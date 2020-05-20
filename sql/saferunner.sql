-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Temps de generació: 20-05-2020 a les 12:32:21
-- Versió del servidor: 10.4.11-MariaDB
-- Versió de PHP: 7.3.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de dades: `saferunner`
--

-- --------------------------------------------------------

--
-- Estructura de la taula `punt`
--

CREATE TABLE `punt` (
  `id_punt` int(11) NOT NULL,
  `id_ruta` int(11) NOT NULL,
  `latitud` float(10,6) NOT NULL,
  `longitud` float(10,6) NOT NULL,
  `ordre_a_ruta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Bolcament de dades per a la taula `punt`
--

INSERT INTO `punt` (`id_punt`, `id_ruta`, `latitud`, `longitud`, `ordre_a_ruta`) VALUES
(15, 10, 12.000000, 65.000000, 1),
(16, 10, 66.000000, 75.000000, 2);

-- --------------------------------------------------------

--
-- Estructura de la taula `ruta`
--

CREATE TABLE `ruta` (
  `id` int(11) NOT NULL,
  `id_cookie` int(11) NOT NULL,
  `municipi` varchar(60) NOT NULL,
  `data` datetime NOT NULL,
  `ritme` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Bolcament de dades per a la taula `ruta`
--

INSERT INTO `ruta` (`id`, `id_cookie`, `municipi`, `data`, `ritme`) VALUES
(10, 1, 'Rivendel', '1918-05-16 12:14:01', 99);

-- --------------------------------------------------------

--
-- Estructura de la taula `usuari`
--

CREATE TABLE `usuari` (
  `id_cookie` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Bolcament de dades per a la taula `usuari`
--

INSERT INTO `usuari` (`id_cookie`) VALUES
(1);

--
-- Índexs per a les taules bolcades
--

--
-- Índexs per a la taula `punt`
--
ALTER TABLE `punt`
  ADD PRIMARY KEY (`id_punt`),
  ADD KEY `punt_ibfk_1` (`id_ruta`);

--
-- Índexs per a la taula `ruta`
--
ALTER TABLE `ruta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_cookie` (`id_cookie`);

--
-- Índexs per a la taula `usuari`
--
ALTER TABLE `usuari`
  ADD PRIMARY KEY (`id_cookie`);

--
-- AUTO_INCREMENT per les taules bolcades
--

--
-- AUTO_INCREMENT per la taula `punt`
--
ALTER TABLE `punt`
  MODIFY `id_punt` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT per la taula `ruta`
--
ALTER TABLE `ruta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restriccions per a les taules bolcades
--

--
-- Restriccions per a la taula `punt`
--
ALTER TABLE `punt`
  ADD CONSTRAINT `punt_ibfk_1` FOREIGN KEY (`id_ruta`) REFERENCES `ruta` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restriccions per a la taula `ruta`
--
ALTER TABLE `ruta`
  ADD CONSTRAINT `ruta_ibfk_1` FOREIGN KEY (`id_cookie`) REFERENCES `usuari` (`id_cookie`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
