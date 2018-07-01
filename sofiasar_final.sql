-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-07-2018 a las 05:14:14
-- Versión del servidor: 10.1.10-MariaDB
-- Versión de PHP: 7.0.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
  `tiempo_cocina` int(11) DEFAULT NULL,
  `tiempo_barra` int(11) DEFAULT NULL,
  `tiempo_cerveza` int(11) DEFAULT NULL,
  `hora_inicio` time NOT NULL,
  `fecha` date NOT NULL,
  `hora_fin` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `comandas`
--

INSERT INTO `comandas` (`id_comanda`, `id_mesa`, `id_usuario`, `foto_mesa`, `nombre_cliente`, `estado`, `tiempo_cocina`, `tiempo_barra`, `tiempo_cerveza`, `hora_inicio`, `fecha`, `hora_fin`) VALUES
('0akz6', 2, 0, NULL, 'prueba', NULL, NULL, 0, 0, '19:20:18', '0000-00-00', '02:30:22'),
('0u41v', 2, 0, NULL, 'prueba', NULL, NULL, 0, 0, '19:15:52', '0000-00-00', '02:30:22'),
('9cim0', 2, 3, NULL, 'Peblo', NULL, NULL, 0, 0, '00:00:00', '2024-06-18', '02:30:22'),
('ha3cn', 2, 0, NULL, 'prueba', NULL, NULL, 0, 0, '19:19:16', '0000-00-00', '02:30:22'),
('m2aqh', 2, 3, NULL, 'Olga', 'cancelado', 25, 0, 0, '22:19:31', '0000-00-00', '02:30:22'),
('oyhqd', 2, 0, NULL, 'prueba', NULL, NULL, 0, 0, '19:16:53', '0000-00-00', '02:30:22'),
('p1wvn', 2, 0, NULL, 'prueba', NULL, NULL, 0, 0, '19:15:22', '0000-00-00', '02:30:22'),
('pt20n', 2, 0, NULL, 'prueba', NULL, NULL, 0, 0, '19:20:42', '0000-00-00', '02:30:22');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `items`
--

CREATE TABLE `items` (
  `id_item` int(11) NOT NULL,
  `precio` float NOT NULL,
  `descripcion` varchar(30) COLLATE utf8_spanish2_ci NOT NULL,
  `tipo` varchar(20) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `items`
--

INSERT INTO `items` (`id_item`, `precio`, `descripcion`, `tipo`) VALUES
(1, 190, 'Pizza', 'comida'),
(2, 25, 'Empanadas', 'comida'),
(3, 40, 'Gaseosa 600', 'bar'),
(4, 90, 'Gaseosa 2 lt.', 'bar'),
(5, 90, 'Cerveza 1lt.', 'cerveza'),
(6, 45, 'Cerveza lata', 'cerveza'),
(7, 40, 'Budin de pan', 'comida'),
(8, 40, 'Flan casero', 'comida'),
(9, 90, 'Vino de la casa', 'bar'),
(10, 130, 'Vino seleccion', 'bar');

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

--
-- Volcado de datos para la tabla `mesas`
--

INSERT INTO `mesas` (`id_mesa`, `estado`) VALUES
(2, 'Con clientes comiendo'),
(5, 'Con cliente esperando pedido'),
(5, 'Con cliente esperando pedido');

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
  `area` varchar(30) COLLATE utf8_spanish2_ci NOT NULL,
  `estado` varchar(30) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `apellido`, `usuario`, `perfil`, `area`, `estado`) VALUES
(1, 'sofia', 'sartori', 'sofiasar', 'socio', 'gerencia', 'activo'),
(2, 'pablo', 'arguimbau', 'pabloearg', 'socio', 'gerencia', 'activo'),
(3, 'mauro', 'sartori', 'maurosar', 'socio', 'gerencia', 'activo'),
(4, 'damian', 'mussi', 'dmussi', 'mozo', 'salon', 'activo'),
(5, 'livio', 'palmieri', 'lpalmieri', 'mozo', 'salon', 'activo'),
(6, 'nicolas', 'lucchesi', 'nlucchesi', 'cervecero', 'barra', 'activo'),
(7, 'micaela', 'cianflone', 'mcianflone', 'moza', 'salon', 'activo'),
(8, 'lucas', 'mora', 'lmora', 'bartender', 'barra', 'activo'),
(9, 'ivana', 'benitez', 'ibenitez', 'bartender', 'barra', 'activo'),
(10, 'nicolas', 'lugosi', 'nlugosi', 'cervecero', 'barra', 'activo'),
(11, 'carolina', 'rodriguez', 'crodriguez', 'cocinero', 'cocina', 'activo'),
(12, 'celeste', 'waijer', 'cwaijer', 'cocinero', 'cocina', 'activo');

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
  MODIFY `id_item` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
