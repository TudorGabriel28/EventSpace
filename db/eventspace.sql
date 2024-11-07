-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 07, 2024 at 02:11 PM
-- Server version: 5.7.24
-- PHP Version: 8.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eventspace`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(2, 'Art Exhibition'),
(1, 'Food Festival'),
(3, 'Music Festival');

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text,
  `coverPhoto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`id`, `name`, `description`, `coverPhoto`) VALUES
(1, 'Paris Food Festival', 'A celebration of food and local produce in the heart of Paris.', 'foodfest.jpg'),
(2, 'Art in the Park', 'An open-air art exhibit showcasing local artists.', 'artpark.jpg'),
(3, 'Music Fest Champs-Elysées', 'A music festival featuring popular and emerging bands.', 'musicfest.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `eventcategory`
--

CREATE TABLE `eventcategory` (
  `id` int(11) NOT NULL,
  `idEvent` int(11) DEFAULT NULL,
  `idCategory` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `eventcategory`
--

INSERT INTO `eventcategory` (`id`, `idEvent`, `idCategory`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 3);

-- --------------------------------------------------------

--
-- Table structure for table `faq`
--

CREATE TABLE `faq` (
  `id` int(11) NOT NULL,
  `question` text NOT NULL,
  `answer` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `faq`
--

INSERT INTO `faq` (`id`, `question`, `answer`) VALUES
(1, 'What are the timings for the Paris Food Festival?', 'The festival runs from 10 AM to 8 PM.'),
(2, 'Is parking available for Art in the Park?', 'Yes, there is parking near the event venue.');

-- --------------------------------------------------------

--
-- Table structure for table `forumcomment`
--

CREATE TABLE `forumcomment` (
  `id` int(11) NOT NULL,
  `content` text NOT NULL,
  `idDiscussion` int(11) DEFAULT NULL,
  `idUser` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `forumcomment`
--

INSERT INTO `forumcomment` (`id`, `content`, `idDiscussion`, `idUser`) VALUES
(1, 'The cheese stalls are amazing!', 1, 2),
(2, 'Bring a picnic blanket and enjoy the art!', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `forumdiscussion`
--

CREATE TABLE `forumdiscussion` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `idUser` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `forumdiscussion`
--

INSERT INTO `forumdiscussion` (`id`, `title`, `idUser`) VALUES
(1, 'Best Food at the Paris Food Festival?', 1),
(2, 'What to Bring to Art in the Park?', 3);

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE `location` (
  `id` int(11) NOT NULL,
  `postalCode` varchar(20) DEFAULT NULL,
  `city` varchar(50) NOT NULL,
  `address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`id`, `postalCode`, `city`, `address`) VALUES
(1, '75001', 'Paris', 'Place Vendôme'),
(2, '75007', 'Paris', 'Champs de Mars, Eiffel Tower'),
(3, '92100', 'Boulogne-Billancourt', 'Rue de Paris, Boulogne'),
(4, '75008', 'Paris', 'Champs-Elysées');

-- --------------------------------------------------------

--
-- Table structure for table `planning`
--

CREATE TABLE `planning` (
  `id` int(11) NOT NULL,
  `startDate` datetime NOT NULL,
  `endDate` datetime NOT NULL,
  `capacity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `idEvent` int(11) DEFAULT NULL,
  `idLocation` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `planning`
--

INSERT INTO `planning` (`id`, `startDate`, `endDate`, `capacity`, `price`, `idEvent`, `idLocation`) VALUES
(1, '2024-11-20 10:00:00', '2024-11-20 20:00:00', 200, '50.00', 1, 1),
(2, '2024-12-05 09:00:00', '2024-12-05 19:00:00', 150, '40.00', 2, 2),
(3, '2024-12-15 12:00:00', '2024-12-15 23:00:00', 500, '60.00', 3, 4);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `dateOfBirth` date DEFAULT NULL,
  `profilePicture` varchar(255) DEFAULT NULL,
  `accessRight` enum('admin','user') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `firstName`, `lastName`, `email`, `password`, `dateOfBirth`, `profilePicture`, `accessRight`) VALUES
(1, 'Alice', 'Dupont', 'alice.dupont@example.com', 'password123', '1992-05-14', 'profile1.jpg', 'user'),
(2, 'Alejandro', 'Martin', 'bob.martin@example.com', 'password456', '1985-08-20', 'profile2.jpg', 'admin'),
(3, 'Charlie', 'Renard', 'charlie.renard@example.com', 'password789', '1990-11-02', 'profile3.jpg', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `usereventreservation`
--

CREATE TABLE `usereventreservation` (
  `id` int(11) NOT NULL,
  `ticketQuantity` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ticketPrice` decimal(10,2) NOT NULL,
  `idUser` int(11) DEFAULT NULL,
  `idEvent` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `usereventreservation`
--

INSERT INTO `usereventreservation` (`id`, `ticketQuantity`, `timestamp`, `ticketPrice`, `idUser`, `idEvent`) VALUES
(1, 2, '2024-11-01 13:30:00', '50.00', 1, 1),
(2, 1, '2024-11-02 16:00:00', '30.00', 3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `usereventrole`
--

CREATE TABLE `usereventrole` (
  `id` int(11) NOT NULL,
  `function` varchar(50) NOT NULL,
  `idUser` int(11) DEFAULT NULL,
  `idEvent` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `usereventrole`
--

INSERT INTO `usereventrole` (`id`, `function`, `idUser`, `idEvent`) VALUES
(1, 'Organizer', 2, 1),
(2, 'Participant', 1, 1),
(3, 'Organizer', 2, 2),
(4, 'Participant', 3, 3);

-- --------------------------------------------------------

--
-- Table structure for table `usereventwaitlist`
--

CREATE TABLE `usereventwaitlist` (
  `id` int(11) NOT NULL,
  `ticketQuantity` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `idUser` int(11) DEFAULT NULL,
  `idEvent` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `usereventwaitlist`
--

INSERT INTO `usereventwaitlist` (`id`, `ticketQuantity`, `timestamp`, `idUser`, `idEvent`) VALUES
(1, 1, '2024-11-03 08:00:00', 3, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `eventcategory`
--
ALTER TABLE `eventcategory`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idEvent` (`idEvent`),
  ADD KEY `idCategory` (`idCategory`);

--
-- Indexes for table `faq`
--
ALTER TABLE `faq`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `forumcomment`
--
ALTER TABLE `forumcomment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idDiscussion` (`idDiscussion`),
  ADD KEY `idUser` (`idUser`);

--
-- Indexes for table `forumdiscussion`
--
ALTER TABLE `forumdiscussion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idUser` (`idUser`);

--
-- Indexes for table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `planning`
--
ALTER TABLE `planning`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idEvent` (`idEvent`),
  ADD KEY `idLocation` (`idLocation`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `usereventreservation`
--
ALTER TABLE `usereventreservation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idUser` (`idUser`),
  ADD KEY `idEvent` (`idEvent`);

--
-- Indexes for table `usereventrole`
--
ALTER TABLE `usereventrole`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idUser` (`idUser`),
  ADD KEY `idEvent` (`idEvent`);

--
-- Indexes for table `usereventwaitlist`
--
ALTER TABLE `usereventwaitlist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idUser` (`idUser`),
  ADD KEY `idEvent` (`idEvent`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `eventcategory`
--
ALTER TABLE `eventcategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `faq`
--
ALTER TABLE `faq`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `forumcomment`
--
ALTER TABLE `forumcomment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `forumdiscussion`
--
ALTER TABLE `forumdiscussion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `planning`
--
ALTER TABLE `planning`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `usereventreservation`
--
ALTER TABLE `usereventreservation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `usereventrole`
--
ALTER TABLE `usereventrole`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `usereventwaitlist`
--
ALTER TABLE `usereventwaitlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `eventcategory`
--
ALTER TABLE `eventcategory`
  ADD CONSTRAINT `eventcategory_ibfk_1` FOREIGN KEY (`idEvent`) REFERENCES `event` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `eventcategory_ibfk_2` FOREIGN KEY (`idCategory`) REFERENCES `category` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `forumcomment`
--
ALTER TABLE `forumcomment`
  ADD CONSTRAINT `forumcomment_ibfk_1` FOREIGN KEY (`idDiscussion`) REFERENCES `forumdiscussion` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `forumcomment_ibfk_2` FOREIGN KEY (`idUser`) REFERENCES `user` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `forumdiscussion`
--
ALTER TABLE `forumdiscussion`
  ADD CONSTRAINT `forumdiscussion_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `user` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `planning`
--
ALTER TABLE `planning`
  ADD CONSTRAINT `planning_ibfk_1` FOREIGN KEY (`idEvent`) REFERENCES `event` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `planning_ibfk_2` FOREIGN KEY (`idLocation`) REFERENCES `location` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `usereventreservation`
--
ALTER TABLE `usereventreservation`
  ADD CONSTRAINT `usereventreservation_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `usereventreservation_ibfk_2` FOREIGN KEY (`idEvent`) REFERENCES `event` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `usereventrole`
--
ALTER TABLE `usereventrole`
  ADD CONSTRAINT `usereventrole_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `usereventrole_ibfk_2` FOREIGN KEY (`idEvent`) REFERENCES `event` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `usereventwaitlist`
--
ALTER TABLE `usereventwaitlist`
  ADD CONSTRAINT `usereventwaitlist_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `usereventwaitlist_ibfk_2` FOREIGN KEY (`idEvent`) REFERENCES `event` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
