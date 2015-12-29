-- MySQL dump 10.13  Distrib 5.6.27, for FreeBSD9.3 (amd64)
--
-- Host: localhost    Database: cwa_database
-- ------------------------------------------------------
-- Server version	5.6.27

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
-- Table structure for table `BlogEntry`
--

DROP TABLE IF EXISTS `BlogEntry`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `BlogEntry` (
  `ID` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `Created` datetime NOT NULL,
  `Updated` datetime NOT NULL,
  `Published` datetime DEFAULT NULL,
  `Slug` varchar(50) NOT NULL,
  `Title` varchar(50) NOT NULL,
  `Summary` varchar(160) NOT NULL,
  `Body` varchar(21200) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `UNQ_BLOGENTRY_SLUG` (`Slug`),
  UNIQUE KEY `UNQ_BLOGENTRY_TITLE` (`Title`),
  KEY `IDX_BLOGENTRY_SUMMARY` (`Summary`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `BlogEntry`
--

LOCK TABLES `BlogEntry` WRITE;
/*!40000 ALTER TABLE `BlogEntry` DISABLE KEYS */;
INSERT INTO `BlogEntry` VALUES (1,NOW(),NOW(),NULL,'sample-blog-entry','Sample Blog Entry','This is a sample blog entry with instructions to customize the site. After customizing the site, you can edit this post to create your first blog entry.','<p><a title=\"View the CWA Blog project\" href=\"https://github.com/chriswells0/cwa-blog\" rel=\"external\">Core Web Application Blog</a> was created to help developers quickly launch new sites leveraging the <a title=\"View the CWA project\" href=\"https://github.com/chriswells0/cwa\" rel=\"external\">Core Web Application</a> libraries. It\'s designed to be easily customized and extended.</p>\r\n<p>Be sure to visit the <a title=\"Administer this site\" href=\"../../admin\">Site Admin</a> section to familiarize yourself with the built-in tools. Although it\'s not on the main menu, there\'s also a dynamic <a title=\"View the site map\" href=\"../../site/map\">site map</a> that you can use as a reference for the main URLs.</p>\r\n<h2>Getting Started</h2>\r\n<p>These steps should be performed right away:</p>\r\n<ol>\r\n<li><a title=\"Log into this site\" href=\"../../account/login\">Log in</a> as <span class=\"label\">admin</span> using the default password: <span class=\"label\">wku(&lt;o%x=%-9</span></li>\r\n<li><a title=\"Administer users\" href=\"../../users/admin\">Update the default users</a> to have correct contact information and passwords you can remember.</li>\r\n<li>If you haven\'t already, create your <a title=\"Create a Disqus account\" href=\"https://disqus.com/admin/signup/\" rel=\"external\">Disqus</a>, <a title=\"Create an Analytics account\" href=\"http://www.google.com/analytics/\" rel=\"external\">Google Analytics</a>, and <a title=\"Create a reCAPTCHA account\" href=\"https://www.google.com/recaptcha/admin/create\" rel=\"external\">reCAPTCHA</a> accounts.</li>\r\n<li>Update <a title=\"Edit config.php\" href=\"../../admin/code/config~config.php\">/application/config/config.php</a> to include your details in the following variables:\r\n<ul>\r\n<li>All of the app-specific constants at the top.</li>\r\n<li><span class=\"label\">RECAPTCHA_PUBLIC_KEY</span> and <span class=\"label\">RECAPTCHA_PRIVATE_KEY</span></li>\r\n<li><span class=\"label\">ANALYTICS_ID</span> (leave commented/undefined in the non-production section)</li>\r\n<li><span class=\"label\">DISQUS_SHORTNAME</span> (use a different shortname for non-production)</li>\r\n</ul>\r\n</li>\r\n<li>Edit this post to create your first blog entry!</li>\r\n</ol>\r\n<h2>Customizing The Design</h2>\r\n<p>These are the primary files to edit in order to redesign the site:</p>\r\n<ol>\r\n<li><a href=\"../../admin/code/views~_layouts~default.html.php\">/application/views/_layouts/default.html.php</a> provides the default page layout.</li>\r\n<li><a href=\"../../admin/code/views~_shared\">/application/views/_shared/</a> contains many of the files included in <span class=\"label\">default.html.php</span>.</li>\r\n<li><span class=\"label\">/public/</span> contains static files such as the main CSS file at <span class=\"label\">/public/styles/main.css</span>.</li>\r\n<li>Be sure to replace <span class=\"label\">/public/images/logo.png</span> and <span class=\"label\">/public/favicon.ico</span> with your own images.</li>\r\n<li>Role-based permissions are set in <a href=\"../../admin/code/main.php\">/application/main.php</a>.</li>\r\n</ol>\r\n<p>Once you\'ve customized the site, it\'s recommended that you delete the main <span class=\"label\">.gitignore</span> and <span class=\"label\">.gitmodules</span> files as well as the <span class=\"label\">.git</span> directory. Then update the <a title=\"View the CWA project\" href=\"https://github.com/chriswells0/cwa\" rel=\"external\">Core Web Application</a> libraries regularly using git inside the <span class=\"label\">/lib/cwa</span> directory.</p>');
/*!40000 ALTER TABLE `BlogEntry` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `BlogEntry_Tag`
--

DROP TABLE IF EXISTS `BlogEntry_Tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `BlogEntry_Tag` (
  `BlogEntryID` smallint(5) unsigned NOT NULL,
  `TagID` smallint(5) unsigned NOT NULL,
  UNIQUE KEY `UNQ_BLOGENTRYID_TAGID` (`BlogEntryID`,`TagID`),
  KEY `FK_BLOGENTRY_TAG_TAGID` (`TagID`),
  CONSTRAINT `FK_BLOGENTRY_TAG_BLOGENTRYID` FOREIGN KEY (`BlogEntryID`) REFERENCES `BlogEntry` (`ID`) ON DELETE CASCADE,
  CONSTRAINT `FK_BLOGENTRY_TAG_TAGID` FOREIGN KEY (`TagID`) REFERENCES `Tag` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `BlogEntry_Tag`
--

LOCK TABLES `BlogEntry_Tag` WRITE;
/*!40000 ALTER TABLE `BlogEntry_Tag` DISABLE KEYS */;
/*!40000 ALTER TABLE `BlogEntry_Tag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Role`
--

DROP TABLE IF EXISTS `Role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Role` (
  `ID` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `Created` datetime NOT NULL,
  `Updated` datetime NOT NULL,
  `Type` varchar(10) NOT NULL,
  `Name` varchar(30) NOT NULL,
  `Description` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `UNQ_ROLE_TYPE` (`Type`),
  UNIQUE KEY `UNQ_ROLE_NAME` (`Name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Role`
--

LOCK TABLES `Role` WRITE;
/*!40000 ALTER TABLE `Role` DISABLE KEYS */;
INSERT INTO `Role` VALUES (1,NOW(),NOW(),'ADMIN','Administrator','Full access to all site functionality.');
INSERT INTO `Role` VALUES (2,NOW(),NOW(),'DEV','Developer','Ability to perform code and database maintenance.');
INSERT INTO `Role` VALUES (3,NOW(),NOW(),'QA','QA','Able to access the QA Assistant.');
/*!40000 ALTER TABLE `Role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Tag`
--

DROP TABLE IF EXISTS `Tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Tag` (
  `ID` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `Created` datetime NOT NULL,
  `Updated` datetime NOT NULL,
  `Slug` varchar(50) DEFAULT NULL,
  `Value` varchar(50) NOT NULL,
  `SortOrder` smallint(5) unsigned NOT NULL DEFAULT '10000',
  `ShowInMenu` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `UNQ_TAG_VALUE` (`Value`),
  UNIQUE KEY `UNQ_TAG_SLUG` (`Slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Tag`
--

LOCK TABLES `Tag` WRITE;
/*!40000 ALTER TABLE `Tag` DISABLE KEYS */;
/*!40000 ALTER TABLE `Tag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `User`
--

DROP TABLE IF EXISTS `User`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `User` (
  `ID` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `Created` datetime NOT NULL,
  `Updated` datetime NOT NULL,
  `LastLogin` datetime NOT NULL,
  `EmailAddress` varchar(50) NOT NULL,
  `PasswordHash` varchar(255) NOT NULL,
  `Nickname` varchar(15) NOT NULL,
  `FirstName` varchar(15) DEFAULT NULL,
  `LastName` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `UNQ_USER_EMAILADDRESS` (`EmailAddress`),
  UNIQUE KEY `UNQ_USER_NICKNAME` (`Nickname`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `User`
--

LOCK TABLES `User` WRITE;
/*!40000 ALTER TABLE `User` DISABLE KEYS */;
INSERT INTO `User` VALUES (1,NOW(),NOW(),'0000-00-00 00:00:00','admin@example.com','$2y$15$CV2gUPzLx2j2/4n5yvTfM.AxszXNJYjyDpIhXF5PCKZE7gGitvjcm','admin','Site','Admin');
INSERT INTO `User` VALUES (2,NOW(),NOW(),'0000-00-00 00:00:00','qa@example.com','$2y$15$im9LGs2ucXul7qPcIq9c.u7wUZ4louvlubHwz4CbC7NaPORNTiCxG','tester','Quality','Assurance');
/*!40000 ALTER TABLE `User` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `User_Role`
--

DROP TABLE IF EXISTS `User_Role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `User_Role` (
  `UserID` smallint(5) unsigned NOT NULL,
  `RoleID` tinyint(3) unsigned NOT NULL,
  UNIQUE KEY `UNQ_USERID_ROLEID` (`UserID`,`RoleID`),
  KEY `FK_USER_ROLE_ROLEID` (`RoleID`),
  CONSTRAINT `FK_USER_ROLE_ROLEID` FOREIGN KEY (`RoleID`) REFERENCES `Role` (`ID`),
  CONSTRAINT `FK_USER_ROLE_USERID` FOREIGN KEY (`UserID`) REFERENCES `User` (`ID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `User_Role`
--

LOCK TABLES `User_Role` WRITE;
/*!40000 ALTER TABLE `User_Role` DISABLE KEYS */;
INSERT INTO `User_Role` VALUES (1,1);
INSERT INTO `User_Role` VALUES (1,2);
INSERT INTO `User_Role` VALUES (2,3);
/*!40000 ALTER TABLE `User_Role` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-12-28 21:20:57
