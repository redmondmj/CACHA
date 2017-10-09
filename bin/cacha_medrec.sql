-- phpMyAdmin SQL Dump
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 09, 2017 at 04:21 PM
-- Server version: 5.6.37
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cacha_medrec`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_dispensary`
--

CREATE TABLE `tbl_dispensary` (
  `DispensaryID` int(10) NOT NULL,
  `DispensaryName` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_dispensary`
--

INSERT INTO `tbl_dispensary` (`DispensaryID`, `DispensaryName`) VALUES
(1, 'Bugola'),
(2, 'Bugorola'),
(3, 'Bukondo'),
(4, 'Buzegwe'),
(5, 'Gallu'),
(6, 'Hamukoko'),
(7, 'Hamuyebe'),
(8, 'Igalla'),
(9, 'Kabuhinzi'),
(10, 'Kagunguli'),
(11, 'Kaseni'),
(12, 'Kazilankanda'),
(13, 'Kigara'),
(14, 'Muhula'),
(15, 'Mukunu'),
(16, 'Muluseni'),
(17, 'Muriti'),
(18, 'Murutilima'),
(19, 'Ukara');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_drugs`
--

CREATE TABLE `tbl_drugs` (
  `drugID` int(11) NOT NULL,
  `drugName` text NOT NULL,
  `drugQuantity` int(11) DEFAULT NULL,
  `drugDirections` text NOT NULL,
  `drugCommon` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_patient`
--

CREATE TABLE `tbl_patient` (
  `PatientID` int(10) NOT NULL,
  `FirstName` varchar(100) DEFAULT NULL,
  `LastName` varchar(100) DEFAULT NULL,
  `Village` varchar(200) DEFAULT NULL,
  `Birthday` varchar(25) DEFAULT NULL,
  `Sex` varchar(8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_patient`
--

INSERT INTO `tbl_patient` (`PatientID`, `FirstName`, `LastName`, `Village`, `Birthday`, `Sex`) VALUES
(1, 'Asriel', 'Dreemurr', 'Bugorola', '2015-09-15', 'male'),
(2, 'Pokey', 'Minch', NULL, '1994-08-27', 'male'),
(3, 'Morrigan', 'Flemeth', 'Ukara', '2010-03-16', 'female'),
(4, 'Copernicus', 'Qwark', 'Kigara', '2002-11-04', 'male'),
(5, 'Albert', 'Wily', 'Kabuhinzi', '1987-12-17', 'male'),
(6, 'Betty', 'Kane', 'Buzegwe', '1930-08-09', 'female'),
(7, 'Jessica', 'Ford', 'Gallu', '1976-11-07', 'female'),
(8, 'Johnny', 'Rose', 'Muhula', NULL, 'male'),
(9, 'Mary', 'Redmond', 'Muhula', '2017-03-29', 'female'),
(10, 'some', 'person', 'Bugola', NULL, 'male'),
(11, 'who', 'dat', 'Bukondo', NULL, 'male');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tests`
--

CREATE TABLE `tbl_tests` (
  `testID` int(11) NOT NULL,
  `patientID` int(11) NOT NULL,
  `date` date NOT NULL,
  `result` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_village`
--

CREATE TABLE `tbl_village` (
  `VillageID` int(10) NOT NULL,
  `Village` varchar(200) NOT NULL DEFAULT 'invalid entry'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_village`
--

INSERT INTO `tbl_village` (`VillageID`, `Village`) VALUES
(1, 'Bugola'),
(2, 'Bugorola'),
(3, 'Bukondo'),
(4, 'Buzegwe'),
(5, 'Gallu'),
(6, 'Hamukoko'),
(7, 'Hamuyebe'),
(8, 'Igalla'),
(9, 'Kabuhinzi'),
(10, 'Kagunguli'),
(11, 'Kaseni'),
(12, 'Kazilankanda'),
(13, 'Kigara'),
(14, 'Muhula'),
(15, 'Mukunu'),
(16, 'Muluseni'),
(17, 'Muriti'),
(18, 'Murutilima'),
(19, 'Ukara');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_visit`
--

CREATE TABLE `tbl_visit` (
  `VisitID` int(10) NOT NULL,
  `PatientID` int(10) NOT NULL,
  `VisitDate` varchar(25) DEFAULT NULL,
  `VisitTime` varchar(25) DEFAULT NULL,
  `VisitedDispensary` varchar(50) DEFAULT NULL,
  `TriageTesting` varchar(8) DEFAULT NULL COMMENT 'no, pending, complete',
  `TriageMedical` varchar(8) DEFAULT NULL COMMENT 'no, pending, complete',
  `TriageGYN` varchar(8) DEFAULT NULL COMMENT 'no, pending, complete',
  `TriageOPHT` varchar(8) DEFAULT NULL COMMENT 'no, pending, complete',
  `TriageDENT` varchar(8) DEFAULT NULL COMMENT 'no, pending, complete',
  `TriageVenDis` varchar(8) DEFAULT NULL COMMENT 'no, pending, complete',
  `Weight` varchar(8) DEFAULT NULL COMMENT 'in KG',
  `Temperature` varchar(8) DEFAULT NULL COMMENT 'in Celsius',
  `BloodPressure` varchar(10) DEFAULT NULL,
  `Glucose` int(10) DEFAULT NULL,
  `HeartRate` int(10) DEFAULT NULL,
  `LastPeriod` varchar(25) DEFAULT NULL COMMENT 'LNMP',
  `Pregnant` varchar(3) DEFAULT NULL COMMENT 'yes, no, n/a',
  `Breastfeed` varchar(3) DEFAULT NULL COMMENT 'yes, no',
  `NumOfPreg` int(2) DEFAULT NULL COMMENT 'P on the form',
  `NumLiveBirth` int(2) DEFAULT NULL COMMENT 'G on the form',
  `NumAbortions` int(2) DEFAULT NULL COMMENT 'A on the form',
  `NumLivingChildren` int(2) DEFAULT NULL,
  `VTest` varchar(8) DEFAULT NULL COMMENT 'no, pending, positive, negative',
  `MalariaTest` varchar(8) DEFAULT NULL COMMENT 'no, pending, positive, negative',
  `SyphilisTest` varchar(8) DEFAULT NULL COMMENT 'no, pending, positive, negative',
  `TyphTest` varchar(8) DEFAULT NULL COMMENT 'no, pending, positive, negative',
  `UrineLeucTest` varchar(8) DEFAULT NULL COMMENT 'no, pending, positive, negative',
  `UrineRBCTest` varchar(8) DEFAULT NULL COMMENT 'no, pending, positive, negative',
  `UrineGlucoseTest` varchar(8) DEFAULT NULL COMMENT 'no, pending, positive, negative',
  `UrineNitritesTest` varchar(8) DEFAULT NULL COMMENT 'no, pending, positive, negative',
  `PregnancyTest` varchar(8) DEFAULT NULL COMMENT 'no, pending, positive, negative, n/a',
  `ChiefComplaint` text,
  `Assessment` text,
  `LastHIVTest` varchar(50) DEFAULT NULL COMMENT 'possibly not needed if we already have testing dates',
  `LastPZQTx` varchar(50) DEFAULT NULL COMMENT 'possibly not needed if we already have testing dates',
  `LastWormTx` varchar(50) DEFAULT NULL COMMENT 'possibly not needed if we already have testing dates',
  `LastVitA` varchar(50) DEFAULT NULL COMMENT 'possibly not needed if we already have testing dates',
  `PrevMeds` longtext,
  `DX_Healthy` tinyint(1) DEFAULT NULL COMMENT 'unknown if needed or redundant',
  `DX_NoTreatment` tinyint(1) DEFAULT NULL COMMENT 'unknown if needed or redundant',
  `DX_MSK` tinyint(1) DEFAULT NULL COMMENT '0 for no, 1-3 for severity',
  `DX_Worms` tinyint(1) DEFAULT NULL COMMENT '0 for no, 1-3 for severity',
  `DX_Asthma` tinyint(1) DEFAULT NULL COMMENT '0 for no, 1-3 for severity',
  `DX_Bronchitis` tinyint(1) DEFAULT NULL COMMENT '0 for no, 1-3 for severity',
  `DX_Pneumonia` tinyint(1) DEFAULT NULL COMMENT '0 for no, 1-3 for severity',
  `DX_Cough` tinyint(1) DEFAULT NULL COMMENT '0 for no, 1-3 for severity',
  `DX_Malaria` tinyint(1) DEFAULT NULL COMMENT '0 for no, 1-3 for severity',
  `DX_Schisto` tinyint(1) DEFAULT NULL COMMENT '0 for no, 1-3 for severity',
  `DX_Typhoid` tinyint(1) DEFAULT NULL COMMENT '0 for no, 1-3 for severity',
  `DX_Gerd` tinyint(1) DEFAULT NULL COMMENT '0 for no, 1-3 for severity',
  `DX_PUD` tinyint(1) DEFAULT NULL COMMENT '0 for no, 1-3 for severity',
  `DX_Diarrhea` tinyint(1) DEFAULT NULL COMMENT '0 for no, 1-3 for severity',
  `DX_DiarrheaBloody` tinyint(1) DEFAULT NULL COMMENT '0 for no, 1-3 for severity',
  `DX_Hypertension` tinyint(1) DEFAULT NULL COMMENT '0 for no, 1-3 for severity',
  `DX_Diabetes` tinyint(1) DEFAULT NULL COMMENT '0 for no, 1-3 for severity',
  `DX_Constipation` tinyint(1) DEFAULT NULL COMMENT '0 for no, 1-3 for severity',
  `DX_PID` tinyint(1) DEFAULT NULL COMMENT '0 for no, 1-3 for severity',
  `DX_STI` tinyint(1) DEFAULT NULL COMMENT '0 for no, 1-3 for severity',
  `DX_Syphilis` tinyint(1) DEFAULT NULL COMMENT '0 for no, 1-3 for severity',
  `DX_Topical` tinyint(1) DEFAULT NULL COMMENT '0 for no, 1-3 for severity',
  `DX_TopicalDescrip` text COMMENT '0 for no, 1-3 for severity',
  `DX_Other` tinyint(1) DEFAULT NULL COMMENT '0 for no, 1-3 for severity',
  `DX_OtherDescrip` text,
  `RegANC` varchar(3) DEFAULT NULL COMMENT 'yes, no',
  `PrevIPTpYes` tinyint(1) DEFAULT NULL COMMENT 'possibly not needed if we already have testing dates',
  `LastIPTpGT1MonYes` tinyint(1) DEFAULT NULL COMMENT 'possibly not needed if we already have testing dates',
  `ClinicalAnemia` varchar(3) DEFAULT NULL COMMENT 'yes, no',
  `Sulfadar` tinyint(1) DEFAULT NULL COMMENT 'SP500/25 Tabs',
  `Rx_Paracetamol` varchar(3) DEFAULT NULL COMMENT 'yes, no',
  `Rx_BenzPen` varchar(3) DEFAULT NULL COMMENT 'yes, no',
  `Rx_Ceftriaxone` varchar(3) DEFAULT NULL COMMENT 'yes, no',
  `Rx_Kit_PCM` varchar(3) DEFAULT NULL COMMENT 'yes, no',
  `Rx_Kit_Pregnancy` varchar(3) DEFAULT NULL COMMENT 'yes, no',
  `Rx_ALU` tinyint(1) DEFAULT NULL COMMENT '3/7 (value)x2, 0 for no',
  `Rx_PUD` varchar(3) DEFAULT NULL COMMENT 'yes, no',
  `Rx_PZQ_Tabs` tinyint(2) DEFAULT NULL COMMENT 'number of tabs',
  `Rx_PZQ_Dose` text COMMENT 'dosage information',
  `RX_Eye` text,
  `RX_Other` longtext,
  `SP_PatInit` varchar(5) DEFAULT NULL,
  `SP_PatGender` varchar(1) DEFAULT NULL,
  `SP_PatPreg` varchar(3) DEFAULT NULL COMMENT 'yes, no, n/a',
  `SP_PatNumMonths` int(10) DEFAULT NULL,
  `SP_PatBF` varchar(3) DEFAULT NULL COMMENT 'yes, no',
  `SP_PatMTZ` varchar(50) DEFAULT NULL,
  `SP_PatDoxy` varchar(50) DEFAULT NULL,
  `SP_PatAmox` varchar(50) DEFAULT NULL,
  `SP_Par1Init` varchar(5) DEFAULT NULL,
  `SP_Par1Gender` varchar(1) DEFAULT NULL,
  `SP_Par1Preg` varchar(3) DEFAULT NULL COMMENT 'yes, no, n/a',
  `SP_Par1NumMonths` int(10) DEFAULT NULL,
  `SP_Par1BF` varchar(3) DEFAULT NULL COMMENT 'yes, no',
  `SP_Par1MTZ` varchar(50) DEFAULT NULL,
  `SP_Par1Doxy` varchar(50) DEFAULT NULL,
  `SP_Par1Amox` varchar(50) DEFAULT NULL,
  `SP_Par2Init` varchar(5) DEFAULT NULL,
  `SP_Par2Gender` varchar(1) DEFAULT NULL,
  `SP_Par2Preg` varchar(3) DEFAULT NULL COMMENT 'yes, no, n/a',
  `SP_Par2NumMonths` int(10) DEFAULT NULL,
  `SP_Par2BF` varchar(3) DEFAULT NULL COMMENT 'yes, no',
  `SP_Par2MTZ` varchar(50) DEFAULT NULL,
  `SP_Par2Doxy` varchar(50) DEFAULT NULL,
  `SP_Par2Amox` varchar(50) DEFAULT NULL,
  `SP_Par3Init` varchar(5) DEFAULT NULL,
  `SP_Par3Gender` varchar(1) DEFAULT NULL,
  `SP_Par3Preg` varchar(3) DEFAULT NULL COMMENT 'yes, no, n/a',
  `SP_Par3NumMonths` int(10) DEFAULT NULL,
  `SP_Par3BF` varchar(3) DEFAULT NULL COMMENT 'yes, no',
  `SP_Par3MTZ` varchar(50) DEFAULT NULL,
  `SP_Par3Doxy` varchar(50) DEFAULT NULL,
  `SP_Par3Amox` varchar(50) DEFAULT NULL,
  `FollowUp` longtext,
  `ReturnTo` varchar(10) DEFAULT NULL COMMENT 'mission or # of days to dispensary',
  `Education` longtext,
  `Practitioners` varchar(100) DEFAULT NULL,
  `Referral` varchar(8) DEFAULT NULL COMMENT 'tb, surgery, hospital',
  `RXNum` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_visit`
--

INSERT INTO `tbl_visit` (`VisitID`, `PatientID`, `VisitDate`, `VisitTime`, `VisitedDispensary`, `TriageTesting`, `TriageMedical`, `TriageGYN`, `TriageOPHT`, `TriageDENT`, `TriageVenDis`, `Weight`, `Temperature`, `BloodPressure`, `Glucose`, `HeartRate`, `LastPeriod`, `Pregnant`, `Breastfeed`, `NumOfPreg`, `NumLiveBirth`, `NumAbortions`, `NumLivingChildren`, `VTest`, `MalariaTest`, `SyphilisTest`, `TyphTest`, `UrineLeucTest`, `UrineRBCTest`, `UrineGlucoseTest`, `UrineNitritesTest`, `PregnancyTest`, `ChiefComplaint`, `Assessment`, `LastHIVTest`, `LastPZQTx`, `LastWormTx`, `LastVitA`, `PrevMeds`, `DX_Healthy`, `DX_NoTreatment`, `DX_MSK`, `DX_Worms`, `DX_Asthma`, `DX_Bronchitis`, `DX_Pneumonia`, `DX_Cough`, `DX_Malaria`, `DX_Schisto`, `DX_Typhoid`, `DX_Gerd`, `DX_PUD`, `DX_Diarrhea`, `DX_DiarrheaBloody`, `DX_Hypertension`, `DX_Diabetes`, `DX_Constipation`, `DX_PID`, `DX_STI`, `DX_Syphilis`, `DX_Topical`, `DX_TopicalDescrip`, `DX_Other`, `DX_OtherDescrip`, `RegANC`, `PrevIPTpYes`, `LastIPTpGT1MonYes`, `ClinicalAnemia`, `Sulfadar`, `Rx_Paracetamol`, `Rx_BenzPen`, `Rx_Ceftriaxone`, `Rx_Kit_PCM`, `Rx_Kit_Pregnancy`, `Rx_ALU`, `Rx_PUD`, `Rx_PZQ_Tabs`, `Rx_PZQ_Dose`, `RX_Eye`, `RX_Other`, `SP_PatInit`, `SP_PatGender`, `SP_PatPreg`, `SP_PatNumMonths`, `SP_PatBF`, `SP_PatMTZ`, `SP_PatDoxy`, `SP_PatAmox`, `SP_Par1Init`, `SP_Par1Gender`, `SP_Par1Preg`, `SP_Par1NumMonths`, `SP_Par1BF`, `SP_Par1MTZ`, `SP_Par1Doxy`, `SP_Par1Amox`, `SP_Par2Init`, `SP_Par2Gender`, `SP_Par2Preg`, `SP_Par2NumMonths`, `SP_Par2BF`, `SP_Par2MTZ`, `SP_Par2Doxy`, `SP_Par2Amox`, `SP_Par3Init`, `SP_Par3Gender`, `SP_Par3Preg`, `SP_Par3NumMonths`, `SP_Par3BF`, `SP_Par3MTZ`, `SP_Par3Doxy`, `SP_Par3Amox`, `FollowUp`, `ReturnTo`, `Education`, `Practitioners`, `Referral`, `RXNum`) VALUES
(1, 1, '2017-05-05', '08:30:00', 'Bugorola', 'yes', 'yes', 'no', 'no', 'no', 'no', '12.3', '37.0', '130/80', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', 'pending', 'pending', 'pending', 'pending', 'pending', 'pending', 'pending', NULL, NULL, 'Traumatized child. Unable to speak clearly. Full testing suggested.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, NULL, '0', NULL, NULL, '0', 0, '0', '0', '0', '0', '0', 0, '0', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Shook keys to try and calm.', '5', NULL, NULL, NULL, NULL),
(2, 2, '2017-08-10', '01:14:00', 'Bugorola', 'yes', 'yes', 'no', 'no', 'no', 'no', '60', '38.5', '110/70', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'no', 'pending', 'no', 'pending', 'pending', 'pending', 'pending', 'pending', NULL, 'Thinks he\'s being followed by another teen.', 'Crash landed a helicopter in the jungle. Only minor wounds considering but seems a bit delusional.', NULL, NULL, NULL, NULL, NULL, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, NULL, 'no', NULL, NULL, 'no', 0, 'no', 'no', 'no', NULL, NULL, 0, 'no', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2', 'Told him to take it easy and not to worry.', NULL, NULL, NULL),
(3, 3, '2017-08-13', '17:17:00', 'Ukara', 'yes', 'yes', 'no', 'no', 'yes', 'no', '62', '35', '70/120', 5, 74, NULL, 'no', NULL, NULL, NULL, NULL, NULL, 'pending', 'pending', 'pending', 'pending', 'pending', 'pending', 'pending', 'pending', 'no', 'Not feeling well', 'Examined her. Malnourished. Infected cut to left knee', 'Unknown', 'Unknown', 'Unknown', 'Unknown', 'Unknown', NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, NULL, 'no', 0, NULL, 'no', 0, 'no', 'no', 'no', 'no', 'no', 0, 'no', 0, NULL, NULL, NULL, NULL, NULL, 'no', NULL, 'no', NULL, NULL, NULL, NULL, NULL, 'no', NULL, 'no', NULL, NULL, NULL, NULL, NULL, 'no', NULL, 'no', NULL, NULL, NULL, NULL, NULL, 'no', NULL, 'no', NULL, NULL, NULL, 'Bandage for cut. Arrangement to see nurse', NULL, NULL, 'Dr. Num One', NULL, NULL),
(4, 3, '2017-08-15', '13:38:00', 'Ukara', 'yes', 'yes', 'no', 'no', 'no', 'no', '62', '36', '73/130', 6, 76, NULL, 'no', NULL, NULL, NULL, NULL, NULL, 'negative', 'negative', 'negative', 'negative', 'negative', 'negative', 'negative', 'negative', NULL, 'Uncomfortable', 'Examined her. Malnourished. Still infected cut to left knee', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 1, 'Infection', 'no', 0, NULL, 'no', 0, 'no', 'no', 'no', 'no', 'no', 0, 'no', 0, NULL, NULL, NULL, NULL, NULL, 'no', NULL, 'no', NULL, NULL, NULL, NULL, NULL, 'no', NULL, 'no', NULL, NULL, NULL, NULL, NULL, 'no', NULL, 'no', NULL, NULL, NULL, NULL, NULL, 'no', NULL, 'no', NULL, NULL, NULL, 'Bandage for cut. Arrangement to see nurse', NULL, NULL, 'Dr. Num One', NULL, NULL),
(5, 4, '2017-08-16', '15:24:00', 'Bukondo', 'no', 'complete', 'no', 'no', 'complete', 'complete', '100', '37', '120/80', NULL, 64, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', 'no', 'pending', 'no', 'no', 'no', 'no', 'no', NULL, 'sore back', 'farmer\r\nmoderate lower back pain\r\nshould get education on proper bending\r\nr22 aerobic infection', NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 0, 1, 0, 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, NULL, 'no', 0, 0, 'no', 0, 'no', 'no', 'no', 'yes', 'no', 0, '0', 6, '6', NULL, 'MTZ200 x 3 x 5/7\r\naminophylline 200mg x3 x 10/7', NULL, NULL, 'no', NULL, 'no', NULL, NULL, NULL, NULL, NULL, 'no', NULL, 'no', NULL, NULL, NULL, NULL, NULL, 'no', NULL, 'no', NULL, NULL, NULL, NULL, NULL, 'no', NULL, 'no', NULL, NULL, NULL, NULL, NULL, NULL, 'wm', NULL, '5'),
(6, 5, '2017-08-21', '21:36:00', 'Kabuhinzi', 'no', 'complete', 'no', 'no', 'no', 'no', '55', '37', '120/80', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', 'pending', 'no', 'pending', 'no', 'no', 'no', 'no', NULL, 'doesn\'t feel well, low energy, diarrhea', 'seems malnourished. send for testing', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 2, 1, 0, 0, 0, 0, 0, 0, 0, NULL, 0, NULL, 'no', 0, 0, 'no', 0, 'no', 'yes', 'yes', 'yes', NULL, 1, 'no', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no', '10', NULL, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 6, '2017-08-21', '21:19:00', 'Buzegwe', 'no', 'no', 'no', 'no', 'no', 'complete', NULL, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, NULL, 'no', 'pending', 'no', 'pending', 'no', 'no', 'no', 'no', 'no', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, NULL, 'no', 0, 0, 'no', 0, 'no', 'no', 'no', 'no', 'no', 0, '0', 0, NULL, NULL, NULL, NULL, NULL, 'no', NULL, 'no', '10', '14', NULL, NULL, NULL, 'no', NULL, 'no', NULL, NULL, NULL, NULL, NULL, 'no', NULL, 'no', NULL, NULL, NULL, NULL, NULL, 'no', NULL, 'no', NULL, NULL, NULL, NULL, '1', NULL, NULL, 'tb', '15'),
(8, 7, '2017-09-15', '17:30:00', 'Igalla', 'pending', 'complete', 'complete', 'complete', 'no', 'no', NULL, NULL, NULL, NULL, NULL, NULL, 'yes', NULL, NULL, NULL, NULL, NULL, 'positive', 'positive', 'positive', 'positive', 'positive', 'positive', 'positive', 'positive', 'positive', NULL, 'this is a test', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, NULL, 'no', 0, 0, 'no', 0, 'no', 'no', 'no', 'no', 'no', 0, 'no', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_dispensary`
--
ALTER TABLE `tbl_dispensary`
  ADD PRIMARY KEY (`DispensaryID`),
  ADD UNIQUE KEY `LU_DispensaryDispensary` (`DispensaryName`);

--
-- Indexes for table `tbl_drugs`
--
ALTER TABLE `tbl_drugs`
  ADD PRIMARY KEY (`drugID`);

--
-- Indexes for table `tbl_patient`
--
ALTER TABLE `tbl_patient`
  ADD PRIMARY KEY (`PatientID`),
  ADD KEY `LU_VillageTbl_Demog` (`Village`),
  ADD KEY `PatientName` (`FirstName`),
  ADD KEY `PatientLastName` (`LastName`);

--
-- Indexes for table `tbl_tests`
--
ALTER TABLE `tbl_tests`
  ADD PRIMARY KEY (`testID`);

--
-- Indexes for table `tbl_village`
--
ALTER TABLE `tbl_village`
  ADD PRIMARY KEY (`VillageID`),
  ADD UNIQUE KEY `Village` (`Village`);

--
-- Indexes for table `tbl_visit`
--
ALTER TABLE `tbl_visit`
  ADD PRIMARY KEY (`VisitID`),
  ADD KEY `ChartNum` (`PatientID`),
  ADD KEY `LU_DispensaryTbl_Visit` (`VisitedDispensary`),
  ADD KEY `Tbl_VisitDispensary` (`VisitedDispensary`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_dispensary`
--
ALTER TABLE `tbl_dispensary`
  MODIFY `DispensaryID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `tbl_drugs`
--
ALTER TABLE `tbl_drugs`
  MODIFY `drugID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_patient`
--
ALTER TABLE `tbl_patient`
  MODIFY `PatientID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `tbl_tests`
--
ALTER TABLE `tbl_tests`
  MODIFY `testID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_village`
--
ALTER TABLE `tbl_village`
  MODIFY `VillageID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `tbl_visit`
--
ALTER TABLE `tbl_visit`
  MODIFY `VisitID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
