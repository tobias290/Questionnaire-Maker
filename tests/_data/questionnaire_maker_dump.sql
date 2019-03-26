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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_100000_create_password_resets_table',1),(2,'2016_06_01_000001_create_oauth_auth_codes_table',1),(3,'2016_06_01_000002_create_oauth_access_tokens_table',1),(4,'2016_06_01_000003_create_oauth_refresh_tokens_table',1),(5,'2016_06_01_000004_create_oauth_clients_table',1),(6,'2016_06_01_000005_create_oauth_personal_access_clients_table',1),(7,'2019_03_06_150100_create_user_table',1),(8,'2019_03_06_174013_settings',1),(9,'2019_03_06_174720_questionnaire_category',1),(10,'2019_03_06_174908_questionnaire',1),(11,'2019_03_06_175508_question_scaled',1),(12,'2019_03_06_183106_question_scaled_response',1),(13,'2019_03_06_183334_question_closed',1),(14,'2019_03_06_183515_question_closed_option',1),(15,'2019_03_06_183842_question_open',1),(16,'2019_03_06_183958_question_open_response',1),(17,'2019_03_06_184256_create_notification_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notification`
--

DROP TABLE IF EXISTS `notification`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notification` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint(20) unsigned NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notification_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notification`
--

LOCK TABLES `notification` WRITE;
/*!40000 ALTER TABLE `notification` DISABLE KEYS */;
/*!40000 ALTER TABLE `notification` ENABLE KEYS */;
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
INSERT INTO `oauth_access_tokens` VALUES ('4a31e051d77543a8cff1d82d061c44719592c9ab0dc2f31d2ba49a136f6a101e4aa9c52bc482ac83',1,1,'QuestionnaireMaker','[]',0,'2019-03-26 20:02:01','2019-03-26 20:02:01','2020-03-26 20:02:01');
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
INSERT INTO `oauth_clients` VALUES (1,NULL,'Laravel Personal Access Client','QepY1BJhqxZbsisJH86HmB9MhJazVh5K2RPs5pOc','http://localhost',1,0,0,'2019-03-26 20:01:36','2019-03-26 20:01:36'),(2,NULL,'Laravel Password Grant Client','BSZuYmdiQhFlO87HhFSfGPGdmT1d6lLnJ7ahMjgt','http://localhost',0,1,0,'2019-03-26 20:01:36','2019-03-26 20:01:36');
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
INSERT INTO `oauth_personal_access_clients` VALUES (1,1,'2019-03-26 20:01:36','2019-03-26 20:01:36');
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
INSERT INTO `question_closed` VALUES (1,'Allow multiple options',2,'radio',1,1),(2,'Drop down question',3,'drop_down',0,1);
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
INSERT INTO `question_closed_option` VALUES (1,'This',0,1),(2,'That',0,1),(3,'Other One',0,1),(4,'Option 1',0,2),(5,'Option 2',0,2),(6,'Option 3',0,2),(7,'Option 4',0,2);
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
INSERT INTO `question_open` VALUES (1,'Single Line Question',4,0,0,1);
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `question_open_response`
--

LOCK TABLES `question_open_response` WRITE;
/*!40000 ALTER TABLE `question_open_response` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `question_scaled`
--

LOCK TABLES `question_scaled` WRITE;
/*!40000 ALTER TABLE `question_scaled` DISABLE KEYS */;
INSERT INTO `question_scaled` VALUES (1,'Star rating question',1,0.00,5.00,1.00,'star',0,1);
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `question_scaled_response`
--

LOCK TABLES `question_scaled_response` WRITE;
/*!40000 ALTER TABLE `question_scaled_response` DISABLE KEYS */;
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
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `questionnaire_category_id` int(10) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `questionnaire_questionnaire_category_id_foreign` (`questionnaire_category_id`),
  KEY `questionnaire_user_id_foreign` (`user_id`),
  CONSTRAINT `questionnaire_questionnaire_category_id_foreign` FOREIGN KEY (`questionnaire_category_id`) REFERENCES `questionnaire_category` (`id`) ON DELETE CASCADE,
  CONSTRAINT `questionnaire_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `questionnaire`
--

LOCK TABLES `questionnaire` WRITE;
/*!40000 ALTER TABLE `questionnaire` DISABLE KEYS */;
INSERT INTO `questionnaire` VALUES (1,'Public Questionnaire','Public questionnaire to use as answer and responses test.',1,1,0,0,0,NULL,'2019-03-26 20:03:08','2019-03-26 20:04:48',1,1);
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'Tobias','Essex','tobiascompany@gmail.com',NULL,'$2y$10$OI0pvlPg9cnd0.uIiG9a2eNdAIqj4kwbiD4uobKBVPoy1juOGYVNa',NULL,'2019-03-26');
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

-- Dump completed on 2019-03-26 20:05:09
