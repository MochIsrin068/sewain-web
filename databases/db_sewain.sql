-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 06, 2019 at 01:09 PM
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
-- Database: `db_sewain`
--

-- --------------------------------------------------------

--
-- Table structure for table `advertisement`
--

CREATE TABLE `advertisement` (
  `id` int(5) NOT NULL,
  `description` text NOT NULL,
  `image` text NOT NULL,
  `create_date` int(11) NOT NULL,
  `order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `advertisement`
--

INSERT INTO `advertisement` (`id`, `description`, `image`, `create_date`, `order`) VALUES
(7, 'asdf', 'IKLAN_1_1557140546.jpg', 0, 0),
(8, 'asdffds', 'IKLAN_1_1557140570.jpg', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

CREATE TABLE `book` (
  `id` int(5) NOT NULL,
  `title` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `category_id` int(5) NOT NULL,
  `user_id` int(5) NOT NULL,
  `images` text NOT NULL,
  `language` varchar(100) NOT NULL,
  `author` varchar(200) NOT NULL,
  `page_count` int(11) NOT NULL,
  `publisher` varchar(200) NOT NULL,
  `create_date` int(11) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `book`
--

INSERT INTO `book` (`id`, `title`, `description`, `category_id`, `user_id`, `images`, `language`, `author`, `page_count`, `publisher`, `create_date`, `price`) VALUES
(23, 'Balada si Roy : Joe', 'Roy mengayuh sepeda balapnya pelan-pelan. \"Ayo, Joe!\" seru Roy.  Anjing herder itu menyalak kegirangan. Bulunya yang cokelat kehitaman berkilat.  Gerak-geriknya melindungi majikannya dari bahaya. Roy memang selalu jadi pusat  perhatian. Ke sekolah dengan sepeda balap dan anjing herder? Itu absurd.  Sebuah objek sensasi. Lain waktu telinganya mendengar suara-suara centil,  manja, genit, dan menggemaskan. Dia memang keren. Tubuhnya jangkung atletis.  Tampan tapi tidak kolokan. Berbeda dari cowok kebanyakan. Senyumnya memang  memabukkan, bandel, dan khas berandal. Roy mengalami segala problematika  khas cowok; cinta, persahabatan, dan permusuhan. Tapi itu belum seberapa.  Ketika rasa kehilangan yang pekat menghantam Roy, dia menghadapi tantangan  terberat. Hanya terpuruk meratapi nasib, melarikan diri pada hal-hal terlarang,  atau bangkit dan menjadi lelaki sejati? *** “Roy sudah jadi legenda di pembaca.  Dia banyak memberi inspirasi untuk bangkit memperjuangkan hidup.”', 6, 15, 'BOOK_15_1556985766_0.jpg', 'Indonesia', 'Gol A Gong', 368, 'Gramedia Pustaka Utama', 1556985766, 10000),
(24, 'Drifting Away', 'You told me that you\'d be nothing without me, You said you\'d go through  fire and hell but you\'re here standing in front of me. seen from the maroon  trails on my skin wounded and blistered. as you kiss my forehead,  took two steps back I saw the blood covering your hands,  I couldn\'t fell my pulse because you were also holding my heart', 4, 15, 'BOOK_15_1556986121_0.jpg', 'English', 'Latisa Naraswari', 229, 'Coconut Books', 1556986121, 10000),
(25, 'Samudera', 'Ini bukan cerita tentang bad boy atau ice boy. Ini hanya cerita tentang  Samudera yang bersahabat dengan Oceana. Di mana kedeketan mereka membuat  Samudera harus putus dengan pacarnya, yang juga teman dekat Oceana.  Ini adalah cerita tentang rumitnya cinta berkedok persahabatan.  Samudera dan Oceana, dua nama berbeda, tapi mempunyai arti yang sama.  Seperti halnya kita, dua orang berbeda tapi mempunyai hati yang sama sama saling mencintai', 6, 17, 'BOOK_17_1557025720_0.jpg', 'Indonesia', 'Mulya Fitri Anggriani', 326, 'Aksara Plus', 1557025720, 10000);

-- --------------------------------------------------------

--
-- Table structure for table `book_genre`
--

CREATE TABLE `book_genre` (
  `id` int(5) NOT NULL,
  `book_id` int(5) NOT NULL,
  `genre_id` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `book_genre`
--

INSERT INTO `book_genre` (`id`, `book_id`, `genre_id`) VALUES
(41, 23, 4),
(43, 23, 6),
(44, 23, 7),
(45, 24, 2),
(46, 24, 3),
(47, 24, 5),
(48, 24, 6),
(49, 25, 4),
(50, 25, 7);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(5) NOT NULL,
  `name` varchar(200) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `description`) VALUES
(1, 'prasejarah', 'prasejarah'),
(4, 'fashion', 'fashion'),
(5, 'anak-anak', 'anak-anak'),
(6, 'pendidikan', 'pendidikan');

-- --------------------------------------------------------

--
-- Table structure for table `genre`
--

CREATE TABLE `genre` (
  `id` int(5) NOT NULL,
  `name` varchar(200) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `genre`
--

INSERT INTO `genre` (`id`, `name`, `description`) VALUES
(2, 'horror', 'horror'),
(3, 'fantasy', 'fantasy'),
(4, 'slice of life', 'slice of life'),
(5, 'thriller', 'thriller'),
(6, 'action', 'action'),
(7, 'romance', 'romance');

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
(1, '', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', '081342989185', 1, 1557109242, 123443, 'muh alfalah', 'madukubah', 'USER_1_1556728458.jpeg', 'jalanan'),
(15, '::1', 'admin@admin.com', '21232f297a57a5a743894a0e4a801fc3', 'admin@admin.com', '1234', 1, 1557086655, 1555585225, 'alan', 'hetfield', 'JASAIN_USER_15_1555585269.jpeg', 'jln mutiara no 8'),
(16, '::1', 'admin1@admin.com', '225bc7ac4aaa1e606a628e990fe2d398', 'admin1@admin.com', '1234', 1, 1556691983, 1556691974, 'alan', 'hetfield', '', 'jalanan'),
(17, '::1', 'alin@alin.com', '827ccb0eea8a706c4c34a16891f84e7b', 'alin@alin.com', '4321', 1, 1557025469, 1557025453, 'alin', 'alin', '', 'alin');

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
(12, 16, 2),
(13, 17, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `advertisement`
--
ALTER TABLE `advertisement`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `book_genre`
--
ALTER TABLE `book_genre`
  ADD PRIMARY KEY (`id`),
  ADD KEY `book_id` (`book_id`),
  ADD KEY `genre_id` (`genre_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `genre`
--
ALTER TABLE `genre`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `graph`
--
ALTER TABLE `graph`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `advertisement`
--
ALTER TABLE `advertisement`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `book`
--
ALTER TABLE `book`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `book_genre`
--
ALTER TABLE `book_genre`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `genre`
--
ALTER TABLE `genre`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `graph`
--
ALTER TABLE `graph`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `table_group`
--
ALTER TABLE `table_group`
  MODIFY `id_group` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `table_user`
--
ALTER TABLE `table_user`
  MODIFY `id_user` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `table_user_group`
--
ALTER TABLE `table_user_group`
  MODIFY `id_user_group` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `book`
--
ALTER TABLE `book`
  ADD CONSTRAINT `book_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`),
  ADD CONSTRAINT `book_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `table_user` (`id_user`);

--
-- Constraints for table `book_genre`
--
ALTER TABLE `book_genre`
  ADD CONSTRAINT `book_genre_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `book` (`id`),
  ADD CONSTRAINT `book_genre_ibfk_2` FOREIGN KEY (`genre_id`) REFERENCES `genre` (`id`);

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
