-- MySQL dump 10.13  Distrib 5.5.46, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: scotchbox
-- ------------------------------------------------------
-- Server version	5.5.46-0ubuntu0.14.04.2

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `Contacts`
--

DROP TABLE IF EXISTS `Contacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Contacts` (
  `contactID` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `vorname` varchar(255) DEFAULT NULL,
  `nachname` varchar(255) DEFAULT NULL,
  `firma` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `telefon` varchar(255) DEFAULT NULL,
  `notizen` text,
  PRIMARY KEY (`contactID`),
  KEY `Contacts_Users_userID_fk` (`userID`),
  CONSTRAINT `Contacts_Users_userID_fk` FOREIGN KEY (`userID`) REFERENCES `Users` (`userID`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Events`
--

DROP TABLE IF EXISTS `Events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `start` datetime NOT NULL,
  `text` text,
  `userID` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Events_Users_userID_fk` (`userID`),
  CONSTRAINT `Events_Users_userID_fk` FOREIGN KEY (`userID`) REFERENCES `Users` (`userID`)
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Notes`
--

DROP TABLE IF EXISTS `Notes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Notes` (
  `noteID` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `descr` text,
  `col` int(11) NOT NULL,
  `row` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  PRIMARY KEY (`noteID`),
  KEY `Notes_Users_userID_fk` (`userID`),
  CONSTRAINT `Notes_Users_userID_fk` FOREIGN KEY (`userID`) REFERENCES `Users` (`userID`)
) ENGINE=InnoDB AUTO_INCREMENT=207 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Tasks`
--

DROP TABLE IF EXISTS `Tasks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Tasks` (
  `taskID` int(11) NOT NULL AUTO_INCREMENT,
  `description` text NOT NULL,
  `userID` int(11) NOT NULL,
  PRIMARY KEY (`taskID`),
  KEY `Tasks_Users_userID_fk` (`userID`),
  CONSTRAINT `Tasks_Users_userID_fk` FOREIGN KEY (`userID`) REFERENCES `Users` (`userID`)
) ENGINE=InnoDB AUTO_INCREMENT=256 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Timers`
--

DROP TABLE IF EXISTS `Timers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Timers` (
  `timerID` int(11) NOT NULL AUTO_INCREMENT,
  `start` datetime NOT NULL,
  `end` datetime DEFAULT NULL,
  `taskID` int(11) NOT NULL,
  `notiz` text,
  PRIMARY KEY (`timerID`),
  KEY `Timers_Tasks_taskID_fk` (`taskID`),
  CONSTRAINT `Timers_Tasks_taskID_fk` FOREIGN KEY (`taskID`) REFERENCES `Tasks` (`taskID`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2234 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Users`
--

DROP TABLE IF EXISTS `Users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Users` (
  `userID` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `vorname` varchar(100) NOT NULL,
  `nachname` varchar(100) NOT NULL,
  `land` char(2) NOT NULL,
  `geschlecht` char(1) NOT NULL,
  `lastLogin` datetime DEFAULT NULL,
  PRIMARY KEY (`userID`),
  UNIQUE KEY `Users_email_uindex` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-02-25 14:03:29

