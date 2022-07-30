#include <WiFi.h>
#include <AsyncTCP.h>
#include <ESPAsyncWebServer.h>
#include <DHT.h>
#include <HTTPClient.h>
#include "credentials.h"

//network credentials - MODIFICATION REQUERED!
const char* ssid = your_ssid;
const char* password = your_password;

#define DHTPIN 4   //temperature and humidity sensor pin
#define DHTTYPE DHT11

DHT dht(DHTPIN, DHTTYPE);

//variables
String readTemp; //current temperature
String readHumid; //current humidity
String tempThreshold; //desired temperature

const char* serverNameThrSelect = "https://biome-project.000webhostapp.com/esp_threshold_select.php";
const char* serverNameDataInsert = "https://biome-project.000webhostapp.com/esp_data_insert.php";

String apiKeyValue = "c5623602F3d2";

//HTML web page
const char index_html[] PROGMEM = R"rawliteral(
<!DOCTYPE HTML>
<html>
<head>
  <title>Temperature Threshold Output Control</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  </head><body>
  <h2>Temperature</h2> 
  <h3 id="temperature">%TEMPERATURE% &deg;C</h3>
  <h2>Humidity</h2> 
  <h3 id="humidity">%HUMIDITY% &percnt;</h3>
  <h2>ESP Arm Trigger</h2>
  <form action="/get">
    Temperature Threshold <input type="number" step="0.1" id="threshold" name="threshold_input" value="%THRESHOLD%" required><br>
    <input type="submit" value="Submit">
  </form>
</body>
<script>
setInterval(function ( ) {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("temperature").innerHTML = this.responseText;
    }
  };
  xhttp.open("GET", "/temperature", true);
  xhttp.send();
}, 30000 ) ;

setInterval(function ( ) {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("humidity").innerHTML = this.responseText;
    }
  };
  xhttp.open("GET", "/humidity", true);
  xhttp.send();
}, 30000 ) ;

setInterval(function ( ) {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("threshold").innerHTML = this.responseText;
    }
  };
  xhttp.open("GET", "/threshold", true);
  xhttp.send();
}, 30000 ) ;
</script>
</html>)rawliteral";

void notFound(AsyncWebServerRequest *request) {
  request->send(404, "text/plain", "Not found");
}

AsyncWebServer server(80);


//HTML placeholders replace
String processor(const String& var){
  if(var == "TEMPERATURE"){
    return readTemp;
  }
  if(var == "HUMIDITY"){
    return readHumid;
  }
  else if(var == "THRESHOLD"){
    return tempThreshold;
  }
  return String();
}

//temperature and threshold
String readTemp1() {
  return String(readTemp);
}
String tempThreshold1() {
  return String(tempThreshold);
}

const char* THRESHOLD_INPUT = "threshold_input";

void setup() {
  Serial.begin(115200);

  //wifi connection
  WiFi.mode(WIFI_STA);
  WiFi.begin(ssid, password);
  Serial.print("\nConnecting ...");
  while (WiFi.status() != WL_CONNECTED) {
    delay(100);
    Serial.print(".");
  }
  Serial.println("\nConnected to WiFi network with IP Address: ");
  Serial.println(WiFi.localIP());

  dht.begin();
  
  //web page 
  server.on("/", HTTP_GET, [](AsyncWebServerRequest *request){
    request->send_P(200, "text/html", index_html, processor);
  });


  //tempeture and threshold requests 
  server.on("/temperature", HTTP_GET, [](AsyncWebServerRequest *request){
    request->send_P(200, "text/plain", readTemp1().c_str());
  });
  server.on("/threshold_input", HTTP_GET, [](AsyncWebServerRequest *request){
    request->send_P(200, "text/plain", tempThreshold1().c_str());
  });

  server.onNotFound(notFound);
  server.begin();
}

void loop() {
  if(WiFi.status()== WL_CONNECTED){
    float t = dht.readTemperature();
    float h = dht.readHumidity();

    //HTTP GET request into the variable 
    server.on("/get", HTTP_GET, [] (AsyncWebServerRequest *request) {
      if (request->hasParam(THRESHOLD_INPUT)) {
        tempThreshold = request->getParam(THRESHOLD_INPUT)->value();

        //insert new data into db
        HTTPClient http;

        http.begin(serverNameDataInsert);

        //specify content type header
        http.addHeader("Content-Type", "application/x-www-form-urlencoded");

        //HTTP POST request data
        String httpRequestData = "api_key=" + apiKeyValue + "&temperature=" + readTemp + "&humidity=" + readHumid + "&threshold=" + tempThreshold;
        int httpResponseCode = http.POST(httpRequestData);

        if (httpResponseCode>0) {
          //Serial.print("HTTP Response code: ");
          //Serial.println(httpResponseCode);
        }
        else {
          Serial.println("Error code: ");
          Serial.print(httpResponseCode);
        }
        http.end();
      }
      Serial.print("\nThreshold local request: ");
      Serial.print(tempThreshold);
      request->send(200, "text/html", "New record has been added successfully !<br><a href=\"/\">Return to Home Page</a>");
    });

    delay(30000);

    //get threshold data from db
    HTTPClient http1;

    //IP address or domain name with URL path
    http1.begin(serverNameThrSelect);

    //HTTP GET request
    int httpCode = http1.GET();

    if (httpCode > 0) {
      //Serial.print("\nHTTP Response code: ");
      //Serial.println(httpCode);

      tempThreshold = http1.getString();
      tempThreshold = tempThreshold.toFloat();
    }
    else {
      Serial.print("\nError code: ");
      Serial.println(httpCode);
    }
    http1.end(); 

    //sensor readings interval time
    delay(30000);

    //insert new data into db
    HTTPClient http;

    http.begin(serverNameDataInsert);

    //specify content type header
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");

    //HTTP POST request data
    String httpRequestData = "api_key=" + apiKeyValue + "&temperature=" + readTemp + "&humidity=" + readHumid + "&threshold=" + tempThreshold;

    //send HTTP POST request
    int httpResponseCode = http.POST(httpRequestData);

    if (httpResponseCode>0) {
      //Serial.print("HTTP Response code: ");
      //Serial.println(httpResponseCode);
    }
    else {
      Serial.println("Error code: ");
      Serial.print(httpResponseCode);
    }
    http.end();


    if (isnan(t) || isnan(h)) {
      Serial.println(F("Sensor failed"));
      return;
    }
    else {  
      Serial.print("\ntemp: ");
      Serial.print(t);
      Serial.print("\nhumid: ");;
      Serial.print(h);
      Serial.print("\nthres: ");
      Serial.print(tempThreshold);
    }

    readTemp = String(t);
    readHumid = String(h);
    tempThreshold = String(tempThreshold);
  }
  else {
    Serial.println("WiFi Disconnected");
  }
}

