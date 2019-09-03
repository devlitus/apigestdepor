/*
SQLyog Ultimate v12.09 (64 bit)
MySQL - 10.4.6-MariaDB : Database - gestdepor
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`gestdepor` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci */;

USE `gestdepor`;

/*Table structure for table `data_session` */

DROP TABLE IF EXISTS `data_session`;

CREATE TABLE `data_session` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `img` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `id_session` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

/*Data for the table `data_session` */

/*Table structure for table `macro` */

DROP TABLE IF EXISTS `macro`;

CREATE TABLE `macro` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `macro_name` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `date_init` date DEFAULT NULL,
  `date_finish` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

/*Data for the table `macro` */

/*Table structure for table `micro` */

DROP TABLE IF EXISTS `micro`;

CREATE TABLE `micro` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `micro_name` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `date_init` date DEFAULT NULL,
  `date_finish` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

/*Data for the table `micro` */

/*Table structure for table `planning` */

DROP TABLE IF EXISTS `planning`;

CREATE TABLE `planning` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_planning` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `data_init` date DEFAULT NULL,
  `data_finish` date DEFAULT NULL,
  `id_macro` int(11) DEFAULT NULL,
  `id_micro` int(11) DEFAULT NULL,
  `id_session` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

/*Data for the table `planning` */

/*Table structure for table `roles` */

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT 0,
  `id_team` int(11) DEFAULT 0,
  `role` varchar(20) COLLATE utf8_spanish_ci DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_role_user` (`id_user`),
  KEY `fk_role_team` (`id_team`),
  CONSTRAINT `fk_role_team` FOREIGN KEY (`id_team`) REFERENCES `teams` (`id`),
  CONSTRAINT `fk_role_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

/*Data for the table `roles` */

/*Table structure for table `sessions` */

DROP TABLE IF EXISTS `sessions`;

CREATE TABLE `sessions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `session_name` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

/*Data for the table `sessions` */

/*Table structure for table `teams` */

DROP TABLE IF EXISTS `teams`;

CREATE TABLE `teams` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `team_name` varchar(40) COLLATE utf8_spanish_ci DEFAULT NULL,
  `date` timestamp(1) NOT NULL DEFAULT current_timestamp(1),
  `id_planning` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

/*Data for the table `teams` */

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(36) COLLATE utf8_spanish_ci DEFAULT NULL,
  `lastname` varchar(40) COLLATE utf8_spanish_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `password` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  `telf` varchar(15) COLLATE utf8_spanish_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `img` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `dni` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`username`,`lastname`,`email`,`password`,`telf`,`address`,`img`,`dni`,`birthday`,`date`) values (1,'Jordi','Mier','jordi@gmail.com','$2y$08$t43vWVqAt38aiDHv17YZqeGw4crKB8MuXQDCMPsb9zNLcujALRT9.','123456789','Carre Strong 123 Tatuin','ad43707e0f.png','12345678D','1976-06-15','2019-09-02 16:16:49'),(2,'Antonio','Hernandez','antonio@gmail.com','$2y$10$pqTntVcRp3Df3pPIR0r/WO3KOLSN5EFaKSQ5uRoOq9pQ2WRb3VD.y','123456789','Carre Irish 23 Navu','','12345678E','2019-10-05','2019-09-03 00:50:57'),(3,'Maria','Perez','maria@gmail.com','$2y$10$BKkv6vaJOVHfo/4aKQ2dpe4iVKtbF2nkewTPbVSAOm8rYSmTQuJh6','123456789','Carre First 54 Corusan',NULL,'12345678S','1994-06-15','2019-09-03 01:36:38');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
