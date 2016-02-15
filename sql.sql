CREATE TABLE Users
(
  userID INT(11) PRIMARY KEY NOT NULL,
  email VARCHAR(100) NOT NULL,
  password VARCHAR(255) NOT NULL,
  vorname VARCHAR(100) NOT NULL,
  nachname VARCHAR(100) NOT NULL,
  land CHAR(2) NOT NULL,
  geschlecht CHAR(1) NOT NULL,
  lastLogin DATETIME
);
CREATE UNIQUE INDEX Users_email_uindex ON Users (email);
CREATE TABLE Events
(
  id INT(11) PRIMARY KEY NOT NULL,
  title TEXT NOT NULL,
  start DATETIME NOT NULL,
  text TEXT,
  userID INT(11),
  CONSTRAINT Events_Users_userID_fk FOREIGN KEY (userID) REFERENCES Users (userID)
);
CREATE INDEX Events_Users_userID_fk ON Events (userID);
CREATE TABLE Contacts
(
  contactID INT(11) PRIMARY KEY NOT NULL,
  userID INT(11) NOT NULL,
  vorname VARCHAR(255),
  nachname VARCHAR(255),
  firma VARCHAR(255),
  email VARCHAR(255),
  telefon VARCHAR(255),
  notizen TEXT,
  CONSTRAINT Contacts_Users_userID_fk FOREIGN KEY (userID) REFERENCES Users (userID)
);
CREATE INDEX Contacts_Users_userID_fk ON Contacts (userID);
CREATE TABLE Tasks
(
  taskID INT(11) PRIMARY KEY NOT NULL,
  description TEXT NOT NULL,
  userID INT(11) NOT NULL,
  CONSTRAINT Tasks_Users_userID_fk FOREIGN KEY (userID) REFERENCES Users (userID)
);
CREATE INDEX Tasks_Users_userID_fk ON Tasks (userID);
CREATE TABLE Timers
(
  timerID INT(11) PRIMARY KEY NOT NULL,
  start DATETIME NOT NULL,
  end DATETIME,
  taskID INT(11) NOT NULL,
  CONSTRAINT Timers_Tasks_taskID_fk FOREIGN KEY (taskID) REFERENCES Tasks (taskID)
);
CREATE INDEX Timers_Tasks_taskID_fk ON Timers (taskID);