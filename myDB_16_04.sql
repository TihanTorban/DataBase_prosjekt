-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 11, 2014 at 01:05 PM
-- Server version: 5.6.14
-- PHP Version: 5.5.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `mydb`
--

-- --------------------------------------------------------

--
-- Table structure for table `eiendel`
--

CREATE TABLE IF NOT EXISTS `eiendel` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Anskafelsesdato` date DEFAULT NULL,
  `Verdi` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `eiendel`
--

-- --------------------------------------------------------

--
-- Table structure for table `har_tilgang`
--

CREATE TABLE IF NOT EXISTS `har_tilgang` (
  `Medlem_Person_personNR` int(11) NOT NULL,
  `Sted_Adress` varchar(60) NOT NULL,
  PRIMARY KEY (`Medlem_Person_personNR`,`Sted_Adress`),
  KEY `fk_Medlem_has_Sted_Sted1_idx` (`Sted_Adress`),
  KEY `fk_Medlem_has_Sted_Medlem1_idx` (`Medlem_Person_personNR`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ikke_medlem`
--

CREATE TABLE IF NOT EXISTS `ikke_medlem` (
  `Person_personNR` int(11) NOT NULL,
  PRIMARY KEY (`Person_personNR`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ikke_medlem`
--

-- --------------------------------------------------------

--
-- Table structure for table `innlaant_fra`
--

CREATE TABLE IF NOT EXISTS `innlaant_fra` (
  `Person_PersonNR` int(11) NOT NULL,
  `Eiendel_ID` int(11) NOT NULL,
  `Utlaansdato` date DEFAULT NULL,
  `Utlaansperiode` int(11) DEFAULT NULL,
  PRIMARY KEY (`Person_PersonNR`,`Eiendel_ID`),
  KEY `fk_lones_fra_Person1_idx` (`Person_PersonNR`),
  KEY `fk_lones_fra_Eiendel1_idx` (`Eiendel_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `medlem`
--

CREATE TABLE IF NOT EXISTS `medlem` (
  `Person_personNR` int(11) NOT NULL,
  PRIMARY KEY (`Person_personNR`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `medlem`
--

-- --------------------------------------------------------

--
-- Table structure for table `miniatyrer`
--

CREATE TABLE IF NOT EXISTS `miniatyrer` (
  `Eiendel_ID` int(11) NOT NULL,
  `Bredde` int(11) DEFAULT NULL,
  `Hoyde` int(11) DEFAULT NULL,
  PRIMARY KEY (`Eiendel_ID`),
  KEY `fk_Miniatyrer_Eiendel1_idx` (`Eiendel_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `miniatyrer`
--

-- --------------------------------------------------------

--
-- Table structure for table `oppbevares`
--

CREATE TABLE IF NOT EXISTS `oppbevares` (
  `Eiendel_ID` int(11) NOT NULL,
  `Sted_Adress` varchar(60) NOT NULL,
  PRIMARY KEY (`Eiendel_ID`,`Sted_Adress`),
  KEY `fk_Oppbevares_Sted1_idx` (`Sted_Adress`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `oppbevares`
--

-- --------------------------------------------------------

--
-- Table structure for table `person`
--

CREATE TABLE IF NOT EXISTS `person` (
  `personNR` int(11) NOT NULL,
  `Navn` varchar(45) DEFAULT NULL,
  `Telefon` int(11) DEFAULT NULL,
  `E-post` varchar(45) DEFAULT NULL,
  `Adresse` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`personNR`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `person`
--

-- --------------------------------------------------------

--
-- Table structure for table `skinner`
--

CREATE TABLE IF NOT EXISTS `skinner` (
  `Eiendel_ID` int(11) NOT NULL,
  `Type` varchar(45) DEFAULT NULL,
  `Lengde` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`Eiendel_ID`),
  KEY `fk_Skinner_Eiendel1_idx` (`Eiendel_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `skinner`
--

-- --------------------------------------------------------

--
-- Table structure for table `sted`
--

CREATE TABLE IF NOT EXISTS `sted` (
  `Adress` varchar(60) NOT NULL,
  `Beskrivelse` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`Adress`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sted`
--

--
-- Table structure for table `tog`
--

CREATE TABLE IF NOT EXISTS `tog` (
  `Eiendel_ID` int(11) NOT NULL,
  `Aargang` varchar(45) DEFAULT NULL,
  `Modell` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`Eiendel_ID`),
  KEY `fk_Tog_Eiendel1_idx` (`Eiendel_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tog`
--

-- --------------------------------------------------------

--
-- Table structure for table `utlaant_til`
--

CREATE TABLE IF NOT EXISTS `utlaant_til` (
  `Medlem_Person_PersonNR` int(11) NOT NULL,
  `Eiendel_ID` int(11) NOT NULL,
  `Utlaansdato` date DEFAULT NULL,
  `Utlaansperiode` int(11) DEFAULT NULL,
  PRIMARY KEY (`Eiendel_ID`,`Medlem_Person_PersonNR`),
  KEY `fk_Laanes_til_Eiendel1_idx` (`Eiendel_ID`),
  KEY `fk_Utlaant_til_Medlem1` (`Medlem_Person_PersonNR`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `har_tilgang`
--
ALTER TABLE `har_tilgang`
  ADD CONSTRAINT `fk_Medlem_has_Sted_Medlem1` FOREIGN KEY (`Medlem_Person_personNR`) REFERENCES `medlem` (`Person_personNR`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Medlem_has_Sted_Sted1` FOREIGN KEY (`Sted_Adress`) REFERENCES `sted` (`Adress`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `ikke_medlem`
--
ALTER TABLE `ikke_medlem`
  ADD CONSTRAINT `fk_Ikke_medlem_Person1` FOREIGN KEY (`Person_personNR`) REFERENCES `person` (`personNR`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `innlaant_fra`
--
ALTER TABLE `innlaant_fra`
  ADD CONSTRAINT `fk_innlaant_fra_Eiendel` FOREIGN KEY (`Eiendel_ID`) REFERENCES `eiendel` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_innlaant_fra_Person` FOREIGN KEY (`Person_PersonNR`) REFERENCES `person` (`personNR`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `medlem`
--
ALTER TABLE `medlem`
  ADD CONSTRAINT `fk_Medlem_Person1` FOREIGN KEY (`Person_personNR`) REFERENCES `person` (`personNR`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `miniatyrer`
--
ALTER TABLE `miniatyrer`
  ADD CONSTRAINT `fk_Miniatyrer_Eiendel1` FOREIGN KEY (`Eiendel_ID`) REFERENCES `eiendel` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `oppbevares`
--
ALTER TABLE `oppbevares`
  ADD CONSTRAINT `fk_Oppbevares_Eiendel1` FOREIGN KEY (`Eiendel_ID`) REFERENCES `eiendel` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Oppbevares_Sted1` FOREIGN KEY (`Sted_Adress`) REFERENCES `sted` (`Adress`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `skinner`
--
ALTER TABLE `skinner`
  ADD CONSTRAINT `fk_Skinner_Eiendel1` FOREIGN KEY (`Eiendel_ID`) REFERENCES `eiendel` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tog`
--
ALTER TABLE `tog`
  ADD CONSTRAINT `fk_Tog_Eiendel1` FOREIGN KEY (`Eiendel_ID`) REFERENCES `eiendel` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `utlaant_til`
--
ALTER TABLE `utlaant_til`
  ADD CONSTRAINT `fk_Utlaant_till_Eiendel1` FOREIGN KEY (`Eiendel_ID`) REFERENCES `eiendel` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Utlaant_til_Medlem1` FOREIGN KEY (`Medlem_Person_PersonNR`) REFERENCES `medlem` (`Person_personNR`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
