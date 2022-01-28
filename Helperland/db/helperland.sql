-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 28, 2022 at 05:23 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `helperland`
--

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

CREATE TABLE `city` (
  `Id` int(11) NOT NULL,
  `CityName` varchar(50) NOT NULL,
  `StateId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `contactus`
--

CREATE TABLE `contactus` (
  `ContactUsId` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Email` varchar(200) NOT NULL,
  `SubjectType` varchar(100) NOT NULL,
  `Subject` varchar(500) DEFAULT NULL,
  `PhoneNumber` varchar(20) NOT NULL,
  `Message` longtext NOT NULL,
  `UploadFileName` varchar(100) DEFAULT NULL,
  `CreatedOn` datetime(3) DEFAULT NULL,
  `CreatedBy` int(11) DEFAULT NULL,
  `Status` int(11) DEFAULT NULL,
  `Priority` int(11) DEFAULT NULL,
  `AssignedToUser` int(11) DEFAULT NULL,
  `IsDeleted` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contactus`
--

INSERT INTO `contactus` (`ContactUsId`, `Name`, `Email`, `SubjectType`, `Subject`, `PhoneNumber`, `Message`, `UploadFileName`, `CreatedOn`, `CreatedBy`, `Status`, `Priority`, `AssignedToUser`, `IsDeleted`) VALUES
(1, 'Shailesh Lakhani', 'shaileshlakhani1234@gmail.com', '', 'Inquiry', '8469116765', 'Where do we get the next discount?', '18SOECE11028_Shailesh Lakhani.jpeg', NULL, NULL, NULL, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `contactusattachment`
--

CREATE TABLE `contactusattachment` (
  `ContactUsAttachmentId` int(11) NOT NULL,
  `ContactUsId` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `FileName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contactusattachment`
--

INSERT INTO `contactusattachment` (`ContactUsAttachmentId`, `ContactUsId`, `Name`, `FileName`) VALUES
(1, 1, 'Shailesh Lakhani', '18SOECE11028_Shailesh Lakhani.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `favoriteandblocked`
--

CREATE TABLE `favoriteandblocked` (
  `Id` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `TargetUserId` int(11) NOT NULL,
  `IsFavorite` tinyint(4) NOT NULL,
  `IsBlocked` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE `rating` (
  `RatingId` int(11) NOT NULL,
  `ServiceRequestId` int(11) NOT NULL,
  `RatingFrom` int(11) NOT NULL,
  `RatingTo` int(11) NOT NULL,
  `Ratings` decimal(2,1) NOT NULL,
  `Comments` varchar(2000) DEFAULT NULL,
  `RatingDate` datetime(3) NOT NULL,
  `IsApproved` tinyint(4) DEFAULT 1,
  `VisibleOnHomeScreen` tinyint(4) NOT NULL DEFAULT 0,
  `OnTimeArrival` decimal(2,1) NOT NULL DEFAULT 0.0,
  `Friendly` decimal(2,1) NOT NULL DEFAULT 0.0,
  `QualityOfService` decimal(2,1) NOT NULL DEFAULT 0.0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `servicerequest`
--

CREATE TABLE `servicerequest` (
  `ServiceRequestId` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `ServiceId` int(11) NOT NULL,
  `ServiceStartDate` datetime(3) NOT NULL,
  `ZipCode` varchar(10) NOT NULL,
  `ServiceFrequency` tinyint(3) UNSIGNED DEFAULT NULL,
  `ServiceHourlyRate` decimal(8,2) DEFAULT NULL,
  `ServiceHours` double NOT NULL,
  `ExtraHours` double DEFAULT NULL,
  `SubTotal` decimal(8,2) NOT NULL,
  `Discount` decimal(8,2) DEFAULT NULL,
  `TotalCost` decimal(8,2) NOT NULL,
  `Comments` varchar(500) DEFAULT NULL,
  `PaymentTransactionRefNo` varchar(50) DEFAULT NULL,
  `PaymentDue` tinyint(4) NOT NULL DEFAULT 0,
  `JobStatus` tinyint(3) UNSIGNED DEFAULT NULL,
  `ServiceProviderId` int(11) DEFAULT NULL,
  `SPAcceptedDate` datetime(3) DEFAULT NULL,
  `HasPets` tinyint(4) NOT NULL DEFAULT 0,
  `Status` int(11) DEFAULT NULL,
  `CreatedDate` datetime(3) NOT NULL DEFAULT current_timestamp(3),
  `ModifiedDate` datetime(3) NOT NULL DEFAULT current_timestamp(3),
  `ModifiedBy` int(11) DEFAULT NULL,
  `RefundedAmount` decimal(8,2) DEFAULT NULL,
  `Distance` decimal(18,2) NOT NULL DEFAULT 0.00,
  `HasIssue` tinyint(4) DEFAULT NULL,
  `PaymentDone` tinyint(4) DEFAULT NULL,
  `RecordVersion` char(36) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `servicerequestaddress`
--

CREATE TABLE `servicerequestaddress` (
  `Id` int(11) NOT NULL,
  `ServiceRequestId` int(11) DEFAULT NULL,
  `AddressLine1` varchar(200) DEFAULT NULL,
  `AddressLine2` varchar(200) DEFAULT NULL,
  `City` varchar(50) DEFAULT NULL,
  `State` varchar(50) DEFAULT NULL,
  `PostalCode` varchar(20) DEFAULT NULL,
  `Mobile` varchar(20) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Type` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `servicerequestextra`
--

CREATE TABLE `servicerequestextra` (
  `ServiceRequestExtraId` int(11) NOT NULL,
  `ServiceRequestId` int(11) NOT NULL,
  `ServiceExtraId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `servicesetting`
--

CREATE TABLE `servicesetting` (
  `Id` int(11) NOT NULL,
  `ActionType` int(11) NOT NULL,
  `Interval` int(11) NOT NULL,
  `ScheduleTime` time(6) NOT NULL,
  `LastPoll` datetime(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `state`
--

CREATE TABLE `state` (
  `Id` int(11) NOT NULL,
  `StateName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `UserId` int(11) NOT NULL,
  `FirstName` varchar(100) NOT NULL,
  `LastName` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Password` varchar(100) DEFAULT NULL,
  `Mobile` varchar(20) NOT NULL,
  `UserTypeId` int(11) NOT NULL,
  `RoleId` int(11) DEFAULT NULL,
  `Gender` int(11) DEFAULT NULL,
  `DateOfBirth` datetime(3) DEFAULT NULL,
  `WebSite` varchar(1000) DEFAULT NULL,
  `UserProfilePicture` varchar(200) DEFAULT NULL,
  `IsRegisteredUser` tinyint(4) NOT NULL DEFAULT 0,
  `PaymentGatewayUserRef` varchar(200) DEFAULT NULL,
  `ZipCode` varchar(20) DEFAULT NULL,
  `WorksWithPets` tinyint(4) NOT NULL DEFAULT 0,
  `LanguageId` int(11) DEFAULT NULL,
  `NationalityId` int(11) DEFAULT NULL,
  `ResetKey` varchar(200) DEFAULT NULL,
  `CreatedDate` datetime(3) NOT NULL,
  `ModifiedDate` datetime(3) NOT NULL,
  `ModifiedBy` int(11) NOT NULL,
  `IsApproved` tinyint(4) NOT NULL DEFAULT 0,
  `IsActive` tinyint(4) NOT NULL DEFAULT 0,
  `IsDeleted` tinyint(4) NOT NULL DEFAULT 0,
  `Status` int(11) DEFAULT NULL,
  `IsOnline` tinyint(4) NOT NULL DEFAULT 0,
  `BankTokenId` varchar(100) DEFAULT NULL,
  `TaxNo` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `useraddress`
--

CREATE TABLE `useraddress` (
  `AddressId` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `AddressLine1` varchar(200) NOT NULL,
  `AddressLine2` varchar(200) DEFAULT NULL,
  `City` varchar(50) NOT NULL,
  `State` varchar(50) DEFAULT NULL,
  `PostalCode` varchar(20) NOT NULL,
  `IsDefault` tinyint(4) NOT NULL DEFAULT 0,
  `IsDeleted` tinyint(4) NOT NULL DEFAULT 0,
  `Mobile` varchar(20) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Type` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `zipcode`
--

CREATE TABLE `zipcode` (
  `Id` int(11) NOT NULL,
  `ZipcodeValue` varchar(50) NOT NULL,
  `CityId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `contactus`
--
ALTER TABLE `contactus`
  ADD PRIMARY KEY (`ContactUsId`);

--
-- Indexes for table `contactusattachment`
--
ALTER TABLE `contactusattachment`
  ADD PRIMARY KEY (`ContactUsAttachmentId`);

--
-- Indexes for table `favoriteandblocked`
--
ALTER TABLE `favoriteandblocked`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`RatingId`);

--
-- Indexes for table `servicerequest`
--
ALTER TABLE `servicerequest`
  ADD PRIMARY KEY (`ServiceRequestId`);

--
-- Indexes for table `servicerequestaddress`
--
ALTER TABLE `servicerequestaddress`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `servicerequestextra`
--
ALTER TABLE `servicerequestextra`
  ADD PRIMARY KEY (`ServiceRequestExtraId`);

--
-- Indexes for table `servicesetting`
--
ALTER TABLE `servicesetting`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `state`
--
ALTER TABLE `state`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`UserId`);

--
-- Indexes for table `useraddress`
--
ALTER TABLE `useraddress`
  ADD PRIMARY KEY (`AddressId`);

--
-- Indexes for table `zipcode`
--
ALTER TABLE `zipcode`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `city`
--
ALTER TABLE `city`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contactus`
--
ALTER TABLE `contactus`
  MODIFY `ContactUsId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `contactusattachment`
--
ALTER TABLE `contactusattachment`
  MODIFY `ContactUsAttachmentId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `favoriteandblocked`
--
ALTER TABLE `favoriteandblocked`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rating`
--
ALTER TABLE `rating`
  MODIFY `RatingId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `servicerequest`
--
ALTER TABLE `servicerequest`
  MODIFY `ServiceRequestId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `servicerequestaddress`
--
ALTER TABLE `servicerequestaddress`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `servicerequestextra`
--
ALTER TABLE `servicerequestextra`
  MODIFY `ServiceRequestExtraId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `servicesetting`
--
ALTER TABLE `servicesetting`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `state`
--
ALTER TABLE `state`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `UserId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `useraddress`
--
ALTER TABLE `useraddress`
  MODIFY `AddressId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `zipcode`
--
ALTER TABLE `zipcode`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
