/*
SQLyog Ultimate v12.09 (64 bit)
MySQL - 10.1.13-MariaDB : Database - rridbdev
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`rridbdev` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `rridbdev`;

/*Table structure for table `pengajuan_dt1` */

DROP TABLE IF EXISTS `pengajuan_dt1`;

CREATE TABLE `pengajuan_dt1` (
  `id_sub` int(11) NOT NULL AUTO_INCREMENT,
  `nopengajuan` varchar(25) DEFAULT NULL,
  `kd_kategori` varchar(10) DEFAULT NULL,
  `kuota` int(11) DEFAULT NULL,
  `ukuran` varchar(25) DEFAULT NULL,
  `keterangan` text,
  PRIMARY KEY (`id_sub`)
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=latin1;

/*Data for the table `pengajuan_dt1` */

insert  into `pengajuan_dt1`(`id_sub`,`nopengajuan`,`kd_kategori`,`kuota`,`ukuran`,`keterangan`) values (51,'P001','K01',35000,'',''),(52,'P001','K02',95000,'',''),(53,'P001','K03',90000,'',''),(55,'P001','K05',65000,'',''),(56,'P001','K06',11400,'',''),(57,'P001','K07',100000,'',''),(58,'P001','K08',4200000,'',''),(59,'P001','K09',3000000,'',''),(60,'P001','K10',32300,'',''),(61,'P002','K11',5000,'',''),(62,'P002','K12',190000,'',''),(63,'P002','K13',130000,'',''),(64,'P002','K14',114000,'',''),(65,'P002','K15',90000,'','');

/*Table structure for table `pengajuan_dt2` */

DROP TABLE IF EXISTS `pengajuan_dt2`;

CREATE TABLE `pengajuan_dt2` (
  `nopengajuan` varchar(25) DEFAULT NULL,
  `id_sub` int(11) DEFAULT NULL,
  `partno` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `pengajuan_dt2` */

insert  into `pengajuan_dt2`(`nopengajuan`,`id_sub`,`partno`) values ('P001',51,'SZ129-034'),('P001',51,'RJB72N-119'),('P001',51,'RB3RHS-137'),('P001',51,'HE28-02A'),('P001',51,'B2B83-10'),('P001',52,'TL-289-001'),('P001',52,'RI-300-004'),('P001',52,'RI-300-003'),('P001',52,'HZQ288A1-04'),('P001',52,'HZQ288A1-03'),('P001',53,'B2B121-1C-2'),('P001',53,'B2B107-1-2'),('P001',53,'B2B121-1-2'),('P001',54,'HS002A1-1-04-Y1'),('P001',54,'RB3G-314X02-HS'),('P001',54,'RSB2-15'),('P001',55,'RSB2-15'),('P001',55,'RB3G-314X02-HS'),('P001',55,'HS002A1-1-04-Y1'),('P001',56,'JK0039-093'),('P001',56,'JK0037-010X01'),('P001',57,'TL-289-005'),('P001',57,'SRJB73S-140BK'),('P001',57,'RJB72N-130'),('P001',57,'JK0039-020S'),('P001',57,'RB3G-213'),('P001',58,'B2B146-02S'),('P001',58,'B2B103-2-3X01'),('P001',58,'HS088A4-1(Y.T)'),('P001',59,'RI52-264'),('P001',59,'RI52-263'),('P001',59,'HE9-02A'),('P001',60,'HZQ291A1-01'),('P001',60,'HZQ290A1-01'),('P001',60,'HZQ288A1-09'),('P001',60,'HZQ288A1-01'),('P002',61,'TL-289-002X01'),('P002',61,'RJB72N-108'),('P002',61,'RJB33N-109'),('P002',61,'RJB33N-119'),('P002',61,'RI-300-005'),('P002',61,'RB3J-157'),('P002',62,'JK0036-006'),('P002',62,'RB3-113'),('P002',62,'SZ129-050'),('P002',62,'RB3J-155'),('P002',63,'C002D-04000-2'),('P002',63,'REY-1246FC-15'),('P002',63,'U271-401'),('P002',63,'CP-60055S-0.85X02'),('P002',64,'JK0039-017'),('P002',64,'JK0039-013'),('P002',64,'B2B121-5-011'),('P002',64,'B2B107-6K'),('P002',65,'HRE0001C6-1X02'),('P002',65,'HRE0001B6-1'),('P002',65,'HRE0001A6-1'),('P002',65,'RB3G-344'),('P002',65,'HZQ288A1-15');

/*Table structure for table `pengajuan_hd` */

DROP TABLE IF EXISTS `pengajuan_hd`;

CREATE TABLE `pengajuan_hd` (
  `idpengajuan` int(11) NOT NULL AUTO_INCREMENT,
  `nopengajuan` varchar(25) NOT NULL,
  `tgl_pengajuan` date DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  `user` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`nopengajuan`),
  KEY `id` (`idpengajuan`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

/*Data for the table `pengajuan_hd` */

insert  into `pengajuan_hd`(`idpengajuan`,`nopengajuan`,`tgl_pengajuan`,`status`,`user`) values (8,'P001','2017-08-30','nonactive','ADMIN'),(9,'P002','2017-09-19','nonactive','ADMIN');

/*Table structure for table `pertek_dt1` */

DROP TABLE IF EXISTS `pertek_dt1`;

CREATE TABLE `pertek_dt1` (
  `id_sub` int(11) NOT NULL,
  `nopertek` varchar(50) DEFAULT NULL,
  `kd_kategori` varchar(10) DEFAULT NULL,
  `kuota` int(11) DEFAULT NULL,
  `sisa_kuota` int(11) DEFAULT NULL,
  `ukuran` varchar(25) DEFAULT NULL,
  `keterangan` text,
  PRIMARY KEY (`id_sub`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `pertek_dt1` */

insert  into `pertek_dt1`(`id_sub`,`nopertek`,`kd_kategori`,`kuota`,`sisa_kuota`,`ukuran`,`keterangan`) values (51,'PERTEK-2017-09-0002','K01',35000,35000,'',''),(52,'PERTEK-2017-09-0002','K02',95000,95000,'',''),(53,'PERTEK-2017-09-0002','K03',90000,90000,'',''),(55,'PERTEK-2017-09-0002','K05',65000,65000,'',''),(56,'PERTEK-2017-09-0002','K06',11400,11400,'',''),(57,'PERTEK-2017-09-0002','K07',100000,100000,'',''),(58,'PERTEK-2017-09-0002','K08',4200000,4200000,'',''),(59,'PERTEK-2017-09-0002','K09',3000000,3000000,'',''),(60,'PERTEK-2017-09-0002','K10',32300,32300,'',''),(61,'PERTEK-2017-09-0001','K11',5000,5000,'',''),(62,'PERTEK-2017-09-0001','K12',190000,190000,'',''),(63,'PERTEK-2017-09-0001','K13',130000,130000,'',''),(64,'PERTEK-2017-09-0001','K14',114000,114000,'',''),(65,'PERTEK-2017-09-0001','K15',90000,90000,'','');

/*Table structure for table `pertek_dt2` */

DROP TABLE IF EXISTS `pertek_dt2`;

CREATE TABLE `pertek_dt2` (
  `nopertek` varchar(50) DEFAULT NULL,
  `id_sub` int(11) DEFAULT NULL,
  `partno` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `pertek_dt2` */

insert  into `pertek_dt2`(`nopertek`,`id_sub`,`partno`) values ('PERTEK-2017-09-0001',61,'TL-289-002X01'),('PERTEK-2017-09-0001',61,'RJB72N-108'),('PERTEK-2017-09-0001',61,'RJB33N-109'),('PERTEK-2017-09-0001',61,'RJB33N-119'),('PERTEK-2017-09-0001',61,'RI-300-005'),('PERTEK-2017-09-0001',61,'RB3J-157'),('PERTEK-2017-09-0001',62,'JK0036-006'),('PERTEK-2017-09-0001',62,'RB3-113'),('PERTEK-2017-09-0001',62,'SZ129-050'),('PERTEK-2017-09-0001',62,'RB3J-155'),('PERTEK-2017-09-0001',63,'C002D-04000-2'),('PERTEK-2017-09-0001',63,'REY-1246FC-15'),('PERTEK-2017-09-0001',63,'U271-401'),('PERTEK-2017-09-0001',63,'CP-60055S-0.85X02'),('PERTEK-2017-09-0001',64,'JK0039-017'),('PERTEK-2017-09-0001',64,'JK0039-013'),('PERTEK-2017-09-0001',64,'B2B121-5-011'),('PERTEK-2017-09-0001',64,'B2B107-6K'),('PERTEK-2017-09-0001',65,'HRE0001C6-1X02'),('PERTEK-2017-09-0001',65,'HRE0001B6-1'),('PERTEK-2017-09-0001',65,'HRE0001A6-1'),('PERTEK-2017-09-0001',65,'RB3G-344'),('PERTEK-2017-09-0001',65,'HZQ288A1-15'),('PERTEK-2017-09-0002',51,'SZ129-034'),('PERTEK-2017-09-0002',51,'RJB72N-119'),('PERTEK-2017-09-0002',51,'RB3RHS-137'),('PERTEK-2017-09-0002',51,'HE28-02A'),('PERTEK-2017-09-0002',51,'B2B83-10'),('PERTEK-2017-09-0002',52,'TL-289-001'),('PERTEK-2017-09-0002',52,'RI-300-004'),('PERTEK-2017-09-0002',52,'RI-300-003'),('PERTEK-2017-09-0002',52,'HZQ288A1-04'),('PERTEK-2017-09-0002',52,'HZQ288A1-03'),('PERTEK-2017-09-0002',53,'B2B121-1C-2'),('PERTEK-2017-09-0002',53,'B2B107-1-2'),('PERTEK-2017-09-0002',53,'B2B121-1-2'),('PERTEK-2017-09-0002',54,'HS002A1-1-04-Y1'),('PERTEK-2017-09-0002',54,'RB3G-314X02-HS'),('PERTEK-2017-09-0002',54,'RSB2-15'),('PERTEK-2017-09-0002',55,'RSB2-15'),('PERTEK-2017-09-0002',55,'RB3G-314X02-HS'),('PERTEK-2017-09-0002',55,'HS002A1-1-04-Y1'),('PERTEK-2017-09-0002',56,'JK0039-093'),('PERTEK-2017-09-0002',56,'JK0037-010X01'),('PERTEK-2017-09-0002',57,'TL-289-005'),('PERTEK-2017-09-0002',57,'SRJB73S-140BK'),('PERTEK-2017-09-0002',57,'RJB72N-130'),('PERTEK-2017-09-0002',57,'JK0039-020S'),('PERTEK-2017-09-0002',57,'RB3G-213'),('PERTEK-2017-09-0002',58,'B2B146-02S'),('PERTEK-2017-09-0002',58,'B2B103-2-3X01'),('PERTEK-2017-09-0002',58,'HS088A4-1(Y.T)'),('PERTEK-2017-09-0002',59,'RI52-264'),('PERTEK-2017-09-0002',59,'RI52-263'),('PERTEK-2017-09-0002',59,'HE9-02A'),('PERTEK-2017-09-0002',60,'HZQ291A1-01'),('PERTEK-2017-09-0002',60,'HZQ290A1-01'),('PERTEK-2017-09-0002',60,'HZQ288A1-09'),('PERTEK-2017-09-0002',60,'HZQ288A1-01');

/*Table structure for table `pertek_hd` */

DROP TABLE IF EXISTS `pertek_hd`;

CREATE TABLE `pertek_hd` (
  `idpertek` int(11) NOT NULL AUTO_INCREMENT,
  `nopertek` varchar(50) NOT NULL,
  `nopengajuan` varchar(25) NOT NULL,
  `tgl_mulai` date DEFAULT NULL,
  `tgl_exp` date DEFAULT NULL,
  `user` varchar(20) DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`nopertek`,`nopengajuan`),
  KEY `idpertek` (`idpertek`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Data for the table `pertek_hd` */

insert  into `pertek_hd`(`idpertek`,`nopertek`,`nopengajuan`,`tgl_mulai`,`tgl_exp`,`user`,`status`) values (7,'PERTEK-2017-09-0001','P002','2017-09-20','2018-03-20','ADMIN','active'),(8,'PERTEK-2017-09-0002','P001','2017-09-26','2018-03-26','ADMIN','active');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
