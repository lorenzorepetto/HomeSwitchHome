-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 06, 2019 at 10:39 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `homeSwitchHome`
--

-- --------------------------------------------------------

--
-- Table structure for table `direcciones`
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
-- Table structure for table `fotos`
--

CREATE TABLE `fotos` (
  `id` int(10) UNSIGNED NOT NULL,
  `foto` longblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hotsales`
--

CREATE TABLE `hotsales` (
  `id` int(10) UNSIGNED NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `estado` tinyint(1) NOT NULL,
  `porcentaje` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reservas`
--

CREATE TABLE `reservas` (
  `id` int(10) UNSIGNED NOT NULL,
  `caducada` tinyint(1) NOT NULL DEFAULT '0',
  `id_usuario` int(10) UNSIGNED NOT NULL,
  `id_residencia` int(10) UNSIGNED NOT NULL,
  `monto_pagado` float NOT NULL,
  `semana` int(2) NOT NULL,
  `ocupada` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `residencias`
--

CREATE TABLE `residencias` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` text COLLATE utf8_spanish_ci NOT NULL,
  `capacidad` int(10) UNSIGNED NOT NULL,
  `monto` float NOT NULL,
  `id_direccion` int(10) UNSIGNED NOT NULL,
  `id_foto` int(10) UNSIGNED NOT NULL,
  `id_hotsale` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subastas`
--

CREATE TABLE `subastas` (
  `id` int(10) UNSIGNED NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `estado` tinyint(1) NOT NULL,
  `usuario_ganador` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `id_reserva` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(10) UNSIGNED NOT NULL,
  `email` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `password` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `apellido` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `foto` longblob,
  `telefono` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `creditos` int(11) NOT NULL DEFAULT '0',
  `marca_tarjeta` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `numero_tarjeta` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `titular_tarjeta` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `fecha_vencimiento_tarjeta` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `rol` varchar(20) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'ESTANDAR'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id`, `email`, `password`, `nombre`, `apellido`, `fecha_nacimiento`, `foto`, `telefono`, `creditos`, `marca_tarjeta`, `numero_tarjeta`, `titular_tarjeta`, `fecha_vencimiento_tarjeta`, `rol`) VALUES
(1, 'admin@admin', 'admin1234', 'Administrador', 'Administrador', '0000-00-00', NULL, '111', 0, 'no corresponde', 'no corresponde', 'no corresponde', '0000-00-00', 'ADMINISTRADOR'),
(2, 'loren@mail.com', 'loren1234', 'Lorenzo', 'Repetto', '1994-04-28', NULL, '452710', 2, 'VISA', '444', 'Lorenzo Repetto', '2021-08-16', 'ESTANDAR'),
(3, 'mel@1234', 'mel1234', 'mel', 'ono', '2019-04-23', 0x2f6f70742f6c616d70702f74656d702f70687074366b6b3552, '4', 2, '4', '4', '', '0000-00-00', 'ESTANDAR');

-- --------------------------------------------------------

--
-- Table structure for table `usuarios_subastas`
--

CREATE TABLE `usuarios_subastas` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_usuario` int(10) UNSIGNED NOT NULL,
  `id_subastas` int(10) UNSIGNED NOT NULL,
  `monto_apostado` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `direcciones`
--
ALTER TABLE `direcciones`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fotos`
--
ALTER TABLE `fotos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hotsales`
--
ALTER TABLE `hotsales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reservas`
--
ALTER TABLE `reservas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `residencias`
--
ALTER TABLE `residencias`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subastas`
--
ALTER TABLE `subastas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mail` (`email`);

--
-- Indexes for table `usuarios_subastas`
--
ALTER TABLE `usuarios_subastas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `direcciones`
--
ALTER TABLE `direcciones`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fotos`
--
ALTER TABLE `fotos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hotsales`
--
ALTER TABLE `hotsales`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reservas`
--
ALTER TABLE `reservas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `residencias`
--
ALTER TABLE `residencias`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subastas`
--
ALTER TABLE `subastas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `usuarios_subastas`
--
ALTER TABLE `usuarios_subastas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
