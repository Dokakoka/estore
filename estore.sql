-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 06, 2022 at 02:42 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `estore`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Tshirt'),
(2, 'Dress'),
(5, 'Shoes'),
(6, 'Bags');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `order_status` tinyint(1) NOT NULL DEFAULT 0,
  `order_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `qty`, `client_id`, `product_id`, `order_status`, `order_time`) VALUES
(2, 6, 4, 3, 1, '2022-11-27 14:26:44'),
(3, 1, 4, 3, 1, '2022-11-27 14:30:22'),
(4, 2, 4, 3, 1, '2022-11-27 14:30:32'),
(10, 2, 4, 4, 1, '2022-12-04 01:22:27'),
(15, 4, 4, 5, 1, '2022-12-04 01:54:12'),
(16, 2, 4, 4, 1, '2022-12-04 01:56:00'),
(17, 3, 4, 5, 1, '2022-12-04 01:56:07'),
(18, 1, 4, 4, 1, '2022-12-04 02:03:31'),
(19, 1, 4, 5, 1, '2022-12-04 02:05:02'),
(24, 1, 11, 3, 1, '2022-12-05 14:33:59'),
(25, 2, 11, 4, 1, '2022-12-05 14:34:12');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(300) NOT NULL,
  `price` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `img` varchar(100) NOT NULL,
  `added_time` date NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `qty`, `img`, `added_time`, `user_id`, `category_id`) VALUES
(3, 'Tshirt', 'This is a good T-Shirt', 100, 9, '638ca69c7f4112.11251561.img-pro-01', '2022-11-26', 8, 1),
(4, 'Shoes', 'This is a good shoes', 40, 18, '638ca6c8aa6ee6.99742393.instagram-img-03', '2022-12-02', 8, 1),
(5, 'Women Bag', 'This is a good bag', 70, 8, '', '2022-12-04', 8, 6);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `img` varchar(50) NOT NULL,
  `type` enum('admin','user','client','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone`, `img`, `type`) VALUES
(1, 'Ahmed Morsy', 'admin@gmail.com', '$2y$10$elwV7wlRll86gYoK/MjG4OjtXeq1o7SUV9Bb2E3gZIBfjgviy5edC', '01017479880', '638e000eb71e55.80353906.img-pro-01', 'user'),
(4, 'Hamza', 'hamza@gmail.com', '', '015663321377', '6382b190bb8531.96187719.img-1', 'client'),
(8, 'Mohamed Ayman', 'mohamed@gmail.com', '$2y$10$fluC7pbTLeZGhSfXuGqkiu9bNQABbrJXhnxUV7wMnk8pQD/ACSoR2', '0123968332', '638c1274474f17.98100985.img-3', 'admin'),
(9, 'Mostafa', 'mostafa@gmail.com', '$2y$10$Aq/y99rkO35DeRYEFNxYweYekRJN7EsDI2Y3J2YUbd2lhhJUjuZc.', '01055668320', '6383727db12f81.56997572.img-1', 'user'),
(11, 'Ahmed', 'ahmed@gmail.com', '', '0123968332', '', 'client');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_FK` (`client_id`),
  ADD KEY `product_FK` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk` (`user_id`),
  ADD KEY `cfk` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `client_FK` FOREIGN KEY (`client_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `product_FK` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `cfk` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
