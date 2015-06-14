-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 03, 2015 at 02:52 AM
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
-- Table structure for table `fastbb_activity`
--

CREATE TABLE IF NOT EXISTS `fastbb_activity` (
  `activityid` int(9) NOT NULL AUTO_INCREMENT,
  `content` varchar(1000) NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`activityid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `fastbb_files`
--

CREATE TABLE IF NOT EXISTS `fastbb_files` (
  `fileid` int(9) NOT NULL AUTO_INCREMENT,
  `parent_type` varchar(30) NOT NULL DEFAULT 'thread',
  `size` double NOT NULL DEFAULT '0',
  `filename` varchar(255) NOT NULL,
  `date_added` datetime NOT NULL,
  `userid` int(11) NOT NULL,
  PRIMARY KEY (`fileid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `fastbb_forums`
--

CREATE TABLE IF NOT EXISTS `fastbb_forums` (
  `forumid` int(9) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `summary` varchar(255) DEFAULT NULL,
  `parentid` int(9) NOT NULL DEFAULT '0',
  `totalthread` int(9) NOT NULL DEFAULT '0',
  `totalpost` int(9) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL,
  `date_expires` datetime DEFAULT NULL,
  `type` varchar(50) NOT NULL DEFAULT 'forum',
  `permission` longtext,
  `status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`forumid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `fastbb_notify`
--

CREATE TABLE IF NOT EXISTS `fastbb_notify` (
  `notifyid` int(9) NOT NULL AUTO_INCREMENT,
  `content` longtext,
  `date_added` datetime NOT NULL,
  `forumid` int(9) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
  `date_expires` datetime DEFAULT NULL,
  PRIMARY KEY (`notifyid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `fastbb_online`
--

CREATE TABLE IF NOT EXISTS `fastbb_online` (
  `sessionid` varchar(255) NOT NULL,
  `userid` int(9) NOT NULL DEFAULT '0',
  `type` varchar(50) NOT NULL DEFAULT 'member',
  `date_added` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fastbb_post`
--

CREATE TABLE IF NOT EXISTS `fastbb_post` (
  `postid` int(9) NOT NULL AUTO_INCREMENT,
  `threadid` int(9) NOT NULL,
  `userid` int(9) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` longtext,
  `date_added` datetime NOT NULL,
  `totallikes` int(9) NOT NULL DEFAULT '0',
  `views` int(9) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`postid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `fastbb_post_icons`
--

CREATE TABLE IF NOT EXISTS `fastbb_post_icons` (
  `icondid` int(9) NOT NULL AUTO_INCREMENT,
  `filename` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `sort_order` int(5) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`icondid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `fastbb_smiles`
--

CREATE TABLE IF NOT EXISTS `fastbb_smiles` (
  `smileid` int(9) NOT NULL AUTO_INCREMENT,
  `filename` varchar(255) NOT NULL,
  `date_added` datetime NOT NULL,
  `code` varchar(50) NOT NULL,
  PRIMARY KEY (`smileid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `fastbb_thread`
--

CREATE TABLE IF NOT EXISTS `fastbb_thread` (
  `threadid` int(9) NOT NULL AUTO_INCREMENT,
  `forumid` int(9) NOT NULL,
  `userid` int(9) NOT NULL,
  `views` int(9) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL,
  `date_expires` datetime DEFAULT NULL,
  `type` varchar(50) NOT NULL DEFAULT 'thread',
  `totallikes` int(9) NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL,
  `content` longtext,
  `status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`threadid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `fastbb_usergroups`
--

CREATE TABLE IF NOT EXISTS `fastbb_usergroups` (
  `usergroupid` int(9) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  PRIMARY KEY (`usergroupid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `fastbb_users`
--

CREATE TABLE IF NOT EXISTS `fastbb_users` (
  `userid` int(9) NOT NULL,
  `ranhtitle` varchar(255) DEFAULT NULL,
  `last_activity` datetime DEFAULT NULL,
  `totalthread` int(9) NOT NULL DEFAULT '0',
  `totalpost` int(9) NOT NULL DEFAULT '0',
  `totallikes` int(9) NOT NULL DEFAULT '0',
  `birthday` datetime DEFAULT NULL,
  `homepage` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `skype` varchar(255) DEFAULT NULL,
  `bio` varchar(500) DEFAULT NULL,
  `gender` varchar(30) NOT NULL DEFAULT 'male',
  `date_expires` datetime DEFAULT NULL,
  `groupid` int(9) NOT NULL DEFAULT '0',
  `signature` varchar(1000) DEFAULT NULL,
  `permission` longtext
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
