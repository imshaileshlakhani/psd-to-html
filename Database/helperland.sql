-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 21, 2022 at 10:50 AM
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
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `Address_id` int(11) NOT NULL,
  `User_id` int(11) NOT NULL,
  `House_number` varchar(10) NOT NULL,
  `Postal_code` varchar(10) NOT NULL,
  `City` varchar(20) NOT NULL,
  `State_name` varchar(20) NOT NULL,
  `Is_address_selected` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `blockcustomer`
--

CREATE TABLE `blockcustomer` (
  `BlockCustomer_id` int(11) NOT NULL,
  `Servicer_id` int(11) NOT NULL,
  `Block_customer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `contactus`
--

CREATE TABLE `contactus` (
  `ContactUs_id` int(11) NOT NULL,
  `First_name` varchar(15) NOT NULL,
  `Last_name` varchar(15) NOT NULL,
  `Email` varchar(25) NOT NULL,
  `Mobile` int(10) NOT NULL,
  `Subject` varchar(255) NOT NULL,
  `Message` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `extraservice`
--

CREATE TABLE `extraservice` (
  `Extra_service_id` int(11) NOT NULL,
  `ServiceSchedule_id` int(11) NOT NULL,
  `ExtraService_name` varchar(25) NOT NULL,
  `Extra_amount` int(11) NOT NULL,
  `Extra_time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `favourite_block_servicer`
--

CREATE TABLE `favourite_block_servicer` (
  `FavouriteServicer_id` int(11) NOT NULL,
  `Customer_id` int(11) NOT NULL,
  `Servicer_id` int(11) NOT NULL,
  `Is_fav` tinyint(1) NOT NULL,
  `Is_block` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `postalcode`
--

CREATE TABLE `postalcode` (
  `Postalcode_id` int(11) NOT NULL,
  `Postalcode` int(11) NOT NULL,
  `City` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE `rating` (
  `Rating_id` int(11) NOT NULL,
  `ServiceSchedule_id` int(11) NOT NULL,
  `On_time_arrival` int(11) NOT NULL,
  `Friendly` int(11) NOT NULL,
  `Quality_service` int(11) NOT NULL,
  `Feedback` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `servicer`
--

CREATE TABLE `servicer` (
  `Id` int(11) NOT NULL,
  `Servicer_id` int(11) NOT NULL,
  `With_pet` tinyint(1) NOT NULL,
  `Radius` int(11) NOT NULL,
  `Avtar` varchar(20) NOT NULL,
  `Is_verified` tinyint(1) NOT NULL,
  `Nationality` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `serviceschedule`
--

CREATE TABLE `serviceschedule` (
  `ServiceSchedule_id` int(11) NOT NULL,
  `Customer_id` int(11) NOT NULL,
  `Servicer_id` int(11) NOT NULL,
  `Service_date` varchar(10) NOT NULL,
  `Service_time` varchar(10) NOT NULL,
  `Working_hour` varchar(10) NOT NULL,
  `Comment` varchar(255) NOT NULL,
  `Having_pat` tinyint(1) NOT NULL,
  `Promocode` varchar(20) NOT NULL,
  `Service_status_id` int(11) NOT NULL,
  `Total_payment` int(11) NOT NULL,
  `Address_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `servicestatus`
--

CREATE TABLE `servicestatus` (
  `ServiceStatus_id` int(11) NOT NULL,
  `ServiceStatus_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `User_id` int(11) NOT NULL,
  `UserType_id` int(11) NOT NULL,
  `First_name` varchar(15) NOT NULL,
  `Last_name` varchar(15) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Mobile` int(10) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Date_Of_Birth` varchar(20) NOT NULL,
  `Gender` varchar(10) NOT NULL,
  `Preferred_language` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `usertype`
--

CREATE TABLE `usertype` (
  `UserType_id` int(11) NOT NULL,
  `UserType_name` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`Address_id`),
  ADD KEY `User_id` (`User_id`);

--
-- Indexes for table `blockcustomer`
--
ALTER TABLE `blockcustomer`
  ADD PRIMARY KEY (`BlockCustomer_id`),
  ADD KEY `Block_customer_id` (`Block_customer_id`),
  ADD KEY `Servicer` (`Servicer_id`);

--
-- Indexes for table `contactus`
--
ALTER TABLE `contactus`
  ADD PRIMARY KEY (`ContactUs_id`);

--
-- Indexes for table `extraservice`
--
ALTER TABLE `extraservice`
  ADD PRIMARY KEY (`Extra_service_id`),
  ADD KEY `ServiceSchedule_id` (`ServiceSchedule_id`);

--
-- Indexes for table `favourite_block_servicer`
--
ALTER TABLE `favourite_block_servicer`
  ADD PRIMARY KEY (`FavouriteServicer_id`),
  ADD KEY `CustomerID` (`Customer_id`),
  ADD KEY `Servicer-id` (`Servicer_id`);

--
-- Indexes for table `postalcode`
--
ALTER TABLE `postalcode`
  ADD PRIMARY KEY (`Postalcode_id`);

--
-- Indexes for table `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`Rating_id`),
  ADD KEY `ServiceScheduleID` (`ServiceSchedule_id`);

--
-- Indexes for table `servicer`
--
ALTER TABLE `servicer`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Servicer_id` (`Servicer_id`);

--
-- Indexes for table `serviceschedule`
--
ALTER TABLE `serviceschedule`
  ADD PRIMARY KEY (`ServiceSchedule_id`),
  ADD KEY `Customer_id` (`Customer_id`),
  ADD KEY `Service_status_id` (`Service_status_id`),
  ADD KEY `Address_id` (`Address_id`),
  ADD KEY `ServicerID` (`Servicer_id`);

--
-- Indexes for table `servicestatus`
--
ALTER TABLE `servicestatus`
  ADD PRIMARY KEY (`ServiceStatus_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`User_id`),
  ADD KEY `UserType_id` (`UserType_id`);

--
-- Indexes for table `usertype`
--
ALTER TABLE `usertype`
  ADD PRIMARY KEY (`UserType_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `Address_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blockcustomer`
--
ALTER TABLE `blockcustomer`
  MODIFY `BlockCustomer_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contactus`
--
ALTER TABLE `contactus`
  MODIFY `ContactUs_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `extraservice`
--
ALTER TABLE `extraservice`
  MODIFY `Extra_service_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `favourite_block_servicer`
--
ALTER TABLE `favourite_block_servicer`
  MODIFY `FavouriteServicer_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `postalcode`
--
ALTER TABLE `postalcode`
  MODIFY `Postalcode_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rating`
--
ALTER TABLE `rating`
  MODIFY `Rating_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `servicer`
--
ALTER TABLE `servicer`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `serviceschedule`
--
ALTER TABLE `serviceschedule`
  MODIFY `ServiceSchedule_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `servicestatus`
--
ALTER TABLE `servicestatus`
  MODIFY `ServiceStatus_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `User_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `usertype`
--
ALTER TABLE `usertype`
  MODIFY `UserType_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `User_id` FOREIGN KEY (`User_id`) REFERENCES `users` (`User_id`);

--
-- Constraints for table `blockcustomer`
--
ALTER TABLE `blockcustomer`
  ADD CONSTRAINT `Block_customer_id` FOREIGN KEY (`Block_customer_id`) REFERENCES `users` (`User_id`),
  ADD CONSTRAINT `Servicer` FOREIGN KEY (`Servicer_id`) REFERENCES `servicer` (`Id`);

--
-- Constraints for table `extraservice`
--
ALTER TABLE `extraservice`
  ADD CONSTRAINT `ServiceSchedule_id` FOREIGN KEY (`ServiceSchedule_id`) REFERENCES `serviceschedule` (`ServiceSchedule_id`);

--
-- Constraints for table `favourite_block_servicer`
--
ALTER TABLE `favourite_block_servicer`
  ADD CONSTRAINT `CustomerID` FOREIGN KEY (`Customer_id`) REFERENCES `users` (`User_id`),
  ADD CONSTRAINT `Servicer-id` FOREIGN KEY (`Servicer_id`) REFERENCES `servicer` (`Id`);

--
-- Constraints for table `rating`
--
ALTER TABLE `rating`
  ADD CONSTRAINT `ServiceScheduleID` FOREIGN KEY (`ServiceSchedule_id`) REFERENCES `serviceschedule` (`ServiceSchedule_id`);

--
-- Constraints for table `servicer`
--
ALTER TABLE `servicer`
  ADD CONSTRAINT `Servicer_id` FOREIGN KEY (`Servicer_id`) REFERENCES `users` (`User_id`);

--
-- Constraints for table `serviceschedule`
--
ALTER TABLE `serviceschedule`
  ADD CONSTRAINT `Address_id` FOREIGN KEY (`Address_id`) REFERENCES `address` (`Address_id`),
  ADD CONSTRAINT `Customer_id` FOREIGN KEY (`Customer_id`) REFERENCES `users` (`User_id`),
  ADD CONSTRAINT `Service_status_id` FOREIGN KEY (`Service_status_id`) REFERENCES `servicestatus` (`ServiceStatus_id`),
  ADD CONSTRAINT `ServicerID` FOREIGN KEY (`Servicer_id`) REFERENCES `servicer` (`Id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `UserType_id` FOREIGN KEY (`UserType_id`) REFERENCES `usertype` (`UserType_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
