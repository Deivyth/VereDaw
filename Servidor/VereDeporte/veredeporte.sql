-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 18-02-2022 a las 19:19:54
-- Versión del servidor: 10.4.21-MariaDB
-- Versión de PHP: 7.4.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `veredeporte`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `apunta`
--

CREATE TABLE `apunta` (
  `id` int(11) NOT NULL,
  `equipo_id` int(11) DEFAULT NULL,
  `liga_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `campo`
--

CREATE TABLE `campo` (
  `id` int(11) NOT NULL,
  `tipo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20220208150536', '2022-02-08 16:05:55', 1735),
('DoctrineMigrations\\Version20220208151930', '2022-02-08 16:19:36', 500),
('DoctrineMigrations\\Version20220218145345', '2022-02-18 15:54:01', 133),
('DoctrineMigrations\\Version20220218174548', '2022-02-18 18:45:55', 185);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipo`
--

CREATE TABLE `equipo` (
  `id` int(11) NOT NULL,
  `capitan_id` int(11) DEFAULT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` longblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `equipo`
--

INSERT INTO `equipo` (`id`, `capitan_id`, `nombre`, `photo`) VALUES
(1, 4, 'Valencia FC', 0x2f746d702f70687077416a74554f);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `liga`
--

CREATE TABLE `liga` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_inicio` datetime NOT NULL,
  `fecha_fin` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `liga`
--

INSERT INTO `liga` (`id`, `nombre`, `fecha_inicio`, `fecha_fin`) VALUES
(1, 'La VereChampions', '2022-02-19 00:00:00', NULL),
(3, 'La VereChampions', '2022-02-19 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `partido`
--

CREATE TABLE `partido` (
  `id` int(11) NOT NULL,
  `id_local_id` int(11) DEFAULT NULL,
  `id_visitante_id` int(11) DEFAULT NULL,
  `id_usuario_id` int(11) DEFAULT NULL,
  `id_campo_id` int(11) DEFAULT NULL,
  `fecha` date NOT NULL,
  `resultado` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reserva`
--

CREATE TABLE `reserva` (
  `id` int(11) NOT NULL,
  `id_equipo_id` int(11) DEFAULT NULL,
  `id_usuario_id` int(11) DEFAULT NULL,
  `id_campo_id` int(11) DEFAULT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicita`
--

CREATE TABLE `solicita` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `equipo_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `solicita`
--

INSERT INTO `solicita` (`id`, `usuario_id`, `equipo_id`) VALUES
(1, 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` longblob DEFAULT NULL,
  `equipo_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `email`, `roles`, `password`, `nombre`, `photo`, `equipo_id`) VALUES
(2, '123@gmail.com', '[\"ROLE_JUGADOR\"]', '$2y$13$4EHMneiB.zG3w/O6HiI2P.DHqPETwqxhd9GPWk9fzIWlV8qOnur8u', '123', 0x2f746d702f706870627344374678, NULL),
(3, 'root@gmail.com', '[\"ROLE_PROFESOR\"]', '$2y$13$VmwmjpvvJbW3/N1403ds.u8cHMD.8So2JEkD5xjxXcwNhk3UeqG7G', 'root', 0x2f746d702f7068704b4e6a326376, NULL),
(4, 'pedro@gmail.com', '[\"ROLE_CAPITAN\"]', '$2y$13$P2UhA9aTFHr0Gr3Y8KeesewMR.y6fJt38PPGR7REguT9vhUZP7.ji', 'Pedro', 0x2f746d702f706870555268787137, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `apunta`
--
ALTER TABLE `apunta`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_E4F6C62B23BFBED` (`equipo_id`),
  ADD UNIQUE KEY `UNIQ_E4F6C62BCF098064` (`liga_id`);

--
-- Indices de la tabla `campo`
--
ALTER TABLE `campo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indices de la tabla `equipo`
--
ALTER TABLE `equipo`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_C49C530B5624577C` (`capitan_id`);

--
-- Indices de la tabla `liga`
--
ALTER TABLE `liga`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `partido`
--
ALTER TABLE `partido`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_4E79750BF1A1D4C9` (`id_campo_id`),
  ADD KEY `IDX_4E79750BD81CD94` (`id_local_id`),
  ADD KEY `IDX_4E79750BFBCBDDDD` (`id_visitante_id`),
  ADD KEY `IDX_4E79750B7EB2C349` (`id_usuario_id`);

--
-- Indices de la tabla `reserva`
--
ALTER TABLE `reserva`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_188D2E3BF1A1D4C9` (`id_campo_id`),
  ADD KEY `IDX_188D2E3B820E47CA` (`id_equipo_id`),
  ADD KEY `IDX_188D2E3B7EB2C349` (`id_usuario_id`);

--
-- Indices de la tabla `solicita`
--
ALTER TABLE `solicita`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_CE64EA75DB38439E` (`usuario_id`),
  ADD UNIQUE KEY `UNIQ_CE64EA7523BFBED` (`equipo_id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_2265B05DE7927C74` (`email`),
  ADD KEY `IDX_2265B05D23BFBED` (`equipo_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `apunta`
--
ALTER TABLE `apunta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `campo`
--
ALTER TABLE `campo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `equipo`
--
ALTER TABLE `equipo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `liga`
--
ALTER TABLE `liga`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `partido`
--
ALTER TABLE `partido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `reserva`
--
ALTER TABLE `reserva`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `solicita`
--
ALTER TABLE `solicita`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `apunta`
--
ALTER TABLE `apunta`
  ADD CONSTRAINT `FK_E4F6C62B23BFBED` FOREIGN KEY (`equipo_id`) REFERENCES `equipo` (`id`),
  ADD CONSTRAINT `FK_E4F6C62BCF098064` FOREIGN KEY (`liga_id`) REFERENCES `liga` (`id`);

--
-- Filtros para la tabla `equipo`
--
ALTER TABLE `equipo`
  ADD CONSTRAINT `FK_C49C530B5624577C` FOREIGN KEY (`capitan_id`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `partido`
--
ALTER TABLE `partido`
  ADD CONSTRAINT `FK_4E79750B7EB2C349` FOREIGN KEY (`id_usuario_id`) REFERENCES `usuario` (`id`),
  ADD CONSTRAINT `FK_4E79750BD81CD94` FOREIGN KEY (`id_local_id`) REFERENCES `equipo` (`id`),
  ADD CONSTRAINT `FK_4E79750BF1A1D4C9` FOREIGN KEY (`id_campo_id`) REFERENCES `campo` (`id`),
  ADD CONSTRAINT `FK_4E79750BFBCBDDDD` FOREIGN KEY (`id_visitante_id`) REFERENCES `equipo` (`id`);

--
-- Filtros para la tabla `reserva`
--
ALTER TABLE `reserva`
  ADD CONSTRAINT `FK_188D2E3B7EB2C349` FOREIGN KEY (`id_usuario_id`) REFERENCES `usuario` (`id`),
  ADD CONSTRAINT `FK_188D2E3B820E47CA` FOREIGN KEY (`id_equipo_id`) REFERENCES `equipo` (`id`),
  ADD CONSTRAINT `FK_188D2E3BF1A1D4C9` FOREIGN KEY (`id_campo_id`) REFERENCES `campo` (`id`);

--
-- Filtros para la tabla `solicita`
--
ALTER TABLE `solicita`
  ADD CONSTRAINT `FK_CE64EA7523BFBED` FOREIGN KEY (`equipo_id`) REFERENCES `equipo` (`id`),
  ADD CONSTRAINT `FK_CE64EA75DB38439E` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `FK_2265B05D23BFBED` FOREIGN KEY (`equipo_id`) REFERENCES `equipo` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
