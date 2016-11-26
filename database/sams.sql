-- phpMyAdmin SQL Dump
-- version 4.2.8
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 26, 2016 at 08:26 PM
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
-- Table structure for table `tbl_course`
--

CREATE TABLE IF NOT EXISTS `tbl_course` (
`Id` int(11) NOT NULL,
  `course` varchar(100) NOT NULL,
  `code` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_course`
--

INSERT INTO `tbl_course` (`Id`, `course`, `code`, `description`) VALUES
(2, 'Bachelor of Science in Information Systems', 'BSIS', ''),
(3, 'Bachelor of Science in Civil Engineering', 'BSCE', ''),
(5, 'Bachelor of Science in Hotel and Restaurant Management', 'BSHRM', ''),
(6, 'Bachelor of Science in Industrial Technology', 'BSIT', ''),
(7, 'Bachelor of Secondary Education', 'BSED', ''),
(8, 'Bachelor of Elementary Education', 'BEED', ''),
(9, 'Bachelor of Arts', 'AB', ''),
(10, 'ertwerwerwe', 'abs', ''),
(14, 'dfasdfsdf', 'kkfhdf', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_course_year`
--

CREATE TABLE IF NOT EXISTS `tbl_course_year` (
`Id` int(11) NOT NULL,
  `CourseId` int(11) NOT NULL,
  `year` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=latin1;

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
(19, 2, '4th Year'),
(27, 4, 'test'),
(28, 4, 'ads'),
(29, 4, 'ads'),
(34, 9, '1st Year'),
(35, 9, '2nd Year'),
(37, 6, '1st Year'),
(38, 6, '2nd Year'),
(39, 6, '3rd Year'),
(40, 6, '4th Year'),
(41, 5, '1st Year'),
(42, 5, '2nd Year'),
(43, 5, '3rd Year'),
(44, 5, '4th Year'),
(45, 7, '1st Year'),
(46, 7, '2nd Year'),
(47, 7, '3rd Year'),
(48, 7, '4th Year'),
(49, 8, '1st Year'),
(50, 8, '2nd Year'),
(51, 8, '3rd Year'),
(52, 8, '4th Year'),
(53, 3, '1st Year'),
(54, 3, '2nd Year'),
(55, 3, '3rd Year'),
(56, 3, '4th Year'),
(57, 3, '5th Year'),
(58, 9, '3rd year'),
(59, 9, '4th Year');

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
  `Status` varchar(50) NOT NULL,
  `SchoolYearId` int(11) NOT NULL,
  `Semester` varchar(50) NOT NULL,
  `TimeType` varchar(50) NOT NULL,
  `EventDate` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_events`
--

INSERT INTO `tbl_events` (`Id`, `Name`, `DateCreated`, `Current`, `Place`, `Status`, `SchoolYearId`, `Semester`, `TimeType`, `EventDate`) VALUES
(8, 'Social Bash', '2016-09-29', 0, 'Open Field', 'Active', 5, '2nd Semester', 'Time-OUT PM', '2016-11-21'),
(9, 'Intramurals', '2016-09-29', 0, 'Anywhere in the campus', 'Active', 5, '2nd Semester', 'Time-IN AM', '2016-11-22'),
(10, 'Teachers Day', '2016-09-29', 0, 'Gym', 'Active', 5, '2nd Semester', 'Time-IN AM', '2016-11-08'),
(11, 'College week', '2016-09-29', 0, 'Anywhere in the campus', 'Active', 5, '2nd Semester', 'Time-IN AM', '2016-11-29'),
(12, 'Intercampus Meet', '2016-09-29', 0, 'Anywhere in the campus', 'InActive', 5, '2nd Semester', 'Time-IN AM', '2016-11-20');

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
  `OutAmDateTime` datetime NOT NULL,
  `InPm` tinyint(1) NOT NULL,
  `InPmDateTim` datetime NOT NULL,
  `OutPm` tinyint(1) NOT NULL,
  `OutPmDateTim` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_event_details`
--

INSERT INTO `tbl_event_details` (`Id`, `MemberId`, `EventId`, `InAm`, `InAmDateTime`, `OutAm`, `OutAmDateTime`, `InPm`, `InPmDateTim`, `OutPm`, `OutPmDateTim`) VALUES
(56, 40, 10, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(57, 39, 10, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(58, 43, 10, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(59, 39, 11, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00');

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
  `email` varchar(100) NOT NULL,
  `date_registered` date NOT NULL,
  `MemberTypeId` int(11) NOT NULL,
  `CourseId` int(11) NOT NULL,
  `CourseYearId` int(11) NOT NULL,
  `SectionId` int(11) NOT NULL,
  `IdNumber` varchar(50) NOT NULL,
  `DateTransfer` date NOT NULL,
  `Transfer` tinyint(1) NOT NULL,
  `Barcode` varchar(100) NOT NULL,
  `ImageUrl` varchar(200) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_member`
--

INSERT INTO `tbl_member` (`Id`, `firstname`, `lastname`, `middlename`, `gender`, `address`, `mobile_no`, `email`, `date_registered`, `MemberTypeId`, `CourseId`, `CourseYearId`, `SectionId`, `IdNumber`, `DateTransfer`, `Transfer`, `Barcode`, `ImageUrl`) VALUES
(39, 'Arnela Mae', 'Mesa', 'G.', 'Female', 'Silay City', '', 'arnelamae@gmail.com', '2016-10-16', 1, 6, 37, 27, '20140001', '2016-11-23', 1, '888', '9798_Koala.jpg'),
(40, 'Micole Marie', 'Dioma', 'C.', 'Female', 'Ruins, Talisay City', '656234236', 'Micolemarie@yahoo.com', '2016-10-16', 1, 7, 46, 59, '20140002', '2016-11-09', 1, '123', '2163_Lighthouse.jpg'),
(41, 'Carlo', 'Siason', 'K.', 'Male', 'Silay City', '', 'carlosiason@gmail.com', '2016-10-16', 1, 9, 34, 19, '20140003', '2016-11-09', 1, '456', '9176_Koala.jpg'),
(42, 'Elyza Mae', 'Murallo', 'C.', 'Female', 'Silay City', '', 'Meimurallo@gmail.com', '2016-10-16', 1, 2, 19, 18, '20140004', '2016-11-09', 0, '2346', '3386_Jellyfish.jpg'),
(43, 'Donard', 'Ytienza', 'M.', 'Male', 'Mandalagan, Bacolod City', '', 'Mcdonard@gmail.com', '2016-10-16', 1, 6, 39, 35, '20140005', '2016-11-09', 0, '222', ''),
(44, 'Rica', 'Gelera', 'S.', 'Female', 'Victorias City', '', 'Ricabebe@gmail.com', '2016-10-16', 1, 3, 57, 92, '20140006', '0000-00-00', 0, '', ''),
(45, 'Eric John', 'Dela Cruz', 'A.', 'Male', 'Talisay City', '', 'Ericjohn@gmail.com', '2016-10-16', 1, 5, 42, 45, '20140007', '0000-00-00', 0, '', ''),
(46, 'Jake', 'Cordero', 'S.', 'Male', 'Silay City', '', 'Jakethesnake@gmail.com', '2016-10-16', 1, 2, 19, 18, '20140008', '0000-00-00', 0, '', ''),
(47, 'Lourdelyn', 'Bibas', 'H.', 'Female', 'Talisay City', '', 'Bibas_3476@gmail.com', '2016-10-16', 1, 8, 51, 76, '20140009', '0000-00-00', 0, '', ''),
(48, 'Giu Matthew', 'Cuesta', 'O.', 'Male', 'Silay City', '', 'Cuesta_giu@gmail.com', '2016-10-16', 3, 2, 19, 18, '20140010', '2016-11-13', 1, '887', ''),
(49, 'Amira', 'Demavivas', 'L', 'Female', 'E.B Magalona', '', 'Amiracle@gmail.com', '2016-10-16', 1, 8, 49, 69, '20140011', '0000-00-00', 1, '', ''),
(50, 'Leah', 'Valente', 'G.', 'Female', 'Silay City', '', 'Leah23@gmail.com', '2016-10-16', 1, 7, 46, 58, '20140012', '0000-00-00', 1, '', ''),
(51, 'Jade', 'Solano', 'C.', 'Male', 'Talisay City', '', 'Jade001@gmail.com', '2016-10-16', 1, 5, 43, 50, '20140013', '0000-00-00', 1, '', ''),
(52, 'Carl Francis', 'Villanueva', 'L.', 'Male', 'Bacolod City', '', 'Yasuo_carl@gmail.com', '2016-10-16', 1, 3, 54, 83, '20140014', '0000-00-00', 1, '', ''),
(53, 'Renzy Ivan', 'Loren', 'Y.', 'Male', 'Silay City', '', 'Babyboy@yahoo.com', '2016-10-16', 1, 9, 35, 22, '20140015', '0000-00-00', 0, '', ''),
(54, 'Joven', 'Diojoy', 'B.', 'Male', 'Talisay City', '', 'YouandMe@gmail.com', '2016-10-16', 1, 2, 19, 18, '20140016', '0000-00-00', 0, '', ''),
(55, 'Cheska', 'Aposaga', 'S.', 'Female', 'E.B Magalona', '', 'AposagaChess@gmail.com', '2016-10-16', 1, 5, 43, 48, '20140017', '0000-00-00', 0, '', ''),
(56, 'Jemelyn', 'Malan', 'E.', 'Female', 'Bacolod City', '', 'MalanJem@gmail.com', '2016-10-16', 1, 5, 41, 43, '20140018', '0000-00-00', 0, '', ''),
(57, 'Eduardo', 'LascoÃ±a', 'P.', 'Male', 'Eroreco, Bacolod City', '', 'MrPerfect@gmail.com', '2016-10-16', 1, 8, 52, 77, '20140019', '0000-00-00', 0, '', ''),
(58, 'Kevin', 'Grajo', 'D.', 'Male', 'Talisay City', '', 'Kevingrajo@gmail.com', '2016-10-16', 1, 6, 40, 38, '20140020', '0000-00-00', 0, '', ''),
(59, 'Ronnel', 'De la torre', 'I.', 'Male', 'Bata, Bacolod City', '', 'ronneldelatorre@yahoo.com', '2016-10-16', 1, 3, 57, 92, '20140021', '0000-00-00', 0, '', ''),
(60, 'Deolita Rose', 'Debuyan', 'K.', 'Female', 'E.B Magalona', '', 'Kairuzlee@yahoo.com', '2016-10-16', 1, 7, 45, 56, '20140022', '0000-00-00', 0, '', ''),
(61, 'Marefel', 'Panes', 'E.', 'Female', 'Silay City', '', 'Boompanes@gmail.com', '2016-10-16', 1, 5, 41, 40, '20140023', '0000-00-00', 0, '', ''),
(62, 'Kimberlyn', 'Mongcal', 'O.', 'Female', 'Talisay City', '', 'Kimkim@gmail.com', '2016-10-16', 1, 7, 46, 59, '20140024', '0000-00-00', 0, '', ''),
(63, 'Mernel', 'Seran', 'S.', 'Female', 'E.B Magalona', '', 'Seran@gmail.com', '2016-10-16', 1, 8, 52, 78, '20140025', '0000-00-00', 0, '', ''),
(64, 'Nicole', 'Castro', 'V.', 'Female', 'Talisay City', '', 'Nicolebukol@gmail.com', '2016-10-16', 1, 9, 34, 19, '20140026', '0000-00-00', 0, '', ''),
(65, 'Rose Ann', 'Balladares', 'C.', 'Female', 'Manapla', '', 'Judyann@yahoo.com', '2016-10-16', 1, 3, 54, 85, '20140027', '0000-00-00', 0, '', ''),
(66, 'Axel', 'De Asis', 'T.', 'Male', 'Talisay City', '', 'AxelD@gmail.com', '2016-10-16', 1, 3, 56, 90, '20140028', '0000-00-00', 0, '', ''),
(67, 'Kristell Marvie', 'Paclibar', 'D.', 'Female', 'La Carlota City', '', 'Teltel@yahoo.com', '2016-10-16', 1, 2, 19, 18, '20140030', '0000-00-00', 0, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_member_type`
--

CREATE TABLE IF NOT EXISTS `tbl_member_type` (
`Id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `EnableAdd` int(5) NOT NULL,
  `EnableBarcode` int(5) NOT NULL,
  `Movable` tinyint(4) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_member_type`
--

INSERT INTO `tbl_member_type` (`Id`, `type`, `EnableAdd`, `EnableBarcode`, `Movable`) VALUES
(1, 'Student', 1, 1, 1),
(3, 'Graduates', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_roles`
--

CREATE TABLE IF NOT EXISTS `tbl_roles` (
`Id` int(11) NOT NULL,
  `role` varchar(100) NOT NULL,
  `OrderNo` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_roles`
--

INSERT INTO `tbl_roles` (`Id`, `role`, `OrderNo`) VALUES
(1, 'Member', 0),
(2, 'User List', 0),
(3, 'Event', 0),
(4, 'Generate Barcode', 0),
(5, 'School Year', 0),
(6, 'User Type', 0),
(7, 'Member Type', 0),
(8, 'Semester', 0),
(9, 'Course', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_school_year`
--

CREATE TABLE IF NOT EXISTS `tbl_school_year` (
`Id` int(11) NOT NULL,
  `YearFrom` int(5) NOT NULL,
  `YearTo` int(5) NOT NULL,
  `Current` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_school_year`
--

INSERT INTO `tbl_school_year` (`Id`, `YearFrom`, `YearTo`, `Current`) VALUES
(3, 2013, 2014, 0),
(4, 2015, 2016, 0),
(5, 2017, 2018, 1),
(6, 2012, 2013, 0),
(8, 2018, 2019, 0),
(9, 2019, 2020, 0),
(10, 2020, 2021, 0),
(11, 2021, 2022, 0),
(12, 2022, 2023, 0),
(13, 2023, 2024, 0),
(14, 2024, 2025, 0),
(15, 2025, 2026, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_section`
--

CREATE TABLE IF NOT EXISTS `tbl_section` (
`Id` int(11) NOT NULL,
  `section` varchar(100) NOT NULL,
  `CourseYearId` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=105 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_section`
--

INSERT INTO `tbl_section` (`Id`, `section`, `CourseYearId`) VALUES
(1, 'A', 16),
(2, 'B', 16),
(3, '3', 0),
(4, 'A', 17),
(5, 'A', 19),
(6, 'B', 0),
(7, 'B', 0),
(8, 'CV', 0),
(9, 'C', 16),
(10, 'D', 16),
(12, 'B', 17),
(13, 'C', 17),
(14, 'D', 17),
(15, 'A', 18),
(16, 'B', 18),
(17, 'C', 18),
(18, 'B', 19),
(19, 'A', 34),
(20, 'B', 34),
(21, 'A', 35),
(22, 'B', 35),
(23, 'C', 35),
(24, 'A', 37),
(25, 'B', 37),
(26, 'C', 37),
(27, 'D', 37),
(28, 'E', 37),
(29, 'F', 37),
(30, 'A', 38),
(31, 'B', 38),
(32, 'C', 38),
(33, 'D', 38),
(34, 'A', 39),
(35, 'B', 39),
(36, 'C', 39),
(37, 'D', 39),
(38, 'A', 40),
(39, 'B', 40),
(40, 'A', 41),
(41, 'B', 41),
(42, 'C', 41),
(43, 'D', 41),
(44, 'A', 42),
(45, 'B', 42),
(46, 'C', 42),
(47, 'D', 42),
(48, 'A', 43),
(49, 'B', 43),
(50, 'C', 43),
(51, 'A', 44),
(52, 'B', 44),
(53, 'A', 45),
(54, 'B', 45),
(55, 'C', 45),
(56, 'D', 45),
(57, 'A', 46),
(58, 'B', 46),
(59, 'C', 46),
(60, 'D', 46),
(61, 'A', 47),
(62, 'B', 47),
(63, 'C', 47),
(64, 'A', 48),
(65, 'B', 48),
(66, 'A', 49),
(67, 'B', 49),
(68, 'C', 49),
(69, 'D', 49),
(70, 'A', 50),
(71, 'B', 50),
(72, 'C', 50),
(73, 'D', 50),
(74, 'A', 51),
(75, 'B', 51),
(76, 'C', 51),
(77, 'A', 52),
(78, 'B', 52),
(79, 'A', 53),
(80, 'B', 53),
(81, 'C', 53),
(82, 'D', 53),
(83, 'A', 54),
(84, 'B', 54),
(85, 'C', 54),
(86, 'D', 54),
(87, 'A', 55),
(88, 'B', 55),
(89, 'C', 55),
(90, 'A', 56),
(91, 'B', 56),
(92, 'A', 57),
(93, 'B', 57),
(94, 'C', 34),
(104, 'D', 34);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_semester`
--

CREATE TABLE IF NOT EXISTS `tbl_semester` (
`Id` int(11) NOT NULL,
  `Semester` varchar(50) NOT NULL,
  `Current` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_semester`
--

INSERT INTO `tbl_semester` (`Id`, `Semester`, `Current`) VALUES
(1, '1st Semester', 0),
(2, '2nd Semester', 1),
(3, 'Summer', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_status`
--

CREATE TABLE IF NOT EXISTS `tbl_status` (
`Id` int(11) NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_status`
--

INSERT INTO `tbl_status` (`Id`, `status`) VALUES
(2, 'Old'),
(3, 'New');

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
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`user_id`, `name`, `username`, `password`, `UserTypeId`, `status`) VALUES
(4, 'Administrator', 'admin', 'admin', 0, 'Active'),
(8, 'Eliseo Beatingo', 'ilesh16', 'hyperlink', 1, 'Active'),
(9, 'Razel Joy Bacan', 'razz', '12345', 3, 'Active'),
(20, 'sdahfasd', 'sdfasd', 'hsdfgsa', 1, 'Active'),
(21, 'fgdfgasdfa', 'gdsgadgf', 'fghdfghdf', 1, 'Active'),
(22, 'fgdfgasdfa', 'gdsgadgf', 'fghdfghdf', 1, 'Active'),
(23, 'fgdfgdf', 'gdfgdfg', 'hfghfg', 1, 'Active'),
(24, 'ghjdfsdf', 'asdfi5twe', '453451', 1, 'Active'),
(25, 'adasda', 'dfgdsgf', 'fwerwe', 1, 'Active'),
(26, 'passive', 'pass', '1234', 1, 'InActive'),
(27, 'dfgdfgd', 'kighf', '123621', 1, 'Active'),
(28, 'fgjgkgjh', 'asfdfhdfgh', '56f3w24', 1, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_roles`
--

CREATE TABLE IF NOT EXISTS `tbl_user_roles` (
`Id` int(11) NOT NULL,
  `RoleId` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `AllowView` tinyint(4) NOT NULL,
  `AllowAdd` tinyint(4) NOT NULL,
  `AllowEdit` tinyint(4) NOT NULL,
  `AllowDelete` tinyint(4) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=97 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_user_roles`
--

INSERT INTO `tbl_user_roles` (`Id`, `RoleId`, `UserId`, `AllowView`, `AllowAdd`, `AllowEdit`, `AllowDelete`) VALUES
(79, 1, 8, 1, 1, 1, 1),
(80, 2, 8, 0, 0, 0, 0),
(81, 3, 8, 0, 0, 0, 0),
(82, 4, 8, 1, 1, 1, 1),
(83, 5, 8, 0, 0, 0, 0),
(84, 6, 8, 0, 0, 0, 0),
(85, 7, 8, 0, 0, 0, 0),
(86, 8, 8, 0, 0, 0, 0),
(87, 9, 8, 0, 0, 0, 0),
(88, 1, 9, 0, 0, 0, 0),
(89, 2, 9, 0, 0, 0, 0),
(90, 3, 9, 1, 1, 1, 1),
(91, 4, 9, 0, 0, 0, 0),
(92, 5, 9, 1, 1, 1, 1),
(93, 6, 9, 0, 0, 0, 0),
(94, 7, 9, 0, 0, 0, 0),
(95, 8, 9, 1, 1, 1, 1),
(96, 9, 9, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_type`
--

CREATE TABLE IF NOT EXISTS `tbl_user_type` (
`Id` int(11) NOT NULL,
  `user_type` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_user_type`
--

INSERT INTO `tbl_user_type` (`Id`, `user_type`) VALUES
(1, 'Registration Staff'),
(3, 'Attendance Staff'),
(4, 'asdasd'),
(5, 'asdasd'),
(6, 'asdasd'),
(7, 'asdasda'),
(8, 'asgsdfgdf'),
(9, 'dffjfgh');

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
-- AUTO_INCREMENT for table `tbl_course`
--
ALTER TABLE `tbl_course`
MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `tbl_course_year`
--
ALTER TABLE `tbl_course_year`
MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=60;
--
-- AUTO_INCREMENT for table `tbl_events`
--
ALTER TABLE `tbl_events`
MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `tbl_event_details`
--
ALTER TABLE `tbl_event_details`
MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=60;
--
-- AUTO_INCREMENT for table `tbl_member`
--
ALTER TABLE `tbl_member`
MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=68;
--
-- AUTO_INCREMENT for table `tbl_member_type`
--
ALTER TABLE `tbl_member_type`
MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tbl_roles`
--
ALTER TABLE `tbl_roles`
MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `tbl_school_year`
--
ALTER TABLE `tbl_school_year`
MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `tbl_section`
--
ALTER TABLE `tbl_section`
MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=105;
--
-- AUTO_INCREMENT for table `tbl_semester`
--
ALTER TABLE `tbl_semester`
MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tbl_status`
--
ALTER TABLE `tbl_status`
MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `tbl_user_roles`
--
ALTER TABLE `tbl_user_roles`
MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=97;
--
-- AUTO_INCREMENT for table `tbl_user_type`
--
ALTER TABLE `tbl_user_type`
MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `tbl_year`
--
ALTER TABLE `tbl_year`
MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=137;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
