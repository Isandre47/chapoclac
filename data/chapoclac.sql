-- MySQL dump 10.13  Distrib 8.0.12, for osx10.13 (x86_64)
--
-- Host: localhost    Database: chapoclac
-- ------------------------------------------------------
-- Server version	8.0.12

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
 SET NAMES utf8mb4 ;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `chapoclac`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `chapoclac` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */;

USE `chapoclac`;

--
-- Table structure for table `activities`
--

DROP TABLE IF EXISTS `activities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `activities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cours` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `day` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `reservation` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hour` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `picture` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activities`
--

LOCK TABLES `activities` WRITE;
/*!40000 ALTER TABLE `activities` DISABLE KEYS */;
INSERT INTO `activities` VALUES (6,'Adolescents(Lycée)','Mercredi',NULL,'18h15 - 19h45','541315503c633cfb24438ca9b9c0b9bb.jpeg','165'),(8,'Adultes','Mercredi',NULL,'20h00 - 22h00','26c1c005fce38c1623624ed6131203b0.png','285'),(9,'Enfants(Primaire)','Lundi',NULL,'17h-18h','a10a7ff986d955e3a2634ae8bbd47ce3.jpeg','145'),(10,'Enfants(Collèges)','Mercredi',NULL,'17h - 18h','4dd6720ffd4b2d1e0d513d5bc73fe15c.jpeg','145'),(16,'Enfants(Primaire)','Mercredi',NULL,'16h45 - 17h45','0cd0a5d7816f938c2264209f343e6295.jpeg','145');
/*!40000 ALTER TABLE `activities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `articles`
--

DROP TABLE IF EXISTS `articles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_creation` datetime DEFAULT NULL,
  `medias` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `press` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sub_title` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_BFDD3168F675F31B` (`author_id`),
  KEY `IDX_BFDD316812469DE2` (`category_id`),
  CONSTRAINT `FK_BFDD316812469DE2` FOREIGN KEY (`category_id`) REFERENCES `category_article` (`id`),
  CONSTRAINT `FK_BFDD3168F675F31B` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `articles`
--

LOCK TABLES `articles` WRITE;
/*!40000 ALTER TABLE `articles` DISABLE KEYS */;
INSERT INTO `articles` VALUES (2,139,2,'Sortie des élèves aux Célestins','Le 24 mars dernier nous avons emmener les ados assister à Georges Dandin dans le magnifique théâtre des Célestins.\r\nLa soirée à d\'abord commencé par un repas au resto/cafet du théâtre \"l\'Etourdi\" puis nous nous sommes dirigés vers nos places respectives dans cette salle magnifique des Célestins. Un théâtre à l\'ancienne comme on en fait plus, avec 3 balcons, des lustres magnifiques, le plafond entièrement peint par divers artistes, des moulures splendides, c\'est un décor à vous couper le souffle.',NULL,'9c349c94e50be92328bfd1878fb18b10.png','Provident et esse eligendi molestias fuga tenetur inventore. Error pariatur suscipit est et eaque at iste.','Les ados ont pu assister à une pièce de Molière dans le plus beau théâtre de Lyon'),(3,139,3,'Hôtes Tensions de Franck Didier.','Venez nombreux au nouveau spectacle de la troupe de Ternay \r\nqui aura lieu au foyer rural de Ternay, les :\r\nJeudi 15 mars à 20h30\r\nVendredi 16 mars à 20h30\r\nSamedi 17 mars à 20h30\r\nDimanche 18 mars à 16h00',NULL,'e13f13fe8f390b536d1d08ebcc225d6f.jpeg','Mollitia vero modi dolores veritatis ipsa. Alias necessitatibus voluptate ab vitae debitis et.','Troupe de Ternay'),(5,139,2,'Superbe prestation','Le public était nombreux à venir écouter le concerto de Chapo-clac......',NULL,'c6ad08430998bd593dfd56a9e9c246d6.jpeg','Culpa ut quisquam consequuntur voluptas voluptatem voluptatem excepturi. Quo a et quod. Aut reiciendis nisi dolorem quia minima illum non.','Consequuntur totam dolores in iste quo omnis. Repudiandae maiores soluta odit qui eum dicta aut est.');
/*!40000 ALTER TABLE `articles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category_article`
--

DROP TABLE IF EXISTS `category_article`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `category_article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category_article`
--

LOCK TABLES `category_article` WRITE;
/*!40000 ALTER TABLE `category_article` DISABLE KEYS */;
INSERT INTO `category_article` VALUES (2,'Actualités de Chapo-Clac'),(3,'Actualités de nos amis');
/*!40000 ALTER TABLE `category_article` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category_gallery`
--

DROP TABLE IF EXISTS `category_gallery`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `category_gallery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category_gallery`
--

LOCK TABLES `category_gallery` WRITE;
/*!40000 ALTER TABLE `category_gallery` DISABLE KEYS */;
/*!40000 ALTER TABLE `category_gallery` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author_id` int(11) DEFAULT NULL,
  `articles_id` int(11) DEFAULT NULL,
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` datetime NOT NULL,
  `speudo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_5F9E962AF675F31B` (`author_id`),
  KEY `IDX_5F9E962A1EBAF6CC` (`articles_id`),
  CONSTRAINT `FK_5F9E962A1EBAF6CC` FOREIGN KEY (`articles_id`) REFERENCES `articles` (`id`),
  CONSTRAINT `FK_5F9E962AF675F31B` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gallery`
--

DROP TABLE IF EXISTS `gallery`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `gallery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `spectacle_id` int(11) NOT NULL,
  `picture` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_472B783AC682915D` (`spectacle_id`),
  CONSTRAINT `FK_472B783AC682915D` FOREIGN KEY (`spectacle_id`) REFERENCES `spectacles` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gallery`
--

LOCK TABLES `gallery` WRITE;
/*!40000 ALTER TABLE `gallery` DISABLE KEYS */;
INSERT INTO `gallery` VALUES (19,9,'9a4289084e7c2947087633ef8d55535a.pdf'),(20,8,'ad9354c5144731af9e2ab7bc4daaedb2.jpeg'),(21,8,'6ecd3bd2d34e037df7dab637991bb6a0.jpeg'),(22,8,'04b30c0a1d72428a59aede6e03e557ca.jpeg'),(24,8,'82d1076567b8825ffe369664e207f73b.jpeg'),(25,8,'c39607e85f9e14c3a76b3fe041e2e61e.jpeg'),(26,8,'23339418026c9c27fbf26b74382c9a96.jpeg'),(35,7,'8829c6dcdf91e0aebdde3df67d881e3c.jpeg'),(36,7,'53d5dbc5692dd2227a42610735541e1d.jpeg'),(39,7,'2e0e5450c86bedfd103364f14ab10b92.jpeg'),(51,9,'327478dec15fcb052a352a727fb51edd.jpeg'),(52,9,'03e9e0e9f1335975bfb033d503b744e1.jpeg'),(53,9,'1269934404d2125d640314462ca57185.jpeg'),(54,9,'f967ad283fa6d92262a869c883e1270f.jpeg'),(55,9,'0473e2ae717f2632d479b9bd33e90c1c.jpeg'),(56,9,'9252b009c265a4887435dd9188420a51.jpeg'),(57,9,'419a5cea2d1554e00daf4628fd8185b2.jpeg'),(58,8,'15181831354d143afb893f6f34bd1b14.jpeg'),(59,3,'a7d6d112db4169a4acd5c783f716d212.jpeg'),(60,3,'beee287293f35192f28501581779b2b1.jpeg'),(61,3,'751fef4730c0d4fbbd9445de0ebed190.jpeg'),(62,3,'2a6942a4be41170b76d1058d7e87825b.jpeg'),(63,3,'2bcfba988a8a15033eea6b3c5aded319.jpeg'),(64,3,'ecfe0783ff06476768d3d0e3aa2f5e75.jpeg'),(66,3,'37277e11563a924a85c7fd812934b956.jpeg'),(67,3,'80a5350d5b1c4e2eef3d3213315e8866.jpeg'),(68,3,'23268041181fdeb28a1f40cd178345d6.jpeg'),(69,3,'c01b5f82797d93f8f5a097c6c0790732.jpeg'),(70,3,'d24b9d1bb1f18cc516826e2d7b02d845.jpeg'),(71,3,'6c3f82fafcde5e7b7319418a4c87710b.jpeg'),(72,3,'a52ccbcb30d84325b3354fc7810ff870.jpeg'),(73,3,'6148eca927856560464176fd40677f56.jpeg'),(74,3,'c1fa617d8793880abd44526648299325.jpeg'),(75,3,'4675f121e1eb9506140c6df72a057454.jpeg'),(76,3,'e8598d02840ca83793e520f5f1ec235c.jpeg'),(77,3,'17a82c6ed646c01cb3b6c99cbf5eea32.jpeg');
/*!40000 ALTER TABLE `gallery` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `date_send` datetime DEFAULT NULL,
  `view` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_DB021E96A76ED395` (`user_id`),
  CONSTRAINT `FK_DB021E96A76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migration_versions`
--

DROP TABLE IF EXISTS `migration_versions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `migration_versions` (
  `version` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migration_versions`
--

LOCK TABLES `migration_versions` WRITE;
/*!40000 ALTER TABLE `migration_versions` DISABLE KEYS */;
INSERT INTO `migration_versions` VALUES ('20181212102508'),('20190109192600'),('20190111102500'),('20190114163950'),('20190114194433'),('20190116085036'),('20190116101416'),('20190128100815');
/*!40000 ALTER TABLE `migration_versions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `picture`
--

DROP TABLE IF EXISTS `picture`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `picture` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `picture`
--

LOCK TABLES `picture` WRITE;
/*!40000 ALTER TABLE `picture` DISABLE KEYS */;
/*!40000 ALTER TABLE `picture` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `presentation`
--

DROP TABLE IF EXISTS `presentation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `presentation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `presentation`
--

LOCK TABLES `presentation` WRITE;
/*!40000 ALTER TABLE `presentation` DISABLE KEYS */;
INSERT INTO `presentation` VALUES (1,'Qui sommes nous ?','L’association CHAPO-CLAC a été créée en 2005.\r\nElle organise des cours de théâtre dispensés par Joëlle, professeur et metteur en scène de la compagnie du Théâtre du Mordant.\r\nElle propose divers cours que vous trouverez plus bas.');
/*!40000 ALTER TABLE `presentation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `registration`
--

DROP TABLE IF EXISTS `registration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `registration` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `activity_id` int(11) NOT NULL,
  `validated` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_62A8A7A7A76ED395` (`user_id`),
  KEY `IDX_62A8A7A781C06096` (`activity_id`),
  CONSTRAINT `FK_62A8A7A781C06096` FOREIGN KEY (`activity_id`) REFERENCES `activities` (`id`),
  CONSTRAINT `FK_62A8A7A7A76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `registration`
--

LOCK TABLES `registration` WRITE;
/*!40000 ALTER TABLE `registration` DISABLE KEYS */;
/*!40000 ALTER TABLE `registration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `spectacles`
--

DROP TABLE IF EXISTS `spectacles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `spectacles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `poster` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `resume` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `spectacles`
--

LOCK TABLES `spectacles` WRITE;
/*!40000 ALTER TABLE `spectacles` DISABLE KEYS */;
INSERT INTO `spectacles` VALUES (3,'3f9d922736e7fed66bd2befd03fb3bb8.jpeg','L\'art de la fugue','Cela fait plusieurs semaines qu’on est sans nouvelle de la locataire du premier étage quand le chat de Mme  Poulard disparaît à son tour.\r\n                                Il se passe de drôles de choses au 2 rue Jean-Sébastien Bach et le calme habituel du quartier va très vite se fissurer.\r\n                                Les personnages se croisent et se racontent, rebondissements et révélations se succèdent lors de cette journée pas comme les autres.'),(7,'c44fbc9d390e975630f66e36dcdd2714.jpeg','Veillée funèbre','Cela fait plusieurs semaines qu’on est sans nouvelle de la locataire du premier étage quand le chat de Mme Poulard disparaît à son tour. Il se passe de drôles de choses au 2 rue Jean-Sébastien Bach et le calme habituel du quartier va très vite se fissurer. Les personnages se croisent et se racontent, rebondissements et révélations se succèdent lors de cette journée pas comme les autres.'),(8,'17bc76002437dae423050f31c4e5f644.jpeg','L\'orchestre','Cela fait plusieurs semaines qu’on est sans nouvelle de la locataire du premier étage quand le chat de Mme Poulard disparaît à son tour. Il se passe de drôles de choses au 2 rue Jean-Sébastien Bach et le calme habituel du quartier va très vite se fissurer. Les personnages se croisent et se racontent, rebondissements et révélations se succèdent lors de cette journée pas comme les autres.'),(9,'153d15a135f9c86fa7810a8abded2cdf.pdf','Des squelettes dans le placard','Ils pensaient partie en week-end Thalasso mais.......');
/*!40000 ALTER TABLE `spectacles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `spectacles_users`
--

DROP TABLE IF EXISTS `spectacles_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `spectacles_users` (
  `spectacles_id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  PRIMARY KEY (`spectacles_id`,`users_id`),
  KEY `IDX_FB6D73C9F26D12FD` (`spectacles_id`),
  KEY `IDX_FB6D73C967B3B43D` (`users_id`),
  CONSTRAINT `FK_FB6D73C967B3B43D` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_FB6D73C9F26D12FD` FOREIGN KEY (`spectacles_id`) REFERENCES `spectacles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `spectacles_users`
--

LOCK TABLES `spectacles_users` WRITE;
/*!40000 ALTER TABLE `spectacles_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `spectacles_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_adress` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `phone_house` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_mobil` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contributions` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `newsletters` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `create_date` date DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `insurance` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `num_insurance` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `number_check` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `doctor_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `doctor_phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `doctor_adress` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `minor_phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `minor_class` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `minor_name_responsable` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `picture` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `validate` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `picture_fun` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reset_token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_1483A5E9E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=174 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (17,'Céline','Karoutchi','boulevard Théodore Peltier00705 Delattredan','4','33','Oui','Oui',NULL,'2016-02-29','Sint commodi sapiente autem quia.','08 95 77 65 23','33','Thibaut','07 66 90 74 39','50','33','Reprehenderit rem suscipit earum dolores blanditiis.','Jacques Gauthier-Pons','Céline1.jpg','xbodin@girard.org','[\"ROLE_USER\", \"Trésorier\"]','9}T$LH\\&^~L}Jm',NULL,NULL,NULL),(18,'Elizabeth ','Millon','6, chemin Éric Lenoir\n04 320 Gallet','33','33','oui','oui',NULL,'2008-08-08','Iure sint est odio aut id.','0218857716','33','Colette','01 26 83 93 57','66','33','Sit esse doloremque repudiandae vero quo ea sit.','Benoît Joubert','Elizabeth.jpg','berthelot.christophe@live.com','[\"ROLE_USER\", \"Trésorier adjoint\"]','lF?f^{07mcY&m(}Ba',NULL,NULL,NULL),(20,'Séverine ','Roumestant','97, boulevard Olivie Hubert\n39064 Vincent','782474179','33','oui','oui',NULL,'1971-09-22','Quia quam architecto consequatur et excepturi.','09 63 66 86 14','118509375','Thomas','01 57 74 72 45','4','33','Quaerat quas temporibus et sunt dolor voluptatem alias.','Timothée Roy','Severine.jpg','philippe75@bouygtel.fr','[\"ROLE_USER\", \"Secrétaire adjoint\"]',')$E5RA',NULL,NULL,NULL),(139,'Evelyne','Pouvreau','hfhdehe','0666666666','0666666666','Oui','Oui','2019-01-11','1899-01-01','0666666666','0666666666',NULL,'dzfzefez','0666666666','efdf',NULL,NULL,NULL,'','gfghz@gvc.com','[\"ROLE_ADMIN\", \"Président\"]','5c392b33134a1',NULL,'Evelyne2.jpg',NULL),(141,'Annie','Frati','nfndfj','0666666666','0666666666','Oui','Oui','2019-01-11','1899-01-01','0666666666','0666666666',NULL,'gfgdee','0666666666','hdfhez',NULL,NULL,NULL,'Annie.jpg','hfheh@ndfj.com','[\"Secrétaire\", \"ROLE_USER\"]','5c392ceedeb11',NULL,NULL,NULL),(171,'lolotte','chauvet','13 rue du garnier',NULL,'0666666666','non','Oui','2019-01-28','1981-07-16','nvjdj','fheje5677','000','jfjej','0666666666','jghjie',NULL,NULL,NULL,NULL,'pixelleart@gmail.com','[\"ROLE_ADMIN\"]','$2y$13$gPwvmtoDrRPOFSmCK6xHeefYaomDRZFkAlqgWRa9nMIHr6Yv1CziS',NULL,NULL,NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `youtube`
--

DROP TABLE IF EXISTS `youtube`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `youtube` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sub_title` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `picture` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `youtube`
--

LOCK TABLES `youtube` WRITE;
/*!40000 ALTER TABLE `youtube` DISABLE KEYS */;
INSERT INTO `youtube` VALUES (2,'L\'art de la fugue','Il se passe de drôle de choses au 2 rue Jean Sébastien Bach et le calme habituel du quartier va vite se fissurer...','https://youtu.be/Koccan_v3V8','e460269f908f12c56aa2380dc88b0d32.jpeg');
/*!40000 ALTER TABLE `youtube` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-01-29 15:57:54
