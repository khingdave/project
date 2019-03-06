-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 04, 2018 at 01:29 PM
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
) ENGINE=InnoDB AUTO_INCREMENT=100021 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `allstudent`
--

INSERT INTO `allstudent` (`SN`, `MATRIC`, `NAME`, `LEVEL`, `COURSE`, `ATTENDANCE`) VALUES
(100006, '22', 'BASHIR IDRIS', '500', 'CPT512', '0'),
(100008, 'm1304214', 'chieze cherokee', '500', 'CPT512', '0'),
(100009, 'm1301028', 'Gambo Yaro', '100', 'IMT111', '0'),
(100010, 'm1301029', 'Moses Mamman', '400', 'BLD423', '0'),
(100011, 'n1301027', 'david g', '100', 'IMT111', '0'),
(100013, 'm1301010', 'david gambo', '100', 'IMT111', '0'),
(100014, 'm129173', 'tosin jethro', '100', 'imt211', '0'),
(100015, 'm1304217', 'mama jiya', '100', 'IMT111', '0'),
(100016, 'm1304210', 'abbas', '100', 'IMT111', '0'),
(100017, 'm1301027', 'GAMBO DAVID', '500', 'IMT523', '0'),
(100018, 'di201027', 'dave', '100', 'IMT523', '0'),
(100019, '2013/1/46770ci', 'GAMBO DAVID YARO', '500', 'IMT523', '0'),
(100020, '2010/1/46770ci', 'ENUMA CHEROKEE', '300', 'IMT523', '0');

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
) ENGINE=InnoDB AUTO_INCREMENT=103 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `SN`, `matric`, `course`, `attendance`, `datetime`) VALUES
(24, '100008', 'm1304214', 'CPT512', '0', '2018-09-06'),
(26, '100008', 'm1304214', 'CPT512', '0', '2018-09-06'),
(29, '100006', '22', 'CPT512', '0', '2018-09-06'),
(31, '100006', '22', 'CPT512', '0', '2018-09-06'),
(34, '100008', 'm1304214', 'CPT512', '0', '2018-09-06'),
(41, '100006', '22', 'CPT512', '0', '2018-09-12'),
(42, '100008', 'm1304214', 'CPT512', '0', '2018-09-12'),
(44, '100006', '22', 'CPT512', '0', '2018-09-14'),
(46, '100006', '22', 'CPT512', '0', '2018-09-14'),
(47, '100008', 'm1304214', 'CPT512', '0', '2018-09-14'),
(49, '100006', '22', 'CPT512', '0', '2018-09-26'),
(50, '100008', 'm1304214', 'CPT512', '0', '2018-09-26'),
(52, '100018', 'di201027', 'IMT523', '0', '2018-10-03'),
(53, '100019', '2013/1/46770ci', 'IMT523', '0', '2018-10-03'),
(55, '100018', 'di201027', 'IMT523', '0', '2018-10-03'),
(56, '100019', '2013/1/46770ci', 'IMT523', '0', '2018-10-03'),
(58, '100018', 'di201027', 'IMT523', '0', '2018-10-03'),
(59, '100019', '2013/1/46770ci', 'IMT523', '0', '2018-10-03'),
(64, '100018', 'di201027', 'IMT523', '0', '2018-10-03'),
(66, '100017', 'm1301027', 'IMT523', '0', '2018-10-03'),
(67, '100018', 'di201027', 'IMT523', '0', '2018-10-03'),
(68, '100017', 'm1301027', 'IMT523', '0', '2018-10-03'),
(69, '100018', 'di201027', 'IMT523', '0', '2018-10-03'),
(70, '100019', '2013/1/46770ci', 'IMT523', '0', '2018-10-03'),
(71, '100017', 'm1301027', 'IMT523', '0', '2018-10-03'),
(72, '100018', 'di201027', 'IMT523', '0', '2018-10-03'),
(73, '100019', '2013/1/46770ci', 'IMT523', '0', '2018-10-03'),
(74, '100017', 'm1301027', 'IMT523', '0', '2018-10-03'),
(75, '100018', 'di201027', 'IMT523', '0', '2018-10-03'),
(76, '100019', '2013/1/46770ci', 'IMT523', '0', '2018-10-03'),
(77, '100017', 'm1301027', 'IMT523', '0', '2018-10-04'),
(78, '100018', 'di201027', 'IMT523', '0', '2018-10-04'),
(79, '100019', '2013/1/46770ci', 'IMT523', '0', '2018-10-04'),
(80, '100017', 'm1301027', 'IMT523', '0', '2018-10-04'),
(81, '100018', 'di201027', 'IMT523', '0', '2018-10-04'),
(82, '100019', '2013/1/46770ci', 'IMT523', '0', '2018-10-04'),
(83, '100017', 'm1301027', 'IMT523', '0', '2018-10-04'),
(84, '100018', 'di201027', 'IMT523', '0', '2018-10-04'),
(85, '100019', '2013/1/46770ci', 'IMT523', '0', '2018-10-04'),
(86, '100017', 'm1301027', 'IMT523', '0', '2018-10-04'),
(87, '100018', 'di201027', 'IMT523', '0', '2018-10-04'),
(88, '100019', '2013/1/46770ci', 'IMT523', '0', '2018-10-04'),
(89, '100017', 'm1301027', 'IMT523', '0', '2018-10-04'),
(90, '100018', 'di201027', 'IMT523', '0', '2018-10-04'),
(91, '100019', '2013/1/46770ci', 'IMT523', '0', '2018-10-04'),
(92, '100017', 'm1301027', 'IMT523', '0', '2018-10-04'),
(93, '100018', 'di201027', 'IMT523', '0', '2018-10-04'),
(94, '100019', '2013/1/46770ci', 'IMT523', '0', '2018-10-04'),
(95, '100017', 'm1301027', 'IMT523', '0', '2018-10-04'),
(96, '100018', 'di201027', 'IMT523', '0', '2018-10-04'),
(97, '100019', '2013/1/46770ci', 'IMT523', '0', '2018-10-04'),
(98, '100020', '2010/1/46770ci', 'IMT523', '1', '2018-10-04'),
(99, '100017', 'm1301027', 'IMT523', '0', '2018-10-04'),
(100, '100018', 'di201027', 'IMT523', '0', '2018-10-04'),
(101, '100019', '2013/1/46770ci', 'IMT523', '0', '2018-10-04');

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `staffid`, `password`, `names`, `course`) VALUES
(2, '1000', '123456', 'ZUBAIRU', 'IMT523'),
(3, '1990', '123456', 'Yahaya Mohammed', 'IMT232');

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
  MODIFY `SN` int(100) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=100021;
--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=103;
--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `SN` int(100) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
