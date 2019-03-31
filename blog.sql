/*
SQLyog Ultimate v12.09 (64 bit)
MySQL - 10.1.36-MariaDB : Database - blog
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`blog` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `blog`;

/*Table structure for table `author_visitor_tables` */

DROP TABLE IF EXISTS `author_visitor_tables`;

CREATE TABLE `author_visitor_tables` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `profile_visited` int(11) DEFAULT NULL,
  `date_visited` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `author_visitor_tables` */

insert  into `author_visitor_tables`(`id`,`user_id`,`profile_visited`,`date_visited`) values (1,2,1,'2019-03-31 07:36:55'),(2,1,1,'2019-03-31 10:24:06'),(3,4,4,'2019-03-31 13:41:13');

/*Table structure for table `custom_user_models` */

DROP TABLE IF EXISTS `custom_user_models`;

CREATE TABLE `custom_user_models` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fullname` varchar(50) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `username` varchar(25) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `photo` varchar(15) DEFAULT NULL,
  `date_last_login` datetime DEFAULT NULL,
  `visitor` int(11) DEFAULT '0',
  `email` varchar(25) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `custom_user_models` */

insert  into `custom_user_models`(`id`,`fullname`,`birthdate`,`username`,`password`,`photo`,`date_last_login`,`visitor`,`email`,`created_at`,`updated_at`) values (4,'Joseph Cruz XCODE','1988-06-06','sep','$2y$10$dI8h9PQBe5ddqPIkY3wwK.qDGPniXihlTeA6KScaNtHv9wd4Fohwa','1554030416.jpeg','2019-03-31 13:36:00',1,'Sephzkytap@gmail.com','2019-03-31 11:06:40',NULL);

/*Table structure for table `like_posts` */

DROP TABLE IF EXISTS `like_posts`;

CREATE TABLE `like_posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `post_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `like_posts` */

insert  into `like_posts`(`id`,`user_id`,`post_id`) values (1,2,2),(2,1,1);

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values (5,'2014_10_12_000000_create_users_table',1),(6,'2014_10_12_100000_create_password_resets_table',1);

/*Table structure for table `password_resets` */

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `password_resets` */

/*Table structure for table `post_models` */

DROP TABLE IF EXISTS `post_models`;

CREATE TABLE `post_models` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `Title` varchar(50) DEFAULT NULL,
  `Body` longtext,
  `date_created` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `visitor_like` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Data for the table `post_models` */

insert  into `post_models`(`id`,`user_id`,`Title`,`Body`,`date_created`,`date_modified`,`visitor_like`) values (2,1,'Android','Today Android Development is a robust.','2019-03-31 07:27:51','2019-03-31 10:21:07',1),(3,4,'Android Application','Today android technology is empowering our daily life today','2019-03-31 13:37:55',NULL,NULL),(4,4,'test 1','test 1','2019-03-31 13:45:47',NULL,NULL),(5,4,'test 2','fwfwafawf','2019-03-31 13:45:59',NULL,NULL),(6,4,'test 3','fawfawfsfw','2019-03-31 13:46:07',NULL,NULL),(7,4,'test 4','fafafwa','2019-03-31 13:46:14',NULL,NULL);

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
