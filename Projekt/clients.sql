-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 26 Sty 2023, 13:50
-- Wersja serwera: 10.4.22-MariaDB
-- Wersja PHP: 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `clients`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `logged_in_users`
--

CREATE TABLE `logged_in_users` (
  `sessionId` varchar(100) NOT NULL,
  `userId` int(11) NOT NULL,
  `lastUpdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `results`
--

CREATE TABLE `results` (
  `Id` int(10) UNSIGNED NOT NULL,
  `userId` int(10) NOT NULL,
  `attack` float NOT NULL,
  `block` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nick` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `surname` varchar(100) NOT NULL,
  `position` varchar(30) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `passwd` varchar(255) NOT NULL,
  `status` int(1) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`id`, `nick`, `name`, `surname`, `position`, `email`, `passwd`, `status`, `date`) VALUES
(20, 'koaa', 'Koaaa', 'Koloa', 'setter', 'karolq@op.pl', '$2y$10$PdHsMtVYxGHG0GqlkSROI.MIRhumPuYcUWMw5jj06zfR6UXCyPsX.', 1, '2023-01-13 15:40:23'),
(21, 'kotre', 'Kolaaa', 'Kolaaere', 'setter', 'ko@op.pl', '$2y$10$DzQxe.vFfvpTGRy/geyete6sxOaCnw47SzUx/VbgIsloIAqpfrHOG', 1, '2023-01-13 15:42:48'),
(43, 'asd', 'As', 'As', 'setter', 'k@op.pl', '$2y$10$0xV45M2.Q3vjziCMsuSo2ODh0kRfNve5Uiabrr2HoX9aj5bI54tvy', 1, '2023-01-23 00:15:09'),
(44, 'Kcarol3', 'Karol', 'Kurowski', 'middleBlocker', 'kk@op.pl', '$2y$10$P8GogDGa6diE/d0V6fLwgulLSmOolrgPNODjAdWiRfVJP5QN5W/sq', 1, '2023-01-23 18:59:06'),
(45, 'star', 'Karol', 'Gad', 'middleBlocker', 'oo@op.pl', '$2y$10$MT9jhnSkTaA30J4/9ccBzO0FFl22nmeHOJNOeFkrmbhfz0InEjhV2', 1, '2023-01-24 21:06:00');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `logged_in_users`
--
ALTER TABLE `logged_in_users`
  ADD PRIMARY KEY (`sessionId`);

--
-- Indeksy dla tabeli `results`
--
ALTER TABLE `results`
  ADD PRIMARY KEY (`Id`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nick` (`nick`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `results`
--
ALTER TABLE `results`
  MODIFY `Id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
