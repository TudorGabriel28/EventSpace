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
(1, 'Food'),
(2, 'Art'),
(3, 'Music'),
(4, 'Sport'),
(5, 'Technology'),
(6, 'Fashion');


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
(1, 'Paris Food Festival', 'A celebration of food and local produce in the heart of Paris.', '../assets/event1.jpg'),
(2, 'Art in the Park', 'An outdoor art exhibition featuring local artists.', '../assets/event2.jpg'),
(3, 'Music Festival', 'A day of live music performances in the city.', '../assets/event3.jpg'),
(4, 'Tech Conference', 'A conference showcasing the latest in technology.', '../assets/event4.jpg'),
(5, 'Fashion Show', 'A runway show featuring the latest fashion trends.', '../assets/event5.jpg'),
(6, 'Sports Gala', 'An event celebrating achievements in sports.', '../assets/event6.jpg'),
(7, 'Food Truck Rally', 'A gathering of the best food trucks in the city.', '../assets/event7.jpg'),
(8, 'Art Workshop', 'A hands-on workshop for aspiring artists.', '../assets/event8.jpg'),
(9, 'Jazz Night', 'An evening of live jazz music.', '../assets/event9.jpg'),
(10, 'Startup Pitch', 'A platform for startups to pitch their ideas.', '../assets/event10.jpg'),
(11, 'Photography Exhibition', 'An exhibition of stunning photographs.', '../assets/event11.jpg'),
(12, 'Book Fair', 'A fair showcasing a wide range of books.', '../assets/event12.jpg'),
(13, 'Film Festival', 'A festival screening independent films.', '../assets/event13.jpg'),
(14, 'Dance Competition', 'A competition featuring various dance styles.', '../assets/event14.jpg'),
(15, 'Science Fair', 'An event showcasing scientific projects.', '../assets/event15.jpg'),
(16, 'Wine Tasting', 'An event for wine enthusiasts to taste different wines.', '../assets/event16.jpg'),
(17, 'Charity Run', 'A run to raise funds for charity.', '../assets/event17.jpg'),
(18, 'Yoga Retreat', 'A retreat focusing on yoga and wellness.', '../assets/event18.jpg'),
(19, 'Gaming Convention', 'A convention for gaming enthusiasts.', '../assets/event19.jpg'),
(20, 'Culinary Class', 'A class teaching culinary skills.', '../assets/event20.jpg'),
(21, 'Theater Play', 'A live theater performance.', '../assets/event21.jpg'),
(22, 'Comedy Show', 'A show featuring stand-up comedians.', '../assets/event22.jpg'),
(23, 'Craft Fair', 'A fair showcasing handmade crafts.', '../assets/event23.jpg'),
(24, 'Pet Expo', 'An expo for pet lovers.', '../assets/event24.jpg'),
(25, 'Marathon', 'A long-distance running event.', '../assets/event25.jpg'),
(26, 'Music Workshop', 'A workshop for aspiring musicians.', '../assets/event26.jpg'),
(27, 'Art Auction', 'An auction of fine art pieces.', '../assets/event27.jpg'),
(28, 'Tech Meetup', 'A meetup for tech enthusiasts.', '../assets/event28.jpg'),
(29, 'Fashion Bazaar', 'A bazaar featuring fashion items.', '../assets/event29.jpg'),
(30, 'Food Expo', 'An expo showcasing different cuisines.', '../assets/event30.jpg');


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
(3, 3, 3),
(4, 4, 5),
(5, 5, 6),
(6, 6, 4),
(7, 7, 1),
(8, 8, 2),
(9, 9, 3),
(10, 10, 5),
(11, 11, 2),
(12, 12, 3),
(13, 13, 3),
(14, 14, 4),
(15, 15, 5),
(16, 16, 1),
(17, 17, 4),
(18, 18, 4),
(19, 19, 5),
(20, 20, 1),
(21, 21, 2),
(22, 22, 3),
(23, 23, 2),
(24, 24, 1),
(25, 25, 4),
(26, 26, 3),
(27, 27, 2),
(28, 28, 5),
(29, 29, 6),
(30, 30, 1);

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
(4, '75008', 'Paris', 'Champs-Elysées'),
(5, '75009', 'Paris', 'Rue de Châteaudun'),
(6, '75010', 'Paris', 'Canal Saint-Martin'),
(7, '75011', 'Paris', 'Place de la République'),
(8, '75012', 'Paris', 'Gare de Lyon'),
(9, '75013', 'Paris', 'Place d Italie'),
(10, '75014', 'Paris', 'Montparnasse'),
(11, '75015', 'Paris', 'Parc André Citroën'),
(12, '75016', 'Paris', 'Trocadéro'),
(13, '75017', 'Paris', 'Place de Clichy'),
(14, '75018', 'Paris', 'Montmartre'),
(15, '75019', 'Paris', 'Parc des Buttes-Chaumont'),
(16, '75020', 'Paris', 'Père Lachaise'),
(17, '75005', 'Paris', 'Panthéon'),
(18, '75006', 'Paris', 'Saint-Germain-des-Prés'),
(19, '75002', 'Paris', 'Rue Montorgueil'),
(20, '75003', 'Paris', 'Le Marais');


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
(3, '2024-12-15 12:00:00', '2024-12-15 23:00:00', 500, '60.00', 3, 4),
(4, '2024-12-20 10:00:00', '2024-12-20 20:00:00', 200, '50.00', 4, 3),
(5, '2024-12-25 09:00:00', '2024-12-25 19:00:00', 150, '40.00', 1, 5),
(6, '2024-12-30 12:00:00', '2024-12-30 23:00:00', 500, '60.00', 6, 6),
(7, '2025-01-05 10:00:00', '2025-01-05 20:00:00', 200, '50.00', 7, 7),
(8, '2025-01-10 09:00:00', '2025-01-10 19:00:00', 150, '40.00', 8, 8),
(9, '2025-01-15 12:00:00', '2025-01-15 23:00:00', 500, '60.00', 9, 9),
(10, '2025-01-20 10:00:00', '2025-01-20 20:00:00', 200, '50.00', 10, 10),
(11, '2025-01-25 09:00:00', '2025-01-25 19:00:00', 150, '40.00', 11, 11),
(12, '2025-01-30 12:00:00', '2025-01-30 23:00:00', 500, '60.00', 12, 12),
(13, '2025-02-05 10:00:00', '2025-02-05 20:00:00', 200, '50.00', 13, 13),
(14, '2025-02-10 09:00:00', '2025-02-10 19:00:00', 150, '40.00', 14, 14),
(15, '2025-02-15 12:00:00', '2025-02-15 23:00:00', 500, '60.00', 15, 15),
(16, '2025-02-20 10:00:00', '2025-02-20 20:00:00', 200, '50.00', 16, 16),
(17, '2025-02-25 09:00:00', '2025-02-25 19:00:00', 150, '40.00', 17, 17),
(18, '2025-03-01 12:00:00', '2025-03-01 23:00:00', 500, '60.00', 18, 18),
(19, '2025-03-05 10:00:00', '2025-03-05 20:00:00', 200, '50.00', 19, 19),
(20, '2025-03-10 09:00:00', '2025-03-10 19:00:00', 150, '40.00', 20, 20),
(21, '2025-03-15 12:00:00', '2025-03-15 23:00:00', 500, '60.00', 21, 3),
(22, '2025-03-20 10:00:00', '2025-03-20 20:00:00', 200, '50.00', 22, 13),
(23, '2025-03-25 09:00:00', '2025-03-25 19:00:00', 150, '40.00', 23, 14),
(24, '2025-03-30 12:00:00', '2025-03-30 23:00:00', 500, '60.00', 24, 16),
(25, '2025-04-05 10:00:00', '2025-04-05 20:00:00', 200, '50.00', 25, 4),
(26, '2025-04-10 09:00:00', '2025-04-10 19:00:00', 150, '40.00', 26, 18),
(27, '2025-04-15 12:00:00', '2025-04-15 23:00:00', 500, '60.00', 27, 12),
(28, '2025-04-20 10:00:00', '2025-04-20 20:00:00', 200, '50.00', 28, 10),
(29, '2025-04-25 09:00:00', '2025-04-25 19:00:00', 150, '40.00', 29, 9),
(30, '2025-04-30 12:00:00', '2025-04-30 23:00:00', 500, '60.00', 30, 1),
(31, '2025-05-05 10:00:00', '2025-05-05 20:00:00', 200, '50.00', 1, 2),
(32, '2025-05-10 09:00:00', '2025-05-10 19:00:00', 150, '40.00', 2, 3),
(33, '2025-05-15 12:00:00', '2025-05-15 23:00:00', 500, '60.00', 3, 4),
(34, '2025-05-20 10:00:00', '2025-05-20 20:00:00', 200, '50.00', 4, 5),
(35, '2025-05-25 09:00:00', '2025-05-25 19:00:00', 150, '40.00', 5, 6),
(36, '2025-05-30 12:00:00', '2025-05-30 23:00:00', 500, '60.00', 6, 7),
(37, '2025-06-05 10:00:00', '2025-06-05 20:00:00', 200, '50.00', 7, 8),
(38, '2025-06-10 09:00:00', '2025-06-10 19:00:00', 150, '40.00', 8, 9),
(39, '2025-06-15 12:00:00', '2025-06-15 23:00:00', 500, '60.00', 9, 10),
(40, '2025-06-20 10:00:00', '2025-06-20 20:00:00', 200, '50.00', 10, 11),
(41, '2025-06-25 09:00:00', '2025-06-25 19:00:00', 150, '40.00', 11, 12);



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
(3, 'Charlie', 'Renard', 'charlie.renard@example.com', 'password789', '1990-11-02', 'profile3.jpg', 'user'),
(4, 'David', 'Smith', 'david.smith@example.com', 'password101', '1988-03-15', 'profile4.jpg', 'user'),
(5, 'Emma', 'Johnson', 'emma.johnson@example.com', 'password102', '1995-07-22', 'profile5.jpg', 'user'),
(6, 'Lucas', 'Brown', 'lucas.brown@example.com', 'password103', '1993-12-05', 'profile6.jpg', 'user'),
(7, 'Olivia', 'Jones', 'olivia.jones@example.com', 'password104', '1991-09-18', 'profile7.jpg', 'user'),
(8, 'Liam', 'Garcia', 'liam.garcia@example.com', 'password105', '1987-04-10', 'profile8.jpg', 'user'),
(9, 'Sophia', 'Martinez', 'sophia.martinez@example.com', 'password106', '1994-06-30', 'profile9.jpg', 'user'),
(10, 'Mason', 'Rodriguez', 'mason.rodriguez@example.com', 'password107', '1992-11-25', 'profile10.jpg', 'user'),
(11, 'Isabella', 'Hernandez', 'isabella.hernandez@example.com', 'password108', '1990-02-14', 'profile11.jpg', 'user'),
(12, 'Ethan', 'Lopez', 'ethan.lopez@example.com', 'password109', '1989-08-08', 'profile12.jpg', 'user'),
(13, 'Ava', 'Gonzalez', 'ava.gonzalez@example.com', 'password110', '1996-01-20', 'profile13.jpg', 'user'),
(14, 'James', 'Wilson', 'james.wilson@example.com', 'password111', '1986-05-12', 'profile14.jpg', 'user'),
(15, 'Mia', 'Anderson', 'mia.anderson@example.com', 'password112', '1991-10-03', 'profile15.jpg', 'user'),
(16, 'Alexander', 'Thomas', 'alexander.thomas@example.com', 'password113', '1993-03-27', 'profile16.jpg', 'user'),
(17, 'Charlotte', 'Taylor', 'charlotte.taylor@example.com', 'password114', '1994-12-17', 'profile17.jpg', 'user'),
(18, 'Benjamin', 'Moore', 'benjamin.moore@example.com', 'password115', '1988-07-09', 'profile18.jpg', 'user'),
(19, 'Amelia', 'Jackson', 'amelia.jackson@example.com', 'password116', '1992-11-11', 'profile19.jpg', 'user'),
(20, 'Henry', 'Martin', 'henry.martin@example.com', 'password117', '1990-04-25', 'profile20.jpg', 'user'),
(21, 'Evelyn', 'Lee', 'evelyn.lee@example.com', 'password118', '1989-09-19', 'profile21.jpg', 'user'),
(22, 'Sebastian', 'Perez', 'sebastian.perez@example.com', 'password119', '1995-06-15', 'profile22.jpg', 'user'),
(23, 'Harper', 'White', 'harper.white@example.com', 'password120', '1991-01-29', 'profile23.jpg', 'user'),
(24, 'Daniel', 'Harris', 'daniel.harris@example.com', 'password121', '1987-10-21', 'profile24.jpg', 'user'),
(25, 'Ella', 'Sanchez', 'ella.sanchez@example.com', 'password122', '1993-05-06', 'profile25.jpg', 'user'),
(26, 'Matthew', 'Clark', 'matthew.clark@example.com', 'password123', '1994-08-13', 'profile26.jpg', 'user'),
(27, 'Scarlett', 'Ramirez', 'scarlett.ramirez@example.com', 'password124', '1992-02-28', 'profile27.jpg', 'user'),
(28, 'Joseph', 'Lewis', 'joseph.lewis@example.com', 'password125', '1988-12-22', 'profile28.jpg', 'user'),
(29, 'Grace', 'Walker', 'grace.walker@example.com', 'password126', '1990-07-07', 'profile29.jpg', 'user'),
(30, 'Samuel', 'Young', 'samuel.young@example.com', 'password127', '1989-03-10', 'profile30.jpg', 'user');


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
