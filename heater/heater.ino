#include <WiFi.h>
#include <HTTPClient.h>
#include "credentials.h"

//network credentials - MODIFICATION REQUERED!
const char* ssid = your_ssid;
const char* password = your_password;

//IP address or domain name with URL path - MODIFICATION REQUERED!
const char* serverNameTemp = your_serverNameTemp; //http://your_IP/temperature
const char* serverNameThreshold = your_serverNameThreshold; //http://your_IP/threshold_input

String readTemp; //current temperature
String tempThreshold; //desired temperature
String valve = "closed";
String messageStatus;

unsigned long previousMillis = 0;
const long interval = 10000; //10 sec

//motor direction
int motor1Pin1 = 27; 
int motor1Pin2 = 26; 

void setup() {
  //sets the pins as outputs
  pinMode(motor1Pin1, OUTPUT);
  pinMode(motor1Pin2, OUTPUT);
  
  Serial.begin(115200);
  
  //wifi connection
  WiFi.begin(ssid, password);
  Serial.print("Connecting ...");
  while(WiFi.status() != WL_CONNECTED) {
    delay(100);
    Serial.print(".");
  }
  Serial.println("\nConnected to WiFi network");
}

void loop() {
  unsigned long currentMillis = millis();

  if(currentMillis - previousMillis >= interval) {
    previousMillis = currentMillis;

    if(WiFi.status() == WL_CONNECTED) { 
      readTemp = httpGETRequest(serverNameTemp);
      tempThreshold = httpGETRequest(serverNameThreshold);
      Serial.println("\nTemperature: " + readTemp + " *C - Temperature Threshold: " + tempThreshold + " *C ");
      
      //is just to show the information on the terminal whether the temperature is increasing or decreasing
      Serial.println(messageStatus);
    }
    else {
      Serial.println("WiFi Disconnected");
    }

    //temperature check
    //if the temperature of the room is lower than threshold temperature, the valve is going to open, to warm up
    if(readTemp.toFloat() < (tempThreshold.toFloat() - 0.2) && valve == "closed" && readTemp != "") {//check null value
      messageStatus = String("Temperature below threshold. Warming up ... ");
      Serial.println(messageStatus);

      //opening valve, iron in (to warm up)
      digitalWrite(motor1Pin1, LOW);
      digitalWrite(motor1Pin2, HIGH); 
      Serial.println("Opening valve ...");
      delay(50000); //it stays 50 seconds with valve motor running

      //motor stop, valve opened (but still warming)
      digitalWrite(motor1Pin1, LOW);
      digitalWrite(motor1Pin2, LOW);
      Serial.println("Valve opened");

      valve = "opened";
    }
    //if the temperature of the room is higher than threshold temperature, the valve is going to close, to cool
    else if(readTemp.toFloat() > (tempThreshold.toFloat() + 0.5) && valve == "opened" && readTemp != "") { //check null value
      messageStatus = String("Temperature above threshold. Cooling ... ");
      Serial.println(messageStatus);
      
      //closing valve, iron out (to cool)
      digitalWrite(motor1Pin1, HIGH);
      digitalWrite(motor1Pin2, LOW);
      Serial.println("Closing Valve ..."); 
      delay(50000); //it stays 50 seconds with valve motor running

      //motor stop, valve closed (but still cooling)
      digitalWrite(motor1Pin1, LOW);
      digitalWrite(motor1Pin2, LOW);
      Serial.println("Valve closed");
      
      valve = "closed";
    }
  }
}


String httpGETRequest(const char* serverName) {
  HTTPClient http;

  //IP address or domain name with URL path
  http.begin(serverName);
  
  //HTTP GET request
  int httpCode = http.GET();

  String payload = "";

  if (httpCode > 0) {
    //Serial.print("HTTP Response code: ");
    //Serial.println(httpCode);

    payload = http.getString();
    //Serial.println(payload);
  }
  else {
    Serial.print("Error code: ");
    Serial.println(httpCode);
  }
  http.end(); 

  return payload;
}