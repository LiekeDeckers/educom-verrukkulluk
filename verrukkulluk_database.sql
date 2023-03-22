-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 22 mrt 2023 om 09:03
-- Serverversie: 10.4.27-MariaDB
-- PHP-versie: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `verrukkulluk`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `artikel`
--

CREATE TABLE `artikel` (
  `artikel_id` int(6) NOT NULL,
  `naam` varchar(30) NOT NULL,
  `omschrijving` varchar(100) NOT NULL,
  `prijs` float NOT NULL,
  `eenheid` varchar(30) NOT NULL,
  `verpakking` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `artikel`
--

INSERT INTO `artikel` (`artikel_id`, `naam`, `omschrijving`, `prijs`, `eenheid`, `verpakking`) VALUES
(1, 'Broodje', 'Hamburger broodje', 4.5, 'stuks', 6),
(2, 'Burger', 'Hamburger van vegetarisch vlees', 6.5, 'gr', 350),
(3, 'Saus', 'Saus voor bij de hamburger', 5, 'ml', 300),
(4, 'Avocado', 'Tropische groente', 3, 'stuks', 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `gerecht`
--

CREATE TABLE `gerecht` (
  `gerecht_id` int(6) NOT NULL,
  `keuken_id` int(6) NOT NULL,
  `type_id` int(6) NOT NULL,
  `user_id` int(6) NOT NULL,
  `datum_toegevoegd` date NOT NULL,
  `titel` varchar(30) NOT NULL,
  `korte_omschrijving` varchar(200) NOT NULL,
  `lange_omschrijving` varchar(400) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `gerecht`
--

INSERT INTO `gerecht` (`gerecht_id`, `keuken_id`, `type_id`, `user_id`, `datum_toegevoegd`, `titel`, `korte_omschrijving`, `lange_omschrijving`) VALUES
(1, 1, 4, 3, '2023-03-02', 'Eggs & Vegies', 'Ei met groente.', 'Heel lekker gerecht me ei en veel groente.'),
(2, 1, 4, 1, '2023-03-04', 'Vega Burger', 'Vegatarische hamburger.', 'Recept voor hamburger met vegatarisch vlees.'),
(3, 2, 6, 4, '2023-03-12', 'Sushi Rolls', 'Rolletjes sushi', 'Sushi met vis en rijst in een rol gedraaid.'),
(4, 3, 4, 1, '2023-03-16', 'Pizza Green', 'Vega pizza.', 'Echte Italiaanse pizza, maar zonder vlees.');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `gerecht_info`
--

CREATE TABLE `gerecht_info` (
  `gerecht_info_id` int(6) NOT NULL,
  `record_type` varchar(30) NOT NULL,
  `gerecht_id` int(6) NOT NULL,
  `user_id` int(6) DEFAULT NULL,
  `datum` date DEFAULT NULL,
  `nummeriekveld` int(6) DEFAULT NULL,
  `tekstveld` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `gerecht_info`
--

INSERT INTO `gerecht_info` (`gerecht_info_id`, `record_type`, `gerecht_id`, `user_id`, `datum`, `nummeriekveld`, `tekstveld`) VALUES
(1, 'B', 2, 1, '0000-00-00', 1, 'Olie op laag vuur.'),
(2, 'B', 2, 1, '0000-00-00', 2, 'Braadt het vlees.'),
(3, 'B', 2, 1, '0000-00-00', 4, 'Snij de avocado.'),
(4, 'B', 2, 1, '0000-00-00', 4, 'Beleg het broodje.'),
(5, 'B', 2, 1, '0000-00-00', 5, 'Maak het af met saus.'),
(6, 'O', 2, 1, '2023-03-06', 0, 'Niet lekker.'),
(7, 'O', 2, 2, '2023-03-06', 0, 'Heel erg lekker!'),
(8, 'O', 2, 3, '2023-03-11', 0, 'Ging wel.'),
(9, 'O', 2, 4, '2023-03-15', 0, 'Best lekker!'),
(10, 'W', 2, 2, '2023-03-06', 5, ''),
(11, 'W', 2, 3, '2023-03-11', 3, ''),
(12, 'W', 2, 4, '2023-03-15', 3, ''),
(13, 'F', 2, 2, '0000-00-00', 0, ''),
(14, 'F', 2, 4, '0000-00-00', 0, '');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `gerecht_info_test`
--

CREATE TABLE `gerecht_info_test` (
  `gerecht_info_id` int(6) NOT NULL,
  `record_type` varchar(30) NOT NULL,
  `gerecht_id` int(6) NOT NULL,
  `user_id` int(6) DEFAULT NULL,
  `datum` timestamp NOT NULL DEFAULT current_timestamp(),
  `nummeriekveld` int(6) DEFAULT NULL,
  `tekstveld` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `ingredient`
--

CREATE TABLE `ingredient` (
  `ingredient_id` int(6) NOT NULL,
  `gerecht_id` int(6) NOT NULL,
  `artikel_id` int(6) NOT NULL,
  `aantal` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `ingredient`
--

INSERT INTO `ingredient` (`ingredient_id`, `gerecht_id`, `artikel_id`, `aantal`) VALUES
(1, 2, 1, 4),
(2, 2, 2, 350),
(3, 2, 3, 30),
(4, 2, 4, 2);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `type_keuken`
--

CREATE TABLE `type_keuken` (
  `type_keuken_id` int(6) NOT NULL,
  `record_type` varchar(6) NOT NULL,
  `omschrijving` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `type_keuken`
--

INSERT INTO `type_keuken` (`type_keuken_id`, `record_type`, `omschrijving`) VALUES
(1, 'K', 'Amerikaans'),
(2, 'K', 'Japans'),
(3, 'K', 'Italiaans'),
(4, 'T', 'Vegatarisch'),
(5, 'T', 'Vlees'),
(6, 'T', 'Vis');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `user`
--

CREATE TABLE `user` (
  `user_id` int(6) NOT NULL,
  `user_name` varchar(30) NOT NULL,
  `user_password` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `afbeelding` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `user_password`, `email`, `afbeelding`) VALUES
(1, 'Tommie', 'wwtommie', 'tommie@gmail.com', 'https://'),
(2, 'Bennie', 'wwbennie', 'bennie@gmail.com', 'https://'),
(3, 'Sammy', 'wwsammy', 'sammy@gmail.com', 'https://'),
(4, 'Katinka', 'wwkatinka', 'katinka@gmail.com', 'https://');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `artikel`
--
ALTER TABLE `artikel`
  ADD PRIMARY KEY (`artikel_id`);

--
-- Indexen voor tabel `gerecht`
--
ALTER TABLE `gerecht`
  ADD PRIMARY KEY (`gerecht_id`),
  ADD KEY `keuken_id` (`keuken_id`),
  ADD KEY `type_id` (`type_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexen voor tabel `gerecht_info`
--
ALTER TABLE `gerecht_info`
  ADD PRIMARY KEY (`gerecht_info_id`),
  ADD KEY `gerecht_id` (`gerecht_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexen voor tabel `gerecht_info_test`
--
ALTER TABLE `gerecht_info_test`
  ADD PRIMARY KEY (`gerecht_info_id`),
  ADD KEY `gerecht_id` (`gerecht_id`);

--
-- Indexen voor tabel `ingredient`
--
ALTER TABLE `ingredient`
  ADD PRIMARY KEY (`ingredient_id`),
  ADD KEY `artikel_id` (`artikel_id`),
  ADD KEY `gerecht_id` (`gerecht_id`);

--
-- Indexen voor tabel `type_keuken`
--
ALTER TABLE `type_keuken`
  ADD PRIMARY KEY (`type_keuken_id`);

--
-- Indexen voor tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `artikel`
--
ALTER TABLE `artikel`
  MODIFY `artikel_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT voor een tabel `gerecht_info`
--
ALTER TABLE `gerecht_info`
  MODIFY `gerecht_info_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT voor een tabel `gerecht_info_test`
--
ALTER TABLE `gerecht_info_test`
  MODIFY `gerecht_info_id` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `ingredient`
--
ALTER TABLE `ingredient`
  MODIFY `ingredient_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT voor een tabel `type_keuken`
--
ALTER TABLE `type_keuken`
  MODIFY `type_keuken_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `gerecht`
--
ALTER TABLE `gerecht`
  ADD CONSTRAINT `keuken_id` FOREIGN KEY (`keuken_id`) REFERENCES `type_keuken` (`type_keuken_id`),
  ADD CONSTRAINT `type_id` FOREIGN KEY (`type_id`) REFERENCES `type_keuken` (`type_keuken_id`);

--
-- Beperkingen voor tabel `gerecht_info`
--
ALTER TABLE `gerecht_info`
  ADD CONSTRAINT `gerecht_id` FOREIGN KEY (`gerecht_id`) REFERENCES `gerecht` (`gerecht_id`),
  ADD CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Beperkingen voor tabel `gerecht_info_test`
--
ALTER TABLE `gerecht_info_test`
  ADD CONSTRAINT `gerecht_info_test_ibfk_1` FOREIGN KEY (`gerecht_id`) REFERENCES `gerecht` (`gerecht_id`);

--
-- Beperkingen voor tabel `ingredient`
--
ALTER TABLE `ingredient`
  ADD CONSTRAINT `artikel_id` FOREIGN KEY (`artikel_id`) REFERENCES `artikel` (`artikel_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
