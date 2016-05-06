/*
 *  ------Waspmote WIFI_16 Example--------
 *
 *  Explanation: This example shows the way the way to use a static 
 *  IP address
 *
 *  Copyright (C) 2015 Libelium Comunicaciones Distribuidas S.L.
 *  http://www.libelium.com
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 2 of the License, or
 *  (at your option) any later version.
 * WREDWP
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 * 
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 *  Version:                0.3
 *  Design:                 David Gascón
 *  Implementation:         Joaquin Ruiz, Yuri Carmona
 */

// Include WIFI library 
#include <WaspWIFI.h>
#include <WaspSensorSW.h>
// choose socket (SELECT USER'S SOCKET)
///////////////////////////////////////
uint8_t socket=SOCKET0;
/////////////////////////////////////
float value_orp;
float value_calculated;
float value_temperature;

///////////////////////////////////////

// WiFi AP settings (CHANGE TO USER'S AP)
/////////////////////////////////
#define ESSID "REDWP"
#define AUTHKEY "initec123"
#define calibration_offset 0.0
pt1000Class TemperatureSensor;
ORPClass ORPSensor;

/////////////////////////////////

// Define static IP Address to set to WiFi module
/////////////////////////////////
//#define STATIC_IP "172.16.13.50"
//#define NETMASK   "255.255.255.0"
//#define GATEWAY   "172.16.13.254"
// WEB server settings 
/////////////////////////////////
/*char HOST[] = "waposat.com";
char URL[]  = "GET$/index/Template/InsertData3.1.php?";*/
/////////////////////////////////
char HOST[] = "estacion.waposat.com";
char URL[]  = "GET$/Template/InsertData3.php?";
/////////////////////////////////
uint8_t status;
uint8_t counter=0;
char body[100];
// variable
unsigned long previous;


void setup()
{
  SensorSW.ON();
  USB.ON();  
  // Switch ON the WiFi module on the desired socket
  if( WIFI.ON(socket) == 1 )
  {    
    USB.println(F("WiFi switched ON"));
  }
  else
  {
    USB.println(F("WiFi did not initialize correctly"));
  }
  
  // 1. Configure the transport protocol (UDP, TCP, FTP, HTTP...)
 WIFI.setConnectionOptions(HTTP|CLIENT_SERVER);
  
  // 2.1. Configure the way the modules will resolve the IP address.
  /*** DHCP MODES ***
  * DHCP_OFF   (0): Use stored static IP address
  * DHCP_ON    (1): Get IP address and gateway from AP
  * AUTO_IP    (2): Generally used with Ad-hoc networks
  * DHCP_CACHE (3): Uses previous IP address if lease is not expired
  */  
  WIFI.setDHCPoptions(DHCP_ON);
  
  // 2.2. Configure the static IP address
  // Beware of the AP address and network mask you try to connect to
 // WIFI.setIp(STATIC_IP); 
  // 2.3. set Netmask
  //WIFI.setNetmask(NETMASK); 
  // 2.4. set DNS address
  //WIFI.setDNS(MAIN,"8.8.8.8","www.google.com");
  // 2.5. set gateway address
 // WIFI.setGW(GATEWAY);
  
  // 3. set Auth key 
  WIFI.setAuthKey(WPA1,AUTHKEY); 
  
  // 4. Configure how to connect the AP
  WIFI.setJoinMode(MANUAL);
  WIFI.setAuthKey(WPA1,AUTHKEY); 
  // 5. Store Values
  WIFI.storeData();
  
   USB.println(F("Set up done"));
}

void loop()
{
  //////////////////////////////
  // Reading of the ORP sensor
  value_orp = ORPSensor.readORP();
  value_temperature = TemperatureSensor.readTemperature();
  // Apply the calibration offset
  value_calculated = value_orp - calibration_offset;
  char float_str_orp[10];
dtostrf( value_calculated, 1, 3, float_str_orp);

char float_str_temp[10];
dtostrf( value_temperature, 1, 3, float_str_temp);
  ///////////////////////////////
  // switch WiFi ON 
 if( WIFI.ON(socket) == 1 )
  {    
    USB.println(F("WiFi switched ON"));
  }
  else
  {
    USB.println(F("WiFi did not initialize correctly"));
  }
  
  // get actual time
  previous=millis();
  
  // Join AP
  if(WIFI.join(ESSID))
  { RTC.ON();
    RTC.getTime(); 
    // Now you are connected to AP
    USB.print(F("Connected to AP."));
    USB.print(F(" Time(ms):"));    
    USB.println(millis()-previous);
    
    USB.println(F("-----------------------"));    
    USB.println(F("get IP"));
    USB.println(F("-----------------------"));
    WIFI.getIP();
    USB.println();
    USB.print(F(" ORP Estimated: "));
    USB.print(value_calculated);
    USB.println(F(" volts"));  
    USB.print(F("Temperature (celsius degrees): "));
    USB.println(value_temperature);
    USB.println();
   // WIFI.resolve("www.google.com");
     //RTC.ON();
    //RTC.getTime();
    //counter++;
    snprintf( body, sizeof(body), "equipo=20&sensor1=2&sensor2=5&sensor3=6&valor1=%s&valor2=%s&valor3=40", float_str_temp, float_str_orp);
    status = WIFI.getURL(DNS, HOST, URL, body); 
     if( status == 1)
    {
      USB.println(F("\nHTTP query OK."));
      USB.print(F("WIFI.answer:"));
      USB.println(WIFI.answer);
      
      /*
       * At this point, it could be possible
       * to parse the web server information
       */
    }
    else
    {
      USB.println(F("\nHTTP query ERROR"));
      //counter--;
    }
  }
  else
  {    
    USB.print(F("ERROR Connecting to AP."));  
    USB.print(F(" Time(ms):"));    
    USB.println(millis()-previous);  
  }  
  
  // Switch WiFi OFF
 // WIFI.OFF();  
  
  USB.println(F("\n\n******************************************************\n\n"));
  delay(1000);
  // delay 2 seconds
  
  
}
