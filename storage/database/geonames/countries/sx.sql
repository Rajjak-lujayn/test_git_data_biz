-- MySQL dump 10.13  Distrib 5.7.32, for osx10.12 (x86_64)
--
-- Host: 127.0.0.1    Database: laraclassified
-- ------------------------------------------------------
-- Server version	5.7.32

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
-- Dumping data for table `<<prefix>>subadmin1`
--

/*!40000 ALTER TABLE `<<prefix>>subadmin1` DISABLE KEYS */;
/*!40000 ALTER TABLE `<<prefix>>subadmin1` ENABLE KEYS */;

--
-- Dumping data for table `<<prefix>>subadmin2`
--

/*!40000 ALTER TABLE `<<prefix>>subadmin2` DISABLE KEYS */;
/*!40000 ALTER TABLE `<<prefix>>subadmin2` ENABLE KEYS */;

--
-- Dumping data for table `<<prefix>>cities`
--

/*!40000 ALTER TABLE `<<prefix>>cities` DISABLE KEYS */;
INSERT INTO `<<prefix>>cities` (`country_code`, `name`, `longitude`, `latitude`, `feature_class`, `feature_code`, `subadmin1_code`, `subadmin2_code`, `population`, `time_zone`, `active`, `created_at`, `updated_at`) VALUES ('SX','{\"en\":\"Philipsburg\"}',-63.05,18.03,'P','PPLC',NULL,NULL,1400,'America/Lower_Princes',1,'2019-09-04 23:00:00','2019-09-04 23:00:00');
INSERT INTO `<<prefix>>cities` (`country_code`, `name`, `longitude`, `latitude`, `feature_class`, `feature_code`, `subadmin1_code`, `subadmin2_code`, `population`, `time_zone`, `active`, `created_at`, `updated_at`) VALUES ('SX','{\"en\":\"Lower Prince’s Quarter\"}',-63.04,18.05,'P','PPL','SX.00',NULL,8000,'America/Lower_Princes',1,'2016-11-27 23:00:00','2016-11-27 23:00:00');
INSERT INTO `<<prefix>>cities` (`country_code`, `name`, `longitude`, `latitude`, `feature_class`, `feature_code`, `subadmin1_code`, `subadmin2_code`, `population`, `time_zone`, `active`, `created_at`, `updated_at`) VALUES ('SX','{\"en\":\"Cul de Sac\"}',-63.07,18.05,'P','PPLL','SX.00',NULL,8467,'America/Lower_Princes',1,'2016-11-27 23:00:00','2016-11-27 23:00:00');
INSERT INTO `<<prefix>>cities` (`country_code`, `name`, `longitude`, `latitude`, `feature_class`, `feature_code`, `subadmin1_code`, `subadmin2_code`, `population`, `time_zone`, `active`, `created_at`, `updated_at`) VALUES ('SX','{\"en\":\"Koolbaai\"}',-63.08,18.04,'P','PPL','SX.00',NULL,6000,'America/Lower_Princes',1,'2016-11-27 23:00:00','2016-11-27 23:00:00');
/*!40000 ALTER TABLE `<<prefix>>cities` ENABLE KEYS */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed
