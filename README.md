# Biome

Biome is an intelligent, sustainable energy system making peoples' lives indoors healthier and more efficient. The objective of this project is to create a smart valve that transforms any old radiator into a smart heater, centralizing the heat system of the building.

<p align="center">
  <img width="600" src="https://user-images.githubusercontent.com/79811891/150334956-79ee3122-3218-4357-82e7-a4f1c6bb3f09.png">
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

## Getting Started

### Parts Required

- 2 ESP32 Board
- 2 Breadboard
- Jumper wires
- 1 Sensor DHT11
- [1 DC Motor](https://www.amazon.de/-/en/Eqiva-Radiator-Thermostat-Model-132231K2/dp/B085LW2K1M?th=1)
- 1 H-Bridge motor drivers L298N
- 1 Battery 9V

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
  <a href="http://www.youtube.com/watch?feature=player_embedded&v=r1hkMHx0Ycg" target="_blank">
   <img src="http://img.youtube.com/vi/r1hkMHx0Ycg/mqdefault.jpg" alt="Watch the video" width="720" height="" border="10" />
  </a>
</p>



## Roadmap

See the open issues for a list of proposed features (and known issues).

- [V] Add Data Base
- [V] Add Online Access to the Valve
- [ ] Add Manual Control of Threshold
- [ ] QR Code Access to Webapp
- [ ] Add Possible Blinds System




## Contact

Jorge Guedes - jorge.guedes@code.berlin

Project Link: [https://github.com/JPeiroteu/Biome-project](https://github.com/JPeiroteu/Biome-project)

<p align="right">(<a href="#top">back to top</a>)</p>
