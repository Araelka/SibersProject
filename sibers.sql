-- MySQL dump 10.13  Distrib 8.0.42, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: sibers
-- ------------------------------------------------------
-- Server version	8.0.42

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'admin','Администратор'),(2,'user','Пользователь');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `login` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `firstName` varchar(50) DEFAULT NULL,
  `secondName` varchar(50) DEFAULT NULL,
  `gender` enum('male','female') DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `role_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`login`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','$2y$10$r7z8qF46rWx5Wj.0zhIgfe.psLg2ken9WLmdP6AbF3hA1qLA20FrG',NULL,NULL,NULL,NULL,1,'2025-09-22 06:50:00','2025-09-22 06:50:00'),(2,'user1','$2y$10$LdoYADimw.nQTM4Dk48km.G6pYPO3YXV8uRIwXtkqaj2sP96dvRxK','Новый','Пользователь','male','2025-09-01',2,'2025-09-22 06:50:35','2025-09-22 06:50:35'),(3,'user2','$2y$10$x9DyStTHkcaAbxc1/egt1eWPxsTRW5HcFdN/HmTJ2H6n2lvUrl3IK','Ещё','Один','female','2025-09-06',2,'2025-09-22 06:50:52','2025-09-22 06:50:52'),(4,'user3','$2y$10$GdW4g38ftYOgjQGlXvpAn.HCq8bY2mT5SxOJZJNsSUXUA84uz7h5S','Титус','Мидус','male','2025-09-04',2,'2025-09-22 06:51:25','2025-09-22 06:51:25'),(5,'user4','$2y$10$oCAoFoeMJWL1m7n6yhxFSOsKJc9ddPiYEpwOWwd1Q1ExfalEGC9Ou','Гарри','Дюбуа','male','2025-09-01',2,'2025-09-22 06:51:40','2025-09-22 06:51:40'),(6,'user16','$2y$10$X62h71k9q61J6Xsz7Jjzpu3daFkg5I0w8SLhxPYKeyr0cHExfQ0mq','Окак','Окак','male','2025-09-04',2,'2025-09-22 06:52:00','2025-09-22 06:52:00'),(7,'gray1','$2y$10$UkxZbhX5uXoM5molyrNPy.2g1.v4030ajiw3v466z9ZZM3Y/VPIT2','Гендальф','Серый','male','2025-09-02',2,'2025-09-22 06:52:28','2025-09-22 06:52:28'),(8,'grey2','$2y$10$a59y45UWsvZXXinGaHaJEOkaWNqLYt/Husvbq3z..6OchT2ggpeRq','Гендальф','Белый','male','2025-09-01',2,'2025-09-22 06:52:44','2025-09-22 06:52:44'),(9,'user666','$2y$10$ede8o.97AOke3KlDX6Gl2epGrhB0aJGrx8vVW3HI9VQecK4WJUUPW','Не','Он','male','2025-09-04',2,'2025-09-22 06:53:06','2025-09-22 06:53:06'),(10,'userNew','$2y$10$6pPe3yWa5HbEuufe59pvKustT08FdS4uhZseSElTqGswZZnXzE5Sq','Имя','Фамилия','male','2025-09-06',2,'2025-09-22 06:53:38','2025-09-22 06:53:38'),(11,'user222','$2y$10$D2uOELrNgWvvT4qv7/Etu.qf2TFRjOKAWIKWwZMpbiA39/xz5fTkS','Лара','Но','female','2025-09-03',2,'2025-09-22 06:54:13','2025-09-22 06:54:13'),(12,'user1111','$2y$10$PxkvTHMChdYOvdYd7mGrUOe0FO3r6K6MI2ugQU8dMFmiN7TuNu0Z2','А','А','male','2025-09-04',2,'2025-09-22 06:54:46','2025-09-22 06:54:46'),(13,'hat','$2y$10$IQYh2vnbIaJdZUyABsNoEOzDOEmyaa/9Q5dDDoyNIJSrYgToER2lO','Весёлый','Шляпник','male','2025-09-02',2,'2025-09-22 06:55:14','2025-09-22 06:55:36');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

--
-- Dumping routines for database 'sibers'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-09-22 13:56:10
