-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 13, 2022 at 07:59 PM
-- Server version: 5.7.39
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `techtip2_mwkpdfaults`
--

-- --------------------------------------------------------

--
-- Table structure for table `faults`
--

CREATE TABLE `faults` (
  `id` int(11) NOT NULL,
  `occured_on` date NOT NULL,
  `machine` varchar(64) NOT NULL,
  `main_part` text NOT NULL,
  `fault_desc` text NOT NULL,
  `rectification` text NOT NULL,
  `components` text NOT NULL,
  `entry_done_by` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `faults`
--

INSERT INTO `faults` (`id`, `occured_on`, `machine`, `main_part`, `fault_desc`, `rectification`, `components`, `entry_done_by`) VALUES
(1, '2022-03-13', 'PWL', 'Sliding Rail', 'LHS Sliding rail was not getting opened at the time of loading Train. RHS was getting opened. Drive roller pressure was 11000 and found OK.', '<p>On further investigation it was found that RHS Slide rail pressure was low and Drive rollers has raised the train wheel clear of the rail. Therefore it was not getting retracted. <strong>Raised the LHS slide rail pressure</strong> by pressure varying knob. Checked the opening and closing of slide rail . Now its Getting Opened.</p>', 'na', '6404');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `name` varchar(64) NOT NULL,
  `emp_num` varchar(16) NOT NULL,
  `desig` varchar(32) NOT NULL,
  `email` varchar(64) NOT NULL,
  `password` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`name`, `emp_num`, `desig`, `email`, `password`) VALUES
('HEMRAJ SAHU', '13211', 'JE', '', '13211'),
('SATISH', '18571', 'JE', 'iamsatishkushwah@gmail.com', '18571'),
('KGS PARIHAR', '5262', 'ASE', '', '5262'),
('JITENDRA K SHOBHAWAT', '5850', 'ASE', '', '5850'),
('YOGESH YADAV', '6354', 'SE', '', '6354'),
('SHAMBU NATH RAI', '6404', 'SSE', '', '6404');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `faults`
--
ALTER TABLE `faults`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD UNIQUE KEY `emp_num` (`emp_num`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `faults`
--
ALTER TABLE `faults`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
