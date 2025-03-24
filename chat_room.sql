-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 24, 2025 at 06:55 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `chat_room`
--

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

CREATE TABLE `chat` (
  `id` int(11) NOT NULL,
  `message` varchar(1500) NOT NULL,
  `username` varchar(30) NOT NULL,
  `date` varchar(40) NOT NULL,
  `replay` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chat`
--

INSERT INTO `chat` (`id`, `message`, `username`, `date`, `replay`) VALUES
(1, 'gello', 'a', '0000-00-00 00:00:00', NULL),
(2, 'hey proder', 'a', '0000-00-00 00:00:00', NULL),
(3, 'heyman iam fine and you', 'a', '0000-00-00 00:00:00', NULL),
(4, 'im good', 'a', '0000-00-00 00:00:00', 'Replay to: a'),
(5, 'lo', 'a', '0000-00-00 00:00:00', NULL),
(6, 'lol', 'a', '0000-00-00 00:00:00', 'Replay to: a'),
(7, 'lol', 'a', '0000-00-00 00:00:00', 'Replay to: a by id: 5'),
(8, 'what', 'a', '0000-00-00 00:00:00', 'Replay to: a / by id: 1'),
(9, 'hello', 'uiman02', '0000-00-00 00:00:00', NULL),
(10, 'heyman iam fine and you', 'uiman02', '0000-00-00 00:00:00', 'Replay to: uiman02 / by id: 9'),
(11, 'hello', 'uiman02', '0000-00-00 00:00:00', NULL),
(12, 'hey', 'uiman02', '0000-00-00 00:00:00', 'Replay to: a / by id: 1'),
(13, 'lol', 'uiman02', '0000-00-00 00:00:00', 'Replay to: uiman02 / by id: 12'),
(14, 'hey', 'uiman02', '0000-00-00 00:00:00', NULL),
(15, 'gggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggg', 'uiman02', '0000-00-00 00:00:00', NULL),
(16, 'hello ,world', 'uiman02', '24/03/2025 18:12:53', NULL),
(17, 'hey', 'uiman02', '24/03/2025 18:14:18', NULL),
(18, 'hey', 'alposgl', '24/03/2025 18:23:06', NULL),
(19, 'yeh man gooooooooooooooooooo', 'sol2', '24/03/2025 18:40:37', 'Reply to: a / by id: 2');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL COMMENT '255',
  `password` varchar(255) NOT NULL,
  `created` varchar(40) NOT NULL,
  `img` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created`, `img`) VALUES
(1, 'altoid', '$2y$10$kuMNvp5yX3ifVvI9elURpeAJEnUd8PavYsdkt/v2mv8uK45q6h3S2', '0000-00-00', ''),
(2, 'goolman', '$2y$10$imYUUUCrB/UIzlTypsouCelRm5iE6Ebjki0/fDNyOZw7gfFeIFogW', '0000-00-00', NULL),
(3, 'ba', '$2y$10$Neze1CIgv3GYbuBzyZ9rDOWEJf/ZuVg2AyBDVFgmnspGa/wAX6Zy.', '0000-00-00', ''),
(4, 'a', '$2y$10$yanngLC2uKqcOdt8ncjOq.7ysS9n/gTReLCLDRmvb1wRi.zawMtSq', '0000-00-00', '1e3421f91e0ade.png'),
(5, 'b', '$2y$10$ao1ot/SIegm5Yy0/B/MRJurd8d.zTyS40RlJq32ugRRQM.uhfIm1W', '0000-00-00', NULL),
(6, 'uiman02', '$2y$10$TAfrwl21OqPAtEjsOihYSux2e5gd.jds4vrK2F5sIWqq3NIsGcT8.', '0000-00-00', 'b1977e273c4747.jpg'),
(7, 'alposgl', '$2y$10$rDRxeMi5zpWSucPczjm41uhvaFH0bRC3ObXCyK8WbiB2iiDBCQou6', '0000-00-00', NULL),
(8, 'sol2', '$2y$10$H.7Lfbwyawdkvt7OVfN22.e/AsGw8zLmoyxnmI0Jd5XzE6qOLC6.a', '24/03/2025 18:28:28', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chat`
--
ALTER TABLE `chat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
