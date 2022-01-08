-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 08 Sty 2022, 17:43
-- Wersja serwera: 10.4.22-MariaDB
-- Wersja PHP: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `pizzeria`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `basket`
--

CREATE TABLE `basket` (
  `client_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `food_size_id` int(11) DEFAULT NULL,
  `is_realised` tinyint(1) NOT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `basket`
--

INSERT INTO `basket` (`client_id`, `order_id`, `food_size_id`, `is_realised`, `quantity`) VALUES
(32, NULL, 11, 0, 2);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `client`
--

CREATE TABLE `client` (
  `id` int(11) NOT NULL,
  `client_role_id` int(11) NOT NULL DEFAULT 1,
  `first_name` varchar(30) COLLATE utf8_polish_ci DEFAULT NULL,
  `last_name` varchar(50) COLLATE utf8_polish_ci DEFAULT NULL,
  `password` text COLLATE utf8_polish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `client`
--

INSERT INTO `client` (`id`, `client_role_id`, `first_name`, `last_name`, `password`) VALUES
(32, 1, 'Piotr', 'Błasiak', '$2y$12$LvnCzrVN8/bOYca2da0TL.tFTkAgF89l3xaPTr92IXp5O./KhLXsi'),
(36, 2, 'test', 'test', '$2y$12$Ap8E3TK9zw5A346p2q2zhey4Sr7vkhvF2QGgpFgo91ToGmqbKcmEi');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `client_address`
--

CREATE TABLE `client_address` (
  `id` int(11) NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `street` varchar(100) COLLATE utf8_polish_ci DEFAULT NULL,
  `house_number` varchar(5) COLLATE utf8_polish_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8_polish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `client_address`
--

INSERT INTO `client_address` (`id`, `client_id`, `street`, `house_number`, `city`) VALUES
(16, 32, 'Jagiellońska ', '57 m ', 'Radomsko');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `client_role`
--

CREATE TABLE `client_role` (
  `id` int(11) NOT NULL,
  `name` varchar(30) COLLATE utf8_polish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `client_role`
--

INSERT INTO `client_role` (`id`, `name`) VALUES
(1, 'USER'),
(2, 'ADMIN');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `contact_data`
--

CREATE TABLE `contact_data` (
  `id` int(11) NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_polish_ci DEFAULT NULL,
  `phone_number` varchar(12) COLLATE utf8_polish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `contact_data`
--

INSERT INTO `contact_data` (`id`, `client_id`, `email`, `phone_number`) VALUES
(5, 32, 'championello@gmail.com', '600472848'),
(6, 36, 'xd@gmail.com', '600472848');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `food`
--

CREATE TABLE `food` (
  `id` int(11) NOT NULL,
  `name` varchar(30) COLLATE utf8_polish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `food`
--

INSERT INTO `food` (`id`, `name`) VALUES
(1, 'Salami'),
(3, 'Funghi2'),
(4, 'Frutti Di Mare'),
(5, '4Stagioni'),
(6, 'Vegetariana I'),
(7, 'Rustica'),
(8, 'Wiejska'),
(9, 'Hawajska'),
(10, 'Pomodoro'),
(11, 'Aleksandria'),
(12, 'Faraon'),
(13, 'Al-Eamarle'),
(14, 'El-bahar'),
(15, 'Horus'),
(17, 'Pyszna'),
(18, 'dwadaw'),
(19, 'witam'),
(42, 'witam');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `food_size`
--

CREATE TABLE `food_size` (
  `id` int(11) NOT NULL,
  `food_id` int(11) DEFAULT NULL,
  `name` varchar(15) COLLATE utf8_polish_ci DEFAULT NULL,
  `price` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `food_size`
--

INSERT INTO `food_size` (`id`, `food_id`, `name`, `price`) VALUES
(7, 3, 'mała', 16),
(8, 3, 'średnia', 22),
(9, 3, 'duża', 34),
(10, 4, 'mała', 21),
(11, 4, 'średnia', 27),
(12, 4, 'duża', 40),
(13, 5, 'mała', 21),
(14, 5, 'średnia', 27),
(15, 5, 'duża', 40),
(16, 6, 'mała', 17),
(17, 6, 'średnia', 23),
(18, 6, 'duża', 35),
(19, 7, 'mała', 20),
(20, 7, 'średnia', 27),
(21, 7, 'duża', 40),
(22, 8, 'mała', 20),
(23, 8, 'średnia', 27),
(24, 8, 'duża', 40),
(25, 9, 'mała', 15),
(26, 9, 'średnia', 22),
(27, 9, 'duża', 31),
(28, 10, 'mała', 18),
(29, 10, 'średnia', 24),
(30, 10, 'duża', 35),
(31, 11, 'mała', 21),
(32, 11, 'średnia', 25),
(33, 11, 'duża', 36),
(34, 12, 'mała', 22),
(35, 12, 'średnia', 26),
(36, 12, 'duża', 37),
(37, 13, 'mała', 20),
(38, 13, 'średnia', 24),
(39, 13, 'duża', 35),
(40, 14, 'mała', 20),
(41, 14, 'średnia', 24),
(42, 14, 'duża', 30),
(43, 15, 'mała', 15),
(44, 15, 'średnia', 20),
(45, 15, 'duża', 32),
(56, 17, 'mała', 10),
(57, 17, 'średnia', 20),
(58, 17, 'duża', 30),
(59, 18, 'mała', 10),
(60, 18, 'średnia', 30),
(61, 18, 'duża', 20),
(62, 19, 'mała', 1),
(63, 19, 'średnia', 2),
(64, 19, 'duża', 3),
(131, 42, 'mała', 1),
(132, 42, 'średnia', 2),
(133, 42, 'duża', 3);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `ingredients`
--

CREATE TABLE `ingredients` (
  `id` int(11) NOT NULL,
  `name` varchar(30) COLLATE utf8_polish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `ingredients`
--

INSERT INTO `ingredients` (`id`, `name`) VALUES
(1, 'Cosik'),
(2, 'Feta'),
(3, 'Pleśniowy'),
(4, 'Mozzarella'),
(5, 'Kurczak'),
(6, 'Salami'),
(7, 'Szynka'),
(8, 'Boczek'),
(9, 'Kabanos'),
(10, 'Pepperoni łagodne'),
(11, 'Kiełbasa'),
(12, 'Jajko'),
(13, 'Krewetki'),
(14, 'Tuńczyk'),
(15, 'ośmiornica'),
(16, 'Papryka kolorowa'),
(17, 'Pieczarki'),
(18, 'Czosnek'),
(19, 'Cebula'),
(20, 'Oliwki'),
(21, 'Ogórek kiszony'),
(22, 'Oregano'),
(23, 'Kukurydza'),
(24, 'Pomidor'),
(25, 'Ananas'),
(26, 'Brzoskwinie'),
(27, 'witam cie cieplutko'),
(28, 'test'),
(29, 'terwadawda'),
(30, 'ostatni'),
(31, 'dwawaw'),
(32, 'wiktor'),
(33, 'wdawd');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `order`
--

CREATE TABLE `order` (
  `id` int(11) NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `address_id` int(11) DEFAULT NULL,
  `order_status_id` int(11) DEFAULT NULL,
  `information_for_courier` text COLLATE utf8_polish_ci DEFAULT NULL,
  `order_date` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `order_status`
--

CREATE TABLE `order_status` (
  `id` int(11) NOT NULL,
  `name` varchar(20) COLLATE utf8_polish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `order_status`
--

INSERT INTO `order_status` (`id`, `name`) VALUES
(1, 'IN_PROGRESS'),
(2, 'FINISHED'),
(3, 'IN_DELIVERY');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `storage`
--

CREATE TABLE `storage` (
  `food_id` int(11) DEFAULT NULL,
  `ingredient_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `storage`
--

INSERT INTO `storage` (`food_id`, `ingredient_id`) VALUES
(1, 1),
(1, 6),
(4, 1),
(4, 13),
(4, 18),
(5, 1),
(5, 7),
(5, 6),
(5, 17),
(5, 10),
(6, 1),
(6, 12),
(6, 19),
(6, 20),
(6, 16),
(6, 10),
(7, 4),
(7, 22),
(7, 6),
(8, 4),
(8, 22),
(8, 19),
(8, 11),
(8, 21),
(9, 1),
(9, 22),
(9, 7),
(9, 25),
(9, 26),
(10, 1),
(10, 22),
(10, 7),
(10, 24),
(11, 1),
(11, 5),
(11, 19),
(11, 22),
(11, 23),
(12, 1),
(12, 7),
(12, 6),
(12, 16),
(12, 17),
(13, 1),
(13, 10),
(13, 6),
(13, 20),
(14, 1),
(14, 7),
(14, 17),
(15, 1),
(15, 8),
(15, 12),
(15, 21),
(17, 2),
(17, 3),
(17, 4),
(17, 5),
(17, 6),
(18, 3),
(18, 7),
(18, 9),
(19, 4),
(19, 5),
(3, 1),
(3, 17),
(42, 7),
(42, 22),
(42, 23),
(42, 24);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `basket`
--
ALTER TABLE `basket`
  ADD KEY `client_id` (`client_id`);

--
-- Indeksy dla tabeli `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `client_address`
--
ALTER TABLE `client_address`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`);

--
-- Indeksy dla tabeli `client_role`
--
ALTER TABLE `client_role`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `contact_data`
--
ALTER TABLE `contact_data`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`);

--
-- Indeksy dla tabeli `food`
--
ALTER TABLE `food`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `food_size`
--
ALTER TABLE `food_size`
  ADD PRIMARY KEY (`id`),
  ADD KEY `food_id` (`food_id`);

--
-- Indeksy dla tabeli `ingredients`
--
ALTER TABLE `ingredients`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `order_status_ibfk_1` (`order_status_id`);

--
-- Indeksy dla tabeli `order_status`
--
ALTER TABLE `order_status`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `storage`
--
ALTER TABLE `storage`
  ADD KEY `food_id` (`food_id`),
  ADD KEY `ingredient_id` (`ingredient_id`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `client`
--
ALTER TABLE `client`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT dla tabeli `client_address`
--
ALTER TABLE `client_address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT dla tabeli `client_role`
--
ALTER TABLE `client_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=204;

--
-- AUTO_INCREMENT dla tabeli `contact_data`
--
ALTER TABLE `contact_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT dla tabeli `food`
--
ALTER TABLE `food`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT dla tabeli `food_size`
--
ALTER TABLE `food_size`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=140;

--
-- AUTO_INCREMENT dla tabeli `ingredients`
--
ALTER TABLE `ingredients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT dla tabeli `order`
--
ALTER TABLE `order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT dla tabeli `order_status`
--
ALTER TABLE `order_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `basket`
--
ALTER TABLE `basket`
  ADD CONSTRAINT `basket_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`);

--
-- Ograniczenia dla tabeli `client_address`
--
ALTER TABLE `client_address`
  ADD CONSTRAINT `client_address_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`);

--
-- Ograniczenia dla tabeli `contact_data`
--
ALTER TABLE `contact_data`
  ADD CONSTRAINT `contact_data_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`);

--
-- Ograniczenia dla tabeli `food_size`
--
ALTER TABLE `food_size`
  ADD CONSTRAINT `food_size_ibfk_1` FOREIGN KEY (`food_id`) REFERENCES `food` (`id`) ON DELETE CASCADE;

--
-- Ograniczenia dla tabeli `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `order_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`),
  ADD CONSTRAINT `order_status_ibfk_1` FOREIGN KEY (`order_status_id`) REFERENCES `order_status` (`id`);

--
-- Ograniczenia dla tabeli `storage`
--
ALTER TABLE `storage`
  ADD CONSTRAINT `storage_ibfk_1` FOREIGN KEY (`food_id`) REFERENCES `food` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `storage_ibfk_2` FOREIGN KEY (`ingredient_id`) REFERENCES `ingredients` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
