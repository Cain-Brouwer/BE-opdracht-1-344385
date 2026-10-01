-- =============================================================================
--  BE-opdracht 01 – Jamin
--  Database-export: Jamin
--  Studentnummer: 344385
--  Datum: 01-10-2026
--
--  Database: laravel (MariaDB / MySQL, charset utf8mb4)
--  Bevat de zes specificatietabellen uit de opdracht met de voorbeelddata:
--  Product, Allergeen, Leverancier, Magazijn, ProductPerAllergeen,
--  ProductPerLeverancier. Daarnaast de Laravel-tabellen voor gebruikers,
--  rollen, rechten, sessies, cache en queues.
--
--  Importeren met MySQL Workbench: open dit bestand in een SQL-tabblad en
--  voer het uit. Het script maakt de database `laravel` aan als die nog niet
--  bestaat.
--
--  De database is ook op te bouwen vanuit de applicatie met:
--      php artisan migrate --seed
-- =============================================================================

/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19-11.8.6-MariaDB, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: laravel
-- ------------------------------------------------------
-- Server version	11.8.6-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*M!100616 SET @OLD_NOTE_VERBOSITY=@@NOTE_VERBOSITY, NOTE_VERBOSITY=0 */;

--
-- Current Database: `laravel`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `laravel` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;

USE `laravel`;

--
-- Table structure for table `Allergeen`
--

DROP TABLE IF EXISTS `Allergeen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `Allergeen` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Naam` varchar(100) NOT NULL,
  `Omschrijving` varchar(250) NOT NULL,
  `IsActief` bit(1) NOT NULL DEFAULT b'1',
  `Opmerking` varchar(250) DEFAULT NULL,
  `DatumAangemaakt` datetime(6) NOT NULL,
  `DatumGewijzigd` datetime(6) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Allergeen`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `Allergeen` WRITE;
/*!40000 ALTER TABLE `Allergeen` DISABLE KEYS */;
INSERT INTO `Allergeen` VALUES
(1,'Gluten','Dit product bevat gluten',0x01,NULL,'2026-10-01 15:02:13.760891','2026-10-01 15:02:13.760898'),
(2,'Gelatine','Dit product bevat gelatine',0x01,NULL,'2026-10-01 15:02:13.760980','2026-10-01 15:02:13.760980'),
(3,'AZO-Kleurstof','Dit product bevat AZO-kleurstoffen',0x01,NULL,'2026-10-01 15:02:13.760992','2026-10-01 15:02:13.760992'),
(4,'Lactose','Dit product bevat lactose',0x01,NULL,'2026-10-01 15:02:13.760995','2026-10-01 15:02:13.760996'),
(5,'Soja','Dit product bevat soja',0x01,NULL,'2026-10-01 15:02:13.760998','2026-10-01 15:02:13.760999');
/*!40000 ALTER TABLE `Allergeen` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `Leverancier`
--

DROP TABLE IF EXISTS `Leverancier`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `Leverancier` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Naam` varchar(100) NOT NULL,
  `ContactPersoon` varchar(100) NOT NULL,
  `LeverancierNummer` varchar(20) NOT NULL,
  `Mobiel` varchar(12) NOT NULL,
  `IsActief` bit(1) NOT NULL DEFAULT b'1',
  `Opmerking` varchar(250) DEFAULT NULL,
  `DatumAangemaakt` datetime(6) NOT NULL,
  `DatumGewijzigd` datetime(6) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Leverancier`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `Leverancier` WRITE;
/*!40000 ALTER TABLE `Leverancier` DISABLE KEYS */;
INSERT INTO `Leverancier` VALUES
(1,'Venco','Bert van Linge','L1029384719','06-28493827',0x01,NULL,'2026-10-01 15:02:13.802055','2026-10-01 15:02:13.802063'),
(2,'Astra Sweets','Jasper del Monte','L1029284315','06-39398734',0x01,NULL,'2026-10-01 15:02:13.802166','2026-10-01 15:02:13.802166'),
(3,'Haribo','Sven Stalman','L1029324748','06-24383291',0x01,NULL,'2026-10-01 15:02:13.802201','2026-10-01 15:02:13.802202'),
(4,'Basset','Joyce Stelterberg','L1023845773','06-48293823',0x01,NULL,'2026-10-01 15:02:13.802206','2026-10-01 15:02:13.802206'),
(5,'De Bron','Remco Veenstra','L1023857736','06-34291234',0x01,NULL,'2026-10-01 15:02:13.802210','2026-10-01 15:02:13.802210');
/*!40000 ALTER TABLE `Leverancier` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `Magazijn`
--

DROP TABLE IF EXISTS `Magazijn`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `Magazijn` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ProductId` int(10) unsigned NOT NULL,
  `Verpakkingseenheid` decimal(5,2) NOT NULL,
  `AantalAanwezig` int(11) DEFAULT NULL,
  `IsActief` bit(1) NOT NULL DEFAULT b'1',
  `Opmerking` varchar(250) DEFAULT NULL,
  `DatumAangemaakt` datetime(6) NOT NULL,
  `DatumGewijzigd` datetime(6) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `FK_Magazijn_ProductId_Product_Id` (`ProductId`),
  CONSTRAINT `FK_Magazijn_ProductId_Product_Id` FOREIGN KEY (`ProductId`) REFERENCES `Product` (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Magazijn`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `Magazijn` WRITE;
/*!40000 ALTER TABLE `Magazijn` DISABLE KEYS */;
INSERT INTO `Magazijn` VALUES
(1,1,5.00,453,0x01,NULL,'2026-10-01 15:02:13.845259','2026-10-01 15:02:13.845268'),
(2,2,2.50,400,0x01,NULL,'2026-10-01 15:02:13.845417','2026-10-01 15:02:13.845418'),
(3,3,5.00,1,0x01,NULL,'2026-10-01 15:02:13.845436','2026-10-01 15:02:13.845437'),
(4,4,1.00,800,0x01,NULL,'2026-10-01 15:02:13.845443','2026-10-01 15:02:13.845444'),
(5,5,3.00,234,0x01,NULL,'2026-10-01 15:02:13.845449','2026-10-01 15:02:13.845449'),
(6,6,2.00,345,0x01,NULL,'2026-10-01 15:02:13.845455','2026-10-01 15:02:13.845455'),
(7,7,1.00,795,0x01,NULL,'2026-10-01 15:02:13.845460','2026-10-01 15:02:13.845460'),
(8,8,10.00,233,0x01,NULL,'2026-10-01 15:02:13.845464','2026-10-01 15:02:13.845465'),
(9,9,2.50,123,0x01,NULL,'2026-10-01 15:02:13.845470','2026-10-01 15:02:13.845470'),
(10,10,3.00,NULL,0x01,NULL,'2026-10-01 15:02:13.845475','2026-10-01 15:02:13.845476'),
(11,11,2.00,367,0x01,NULL,'2026-10-01 15:02:13.845481','2026-10-01 15:02:13.845481'),
(12,12,1.00,467,0x01,NULL,'2026-10-01 15:02:13.845486','2026-10-01 15:02:13.845486'),
(13,13,5.00,20,0x01,NULL,'2026-10-01 15:02:13.845492','2026-10-01 15:02:13.845492');
/*!40000 ALTER TABLE `Magazijn` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `Product`
--

DROP TABLE IF EXISTS `Product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `Product` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Naam` varchar(100) NOT NULL,
  `Barcode` varchar(20) NOT NULL,
  `IsActief` bit(1) NOT NULL DEFAULT b'1',
  `Opmerking` varchar(250) DEFAULT NULL,
  `DatumAangemaakt` datetime(6) NOT NULL,
  `DatumGewijzigd` datetime(6) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Product`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `Product` WRITE;
/*!40000 ALTER TABLE `Product` DISABLE KEYS */;
INSERT INTO `Product` VALUES
(1,'Mintnopjes','8719587231278',0x01,NULL,'2026-10-01 15:02:13.725358','2026-10-01 15:02:13.725365'),
(2,'Schoolkrijt','8719587326713',0x01,NULL,'2026-10-01 15:02:13.725460','2026-10-01 15:02:13.725460'),
(3,'Honingdrop','8719587327836',0x01,NULL,'2026-10-01 15:02:13.725474','2026-10-01 15:02:13.725475'),
(4,'Zure Beren','8719587321441',0x01,NULL,'2026-10-01 15:02:13.725478','2026-10-01 15:02:13.725478'),
(5,'Cola Flesjes','8719587321237',0x01,NULL,'2026-10-01 15:02:13.725481','2026-10-01 15:02:13.725481'),
(6,'Turtles','8719587322245',0x01,NULL,'2026-10-01 15:02:13.725484','2026-10-01 15:02:13.725484'),
(7,'Witte Muizen','8719587328256',0x01,NULL,'2026-10-01 15:02:13.725486','2026-10-01 15:02:13.725487'),
(8,'Reuzen Slangen','8719587325641',0x01,NULL,'2026-10-01 15:02:13.725489','2026-10-01 15:02:13.725489'),
(9,'Zoute Rijen','8719587322739',0x01,NULL,'2026-10-01 15:02:13.725491','2026-10-01 15:02:13.725492'),
(10,'Winegums','8719587327527',0x01,NULL,'2026-10-01 15:02:13.725494','2026-10-01 15:02:13.725494'),
(11,'Drop Munten','8719587322345',0x01,NULL,'2026-10-01 15:02:13.725496','2026-10-01 15:02:13.725496'),
(12,'Kruis Drop','8719587322265',0x01,NULL,'2026-10-01 15:02:13.725498','2026-10-01 15:02:13.725499'),
(13,'Zoute Ruitjes','8719587323256',0x01,NULL,'2026-10-01 15:02:13.725501','2026-10-01 15:02:13.725501');
/*!40000 ALTER TABLE `Product` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `ProductPerAllergeen`
--

DROP TABLE IF EXISTS `ProductPerAllergeen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `ProductPerAllergeen` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ProductId` int(10) unsigned NOT NULL,
  `AllergeenId` int(10) unsigned NOT NULL,
  `IsActief` bit(1) NOT NULL DEFAULT b'1',
  `Opmerking` varchar(250) DEFAULT NULL,
  `DatumAangemaakt` datetime(6) NOT NULL,
  `DatumGewijzigd` datetime(6) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `FK_ProductPerAllergeen_ProductId_Product_Id` (`ProductId`),
  KEY `FK_ProductPerAllergeen_AllergeenId_Allergeen_Id` (`AllergeenId`),
  CONSTRAINT `FK_ProductPerAllergeen_AllergeenId_Allergeen_Id` FOREIGN KEY (`AllergeenId`) REFERENCES `Allergeen` (`Id`),
  CONSTRAINT `FK_ProductPerAllergeen_ProductId_Product_Id` FOREIGN KEY (`ProductId`) REFERENCES `Product` (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ProductPerAllergeen`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `ProductPerAllergeen` WRITE;
/*!40000 ALTER TABLE `ProductPerAllergeen` DISABLE KEYS */;
INSERT INTO `ProductPerAllergeen` VALUES
(1,1,2,0x01,NULL,'2026-10-01 15:02:13.886292','2026-10-01 15:02:13.886299'),
(2,1,1,0x01,NULL,'2026-10-01 15:02:13.886451','2026-10-01 15:02:13.886452'),
(3,1,3,0x01,NULL,'2026-10-01 15:02:13.886469','2026-10-01 15:02:13.886469'),
(4,3,4,0x01,NULL,'2026-10-01 15:02:13.886474','2026-10-01 15:02:13.886475'),
(5,6,5,0x01,NULL,'2026-10-01 15:02:13.886479','2026-10-01 15:02:13.886479'),
(6,9,2,0x01,NULL,'2026-10-01 15:02:13.886483','2026-10-01 15:02:13.886483'),
(7,9,5,0x01,NULL,'2026-10-01 15:02:13.886487','2026-10-01 15:02:13.886488'),
(8,10,2,0x01,NULL,'2026-10-01 15:02:13.886491','2026-10-01 15:02:13.886492'),
(9,12,4,0x01,NULL,'2026-10-01 15:02:13.886496','2026-10-01 15:02:13.886496'),
(10,13,1,0x01,NULL,'2026-10-01 15:02:13.886500','2026-10-01 15:02:13.886501'),
(11,13,4,0x01,NULL,'2026-10-01 15:02:13.886504','2026-10-01 15:02:13.886504'),
(12,13,5,0x01,NULL,'2026-10-01 15:02:13.886508','2026-10-01 15:02:13.886508');
/*!40000 ALTER TABLE `ProductPerAllergeen` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `ProductPerLeverancier`
--

DROP TABLE IF EXISTS `ProductPerLeverancier`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `ProductPerLeverancier` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `LeverancierId` int(10) unsigned NOT NULL,
  `ProductId` int(10) unsigned NOT NULL,
  `DatumLevering` date NOT NULL,
  `Aantal` int(11) NOT NULL,
  `DatumEerstVolgendeLevering` date DEFAULT NULL,
  `IsActief` bit(1) NOT NULL DEFAULT b'1',
  `Opmerking` varchar(250) DEFAULT NULL,
  `DatumAangemaakt` datetime(6) NOT NULL,
  `DatumGewijzigd` datetime(6) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `FK_ProductPerLeverancier_LeverancierId_Leverancier_Id` (`LeverancierId`),
  KEY `FK_ProductPerLeverancier_ProductId_Product_Id` (`ProductId`),
  CONSTRAINT `FK_ProductPerLeverancier_LeverancierId_Leverancier_Id` FOREIGN KEY (`LeverancierId`) REFERENCES `Leverancier` (`Id`),
  CONSTRAINT `FK_ProductPerLeverancier_ProductId_Product_Id` FOREIGN KEY (`ProductId`) REFERENCES `Product` (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ProductPerLeverancier`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `ProductPerLeverancier` WRITE;
/*!40000 ALTER TABLE `ProductPerLeverancier` DISABLE KEYS */;
INSERT INTO `ProductPerLeverancier` VALUES
(1,1,1,'2024-10-09',23,'2024-10-16',0x01,NULL,'2026-10-01 15:02:13.927824','2026-10-01 15:02:13.927831'),
(2,1,1,'2024-10-18',21,'2024-10-25',0x01,NULL,'2026-10-01 15:02:13.927934','2026-10-01 15:02:13.927935'),
(3,1,2,'2024-10-09',12,'2024-10-16',0x01,NULL,'2026-10-01 15:02:13.927956','2026-10-01 15:02:13.927956'),
(4,1,3,'2024-10-10',11,'2024-10-17',0x01,NULL,'2026-10-01 15:02:13.927963','2026-10-01 15:02:13.927963'),
(5,2,4,'2024-10-14',16,'2024-10-21',0x01,NULL,'2026-10-01 15:02:13.927969','2026-10-01 15:02:13.927969'),
(6,2,4,'2024-10-21',23,'2024-10-28',0x01,NULL,'2026-10-01 15:02:13.927975','2026-10-01 15:02:13.927975'),
(7,2,5,'2024-10-14',45,'2024-10-21',0x01,NULL,'2026-10-01 15:02:13.927980','2026-10-01 15:02:13.927981'),
(8,2,6,'2024-10-14',30,'2024-10-21',0x01,NULL,'2026-10-01 15:02:13.927986','2026-10-01 15:02:13.927986'),
(9,3,7,'2024-10-12',12,'2024-10-19',0x01,NULL,'2026-10-01 15:02:13.927992','2026-10-01 15:02:13.927992'),
(10,3,7,'2024-10-19',23,'2024-10-26',0x01,NULL,'2026-10-01 15:02:13.927996','2026-10-01 15:02:13.927996'),
(11,3,8,'2024-10-10',12,'2024-10-17',0x01,NULL,'2026-10-01 15:02:13.928000','2026-10-01 15:02:13.928000'),
(12,3,9,'2024-10-11',1,'2024-10-18',0x01,NULL,'2026-10-01 15:02:13.928004','2026-10-01 15:02:13.928004'),
(13,4,10,'2024-10-16',24,'2024-10-30',0x01,NULL,'2026-10-01 15:02:13.928008','2026-10-01 15:02:13.928008'),
(14,5,11,'2024-10-10',47,'2024-10-17',0x01,NULL,'2026-10-01 15:02:13.928011','2026-10-01 15:02:13.928012'),
(15,5,11,'2024-10-19',60,'2024-10-26',0x01,NULL,'2026-10-01 15:02:13.928015','2026-10-01 15:02:13.928016'),
(16,5,12,'2024-10-11',45,NULL,0x01,NULL,'2026-10-01 15:02:13.928019','2026-10-01 15:02:13.928020'),
(17,5,13,'2024-10-12',23,NULL,0x01,NULL,'2026-10-01 15:02:13.928024','2026-10-01 15:02:13.928024');
/*!40000 ALTER TABLE `ProductPerLeverancier` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` bigint(20) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
INSERT INTO `cache` VALUES
('jamin-magazijn-cache-5c785c036466adea360111aa28563bfd556b5fba','i:1;',1790859798),
('jamin-magazijn-cache-5c785c036466adea360111aa28563bfd556b5fba:timer','i:1790859798;',1790859798);
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` bigint(20) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES
(1,'Hardware'),
(2,'Accessoires');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` varchar(255) NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` smallint(5) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES
(1,'0001_01_01_000000_create_users_table',1),
(2,'0001_01_01_000001_create_cache_table',1),
(3,'0001_01_01_000002_create_jobs_table',1),
(4,'2026_09_13_192456_create_permission_tables',1),
(5,'2026_09_14_000000_create_categories_table',1),
(6,'2026_09_14_000001_create_products_table',1),
(7,'2026_09_24_083951_import_database_jamin',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_permissions`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `model_has_permissions` WRITE;
/*!40000 ALTER TABLE `model_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `model_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_roles`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `model_has_roles` WRITE;
/*!40000 ALTER TABLE `model_has_roles` DISABLE KEYS */;
INSERT INTO `model_has_roles` VALUES
(1,'App\\Models\\User',1),
(2,'App\\Models\\User',2),
(3,'App\\Models\\User',3);
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `description` mediumtext NOT NULL,
  `category_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `products_category_id_foreign` (`category_id`),
  CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_has_permissions`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `role_has_permissions` WRITE;
/*!40000 ALTER TABLE `role_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `role_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES
(1,'user','web','2026-10-01 11:02:13','2026-10-01 11:02:13'),
(2,'admin','web','2026-10-01 11:02:13','2026-10-01 11:02:13'),
(3,'magazijnmedewerker','web','2026-10-01 11:02:13','2026-10-01 11:02:13');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES
('locFzK8aOUCPYthrwSF8Cid86BZansc6AGA5gdBM',3,'127.0.0.1','curl/8.18.0','eyJfdG9rZW4iOiJxUmEyYXowYlBSc2gwV2FVWk5kSzRPSGtGUjZDMlYxbTNuUFBaSUNoIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MTI1XC9tYWdhemlqblwvNVwvYWxsZXJnZW5lbiIsInJvdXRlIjoibWFnYXppam4uYWxsZXJnZW5lbiJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX0sImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjozfQ==',1790859739),
('vxGKNvZiBI2pJ9LonYFRJEQBDMnFRUUamiHami0e',NULL,'127.0.0.1','curl/8.18.0','eyJfdG9rZW4iOiJHZ0ZNZVZoUVR4SnIzTThKNmFERXdqa1pOdERIem8zRWEweWx3aG16IiwidXJsIjp7ImludGVuZGVkIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgxMjVcL21hZ2F6aWpuIn0sIl9wcmV2aW91cyI6eyJ1cmwiOiJodHRwOlwvXC8xMjcuMC4wLjE6ODEyNVwvbWFnYXppam4iLCJyb3V0ZSI6Im1hZ2F6aWpuLmluZGV4In0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1790859738),
('xiNXF3O1GTE2v8vi46vBFQZThKmBRCxOzt5QAjVO',NULL,'127.0.0.1','curl/8.18.0','eyJfdG9rZW4iOiJPSXF5cXBYVGdPNGNmeFZyM1pKR2ZTQkRNUDN2UEtSUXlPSld0TVFvIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MTI1Iiwicm91dGUiOiJob21lIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1790859738);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES
(1,'Test User','test@example.com',NULL,'$2y$12$TXzHCcTGiAptIfijH8z.2ebIRUTHSjFCmhORwqp4VowiUM5Cwn.Mm',NULL,'2026-10-01 11:02:14','2026-10-01 11:02:14'),
(2,'admin','admin@admin.com',NULL,'$2y$12$TXzHCcTGiAptIfijH8z.2ebIRUTHSjFCmhORwqp4VowiUM5Cwn.Mm',NULL,'2026-10-01 11:02:14','2026-10-01 11:02:14'),
(3,'Magazijnmedewerker','magazijnmedewerker@jamin.nl',NULL,'$2y$12$TXzHCcTGiAptIfijH8z.2ebIRUTHSjFCmhORwqp4VowiUM5Cwn.Mm',NULL,'2026-10-01 11:02:14','2026-10-01 11:02:14');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*M!100616 SET NOTE_VERBOSITY=@OLD_NOTE_VERBOSITY */;

-- Dump completed on 2026-10-01 15:33:01
