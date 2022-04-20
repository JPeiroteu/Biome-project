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

const char* serverName = "https://biome-project.000webhostapp.com/threshold_select.php";

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
    Temperature Threshold <input type="number" step="0.1" name="threshold_input" value="%THRESHOLD%" required><br>
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
}, 10000 ) ;

setInterval(function ( ) {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("humidity").innerHTML = this.responseText;
    }
  };
  xhttp.open("GET", "/humidity", true);
  xhttp.send();
}, 10000 ) ;
</script>
</html>)rawliteral";

void notFound(AsyncWebServerRequest *request) {
  request->send(404, "text/plain", "Not found");
}

AsyncWebServer server(80);



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

//HTML placeholders replace
String processor(const String& var){
  Serial.println(var); //optional
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

//temperature and threshold function
String readTemp() {
  return String(readTemp);
}
String tempThreshold() {
  return String(tempThreshold);
}

const char* THRESHOLD_INPUT = "threshold_input";

void setup() {
  Serial.begin(115200);

  //wifi connection
  WiFi.mode(WIFI_STA);
  WiFi.begin(ssid, password);
  Serial.print("Connecting ...");
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

  //receive HTTP GET requests 
  server.on("/get", HTTP_GET, [] (AsyncWebServerRequest *request) {
    if (request->hasParam(THRESHOLD_INPUT)) {
      tempThreshold = request->getParam(THRESHOLD_INPUT)->value();
    }
    Serial.println(tempThreshold);
    request->send(200, "text/html", "HTTP GET request sent to your ESP.<br><a href=\"/\">Return to Home Page</a>");
  });
  
  //tempeture and threshold requests 
  server.on("/temperature", HTTP_GET, [](AsyncWebServerRequest *request){
    request->send_P(200, "text/plain", readTemp().c_str());
  });
  server.on("/threshold_input", HTTP_GET, [](AsyncWebServerRequest *request){
    request->send_P(200, "text/plain", tempThreshold().c_str());
  });

  server.onNotFound(notFound);
  server.begin();
}

void loop() {
  //sensor readings interval time
  delay(5000);
  
  String tT = httpGETRequest(serverName);
  float t = dht.readTemperature();
  float h = dht.readHumidity();

  if (isnan(t) || isnan(h)) {
    Serial.println(F("Sensor failed"));
    return;
  }
  else {  
    Serial.println(t);
    Serial.println(h);
    Serial.println(tT);
  }

  readTemp = String(t);
  readHumid = String(h);
  tempThreshold = String(tT);
}