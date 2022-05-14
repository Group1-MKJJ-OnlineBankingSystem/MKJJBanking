-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 14, 2022 at 02:18 AM
-- Server version: 5.7.38
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `maurom3_CityCentral`
--
CREATE DATABASE IF NOT EXISTS `maurom3_CityCentral` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `maurom3_CityCentral`;

-- --------------------------------------------------------

--
-- Table structure for table `APPAREL_INVENTORY`
--

CREATE TABLE `APPAREL_INVENTORY` (
  `inventoryID` decimal(30,0) NOT NULL,
  `Pname` varchar(50) DEFAULT NULL,
  `Pdesc` varchar(50) DEFAULT NULL,
  `Pquant` decimal(10,0) DEFAULT NULL,
  `Ptype` varchar(25) DEFAULT NULL,
  `Plink` varchar(150) DEFAULT NULL,
  `Pprice` decimal(5,0) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `APPAREL_INVENTORY`
--

INSERT INTO `APPAREL_INVENTORY` (`inventoryID`, `Pname`, `Pdesc`, `Pquant`, `Ptype`, `Plink`, `Pprice`) VALUES
('1001', 'Boston T', 'T-shirt with Boston Skyline', '10', 'T-shirts', 'https://cyan.csam.montclair.edu/~maurom3/citycentral/product_pages/boston.html', '25'),
('1002', 'Miami T', 'T-shirt with Miami Skyline', '10', 'T-shirts', 'https://cyan.csam.montclair.edu/~maurom3/citycentral/product_pages/miami.html', '25'),
('1003', 'New York City T', 'T-shirt with NYC Skyline', '10', 'T-shirts', 'https://cyan.csam.montclair.edu/~maurom3/citycentral/product_pages/newyorkcity.html', '25'),
('1004', 'Philadelphia T', 'T-shirt with Philly Skyline', '10', 'T-shirts', 'https://cyan.csam.montclair.edu/~maurom3/citycentral/product_pages/philadelphia.html', '25'),
('1005', 'Pittsburgh T', 'T-shirt with Pittsburgh Skyline', '10', 'T-shirts', 'https://cyan.csam.montclair.edu/~maurom3/citycentral/product_pages/pittsburgh.html', '25'),
('1006', 'Tampa T', 'T-shirt with Tampa Skyline', '10', 'T-shirts', 'https://cyan.csam.montclair.edu/~maurom3/citycentral/product_pages/tampa.html', '35'),
('2001', 'Austin Long-sleeve shirt', 'Long-sleeve with Austin Skyline', '10', 'Long-sleeve', 'https://cyan.csam.montclair.edu/~maurom3/citycentral/product_pages/austin.html', '35'),
('2002', 'Boise Long-sleeve shirt', 'Long-sleeve with Boise Skyline', '10', 'Long-sleeve', 'https://cyan.csam.montclair.edu/~maurom3/citycentral/product_pages/boise.html', '35'),
('2003', 'Dallas Long-sleeve shirt', 'Long-sleeve with Dallas Skyline', '10', 'Long-sleeve', 'https://cyan.csam.montclair.edu/~maurom3/citycentral/product_pages/dallas.html', '35'),
('2004', 'Houston Long-sleeve shirt', 'Long-sleeve with Houston Skyline', '10', 'Long-sleeve', 'https://cyan.csam.montclair.edu/~maurom3/citycentral/product_pages/houston.html', '35'),
('2005', 'Las Vegas Vegas Long-sleeve shirt', 'Long-sleeve with Las Vegas Skyline', '10', 'Long-sleeve', 'https://cyan.csam.montclair.edu/~maurom3/citycentral/product_pages/lasvegas.html', '35'),
('2006', 'Phoenix Long-sleeve shirt', 'Long-sleeve with Phoenix Skyline', '10', 'Long-sleeve', 'https://cyan.csam.montclair.edu/~maurom3/citycentral/product_pages/phoenix.html', '35'),
('3001', 'Hollywood crewneck', 'Crewneck with Hollywood Skyline', '10', 'Crewnecks', 'https://cyan.csam.montclair.edu/~maurom3/citycentral/product_pages/hollywood.html', '40'),
('3002', 'Los Angeles crewneck', 'Crewneck with Los Angeles Skyline', '10', 'Crewnecks', 'https://cyan.csam.montclair.edu/~maurom3/citycentral/product_pages/losangeles.html', '40'),
('3003', 'San Jose crewneck', 'Crewneck with San Jose Skyline', '10', 'Crewnecks', 'https://cyan.csam.montclair.edu/~maurom3/citycentral/product_pages/sanjose.html', '40'),
('3004', 'San Diego crewneck', 'Crewneck with San Diego Skyline', '10', 'Crewnecks', 'https://cyan.csam.montclair.edu/~maurom3/citycentral/product_pages/sandiego.html', '40'),
('3005', 'Seattle crewneck', 'Crewneck with Seattle Skyline', '10', 'Crewnecks', 'https://cyan.csam.montclair.edu/~maurom3/citycentral/product_pages/seattle.html', '40'),
('3006', 'San Francisco crewneck', 'Crewneck with San Francisco Skyline', '10', 'Crewnecks', 'https://cyan.csam.montclair.edu/~maurom3/citycentral/product_pages/sanfrancisco.html', '40'),
('4001', 'Chicago hoodie', 'Hoodie with Chicago Skyline', '10', 'Hoodies', 'https://cyan.csam.montclair.edu/~maurom3/citycentral/product_pages/chicago.html', '50'),
('4002', 'Cincinnati hoodie', 'Hoodie with Cincinnati Skyline', '10', 'Hoodies', 'https://cyan.csam.montclair.edu/~maurom3/citycentral/product_pages/cincinnati.html', '50'),
('4003', 'Denver hoodie', 'Hoodie with Denver Skyline', '10', 'Hoodies', 'https://cyan.csam.montclair.edu/~maurom3/citycentral/product_pages/denver.html', '50'),
('4004', 'Indianapolis hoodie', 'Hoodie with Indianapolis Skyline', '10', 'Hoodies', 'https://cyan.csam.montclair.edu/~maurom3/citycentral/product_pages/indianapolis.html', '50'),
('4005', 'Salt Lake City hoodie', 'Hoodie with Salt Lake City Skyline', '10', 'Hoodies', 'https://cyan.csam.montclair.edu/~maurom3/citycentral/product_pages/saltlakecity.html', '50'),
('4006', 'St. Louis hoodie', 'Hoodie with St. Louis Skyline', '10', 'Hoodies', 'https://cyan.csam.montclair.edu/~maurom3/citycentral/product_pages/saintlouis.html', '50'),
('5001', 'Kansas City jacket', 'Jacket with Kansas City Skyline', '10', 'Jackets', 'https://cyan.csam.montclair.edu/~maurom3/citycentral/product_pages/kansascity.html', '70'),
('5002', 'Nashville jacket', 'Jacket with Nashville Skyline', '10', 'Jackets', 'https://cyan.csam.montclair.edu/~maurom3/citycentral/product_pages/nashville.html', '70'),
('5003', 'New Orleans jacket', 'Jacket with New Orleans Skyline', '10', 'Jackets', 'https://cyan.csam.montclair.edu/~maurom3/citycentral/product_pages/neworleans.html', '70'),
('5004', 'Oklahoma City jacket', 'Jacket with Oklahoma City Skyline', '10', 'Jackets', 'https://cyan.csam.montclair.edu/~maurom3/citycentral/product_pages/oklahomacity.html', '70'),
('5005', 'San Antonio jacket', 'Jacket with San Antonio Skyline', '10', 'Jackets', 'https://cyan.csam.montclair.edu/~maurom3/citycentral/product_pages/sanantonio.html', '70'),
('5006', 'Tuscon jacket', 'Jacket with Tuscon Skyline', '10', 'Jackets', 'https://cyan.csam.montclair.edu/~maurom3/citycentral/product_pages/tuscon.html', '70');

-- --------------------------------------------------------

--
-- Table structure for table `CUSTOMER`
--

CREATE TABLE `CUSTOMER` (
  `customerID` decimal(5,0) DEFAULT NULL,
  `cUsername` varchar(30) DEFAULT NULL,
  `cFname` varchar(10) NOT NULL,
  `cMinit` char(1) DEFAULT NULL,
  `cLname` varchar(20) NOT NULL,
  `cEmail` varchar(30) DEFAULT NULL,
  `cAddress` varchar(30) DEFAULT NULL,
  `loginID` decimal(5,0) NOT NULL,
  `cartID` decimal(7,0) DEFAULT NULL,
  `orderID` decimal(7,0) DEFAULT NULL,
  `saleID` decimal(7,0) DEFAULT NULL,
  `inventoryID` decimal(30,0) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `EMPLOYEE`
--

CREATE TABLE `EMPLOYEE` (
  `employeeID` decimal(5,0) DEFAULT NULL,
  `eUsername` varchar(30) DEFAULT NULL,
  `eFname` varchar(10) NOT NULL,
  `eMinit` char(1) DEFAULT NULL,
  `eLname` varchar(20) NOT NULL,
  `eEmail` varchar(30) DEFAULT NULL,
  `eAddress` varchar(30) DEFAULT NULL,
  `loginID` decimal(5,0) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `LOGIN`
--

CREATE TABLE `LOGIN` (
  `Username` varchar(30) DEFAULT NULL,
  `Password` varchar(30) DEFAULT NULL,
  `loginID` decimal(5,0) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ORDERS`
--

CREATE TABLE `ORDERS` (
  `orderID` char(7) NOT NULL,
  `customerID` char(6) NOT NULL,
  `total` float NOT NULL,
  `address` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `authID` char(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ORDER_CONTAINS`
--

CREATE TABLE `ORDER_CONTAINS` (
  `orderID` char(7) NOT NULL,
  `inventoryID` char(4) NOT NULL,
  `Pname` varchar(50) NOT NULL,
  `Pprice` float NOT NULL,
  `Pquant` int(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `APPAREL_INVENTORY`
--
ALTER TABLE `APPAREL_INVENTORY`
  ADD PRIMARY KEY (`inventoryID`);

--
-- Indexes for table `CUSTOMER`
--
ALTER TABLE `CUSTOMER`
  ADD PRIMARY KEY (`loginID`);

--
-- Indexes for table `EMPLOYEE`
--
ALTER TABLE `EMPLOYEE`
  ADD PRIMARY KEY (`loginID`);

--
-- Indexes for table `LOGIN`
--
ALTER TABLE `LOGIN`
  ADD PRIMARY KEY (`loginID`);
--
-- Database: `maurom3_CityCentral2.0`
--
CREATE DATABASE IF NOT EXISTS `maurom3_CityCentral2.0` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `maurom3_CityCentral2.0`;
--
-- Database: `maurom3_Company`
--
CREATE DATABASE IF NOT EXISTS `maurom3_Company` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `maurom3_Company`;

-- --------------------------------------------------------

--
-- Table structure for table `DEPARTMENT`
--

CREATE TABLE `DEPARTMENT` (
  `Dname` varchar(15) NOT NULL,
  `Dnumber` int(11) NOT NULL,
  `Mgr_ssn` char(9) NOT NULL,
  `Mgr_start_date` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `DEPARTMENT`
--

INSERT INTO `DEPARTMENT` (`Dname`, `Dnumber`, `Mgr_ssn`, `Mgr_start_date`) VALUES
('Research', 5, '333445555', '1988-05-22'),
('Administration', 4, '987654321', '1995-01-01'),
('Headquarters', 1, '888665555', '1981-06-19');

-- --------------------------------------------------------

--
-- Table structure for table `DEPENDENT`
--

CREATE TABLE `DEPENDENT` (
  `Essn` char(9) NOT NULL,
  `Dependent_name` varchar(15) NOT NULL,
  `Sex` char(1) DEFAULT NULL,
  `Bdate` date DEFAULT NULL,
  `Relationship` varchar(8) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `DEPENDENT`
--

INSERT INTO `DEPENDENT` (`Essn`, `Dependent_name`, `Sex`, `Bdate`, `Relationship`) VALUES
('333445555', 'Alice', 'F', '1986-04-04', 'Daughter'),
('333445555', 'Theodore', 'M', '1983-10-25', 'Son'),
('333445555', 'Joy', 'F', '1958-05-03', 'Spouse'),
('987654321', 'Abner', 'M', '1942-02-28', 'Spouse'),
('123456789', 'Michael', 'M', '1988-01-04', 'Son'),
('123456789', 'Alice', 'F', '1988-12-30', 'Daughter'),
('123456789', 'Elizabeth', 'F', '1967-05-05', 'Spouse');

-- --------------------------------------------------------

--
-- Table structure for table `DEPT_LOCATIONS`
--

CREATE TABLE `DEPT_LOCATIONS` (
  `Dnumber` int(11) NOT NULL,
  `Dlocation` varchar(15) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `DEPT_LOCATIONS`
--

INSERT INTO `DEPT_LOCATIONS` (`Dnumber`, `Dlocation`) VALUES
(1, 'Houston'),
(4, 'Stafford'),
(5, 'Bellaire'),
(5, 'Houston'),
(5, 'Sugarland');

-- --------------------------------------------------------

--
-- Table structure for table `EMPLOYEE`
--

CREATE TABLE `EMPLOYEE` (
  `Fname` varchar(10) NOT NULL,
  `Minit` char(1) DEFAULT NULL,
  `Lname` varchar(20) NOT NULL,
  `Ssn` char(9) NOT NULL,
  `Bdate` date DEFAULT NULL,
  `Address` varchar(30) DEFAULT NULL,
  `Sex` char(1) DEFAULT NULL,
  `Salary` decimal(5,0) DEFAULT NULL,
  `Super_ssn` char(9) DEFAULT NULL,
  `Dno` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `EMPLOYEE`
--

INSERT INTO `EMPLOYEE` (`Fname`, `Minit`, `Lname`, `Ssn`, `Bdate`, `Address`, `Sex`, `Salary`, `Super_ssn`, `Dno`) VALUES
('John', 'B', 'Smith', '123456789', '1965-01-09', '731 Fondren, Houston TX', 'M', '30000', '333445555', 5),
('Franklin', 'T', 'Wong', '333445555', '1965-12-08', '638 Voss, Houston TX', 'M', '40000', '888665555', 5),
('Alicia', 'J', 'Zelaya', '999887777', '1968-01-19', '3321 Castle, Spring TX', 'F', '25000', '987654321', 4),
('Jennifer', 'S', 'Wallace', '987654321', '1941-06-20', '291 Berry, Bellaire TX', 'F', '43000', '888665555', 4),
('Ramesh', 'K', 'Narayan', '666884444', '1962-09-15', '975 Fire Oak, Humble TX', 'M', '38000', '333445555', 5),
('Joyce', 'A', 'English', '453453453', '1972-07-31', '5631 Rice, Houston TX', 'F', '25000', '333445555', 5),
('Ahmad', 'V', 'Jabbar', '987987987', '1969-03-29', '980 Dallas, Houston TX', 'M', '25000', '987654321', 4),
('James', 'E', 'Borg', '888665555', '1937-11-10', '450 Stone, Houston TX', 'M', '55000', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `PROJECT`
--

CREATE TABLE `PROJECT` (
  `Pname` varchar(15) NOT NULL,
  `Pnumber` int(11) NOT NULL,
  `Plocation` varchar(15) DEFAULT NULL,
  `Dnum` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `PROJECT`
--

INSERT INTO `PROJECT` (`Pname`, `Pnumber`, `Plocation`, `Dnum`) VALUES
('ProductX', 1, 'Bellaire', 5),
('ProductY', 2, 'Sugarland', 5),
('ProductZ', 3, 'Houston', 5),
('Computerization', 10, 'Stafford', 4),
('Reorganization', 20, 'Houston', 1),
('Newbenefits', 30, 'Stafford', 4);

-- --------------------------------------------------------

--
-- Table structure for table `WORKS_ON`
--

CREATE TABLE `WORKS_ON` (
  `Essn` char(9) NOT NULL,
  `Pno` int(11) NOT NULL,
  `Hours` decimal(3,1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `WORKS_ON`
--

INSERT INTO `WORKS_ON` (`Essn`, `Pno`, `Hours`) VALUES
('123456789', 1, '32.5'),
('123456789', 2, '7.5'),
('666884444', 3, '40.0'),
('453453453', 1, '20.0'),
('453453453', 2, '20.0'),
('333445555', 2, '10.0'),
('333445555', 3, '10.0'),
('333445555', 10, '10.0'),
('333445555', 20, '10.0'),
('999887777', 30, '30.0'),
('999887777', 10, '10.0'),
('987987987', 10, '35.0'),
('987987987', 30, '5.0'),
('987654321', 30, '20.0'),
('987654321', 20, '15.0'),
('888665555', 20, '16.0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `DEPARTMENT`
--
ALTER TABLE `DEPARTMENT`
  ADD PRIMARY KEY (`Dnumber`),
  ADD UNIQUE KEY `Dname` (`Dname`),
  ADD KEY `Dep_emp` (`Mgr_ssn`);

--
-- Indexes for table `DEPENDENT`
--
ALTER TABLE `DEPENDENT`
  ADD PRIMARY KEY (`Essn`,`Dependent_name`);

--
-- Indexes for table `DEPT_LOCATIONS`
--
ALTER TABLE `DEPT_LOCATIONS`
  ADD PRIMARY KEY (`Dnumber`,`Dlocation`);

--
-- Indexes for table `EMPLOYEE`
--
ALTER TABLE `EMPLOYEE`
  ADD PRIMARY KEY (`Ssn`),
  ADD KEY `Emp_dno` (`Dno`),
  ADD KEY `Emp_super` (`Super_ssn`);

--
-- Indexes for table `PROJECT`
--
ALTER TABLE `PROJECT`
  ADD PRIMARY KEY (`Pnumber`),
  ADD UNIQUE KEY `Pname` (`Pname`),
  ADD KEY `Dnum` (`Dnum`);

--
-- Indexes for table `WORKS_ON`
--
ALTER TABLE `WORKS_ON`
  ADD PRIMARY KEY (`Essn`,`Pno`),
  ADD KEY `Pno` (`Pno`);
--
-- Database: `maurom3_DB5.2_Apparel`
--
CREATE DATABASE IF NOT EXISTS `maurom3_DB5.2_Apparel` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `maurom3_DB5.2_Apparel`;

-- --------------------------------------------------------

--
-- Table structure for table `APPAREL_INVENTORY`
--

CREATE TABLE `APPAREL_INVENTORY` (
  `inventoryID` decimal(30,0) DEFAULT NULL,
  `Pname` varchar(50) DEFAULT NULL,
  `Pdesc` varchar(50) DEFAULT NULL,
  `Pquant` decimal(10,0) DEFAULT NULL,
  `Ptype` varchar(25) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `APPAREL_INVENTORY`
--

INSERT INTO `APPAREL_INVENTORY` (`inventoryID`, `Pname`, `Pdesc`, `Pquant`, `Ptype`) VALUES
('1', 'Boston T', 'T-shirt with Boston Skyline', '1', 'T-shirts'),
('2', 'Miami T', 'T-shirt with Miami Skyline', '1', 'T-shirts'),
('3', 'New York City T', 'T-shirt with NYC Skyline', '1', 'T-shirts'),
('4', 'Philadelphia T', 'T-shirt with Philly Skyline', '1', 'T-shirts'),
('5', 'Pittsburgh T', 'T-shirt with Pittsburgh Skyline', '1', 'T-shirts'),
('6', 'Tampa T', 'T-shirt with Tampa Skyline', '1', 'T-shirts'),
('7', 'Austin Long-sleeve shirt', 'Long-sleeve with Austin Skyline', '1', 'Long-sleeve'),
('8', 'Boise Long-sleeve shirt', 'Long-sleeve with Boise Skyline', '1', 'Long-sleeve'),
('9', 'Dallas Long-sleeve shirt', 'Long-sleeve with Dallas Skyline', '1', 'Long-sleeve'),
('10', 'Houston Long-sleeve shirt', 'Long-sleeve with Houston Skyline', '1', 'Long-sleeve'),
('11', 'Las Vegas Vegas Long-sleeve shirt', 'Long-sleeve with Las Vegas Skyline', '1', 'Long-sleeve'),
('12', 'Phoenix Long-sleeve shirt', 'Long-sleeve with Phoenix Skyline', '1', 'Long-sleeve'),
('13', 'Hollywood crewneck', 'Crewneck with Hollywood Skyline', '1', 'Crewnecks'),
('14', 'Los Angeles crewneck', 'Crewneck with Los Angeles Skyline', '1', 'Crewnecks'),
('15', 'San Jose crewneck', 'Crewneck with San Jose Skyline', '1', 'Crewnecks'),
('16', 'San Diego crewneck', 'Crewneck with San Diego Skyline', '1', 'Crewnecks'),
('17', 'Seattle crewneck', 'Crewneck with Seattle Skyline', '1', 'Crewnecks'),
('18', 'San Francisco crewneck', 'Crewneck with San Francisco Skyline', '1', 'Crewnecks'),
('19', 'Chicago hoodie', 'Hoodie with Chicago Skyline', '1', 'Hoodies'),
('20', 'Cincinnati hoodie', 'Hoodie with Cincinnati Skyline', '1', 'Hoodies'),
('21', 'Denver hoodie', 'Hoodie with Denver Skyline', '1', 'Hoodies'),
('22', 'Indianapolis hoodie', 'Hoodie with Indianapolis Skyline', '1', 'Hoodies'),
('23', 'Salt Lake City hoodie', 'Hoodie with Salt Lake City Skyline', '1', 'Hoodies'),
('24', 'St. Louis hoodie', 'Hoodie with St. Louis Skyline', '1', 'Hoodies'),
('25', 'Kansas City jacket', 'Jacket with Kansas City Skyline', '1', 'Jackets'),
('26', 'Nashville jacket', 'Jacket with Nashville Skyline', '1', 'Jackets'),
('27', 'New Orleans jacket', 'Jacket with New Orleans Skyline', '1', 'Jackets'),
('28', 'Oklahoma City jacket', 'Jacket with Oklahoma City Skyline', '1', 'Jackets'),
('29', 'San Antonio jacket', 'Jacket with San Antonio Skyline', '1', 'Jackets'),
('30', 'Tuscon jacket', 'Jacket with Tuscon Skyline', '1', 'Jackets'),
('1', ' Boston T', 'T-shirt with Boston Skyline', '1', 'T-shirts'),
('31', ' Oakhurst T', 'T-shirt with Oakhurst Skyline', '1', 'T-shirts'),
('1', ' Boston T', 'T-shirt with Boston Skyline', '1', 'T-shirts'),
('31', ' adadasd', 'asd', '111', 'T-shirts');
--
-- Database: `maurom3_mkjj`
--
CREATE DATABASE IF NOT EXISTS `maurom3_mkjj` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `maurom3_mkjj`;

-- --------------------------------------------------------

--
-- Table structure for table `ACCOUNTS`
--

CREATE TABLE `ACCOUNTS` (
  `bankAccountNumber` char(12) NOT NULL,
  `accountType` varchar(10) NOT NULL,
  `balance` double NOT NULL,
  `ownerID` char(6) NOT NULL,
  `dateOpened` date NOT NULL,
  `numOfTransactions` int(11) NOT NULL,
  `status` varchar(128) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ACCOUNTS`
--

INSERT INTO `ACCOUNTS` (`bankAccountNumber`, `accountType`, `balance`, `ownerID`, `dateOpened`, `numOfTransactions`, `status`) VALUES
('422911965516', 'savings', 500, '599825', '2022-05-09', 1, 'pending approval'),
('417306650218', 'checking', 4100, '599825', '2022-05-09', 3, 'approved'),
('499159919410', 'checking', 10000, '599825', '2022-05-09', 1, 'denied'),
('416158653457', 'savings', 5000, '655545', '2022-05-08', 1, 'denied'),
('461159807382', 'savings', 5000, '599825', '2022-05-09', 1, 'pending approval'),
('466241585724', 'savings', 100, '599825', '2022-05-09', 1, 'denied'),
('451824039436', 'savings', 207.57, '655545', '2022-04-25', 6, 'approved'),
('430647360782', 'savings', 284.2, '487742', '2022-04-25', 6, 'approved'),
('444444444444', 'savings', 302.01, '655545', '2022-05-05', 3, 'approved');

-- --------------------------------------------------------

--
-- Table structure for table `CUSTOMER`
--

CREATE TABLE `CUSTOMER` (
  `customerID` char(6) NOT NULL,
  `cUsername` varchar(50) DEFAULT NULL,
  `cPassword` varchar(255) NOT NULL,
  `cEmail` varchar(50) DEFAULT NULL,
  `cFname` varchar(50) NOT NULL,
  `cLname` varchar(50) NOT NULL,
  `cAddress` varchar(100) NOT NULL,
  `phoneNumber` varchar(255) DEFAULT NULL,
  `numOfAccounts` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `CUSTOMER`
--

INSERT INTO `CUSTOMER` (`customerID`, `cUsername`, `cPassword`, `cEmail`, `cFname`, `cLname`, `cAddress`, `phoneNumber`, `numOfAccounts`) VALUES
('951177', 'maurom3', '$2y$10$PW8Km5lEL7WMuItqQT8vDu2cIeM8/6/foXUGQrMTqX.0PB/VGrMLK', 'maurom3@montclair.edu', 'Mark', 'Mauro', '710 Talmadge Avenue Oakhurst, New Jersey 07755', '123-456-7890', 0),
('335417', 'kenny', '$2y$10$62aK8SY4ZORxgcn9SCUc2e1MsNwNOFGnviAAbHZaZ38I9jZQWDQQ.', 'kenny@gmail.com', 'Kenny', 'Doerflein', '1 Normal Avenue Montclair, NJ 07043', '198-765-4321', 0),
('620126', 'johnj', '$2y$10$an4UoG1pxSd39Ijgikei/OhA1FQY4mk4pwlmiJHSE8/ZZoXXqkoHq', 'johnj@gmail.com', 'John', 'Josephsen', '1 Normal Avenue Montclair, NJ 07043', '999-999-9991', 0),
('214914', 'jackk', '$2y$10$BcbDfCnb2Iz2NH8IQ06oVeWWHbhRZl8wOSWmfn4Ipp7kVKRslANK.', 'JackKeane@gmail.com', 'Jack', 'Keane', '1 Normal Avenue Montclair, NJ 07043', '787-525-6515', 0),
('655545', 'test', '$2y$10$duX10ezAkGFmt5fJM6F2fuPBETYTdv4pRbRwE2vyu0YHzdNV/XnKS', 'test@test.com', 'test', 'test', 'test, NJ 09099', '999-333-3333', 1),
('984628', 'test2', '$2y$10$X07nUdlerLiVDa0eO6s/BeLhN76zJP91wmeJPNJ1SYGrAQOH0FmnC', 'mak@gmail.com', 'Mark', 'Menny', '710 Cool Street Oak, NJ 07043', '888-888-8888', 0),
('487742', 'markmauro', '$2y$10$J3lCosxQLUIJHJCSvaJeyucxJTNARGk3QXMHNO9QiycGLc6cQFg7.', 'markymauro@gmail.com', 'Mark', 'Mauro', '710 Talmadge Avenue Oakhurst, NJ 07755', '908-489-1319', 2),
('136599', 'markmauro15', '$2y$10$X9h1WWa03jm4FF794b3AHurR1/hqAWAx6tfSBDF/W8rRfecuzr7Ai', 'marl@gmail.com', 'Mark', 'Mauro', '1 Normal ave Montclair, NJ 07043', '999-888-9000', 0),
('447378', '$markmauro$', '$2y$10$soBHPgM1.WpuL8mGr7Sqwu1PKWGFxwm3Nai5rg8hJ6.roE7p0ehAy', 'mark@markymauro.net', 'Mark', 'Mauro', '1 Normal Ave Montclair, NJ 07043', '789-456-1230', 0),
('599825', 'alanturing', '$2y$10$xNFxTIUDSx1zKYmIkzDNMOQ9.LdgCxqlny/USyNFSYuvXbFd2ZP.O', 'alanturing@gmail.com', 'Alan', 'Turing', '96 Euston Road New York City, New York 10001', '808-469-7070', 6);

-- --------------------------------------------------------

--
-- Table structure for table `EMPLOYEE`
--

CREATE TABLE `EMPLOYEE` (
  `employeeID` char(6) NOT NULL,
  `eUsername` varchar(500) DEFAULT NULL,
  `ePassword` varchar(255) NOT NULL,
  `eEmail` varchar(500) DEFAULT NULL,
  `eFname` varchar(500) NOT NULL,
  `eLname` varchar(500) NOT NULL,
  `eAddress` varchar(1000) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `EMPLOYEE`
--

INSERT INTO `EMPLOYEE` (`employeeID`, `eUsername`, `ePassword`, `eEmail`, `eFname`, `eLname`, `eAddress`) VALUES
('625505', 'admin', '$2y$10$ajOnRNZsK5xJA/1scHQ79u1FABd53BXwnK3vMFPmmZpUksbITU.eS', 'admin@mkjj.com', 'Ada', 'Lovelace', '1 Normal Ave Montclair NJ 07043');

-- --------------------------------------------------------

--
-- Table structure for table `TRANSACTIONS`
--

CREATE TABLE `TRANSACTIONS` (
  `dateOfTransaction` datetime NOT NULL,
  `transactionType` varchar(128) NOT NULL,
  `changeInBalance` double NOT NULL,
  `bankAccountNumber` char(12) NOT NULL,
  `transactionID` char(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `TRANSACTIONS`
--

INSERT INTO `TRANSACTIONS` (`dateOfTransaction`, `transactionType`, `changeInBalance`, `bankAccountNumber`, `transactionID`) VALUES
('2022-05-09 15:05:29', 'initial deposit', 500, '422911965516', '12393094253'),
('2019-01-09 15:55:59', 'initial deposit', 400, '451824039436', '11105373238'),
('2022-04-25 15:56:29', 'deposit', 500, '451824039436', '18390194070'),
('2022-04-25 21:40:03', 'withdrawal', -400, '451824039436', '10782100665'),
('2022-04-25 21:40:52', 'withdrawal', -25.44, '451824039436', '13839463182'),
('2022-04-25 21:56:13', 'initial deposit', 75, '430647360782', '19612999001'),
('2022-04-25 21:58:41', 'transfer sent', -71.78, '451824039436', '18537067784'),
('2022-04-25 21:58:41', 'transfer received', 69.69, '430647360782', '13548512967'),
('2022-04-25 22:00:08', 'transfer sent', -71.78, '451824039436', '19591595356'),
('2022-04-25 22:00:08', 'transfer received', 69.69, '430647360782', '14481446104'),
('2022-04-25 22:00:47', 'transfer sent', -71.78, '451824039436', '19720394547'),
('2022-04-25 22:00:47', 'transfer received', 69.69, '430647360782', '16837417032'),
('2022-04-30 12:26:29', 'deposit', 0.04, '430647360782', '10871794715'),
('2022-04-30 12:26:59', 'deposit', 0.09, '430647360782', '14832863591'),
('2022-05-05 19:38:58', 'initial deposit', 100, '453141178534', '14226609655'),
('2022-05-05 21:45:27', 'deposit', 56.76, '444444444444', '16179925021'),
('2022-05-05 21:49:47', 'deposit', 500, '444444444444', '14177036744'),
('2022-05-05 21:50:44', 'deposit', 50, '444444444444', '11139081240'),
('2022-05-05 21:51:17', 'deposit', 500, '444444444444', '11549605265'),
('2022-05-05 21:52:36', 'deposit', 50, '444444444444', '10228838605'),
('2022-05-05 21:54:37', 'withdrawal', -1500, '444444444444', '18723003588'),
('2022-05-05 21:54:46', 'withdrawal', -500, '444444444444', '16256437753'),
('2022-05-05 21:55:53', 'withdrawal', -1, '444444444444', '11401395968'),
('2022-05-05 21:57:50', 'transfer sent', -5.15, '451824039436', '10876929120'),
('2022-05-05 21:57:50', 'transfer received', 5, '451824039436', '14479619117'),
('2022-05-05 22:02:03', 'deposit', 5, '451824039436', '17005109732'),
('2022-05-08 16:10:30', 'initial deposit', 5000, '416158653457', '16666958137'),
('2022-05-08 16:15:00', 'transfer sent', -51.5, '451824039436', '14438323982'),
('2022-05-08 16:15:00', 'transfer received', 50, '444444444444', '18008123540'),
('2022-05-08 16:24:58', 'deposit', 432.62, '444444444444', '18292920563'),
('2022-05-08 16:25:30', 'withdrawal', -200, '444444444444', '10116833614'),
('2022-05-08 16:27:17', 'transfer sent', -180.61, '444444444444', '12473426469'),
('2022-05-08 16:35:31', 'deposit', 100, '444444444444', '14564723346'),
('2022-05-09 12:16:31', 'initial deposit', 100, '466241585724', '16458236101'),
('2022-05-09 14:49:35', 'initial deposit', 5000, '461159807382', '15065153837'),
('2022-05-09 14:50:00', 'initial deposit', 10000, '499159919410', '16087279568'),
('2022-05-09 14:50:08', 'initial deposit', 5000, '417306650218', '18481862222'),
('2022-05-09 14:50:12', 'initial deposit', 40000, '484122322559', '17740598047'),
('2022-05-09 14:51:48', 'deposit', 100, '417306650218', '10605836819'),
('2022-05-09 14:52:09', 'withdrawal', -1000, '417306650218', '18777591669');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ACCOUNTS`
--
ALTER TABLE `ACCOUNTS`
  ADD PRIMARY KEY (`bankAccountNumber`),
  ADD KEY `ownerID` (`ownerID`);

--
-- Indexes for table `CUSTOMER`
--
ALTER TABLE `CUSTOMER`
  ADD PRIMARY KEY (`customerID`),
  ADD UNIQUE KEY `cUsername` (`cUsername`),
  ADD UNIQUE KEY `cEmail` (`cEmail`);

--
-- Indexes for table `EMPLOYEE`
--
ALTER TABLE `EMPLOYEE`
  ADD PRIMARY KEY (`employeeID`),
  ADD UNIQUE KEY `eUsername` (`eUsername`),
  ADD UNIQUE KEY `eEmail` (`eEmail`);

--
-- Indexes for table `TRANSACTIONS`
--
ALTER TABLE `TRANSACTIONS`
  ADD PRIMARY KEY (`transactionID`),
  ADD KEY `bankAccountNumber` (`bankAccountNumber`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
