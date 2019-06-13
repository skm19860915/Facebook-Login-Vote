/*
SQLyog Professional v12.4.1 (64 bit)
MySQL - 5.7.24 : Database - db_a47e9f_art
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`db_a47e9f_art` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `db_a47e9f_art`;

/*Table structure for table `artists` */

DROP TABLE IF EXISTS `artists`;

CREATE TABLE `artists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `photo` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `register_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `artists` */

insert  into `artists`(`id`,`email`,`name`,`photo`,`register_date`) values 
(1,'elena@col.com','Elena Invana',NULL,'2019-05-05'),
(2,'peter@yandex.com','Peter Rodrigo',NULL,'2019-02-10'),
(3,'eugene@sharemycoach.com','Eugene Elder',NULL,'2014-12-16'),
(4,'victor@gmail.com','Victor Pinkuchuk',NULL,'2016-10-09'),
(5,'joehill@kingofthe.com','Joe Hill',NULL,'2013-11-19'),
(6,'anna@rose.com','Anna Frank',NULL,'2017-08-26'),
(7,'jacky@365.com','Jacky Ma',NULL,'2018-01-31'),
(8,'stomy@flowers.com','Stomy Daniel',NULL,'2018-02-10'),
(9,'tayler@mail.com','Tayler Swift',NULL,'2013-05-15'),
(10,'wang@dong.com','Wang Min',NULL,'2014-10-25'),
(11,'michael@gmail.com','Michael Zhang',NULL,'2019-05-24');

/*Table structure for table `pictures` */

DROP TABLE IF EXISTS `pictures`;

CREATE TABLE `pictures` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `artist_id` int(11) NOT NULL,
  `name` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description_1` text COLLATE utf8_unicode_ci,
  `description_2` text COLLATE utf8_unicode_ci,
  `path` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pending_status` tinyint(1) NOT NULL DEFAULT '0',
  `votes` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `artist_id` (`artist_id`),
  CONSTRAINT `pictures_ibfk_1` FOREIGN KEY (`artist_id`) REFERENCES `artists` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `pictures` */

insert  into `pictures`(`id`,`artist_id`,`name`,`description_1`,`description_2`,`path`,`pending_status`,`votes`) values 
(5,8,'2.jpg','hhhhhhhhhhhhhhhh ........','scrambled it to make a type specimen book. Lorem Ipsum is simply dummy text of the printing and typesetting industry','upload',0,1),
(6,6,'3.jpg','mmmmmmmmmm ........','it is to make a type specimen book. Lorem Ipsum is simply dummy text of the printing.','upload',1,9),
(7,10,'4.jpg','qwqwqwqwqwqwqwqwqwqwqw ........','action is louder that words. Ipsum is simply dummy text of the printing.','upload',0,40),
(8,5,'5.jpg','dddddddddddddddddddddd ........','that words. kkkkkkkkk is simply dummy text of the printing.','upload',0,17),
(9,7,'6.jpg','UUUUUUUUUUUUUUU ........','hey hey heyyyyy is simply dummy text of the printing.','upload',1,2),
(10,9,'7.jpg','Please contact me ........','welcome to visit my business. good is simply dummy text of the printing.','upload',1,52),
(13,8,'9.jpg','Must build a Responsive mockup','After you mockup has been completed and approved, you will submit a fixed bid to complete the Programming and connections to our web services.','upload',1,1),
(15,4,'11.jpg','approved the milestone','oe and I met with Tom (Graphics) guy and had a meeting early Sunday morning. Tom is working on the graphics today (Monday morning). I will keep you posted.','upload',1,1),
(22,3,'12.jpg','4r44ttgrrrtr','is simply dummy text of the printing and typesetting indust','upload',1,15),
(52,11,'efe.jpg','Best Luxury Large Cars','Luxury large cars are great if you want a full-size car that has an opulent interior with the latest technology features. The best luxury large cars are listed below.','upload',0,0),
(59,11,'Capture.PNG','The standard font Material Design uses ','Roboto has been refined extensively to work across the wider set of supported platforms. It is slightly wider and rounder, giving it greater clarity and making it more optimistic.','upload',0,0),
(63,2,'10.jpg','34343434','bregwefwfwefwefewfewfewfewfefe','upload',1,0),
(64,11,'aa.jpg','我很高兴','We are an experienced team who naturally go beyond the calls of duty. As you define your problems, our team starts breathing life to the best solutions using modern and tested tools in the industry','upload',0,0),
(65,11,'fail.PNG','Fail','dddddddddddddddddd','upload',0,0),
(66,11,'test.jpg','tete','fefefefedssdfasdfsdfs','upload',0,0),
(67,11,'tiger.jpg','Very good Picture haha','I am Looking for an experienced ASP.NET and DevExtreme developer using the latest version 16.x/17. Must have their own DevExpress subscription.\r\n','upload',0,0),
(69,11,'fixed.PNG','dwwdw','dwdwdwdww','upload',0,0);

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`username`,`password`) values 
(1,'admin','202cb962ac59075b964b07152d234b70');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
