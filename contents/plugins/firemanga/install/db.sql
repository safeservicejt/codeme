-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 02, 2015 at 05:09 PM
-- Server version: 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `2015_project_noblessecms`
--

-- --------------------------------------------------------

--
-- Table structure for table `chapter_list`
--

CREATE TABLE IF NOT EXISTS `chapter_list` (
  `chapterid` int(9) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `friendly_url` varchar(255) DEFAULT NULL,
  `content_type` varchar(50) NOT NULL DEFAULT 'url',
  `content` longtext,
  `number` int(5) NOT NULL DEFAULT '1',
  `views` int(9) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL,
  `is_featured` int(1) NOT NULL DEFAULT '0',
  `featured_date` datetime DEFAULT NULL,
  `mangaid` int(9) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`chapterid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `manga_authors`
--

CREATE TABLE IF NOT EXISTS `manga_authors` (
  `authorid` int(9) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `rating` int(2) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`authorid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `manga_categories`
--

CREATE TABLE IF NOT EXISTS `manga_categories` (
  `mangaid` int(9) NOT NULL,
  `catid` int(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `manga_list`
--

CREATE TABLE IF NOT EXISTS `manga_list` (
  `mangaid` int(9) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `friendly_url` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `summary` longtext,
  `rating` int(2) NOT NULL DEFAULT '0',
  `authorid` int(9) DEFAULT '0',
  `keywords` varchar(255) DEFAULT NULL,
  `date_added` datetime NOT NULL,
  `views` int(9) NOT NULL DEFAULT '0',
  `is_featured` int(1) NOT NULL DEFAULT '0',
  `featured_date` datetime DEFAULT NULL,
  `compeleted` int(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`mangaid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Table structure for table `manga_tags`
--

CREATE TABLE IF NOT EXISTS `manga_tags` (
  `tagid` int(9) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `mangaid` int(9) NOT NULL,
  PRIMARY KEY (`tagid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
