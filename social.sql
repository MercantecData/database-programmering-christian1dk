-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Vært: 127.0.0.1
-- Genereringstid: 08. 12 2017 kl. 10:14:52
-- Serverversion: 5.7.14
-- PHP-version: 7.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `social`
--

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `comments`
--

CREATE TABLE `comments` (
  `ID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `StatusID` int(11) NOT NULL,
  `Content` text NOT NULL,
  `Created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `comments`
--

INSERT INTO `comments` (`ID`, `UserID`, `StatusID`, `Content`, `Created`, `Modified`) VALUES
(1, 1, 11, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus dapibus ipsum nec nulla pharetra, sed condimentum dolor rutrum. Vestibulum facilisis.', '2017-12-06 14:15:18', '2017-12-06 22:12:27'),
(2, 1, 11, 'Cras laoreet mi in dignissim posuere. Vestibulum ante ipsum primis in faucibus orci...', '2017-12-06 14:21:23', '2017-12-07 00:06:34'),
(3, 1, 12, 'Work', '2017-12-06 20:14:49', '2017-12-06 20:14:49'),
(5, 3, 11, 'Work', '2017-12-06 20:14:49', '2017-12-07 00:04:42'),
(6, 8, 12, 'Work', '2017-12-06 20:14:49', '2017-12-06 20:14:49'),
(7, 1, 12, 'Hej', '2017-12-08 10:49:54', '2017-12-08 10:49:54'),
(8, 1, 12, 'Comment work', '2017-12-08 10:53:02', '2017-12-08 10:53:02'),
(10, 8, 16, 'Hej', '2017-12-08 11:03:52', '2017-12-08 11:04:07'),
(11, 9, 16, 'Hej', '2017-12-08 11:03:52', '2017-12-08 11:04:07');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `events`
--

CREATE TABLE `events` (
  `ID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `Start_Date` datetime NOT NULL,
  `End_Date` datetime DEFAULT NULL,
  `Created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `events`
--

INSERT INTO `events` (`ID`, `UserID`, `Title`, `Description`, `Start_Date`, `End_Date`, `Created`, `Modified`) VALUES
(1, 1, 'Event', 'First Event', '2017-12-07 23:40:34', NULL, '2017-12-07 23:40:34', '2017-12-07 23:47:42'),
(4, 1, 'Working', 'This is Working', '2017-12-08 08:00:00', '2017-12-08 11:00:00', '2017-12-08 08:41:26', '2017-12-08 08:41:26');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `event_responses`
--

CREATE TABLE `event_responses` (
  `ID` int(11) NOT NULL,
  `Response` varchar(255) NOT NULL,
  `Response_after` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `event_responses`
--

INSERT INTO `event_responses` (`ID`, `Response`, `Response_after`) VALUES
(1, 'Going', 'Went'),
(2, 'Maybe', NULL),
(3, 'Invited', NULL),
(4, 'Can\'t go', NULL);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `event_users`
--

CREATE TABLE `event_users` (
  `ID` int(11) NOT NULL,
  `EventID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `ResponseID` int(11) NOT NULL,
  `Created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `event_users`
--

INSERT INTO `event_users` (`ID`, `EventID`, `UserID`, `ResponseID`, `Created`, `Modified`) VALUES
(1, 1, 1, 1, '2017-12-08 08:27:35', '2017-12-08 08:27:35'),
(2, 4, 1, 1, '2017-12-08 08:41:26', '2017-12-08 08:41:26'),
(3, 1, 3, 1, '2017-12-08 08:27:35', '2017-12-08 08:27:35');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `friends`
--

CREATE TABLE `friends` (
  `ID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `FriendID` int(11) NOT NULL,
  `Created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `friends`
--

INSERT INTO `friends` (`ID`, `UserID`, `FriendID`, `Created`, `Modified`) VALUES
(2, 1, 3, '2017-12-07 10:44:52', '2017-12-07 10:44:52'),
(3, 1, 8, '2017-12-07 21:26:47', '2017-12-07 21:26:47'),
(4, 3, 1, '2017-12-07 22:04:46', '2017-12-07 22:04:46'),
(5, 9, 1, '2017-12-07 22:04:46', '2017-12-07 22:04:46');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `status`
--

CREATE TABLE `status` (
  `ID` int(11) NOT NULL,
  `PlaceID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `EventID` int(11) DEFAULT NULL,
  `Content` text NOT NULL,
  `Created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `status`
--

INSERT INTO `status` (`ID`, `PlaceID`, `UserID`, `EventID`, `Content`, `Created`, `Modified`) VALUES
(1, 1, 1, NULL, 'Welcome', '2017-12-06 12:35:24', '2017-12-08 08:26:04'),
(2, 1, 1, NULL, 'New Post', '2017-12-06 12:41:28', '2017-12-08 08:26:12'),
(3, 1, 1, NULL, 'My Post', '2017-12-06 12:41:38', '2017-12-08 08:26:08'),
(11, 1, 1, NULL, 'Phasellus dapibus ipsum nec nulla pharetra, sed condimentum dolor rutrum. Vestibulum facilisis.', '2017-12-06 13:52:05', '2017-12-08 08:26:19'),
(12, 1, 3, NULL, 'New', '2017-12-06 14:21:39', '2017-12-08 08:26:14'),
(16, 1, 1, NULL, 'Hej', '2017-12-08 10:58:44', '2017-12-08 10:58:44'),
(17, 3, 3, 1, 'Hej', '2017-12-08 11:05:28', '2017-12-08 11:08:32'),
(18, 3, 1, 1, 'Hej', '2017-12-08 11:09:08', '2017-12-08 11:09:08');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `status_places`
--

CREATE TABLE `status_places` (
  `ID` int(11) NOT NULL,
  `Place` varchar(255) NOT NULL,
  `Created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `status_places`
--

INSERT INTO `status_places` (`ID`, `Place`, `Created`, `Modified`) VALUES
(1, 'Profile', '2017-12-08 08:24:11', '2017-12-08 08:24:11'),
(2, 'Group', '2017-12-08 08:24:11', '2017-12-08 08:24:11'),
(3, 'Event', '2017-12-08 08:24:22', '2017-12-08 08:24:22');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `ProfilePhoto` varchar(255) DEFAULT NULL,
  `Created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Level` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `users`
--

INSERT INTO `users` (`ID`, `Username`, `Password`, `Name`, `ProfilePhoto`, `Created`, `Modified`, `Level`) VALUES
(1, 'Christian', '$2y$10$JOt8uuZkSU.XZIrpIC..BOE2XFmA2e4Xk/3YIuAQ9TzKGRy3GGUgy', 'Christian', '3e6d188b8d710482a6bfb51a2b515c06.png', '2017-12-06 10:47:27', '2017-12-07 12:57:30', 2),
(3, 'Admin', '$2y$10$63dsR4NN96GM8e.puJDfi.tCQdlxgDOXmCkcK5E6EL98eGeZBrJNy', 'Admin', '3e6d188b8d710482a6bfb51a2b515c06.png', '2017-12-06 12:56:20', '2017-12-07 12:57:28', 0),
(8, 'test', '$2y$10$bihheUuRRkI.45qxr0JAS.rVNW6lx9AAild7iu5oP/xtAobfTAgka', 'Test', '3e6d188b8d710482a6bfb51a2b515c06.png', '2017-12-07 12:29:31', '2017-12-07 22:13:12', 0),
(9, 'bo', '$2y$10$sNJlfc3LmDYBEcLZ.kzWs.LFzukbTIwcYY80BQKiheY1izFmeaieG', 'bo', '', '2017-12-07 23:37:57', '2017-12-07 23:37:57', 0);

--
-- Begrænsninger for dumpede tabeller
--

--
-- Indeks for tabel `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `StatusID` (`StatusID`);

--
-- Indeks for tabel `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`ID`);

--
-- Indeks for tabel `event_responses`
--
ALTER TABLE `event_responses`
  ADD PRIMARY KEY (`ID`);

--
-- Indeks for tabel `event_users`
--
ALTER TABLE `event_users`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `EventID` (`EventID`,`UserID`,`ResponseID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `ResponseID` (`ResponseID`);

--
-- Indeks for tabel `friends`
--
ALTER TABLE `friends`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `UserID` (`UserID`,`FriendID`),
  ADD KEY `FriendID` (`FriendID`);

--
-- Indeks for tabel `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `PlaceID` (`PlaceID`),
  ADD KEY `EventID` (`EventID`);

--
-- Indeks for tabel `status_places`
--
ALTER TABLE `status_places`
  ADD PRIMARY KEY (`ID`);

--
-- Indeks for tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- Brug ikke AUTO_INCREMENT for slettede tabeller
--

--
-- Tilføj AUTO_INCREMENT i tabel `comments`
--
ALTER TABLE `comments`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- Tilføj AUTO_INCREMENT i tabel `events`
--
ALTER TABLE `events`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- Tilføj AUTO_INCREMENT i tabel `event_responses`
--
ALTER TABLE `event_responses`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- Tilføj AUTO_INCREMENT i tabel `event_users`
--
ALTER TABLE `event_users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Tilføj AUTO_INCREMENT i tabel `friends`
--
ALTER TABLE `friends`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- Tilføj AUTO_INCREMENT i tabel `status`
--
ALTER TABLE `status`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- Tilføj AUTO_INCREMENT i tabel `status_places`
--
ALTER TABLE `status_places`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Tilføj AUTO_INCREMENT i tabel `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- Begrænsninger for dumpede tabeller
--

--
-- Begrænsninger for tabel `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`ID`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`StatusID`) REFERENCES `status` (`ID`);

--
-- Begrænsninger for tabel `event_users`
--
ALTER TABLE `event_users`
  ADD CONSTRAINT `event_users_ibfk_1` FOREIGN KEY (`EventID`) REFERENCES `events` (`ID`),
  ADD CONSTRAINT `event_users_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `users` (`ID`),
  ADD CONSTRAINT `event_users_ibfk_3` FOREIGN KEY (`ResponseID`) REFERENCES `event_responses` (`ID`);

--
-- Begrænsninger for tabel `friends`
--
ALTER TABLE `friends`
  ADD CONSTRAINT `friends_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`ID`),
  ADD CONSTRAINT `friends_ibfk_2` FOREIGN KEY (`FriendID`) REFERENCES `users` (`ID`);

--
-- Begrænsninger for tabel `status`
--
ALTER TABLE `status`
  ADD CONSTRAINT `status_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`ID`),
  ADD CONSTRAINT `status_ibfk_2` FOREIGN KEY (`PlaceID`) REFERENCES `status_places` (`ID`),
  ADD CONSTRAINT `status_ibfk_3` FOREIGN KEY (`EventID`) REFERENCES `events` (`ID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
