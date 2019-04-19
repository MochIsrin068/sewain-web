-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 19, 2019 at 03:24 PM
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
-- Table structure for table `table_category`
--

CREATE TABLE `table_category` (
  `id_category` int(11) NOT NULL,
  `category_name` varchar(200) NOT NULL,
  `category_description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `table_category`
--

INSERT INTO `table_category` (`id_category`, `category_name`, `category_description`) VALUES
(1, 'kebersihan', 'kebersihan');

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
-- Table structure for table `table_portofolio`
--

CREATE TABLE `table_portofolio` (
  `id_portofolio` int(11) NOT NULL,
  `portofolio_name` varchar(200) NOT NULL,
  `portofolio_description` text NOT NULL,
  `portofolio_images` text NOT NULL,
  `id_service` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `table_portofolio`
--

INSERT INTO `table_portofolio` (`id_portofolio`, `portofolio_name`, `portofolio_description`, `portofolio_images`, `id_service`) VALUES
(2, 'kegiatan 1', 'kegiatan 1', 'kegiatan 1', 2);

-- --------------------------------------------------------

--
-- Table structure for table `table_service`
--

CREATE TABLE `table_service` (
  `id_service` int(11) NOT NULL,
  `service_name` varchar(200) NOT NULL,
  `service_description` text NOT NULL,
  `service_images` text NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_category` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `table_service`
--

INSERT INTO `table_service` (`id_service`, `service_name`, `service_description`, `service_images`, `id_user`, `id_category`) VALUES
(2, 'bersih-bersih', 'bersih-bersih', 'bersih-bersih', 15, 1);

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
(1, '', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', '1234', 1, 1555586294, 123443, 'muh alfalah', 'madukubah', 'JASAIN_USER_1_1555579157.jpeg', 'jalanan'),
(15, '::1', 'admin@admin.com', '5f4dcc3b5aa765d61d8327deb882cf99', 'admin@admin.com', '1234', 1, 1555668356, 1555585225, 'alan', 'hetfield', 'JASAIN_USER_15_1555585269.jpeg', 'jln mutiara no 8');

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
(11, 15, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `table_category`
--
ALTER TABLE `table_category`
  ADD PRIMARY KEY (`id_category`);

--
-- Indexes for table `table_group`
--
ALTER TABLE `table_group`
  ADD PRIMARY KEY (`id_group`);

--
-- Indexes for table `table_portofolio`
--
ALTER TABLE `table_portofolio`
  ADD PRIMARY KEY (`id_portofolio`),
  ADD KEY `id_service` (`id_service`);

--
-- Indexes for table `table_service`
--
ALTER TABLE `table_service`
  ADD PRIMARY KEY (`id_service`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_category` (`id_category`);

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
-- AUTO_INCREMENT for table `table_category`
--
ALTER TABLE `table_category`
  MODIFY `id_category` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `table_group`
--
ALTER TABLE `table_group`
  MODIFY `id_group` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `table_portofolio`
--
ALTER TABLE `table_portofolio`
  MODIFY `id_portofolio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `table_service`
--
ALTER TABLE `table_service`
  MODIFY `id_service` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `table_user`
--
ALTER TABLE `table_user`
  MODIFY `id_user` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `table_user_group`
--
ALTER TABLE `table_user_group`
  MODIFY `id_user_group` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `table_portofolio`
--
ALTER TABLE `table_portofolio`
  ADD CONSTRAINT `table_portofolio_ibfk_1` FOREIGN KEY (`id_service`) REFERENCES `table_service` (`id_service`);

--
-- Constraints for table `table_service`
--
ALTER TABLE `table_service`
  ADD CONSTRAINT `table_service_ibfk_1` FOREIGN KEY (`id_category`) REFERENCES `table_category` (`id_category`);

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
