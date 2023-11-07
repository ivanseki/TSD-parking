#include <SPI.h>
#include <Ethernet.h>
#include <EthernetUdp.h>
#include <Wire.h>
#include <Adafruit_PN532.h>
#include <FastLED.h>

#define PN532_SCK (2)
#define PN532_MOSI (3)
#define PN532_SS (4)
#define PN532_MISO (5)

#define NUM_LEDS 1
#define DATA_PIN 9

byte mac[] = {0xDE, 0xAD, 0xBE, 0xEF, 0xFE, 0xEE};
IPAddress ip(192, 168, 0, 24);
unsigned int localPort = 23;
char packetBuffer[UDP_TX_PACKET_MAX_SIZE];
String datReq;
int packetSize;
EthernetUDP Udp;

Adafruit_PN532 nfc(PN532_SCK, PN532_MISO, PN532_MOSI, PN532_SS);

int relay = A0;
int brava = 8;
int b = 0;

CRGB leds[NUM_LEDS];

uint8_t success;
uint8_t uid[] = {0, 0, 0, 0};
uint8_t uidLength;

void setup() 
{ 
  FastLED.addLeds<WS2812, DATA_PIN, RGB>(leds, NUM_LEDS);
  pinMode(brava, INPUT_PULLUP);
  pinMode(relay, OUTPUT);
  //pinMode(buzzer, OUTPUT);
  digitalWrite(relay, LOW);
  Serial.begin(115200);
  Ethernet.begin(mac, ip);
  Udp.begin(localPort);
  delay(500);

  nfc.begin();
  
  nfc.SAMConfig();
  
  Serial.println("Waiting for a card ...");

  delay(5000);

  packetSize = Udp.parsePacket();

  if(packetSize > 0)
  { 
    Udp.read(packetBuffer, UDP_TX_PACKET_MAX_SIZE);
    String datReq(packetBuffer);
    Serial.println("Ocitavanje paketa: ");
    Serial.println(datReq);
  }
}

void loop() 
{ 
  leds[0] = CRGB::Green;
  FastLED.show();
  
  while(digitalRead(brava) == 0)
  {    
    if(b == 0)
    {
      leds[0] = CRGB::Blue;
      FastLED.show();
    }
    
    success = nfc.readPassiveTargetID(PN532_MIFARE_ISO14443A, uid, &uidLength);

    if(success)
    {
      Serial.println("");
      Serial.println("Found an ISO14443A card");
      Serial.print("  UID Length: ");
      Serial.print(uidLength, DEC);
      Serial.println(" bytes");
      Serial.print("  UID Value: ");
      nfc.PrintHex(uid, uidLength);
      Serial.println(uid[0]);
      Serial.println(uid[1]);
      Serial.println(uid[2]);
      Serial.println(uid[3]);
      Serial.println("");
      Serial.println("Slanje paketa");
      Udp.beginPacket(Udp.remoteIP(), Udp.remotePort());
      Udp.print(uid[0]);
      Udp.print(uid[1]);
      Udp.print(uid[2]);
      Udp.print(uid[3]);
      Udp.endPacket();
      Serial.println("Zavrsetak slanja paketa");
      
      delay(500);
      
      memset(packetBuffer, 0, UDP_TX_PACKET_MAX_SIZE);
      packetSize = Udp.parsePacket();
      Udp.read(packetBuffer, UDP_TX_PACKET_MAX_SIZE);
      String datReq(packetBuffer);
      Serial.println("Ocitavanje paketa: ");
      Serial.println(datReq);
  
      if(datReq == "zakljucaj")
      {
        b = 1;
        Serial.println("Card accepted!");
        leds[0] = CRGB::Red;
        FastLED.show(); 
        success = 0;  
      } else if(datReq == "otkljucaj")
             {
               leds[0] = CRGB::Green;
               FastLED.show();
               digitalWrite(relay, HIGH);
               delay(200);
               digitalWrite(relay, LOW);
               success = 0;
             } else
               {
                 Serial.println("Card denied");
                 success = 0;
               }
      memset(packetBuffer, 0, UDP_TX_PACKET_MAX_SIZE);
    } 
    
   delay(3000);
  
  }
}
