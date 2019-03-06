
#include <ESP8266WiFi.h>

#include <SPI.h>
#include <Adafruit_GFX.h>
#include <Adafruit_PCD8544.h>

#include <Adafruit_Fingerprint.h>

// Pins
const int8_t RST_PIN = D2;
const int8_t CE_PIN = D1;
const int8_t DC_PIN = D6;
const int8_t BL_PIN = D0;


//Buttons
const int8_t ENTER_PIN = D3;
const int8_t NEXT_PIN = D4;


//
const int8_t MAXSTD = 50;


Adafruit_PCD8544 display = Adafruit_PCD8544(DC_PIN, CE_PIN, RST_PIN);

uint8_t getFingerprintEnroll();
int getFingerprintIDez();

Adafruit_Fingerprint finger = Adafruit_Fingerprint(&Serial);


const char* ssidAP = "My_ESP_AP";
const char* passwordAP = "123456781";

// Create an instance of the server
// specify the port to listen on as an argument
WiFiServer server(801);

void setup() {

  Serial1.begin(9600);
  delay(10);

  
//  delay(10);


  // Turn Button
  pinMode(ENTER_PIN, INPUT_PULLUP);
  pinMode(NEXT_PIN, INPUT_PULLUP);

  pinMode(D8, OUTPUT);
  digitalWrite(D8, HIGH);
  // Turn LCD backlight on
  pinMode(BL_PIN, OUTPUT);
  digitalWrite(BL_PIN, HIGH);

  display.clearDisplay();
  display.begin();
  delay(500);
  display.setTextSize(1);
  display.setTextColor(BLACK);
  display.setCursor(0, 0);
  // init done

  // you can change the contrast around to adapt the display
  // for the best viewing!
  display.setContrast(60);


  // set the data rate for the sensor serial port
  finger.begin(57600);
  delay(100);
  
  
  if (finger.verifyPassword()) {
    display.println("Found  FingerPrint Sensor!");
    display.display();
  }
  else {
    display.println("Did not find Fingerprint  Sensor :(");
    display.display();
    digitalWrite(D8, HIGH);
    while (1);
  }



  delay(100);

  // Connect to WiFi network

  display.clearDisplay();
  display.println("  Configuring");
  display.println(" access point");
  display.println("    -----");
  WiFi.mode(WIFI_AP);
  WiFi.softAP(ssidAP, passwordAP);
  IPAddress myIP = WiFi.softAPIP();
  display.print("AP IP Address ");
  display.println(myIP);
  server.begin();
  display.println(" Server Ready");
  display.display();

  delay(1000);
  
  digitalWrite(D8, LOW);
}


int id;
String msg;

bool ATD[50];

byte tNames = 1;
byte MODE = 0;
const uint8_t nDelay = 100;

uint8_t next_pin = 0;
byte SN[50];

void loop() {

  display.clearDisplay();
  do {

    if (MODE == 0) {

      display.clearDisplay();
      display.setTextColor(WHITE, BLACK); // 'inverted' text
      display.println(" Select Mode ");
      display.println("");
      display.setTextColor(BLACK, WHITE);
      display.println("=> Attendance");
      display.println("   Enrollment");
      display.println("   UploadATDs");
      display.println("   DeleteATDs");
      display.display();



    }
    else if (MODE == 1) {

      display.clearDisplay();
      display.setTextColor(WHITE, BLACK); // 'inverted' text
      display.println(" Select Mode ");
      display.println("");
      display.setTextColor(BLACK, WHITE);
      display.println("   Attendance");
      display.println("=> Enrollment");
      display.println("   UploadATDs");
      display.println("   DeleteATDs");
      display.display();
    } else if (MODE == 2) {

      display.clearDisplay();
      display.setTextColor(WHITE, BLACK); // 'inverted' text
      display.println(" Select Mode ");
      display.println("");
      display.setTextColor(BLACK, WHITE);
      display.println("   Attendance");
      display.println("   Enrollment");
      display.println("=> UploadATDs");
      display.println("   DeleteATDs");
      display.display();
    } else if (MODE == 3) {

      display.clearDisplay();
      display.setTextColor(WHITE, BLACK); // 'inverted' text
      display.println(" Select Mode ");
      display.println("");
      display.setTextColor(BLACK, WHITE);
      display.println("   Attendance");
      display.println("   Enrollment");
      display.println("   UploadATDs");
      display.println("=> DeleteATDs");
      display.display();
    }


    delay(500);
    uint8_t enter_pin = 0;

    while (enter_pin = digitalRead(ENTER_PIN)) {
      digitalWrite(D8, LOW);
      if (!digitalRead(NEXT_PIN)) {
        MODE++;
        //        delay(500);
        if (MODE >= 4) MODE = 0;
        digitalWrite(D8, HIGH);
        break;
      }
      delay(nDelay);
    }

    if (!enter_pin) {
      //    if (!digitalRead(ENTER_PIN)) {
      //      delay(500);
      break;
    }

  } while (1);

  if (MODE == 0) {

    display.clearDisplay();////////////////////
    display.println("  ATTENDANCE ");
    display.display();

    delay(2000);

    while (digitalRead(ENTER_PIN)) {

      digitalWrite(D8, LOW);
      //    while (1) {

      id = -1;
      int trial = 0;

      while (id < 0) {
        if (trial < 20) {

          display.clearDisplay();////////////////////
          display.println("  ATTENDANCE ");
          display.display();
          //    display.clearDisplay();
          display.fillRect(0, 20, display.width(), 25, BLACK);
          display.display();
          delay(100);

          if (!digitalRead(ENTER_PIN)) return;

          testfillroundrect();
          display.setCursor(0, 30);
          display.println(" place Finger");
          display.display();
          //        delay(100);

          id = getFingerprintIDez();

          trial++;

          delay(100);

          if (!digitalRead(ENTER_PIN)) return;

        } else {
          break;
        }
      }
      if (id > -1)
      {
        digitalWrite(D8, HIGH);

        //      --id;
        ATD[id] = 1;
        //      ++id;
        display.clearDisplay();
        display.println();
        display.print(" ID: ");
        id = id + 100000;
        display.println(id);
        display.println("  *PRESENT*");
        display.display();
        delay(500);

        while (digitalRead(NEXT_PIN)) delay(150);
        digitalWrite(D8, LOW);

      } else {
        digitalWrite(D8, HIGH);
        display.clearDisplay();
        display.println();
        display.println("  NOT FOUND");
        display.println(" TRY AGAIN ?");
        display.display();

        while (digitalRead(NEXT_PIN)) {
          if (!digitalRead(ENTER_PIN)) {
            digitalWrite(D8, LOW);
            return;
          }
          delay(150);
        }

        digitalWrite(D8, LOW);
        //        break;
      }
    }
  }


  if (MODE == 0) {
    return;
  }


  WiFiClient client;
  while (1) {
    // Check if a client has connected
    client = server.available();
    if (!client) {
      display.clearDisplay();
      display.println();
      display.println("  Connecting ");
      //      display.println();
      display.println("to the Server");
      display.println();
      display.println("  *********  ");
      display.display();

      if (!digitalRead(NEXT_PIN)) return;
      //      if (!digitalRead(ENTER_PIN)) return;

      display.clearDisplay();
      delay(150);
      //    return;
    }
    else {
      break;
    }
  }

  // Wait until the client sends some data
  display.println("new client");


  while (!client.available()) {
    delay(1);
  }

  String req = client.readStringUntil('=');
  display.println(req);
  display.display();


  //    Confirm the request


  if (req.indexOf("ENROLLFPS") != -1 && MODE == 1) {
    //      Serial.println(client.localIP());
    //    display.clearDisplay();
    display.println("ENROLLMENT");
    display.display();

    String NAMES[50];
    int i;

    display.clearDisplay();////////////////////
    id = 0;
    for (i = 0; client.available(); i++) {

      //    while (client.available()) {
      //100,051
      SN[id] = byte((client.readStringUntil(',').toInt() - 100000));
      id++;
      //      i++;
      //      client.readStringUntil(',');
      NAMES[i] = client.readStringUntil(',');
      i++;
      NAMES[i] += client.readStringUntil('&');

      if (client.peek() == '\\') break;
    }

    digitalWrite(D8, HIGH);

    display.clearDisplay();////////////////////
    display.setTextColor(WHITE, BLACK); // 'inverted' text
    display.println("");
    display.println("");
    display.println("   All Data ");
    display.println("  Downloaded");

    display.display();
    delay(1500);

    digitalWrite(D8, LOW);

    display.clearDisplay();////////////////////
    display.setTextColor(BLACK, WHITE); //

    id = 0;
    tNames = (i / 2);
    int j = 0;
    while (j <= tNames) {

      display.clearDisplay();////////////////////

      i = j * 2;

      id = SN[j];

      display.print(SN[j]);
      display.print(". ");

      ++j;

      display.print(NAMES[i]);
      display.print(" ");

      i++;
      display.println(NAMES[i]);
      display.display();

      while (digitalRead(ENTER_PIN)) delay(nDelay);

      testfillroundrect();
      display.setCursor(0, 30);
      display.println(" place Finger");
      display.display();



      next_pin = 0;
      while ((next_pin = getFingerprintEnroll()) < 0) {

        if (next_pin == -10) break;
        
      }
      delay(1500);
    }

    String s = "HTTP/1.1 200 OK\r\nContent-Type: text/html\r\n\r\n<!DOCTYPE HTML>\r\n<html><a href=\"http://localhost/WEbfiles/showallinfo.php\"><center>Enrollment Completed!!!!!!!!!!!</center></a>\r\n";
    s += "</html>\n";

    // Send the response to the client
    client.print(s);
    delay(10);
    client.flush();
    client.stop();
    return;
  }
  else if (req.indexOf("GETATDFPS") != -1 && MODE == 2) {

    String CourseCode = client.readStringUntil(' ');

    display.clearDisplay();////////////////////

    digitalWrite(D8, HIGH);
    display.setTextColor(WHITE, BLACK); // 'inverted' text
    display.println("");
    display.println("");
    display.println("  UPLOADING");
    display.println(" ATTENDANCE");

    display.display();
    delay(1500);
    digitalWrite(D8, LOW);

    //    display.clearDisplay();////////////////////
    display.setTextColor(BLACK, WHITE); //


    //    while (1) {



    // send a standard http response header
    client.println("HTTP/1.1 200 OK");
    client.println("Content-Type: text/html");
    client.println("Connection: close");  // the connection will be closed after completion of the response
    //    client.println("Refresh: 10");  // refresh the page automatically every 5 sec
    client.println();
    client.println("<!DOCTYPE HTML>");
    client.println("<html>");
    // output the value of each analog input pin
    //    for (int id = 1; id < tNames; id++) {
    //      //            id = 1;
    //      client.print("Student ");
    //      client.print(id);
    //      client.print(" is ");
    //      --id;
    //      String atd = ATD[id] ? "PRESENT" : "ABSENT";
    //      ++id;
    //      client.print(atd);
    //      client.println("<br />");
    //    }

    //      http://localhost/ENROLLFPS/?=

    //    client.println("<div class=\"input-group\">")
    //
    //    client.println("</div>");
    client.println("<head>");
    client.println("<script>");
    client.println("function load(){");
    client.print("window.location.href = \"http://localhost/WEbfiles/attendancerequest.php?CourseCode=-99&CC=");
    client.print(CourseCode);
    client.print("&ATD=");

    //    http://cpefutmxcarcheck.000webhostapp.com/getDriverInfo.php?PAGE=1&CHECK_MODE=3&ID=ABJ12345AA6


    client.print(ATD[1]);
    for (int id = 2; id < MAXSTD; id++) {

      client.print(",");
      client.print(ATD[id]);

    }


    client.println("\";");
    client.println("}");
    client.println("</script>");
    client.println("</head>");

    client.println("<body onload=\"load()\">");
    client.println("</body>");
    client.println("</html>");

    // Send the response to the client
    //    client.print(s);
    delay(10);
    client.flush();
    client.stop();
  }
  else if (req.indexOf("DELETEFPS") != -1 && MODE == 3) {

    display.clearDisplay();////////////////////

    id = client.readStringUntil(' ').toInt();

    if (id == 9999) {

      finger.emptyDatabase();

      String s = "HTTP/1.1 200 OK\r\nContent-Type: text/html\r\n\r\n<!DOCTYPE HTML>\r\n<html><a href=\"http://localhost/WEbfiles/showallinfo.php\"><center>Database Formatting Completed!!!!!!!!!!!</center></a>\r\n";
      s += "</html>\n";

      // Send the response to the client
      client.print(s);
      delay(10);
      client.flush();
      client.stop();

      digitalWrite(D8, HIGH);
      display.println("   DATABASE");
      display.println("  FORMATTED");
      display.display();
      delay(3000);
      digitalWrite(D8, LOW);
      return;

    }
    else {
      id = id - 100000;
    }


    //    display.println("  DELETTING");

    //    while (!Serial1.available()) delay(50);
    //    req = Serial1.readStringUntil('\\');
    //
    //    id = req.toInt();

    if (id > -1) {

      while (!deleteFingerprint(id)) delay(50);

      String s = "HTTP/1.1 200 OK\r\nContent-Type: text/html\r\n\r\n<!DOCTYPE HTML>\r\n<html><a href=\"http://localhost/WEbfiles/showallinfo.php\"><center>Deleted!!!!!!!!!!!</center></a>\r\n";
      s += "</html>\n";

      // Send the response to the client
      client.print(s);
      delay(10);
      client.flush();
      client.stop();

      display.clearDisplay();
      display.println();
      display.print(" ID: ");
      id = id + 100000;
      display.println(id);
      display.println("   *DELETED*");
      display.display();
      digitalWrite(D8, HIGH);
      delay(3000);
      digitalWrite(D8, LOW);
      return;
    }

    //    if (id == -111) {
    //      finger.emptyDatabase();
    //    }
  }
  else {
    //    Serial1.println("invalid request");
    client.stop();
    return;
  }

  client.flush();


  // Prepare the response
  //  String s = "HTTP/1.1 200 OK\r\nContent-Type: text/html\r\n\r\n<!DOCTYPE HTML>\r\n<html>Hello, today is <script><?php echo date('l, F jS, Y'); ?></script>.\r\nGPIO is now ";

  client.stop();
  //  Serial1.println("Client disonnected");

  // The client will actually be disconnected
  // when the function returns and 'client' object is detroyed
}


uint8_t getFingerprintEnroll() {

  int p = -1;
  while (p != FINGERPRINT_OK) {
    p = finger.getImage();
    switch (p) {
      case FINGERPRINT_OK:
        //      Serial1.println("ImageTaken");
        break;
      default:
        //      Serial1.println("ERROR");
        break;
    }

    //    display.clearDisplay();
    display.fillRect(0, 20, display.width(), 25, BLACK);
    display.display();
    delay(100);

    if (!digitalRead(NEXT_PIN)) return -10;

    testfillroundrect();
    display.setCursor(0, 30);
    display.println(" place Finger");
    display.display();
    delay(100);
  }

  // OK success!

  p = finger.image2Tz(1);
  switch (p) {
    case FINGERPRINT_OK:
      //      Serial1.println("ImageConverted");
      break;
    default:
      //      Serial1.println("ERROR");
      //    display.clearDisplay();
      display.clearDisplay();
      display.setCursor(0, 25);
      display.println(" ERROR ");
      display.display();
      delay(500);
      return p;
  }

  //  Serial1.println("RemoveFinger");
  display.clearDisplay();
  display.setCursor(0, 25);
  display.println(" RemoveFinger");
  display.display();
  digitalWrite(D8, HIGH);
  //  delay(2000);


  p = 0;
  while (p != FINGERPRINT_NOFINGER) {
    p = finger.getImage();
    display.clearDisplay();
    display.display();
  }
  digitalWrite(D8, LOW);
  //  Serial1.print("ID "); Serial1.println(id);
  p = -1;

  //  Serial1.println("PlaceAgain");

  while (p != FINGERPRINT_OK) {
    p = finger.getImage();
    switch (p) {
      case FINGERPRINT_OK:
        //      Serial1.println("ImageTaken");
        break;
      default:
        //      Serial1.println("ERROR");
        break;
    }

    display.fillRect(0, 20, display.width(), 25, BLACK);
    display.display();
    delay(100);
    testfillroundrect();
    display.setCursor(0, 25);
    display.println(" place Finger");
    display.setCursor(22, 37);
    display.println(" Again ");
    display.display();
    delay(100);

  }

  // OK success!

  p = finger.image2Tz(2);
  switch (p) {
    case FINGERPRINT_OK:
      //      Serial1.println("ImageConverted");
      break;
    default:
      //      Serial1.println("ERROR");///////////////////////
      return p;
  }

  // OK converted!
  //  Serial1.print("Creating model for #");  Serial1.println(id);

  p = finger.createModel();
  if (p == FINGERPRINT_OK) {
    //    Serial1.println("PrintsMatched!");
  } else {
    //    Serial1.println("ERROR");///////////////////////////
    return p;
  }

  p = finger.storeModel(id);

  if (p == FINGERPRINT_OK) {
    //    Serial1.println("DONE");////////////////////////////

    display.clearDisplay();
    display.setCursor(0, 25);
    display.println("     DONE");
    display.display();
    digitalWrite(D8, HIGH);
    delay(500);
    
    while (digitalRead(ENTER_PIN)) delay(nDelay);
    digitalWrite(D8, LOW);
    //    delay(50);
  }
  else {
    //    Serial1.println("ERROR");////////////////////////////
    return p;
  }
}



//verification
// returns -1 if failed, otherwise returns ID #
int getFingerprintIDez() {
  uint8_t p = finger.getImage();
  if (p != FINGERPRINT_OK) {
    //    Serial1.println("ERROR");
    return -1;
  }

  p = finger.image2Tz();
  if (p != FINGERPRINT_OK) {
    //    Serial1.println("ERROR");
    return -1;
  }

  p = finger.fingerFastSearch();
  if (p != FINGERPRINT_OK) {
    //    Serial1.println("NOT_FOUND");
    return -1;
  }

  // found a match!
  //  Serial1.print("Found ID #"); Serial1.print(finger.fingerID);
  //  Serial1.print(" with confidence of "); Serial1.println(finger.confidence);

  return finger.fingerID;
}


uint8_t deleteFingerprint(uint8_t id) {

  uint8_t p = -1;

  p = finger.deleteModel(id);

  if (p == FINGERPRINT_OK) {
    //    Serial1.println("Deleted!");
  }
  else {
    //    Serial1.print("ERROR");
    return p;
  }
}



void testfillroundrect(void) {
  uint8_t color = BLACK;
  for (int16_t i = 0; i < display.height() / 4 - 2; i += 2) {
    display.fillRoundRect(i + 20, i + 20, display.width() / 2 - 2 * i, display.height() / 2 - 2 * i, display.height() / 8, color);
    if (color == WHITE) color = BLACK;
    else color = WHITE;
    display.display();
  }
}
