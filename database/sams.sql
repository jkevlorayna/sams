-- phpMyAdmin SQL Dump
-- version 4.2.8
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 28, 2016 at 11:12 PM
-- Server version: 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sams`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_category`
--

CREATE TABLE IF NOT EXISTS `tbl_category` (
`Id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `category_desc` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_category`
--

INSERT INTO `tbl_category` (`Id`, `category_name`, `category_desc`) VALUES
(24, 'Hotels', 'Hotels List'),
(25, 'Resorts', '0'),
(26, 'Beach', '0'),
(27, 'Restuarant', '0');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_course`
--

CREATE TABLE IF NOT EXISTS `tbl_course` (
`Id` int(11) NOT NULL,
  `course` varchar(100) NOT NULL,
  `code` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_course`
--

INSERT INTO `tbl_course` (`Id`, `course`, `code`, `description`) VALUES
(2, 'Bachelor in Science in Information System', 'BSIS', ''),
(3, 'Bachelor in Science in Civil Engeenering', 'BSCE', ''),
(4, 'eweqwe', 'BSHRM', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_course_year`
--

CREATE TABLE IF NOT EXISTS `tbl_course_year` (
`Id` int(11) NOT NULL,
  `CourseId` int(11) NOT NULL,
  `year` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_course_year`
--

INSERT INTO `tbl_course_year` (`Id`, `CourseId`, `year`) VALUES
(12, 1, '1st year'),
(13, 1, '2nd year'),
(14, 1, '3rd year'),
(15, 1, '4th year'),
(16, 2, '1st year'),
(17, 2, '2nd year'),
(18, 2, '3rd Year'),
(19, 2, '4th year'),
(27, 4, 'test'),
(28, 4, 'ads'),
(29, 4, 'ads');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_department`
--

CREATE TABLE IF NOT EXISTS `tbl_department` (
`Id` int(11) NOT NULL,
  `department` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_department`
--

INSERT INTO `tbl_department` (`Id`, `department`) VALUES
(3, 'department 1'),
(4, 'department 2'),
(5, 'department 3'),
(6, 'department 4'),
(7, 'department 5');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_events`
--

CREATE TABLE IF NOT EXISTS `tbl_events` (
`Id` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `DateCreated` date NOT NULL,
  `Current` int(11) NOT NULL,
  `Place` varchar(100) NOT NULL,
  `Status` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_events`
--

INSERT INTO `tbl_events` (`Id`, `Name`, `DateCreated`, `Current`, `Place`, `Status`) VALUES
(1, 'Example Event', '2016-09-19', 0, '', ''),
(2, 'asd', '2016-09-19', 0, '', ''),
(4, 'adsd22', '2016-09-24', 0, '123', ''),
(5, 'test 123', '2016-09-24', 0, '', ''),
(6, 'da', '2016-09-24', 0, 'das', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_event_details`
--

CREATE TABLE IF NOT EXISTS `tbl_event_details` (
`Id` int(11) NOT NULL,
  `MemberId` int(11) NOT NULL,
  `EventId` int(11) NOT NULL,
  `InAm` tinyint(1) NOT NULL,
  `InAmDateTime` datetime NOT NULL,
  `OutAm` tinyint(1) NOT NULL,
  `OutAmDateTime` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_event_details`
--

INSERT INTO `tbl_event_details` (`Id`, `MemberId`, `EventId`, `InAm`, `InAmDateTime`, `OutAm`, `OutAmDateTime`) VALUES
(6, 111, 4, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(7, 555, 4, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_member`
--

CREATE TABLE IF NOT EXISTS `tbl_member` (
`Id` int(11) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `middlename` varchar(100) NOT NULL,
  `gender` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `mobile_no` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `date_registered` date NOT NULL,
  `MemberTypeId` int(11) NOT NULL,
  `CourseId` int(11) NOT NULL,
  `CourseYearId` int(11) NOT NULL,
  `SectionId` int(11) NOT NULL,
  `IdNumber` varchar(50) NOT NULL,
  `DateTransfer` date NOT NULL,
  `Transfer` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_member`
--

INSERT INTO `tbl_member` (`Id`, `firstname`, `lastname`, `middlename`, `gender`, `address`, `mobile_no`, `username`, `password`, `email`, `date_registered`, `MemberTypeId`, `CourseId`, `CourseYearId`, `SectionId`, `IdNumber`, `DateTransfer`, `Transfer`) VALUES
(25, 'asd', 'asd', 'dasd', 'Male', 'dasd', '', '', '', '', '2016-09-12', 1, 2, 16, 2, '123', '2016-09-24', 1),
(27, 'student test 2', 'student test 2', 'student test 2', 'Male', 'da', 'dsad', '', '', '', '2016-09-17', 1, 2, 16, 1, '456', '2016-09-25', 1),
(28, 'student test 3', 'student test 3', 'student test 3', 'Male', '', '', '', '', '', '2016-09-23', 1, 2, 17, 4, '789', '2016-09-25', 1),
(29, ':firstname', ':lastname', ':middlename', '', '', '', '', '', '', '2016-09-01', 0, 0, 0, 0, '', '0000-00-00', 0),
(30, 'asdasd', 'das', 'dasd', '', '', '', '', '', '', '2016-09-01', 0, 0, 0, 0, '', '0000-00-00', 0),
(31, 'asdasd', 'das', 'dasd', 'Female', 'dasd', '', '', '', '', '2016-09-07', 0, 0, 0, 0, '', '0000-00-00', 0),
(32, 'asdasd', 'das', 'dasd', 'Female', 'dasd', '', '', '', '', '2016-09-06', 0, 0, 0, 0, '', '0000-00-00', 0),
(33, 'asdasd', 'das', 'dasd', 'Female', 'dasd', 'asdasd', '', '', '', '2016-09-04', 3, 2, 16, 1, '123456', '2016-09-24', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_member_type`
--

CREATE TABLE IF NOT EXISTS `tbl_member_type` (
`Id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_member_type`
--

INSERT INTO `tbl_member_type` (`Id`, `type`) VALUES
(1, 'Student'),
(3, 'Graduaties');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_roles`
--

CREATE TABLE IF NOT EXISTS `tbl_roles` (
`Id` int(11) NOT NULL,
  `role` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_roles`
--

INSERT INTO `tbl_roles` (`Id`, `role`) VALUES
(1, 'Member'),
(2, 'Product'),
(3, 'Setting'),
(4, 'OrderList');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_school_year`
--

CREATE TABLE IF NOT EXISTS `tbl_school_year` (
`Id` int(11) NOT NULL,
  `year_from` int(5) NOT NULL,
  `year_to` int(5) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_school_year`
--

INSERT INTO `tbl_school_year` (`Id`, `year_from`, `year_to`) VALUES
(3, 2013, 2014),
(4, 2015, 2016);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_section`
--

CREATE TABLE IF NOT EXISTS `tbl_section` (
`Id` int(11) NOT NULL,
  `section` varchar(100) NOT NULL,
  `CourseYearId` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_section`
--

INSERT INTO `tbl_section` (`Id`, `section`, `CourseYearId`) VALUES
(1, 'AA', 16),
(2, 'B', 16),
(3, '3', 0),
(4, '4', 17),
(5, 'A', 19),
(6, 'B', 0),
(7, 'B', 0),
(8, 'CV', 0),
(9, 'C', 16),
(10, 'D', 16);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_semester`
--

CREATE TABLE IF NOT EXISTS `tbl_semester` (
`Id` int(11) NOT NULL,
  `semester` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_semester`
--

INSERT INTO `tbl_semester` (`Id`, `semester`) VALUES
(1, '1st Semester'),
(2, '2nd Semester'),
(3, 'Summer');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_setting`
--

CREATE TABLE IF NOT EXISTS `tbl_setting` (
`Id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `settingKey` varchar(50) NOT NULL,
  `value` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_setting`
--

INSERT INTO `tbl_setting` (`Id`, `title`, `settingKey`, `value`) VALUES
(2, 'te', 'das', 'das'),
(3, '2', '32', '23');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_status`
--

CREATE TABLE IF NOT EXISTS `tbl_status` (
`Id` int(11) NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_status`
--

INSERT INTO `tbl_status` (`Id`, `status`) VALUES
(2, 'Old'),
(3, 'new'),
(4, 'das');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE IF NOT EXISTS `tbl_user` (
`user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `UserTypeId` int(11) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`user_id`, `name`, `username`, `password`, `UserTypeId`, `status`) VALUES
(3, 'john kevin lorayna', 'kevin', 'kevin', 1, 'InActive'),
(4, 'Administrator', 'admin', 'admin', 0, 'Active'),
(5, 'stephanie villanueva', 'teph', 'q', 2, 'Active'),
(8, 'das', 'sad', 'ds', 2, 'InActive');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_roles`
--

CREATE TABLE IF NOT EXISTS `tbl_user_roles` (
`Id` int(11) NOT NULL,
  `RoleId` int(11) NOT NULL,
  `UserId` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_user_roles`
--

INSERT INTO `tbl_user_roles` (`Id`, `RoleId`, `UserId`) VALUES
(49, 3, 5),
(50, 4, 5);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_type`
--

CREATE TABLE IF NOT EXISTS `tbl_user_type` (
`Id` int(11) NOT NULL,
  `user_type` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_user_type`
--

INSERT INTO `tbl_user_type` (`Id`, `user_type`) VALUES
(1, 'staff'),
(2, 'librarian'),
(3, 'Staff 1');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_year`
--

CREATE TABLE IF NOT EXISTS `tbl_year` (
`Id` int(11) NOT NULL,
  `year` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=137 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_year`
--

INSERT INTO `tbl_year` (`Id`, `year`) VALUES
(129, 2014),
(130, 2015),
(131, 2016),
(132, 2017),
(133, 2018),
(134, 2019),
(136, 2013);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_category`
--
ALTER TABLE `tbl_category`
 ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tbl_course`
--
ALTER TABLE `tbl_course`
 ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tbl_course_year`
--
ALTER TABLE `tbl_course_year`
 ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tbl_department`
--
ALTER TABLE `tbl_department`
 ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tbl_events`
--
ALTER TABLE `tbl_events`
 ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tbl_event_details`
--
ALTER TABLE `tbl_event_details`
 ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tbl_member`
--
ALTER TABLE `tbl_member`
 ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tbl_member_type`
--
ALTER TABLE `tbl_member_type`
 ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tbl_roles`
--
ALTER TABLE `tbl_roles`
 ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tbl_school_year`
--
ALTER TABLE `tbl_school_year`
 ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tbl_section`
--
ALTER TABLE `tbl_section`
 ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tbl_semester`
--
ALTER TABLE `tbl_semester`
 ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tbl_setting`
--
ALTER TABLE `tbl_setting`
 ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tbl_status`
--
ALTER TABLE `tbl_status`
 ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
 ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `tbl_user_roles`
--
ALTER TABLE `tbl_user_roles`
 ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tbl_user_type`
--
ALTER TABLE `tbl_user_type`
 ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tbl_year`
--
ALTER TABLE `tbl_year`
 ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_category`
--
ALTER TABLE `tbl_category`
MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `tbl_course`
--
ALTER TABLE `tbl_course`
MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tbl_course_year`
--
ALTER TABLE `tbl_course_year`
MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT for table `tbl_department`
--
ALTER TABLE `tbl_department`
MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `tbl_events`
--
ALTER TABLE `tbl_events`
MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `tbl_event_details`
--
ALTER TABLE `tbl_event_details`
MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `tbl_member`
--
ALTER TABLE `tbl_member`
MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT for table `tbl_member_type`
--
ALTER TABLE `tbl_member_type`
MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tbl_roles`
--
ALTER TABLE `tbl_roles`
MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tbl_school_year`
--
ALTER TABLE `tbl_school_year`
MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tbl_section`
--
ALTER TABLE `tbl_section`
MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `tbl_semester`
--
ALTER TABLE `tbl_semester`
MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tbl_setting`
--
ALTER TABLE `tbl_setting`
MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tbl_status`
--
ALTER TABLE `tbl_status`
MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `tbl_user_roles`
--
ALTER TABLE `tbl_user_roles`
MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=51;
--
-- AUTO_INCREMENT for table `tbl_user_type`
--
ALTER TABLE `tbl_user_type`
MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tbl_year`
--
ALTER TABLE `tbl_year`
MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=137;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
