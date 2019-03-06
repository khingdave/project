-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 05, 2018 at 02:14 PM
-- Server version: 5.6.24
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `attendancedb`
--
CREATE DATABASE IF NOT EXISTS `attendancedb` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `attendancedb`;

-- --------------------------------------------------------

--
-- Table structure for table `allstudent`
--

CREATE TABLE IF NOT EXISTS `allstudent` (
  `SN` int(100) NOT NULL,
  `MATRIC` varchar(255) DEFAULT NULL,
  `NAME` varchar(100) NOT NULL,
  `LEVEL` varchar(255) DEFAULT NULL,
  `COURSE` varchar(255) DEFAULT NULL,
  `ATTENDANCE` varchar(100) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=100008 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `allstudent`
--

INSERT INTO `allstudent` (`SN`, `MATRIC`, `NAME`, `LEVEL`, `COURSE`, `ATTENDANCE`) VALUES
(100006, '22', 'BASHIR IDRIS', '500', 'CPT512', '0'),
(100007, 'ML2345', 'DAVID', '500', 'IMT523', '0');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE IF NOT EXISTS `attendance` (
  `id` int(11) NOT NULL,
  `SN` varchar(100) DEFAULT NULL,
  `matric` varchar(255) DEFAULT NULL,
  `course` varchar(255) DEFAULT NULL,
  `attendance` varchar(255) DEFAULT '0',
  `datetime` date DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `SN`, `matric`, `course`, `attendance`, `datetime`) VALUES
(21, '100006', '22', 'CPT512', '1', '2018-08-25'),
(22, '100006', '22', 'CPT512', '1', '2018-08-27');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE IF NOT EXISTS `staff` (
  `id` int(11) NOT NULL,
  `staffid` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `names` varchar(255) DEFAULT NULL,
  `course` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `staffid`, `password`, `names`, `course`) VALUES
(1, '24109', '123456', 'David', 'CPT512'),
(2, '1000', '123456', 'ZUBAIRU', 'IMT523');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE IF NOT EXISTS `student` (
  `SN` int(100) NOT NULL,
  `NAME` varchar(100) NOT NULL,
  `ATTENDANCE` varchar(100) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `allstudent`
--
ALTER TABLE `allstudent`
  ADD PRIMARY KEY (`SN`), ADD UNIQUE KEY `SN` (`SN`), ADD UNIQUE KEY `NAME` (`NAME`), ADD UNIQUE KEY `SN_2` (`SN`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`SN`), ADD UNIQUE KEY `SN` (`SN`), ADD UNIQUE KEY `NAME` (`NAME`), ADD UNIQUE KEY `SN_2` (`SN`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `allstudent`
--
ALTER TABLE `allstudent`
  MODIFY `SN` int(100) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=100008;
--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `SN` int(100) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
