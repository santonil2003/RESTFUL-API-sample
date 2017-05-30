-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 30, 2017 at 11:05 PM
-- Server version: 5.7.17-0ubuntu0.16.04.1
-- PHP Version: 7.0.15-0ubuntu0.16.04.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `api`
--

-- --------------------------------------------------------

--
-- Table structure for table `coffees`
--

CREATE TABLE `coffees` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `coffees`
--

INSERT INTO `coffees` (`id`, `name`, `image_url`) VALUES
(1, 'Espresso', '1.jpg'),
(2, 'Long black', '2.jpg'),
(3, 'Long macchiato', '3.jpg'),
(4, 'cafe latte', '4.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `coffee_reviews`
--

CREATE TABLE `coffee_reviews` (
  `id` int(11) NOT NULL,
  `reviewer_name` varchar(255) DEFAULT NULL,
  `review` text,
  `rating` int(11) NOT NULL,
  `coffee_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `coffee_reviews`
--

INSERT INTO `coffee_reviews` (`id`, `reviewer_name`, `review`, `rating`, `coffee_id`) VALUES
(2, 'Sam', 'To much sugur is good', 1, 2),
(4, 'Ram ', 'this is ram comments', 5, 1),
(7, 'Robert', 'testing comment', 2, 3),
(8, 'John', 'nice spoon', 4, 4),
(9, 'Peter', 'I prefer tea', 4, 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `coffees`
--
ALTER TABLE `coffees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coffee_reviews`
--
ALTER TABLE `coffee_reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_review_coffee_idx` (`coffee_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `coffees`
--
ALTER TABLE `coffees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `coffee_reviews`
--
ALTER TABLE `coffee_reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `coffee_reviews`
--
ALTER TABLE `coffee_reviews`
  ADD CONSTRAINT `fk_review_coffee` FOREIGN KEY (`coffee_id`) REFERENCES `coffees` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
