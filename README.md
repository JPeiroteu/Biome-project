# Biome

Biome is an intelligent, sustainable energy system making peoples' lives indoors healthier and more efficient. The objective of this project is to create a smart valve that transforms any old radiator into a smart heater, thus allowing centralized control of any heating system.

<br>

<p align="center">
  <img width="600" src="https://user-images.githubusercontent.com/79811891/165746275-8879fc77-0d6f-41b8-bad2-11538717443b.png">
</p>

### Features

- Secure centralized system
- Intelligent temperature control
- Real-time query of environmental data
- Reliable, low-power and wireless
- Easy implementation
- Multiplataform, easy access to the heating management system*

*It is possible to install multiple radiators in this system if the file "heater.ino" is installed correctly in another esp32

### Built With

- [Arduino](https://www.arduino.cc/)
- [C++](https://www.cplusplus.com/)
- [HTML](https://www.w3.org/html/)

<br>

## Getting Started

### Parts Required

- [2x ESP32 Board](https://www.amazon.de/-/en/ESP-32S-Development-Bluetooth-Microcontroller-ESP-WROOM-32/dp/B07XH45MWW/ref=sr_1_19?crid=G8IZGQUA1J2V&keywords=esp32&qid=1651326820&sprefix=esp32%2Caps%2C95&sr=8-19)
- [2x Breadboard](https://www.amazon.de/-/en/AZDelivery-Breadboard-Kit-Compatible-Book/dp/B078JGQKWP/ref=sr_1_6?crid=26659W6VDD48R&keywords=breadboards&qid=1651318781&sprefix=breadboards%2Caps%2C107&sr=8-6)
- Jumper wires
- [1x Sensor DHT11](https://www.amazon.de/-/en/AZDelivery-temperature-sensor-humidity-including/dp/B078S7FCZ9/ref=sr_1_3?crid=BDBR8ASPORAC&keywords=Sensor+DHT11&qid=1651318891&sprefix=sensor+dht11%2Caps%2C160&sr=8-3)
- [1x DC Motor](https://www.amazon.de/-/en/Eqiva-Radiator-Thermostat-Model-132231K2/dp/B085LW2K1M?th=1)
- [1x H-Bridge motor drivers L298N](https://www.amazon.de/-/en/ARCELI-Controller-Module-Bridge-Arduino/dp/B07MY33PC9/ref=sr_1_4?crid=2IY7KEWOCZMO6&keywords=L298N&qid=1651318926&s=industrial&sprefix=l298n%2Cindustrial%2C71&sr=1-4)
- 1x Battery 9V

### Installation

Install the [Arduino IDE](https://www.arduino.cc/en/software).

Install ESP32 Add-on in Arduino IDE
1. In your Arduino IDE, go to File Preferences
2. Enter https://dl.espressif.com/dl/package_esp32_index.json, http://arduino.esp8266.com/stable/package_esp8266com_index.json into the “Additional Board Manager URLs”. Then, click the “OK” button
3. Open the Boards Manager. Go to Tools  Board  Boards Manager…
4. Search for ESP32 and press install button for the “ESP32 by Espressif Systems“
5. That’s it. It should be installed after a few seconds.

Install libraries.
For this project is necessary to install the following libraries
- WiFi (Arduino Library Manager)
- DHT sensor library (Arduino Library Manager);
- [AsyncTCP](https://github.com/JPeiroteu/Biome-project/tree/main/libraries/AsyncTCP) (.zip folder)
- [ESPAsyncWebServer](https://github.com/JPeiroteu/Biome-project/tree/main/libraries/ESPAsyncWebServer) (.zip folder)
- [HTTPClient](https://github.com/JPeiroteu/Biome-project/tree/main/libraries/HTTPClient) (.zip folder).

You can install the first two libraries using the Arduino Library Manager. Go to Sketch  Include Library  Manage Libraries and search for the libraries’ names.

The AsynTCP, ESPAsyncWebServer and HTTPClient libraries aren’t available to install through the Arduino Library Manager, so you need to copy the library files to the Arduino Installation Libraries folder. Alternatively, download the libraries’ .zip folders, and then, in your Arduino IDE, go to Sketch  Include Library  Add .zip Library and select the libraries you’ve just downloaded. Each of the libraries must be zipped separately.

### Usage

Download this project as zip and extract it.

Plug the ESP32 board to your computer. With your Arduino IDE open, follow these steps
1. After that you need to select your Board in Tools > Board (DOIT ESP32 DEVKIT V1)
2. Select the COM port in Tools > Port (if you don’t see the COM Port in your Arduino IDE, you need to install the [CP210x USB to UART Bridge VCP Drivers](https://www.silabs.com/developers/usb-to-uart-bridge-vcp-drivers))
3. Press the Upload button in the Arduino IDE and wait a few seconds while the code compiles and uploads to your board (you can follow the same steps with the video below)
4. Wait for the “Done uploading” message.

### Video Demo

Click on the image for play the video

<p align="center">
  <a href="https://youtu.be/mobOuVpaaxY" target="_blank">
   <img src="http://img.youtube.com/vi/mobOuVpaaxY/0.jpg" alt="Watch the video" width="720" height="" border="10" />
  </a>
</p>

***Important Information!***<br>
Make sure your router is using the 2.4Ghz frequency band, otherwise the ESP32 will not work.

### Respective Links

Repository Link: https://github.com/JPeiroteu/Biome-project

Webapp Link: https://biome-project.000webhostapp.com/

Webapp Authentication:
- Email: guest.test@code.berlin
- Password: 123

<br>

## Roadmap

See the open issues for a list of proposed features (and known issues).

- [x] Add Database
- [x] Add Online Access to the Valve
- [ ] Add Manual Control of Threshold
- [ ] QR Code Access to Webapp
- [ ] Add Possible Blinds System

<br>

## Security

### Threat Modeling

![Threat_Modeling](https://user-images.githubusercontent.com/79811891/166241108-755fb513-cf13-4611-87ca-163fc3a46a0f.jpg)


### Implemented Security Measures

- Ensured that errors are not visible in the Web Application from the attacker's perspective.  I.e., no feedback of "no user exists", "incorrect password", "password accepted" or anything like that
- Access credentials stored in separate files
- Updated programs, systems, and libraries
- Put in place an authentication form to protect unauthorized use of the application
- Strong passwords have been established
- Password encryption was used
- Ensured that the SQL form only accepts data of specific type/length to prevent injection
- Used Prepared statements in SQL queries
- HTTPS protocol was used
- Encrypted communications with SSL

<br>

## Contact

Jorge Guedes - jorge.guedes@code.berlin


<p align="right">(<a href="#top">back to top</a>)</p>
