-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 05, 2020 at 07:25 PM
-- Server version: 8.0.13-4
-- PHP Version: 7.2.24-0ubuntu0.18.04.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `baza`
--

-- --------------------------------------------------------

--
-- Table structure for table `korisnik`
--

CREATE TABLE `korisnik` (
  `ID` int(11) NOT NULL,
  `Ime` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `Prezime` varchar(25) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `Lozinka` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `Email` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `Bicikl` int(1) NOT NULL,
  `Stanica` int(1) DEFAULT NULL,
  `Kartica_ID` varchar(12) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `korisnik`
--

INSERT INTO `korisnik` (`ID`, `Ime`, `Prezime`, `Lozinka`, `Email`, `Bicikl`, `Stanica`, `Kartica_ID`) VALUES
(4, 'Ivan', 'Seki', 'bicikl1234', 'ivanseki@skole.hr', 1, NULL, '135344416'),
(7, 'neki', 'tamo', 'bicikl4321', 'ivanseki@skole.hr', 2, NULL, '21354855');

-- --------------------------------------------------------

--
-- Table structure for table `zapisi`
--

CREATE TABLE `zapisi` (
  `ID` int(11) NOT NULL,
  `Email` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `Vrijeme` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `Kartica` varchar(12) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `Stanje` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `Stanica` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `zapisi`
--

INSERT INTO `zapisi` (`ID`, `Email`, `Vrijeme`, `Kartica`, `Stanje`, `Stanica`) VALUES
(1, 'ivanseki@skole.hr', '2019-06-18 12:22:08', '135344416', 'zakljucano', 1),
(2, 'ivanseki@skole.hr', '2019-01-18 10:34:09', '135344416', 'otključano', 1),
(3, 'ivanseki@skole.hr', '2020-02-03 7:55:10', '135344416', 'zaključano', 1),
(4, 'ivanseki@skole.hr', '2020-02-04 15:35:40', '21354855', 'zaključano', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `korisnik`
--
ALTER TABLE `korisnik`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `zapisi`
--
ALTER TABLE `zapisi`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `korisnik`
--
ALTER TABLE `korisnik`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `zapisi`
--
ALTER TABLE `zapisi`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
