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

/*Table structure for table `eimportdt` */

DROP TABLE IF EXISTS `eimportdt`;

CREATE TABLE `eimportdt` (
  `noinvoice` varchar(25) DEFAULT NULL,
  `partno` varchar(35) DEFAULT NULL,
  `qty` int(25) DEFAULT NULL,
  `unit_price` double DEFAULT NULL,
  `kd_curr` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `eimporthd` */

DROP TABLE IF EXISTS `eimporthd`;

CREATE TABLE `eimporthd` (
  `idinvoicehd` int(11) NOT NULL AUTO_INCREMENT,
  `noinvoice` varchar(25) NOT NULL,
  `tglinvoice` date DEFAULT NULL,
  `kd_supplier` varchar(10) DEFAULT NULL,
  `userid` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`noinvoice`),
  KEY `idinvoicehd` (`idinvoicehd`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `invoice_dt` */

DROP TABLE IF EXISTS `invoice_dt`;

CREATE TABLE `invoice_dt` (
  `noinvoice` varchar(25) DEFAULT NULL,
  `nopertek` varchar(50) DEFAULT NULL,
  `kd_kategori` varchar(10) DEFAULT NULL,
  `partno` varchar(35) DEFAULT NULL,
  `qty` int(25) DEFAULT NULL,
  `unit_price` double DEFAULT NULL,
  `kd_curr` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `invoice_hd` */

DROP TABLE IF EXISTS `invoice_hd`;

CREATE TABLE `invoice_hd` (
  `idinvoicehd` int(11) NOT NULL AUTO_INCREMENT,
  `noinvoice` varchar(25) NOT NULL,
  `tgl_invoice` date DEFAULT NULL,
  `tgl_aju` date DEFAULT NULL,
  `noaju` varchar(10) DEFAULT NULL,
  `kd_supplier` varchar(10) DEFAULT NULL,
  `pelabuhan_muat` varchar(20) DEFAULT NULL,
  `negara_asal` varchar(20) DEFAULT NULL,
  `nodaftar_pib` varchar(10) DEFAULT NULL,
  `tgldaftar_pib` date DEFAULT NULL,
  `userid` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`noinvoice`),
  KEY `idinvoicehd` (`idinvoicehd`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `ms_barang` */

DROP TABLE IF EXISTS `ms_barang`;

CREATE TABLE `ms_barang` (
  `partno` varchar(35) NOT NULL,
  `uraian_barang` varchar(250) DEFAULT NULL,
  `nohs` int(10) DEFAULT NULL,
  `satuan` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`partno`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `ms_curr` */

DROP TABLE IF EXISTS `ms_curr`;

CREATE TABLE `ms_curr` (
  `kd_curr` varchar(5) NOT NULL,
  `nama_curr` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`kd_curr`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `ms_kategori` */

DROP TABLE IF EXISTS `ms_kategori`;

CREATE TABLE `ms_kategori` (
  `kd_kategori` varchar(10) NOT NULL,
  `nama_kategori` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`kd_kategori`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `ms_supplier` */

DROP TABLE IF EXISTS `ms_supplier`;

CREATE TABLE `ms_supplier` (
  `kd_supplier` varchar(10) NOT NULL,
  `nama_supplier` varchar(20) DEFAULT NULL,
  `alamat` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`kd_supplier`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `ms_user` */

DROP TABLE IF EXISTS `ms_user`;

CREATE TABLE `ms_user` (
  `username` varchar(10) NOT NULL,
  `password` varchar(50) DEFAULT NULL,
  `full_name` varchar(25) DEFAULT NULL,
  `privilege` varchar(5) DEFAULT NULL,
  `email` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=latin1;

/*Table structure for table `pengajuan_dt2` */

DROP TABLE IF EXISTS `pengajuan_dt2`;

CREATE TABLE `pengajuan_dt2` (
  `nopengajuan` varchar(25) DEFAULT NULL,
  `id_sub` int(11) DEFAULT NULL,
  `partno` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

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

/*Table structure for table `pertek_dt2` */

DROP TABLE IF EXISTS `pertek_dt2`;

CREATE TABLE `pertek_dt2` (
  `nopertek` varchar(50) DEFAULT NULL,
  `id_sub` int(11) DEFAULT NULL,
  `partno` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

/*Table structure for table `query` */

DROP TABLE IF EXISTS `query`;

CREATE TABLE `query` (
  `user` varchar(10) NOT NULL,
  `menu` varchar(50) NOT NULL,
  `query` text NOT NULL,
  PRIMARY KEY (`user`,`menu`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `sequence` */

DROP TABLE IF EXISTS `sequence`;

CREATE TABLE `sequence` (
  `nama_field` varchar(20) NOT NULL,
  `nomor_terakhir` varchar(20) DEFAULT NULL,
  `remark` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`nama_field`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
