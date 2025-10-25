#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <WiFiClient.h>
#include <Wire.h>
#include <LiquidCrystal_I2C.h>

// Network credentials
const char* ssid = "LAB1.APL";
const char* password = "aplskaneka";
const char* host = "https://level-air.smknkabuh.sch.id/";

const float tinggiTandon = 16.0;

// Pin definitions
#define TRIGGER_PIN D8
#define ECHO_PIN D7
#define BUZZER_PIN D3
#define RELAY_PIN D0
#define PIN_LED D6
#define PIN_LED2 D5

// LCD setup
LiquidCrystal_I2C lcd(0x27, 16, 2);

// Variabel optimasi
WiFiClient client;
HTTPClient http;
unsigned long lastDataSendTime = 0;
const unsigned long dataSendInterval = 500;

float readDistance() {
  digitalWrite(TRIGGER_PIN, LOW);
  delayMicroseconds(2);
  digitalWrite(TRIGGER_PIN, HIGH);
  delayMicroseconds(10);
  digitalWrite(TRIGGER_PIN, LOW);
  long duration = pulseIn(ECHO_PIN, HIGH);
  return duration * 0.034 / 2;
}

void setup() {
  Serial.begin(115200);
  Serial.println("\nSystem Initializing...");
  
  pinMode(TRIGGER_PIN, OUTPUT);
  pinMode(ECHO_PIN, INPUT);
  pinMode(BUZZER_PIN, OUTPUT);
  pinMode(RELAY_PIN, OUTPUT);
  pinMode(PIN_LED, OUTPUT);
  pinMode(PIN_LED2, OUTPUT);
  
  lcd.begin();
  lcd.backlight();
  lcd.setCursor(0, 0);
  lcd.print("Water Tank");

  // Connect to WiFi
  Serial.print("Connecting to WiFi");
  WiFi.hostname("NodeMCU");
  WiFi.begin(ssid, password);
  WiFi.setAutoReconnect(true);
  WiFi.persistent(true);

  while (WiFi.status() != WL_CONNECTED) {
    delay(100);
    Serial.print(".");
    lcd.setCursor(0, 1);
    lcd.print("Connecting...");
  }
  
  Serial.println("\nWiFi Connected!");
  Serial.print("IP Address: ");
  Serial.println(WiFi.localIP());
  lcd.setCursor(0, 1);
  lcd.print("WiFi Connected ");
}

void loop() {
  float distance = readDistance();
  float waterHeight = calculateWaterHeight(distance);
  
  if (WiFi.status() == WL_CONNECTED) {
    // Get mode
    String LinkMode = "http://" + String(host) + "/ci4/public/bacamode.php";
    http.begin(client, LinkMode);
    http.GET();
    String mode = http.getString();
    http.end();

    // Get relay status
    String LinkRelay = "http://" + String(host) + "/ci4/public/bacamanual.php";
    http.begin(client, LinkRelay);
    http.GET();
    String statusrelay = http.getString();
    http.end();

    // Serial output
    Serial.print("Mode: ");
    Serial.print(mode);
    Serial.print(" | Relay Status: ");
    Serial.print(statusrelay);
    Serial.print(" | Distance: ");
    Serial.print(distance);
    Serial.println(" cm");

    // Control logic
    if (mode == "Manual") {
      if (statusrelay == "0") {
        digitalWrite(RELAY_PIN, LOW);
        digitalWrite(PIN_LED2, LOW);
        digitalWrite(PIN_LED, HIGH);
        lcd.setCursor(0, 0); lcd.print("Mode: Manual ON ");
        Serial.println("ACTION: Manual Mode - PUMP ON");
      } else {
        digitalWrite(RELAY_PIN, HIGH);
        digitalWrite(PIN_LED2, HIGH);
        digitalWrite(PIN_LED, LOW);
        lcd.setCursor(0, 0); lcd.print("Mode: Manual OFF ");
        Serial.println("ACTION: Manual Mode - PUMP OFF");
      }
    } 
    else if (mode == "Auto") {
      lcd.setCursor(0, 0); lcd.print("Mode: Auto ON    ");
      
      if (waterHeight <= 3 ) {
        digitalWrite(RELAY_PIN, LOW);
        digitalWrite(PIN_LED2, LOW);
        digitalWrite(PIN_LED, HIGH);
        Serial.println("ACTION: Auto Mode - HIGH WATER LEVEL - PUMP ON + BUZZER");
        
        // Buzzer sequence
        tone(BUZZER_PIN, 1000);
        delay(500);
        noTone(BUZZER_PIN);
        delay(100);
        tone(BUZZER_PIN, 0);
        delay(500);
        noTone(BUZZER_PIN);
        delay(100);
        tone(BUZZER_PIN, 1000);
        delay(500);
        noTone(BUZZER_PIN);
        delay(1000);
      } 
      else if (waterHeight >= 14) {
        digitalWrite(RELAY_PIN, HIGH);
        digitalWrite(PIN_LED2, HIGH);
        digitalWrite(PIN_LED, LOW);
        Serial.println("ACTION: Auto Mode - LOW WATER LEVEL - PUMP OFF");
      }
      else {
        Serial.println("ACTION: Auto Mode - NORMAL WATER LEVEL - NO CHANGE");
      }
    }

    // Data sending
    if (millis() - lastDataSendTime >= dataSendInterval) {
      lastDataSendTime = millis();
      
      String Link = "http://" + String(host) + "/ci4/public/oleh-data/" + String(distance, 1);
      http.begin(client, Link);
      http.addHeader("Connection", "close");
      int httpCode = http.GET();
      http.end();
      
      Serial.print("DATA SENT: ");
      Serial.print(distance, 1);
      Serial.print(" cm | Ketinggian Air: ");
      Serial.print(waterHeight);
      Serial.println(" cm");
    }
  }

  // LCD display
  lcd.setCursor(0, 1);
  lcd.print("Level: ");
  lcd.print(waterHeight, 1);
  lcd.print(" cm    ");

  delay(100);
}

float calculateWaterHeight(float distance) {
  float waterHeight = tinggiTandon - distance;
  if(waterHeight <0) waterHeight = 0;
  if(waterHeight > tinggiTandon) waterHeight = tinggiTandon;
  return waterHeight;
}