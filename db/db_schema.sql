-- Set DB Variables
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+02:00";

-- --------------------------------------------------------

-- Create Database: mufulir1_mwfc_db
CREATE DATABASE IF NOT EXISTS `mufulir1_mwfc_db`;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `admin` (
  `id` BIGINT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `email` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `updateDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `admin` 
--

-- INSERT INTO `admin` (`email`, `password`) VALUES
-- ('test@mufulirawanderers.com', 'admin123');

-- --------------------------------------------------------

-- Create table: users
CREATE TABLE IF NOT EXISTS `users` (
  `userId` BIGINT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `firstName` VARCHAR(255) NOT NULL,
  `lastName` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `contact` VARCHAR(10),
  `gender` VARCHAR(10),
  `nrc` VARCHAR(9),
  `address` VARCHAR(255),
  `town` VARCHAR(255),
  `country` VARCHAR(255),
  `password` VARCHAR(255) NOT NULL,
  `loginAttempts` INT(5) DEFAULT 0,
  `token` VARCHAR(255) NOT NULL,
  `token_expiry_date` TIMESTAMP NOT NULL DEFAULT '1999-01-01 00:00:01',
  `active` tinyint(1) NOT NULL DEFAULT 0,
  `signup_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT user_key UNIQUE (contact,email)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

-- Create table: membership
CREATE TABLE IF NOT EXISTS `membership` (
  `memId` BIGINT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `membNo` VARCHAR(255) DEFAULT 0,
  `memberType` VARCHAR(255) NOT NULL,
  `path` VARCHAR(255) NOT NULL,
  `applyDate` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `applyAttempts` INT(5) DEFAULT 0,
  `active` tinyint(1) NOT NULL DEFAULT 0,
  `userId` BIGINT(20) UNSIGNED,
  FOREIGN KEY (userId) REFERENCES users(userId)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;


-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `membershipConfig` (
  `id` BIGINT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `memberType` VARCHAR(255) NOT NULL,
  `price` decimal(15,2) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `admin`
--

-- INSERT INTO `membershipConfig` (`memberType`, `price`) VALUES
-- ('Platinum', 500);
-- INSERT INTO `membershipConfig` (`memberType`, `price`) VALUES
-- ('Gold', 400);
-- INSERT INTO `membershipConfig` (`memberType`, `price`) VALUES
-- ('Silver', 300);
-- INSERT INTO `membershipConfig` (`memberType`, `price`) VALUES
-- ('Bronze', 200);


-- --------------------------------------------------------

-- Create table: membershipLogs
CREATE TABLE IF NOT EXISTS `membershipLogs` (
  `memLogId` BIGINT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `membNo` VARCHAR(255) NOT NULL,
  `memberType` VARCHAR(255) NOT NULL,
  `applyDate` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `userId` BIGINT(20) NOT NULL,
  `memId` BIGINT(20) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;


-- --------------------------------------------------------


-- Create table: products
CREATE TABLE IF NOT EXISTS `products` (
  `prodId` BIGINT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `quantity` INT(5) DEFAULT 1,
  `category` VARCHAR(255) NOT NULL,
  `description` VARCHAR(255),
  `price` DECIMAL(15,2) NOT NULL,
  `oldPrice` DECIMAL(15,2) DEFAULT 0.0,
  `ref` VARCHAR(255) DEFAULT 0,
  `path` VARCHAR(255) NOT NULL,
  `uploadDate` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `active` tinyint(1) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;


-- --------------------------------------------------------


-- Create table: productCategoryConfig
CREATE TABLE IF NOT EXISTS `productCategoryConfig` (
  `id` BIGINT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `categoryName` VARCHAR(255) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;


-- --------------------------------------------------------


-- Create table: payments
CREATE TABLE IF NOT EXISTS `payments` (
  `payId` BIGINT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `userId` BIGINT(20) UNSIGNED,
  `ref` VARCHAR(255) NOT NULL,
  `cartArray` VARCHAR(20000) NOT NULL,
  `amountPaid` DECIMAL(15,2) NOT NULL,
  `currency` VARCHAR(10) DEFAULT "ZMW",
  `payDate` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  FOREIGN KEY (userId) REFERENCES users(userId),
  CONSTRAINT payments_key UNIQUE (ref)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;


-- --------------------------------------------------------


-- Create table: paidForItems
CREATE TABLE IF NOT EXISTS `paidForItems` ( 
  `paidId` BIGINT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `itemType` VARCHAR(255) NOT NULL,
  `myQuantity` INT(5) NOT NULL,
  `priceByQuantity` DECIMAL(15,2) NOT NULL,
  `originalPrice` DECIMAL(15,2) NOT NULL,
  `itemId` BIGINT(20) NOT NULL,
  `payId` BIGINT(20) NOT NULL,
  `userId` BIGINT(20) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;


-- --------------------------------------------------------


-- --------------------------------------------------------


-- Create table: contactus
CREATE TABLE IF NOT EXISTS `contactus` ( 
  `contactId` BIGINT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `userId` VARCHAR(255) NOT NULL,
  `fullName` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `comment` VARCHAR(1000) NOT NULL,
  `markRead` tinyint(1) NOT NULL DEFAULT 0,
  `contactDate` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;


-- --------------------------------------------------------







-- ---------------------DROP TABLES-----------------------------------
--
-- DROP TABLE payments;
-- DROP TABLE products;
-- DROP TABLE paidForItems;
-- DROP TABLE membershipLogs;
-- DROP TABLE membershipConfig;
-- DROP TABLE productCategoryConfig;
-- DROP TABLE membership;
-- DROP TABLE admin;
-- DROP TABLE users;
