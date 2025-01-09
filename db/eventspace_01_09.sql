-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 09-01-2025 a las 14:56:36
-- Versión del servidor: 5.7.24
-- Versión de PHP: 8.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `eventspace`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `photo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `category`
--

INSERT INTO `category` (`id`, `name`, `photo`) VALUES
(1, 'Food', '../assets/categories/food.png'),
(2, 'Art', '../assets/categories/art.png'),
(3, 'Music', '../assets/categories/music.png'),
(4, 'Sport', '../assets/categories/sport.png'),
(5, 'Technology', '../assets/categories/technology.png'),
(6, 'Fashion', '../assets/categories/fashion.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `event`
--

CREATE TABLE `event` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text,
  `coverPhoto` varchar(255) DEFAULT NULL,
  `creationTimestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `isApproved` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `event`
--

INSERT INTO `event` (`id`, `name`, `description`, `coverPhoto`, `creationTimestamp`, `isApproved`) VALUES
(1, 'Paris Food Festival', 'A celebration of food and local produce in the heart of Paris.', '../assets/events/event1.jpg', '2024-11-27 15:51:16', 1),
(2, 'Art in the Park', 'An outdoor art exhibition featuring local artists.', '../assets/events/event2.jpg', '2024-11-27 15:51:16', 1),
(3, 'Music Festival', 'A day of live music performances in the city.', '../assets/events/event3.jpg', '2024-11-27 15:51:16', 1),
(4, 'Tech Conference', 'A conference showcasing the latest in technology.', '../assets/events/event4.jpg', '2024-11-27 15:51:16', 1),
(5, 'Fashion Show', 'A runway show featuring the latest fashion trends.', '../assets/events/event5.jpg', '2024-11-27 15:51:16', 1),
(6, 'Sports Gala', 'An event celebrating achievements in sports.', '../assets/events/event6.jpg', '2024-11-27 15:51:16', 1),
(7, 'Food Truck Rally', 'A gathering of the best food trucks in the city.', '../assets/events/event.jpg', '2024-11-27 15:51:16', 0),
(8, 'Art Workshop', 'A hands-on workshop for aspiring artists.', '../assets/events/event.jpg', '2024-11-27 15:51:16', 0),
(9, 'Jazz Night', 'An evening of live jazz music.', '../assets/events/event.jpg', '2024-11-27 15:51:16', 0),
(10, 'Startup Pitch', 'A platform for startups to pitch their ideas.', '../assets/events/event.jpg', '2024-11-27 15:51:16', 0),
(11, 'Photography Exhibition', 'An exhibition of stunning photographs.', '../assets/events/event.jpg', '2024-11-27 15:51:16', 0),
(12, 'Book Fair', 'A fair showcasing a wide range of books.', '../assets/events/event.jpg', '2024-11-27 15:51:16', 0),
(13, 'Film Festival', 'A festival screening independent films.', '../assets/events/event.jpg', '2024-11-27 15:51:16', 0),
(14, 'Dance Competition', 'A competition featuring various dance styles.', '../assets/events/event.jpg', '2024-11-27 15:51:16', 0),
(15, 'Science Fair', 'An event showcasing scientific projects.', '../assets/events/event.jpg', '2024-11-27 15:51:16', 0),
(16, 'Wine Tasting', 'An event for wine enthusiasts to taste different wines.', '../assets/events/event.jpg', '2024-11-27 15:51:16', 0),
(17, 'Charity Run', 'A run to raise funds for charity.', '../assets/events/event.jpg', '2024-11-27 15:51:16', 0),
(18, 'Yoga Retreat', 'A retreat focusing on yoga and wellness.', '../assets/events/event.jpg', '2024-11-27 15:51:16', 0),
(19, 'Gaming Convention', 'A convention for gaming enthusiasts.', '../assets/events/event.jpg', '2024-11-27 15:51:16', 0),
(20, 'Culinary Class', 'A class teaching culinary skills.', '../assets/events/event.jpg', '2024-11-27 15:51:16', 0),
(21, 'Theater Play', 'A live theater performance.', '../assets/events/event.jpg', '2024-11-27 15:51:16', 0),
(22, 'Comedy Show', 'A show featuring stand-up comedians.', '../assets/events/event.jpg', '2024-11-27 15:51:16', 0),
(23, 'Craft Fair', 'A fair showcasing handmade crafts.', '../assets/events/event.jpg', '2024-11-27 15:51:16', 0),
(24, 'Pet Expo', 'An expo for pet lovers.', '../assets/events/event.jpg', '2024-11-27 15:51:16', 0),
(25, 'Marathon', 'A long-distance running event.', '../assets/events/event.jpg', '2024-11-27 15:51:16', 0),
(26, 'Music Workshop', 'A workshop for aspiring musicians.', '../assets/events/event.jpg', '2024-11-27 15:51:16', 0),
(27, 'Art Auction', 'An auction of fine art pieces.', '../assets/events/event.jpg', '2024-11-27 15:51:16', 0),
(28, 'Tech Meetup', 'A meetup for tech enthusiasts.', '../assets/events/event.jpg', '2024-11-27 15:51:16', 0),
(29, 'Fashion Bazaar', 'A bazaar featuring fashion items.', '../assets/events/event.jpg', '2024-11-27 15:51:16', 0),
(30, 'Food Expo', 'An expo showcasing different cuisines.', '../assets/events/event.jpg', '2024-11-27 15:51:16', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eventcategory`
--

CREATE TABLE `eventcategory` (
  `id` int(11) NOT NULL,
  `idEvent` int(11) DEFAULT NULL,
  `idCategory` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `eventcategory`
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
-- Estructura de tabla para la tabla `faq`
--

CREATE TABLE `faq` (
  `id` int(11) NOT NULL,
  `question` text NOT NULL,
  `answer` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `faq`
--

INSERT INTO `faq` (`id`, `question`, `answer`) VALUES
(3, 'How do I register for an event?', 'To register for an event, simply visit the event page, select the event you’re interested in, and click on the Register button. You may need to create an account or log in to complete your registration.'),
(4, 'Can I host my own event?', 'Yes! Eventspace allows users to create and host their own events. You can choose the category, set the date, and provide all the event details. Once your event is created, others can register and participate.'),
(5, 'How can I find events related to my interests?', 'You can browse events by categories such as Music, Technology, Sports, and Art. Additionally, you can use the search function to find events based on location, date, or keywords.'),
(6, 'Can I cancel my registration for an event?', 'Yes, you can cancel your registration. Simply go to your profile or the event page, and you ll find an option to cancel your registration. Please check if the event has any specific cancellation policies.'),
(7, 'What should I do if I want to modify my event details after posting?', 'If you need to update the event details, you can edit the event by logging into your Eventspace account. Changes will be reflected on the event page once updated.'),
(8, 'What happens if an event I registered for gets canceled?', 'If an event is canceled, you will be notified via email or through your account. Depending on the event, you may be offered a refund if there was a registration fee.'),
(9, 'Can I create an event with multiple categories?', 'Yes, you can select multiple categories for your event if it fits within different interests, such as combining Music and Technology for a music tech event.'),
(10, 'How do I contact event hosts or organizers?', 'You can contact event hosts directly through the event page by sending them a message or using the provided contact information.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `forumcomment`
--

CREATE TABLE `forumcomment` (
  `id` int(11) NOT NULL,
  `content` text NOT NULL,
  `idDiscussion` int(11) DEFAULT NULL,
  `idUser` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `forumcomment`
--

INSERT INTO `forumcomment` (`id`, `content`, `idDiscussion`, `idUser`) VALUES
(1, 'The cheese stalls are amazing!', 1, 2),
(2, 'Bring a picnic blanket and enjoy the art!', 1, 3),
(3, 'I have the same question too!', 1, 6),
(6, 'You should try the spanish food stand!', 1, 1),
(8, 'The hamburguers are top', 1, 1),
(9, 'Yes!!! I love tacos and they are amazing there', 5, 1),
(10, 'Yes!!! I love tacos and they are amazing there', 5, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `forumdiscussion`
--

CREATE TABLE `forumdiscussion` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `question` text NOT NULL,
  `idUser` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `forumdiscussion`
--

INSERT INTO `forumdiscussion` (`id`, `title`, `question`, `idUser`) VALUES
(1, 'Best Food at the Paris Food Festival?', 'I wanted to know what is the best stands that I can visit this weekend in the festival?', 1),
(2, 'What to Bring to Art in the Park?', '', 3),
(3, 'Football event in Issy-les-Molineaux', 'What types of shoes are you going to bring to the event?', 8),
(4, 'Company for the Paris Food Festival', 'Is there someone looking forward to going to the Paris Food Festival? I am new in the city and it would be great to meet new people there.', 8),
(5, 'Mexican food at the Paris Food Festival?', 'Is there anyone that has gone to the PFF and has seen a mexican food stand?', 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `location`
--

CREATE TABLE `location` (
  `id` int(11) NOT NULL,
  `postalCode` varchar(20) DEFAULT NULL,
  `city` varchar(50) NOT NULL,
  `address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `location`
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
-- Estructura de tabla para la tabla `planning`
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
-- Volcado de datos para la tabla `planning`
--

INSERT INTO `planning` (`id`, `startDate`, `endDate`, `capacity`, `price`, `idEvent`, `idLocation`) VALUES
(1, '2024-11-20 10:00:00', '2024-11-20 20:00:00', 2, '50.00', 1, 1),
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
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `dateOfBirth` date DEFAULT NULL,
  `profilePicture` varchar(255) DEFAULT '../assets/users/generic-user.png',
  `accessRight` enum('admin','user') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `firstName`, `lastName`, `email`, `password`, `dateOfBirth`, `profilePicture`, `accessRight`) VALUES
(1, 'Alice', 'Dupont', 'alice.dupont@example.com', 'password123', '1992-05-14', '../assets/users/generic-user.png', 'user'),
(2, 'Alejandro', 'Martin', 'bob.martin@example.com', 'password456', '1985-08-20', '../assets/users/generic-user.png', 'admin'),
(3, 'Charlie', 'Renard', 'charlie.renard@example.com', 'password789', '1990-11-02', '../assets/users/generic-user.png', 'user'),
(4, 'David', 'Smith', 'david.smith@example.com', 'password101', '1988-03-15', '../assets/users/generic-user.png', 'user'),
(5, 'Emma', 'Johnson', 'emma.johnson@example.com', 'password102', '1995-07-22', '../assets/users/generic-user.png', 'user'),
(6, 'Lucas', 'Brown', 'lucas.brown@example.com', 'password103', '1993-12-05', '../assets/users/generic-user.png', 'user'),
(7, 'Olivia', 'Jones', 'olivia.jones@example.com', 'password104', '1991-09-18', '../assets/users/generic-user.png', 'user'),
(8, 'Liam', 'Garcia', 'liam.garcia@example.com', 'password105', '1987-04-10', '../assets/users/generic-user.png', 'user'),
(9, 'Sophia', 'Martinez', 'sophia.martinez@example.com', 'password106', '1994-06-30', '../assets/users/generic-user.png', 'user'),
(10, 'Mason', 'Rodriguez', 'mason.rodriguez@example.com', 'password107', '1992-11-25', '../assets/users/generic-user.png', 'user'),
(11, 'Isabella', 'Hernandez', 'isabella.hernandez@example.com', 'password108', '1990-02-14', '../assets/users/generic-user.png', 'user'),
(12, 'Ethan', 'Lopez', 'ethan.lopez@example.com', 'password109', '1989-08-08', '../assets/users/generic-user.png', 'user'),
(13, 'Ava', 'Gonzalez', 'ava.gonzalez@example.com', 'password110', '1996-01-20', '../assets/users/generic-user.png', 'user'),
(14, 'James', 'Wilson', 'james.wilson@example.com', 'password111', '1986-05-12', '../assets/users/generic-user.png', 'user'),
(15, 'Mia', 'Anderson', 'mia.anderson@example.com', 'password112', '1991-10-03', '../assets/users/generic-user.png', 'user'),
(16, 'Alexander', 'Thomas', 'alexander.thomas@example.com', 'password113', '1993-03-27', '../assets/users/generic-user.png', 'user'),
(17, 'Charlotte', 'Taylor', 'charlotte.taylor@example.com', 'password114', '1994-12-17', '../assets/users/generic-user.png', 'user'),
(18, 'Benjamin', 'Moore', 'benjamin.moore@example.com', 'password115', '1988-07-09', '../assets/users/generic-user.png', 'user'),
(19, 'Amelia', 'Jackson', 'amelia.jackson@example.com', 'password116', '1992-11-11', '../assets/users/generic-user.png', 'user'),
(20, 'Henry', 'Martin', 'henry.martin@example.com', 'password117', '1990-04-25', '../assets/users/generic-user.png', 'user'),
(21, 'Evelyn', 'Lee', 'evelyn.lee@example.com', 'password118', '1989-09-19', '../assets/users/generic-user.png', 'user'),
(22, 'Sebastian', 'Perez', 'sebastian.perez@example.com', 'password119', '1995-06-15', '../assets/users/generic-user.png', 'user'),
(23, 'Harper', 'White', 'harper.white@example.com', 'password120', '1991-01-29', '../assets/users/generic-user.png', 'user'),
(24, 'Daniel', 'Harris', 'daniel.harris@example.com', 'password121', '1987-10-21', '../assets/users/generic-user.png', 'user'),
(25, 'Ella', 'Sanchez', 'ella.sanchez@example.com', 'password122', '1993-05-06', '../assets/users/generic-user.png', 'user'),
(26, 'Matthew', 'Clark', 'matthew.clark@example.com', 'password123', '1994-08-13', '../assets/users/generic-user.png', 'user'),
(27, 'Scarlett', 'Ramirez', 'scarlett.ramirez@example.com', 'password124', '1992-02-28', '../assets/users/generic-user.png', 'user'),
(28, 'Joseph', 'Lewis', 'joseph.lewis@example.com', 'password125', '1988-12-22', '../assets/users/generic-user.png', 'user'),
(29, 'Grace', 'Walker', 'grace.walker@example.com', 'password126', '1990-07-07', '../assets/users/generic-user.png', 'user'),
(30, 'Samuel', 'Young', 'samuel.young@example.com', 'password127', '1989-03-10', '../assets/users/generic-user.png', 'user'),
(31, 'Luke', 'Littler', 'lukelitller@example.com', '1234', '2003-01-31', '../assets/users/generic-user.png', 'user'),
(32, 'Michael', 'Smith', 'michaelsmith@example.com', '123', '2000-01-20', '../assets/users/generic-user.png', 'user'),
(33, 'Michael', 'Van Gerwen', 'michaelvangerwen@example.com', '098', '1999-04-20', '../assets/users/generic-user.png', 'user'),
(34, 'Laura', 'Espinosa Alfonso', 'laura@example.com', '1234', '2003-09-05', '../assets/users/generic-user.png', 'user'),
(35, 'Alex', 'Smith', 'alexsmith@example.com', '123', '2000-11-11', '../assets/users/generic-user.png', 'user'),
(36, 'Kamil', 'Sikora', 'kamilsikora@example.com', '123', '2000-11-11', '../assets/users/generic-user.png', 'user'),
(37, 'Dan', 'Gabi', 'clewmcl@jkaka.com', '$2y$10$TRojK4R9CBbIdxEARjQaGOFDvFyanhZe6c7rdGVdecAljzyyIZfu6', '2000-11-11', '../assets/users/generic-user.png', 'user'),
(38, 'te', 'test', 'test@example.com', '$2y$10$Fch5B/oOL5YyvM9DOJAP5.uLuLAoW58b6mOXgl1gb5yiJvRxsR.Y6', '2024-12-27', '../assets/users/generic-user.png', 'user'),
(39, 'Alejandro', 'García Menor', 'alejandrogarciamenor@gmail.com', '$2y$10$FfkqWwceNsqvzlFNZTpTluZCTZkNmQ2GgiD1wXNrRQaxKNJoggTv.', '2003-11-28', '../assets/users/generic-user.png', 'user');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usereventreservation`
--

CREATE TABLE `usereventreservation` (
  `id` int(11) NOT NULL,
  `ticketQuantity` int(11) NOT NULL,
  `timestamp` datetime DEFAULT CURRENT_TIMESTAMP,
  `idPlanning` int(11) NOT NULL,
  `idUser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usereventreservation`
--

INSERT INTO `usereventreservation` (`id`, `ticketQuantity`, `timestamp`, `idPlanning`, `idUser`) VALUES
(6, 1, '2024-12-03 18:57:53', 1, 1),
(9, 2, '2024-12-03 19:03:55', 1, 1),
(13, 2, '2024-12-04 17:24:19', 1, 1),
(14, 3, '2024-12-04 17:37:37', 1, 5),
(17, 4, '2024-12-04 17:41:01', 1, 1),
(18, 4, '2024-12-04 17:41:26', 1, 1),
(20, 4, '2024-12-04 17:41:57', 1, 1),
(22, 1, '2024-12-05 11:35:42', 1, 1),
(23, 1, '2024-12-05 11:46:16', 1, 1),
(24, 3, '2024-12-05 12:05:09', 1, 1),
(25, 3, '2024-12-05 12:07:43', 1, 1),
(27, 1, '2024-12-05 12:08:45', 1, 5),
(28, 1, '2024-12-05 12:10:20', 5, 1),
(29, 2, '2024-12-05 12:10:27', 31, 1),
(30, 2, '2024-12-05 12:40:42', 31, 1),
(31, 1, '2024-12-05 12:40:51', 5, 1),
(32, 2, '2024-12-05 14:57:20', 31, 1),
(33, 1, '2024-12-05 15:05:10', 1, 1),
(34, 1, '2024-12-05 15:05:15', 1, 1),
(35, 1, '2024-12-05 15:05:23', 5, 1),
(36, 2, '2024-12-05 15:05:36', 1, 1),
(37, 1, '2024-12-05 16:01:51', 5, 1),
(38, 1, '2024-12-05 16:04:35', 5, 1),
(40, 2, '2024-12-17 17:50:16', 31, 38),
(41, 1, '2024-12-17 17:50:26', 31, 38),
(42, 2, '2024-12-17 17:51:12', 31, 38),
(43, 1, '2024-12-17 17:53:20', 32, 38),
(44, 2, '2024-12-17 17:57:50', 33, 38),
(45, 1, '2024-12-17 19:55:14', 5, 38),
(46, 1, '2024-12-17 19:55:20', 5, 38),
(47, 1, '2024-12-17 19:57:08', 32, 38),
(48, 1, '2024-12-17 19:58:43', 32, 38),
(49, 1, '2024-12-17 19:58:52', 31, 38),
(50, 1, '2024-12-17 20:00:21', 33, 38),
(51, 1, '2024-12-17 20:03:07', 34, 38),
(52, 1, '2024-12-17 20:03:36', 31, 38),
(53, 2, '2024-12-17 20:06:43', 31, 38),
(54, 1, '2024-12-17 20:11:53', 31, 38),
(55, 1, '2024-12-17 20:16:43', 31, 38),
(56, 1, '2024-12-17 20:19:15', 31, 38),
(57, 1, '2024-12-17 21:14:38', 31, 38),
(58, 1, '2024-12-17 21:18:10', 31, 38),
(59, 1, '2024-12-17 21:18:24', 32, 38),
(60, 1, '2024-12-17 21:18:42', 39, 38),
(61, 3, '2024-12-17 21:19:29', 32, 38),
(62, 1, '2024-12-17 21:19:55', 29, 38),
(63, 1, '2024-12-17 21:20:48', 32, 38),
(64, 1, '2024-12-17 21:30:46', 29, 38),
(65, 2, '2024-12-17 21:30:51', 29, 38),
(66, 1, '2024-12-17 21:30:57', 29, 38),
(69, 1, '2024-12-18 13:46:39', 3, 38),
(70, 1, '2024-12-18 13:46:48', 3, 38),
(71, 1, '2024-12-18 13:47:09', 2, 38),
(72, 1, '2024-12-18 13:47:13', 2, 38),
(73, 1, '2024-12-18 13:47:17', 2, 38),
(74, 1, '2024-12-18 13:47:21', 2, 38),
(75, 1, '2025-01-09 14:52:02', 31, 39),
(76, 1, '2025-01-09 15:09:47', 31, 39),
(77, 1, '2025-01-09 15:11:24', 31, 39),
(78, 1, '2025-01-09 15:11:53', 31, 39),
(79, 1, '2025-01-09 15:12:00', 31, 39),
(80, 1, '2025-01-09 15:12:34', 31, 39),
(81, 1, '2025-01-09 15:15:55', 31, 39),
(82, 1, '2025-01-09 15:16:03', 5, 39),
(83, 1, '2025-01-09 15:17:58', 32, 39),
(84, 1, '2025-01-09 15:38:51', 31, 39);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usereventrole`
--

CREATE TABLE `usereventrole` (
  `id` int(11) NOT NULL,
  `function` varchar(50) NOT NULL,
  `idUser` int(11) DEFAULT NULL,
  `idEvent` int(11) DEFAULT NULL,
  `idPlanning` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usereventrole`
--

INSERT INTO `usereventrole` (`id`, `function`, `idUser`, `idEvent`, `idPlanning`) VALUES
(1, 'Organizer', 2, 1, NULL),
(2, 'Participant', 1, 1, NULL),
(3, 'Organizer', 2, 2, NULL),
(4, 'Participant', 3, 3, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usereventwaitlist`
--

CREATE TABLE `usereventwaitlist` (
  `id` int(11) NOT NULL,
  `ticketQuantity` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `idUser` int(11) DEFAULT NULL,
  `idPlanning` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usereventwaitlist`
--

INSERT INTO `usereventwaitlist` (`id`, `ticketQuantity`, `timestamp`, `idUser`, `idPlanning`) VALUES
(1, 1, '2024-11-03 08:00:00', 3, NULL),
(2, 1, '2024-12-05 14:49:39', 1, 1),
(3, 1, '2024-12-05 14:59:52', 1, 1),
(4, 1, '2024-12-05 15:00:10', 1, 1),
(5, 1, '2024-12-05 15:00:29', 1, 1),
(6, 2, '2024-12-05 15:17:37', 1, 1),
(7, 3, '2024-12-05 15:28:20', 1, 1),
(8, 1, '2024-12-05 15:45:58', 1, 1),
(9, 1, '2024-12-17 16:42:24', 38, 1),
(11, 1, '2024-12-17 18:59:10', 38, 1),
(12, 1, '2024-12-17 19:03:25', 38, 1),
(13, 1, '2024-12-17 19:11:36', 38, 1),
(14, 1, '2024-12-17 19:16:36', 38, 1),
(15, 1, '2024-12-17 19:19:09', 38, 1),
(16, 1, '2024-12-17 20:15:58', 38, 1),
(17, 1, '2024-12-17 20:18:02', 38, 1),
(18, 1, '2024-12-18 12:47:02', 38, 1),
(19, 1, '2024-12-19 14:55:33', 38, 10),
(20, 1, '2024-12-22 17:47:49', 38, 1),
(21, 1, '2025-01-09 13:49:14', 39, 1),
(22, 1, '2025-01-09 14:18:23', 39, 1),
(23, 1, '2025-01-09 14:19:46', 39, 1),
(24, 1, '2025-01-09 14:20:37', 39, 1),
(25, 1, '2025-01-09 14:39:07', 39, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indices de la tabla `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `eventcategory`
--
ALTER TABLE `eventcategory`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idEvent` (`idEvent`),
  ADD KEY `idCategory` (`idCategory`);

--
-- Indices de la tabla `faq`
--
ALTER TABLE `faq`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `forumcomment`
--
ALTER TABLE `forumcomment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idDiscussion` (`idDiscussion`),
  ADD KEY `idUser` (`idUser`);

--
-- Indices de la tabla `forumdiscussion`
--
ALTER TABLE `forumdiscussion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idUser` (`idUser`);

--
-- Indices de la tabla `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `planning`
--
ALTER TABLE `planning`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idEvent` (`idEvent`),
  ADD KEY `idLocation` (`idLocation`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `usereventreservation`
--
ALTER TABLE `usereventreservation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idPlanning` (`idPlanning`),
  ADD KEY `idUser` (`idUser`);

--
-- Indices de la tabla `usereventrole`
--
ALTER TABLE `usereventrole`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idUser` (`idUser`),
  ADD KEY `idEvent` (`idEvent`),
  ADD KEY `fk_UserEventRole_Planning` (`idPlanning`);

--
-- Indices de la tabla `usereventwaitlist`
--
ALTER TABLE `usereventwaitlist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idUser` (`idUser`),
  ADD KEY `fk_UserEventWaitlist_Planning` (`idPlanning`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `event`
--
ALTER TABLE `event`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `eventcategory`
--
ALTER TABLE `eventcategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `faq`
--
ALTER TABLE `faq`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `forumcomment`
--
ALTER TABLE `forumcomment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `forumdiscussion`
--
ALTER TABLE `forumdiscussion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `location`
--
ALTER TABLE `location`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `planning`
--
ALTER TABLE `planning`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de la tabla `usereventreservation`
--
ALTER TABLE `usereventreservation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT de la tabla `usereventrole`
--
ALTER TABLE `usereventrole`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usereventwaitlist`
--
ALTER TABLE `usereventwaitlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `eventcategory`
--
ALTER TABLE `eventcategory`
  ADD CONSTRAINT `eventcategory_ibfk_1` FOREIGN KEY (`idEvent`) REFERENCES `event` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `eventcategory_ibfk_2` FOREIGN KEY (`idCategory`) REFERENCES `category` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `forumcomment`
--
ALTER TABLE `forumcomment`
  ADD CONSTRAINT `forumcomment_ibfk_1` FOREIGN KEY (`idDiscussion`) REFERENCES `forumdiscussion` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `forumcomment_ibfk_2` FOREIGN KEY (`idUser`) REFERENCES `user` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `forumdiscussion`
--
ALTER TABLE `forumdiscussion`
  ADD CONSTRAINT `forumdiscussion_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `user` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `planning`
--
ALTER TABLE `planning`
  ADD CONSTRAINT `planning_ibfk_1` FOREIGN KEY (`idEvent`) REFERENCES `event` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `planning_ibfk_2` FOREIGN KEY (`idLocation`) REFERENCES `location` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `usereventreservation`
--
ALTER TABLE `usereventreservation`
  ADD CONSTRAINT `usereventreservation_ibfk_1` FOREIGN KEY (`idPlanning`) REFERENCES `planning` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `usereventreservation_ibfk_2` FOREIGN KEY (`idUser`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usereventrole`
--
ALTER TABLE `usereventrole`
  ADD CONSTRAINT `fk_UserEventRole_Planning` FOREIGN KEY (`idPlanning`) REFERENCES `planning` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `usereventrole_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `usereventrole_ibfk_2` FOREIGN KEY (`idEvent`) REFERENCES `event` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `usereventwaitlist`
--
ALTER TABLE `usereventwaitlist`
  ADD CONSTRAINT `fk_UserEventWaitlist_Planning` FOREIGN KEY (`idPlanning`) REFERENCES `planning` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `usereventwaitlist_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `user` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
