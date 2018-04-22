/*
SQLyog v4.05
Host - 5.6.26 : Database - ransomware
*********************************************************************
Server version : 5.6.26
*/


create database if not exists `ransomware`;

USE `ransomware`;

/*Table structure for table `ransomware`.`phish_table` */

drop table if exists `ransomware`.`phish_table`;

CREATE TABLE `phish_table` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `phish_url` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `ransomware`.`phish_table` */

insert into `ransomware`.`phish_table` values (4,'http://streaming-sport.tv/ch/live/di/');
