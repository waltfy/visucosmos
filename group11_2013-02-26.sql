# ************************************************************
# Sequel Pro SQL dump
# Version 3408
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.1.63-0+squeeze1)
# Database: group11
# Generation Time: 2013-02-26 17:04:11 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table data
# ------------------------------------------------------------

DROP TABLE IF EXISTS `data`;

CREATE TABLE `data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data_set_id` int(11) DEFAULT NULL,
  `line_type` char(1) NOT NULL DEFAULT 'L',
  `attr1` varchar(140) DEFAULT NULL,
  `attr2` varchar(140) DEFAULT NULL,
  `attr3` varchar(140) DEFAULT NULL,
  `attr4` varchar(140) DEFAULT NULL,
  `attr5` varchar(140) DEFAULT NULL,
  `attr6` varchar(140) DEFAULT NULL,
  `attr7` varchar(140) DEFAULT NULL,
  `attr8` varchar(140) DEFAULT NULL,
  `attr9` varchar(140) DEFAULT NULL,
  `attr10` varchar(140) DEFAULT NULL,
  `attr11` varchar(140) DEFAULT NULL,
  `attr12` varchar(140) DEFAULT NULL,
  `attr13` varchar(140) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `data` WRITE;
/*!40000 ALTER TABLE `data` DISABLE KEYS */;

INSERT INTO `data` (`id`, `data_set_id`, `line_type`, `attr1`, `attr2`, `attr3`, `attr4`, `attr5`, `attr6`, `attr7`, `attr8`, `attr9`, `attr10`, `attr11`, `attr12`, `attr13`)
VALUES
	(2,1,'H','Timestamp','Tweet ID','Gender','Positive Sentiment','Negative Sentiment','Latitude','Longitude','Location','Tweet Text',NULL,NULL,NULL,NULL),
	(3,1,'L','1341133625','219356424306827000','M','4','-1','-','-','Addingham, Yorkshire, UK','@IsobelPooley After watching you at Birmngm my new athlete to follow. Love the passion, enthusiasm and big smiles!! Long may it last #TeamGB',NULL,NULL,NULL,NULL),
	(4,1,'L','1341137299','219371834213285000','F','1','-3','-','-','Cardiff','RT @GarethFishlock: #TeamGB rejects @JessFishlock &amp; Beckham both get MoM at the w/e, &amp; both bang in a free-kick! #Fishlockfortea ...',NULL,NULL,NULL,NULL),
	(5,1,'L','1341148349','219418181276676000','?','3','-1','-','-','England','RT @abidaviesss: 4hours of althletics! ohh i love the bbc #europeanchamps #teamgb',NULL,NULL,NULL,NULL),
	(6,1,'L','1341172561','219519733748342000','M','3','-1','-','-','On Tour in UK','Love the new London 2012 Titles #TeamGB BBC London 2012 Olympics titles http://t.co/7K2KbwUG',NULL,NULL,NULL,NULL),
	(7,1,'L','1341237825','219793466606100000','?','1','-1','-','-','-','13 English players and 5 welsh in #TeamGB. No Scots or Northern Irish players',NULL,NULL,NULL,NULL),
	(8,1,'L','1341238082','219794544546418000','M','3','-2','-','-','worsley, manchester','I hope #teamGB football crash and burn, no becks... Stuart Pearce should be sacked, what a joke. Beckham &gt; GB!!',NULL,NULL,NULL,NULL),
	(9,1,'L','1341238317','219795530212057000','U','1','-1','-','-','Gainsborough','I think McLean from Sunderland should of had a crack at #TeamGB',NULL,NULL,NULL,NULL),
	(10,1,'L','1341238481','219796218065330000','U','3','-1','-','-','Essex','RT @MA_Fox: James Tomkins #TeamGB love that!',NULL,NULL,NULL,NULL),
	(12,1,'T','time','longint','string','int','float','geo',NULL,'string','string',NULL,NULL,NULL,NULL);

/*!40000 ALTER TABLE `data` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table data_sets
# ------------------------------------------------------------

DROP TABLE IF EXISTS `data_sets`;

CREATE TABLE `data_sets` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `data_sets` WRITE;
/*!40000 ALTER TABLE `data_sets` DISABLE KEYS */;

INSERT INTO `data_sets` (`id`, `name`, `description`)
VALUES
	(1,'Olympic Data','');

/*!40000 ALTER TABLE `data_sets` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table graphs
# ------------------------------------------------------------

DROP TABLE IF EXISTS `graphs`;

CREATE TABLE `graphs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `graph_name` varchar(50) NOT NULL DEFAULT '',
  `type` varchar(50) NOT NULL DEFAULT '',
  `function` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `graphs` WRITE;
/*!40000 ALTER TABLE `graphs` DISABLE KEYS */;

INSERT INTO `graphs` (`id`, `graph_name`, `type`, `function`)
VALUES
	(1,'Pie Chart','float, int','pieChart'),
	(2,'Bar Chart','float, int','barChart'),
	(3,'Word Cloud','string','wordCloud');

/*!40000 ALTER TABLE `graphs` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table scores
# ------------------------------------------------------------

DROP TABLE IF EXISTS `scores`;

CREATE TABLE `scores` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `wordcloud` int(11) DEFAULT NULL,
  `piechart` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `scores` WRITE;
/*!40000 ALTER TABLE `scores` DISABLE KEYS */;

INSERT INTO `scores` (`id`, `user_id`, `wordcloud`, `piechart`)
VALUES
	(1,1,10,1);

/*!40000 ALTER TABLE `scores` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(200) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(200) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `is_admin` char(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `username`, `password`, `email`, `created_at`, `updated_at`, `is_admin`)
VALUES
	(1,'c1001984','$2a$08$Ewt.9CcI6P3Mi07oT7t/vuKO7.4Fn3xEbdaFQyIU72cxD8ypyKk3C','waltervascarvalho@gmail.com','0000-00-00 00:00:00','2013-02-07 16:30:35','Y'),
	(7,'c1110029','$2a$08$Kw2g8zVxQmafWEJYDdO.xezcAWZF/65eCp6AqpKATV2KwhH7nK/KO','m.a.muhit@hotmail.com','2013-02-07 13:06:17','2013-02-07 13:12:53','N'),
	(8,'c0933521','$2a$08$40hHlDuPwNrCn3bPPBYyYehdEm3ZusfMSK5CzcLLQw47Q47p5q0J6','jamiemacdonald66@gmail.com','2013-02-07 13:08:06','2013-02-07 13:08:06','N'),
	(9,'c1119505','$2a$08$IIQ0ztJK2KioyPBdaj5pQOe633p8IM9BN/tWYDDqlNUKaBjNdcsG2','452nad@gmail.com','2013-02-07 13:09:47','2013-02-14 07:29:42','N'),
	(10,'c1116216','$2a$08$PZx9JRCAwrYvKSxlEjY0OOFZQ0d.XjNymNFkSL6oOqiUZrW6l338K','uk.andrew.w@gmail.com','2013-02-07 13:10:37','2013-02-25 12:32:04','N'),
	(13,'c1109949','$2a$08$dwdblS5yjCnr1lJSFSule.ggsc9Sny8c3myJvLVTP/sNij/ZiHz9i','opi4613@hotmail.co.uk','2013-02-08 20:36:24','2013-02-25 18:39:51','Y'),
	(15,'c1026719','$2a$08$2oOc4We183XeWHwYfhzR7OlM2q/q/iQS4ETR/ajTrDGGqhaNlK/YS','timgwest@gmail.com','2013-02-15 14:11:03','2013-02-15 14:54:28','N'),
	(16,'c1114016','$2a$08$YtjBEzCmzMAWoe0Zl1MjiekHheKS/kG.yhgtpWbuwdq7mW/ZJ3Knu','aledrowen@gmail.com','2013-02-17 19:09:53','2013-02-18 21:00:51','Y'),
	(17,'c1123702','$2a$08$a12LrMbO/MyTEvGQ4mFUbO40k/tf4Kcu5xNfrqKX/8mmmgxTd.xZa','j.morris676@gmail.com','2013-02-21 12:48:11','2013-02-25 19:23:52','N'),
	(18,'jawrainey','$2a$08$HQ6V08mkD1Zi.fyNBN40..BuGhf25CxgAECgt4M0FwFM/9/h4Y09u','jawrainey@gmail.com','2013-02-22 15:43:32','2013-02-22 15:45:24','N');

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table visualisation
# ------------------------------------------------------------

DROP TABLE IF EXISTS `visualisation`;

CREATE TABLE `visualisation` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `data_set_id` int(11) NOT NULL,
  `params` varchar(255) DEFAULT '',
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `is_active` char(1) NOT NULL DEFAULT 'Y',
  `json_path` varchar(250) DEFAULT '',
  `available_graphs` varchar(250) DEFAULT NULL,
  `selected_graph` varchar(250) DEFAULT NULL,
  `dimension` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `visualisation` WRITE;
/*!40000 ALTER TABLE `visualisation` DISABLE KEYS */;

INSERT INTO `visualisation` (`id`, `user_id`, `name`, `data_set_id`, `params`, `created_at`, `updated_at`, `is_active`, `json_path`, `available_graphs`, `selected_graph`, `dimension`)
VALUES
	(43,1,'Will\'s Test',1,'a:1:{i:0;s:5:\"attr3\";}','2013-02-14 12:21:44','2013-02-18 10:02:44','N','public_html/json/43.json',NULL,NULL,0),
	(48,1,'Test',1,'a:1:{i:0;s:5:\"attr9\";}','2013-02-17 16:55:06','2013-02-26 17:02:52','Y','public_html/json/48.json','a:1:{i:0;s:1:\"3\";}',NULL,1),
	(85,16,'Test',1,'a:1:{i:0;s:5:\"attr8\";}','2013-02-26 16:52:09','2013-02-26 17:02:12','Y','public_html/json/85.json','a:1:{i:0;s:1:\"3\";}',NULL,1),
	(62,1,'Jay\'s test',1,'a:1:{i:0;s:5:\"attr9\";}','2013-02-22 15:06:26','2013-02-22 15:34:19','N','public_html/json/62.json','a:1:{i:0;s:1:\"3\";}',NULL,1),
	(50,16,'Test',1,'','2013-02-17 19:14:35','2013-02-26 16:04:40','N','',NULL,NULL,0),
	(51,10,'Test',1,'a:2:{i:0;s:5:\"attr2\";i:1;s:5:\"attr1\";}','2013-02-18 15:35:30','2013-02-20 16:10:51','Y','public_html/json/51.json',NULL,NULL,0),
	(53,10,'Test 2',1,'a:3:{i:0;s:5:\"attr1\";i:1;s:5:\"attr2\";i:2;s:5:\"attr3\";}','2013-02-20 16:15:47','2013-02-20 16:22:41','Y','public_html/json/53.json',NULL,NULL,0),
	(52,16,'Test2',1,'','2013-02-18 16:36:23','2013-02-18 16:46:36','N','',NULL,NULL,0),
	(54,10,'Test 2',1,'','2013-02-20 17:57:30','2013-02-20 17:57:30','Y','',NULL,NULL,0),
	(55,10,'Just creating some more test cases, hence the multiple visualisations i have attempted to create',1,'','2013-02-20 18:00:16','2013-02-20 18:00:16','Y','',NULL,NULL,0),
	(56,10,'k',1,'','2013-02-20 18:13:35','2013-02-20 18:13:35','Y','',NULL,NULL,0),
	(63,18,'test',1,'a:1:{i:0;s:5:\"attr9\";}','2013-02-22 15:45:44','2013-02-25 08:28:27','Y','json/63.json','a:1:{i:0;s:1:\"3\";}',NULL,1),
	(58,15,'tim',1,'a:2:{i:0;s:5:\"attr3\";i:1;s:5:\"attr5\";}','2013-02-21 11:46:05','2013-02-21 11:46:15','Y','public_html/json/58.json',NULL,NULL,0),
	(65,18,'uda',1,'','2013-02-24 02:13:59','2013-02-24 02:13:59','Y','',NULL,NULL,0),
	(66,18,'sa',1,'a:3:{i:0;s:5:\"attr8\";i:1;s:5:\"attr7\";i:2;s:5:\"attr6\";}','2013-02-25 00:28:50','2013-02-25 08:28:00','Y','json/66.json','a:0:{}',NULL,3),
	(64,18,'hva',1,'','2013-02-23 00:33:43','2013-02-23 00:33:43','Y','',NULL,NULL,0),
	(61,10,'test232',1,'a:1:{i:0;s:5:\"attr2\";}','2013-02-22 13:53:02','2013-02-25 12:38:11','Y','json/61.json','a:0:{}',NULL,1),
	(67,10,'test',1,'a:1:{i:0;s:5:\"attr3\";}','2013-02-25 12:24:26','2013-02-25 13:45:41','Y','json/67.json','a:1:{i:0;s:1:\"3\";}',NULL,1),
	(68,10,'k',1,'a:1:{i:0;s:5:\"attr2\";}','2013-02-25 12:45:10','2013-02-25 20:49:37','Y','json/68.json','a:0:{}',NULL,1),
	(77,16,'S',1,'a:2:{i:0;s:5:\"attr9\";i:1;s:5:\"attr2\";}','2013-02-26 15:55:17','2013-02-26 16:04:36','N','json/77.json','a:0:{}',NULL,2),
	(78,16,'SomeTest',1,'a:1:{i:0;s:5:\"attr8\";}','2013-02-26 16:02:58','2013-02-26 16:04:30','N','json/78.json','a:1:{i:0;s:1:\"3\";}',NULL,1),
	(79,16,'SomeTest',1,'a:1:{i:0;s:5:\"attr8\";}','2013-02-26 16:04:47','2013-02-26 16:11:11','N','json/79.json','a:1:{i:0;s:1:\"3\";}',NULL,1),
	(80,16,'SomeTestNew',1,'a:1:{i:0;s:5:\"attr8\";}','2013-02-26 16:11:24','2013-02-26 16:11:35','Y','json/80.json','a:1:{i:0;s:1:\"3\";}',NULL,1),
	(81,16,'SomeTest2',1,'a:2:{i:0;s:5:\"attr4\";i:1;s:5:\"attr2\";}','2013-02-26 16:12:17','2013-02-26 16:12:31','Y','json/81.json','a:0:{}',NULL,2),
	(82,16,'SomeTest3',1,'a:1:{i:0;s:5:\"attr8\";}','2013-02-26 16:38:27','2013-02-26 16:38:31','Y','json/82.json','a:1:{i:0;s:1:\"3\";}',NULL,1),
	(83,16,'ATesy',1,'a:1:{i:0;s:5:\"attr9\";}','2013-02-26 16:39:43','2013-02-26 16:39:49','Y','json/83.json','a:1:{i:0;s:1:\"3\";}',NULL,1),
	(84,16,'A test',1,'a:1:{i:0;s:5:\"attr8\";}','2013-02-26 16:43:01','2013-02-26 16:43:08','Y','json/84.json','a:1:{i:0;s:1:\"3\";}',NULL,1),
	(86,16,'Pie',1,'a:1:{i:0;s:5:\"attr9\";}','2013-02-26 17:01:38','2013-02-26 17:02:55','Y','public_html/json/86.json','a:1:{i:0;s:1:\"3\";}',NULL,1),
	(87,13,'dddd',1,'a:1:{i:0;s:5:\"attr9\";}','2013-02-26 17:02:08','2013-02-26 17:03:47','Y','public_html/json/87.json','a:1:{i:0;s:1:\"3\";}',NULL,1);

/*!40000 ALTER TABLE `visualisation` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
