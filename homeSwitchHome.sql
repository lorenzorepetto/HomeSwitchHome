-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-04-2019 a las 01:56:47
-- Versión del servidor: 10.1.38-MariaDB
-- Versión de PHP: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `homeSwitchHome`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `direcciones`
--

CREATE TABLE `direcciones` (
  `id` int(10) UNSIGNED NOT NULL,
  `calle` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `altura` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `provincia` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `ciudad` varchar(50) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estadias`
--

CREATE TABLE `estadias` (
  `id` int(10) UNSIGNED NOT NULL,
  `caducada` tinyint(1) NOT NULL DEFAULT '0',
  `id_residencia` int(10) UNSIGNED NOT NULL,
  `monto_pagado` float NOT NULL,
  `semana` int(2) NOT NULL,
  `ocupada` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hotsales`
--

CREATE TABLE `hotsales` (
  `id` int(10) UNSIGNED NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `estado` tinyint(1) NOT NULL,
  `porcentaje` float NOT NULL,
  `id_estadia` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `residencias`
--

CREATE TABLE `residencias` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` text COLLATE utf8_spanish_ci NOT NULL,
  `foto` varchar(100) COLLATE utf8_spanish_ci DEFAULT 'app/img/residencias/residenciaPrueba.jpg',
  `capacidad` int(10) UNSIGNED NOT NULL,
  `monto` float NOT NULL,
  `id_direccion` int(10) UNSIGNED NOT NULL,
  `estado_logico` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subastas`
--

CREATE TABLE `subastas` (
  `id` int(10) UNSIGNED NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `estado` tinyint(1) NOT NULL,
  `usuario_ganador` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `id_estadia` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(10) UNSIGNED NOT NULL,
  `email` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `password` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `apellido` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `foto` varchar(250) COLLATE utf8_spanish_ci DEFAULT 'app/img/usuarios/user.png',
  `telefono` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `creditos` int(11) NOT NULL DEFAULT '0',
  `marca_tarjeta` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `numero_tarjeta` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `titular_tarjeta` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `fecha_vencimiento_tarjeta` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `rol` varchar(20) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'ESTANDAR',
  `estado_logico` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `email`, `password`, `nombre`, `apellido`, `fecha_nacimiento`, `foto`, `telefono`, `creditos`, `marca_tarjeta`, `numero_tarjeta`, `titular_tarjeta`, `fecha_vencimiento_tarjeta`, `rol`, `estado_logico`) VALUES
(1, 'admin@homeswitchhome.com', 'admin1234', 'Administrador', 'Administrador', '0000-00-00', NULL, '111', 0, 'no corresponde', 'no corresponde', 'no corresponde', '0000-00-00', 'ADMINISTRADOR', 1),
(2, 'loren@mail.com', 'loren1234', 'Lorenzo', 'Repetto', '1994-04-28', 'app/img/usuarios/user.png', '452710', 1, 'VISA', '444', 'Lorenzo Repetto', '2021-08-16', 'ESTANDAR', 1),
(3, 'prueba@mail.com', 'prueba1234', 'Prueba', 'SubirUsuario', '1992-04-18', '', '11111', 2, 'AAA', '111', '', '1/2020', 'ESTANDAR', 1),
(4, 'asdasdasd@asdas.asd', 'asdasdasd', 'asdasdas', 'asdasdasd', '2000-04-05', '', 'asdasd', 2, 'asdasdas', 'asdad', '', 'asdasd', 'ESTANDAR', 1),
(5, 'pieri@mail.com', 'pieri1234', 'Pierina', 'Tufillaro', '1999-01-13', '', '411872', 2, 'VISA', '1111', '', '13/2022', 'ESTANDAR', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_estadias`
--

CREATE TABLE `usuarios_estadias` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_usuario` int(10) UNSIGNED NOT NULL,
  `id_estadia` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_subastas`
--

CREATE TABLE `usuarios_subastas` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_usuario` int(10) UNSIGNED NOT NULL,
  `id_subastas` int(10) UNSIGNED NOT NULL,
  `monto_apostado` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `direcciones`
--
ALTER TABLE `direcciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `estadias`
--
ALTER TABLE `estadias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `hotsales`
--
ALTER TABLE `hotsales`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `residencias`
--
ALTER TABLE `residencias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `subastas`
--
ALTER TABLE `subastas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mail` (`email`);

--
-- Indices de la tabla `usuarios_estadias`
--
ALTER TABLE `usuarios_estadias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios_subastas`
--
ALTER TABLE `usuarios_subastas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `direcciones`
--
ALTER TABLE `direcciones`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `estadias`
--
ALTER TABLE `estadias`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `hotsales`
--
ALTER TABLE `hotsales`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `residencias`
--
ALTER TABLE `residencias`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `subastas`
--
ALTER TABLE `subastas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuarios_estadias`
--
ALTER TABLE `usuarios_estadias`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios_subastas`
--
ALTER TABLE `usuarios_subastas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
