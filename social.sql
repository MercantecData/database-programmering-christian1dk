-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Vært: 127.0.0.1
-- Genereringstid: 07. 12 2017 kl. 07:22:31
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
(5, 3, 11, 'Work', '2017-12-06 20:14:49', '2017-12-07 00:04:42');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `status`
--

CREATE TABLE `status` (
  `ID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `Content` text NOT NULL,
  `Created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `status`
--

INSERT INTO `status` (`ID`, `UserID`, `Content`, `Created`, `Modified`) VALUES
(1, 1, 'Welcome', '2017-12-06 12:35:24', '2017-12-06 21:49:00'),
(2, 1, 'New Post', '2017-12-06 12:41:28', '2017-12-06 14:29:23'),
(3, 1, 'My Post', '2017-12-06 12:41:38', '2017-12-06 14:29:29'),
(4, 1, 'test', '2017-12-06 12:41:41', '2017-12-06 14:29:32'),
(5, 1, 'Test', '2017-12-06 12:52:11', '2017-12-06 14:29:35'),
(7, 1, 'Test2', '2017-12-06 13:36:25', '2017-12-07 00:00:48'),
(11, 1, 'Phasellus dapibus ipsum nec nulla pharetra, sed condimentum dolor rutrum. Vestibulum facilisis.', '2017-12-06 13:52:05', '2017-12-06 22:13:40'),
(12, 3, 'New', '2017-12-06 14:21:39', '2017-12-06 14:29:16');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Level` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `users`
--

INSERT INTO `users` (`ID`, `Username`, `Password`, `Name`, `Created`, `Modified`, `Level`) VALUES
(1, 'Christian', '$2y$10$JOt8uuZkSU.XZIrpIC..BOE2XFmA2e4Xk/3YIuAQ9TzKGRy3GGUgy', 'Christian', '2017-12-06 10:47:27', '2017-12-06 12:11:38', 2),
(3, 'Admin', '$2y$10$63dsR4NN96GM8e.puJDfi.tCQdlxgDOXmCkcK5E6EL98eGeZBrJNy', 'Admin', '2017-12-06 12:56:20', '2017-12-06 12:56:20', 0);

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
-- Indeks for tabel `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `UserID` (`UserID`);

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
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- Tilføj AUTO_INCREMENT i tabel `status`
--
ALTER TABLE `status`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- Tilføj AUTO_INCREMENT i tabel `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
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
-- Begrænsninger for tabel `status`
--
ALTER TABLE `status`
  ADD CONSTRAINT `status_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`ID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
