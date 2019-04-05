-- MySQL dump 10.13  Distrib 5.7.11, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: questionnaire_maker
-- ------------------------------------------------------
-- Server version	5.7.11-log

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
-- Table structure for table `admin_user`
--

DROP TABLE IF EXISTS `admin_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_user` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admin_user_username_unique` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_user`
--

LOCK TABLES `admin_user` WRITE;
/*!40000 ALTER TABLE `admin_user` DISABLE KEYS */;
INSERT INTO `admin_user` VALUES (1,'tobias290','$2y$10$coNgisQvtc9p4Vf7brOnpeUI2Hv2bM15u0G5Wua3Uvx2GYfkRCXKy');
/*!40000 ALTER TABLE `admin_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_100000_create_password_resets_table',1),(2,'2016_06_01_000001_create_oauth_auth_codes_table',1),(3,'2016_06_01_000002_create_oauth_access_tokens_table',1),(4,'2016_06_01_000003_create_oauth_refresh_tokens_table',1),(5,'2016_06_01_000004_create_oauth_clients_table',1),(6,'2016_06_01_000005_create_oauth_personal_access_clients_table',1),(7,'2019_03_06_150100_create_user_table',1),(8,'2019_03_06_174013_settings',1),(9,'2019_03_06_174720_questionnaire_category',1),(10,'2019_03_06_174908_questionnaire',1),(11,'2019_03_06_175508_question_scaled',1),(12,'2019_03_06_183106_question_scaled_response',1),(13,'2019_03_06_183334_question_closed',1),(14,'2019_03_06_183515_question_closed_option',1),(15,'2019_03_06_183842_question_open',1),(16,'2019_03_06_183958_question_open_response',1),(17,'2019_04_02_164715_create_notifications_table',1),(18,'2019_04_03_211810_admin_user',2);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint(20) unsigned NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
INSERT INTO `notifications` VALUES ('1d6b242f-f3f1-4b26-97b3-3990bc42bcab','App\\Notifications\\QuestionnaireResponse','App\\Models\\User',1,'{\"title\":\"You have a new response!\",\"message\":\"A new response for First Questionnaire has just come in. You now have 1 responses!\"}',NULL,'2019-04-03 12:27:19','2019-04-03 12:27:19'),('240879ff-8461-4a4d-835a-7f2bb5ada496','App\\Notifications\\QuestionnaireResponse','App\\Models\\User',1,'{\"title\":\"You have a new response!\",\"message\":\"A new response for First Questionnaire has just come in. You now have 4 responses!\"}',NULL,'2019-04-03 12:28:18','2019-04-03 12:28:18'),('5b49d001-a4a1-47e0-9faa-02a531066986','App\\Notifications\\QuestionnaireResponse','App\\Models\\User',1,'{\"title\":\"You have a new response!\",\"message\":\"A new response for First Questionnaire has just come in. You now have 6 responses!\"}',NULL,'2019-04-03 12:28:51','2019-04-03 12:28:51'),('63fb74d8-652c-4f4f-86d6-240440b6de4e','App\\Notifications\\Welcome','App\\Models\\User',2,'{\"title\":\"Welcome to Questionnaire Maker\",\"message\":\"Thank You Toby Essex for signing up with us!\"}',NULL,'2019-04-05 13:09:44','2019-04-05 13:09:44'),('880f2db5-5678-4f77-88cc-ec0f9506f5e8','App\\Notifications\\QuestionnaireResponse','App\\Models\\User',1,'{\"title\":\"You have a new response!\",\"message\":\"A new response for First Questionnaire has just come in. You now have 5 responses!\"}',NULL,'2019-04-03 12:28:27','2019-04-03 12:28:27'),('cbbb16f9-0d3d-45af-a458-e5a5db8814dc','App\\Notifications\\QuestionnaireResponse','App\\Models\\User',1,'{\"title\":\"You have a new response!\",\"message\":\"A new response for First Questionnaire has just come in. You now have 2 responses!\"}',NULL,'2019-04-03 12:27:32','2019-04-03 12:27:32'),('ff0edfbb-a741-415e-a322-278ba76e8f13','App\\Notifications\\QuestionnaireResponse','App\\Models\\User',1,'{\"title\":\"You have a new response!\",\"message\":\"A new response for First Questionnaire has just come in. You now have 3 responses!\"}',NULL,'2019-04-03 12:28:07','2019-04-03 12:28:07');
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_access_tokens`
--

DROP TABLE IF EXISTS `oauth_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `client_id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_access_tokens_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_access_tokens`
--

LOCK TABLES `oauth_access_tokens` WRITE;
/*!40000 ALTER TABLE `oauth_access_tokens` DISABLE KEYS */;
INSERT INTO `oauth_access_tokens` VALUES ('29a60419e42541bdd49f4b17e8bed4893aa3b2dd794a2756cbf02ce1a77cdfcc40f9ee0243e0de23',1,1,'QuestionnaireMaker','[]',0,'2019-04-03 12:08:31','2019-04-03 12:08:31','2020-04-03 13:08:31'),('4fc5edaefde0263b0ed4f705e81db820316893a770d70baa1c99b90bb5b987b1dbcb04a1c9fcb7ad',1,1,'QuestionnaireMaker','[]',0,'2019-04-03 11:10:54','2019-04-03 11:10:54','2020-04-03 12:10:54'),('98e532e256c3000367c74a0d6f729d97e47094b387447c555a3eb1ac45eb11f21f4e67816e4bedd4',2,1,'QuestionnaireMaker','[]',0,'2019-04-05 13:09:43','2019-04-05 13:09:43','2020-04-05 14:09:43'),('d00a7795b50714a225f01d42c78a82c27eb70f1e85da41928433482de9364efe3ee48ef002bf0bd6',1,1,'QuestionnaireMaker','[]',0,'2019-04-03 11:58:48','2019-04-03 11:58:48','2020-04-03 12:58:48');
/*!40000 ALTER TABLE `oauth_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_auth_codes`
--

DROP TABLE IF EXISTS `oauth_auth_codes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `client_id` int(10) unsigned NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_auth_codes`
--

LOCK TABLES `oauth_auth_codes` WRITE;
/*!40000 ALTER TABLE `oauth_auth_codes` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_auth_codes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_clients`
--

DROP TABLE IF EXISTS `oauth_clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_clients` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_clients_user_id_index` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_clients`
--

LOCK TABLES `oauth_clients` WRITE;
/*!40000 ALTER TABLE `oauth_clients` DISABLE KEYS */;
INSERT INTO `oauth_clients` VALUES (1,NULL,'Laravel Personal Access Client','d91UpNUayX7AGMkDCnGfGdwU19Ewhp4Vx9SLLEQx','http://localhost',1,0,0,'2019-04-03 11:09:21','2019-04-03 11:09:21'),(2,NULL,'Laravel Password Grant Client','a7qaM81I5eLz33F7C49PM0X5C5tHDkaBaOuWK8jF','http://localhost',0,1,0,'2019-04-03 11:09:21','2019-04-03 11:09:21');
/*!40000 ALTER TABLE `oauth_clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_personal_access_clients`
--

DROP TABLE IF EXISTS `oauth_personal_access_clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_personal_access_clients` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_personal_access_clients_client_id_index` (`client_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_personal_access_clients`
--

LOCK TABLES `oauth_personal_access_clients` WRITE;
/*!40000 ALTER TABLE `oauth_personal_access_clients` DISABLE KEYS */;
INSERT INTO `oauth_personal_access_clients` VALUES (1,1,'2019-04-03 11:09:21','2019-04-03 11:09:21');
/*!40000 ALTER TABLE `oauth_personal_access_clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_refresh_tokens`
--

DROP TABLE IF EXISTS `oauth_refresh_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_refresh_tokens`
--

LOCK TABLES `oauth_refresh_tokens` WRITE;
/*!40000 ALTER TABLE `oauth_refresh_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_refresh_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `question_closed`
--

DROP TABLE IF EXISTS `question_closed`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `question_closed` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` int(11) NOT NULL,
  `type` enum('check','radio','drop_down') COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_required` tinyint(1) NOT NULL DEFAULT '0',
  `questionnaire_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `question_closed_questionnaire_id_foreign` (`questionnaire_id`),
  CONSTRAINT `question_closed_questionnaire_id_foreign` FOREIGN KEY (`questionnaire_id`) REFERENCES `questionnaire` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `question_closed`
--

LOCK TABLES `question_closed` WRITE;
/*!40000 ALTER TABLE `question_closed` DISABLE KEYS */;
INSERT INTO `question_closed` VALUES (1,'Check boxes?',1,'check',0,1);
/*!40000 ALTER TABLE `question_closed` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `question_closed_option`
--

DROP TABLE IF EXISTS `question_closed_option`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `question_closed_option` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `option` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `responses` int(11) NOT NULL DEFAULT '0',
  `question_closed_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `question_closed_option_question_closed_id_foreign` (`question_closed_id`),
  CONSTRAINT `question_closed_option_question_closed_id_foreign` FOREIGN KEY (`question_closed_id`) REFERENCES `question_closed` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `question_closed_option`
--

LOCK TABLES `question_closed_option` WRITE;
/*!40000 ALTER TABLE `question_closed_option` DISABLE KEYS */;
INSERT INTO `question_closed_option` VALUES (1,'Toby',3,1),(2,'Jeff',3,1),(3,'Mike',5,1),(4,'Luke',3,1),(5,'Kate',3,1),(6,'Irene',1,1);
/*!40000 ALTER TABLE `question_closed_option` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `question_open`
--

DROP TABLE IF EXISTS `question_open`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `question_open` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` int(11) NOT NULL,
  `is_required` tinyint(1) NOT NULL DEFAULT '0',
  `is_long` tinyint(1) NOT NULL,
  `questionnaire_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `question_open_questionnaire_id_foreign` (`questionnaire_id`),
  CONSTRAINT `question_open_questionnaire_id_foreign` FOREIGN KEY (`questionnaire_id`) REFERENCES `questionnaire` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `question_open`
--

LOCK TABLES `question_open` WRITE;
/*!40000 ALTER TABLE `question_open` DISABLE KEYS */;
INSERT INTO `question_open` VALUES (1,'What is your name?',3,0,0,1);
/*!40000 ALTER TABLE `question_open` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `question_open_response`
--

DROP TABLE IF EXISTS `question_open_response`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `question_open_response` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `response` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `question_open_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `question_open_response_question_open_id_foreign` (`question_open_id`),
  CONSTRAINT `question_open_response_question_open_id_foreign` FOREIGN KEY (`question_open_id`) REFERENCES `question_open` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `question_open_response`
--

LOCK TABLES `question_open_response` WRITE;
/*!40000 ALTER TABLE `question_open_response` DISABLE KEYS */;
INSERT INTO `question_open_response` VALUES (1,'Toby',1),(2,'Jeff',1),(3,'Kate',1),(4,'Luke',1),(5,'Irene',1),(6,'Mike',1);
/*!40000 ALTER TABLE `question_open_response` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `question_scaled`
--

DROP TABLE IF EXISTS `question_scaled`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `question_scaled` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` int(11) NOT NULL,
  `min` double(8,2) NOT NULL DEFAULT '0.00',
  `max` double(8,2) NOT NULL DEFAULT '5.00',
  `interval` double(8,2) NOT NULL DEFAULT '1.00',
  `type` enum('star','slider') COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_required` tinyint(1) NOT NULL DEFAULT '0',
  `questionnaire_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `question_scaled_questionnaire_id_foreign` (`questionnaire_id`),
  CONSTRAINT `question_scaled_questionnaire_id_foreign` FOREIGN KEY (`questionnaire_id`) REFERENCES `questionnaire` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `question_scaled`
--

LOCK TABLES `question_scaled` WRITE;
/*!40000 ALTER TABLE `question_scaled` DISABLE KEYS */;
INSERT INTO `question_scaled` VALUES (1,'Star Rating?',1,0.00,5.00,1.00,'star',0,3),(2,'Slider Question',1,0.00,10.00,1.00,'slider',0,2),(3,'Star Rating?',2,0.00,5.00,1.00,'star',0,1);
/*!40000 ALTER TABLE `question_scaled` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `question_scaled_response`
--

DROP TABLE IF EXISTS `question_scaled_response`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `question_scaled_response` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `response` double(8,2) NOT NULL,
  `question_scaled_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `question_scaled_response_question_scaled_id_foreign` (`question_scaled_id`),
  CONSTRAINT `question_scaled_response_question_scaled_id_foreign` FOREIGN KEY (`question_scaled_id`) REFERENCES `question_scaled` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `question_scaled_response`
--

LOCK TABLES `question_scaled_response` WRITE;
/*!40000 ALTER TABLE `question_scaled_response` DISABLE KEYS */;
INSERT INTO `question_scaled_response` VALUES (1,3.00,3),(2,5.00,3),(3,2.00,3),(4,2.00,3),(5,4.00,3),(6,1.00,3);
/*!40000 ALTER TABLE `question_scaled_response` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `questionnaire`
--

DROP TABLE IF EXISTS `questionnaire`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `questionnaire` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_public` tinyint(1) NOT NULL DEFAULT '0',
  `is_complete` tinyint(1) NOT NULL DEFAULT '0',
  `is_reported` tinyint(1) NOT NULL DEFAULT '0',
  `is_locked` tinyint(1) NOT NULL DEFAULT '0',
  `responses` int(11) NOT NULL DEFAULT '0',
  `expiry_date` date DEFAULT NULL,
  `expiry_date_advanced_notified` tinyint(1) NOT NULL DEFAULT '0',
  `expiry_date_notified` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `questionnaire_category_id` int(10) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `questionnaire_questionnaire_category_id_foreign` (`questionnaire_category_id`),
  KEY `questionnaire_user_id_foreign` (`user_id`),
  CONSTRAINT `questionnaire_questionnaire_category_id_foreign` FOREIGN KEY (`questionnaire_category_id`) REFERENCES `questionnaire_category` (`id`) ON DELETE CASCADE,
  CONSTRAINT `questionnaire_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `questionnaire`
--

LOCK TABLES `questionnaire` WRITE;
/*!40000 ALTER TABLE `questionnaire` DISABLE KEYS */;
INSERT INTO `questionnaire` VALUES (1,'First Questionnaire','Test Questionnaire',1,1,0,0,6,'2019-04-06',0,0,'2019-04-03 11:12:40','2019-04-03 12:28:51',2,1),(2,'Expired Questionnaire','This has expired!',1,1,0,0,0,'2019-04-02',0,0,'2019-04-03 11:13:01','2019-04-03 12:21:29',2,1),(3,'Public Questionnaire','Public Questionnaire',1,1,0,0,0,NULL,0,0,'2019-04-03 12:06:01','2019-04-03 12:06:29',13,1);
/*!40000 ALTER TABLE `questionnaire` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `questionnaire_category`
--

DROP TABLE IF EXISTS `questionnaire_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `questionnaire_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `questionnaire_category`
--

LOCK TABLES `questionnaire_category` WRITE;
/*!40000 ALTER TABLE `questionnaire_category` DISABLE KEYS */;
INSERT INTO `questionnaire_category` VALUES (1,'Business'),(2,'Community'),(3,'Customer Feedback'),(4,'Customer Satisfaction'),(5,'Education'),(6,'Events'),(7,'Health Care'),(8,'Human Resources'),(9,'Just For Fun'),(10,'Marketing'),(11,'Non Profit'),(12,'Political'),(13,'Other');
/*!40000 ALTER TABLE `questionnaire_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings` (
  `user_id` bigint(20) unsigned NOT NULL,
  `enable_in_app_notifications` tinyint(1) NOT NULL DEFAULT '1',
  `enable_email_notifications` tinyint(1) NOT NULL DEFAULT '1',
  `questionnaire_expiration_notification` enum('none','day','week','month') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'day',
  KEY `settings_user_id_foreign` (`user_id`),
  CONSTRAINT `settings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (1,1,0,'week'),(2,1,1,'day');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `surname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_joined` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'Toby','Essex','tobiascompany@gmail.com',NULL,'$2y$10$aEakPpANXwnc4jbBamWGUeSj7R6V1h6UEh9yi96RZMMiLlHi3oGBC',NULL,'2019-04-03'),(2,'Toby','Essex','tobysx@gmail.com',NULL,'$2y$10$gUx3aZo9LCL00lCpny470OtX0FGVoyzNZSy6XPLL5tak1WI16kAGa',NULL,'2019-04-05');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-04-05 15:10:34
