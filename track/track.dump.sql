-- MySQL dump 10.11

--

-- Host: localhost    Database: track

-- ------------------------------------------------------

-- Server version	5.0.45-community-nt



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

-- Table structure for table `category`

--



DROP TABLE IF EXISTS `category`;

CREATE TABLE `category` (

  `id` int(11) NOT NULL auto_increment,

  `name` varchar(40) NOT NULL default '',

  `notes` text,

  PRIMARY KEY  (`id`),

  KEY `ix_category_name` (`name`)

) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;



--

-- Dumping data for table `category`

--



LOCK TABLES `category` WRITE;

/*!40000 ALTER TABLE `category` DISABLE KEYS */;

INSERT INTO `category` VALUES (1,'Code defect','Bug fix required. Program not meeting specifications.'),(2,'Build program.','Issues with make / build programs.'),(3,'Feature request','A must-have feature in the application.'),(4,'Documentation','Missing, wrong or inadequate documentation.'),(5,'Incident','All else that does not fit the other categories.');

/*!40000 ALTER TABLE `category` ENABLE KEYS */;

UNLOCK TABLES;



--

-- Table structure for table `component`

--



DROP TABLE IF EXISTS `component`;

CREATE TABLE `component` (

  `id` int(11) NOT NULL auto_increment,

  `name` varchar(40) NOT NULL default '',

  `notes` text,

  PRIMARY KEY  (`id`),

  KEY `ix_component_name` (`name`)

) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;



--

-- Dumping data for table `component`

--



LOCK TABLES `component` WRITE;

/*!40000 ALTER TABLE `component` DISABLE KEYS */;

INSERT INTO `component` VALUES (1,'JMS Queue System','SOA sub-system.'),(2,'Project Manger Editor','Sub-system of project management program.');

/*!40000 ALTER TABLE `component` ENABLE KEYS */;

UNLOCK TABLES;



--

-- Table structure for table `primetrack`

--



DROP TABLE IF EXISTS `primetrack`;

CREATE TABLE `primetrack` (

  `id` int(11) NOT NULL auto_increment,

  `name` varchar(40) NOT NULL default '',

  `notes` text,

  PRIMARY KEY  (`id`),

  KEY `ix_primetrack_name` (`name`)

) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;



--

-- Dumping data for table `primetrack`

--



LOCK TABLES `primetrack` WRITE;

/*!40000 ALTER TABLE `primetrack` DISABLE KEYS */;

INSERT INTO `primetrack` VALUES (1,'Stercks Systems Project Manager','Project Management Program Status Notes.'),(2,'SOA / BPEL POC System','POC project.'),(3,'X-Forms','User interface of the future.');

/*!40000 ALTER TABLE `primetrack` ENABLE KEYS */;

UNLOCK TABLES;



--

-- Table structure for table `resolution`

--



DROP TABLE IF EXISTS `resolution`;

CREATE TABLE `resolution` (

  `id` int(11) NOT NULL auto_increment,

  `name` varchar(40) NOT NULL default '',

  `notes` text,

  PRIMARY KEY  (`id`),

  KEY `ix_resolution_name` (`name`)

) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;



--

-- Dumping data for table `resolution`

--



LOCK TABLES `resolution` WRITE;

/*!40000 ALTER TABLE `resolution` DISABLE KEYS */;

INSERT INTO `resolution` VALUES (1,'Open','Hmmm. Needs your attention.'),(2,'Fixed','We are *really* done with this thingy!'),(3,'Rejected','Hope this happens often, when it\'s good news.'),(4,'Workaround','Hacky resolution.'),(5,'Unable to reproduce','Too bad.'),(6,'Works as designed','It was a misunderstanding... Trust me!'),(7,'External bug','We are not responsible!'),(8,'Not a bug','Good news.'),(9,'Overcome by events','What can we say?'),(10,'Drive by patch','Let\'s see how this goes... Don\'t make a habit of this!'),(11,'Misconfiguration','Ah! It was the configuration.');

/*!40000 ALTER TABLE `resolution` ENABLE KEYS */;

UNLOCK TABLES;



--

-- Table structure for table `severity`

--



DROP TABLE IF EXISTS `severity`;

CREATE TABLE `severity` (

  `id` int(11) NOT NULL auto_increment,

  `name` varchar(40) NOT NULL default '',

  `notes` text,

  PRIMARY KEY  (`id`),

  KEY `ix_severity_name` (`name`)

) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;



--

-- Dumping data for table `severity`

--



LOCK TABLES `severity` WRITE;

/*!40000 ALTER TABLE `severity` DISABLE KEYS */;

INSERT INTO `severity` VALUES (1,'Critical','Must-fix issues that MUST be attended to ASAP.'),(2,'Severe','Requires attention.'),(3,'Important','Not unimportant.'),(4,'Minor','Niggling issues that would be good to not have.'),(5,'Cosmetic','Non-trivial UX issues. Not of vital importance.');

/*!40000 ALTER TABLE `severity` ENABLE KEYS */;

UNLOCK TABLES;



--

-- Table structure for table `status`

--



DROP TABLE IF EXISTS `status`;

CREATE TABLE `status` (

  `id` int(11) NOT NULL auto_increment,

  `name` varchar(40) NOT NULL default '',

  `notes` text,

  PRIMARY KEY  (`id`),

  KEY `ix_status_name` (`name`)

) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;



--

-- Dumping data for table `status`

--



LOCK TABLES `status` WRITE;

/*!40000 ALTER TABLE `status` DISABLE KEYS */;

INSERT INTO `status` VALUES (1,'Open','The issue requires attention.'),(2,'Closed','The issue is closed.'),(3,'Fixed','The issue is resolved.'),(4,'Verified','Confirmation has been carried out.'),(5,'Reviewed','A step towards issue resolution.'),(6,'Deferred','The issue can be attended to later.'),(7,'Tested','Closer to the issue being fixed.'),(8,'Reopen','A previously closed issue has been found to have problems.');

/*!40000 ALTER TABLE `status` ENABLE KEYS */;

UNLOCK TABLES;



--

-- Table structure for table `tasklist`

--



DROP TABLE IF EXISTS `tasklist`;

CREATE TABLE `tasklist` (

  `id` int(11) NOT NULL auto_increment,

  `title` varchar(60) NOT NULL default '',

  `category_id` int(11) NOT NULL,

  `severity_id` int(11) NOT NULL,

  `status_id` int(11) NOT NULL,

  `detected_by_id` int(11) NOT NULL,

  `assigned_to_id` int(11) NOT NULL,

  `component_id` int(11) NOT NULL,

  `prime_track_id` int(11) NOT NULL,

  `resolution_id` int(11) NOT NULL,

  `planned_close_date` date NOT NULL,

  `notes` text,

  PRIMARY KEY  (`id`),

  KEY `ix_tasklist_cat` (`category_id`),

  KEY `ix_tasklist_sevr` (`severity_id`),

  KEY `ix_tasklist_stat` (`status_id`),

  KEY `ix_tasklist_detb` (`detected_by_id`),

  KEY `ix_tasklist_asst` (`assigned_to_id`),

  KEY `ix_tasklist_cmpt` (`component_id`),

  KEY `ix_tasklist_prtr` (`prime_track_id`),

  KEY `ix_tasklist_resol` (`resolution_id`)

) ENGINE=InnoDB AUTO_INCREMENT=1011 DEFAULT CHARSET=latin1;



--

-- Dumping data for table `tasklist`

--



LOCK TABLES `tasklist` WRITE;

/*!40000 ALTER TABLE `tasklist` DISABLE KEYS */;

INSERT INTO `tasklist` VALUES (1001,'User record is not saved correctly.',1,1,1,7,3,1,1,1,'2010-09-13',': 2010-10-02T09:55:08+05:30 - raman@company.com\r\n\r\nThe mail feature started working on Oct 2, 2010 at 9.45.'),(1002,'Component editor notes error.',1,1,1,1,2,1,1,1,'2010-09-13',': 2010-09-21T21:37:56+05:30 - raman@company.com\r\n\r\nComponent record not accepting notes. More comments here.'),(1003,'Date display needs to be fixed.',3,3,1,5,5,2,2,1,'2010-09-20',': 2010-09-21T12:27:40+05:30 - mohan@company.com\r\n\r\nDate display is in YMD format is very unnatural.\r\n\r\nJanata is finding it difficult to do their dates in the YMD format, the recommended fix for this issue is to make  it happen with a calendar widget.'),(1004,'Implement \'Delete\' for all entities.',3,4,2,5,5,2,1,2,'2010-09-21','Be able to correctly remove any record.\r\n\r\nThe delete operation should not cause bad references to occur.'),(1006,'Defect for defect list sake. Good one !?',1,1,6,7,2,2,1,7,'2010-09-20','Notes for this \"defect\".'),(1010,'XForm bug',2,5,1,6,4,1,3,7,'2010-09-20',':2010-09-20T14:50:47+05:30 - mohan@company.com\r\n\r\nXForm bug');

/*!40000 ALTER TABLE `tasklist` ENABLE KEYS */;

UNLOCK TABLES;



--

-- Table structure for table `users`

--



DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (

  `id` int(11) NOT NULL auto_increment,

  `name` varchar(40) NOT NULL default '',

  `email_id` varchar(100) NOT NULL default '',

  `password` varchar(100) NOT NULL default '' COMMENT 'MDS of plain text.',

  `role` enum('admin','engineer','client') default 'engineer',

  `active` tinyint(4) NOT NULL default '1',

  PRIMARY KEY  (`id`),

  KEY `ix_users_name` (`name`)

) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;



--

-- Dumping data for table `users`

--



LOCK TABLES `users` WRITE;

/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` VALUES (1,'Raman Gunasekar','raman@company.com','3e8961306a7d9c49c15e97d4943b2529','admin',1),(2,'Mohan Paranjpe','mohan@company.com','e9206237def4b4ef46fd933ed0f5a08f','engineer',1),(3,'Suresh Krishnan','suresh@company.com','0487cc982f7db39c51695026e4bdc692','engineer',1),(4,'Ramesh Kannan','ramesh@company.com','6fc42c4388ed6f0c5a91257f096fef3c','engineer',0),(5,'Vijay Patil','vijay.a.patil@gmail.com','4f9fecabbd77fba02d2497f880f44e6f','engineer',1),(6,'Kamath S K','kamath@ss.com','fed7e4d7f77a34360047eb8c38a45e8d','engineer',1),(7,'Krishnan Ramnathan','krishnan@company.com','fea209e251aade9628951d59f6108caa','engineer',1),(8,'Jack Smith','jack@xcom.com','4ff9fc6e4e5d5f590c4f2134a8cc96d1','client',1);

/*!40000 ALTER TABLE `users` ENABLE KEYS */;

UNLOCK TABLES;



--

-- Table structure for table `usertrack`

--



DROP TABLE IF EXISTS `usertrack`;

CREATE TABLE `usertrack` (

  `id` int(11) NOT NULL auto_increment,

  `user_id` int(11) NOT NULL,

  `track_id` int(11) NOT NULL,

  PRIMARY KEY  (`id`),

  KEY `ix_ut_ut` (`user_id`,`track_id`),

  KEY `ix_ut_tu` (`track_id`,`user_id`)

) ENGINE=InnoDB AUTO_INCREMENT=97 DEFAULT CHARSET=latin1;



--

-- Dumping data for table `usertrack`

--



LOCK TABLES `usertrack` WRITE;

/*!40000 ALTER TABLE `usertrack` DISABLE KEYS */;

INSERT INTO `usertrack` VALUES (87,1,1),(93,1,2),(94,1,3),(78,2,2),(80,2,3),(83,3,1),(77,3,2),(76,3,3),(74,4,1),(89,5,2),(88,5,3),(96,6,1),(81,6,2),(61,7,1),(57,7,2);

/*!40000 ALTER TABLE `usertrack` ENABLE KEYS */;

UNLOCK TABLES;

/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;



/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;

/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;

/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;

/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;



-- Dump completed on 2011-11-28  7:10:36

