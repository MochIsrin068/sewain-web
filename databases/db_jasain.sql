-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 16, 2019 at 12:34 AM
-- Server version: 10.1.34-MariaDB
-- PHP Version: 7.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_jasain`
--

-- --------------------------------------------------------

--
-- Table structure for table `table_group`
--

CREATE TABLE `table_group` (
  `id_group` int(5) NOT NULL,
  `group_name` varchar(100) NOT NULL,
  `group_description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `table_group`
--

INSERT INTO `table_group` (`id_group`, `group_name`, `group_description`) VALUES
(1, 'admin', 'admin'),
(2, 'members', 'members');

-- --------------------------------------------------------

--
-- Table structure for table `table_user`
--

CREATE TABLE `table_user` (
  `id_user` int(5) NOT NULL,
  `ip_address` varchar(100) NOT NULL,
  `user_username` varchar(200) NOT NULL,
  `user_password` varchar(200) NOT NULL,
  `user_email` varchar(200) NOT NULL,
  `user_phone` varchar(20) NOT NULL,
  `user_status` int(5) NOT NULL,
  `user_last_login` int(11) NOT NULL,
  `create_date` int(11) NOT NULL,
  `user_first_name` varchar(200) NOT NULL,
  `user_last_name` varchar(200) NOT NULL,
  `user_image` varchar(200) NOT NULL,
  `user_address` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `table_user`
--

INSERT INTO `table_user` (`id_user`, `ip_address`, `user_username`, `user_password`, `user_email`, `user_phone`, `user_status`, `user_last_login`, `create_date`, `user_first_name`, `user_last_name`, `user_image`, `user_address`) VALUES
(1, '', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', '1234', 1, 1555340159, 123443, 'muh alfalah', 'madukubah', '', ''),
(8, '::1', '12341', 'b93939873fd4923043b9dec975811f66', 'admin@admin.com', '12341', 1, 0, 1554823291, 'tes', 'tes', '', 'tes'),
(9, '::1', '123443', 'b93939873fd4923043b9dec975811f66', 'admin21@admin.com', '123443', 1, 0, 1554823499, 'tes', 'tes', '', 'tes'),
(11, '::1', '12341', '19fd7be891222ed1dfc041e01fa19e13', 'admin1221@admin.com', '12341221', 1, 0, 1554836027, 'tes', 'tes', '', 'tes'),
(13, '::1', '1234321', 'b93939873fd4923043b9dec975811f66', 'admfdsain@admin.com', '1234321', 1, 0, 1555311581, 'test', 'tes', '', 'tes');

-- --------------------------------------------------------

--
-- Table structure for table `table_user_group`
--

CREATE TABLE `table_user_group` (
  `id_user_group` int(5) NOT NULL,
  `id_user` int(5) NOT NULL,
  `id_group` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `table_user_group`
--

INSERT INTO `table_user_group` (`id_user_group`, `id_user`, `id_group`) VALUES
(1, 1, 1),
(4, 8, 2),
(5, 9, 2),
(7, 11, 2),
(9, 13, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `table_group`
--
ALTER TABLE `table_group`
  ADD PRIMARY KEY (`id_group`);

--
-- Indexes for table `table_user`
--
ALTER TABLE `table_user`
  ADD PRIMARY KEY (`id_user`);

--
-- Indexes for table `table_user_group`
--
ALTER TABLE `table_user_group`
  ADD PRIMARY KEY (`id_user_group`),
  ADD KEY `id_group` (`id_group`),
  ADD KEY `id_user` (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `table_group`
--
ALTER TABLE `table_group`
  MODIFY `id_group` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `table_user`
--
ALTER TABLE `table_user`
  MODIFY `id_user` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `table_user_group`
--
ALTER TABLE `table_user_group`
  MODIFY `id_user_group` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `table_user_group`
--
ALTER TABLE `table_user_group`
  ADD CONSTRAINT `table_user_group_ibfk_1` FOREIGN KEY (`id_group`) REFERENCES `table_group` (`id_group`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `table_user_group_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `table_user` (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
