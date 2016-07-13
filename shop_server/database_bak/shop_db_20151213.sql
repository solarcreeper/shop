-- MySQL dump 10.13  Distrib 5.7.9, for Win64 (x86_64)
--
-- Host: localhost    Database: shop_db
-- ------------------------------------------------------
-- Server version	5.7.9-log

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
-- Table structure for table `ciq_order_receive_info`
--

DROP TABLE IF EXISTS `ciq_order_receive_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ciq_order_receive_info` (
  `ciq_order_receive_info_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_no` varchar(30) DEFAULT NULL,
  `original_order_no` varchar(30) NOT NULL,
  `bill_info_no` varchar(30) NOT NULL,
  `eshop_ent_code` varchar(20) DEFAULT NULL,
  `eshop_ent_name` varchar(100) DEFAULT NULL,
  `logistics_ent_code` varchar(20) DEFAULT NULL,
  `logistics_ent_name` varchar(100) DEFAULT NULL,
  `receive_status_code` varchar(4) NOT NULL,
  `receive_date` datetime NOT NULL,
  `memo` varchar(30) DEFAULT NULL,
  `status_code` varchar(4) DEFAULT '暂无数据',
  `op_date` date DEFAULT NULL,
  `audit_memo` varchar(500) DEFAULT '暂无数据',
  PRIMARY KEY (`ciq_order_receive_info_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ciq_order_receive_info`
--

LOCK TABLES `ciq_order_receive_info` WRITE;
/*!40000 ALTER TABLE `ciq_order_receive_info` DISABLE KEYS */;
/*!40000 ALTER TABLE `ciq_order_receive_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ciq_sku_info`
--

DROP TABLE IF EXISTS `ciq_sku_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ciq_sku_info` (
  `ciq_sku_info_id` int(8) NOT NULL AUTO_INCREMENT,
  `eshop_ent_code` varchar(20) NOT NULL,
  `eshop_ent_name` varchar(100) NOT NULL,
  `external_no` varchar(30) DEFAULT NULL,
  `record_id` varchar(30) DEFAULT NULL,
  `sku` varchar(20) NOT NULL,
  `goods_name` varchar(100) NOT NULL,
  `goods_spec` varchar(600) NOT NULL,
  `declare_unit` varchar(2) NOT NULL,
  `post_tax_no` varchar(10) NOT NULL,
  `legal_unit` varchar(4) DEFAULT NULL,
  `conv_legal_unit_num` varchar(30) DEFAULT NULL,
  `hs_code` varchar(10) DEFAULT NULL,
  `in_area_unit` varchar(4) DEFAULT NULL,
  `conv_in_area_unit_num` varchar(30) DEFAULT NULL,
  `is_experiment_goods` varchar(1) NOT NULL,
  `origin_country_code` varchar(4) DEFAULT NULL,
  `is_cnca_por` varchar(1) DEFAULT NULL,
  `cnca_por_doc` longtext,
  `origin_place_cert` longtext,
  `test_report` longtext,
  `legal_ticket` longtext,
  `mark_exchange` longtext,
  `check_org_code` varchar(10) DEFAULT NULL,
  `supplier_name` varchar(200) DEFAULT NULL,
  `producer_name` varchar(200) DEFAULT NULL,
  `is_cnca_por_doc` bit(1) NOT NULL,
  `is_origin_place_cert` bit(1) NOT NULL,
  `is_test_peport` bit(1) NOT NULL,
  `is_legal_ticket` bit(1) NOT NULL,
  `is_mark_exchange` bit(1) NOT NULL,
  `status_code` varchar(20) DEFAULT '暂无数据',
  `op_date` date DEFAULT NULL,
  `memo` varchar(500) DEFAULT '暂无数据',
  `price` double NOT NULL COMMENT '市场价',
  `picture` longtext COMMENT '缩略图',
  `tax_rate` double NOT NULL,
  PRIMARY KEY (`ciq_sku_info_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ciq_sku_info`
--

LOCK TABLES `ciq_sku_info` WRITE;
/*!40000 ALTER TABLE `ciq_sku_info` DISABLE KEYS */;
INSERT INTO `ciq_sku_info` VALUES (1,'50122604E2','诺森比亚进出口贸易公司','',NULL,'50052602BEI000000022','帆布鞋1','Nutrilon 荷兰本土牛栏奶粉1段1','个','06010200','个','1','','','','0','','1','','','','','','','','','\0','\0','\0','\0','\0','暂无数据',NULL,'暂无数据',123,'images/default_thumb.png',0.5);
/*!40000 ALTER TABLE `ciq_sku_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `common_sku_info`
--

DROP TABLE IF EXISTS `common_sku_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_sku_info` (
  `common_sku_info_id` int(8) NOT NULL AUTO_INCREMENT,
  `sku` varchar(60) NOT NULL,
  `goods_name` varchar(120) NOT NULL,
  `goods_spec` varchar(200) NOT NULL,
  `price` double(10,0) NOT NULL,
  `picture` longtext,
  PRIMARY KEY (`common_sku_info_id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `common_sku_info`
--

LOCK TABLES `common_sku_info` WRITE;
/*!40000 ALTER TABLE `common_sku_info` DISABLE KEYS */;
INSERT INTO `common_sku_info` VALUES (1,'20121212','hahaha','hahaha',111,''),(10,'201512100001','特使特1','特1',111,''),(19,'201512100002','帆布鞋2','1',111,''),(21,'201512100009','1','1',111,'images/default_thumb.png'),(22,'201512130001','特13','特13',111,'images/default_thumb.png'),(12,'1234567890','qwertyuiop','工工',8888888,''),(16,'20150001','t1','import',100,'data:image/jpeg;base64,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'),(18,'1','1','1',1,'');
/*!40000 ALTER TABLE `common_sku_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_goods_info`
--

DROP TABLE IF EXISTS `order_goods_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_goods_info` (
  `order_goods_info_id` int(11) NOT NULL AUTO_INCREMENT,
  `original_order_no` varchar(30) NOT NULL,
  `sku` varchar(30) NOT NULL,
  `goods_spec` varchar(200) NOT NULL,
  `currency_code` varchar(4) NOT NULL,
  `price` double NOT NULL,
  `qty` int(8) NOT NULL,
  `goods_fee` double NOT NULL,
  `tax_fee` double NOT NULL,
  `xiyong_f_unit` varchar(6) DEFAULT NULL,
  `xiyong_f_remark_detail` text,
  PRIMARY KEY (`order_goods_info_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_goods_info`
--

LOCK TABLES `order_goods_info` WRITE;
/*!40000 ALTER TABLE `order_goods_info` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_goods_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_payment_info`
--

DROP TABLE IF EXISTS `order_payment_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_payment_info` (
  `order_payment_info_id` int(11) NOT NULL AUTO_INCREMENT,
  `customs_code` varchar(4) NOT NULL,
  `biz_type_code` char(3) NOT NULL,
  `original_order_no` varchar(30) NOT NULL,
  `eshop_ent_code` varchar(20) NOT NULL,
  `eshop_ent_name` varchar(45) NOT NULL,
  `desc_arri_country_code` varchar(4) NOT NULL,
  `ship_tool_code` varchar(4) NOT NULL,
  `receiver_id_no` varchar(20) NOT NULL,
  `receiver_name` varchar(100) NOT NULL,
  `receiver_address` varchar(500) NOT NULL,
  `receiver_tel` varchar(50) NOT NULL,
  `goods_fee` double NOT NULL,
  `tax_fee` double NOT NULL,
  `sortline_id` varchar(50) NOT NULL,
  `transport_fee` varchar(30) DEFAULT NULL,
  `check_type` varchar(1) DEFAULT NULL,
  `order_status_code` varchar(4) DEFAULT '暂无数据',
  `order_op_date` date DEFAULT NULL,
  `order_memo` varchar(30) DEFAULT '暂无数据',
  `bar_code` varchar(200) DEFAULT '暂无数据',
  `payment_id_no` varchar(20) DEFAULT NULL,
  `payment_name` varchar(100) DEFAULT NULL,
  `payment_tel` varchar(50) DEFAULT NULL,
  `payment_ent_code` varchar(30) DEFAULT NULL,
  `payment_ent_name` varchar(30) NOT NULL,
  `payment_no` varchar(30) NOT NULL,
  `pay_amount` varchar(45) NOT NULL,
  `pay_memo` varchar(1000) DEFAULT NULL,
  `payment_status_code` varchar(4) DEFAULT '暂无数据',
  `payment_op_date` date DEFAULT NULL,
  `payment_memo` varchar(30) DEFAULT '暂无数据',
  `xiyong_bill_type` varchar(2) NOT NULL,
  `xiyong_acount_no` varchar(20) NOT NULL,
  `xiyong_cust_no` varchar(10) NOT NULL,
  `xiyong_stock_in_no` varchar(5) NOT NULL,
  `xiyong_stock_out_no` varchar(5) DEFAULT NULL,
  `xiyong_biller_no` varchar(10) DEFAULT NULL,
  `xiyong_checker_no` varchar(10) DEFAULT NULL,
  `xiyong_bill_date` date NOT NULL,
  `xiyong_remark` text,
  `xiyong_discharge_place` varchar(30) DEFAULT NULL,
  `xiyong_deliver_place` varchar(30) DEFAULT '暂无数据',
  `xiyong_province` varchar(20) NOT NULL,
  `xiyong_province_code` varchar(8) NOT NULL,
  `xiyong_city` varchar(20) NOT NULL,
  `xiyong_city_code` varchar(8) NOT NULL,
  `xiyong_area` varchar(20) NOT NULL,
  `xiyong_area_code` varchar(8) NOT NULL,
  `xiyong_zip` varchar(10) NOT NULL,
  `xiyong_type` varchar(1) DEFAULT NULL,
  `xiyong_bjflag` varchar(1) NOT NULL,
  `xiyong_bjamt` double DEFAULT NULL,
  `owner` varchar(45) NOT NULL,
  `send_status` int(1) DEFAULT '0',
  PRIMARY KEY (`order_payment_info_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_payment_info`
--

LOCK TABLES `order_payment_info` WRITE;
/*!40000 ALTER TABLE `order_payment_info` DISABLE KEYS */;
INSERT INTO `order_payment_info` VALUES (4,'8000','I10','201512130001','50122604E2','诺森比亚进出口贸易公司','','5','510111111111111111','zx','四川省成都市','18888888888',12321,0,'SORTLINE01','111','R','暂无数据',NULL,'暂无数据','暂无数据','','','','','111','111','111','','暂无数据',NULL,'暂无数据','2','001','111','01','','','','2015-12-09','','','','北京市','110000','市辖区','110100','','110102','111111','Y','Y',111,'',0);
/*!40000 ALTER TABLE `order_payment_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `sku_info`
--

DROP TABLE IF EXISTS `sku_info`;
/*!50001 DROP VIEW IF EXISTS `sku_info`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `sku_info` AS SELECT 
 1 AS `sku`,
 1 AS `goods_name`,
 1 AS `goods_spec`,
 1 AS `price`,
 1 AS `picture`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `sku_info_with_user`
--

DROP TABLE IF EXISTS `sku_info_with_user`;
/*!50001 DROP VIEW IF EXISTS `sku_info_with_user`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `sku_info_with_user` AS SELECT 
 1 AS `username`,
 1 AS `sku`,
 1 AS `goods_name`,
 1 AS `goods_spec`,
 1 AS `price`,
 1 AS `picture`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `sku_info_with_user_stock`
--

DROP TABLE IF EXISTS `sku_info_with_user_stock`;
/*!50001 DROP VIEW IF EXISTS `sku_info_with_user_stock`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `sku_info_with_user_stock` AS SELECT 
 1 AS `username`,
 1 AS `sku`,
 1 AS `goods_name`,
 1 AS `goods_spec`,
 1 AS `price`,
 1 AS `picture`,
 1 AS `total_stock`,
 1 AS `availble_stock`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `stock`
--

DROP TABLE IF EXISTS `stock`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stock` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sku` varchar(30) DEFAULT NULL,
  `total_stock` int(8) DEFAULT NULL,
  `availble_stock` int(8) DEFAULT NULL,
  `blocked_stock` int(8) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stock`
--

LOCK TABLES `stock` WRITE;
/*!40000 ALTER TABLE `stock` DISABLE KEYS */;
INSERT INTO `stock` VALUES (4,'201512100001',100,1000,0),(6,'1234567890',100000,100000,0),(10,'20150001',100,100,0),(12,'1',1,1,0),(13,'201512100002',111,111,0),(15,'201512100009',1,1,0),(16,'201512130001',111,111,0);
/*!40000 ALTER TABLE `stock` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_goods_data`
--

DROP TABLE IF EXISTS `t_goods_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_goods_data` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `original_order_no` varchar(20) NOT NULL,
  `sku` varchar(60) NOT NULL,
  `goods_name` varchar(120) NOT NULL,
  `goods_spec` varchar(200) NOT NULL,
  `price` double NOT NULL,
  `qty` int(8) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_goods_data`
--

LOCK TABLES `t_goods_data` WRITE;
/*!40000 ALTER TABLE `t_goods_data` DISABLE KEYS */;
INSERT INTO `t_goods_data` VALUES (1,'201512100001','20150001','你才','你才',100,100);
/*!40000 ALTER TABLE `t_goods_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_item_data`
--

DROP TABLE IF EXISTS `t_item_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_item_data` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `sku` varchar(60) NOT NULL,
  `goods_name` varchar(120) NOT NULL,
  `goods_spec` varchar(200) NOT NULL,
  `shop_price` double NOT NULL,
  `stock` smallint(5) NOT NULL,
  `picture` longtext NOT NULL,
  `is_excel` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_item_data`
--

LOCK TABLES `t_item_data` WRITE;
/*!40000 ALTER TABLE `t_item_data` DISABLE KEYS */;
/*!40000 ALTER TABLE `t_item_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_order_data`
--

DROP TABLE IF EXISTS `t_order_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_order_data` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `original_order_no` varchar(20) NOT NULL,
  `receiver_name` varchar(60) NOT NULL,
  `province_name` varchar(120) NOT NULL,
  `city_name` varchar(120) NOT NULL,
  `area_name` varchar(120) NOT NULL,
  `receiver_address` varchar(255) NOT NULL,
  `zip` varchar(60) NOT NULL,
  `tel` varchar(60) NOT NULL,
  `receiver_id_no` varchar(120) NOT NULL,
  `remark` varchar(255) NOT NULL,
  `pay_note` varchar(255) NOT NULL,
  `bill_date` datetime NOT NULL,
  `transport_fee` double NOT NULL,
  `goods_fee` double NOT NULL,
  `is_excel` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_order_data`
--

LOCK TABLES `t_order_data` WRITE;
/*!40000 ALTER TABLE `t_order_data` DISABLE KEYS */;
INSERT INTO `t_order_data` VALUES (1,'201512100001','叶虹江','四川省','成都市','双流县','四川省。。。。','611011','888888888','5111111111111','没有','没有','2015-12-10 00:00:00',10000,10000,0);
/*!40000 ALTER TABLE `t_order_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `test`
--

DROP TABLE IF EXISTS `test`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `test` (
  `test_id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text,
  PRIMARY KEY (`test_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `test`
--

LOCK TABLES `test` WRITE;
/*!40000 ALTER TABLE `test` DISABLE KEYS */;
/*!40000 ALTER TABLE `test` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `token`
--

DROP TABLE IF EXISTS `token`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `token` (
  `token_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL,
  `content` varchar(32) NOT NULL,
  `update_time` datetime NOT NULL,
  PRIMARY KEY (`token_id`,`content`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `token`
--

LOCK TABLES `token` WRITE;
/*!40000 ALTER TABLE `token` DISABLE KEYS */;
INSERT INTO `token` VALUES (1,'yehongjiang','de374e1cb6fe2f68a5f94e904e05f4cd','2015-12-09 12:14:57'),(2,'yehongjiang','69a8b6176a89a571002dbeae01c272e4','2015-12-09 10:46:38'),(3,'yehongjiang','62e258635e64a9def33c8fe2fdbab3bc','2015-12-09 10:47:18'),(4,'yehongjiang','c29acf494d0e3f8a8381885a51f6bb56','2015-12-09 10:47:39'),(5,'TESTER','qwertyuiop1234567890','2015-12-13 12:51:46'),(6,'TESTER','19b4ffb9266c8ab2052213303e4940df','2015-12-11 16:38:18'),(7,'TESTER','450916e3d2f55f2a03d0084f038ff36c','2015-12-11 16:40:05'),(8,'TESTER','885ca24d48cade37bbbf72cc9184edc7','2015-12-11 16:45:42'),(9,'TESTER','1b0f75e557b53752f9e4a442be7a4f81','2015-12-13 10:48:41'),(10,'yehongjiang','35366601922126edc52c5d8dbd998db4','2015-12-13 10:52:30'),(11,'yehongjiang','9df873587c9ba7b1334fed0003985ea0','2015-12-13 11:19:11'),(12,'TESTER','18f2d6b204d74da029e1332ecdcfebd2','2015-12-13 11:57:48'),(13,'yehongjiang','167ab34477fd3ed9f8b29d8f53a6d3f6','2015-12-13 13:34:55'),(14,'TESTER','ab8e8285e76ada3b4e338e4532056bf6','2015-12-13 13:33:22');
/*!40000 ALTER TABLE `token` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `user_id` int(5) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `real_name` varchar(45) NOT NULL,
  `email` varchar(128) DEFAULT NULL,
  `mobile` varchar(15) NOT NULL,
  `address` varchar(128) DEFAULT NULL,
  `discount` double NOT NULL DEFAULT '1',
  `is_admin` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'TESTER','123','',NULL,'',NULL,1,''),(3,'yehongjiang','123','yehongjiang','','18888888888','',0.11,'\0');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_product`
--

DROP TABLE IF EXISTS `user_product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_product` (
  `user_pro_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL,
  `sku_id` varchar(45) NOT NULL,
  PRIMARY KEY (`user_pro_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_product`
--

LOCK TABLES `user_product` WRITE;
/*!40000 ALTER TABLE `user_product` DISABLE KEYS */;
INSERT INTO `user_product` VALUES (5,'TESTER','201512100001'),(7,'TESTER','1234567890'),(11,'TESTER','20150001'),(13,'TESTER','1'),(14,'TESTER','201512100002'),(15,'yehongjiang','201512100001'),(17,'TESTER','201512100009'),(18,'TESTER','201512130001');
/*!40000 ALTER TABLE `user_product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `xiyong_purchase`
--

DROP TABLE IF EXISTS `xiyong_purchase`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xiyong_purchase` (
  `purchase_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `f_account_no` varchar(10) NOT NULL,
  `f_erp_order_bill_no` varchar(45) NOT NULL,
  `f_erp_bill_no` varchar(60) NOT NULL,
  `f_cust_no` varchar(45) NOT NULL,
  `f_biller_no` varchar(15) NOT NULL,
  `f_biller_p_no` varchar(15) NOT NULL,
  `f_checker_no` varchar(15) NOT NULL,
  `f_bill_date` date NOT NULL,
  `f_remark` text,
  `custname` varchar(100) NOT NULL,
  `linkman` varchar(20) NOT NULL,
  `tel` varchar(15) NOT NULL,
  `deliver_no` varchar(30) DEFAULT NULL,
  `deliver_name` varchar(30) DEFAULT NULL,
  `deliver_time` date DEFAULT NULL,
  `arrive_time` date DEFAULT NULL,
  `qty` int(8) NOT NULL,
  `unit` varchar(10) NOT NULL,
  `flag` int(1) NOT NULL DEFAULT '-1',
  PRIMARY KEY (`purchase_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xiyong_purchase`
--

LOCK TABLES `xiyong_purchase` WRITE;
/*!40000 ALTER TABLE `xiyong_purchase` DISABLE KEYS */;
/*!40000 ALTER TABLE `xiyong_purchase` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `xiyong_purchase_product`
--

DROP TABLE IF EXISTS `xiyong_purchase_product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xiyong_purchase_product` (
  `product_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `f_erp_bill_no` varchar(60) NOT NULL,
  `f_icno` varchar(60) NOT NULL,
  `f_unit` varchar(60) NOT NULL,
  `f_price` double NOT NULL,
  `f_qty` int(8) NOT NULL,
  `f_amount` double DEFAULT NULL,
  `f_pro_date` date DEFAULT NULL,
  `f_out_date` date DEFAULT NULL,
  `f_block_no` varchar(30) DEFAULT NULL,
  `f_remark_dtail` text,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xiyong_purchase_product`
--

LOCK TABLES `xiyong_purchase_product` WRITE;
/*!40000 ALTER TABLE `xiyong_purchase_product` DISABLE KEYS */;
/*!40000 ALTER TABLE `xiyong_purchase_product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Final view structure for view `sku_info`
--

/*!50001 DROP VIEW IF EXISTS `sku_info`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `sku_info` AS select `common_sku_info`.`sku` AS `sku`,`common_sku_info`.`goods_name` AS `goods_name`,`common_sku_info`.`goods_spec` AS `goods_spec`,`common_sku_info`.`price` AS `price`,`common_sku_info`.`picture` AS `picture` from `common_sku_info` union select `ciq_sku_info`.`sku` AS `sku`,`ciq_sku_info`.`goods_name` AS `goods_name`,`ciq_sku_info`.`goods_spec` AS `goods_spec`,`ciq_sku_info`.`price` AS `price`,`ciq_sku_info`.`picture` AS `picture` from `ciq_sku_info` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `sku_info_with_user`
--

/*!50001 DROP VIEW IF EXISTS `sku_info_with_user`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `sku_info_with_user` AS select `user_product`.`username` AS `username`,`sku_info`.`sku` AS `sku`,`sku_info`.`goods_name` AS `goods_name`,`sku_info`.`goods_spec` AS `goods_spec`,`sku_info`.`price` AS `price`,`sku_info`.`picture` AS `picture` from (`user_product` left join `sku_info` on((`user_product`.`sku_id` = `sku_info`.`sku`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `sku_info_with_user_stock`
--

/*!50001 DROP VIEW IF EXISTS `sku_info_with_user_stock`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `sku_info_with_user_stock` AS select `sku_info_with_user`.`username` AS `username`,`sku_info_with_user`.`sku` AS `sku`,`sku_info_with_user`.`goods_name` AS `goods_name`,`sku_info_with_user`.`goods_spec` AS `goods_spec`,`sku_info_with_user`.`price` AS `price`,`sku_info_with_user`.`picture` AS `picture`,`stock`.`total_stock` AS `total_stock`,`stock`.`availble_stock` AS `availble_stock` from (`sku_info_with_user` left join `stock` on((`sku_info_with_user`.`sku` = `stock`.`sku`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-12-13 13:38:52
