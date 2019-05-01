-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 01, 2019 at 08:36 AM
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
-- Database: `db_mycore`
--

-- --------------------------------------------------------

--
-- Table structure for table `graph`
--

CREATE TABLE `graph` (
  `id` int(11) NOT NULL,
  `node` text NOT NULL,
  `adj_list` text NOT NULL,
  `scope` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `graph`
--

INSERT INTO `graph` (`id`, `node`, `adj_list`, `scope`) VALUES
(1, '2', '3,4', 'a'),
(2, '3', '6', 'a');

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
(1, 'kebersihan', 'kebersihan 1'),
(2, 'agrikultur', 'agrikultur'),
(3, 'category_name', 'category_description');

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
(1, '', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', '081342989185', 1, 1556688454, 123443, 'muh alfalah', 'madukubah', 'USER_1_1556685707.png', 'jalanan'),
(15, '::1', 'admin@admin.com', '21232f297a57a5a743894a0e4a801fc3', 'admin@admin.com', '1234', 1, 1556688422, 1555585225, 'alan', 'hetfield', 'JASAIN_USER_15_1555585269.jpeg', 'jln mutiara no 8'),
(16, '::1', 'admin1@admin.com', '225bc7ac4aaa1e606a628e990fe2d398', 'admin1@admin.com', '1234', 1, 1556691983, 1556691974, 'alan', 'hetfield', '', 'jalanan');

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
(11, 15, 2),
(12, 16, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `graph`
--
ALTER TABLE `graph`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `graph`
--
ALTER TABLE `graph`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `table_category`
--
ALTER TABLE `table_category`
  MODIFY `id_category` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `table_group`
--
ALTER TABLE `table_group`
  MODIFY `id_group` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `table_user`
--
ALTER TABLE `table_user`
  MODIFY `id_user` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `table_user_group`
--
ALTER TABLE `table_user_group`
  MODIFY `id_user_group` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

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
