-- MySQL dump 10.13  Distrib 5.6.23, for Win64 (x86_64)
--
-- Host: localhost    Database: transfer
-- ------------------------------------------------------
-- Server version	5.6.25-log

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
-- Table structure for table `order_bar_code_fb`
--

DROP TABLE IF EXISTS `order_bar_code_fb`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_bar_code_fb` (
  `order_bar_fb_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_no` varchar(30) DEFAULT NULL,
  `original_order_no` varchar(30) DEFAULT NULL,
  `bar_code` varchar(200) DEFAULT NULL,
  `op_date` datetime DEFAULT NULL,
  PRIMARY KEY (`order_bar_fb_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_bar_code_fb`
--

LOCK TABLES `order_bar_code_fb` WRITE;
/*!40000 ALTER TABLE `order_bar_code_fb` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_bar_code_fb` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_info_fb`
--

DROP TABLE IF EXISTS `order_info_fb`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_info_fb` (
  `oder_fb_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_no` varchar(30) DEFAULT NULL,
  `original_order_no` varchar(30) DEFAULT NULL,
  `status_code` varchar(2) DEFAULT NULL,
  `op_date` datetime DEFAULT NULL,
  `memo` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`oder_fb_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_info_fb`
--

LOCK TABLES `order_info_fb` WRITE;
/*!40000 ALTER TABLE `order_info_fb` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_info_fb` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment_info_fb`
--

DROP TABLE IF EXISTS `payment_info_fb`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payment_info_fb` (
  `payment_fb_id` int(11) NOT NULL AUTO_INCREMENT,
  `payment_no` varchar(30) DEFAULT NULL,
  `status_code` varchar(2) DEFAULT NULL,
  `op_date` datetime DEFAULT NULL,
  `memo` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`payment_fb_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_info_fb`
--

LOCK TABLES `payment_info_fb` WRITE;
/*!40000 ALTER TABLE `payment_info_fb` DISABLE KEYS */;
/*!40000 ALTER TABLE `payment_info_fb` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `repertory`
--

DROP TABLE IF EXISTS `repertory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `repertory` (
  `r_id` int(12) NOT NULL AUTO_INCREMENT,
  `original_order_no` varchar(30) DEFAULT NULL,
  `order_code` varchar(50) DEFAULT NULL,
  `hb_bar_code` varchar(50) DEFAULT NULL,
  `print_msg` varchar(50) DEFAULT NULL,
  `order_tax` varchar(50) DEFAULT NULL,
  `plat_from_name` varchar(50) DEFAULT NULL,
  `shop_name` varchar(50) DEFAULT NULL,
  `order_status` varchar(100) DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL,
  `create_date` varchar(50) DEFAULT NULL,
  `update_date` varchar(50) DEFAULT NULL,
  `pay_time` varchar(20) DEFAULT NULL,
  `logistics_company_name` varchar(20) DEFAULT NULL,
  `logistics_company_code` varchar(20) DEFAULT NULL,
  `logistics_number` varchar(50) DEFAULT NULL,
  `post_price` varchar(50) DEFAULT NULL,
  `is_delivery_pay` varchar(50) DEFAULT NULL,
  `bunick` varchar(50) DEFAULT NULL,
  `invoice_name` varchar(200) DEFAULT NULL,
  `invoice_type` varchar(200) DEFAULT NULL,
  `invoice_content` varchar(500) DEFAULT NULL,
  `sellers_message` varchar(500) DEFAULT NULL,
  `buyer_message` varchar(500) DEFAULT NULL,
  `merchant_message` varchar(50) DEFAULT NULL,
  `amount_receivable` varchar(50) DEFAULT NULL,
  `actual_payment` varchar(50) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `mobile_phone` varchar(50) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `province` varchar(50) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `district` varchar(50) DEFAULT NULL,
  `zip` varchar(50) DEFAULT NULL,
  `order_detail_code` varchar(50) DEFAULT NULL,
  `sku_id` varchar(50) DEFAULT NULL,
  `outer_sku_id` varchar(50) DEFAULT NULL,
  `num` varchar(50) DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL,
  `price` varchar(50) DEFAULT NULL,
  `payment` varchar(50) DEFAULT NULL,
  `discount_price` varchar(50) DEFAULT NULL,
  `total_price` varchar(50) DEFAULT NULL,
  `adjust_price` varchar(50) DEFAULT NULL,
  `divide_order_price` varchar(50) DEFAULT NULL,
  `bill_price` varchar(50) DEFAULT NULL,
  `part_mjz_discount` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`r_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `repertory`
--

LOCK TABLES `repertory` WRITE;
/*!40000 ALTER TABLE `repertory` DISABLE KEYS */;
INSERT INTO `repertory` VALUES (1,'130895725945867671','undefined','','','0','重庆诺森比亚进出口贸易公司','重庆诺森比亚进出口贸易公司','WAIT_SELLER_SEND_GOODS','Fixed','2014-10-8 10:30:28','2014-10-8 10:30:28','2014-10-8 10:30:28','圆通速递','YTO','0','0.00','false','林生','','','','','','','134.00','134.00','林生','0592-55555555','13400998080','福建省厦门市思明区软件园二期61号3楼','福建','厦门市','思明区','362114','130895725945867671_1','581336618001','345','1','361度女鞋正品2014新款时尚休闲板鞋轻便运动鞋韩版潮','134.00','134','0','134','0','0','0','0'),(2,'130895725977968961','undefined','','','310','重庆诺森比亚进出口贸易公司','重庆诺森比亚进出口贸易公司','WAIT_SELLER_SEND_GOODS','Fixed','2014-10-8 10:09:53','2014-10-8 10:09:53','2014-10-8 10:09:53','圆通速递','YTO','0','0.00','false','1111','','','','','','','3100.00','3100.00','张三','0591-83333333','15909090909','福建省 福州市 台江区 六一中路249号 电子商务部','福建','福州市','台江区','350001','130895725977968961_1','581336618001','345','10','361度女鞋正品2014新款时尚休闲板鞋轻便运动鞋韩版潮','160.00','1600','0','1600','0','0','0','0'),(3,'130895726001470059','undefined','','','0','重庆诺森比亚进出口贸易公司','重庆诺森比亚进出口贸易公司','WAIT_SELLER_SEND_GOODS','Fixed','2014-10-31 9:43:16','2014-10-31 9:43:16','2014-10-31 9:43:16','邮政EMS','EMS','0','0.00','false','测试','','','','','','','134.00','134.00','测试','','12345678901','福建厦门湖里','福建','厦门市','湖里区','362114','130895726001470059_1','581336618001','345','1','361度女鞋正品2014新款时尚休闲板鞋轻便运动鞋韩版潮','134.00','134','0','134','0','0','0','0'),(4,'130896083898445300','undefined','','','0','重庆诺森比亚进出口贸易公司','重庆诺森比亚进出口贸易公司','WAIT_SELLER_SEND_GOODS','Fixed','2014-9-26 14:42:11','2014-9-26 14:42:11','2014-9-26 14:42:11','邮政EMS','EMS','0','0.00','false','123456','','','','','','','160.00','160.00','李四','','13345678909','湖北省 武汉市 洪山区 珞瑜东路1102号','湖北','武汉市','洪山区','410000','130896083898445300_1','581336618001','667','1','361度女鞋正品2014新款时尚休闲板鞋轻便运动鞋韩版潮','160.00','160','0','160','0','0','0','0');
/*!40000 ALTER TABLE `repertory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `test`
--

DROP TABLE IF EXISTS `test`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `test` (
  `test_id` int(4) NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL,
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
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-10-18 10:42:10
