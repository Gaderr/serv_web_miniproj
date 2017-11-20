-- phpMyAdmin SQL Dump
-- version 4.3.11.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 11, 2016 at 12:22 PM
-- Server version: 5.5.50-0+deb7u2
-- PHP Version: 5.4.45-1~dotdeb+7.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";



-- Table structure for table `parties`


CREATE TABLE IF NOT EXISTS `parties` (
  `id` int(11) NOT NULL,
  `pseudo` varchar(20) CHARACTER SET utf8 NOT NULL,
  `partieGagnee` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `parties`
--
ALTER TABLE `parties`
  ADD PRIMARY KEY (`id`), ADD KEY `pseudo` (`pseudo`), ADD KEY `pseudo_2` (`pseudo`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `parties`
--
ALTER TABLE `parties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `parties`
--
ALTER TABLE `parties`
ADD CONSTRAINT `parties_ibfk_1` FOREIGN KEY (`pseudo`) REFERENCES `joueurs` (`pseudo`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
