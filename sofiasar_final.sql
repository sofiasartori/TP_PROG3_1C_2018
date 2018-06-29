-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-06-2018 a las 19:26:26
-- Versión del servidor: 10.1.31-MariaDB
-- Versión de PHP: 7.2.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sofiasar_final`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comandas`
--

CREATE TABLE `comandas` (
  `id_comanda` varchar(5) COLLATE utf8_spanish2_ci NOT NULL,
  `id_mesa` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `foto_mesa` varchar(50) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `nombre_cliente` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `estado` varchar(80) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `tiempo` int(11) DEFAULT NULL,
  `hora_inicio` time NOT NULL,
  `fecha` date NOT NULL,
  `hora_fin` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `comandas`
--

INSERT INTO `comandas` (`id_comanda`, `id_mesa`, `id_usuario`, `foto_mesa`, `nombre_cliente`, `estado`, `tiempo`, `hora_inicio`, `fecha`, `hora_fin`) VALUES
('0akz6', 2, 0, NULL, 'prueba', NULL, NULL, '19:20:18', '0000-00-00', NULL),
('0u41v', 2, 0, NULL, 'prueba', NULL, NULL, '19:15:52', '0000-00-00', NULL),
('9cim0', 2, 3, NULL, 'Peblo', NULL, NULL, '00:00:00', '2024-06-18', NULL),
('ha3cn', 2, 0, NULL, 'prueba', NULL, NULL, '19:19:16', '0000-00-00', NULL),
('m2aqh', 2, 3, NULL, 'Olga', 'cancelado', 25, '22:19:31', '0000-00-00', NULL),
('oyhqd', 2, 0, NULL, 'prueba', NULL, NULL, '19:16:53', '0000-00-00', NULL),
('p1wvn', 2, 0, NULL, 'prueba', NULL, NULL, '19:15:22', '0000-00-00', NULL),
('pt20n', 2, 0, NULL, 'prueba', NULL, NULL, '19:20:42', '0000-00-00', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `items`
--

CREATE TABLE `items` (
  `id_item` int(11) NOT NULL,
  `precio` float NOT NULL,
  `descripcion` varchar(30) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `itemsxcomanda`
--

CREATE TABLE `itemsxcomanda` (
  `id_item` int(11) NOT NULL,
  `id_comanda` varchar(5) COLLATE utf8_spanish2_ci NOT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `itemsxcomanda`
--

INSERT INTO `itemsxcomanda` (`id_item`, `id_comanda`, `cantidad`) VALUES
(5, '0', 2),
(5, '0akz6', 2),
(2, 'pt20n', 2),
(4, 'pt20n', 2),
(5, 'pt20n', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesas`
--

CREATE TABLE `mesas` (
  `id_mesa` int(11) NOT NULL,
  `estado` varchar(30) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `apellido` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `usuario` varchar(30) COLLATE utf8_spanish2_ci NOT NULL,
  `perfil` varchar(30) COLLATE utf8_spanish2_ci NOT NULL,
  `area` varchar(30) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `apellido`, `usuario`, `perfil`, `area`) VALUES
(1, 'sofia', 'sartori', 'sofiasar', 'socio', 'gerencia'),
(2, 'pablo', 'arguimbau', 'pabloearg', 'socio', 'gerencia'),
(3, 'mauro', 'sartori', 'maurosar', 'socio', 'gerencia'),
(4, 'damian', 'mussi', 'dmussi', 'mozo', 'salon'),
(5, 'livio', 'palmieri', 'lpalmieri', 'mozo', 'salon');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `comandas`
--
ALTER TABLE `comandas`
  ADD PRIMARY KEY (`id_comanda`);

--
-- Indices de la tabla `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id_item`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `items`
--
ALTER TABLE `items`
  MODIFY `id_item` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
