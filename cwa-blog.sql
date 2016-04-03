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
-- Table structure for table `BlogPost`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `BlogPost` (
  `ID` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `Created` datetime NOT NULL,
  `Updated` datetime NOT NULL,
  `Published` datetime DEFAULT NULL,
  `Slug` varchar(50) NOT NULL,
  `Title` varchar(50) NOT NULL,
  `Summary` varchar(160) NOT NULL,
  `Body` varchar(21200) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `UNQ_BLOGPOST_SLUG` (`Slug`),
  UNIQUE KEY `UNQ_BLOGPOST_TITLE` (`Title`),
  KEY `IDX_BLOGPOST_SUMMARY` (`Summary`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `BlogPost`
--

LOCK TABLES `BlogPost` WRITE;
/*!40000 ALTER TABLE `BlogPost` DISABLE KEYS */;
INSERT INTO `BlogPost` VALUES (1,NOW(),NOW(),NOW(),'sample-blog-post','Sample Blog Post','This is a sample blog post. After customizing the site, you can edit this post to create your first blog post.','<p><a title=\"View the CWA Blog project\" href=\"https://github.com/chriswells0/cwa-blog\" rel=\"external\">Core Web Application Blog</a> was created to help developers quickly add a blog to <a title=\"View the CWA Site project\" href=\"https://github.com/chriswells0/cwa-site\" rel=\"external\">Core Web Application Site</a>. It\'s designed to be easily customized and extended.</p>\r\n<p>Once you\'ve customized the site, <a title=\"Edit this post\" href=\"/blog/edit/sample-blog-post\">edit this post</a> to create your first blog post!</p>');
/*!40000 ALTER TABLE `BlogPost` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `BlogPost_Tag`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `BlogPost_Tag` (
  `BlogPostID` smallint(5) unsigned NOT NULL,
  `TagID` smallint(5) unsigned NOT NULL,
  UNIQUE KEY `UNQ_BLOGPOSTID_TAGID` (`BlogPostID`,`TagID`),
  KEY `FK_BLOGPOST_TAG_TAGID` (`TagID`),
  CONSTRAINT `FK_BLOGPOST_TAG_BLOGPOSTID` FOREIGN KEY (`BlogPostID`) REFERENCES `BlogPost` (`ID`) ON DELETE CASCADE,
  CONSTRAINT `FK_BLOGPOST_TAG_TAGID` FOREIGN KEY (`TagID`) REFERENCES `Tag` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `BlogPost_Tag`
--

LOCK TABLES `BlogPost_Tag` WRITE;
/*!40000 ALTER TABLE `BlogPost_Tag` DISABLE KEYS */;
/*!40000 ALTER TABLE `BlogPost_Tag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Tag`
--

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

/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
