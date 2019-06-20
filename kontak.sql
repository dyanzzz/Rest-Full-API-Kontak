/*
SQLyog Ultimate v12.4.3 (32 bit)
MySQL - 10.1.16-MariaDB : Database - kontak
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`kontak` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `kontak`;

/*Table structure for table `telepon` */

DROP TABLE IF EXISTS `telepon`;

CREATE TABLE `telepon` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) NOT NULL,
  `nomor` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

/*Data for the table `telepon` */

insert  into `telepon`(`id`,`nama`,`nomor`) values 
(1,'Orion','08576666762'),
(2,'Mars','08576666770'),
(3,'gogot','654879789'),
(11,'budi','0899910199873'),
(12,'budi','0899910199873'),
(13,'budi','0899910199873'),
(14,'budi','0899910199873'),
(15,'budi','0899910199873'),
(16,'budi','0899910199873'),
(17,'jokoi','087898765678'),
(18,'budi anduk','08777202329');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
