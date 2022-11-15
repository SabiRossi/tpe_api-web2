-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-11-2022 a las 19:22:48
-- Versión del servidor: 10.4.25-MariaDB
-- Versión de PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `db_tpeqatar`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `players`
--

CREATE TABLE `players` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  `team` varchar(50) DEFAULT NULL,
  `league` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `players`
--

INSERT INTO `players` (`id`, `nombre`, `position`, `team`, `league`) VALUES
(41, 'Nahuel Molina', 12, 'Atletico Maadrid', 'Liga BBVA'),
(43, 'German Pezzella', 12, 'Betis', 'Liga BBVA'),
(44, 'Cristian Romero ', 12, 'Tottenham', 'Premier League'),
(45, 'Nicolas Otamendi ', 12, 'Benfica', 'Liga Portuguesa'),
(46, 'Lisandro Martinez', 12, 'Manchester United ', 'Premier League'),
(47, 'Juan Foyth', 12, 'Villarreal', 'Liga BBVA'),
(49, 'Nicolas Tagliafico', 12, 'Olympique de Lyon', 'Ligue 1'),
(50, 'Marcos Acuña', 12, 'Sevilla', 'Liga BBVA'),
(51, 'Gonzalo Montiel ', 12, 'Sevilla', 'Liga BBVA'),
(52, 'Rodrigo De Paul', 13, 'Atletico de Madrid', 'Liga BBVA'),
(53, 'Guido Rodriguez', 13, 'Betis', 'Liga BBVA'),
(55, 'Leandro Paredes', 13, 'Paris Saint Germain', 'Ligue 1'),
(56, 'Giovani Lo Celso', 13, 'Villarreal', 'Liga BBVA'),
(57, 'Alexis Mac Allister', 13, 'Brighton & Hove Albion', 'Premier League'),
(58, 'Alejandro \"Papu\" Gomez', 14, 'Sevilla', 'Liga BBVA'),
(59, 'Exequiel Palacios', 13, 'Bayer 04 Leverkusen', 'Bundesliga'),
(60, 'Angel Di Maria ', 14, 'Juventus', 'Serie A'),
(61, 'Lautaro Martinez ', 15, 'Inter de Milan ', 'Serie A'),
(62, 'Julian Alvarez', 15, 'Manchester City', 'Premier League'),
(63, 'Lionel Messi ', 15, 'Paris Saint Germain ', 'Ligue 1'),
(64, 'Nicolas Gonzalez', 14, 'Fiorentina', 'Serie A'),
(65, 'Paulo Dybala', 15, 'AS Roma', 'Serie A'),
(66, 'Angel Correa', 15, 'Atletico Madrid', 'Liga BBVA'),
(87, 'Agustin Rossi', 11, 'Boca Juniors', 'Superliga Argentina'),
(88, 'Geronimo Rulli', 11, 'Villarreal', 'Liga BBVA'),
(89, 'Emiliano Martinez', 11, 'Aston Villa', 'Premier League');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `positions`
--

CREATE TABLE `positions` (
  `position_id` int(11) NOT NULL,
  `position` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `positions`
--

INSERT INTO `positions` (`position_id`, `position`) VALUES
(11, 'Arquero'),
(12, 'Defensor'),
(13, 'Mediocampista'),
(14, 'Extremo'),
(15, 'Delantero');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `email`, `password`) VALUES
(2, 'sabino@admin.com', '$2y$10$v3elQ9Q0zGdTG35lB4Im5.ScgrgtmP6PevGRQkNwF5PkUJQ9JonqC');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `players`
--
ALTER TABLE `players`
  ADD PRIMARY KEY (`id`),
  ADD KEY `position` (`position`);

--
-- Indices de la tabla `positions`
--
ALTER TABLE `positions`
  ADD PRIMARY KEY (`position_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `players`
--
ALTER TABLE `players`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT de la tabla `positions`
--
ALTER TABLE `positions`
  MODIFY `position_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `players`
--
ALTER TABLE `players`
  ADD CONSTRAINT `players_ibfk_1` FOREIGN KEY (`position`) REFERENCES `positions` (`position_id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
