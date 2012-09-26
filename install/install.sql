-- phpMyAdmin SQL Dump
-- version 3.1.3.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 26, 2012 at 03:42 PM
-- Server version: 5.1.53
-- PHP Version: 5.3.14

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `mylist`
--

-- --------------------------------------------------------

--
-- Table structure for table `mylist_items`
--

CREATE TABLE IF NOT EXISTS `mylist_items` (
  `mylist_item_id` int(11) NOT NULL AUTO_INCREMENT,
  `item` text NOT NULL,
  `priority` int(4) NOT NULL,
  `duedate` date NOT NULL,
  `ordering` int(4) NOT NULL,
  `status` int(4) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`mylist_item_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `mylist_items`
--

INSERT INTO `mylist_items` (`mylist_item_id`, `item`, `priority`, `duedate`, `ordering`, `status`, `user_id`) VALUES
(2, 'come back from the landry.  boom, crack MANY', 20, '2012-09-22', 0, 50, 50),
(3, 'Bring me a scone', 30, '0000-00-00', 0, 60, 0),
(4, 'bring me a scone', 30, '0000-00-00', 0, 50, 0),
(6, 'due boom', 30, '2012-09-29', 0, 50, 50),
(8, 'More of a dump', 30, '2012-09-19', 0, 80, 50),
(9, 'Doing it again', 30, '2012-09-12', 0, 60, 50);

-- --------------------------------------------------------

--
-- Table structure for table `mylist_session`
--

CREATE TABLE IF NOT EXISTS `mylist_session` (
  `session_id` varchar(200) NOT NULL DEFAULT '',
  `client_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `guest` tinyint(4) unsigned DEFAULT '1',
  `time` varchar(14) DEFAULT '',
  `data` mediumtext,
  `userid` int(11) DEFAULT '0',
  `username` varchar(150) DEFAULT '',
  `usertype` varchar(50) DEFAULT '',
  PRIMARY KEY (`session_id`),
  KEY `whosonline` (`guest`,`usertype`),
  KEY `userid` (`userid`),
  KEY `time` (`time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mylist_session`
--

INSERT INTO `mylist_session` (`session_id`, `client_id`, `guest`, `time`, `data`, `userid`, `username`, `usertype`) VALUES
('9drfmiaqkvdj5k4pkiapfv3900', 0, 0, '1348688513', '__default|a:6:{s:15:"session.counter";i:154;s:19:"session.timer.start";i:1348684884;s:18:"session.timer.last";i:1348688512;s:17:"session.timer.now";i:1348688513;s:22:"session.client.browser";s:106:"Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.4 (KHTML, like Gecko) Chrome/22.0.1229.79 Safari/537.4";s:4:"user";O:7:"JObject":15:{s:10:"\0*\0_errors";a:0:{}s:14:"mylist_user_id";N;s:4:"name";N;s:8:"username";N;s:5:"email";N;s:8:"password";N;s:8:"usertype";N;s:5:"block";N;s:9:"sendEmail";N;s:12:"registerDate";N;s:13:"lastvisitDate";N;s:10:"activation";N;s:6:"params";N;s:13:"lastResetTime";N;s:10:"resetCount";N;}}userid|s:2:"50";', 50, 'demo', ''),
('vr3mo2mqvtrktdfm5k7kcatke7', 0, 1, '1348683720', '', 0, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `mylist_users`
--

CREATE TABLE IF NOT EXISTS `mylist_users` (
  `mylist_user_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `username` varchar(150) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL DEFAULT '',
  `password` varchar(100) NOT NULL DEFAULT '',
  `usertype` varchar(25) NOT NULL DEFAULT '',
  `block` tinyint(4) NOT NULL DEFAULT '0',
  `sendEmail` tinyint(4) DEFAULT '0',
  `registerDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `lastvisitDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `activation` varchar(100) NOT NULL DEFAULT '',
  `params` text NOT NULL,
  `lastResetTime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Date of last password reset',
  `resetCount` int(11) NOT NULL DEFAULT '0' COMMENT 'Count of password resets since lastResetTime',
  PRIMARY KEY (`mylist_user_id`),
  KEY `usertype` (`usertype`),
  KEY `idx_name` (`name`),
  KEY `idx_block` (`block`),
  KEY `username` (`username`),
  KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=44 ;

--
-- Dumping data for table `mylist_users`
--

INSERT INTO `mylist_users` (`mylist_user_id`, `name`, `username`, `email`, `password`, `usertype`, `block`, `sendEmail`, `registerDate`, `lastvisitDate`, `activation`, `params`, `lastResetTime`, `resetCount`) VALUES
(50, 'Demo', 'demo', 'demo@ijobid.com', 'fcd1d48a55a9a6754323eca5ac8dd3f9:xJ8oRt9G4h4UA3Sx5M4gpbqgS1uabjZW', '', 1, 0, '2012-09-26 13:14:22', '0000-00-00 00:00:00', '67e1b2f151c5272331bdc4a514efba42', '{}', '0000-00-00 00:00:00', 0);
