-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-05-2019 a las 02:33:17
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
-- Estructura de tabla para la tabla `estadias`
--

CREATE TABLE `estadias` (
  `id` int(10) UNSIGNED NOT NULL,
  `caducada` tinyint(1) NOT NULL DEFAULT '0',
  `id_residencia` int(10) UNSIGNED NOT NULL,
  `semana` int(2) NOT NULL,
  `ocupada` tinyint(1) NOT NULL DEFAULT '0',
  `monto` float NOT NULL,
  `estado_logico` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `estadias`
--

INSERT INTO `estadias` (`id`, `caducada`, `id_residencia`, `semana`, `ocupada`, `monto`, `estado_logico`) VALUES
(1, 0, 1, 100, 0, 1000, 0),
(2, 0, 1, 21, 0, 15000, 0),
(3, 0, 1, 41, 0, 2000, 0),
(4, 0, 2, 19, 0, 10000, 0);

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
-- Estructura de tabla para la tabla `pujas`
--

CREATE TABLE `pujas` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_usuario` int(10) UNSIGNED NOT NULL,
  `id_subasta` int(10) UNSIGNED NOT NULL,
  `monto_apostado` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservas`
--

CREATE TABLE `reservas` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_usuario` int(10) UNSIGNED NOT NULL,
  `id_estadia` int(10) UNSIGNED NOT NULL,
  `monto_pagado` float NOT NULL
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
  `estado_logico` tinyint(1) NOT NULL DEFAULT '0',
  `calle` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `altura` int(11) NOT NULL,
  `ciudad` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `provincia` varchar(50) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `residencias`
--

INSERT INTO `residencias` (`id`, `nombre`, `descripcion`, `foto`, `capacidad`, `estado_logico`, `calle`, `altura`, `ciudad`, `provincia`) VALUES
(1, 'Aldea Andina', 'Los servicios de Aldea Andina incluyen Wi-Fi en todo el recinto, zonas comunes y privadas, piscina climatizada interior y exterior, servicios de SPA, cancha de tenis, un \"quincho para asados\", un fogón, lugar de juegos de mesa y un parque de juegos para los niños en el fabuloso parque de cuatro acres rodeado de una gran variedad de árboles. ', 'app/img/residencias/residencia1.jpg', 10, 0, 'Avenida de Los Pioneros', 1403, 'San Carlos de Bariloche', 'Río Negro'),
(2, 'Building Albar', 'El complejo Building Albar tiene dos espacios diferentes: un área gastronómica abierta a todo el público y un área de recreación privada con piscinas, decks y solárium. Tiene cocheras con portón automatizado con comando a distancia. Ademas cuentan con sauna, hidromasaje, piscina climatizada, área de fitness y vestuarios con acceso independiente. El complejo brinda todo en cuanto a tecnología, confort, seguridad y un diseño moderno en armonía con el entorno. ', 'app/img/residencias/residencia2.jpg', 6, 0, 'Av. Bunge ', 1868, 'Pinamar', 'Buenos Aires'),
(3, 'Apartur Mar Del Plata', 'El desarrollo cuenta con 1 piscina descubierta, bar - cafetería, cancha de tenis, de boley y de futbol, cuarto de juegos , área de recreación, etc. Estacionamiento para todas las unidades.\r\n', 'app/img/residencias/residencia3.jpg', 10, 0, 'Jorge Hernandez', 1066, 'Mar Del Plata', 'Buenos Aires'),
(4, 'Club Cariló Playa', 'El complejo cuenta con un clubhouse, una sala para leer, un solarium, piscina exterior y cubierta, gimnasio, sauna, acceso directo a la playa y WI-FI. El condominio está formado por 4 edificios con departamentos de 1, 2 y 3 ambientes totalmente equipados con parrillas y balcones individuales. Dichos departamentos tienen una capacidad de 2 a 7 personas, con vista al mar y al bosque. Desarrollados en un amplio parque con salida exclusiva a la playa.             ', 'app/img/residencias/residencia4.jpg', 15, 0, 'Avutarda', 2909, 'Cariló', 'Buenos Aires');

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
  `id_estadia` int(10) UNSIGNED NOT NULL,
  `monto` int(10) NOT NULL,
  `monto_actual` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `subastas`
--

INSERT INTO `subastas` (`id`, `fecha_inicio`, `fecha_fin`, `estado`, `usuario_ganador`, `id_estadia`, `monto`, `monto_actual`) VALUES
(7, '0000-00-00', '0000-00-00', 0, ' ', 2, 5000, 5000);

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
  `estado_logico` tinyint(1) NOT NULL DEFAULT '0',
  `token` varchar(10) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `email`, `password`, `nombre`, `apellido`, `fecha_nacimiento`, `foto`, `telefono`, `creditos`, `marca_tarjeta`, `numero_tarjeta`, `titular_tarjeta`, `fecha_vencimiento_tarjeta`, `rol`, `estado_logico`, `token`) VALUES
(1, 'admin@homeswitchhome.com', 'admin1234', 'Administrador', 'Administrador', '0000-00-00', NULL, '111', 0, 'no corresponde', 'no corresponde', 'no corresponde', '0000-00-00', 'ADMINISTRADOR', 0, '123456'),
(2, 'loren@mail.com', 'loren1234', 'Lorenzo', 'Repetto', '1994-04-28', 'app/img/usuarios/user.png', '452710', 1, 'VISA', '444', 'Lorenzo Repetto', '2021-08-16', 'ESTANDAR', 0, NULL),
(3, 'prueba@mail.com', 'prueba1234', 'Prueba', 'SubirUsuario', '1992-04-18', '', '11111', 2, 'AAA', '111', '', '1/2020', 'ESTANDAR', 0, NULL),
(4, 'asdasdasd@asdas.asd', 'asdasdasd', 'asdasdas', 'asdasdasd', '2000-04-05', '', 'asdasd', 2, 'asdasdas', 'asdad', '', 'asdasd', 'ESTANDAR', 0, NULL),
(5, 'pieri@mail.com', 'pieri1234', 'Pierina', 'Tufillaro', '1999-01-13', '', '411872', 2, 'VISA', '1111', '', '13/2022', 'ESTANDAR', 0, NULL),
(6, 'jorge@gmail.com', 'jorge1234', 'Jorge', 'Paulos', '1980-04-13', 'app/img/usuarios/jorge.jpg', '0113751314', 2, 'MASTERCARD', '8254435411', '', '04/2022', 'ESTANDAR', 0, NULL),
(7, 'julia@gmail.com', 'julia1234', 'Julia', 'Rosales', '1990-09-04', 'app/img/usuarios/julia.jpg', '0113441586', 2, 'VISA', '512497543', '', '04/2022', 'ESTANDAR', 0, NULL);

--
-- Índices para tablas volcadas
--

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
-- Indices de la tabla `pujas`
--
ALTER TABLE `pujas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `reservas`
--
ALTER TABLE `reservas`
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
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `estadias`
--
ALTER TABLE `estadias`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `hotsales`
--
ALTER TABLE `hotsales`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pujas`
--
ALTER TABLE `pujas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `reservas`
--
ALTER TABLE `reservas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `residencias`
--
ALTER TABLE `residencias`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `subastas`
--
ALTER TABLE `subastas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
