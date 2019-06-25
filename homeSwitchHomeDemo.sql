-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 25-06-2019 a las 19:03:04
-- Versión del servidor: 10.1.40-MariaDB
-- Versión de PHP: 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `homeSwitchHomeDemo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estadias`
--

CREATE TABLE `estadias` (
  `id` int(10) UNSIGNED NOT NULL,
  `estado` varchar(20) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'LIBRE',
  `id_residencia` int(10) UNSIGNED NOT NULL,
  `semana` int(2) NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `estadias`
--

INSERT INTO `estadias` (`id`, `estado`, `id_residencia`, `semana`, `fecha`) VALUES
(11, 'LIBRE', 1, 33, '2019-08-15'),
(14, 'LIBRE', 1, 5, '2020-01-30'),
(15, 'SUBASTA', 2, 52, '2019-12-25'),
(16, 'LIBRE', 2, 2, '2020-01-10'),
(18, 'LIBRE', 3, 7, '2020-02-15'),
(19, 'LIBRE', 1, 23, '2020-06-04'),
(20, 'LIBRE', 6, 33, '2019-08-18'),
(21, 'SUBASTA', 3, 21, '2020-05-19'),
(22, 'SUBASTA', 7, 52, '2019-12-25'),
(23, 'SUBASTA', 8, 52, '2019-12-25'),
(24, 'SUBASTA', 9, 52, '2019-12-25'),
(25, 'LIBRE', 6, 4, '2020-01-20'),
(26, 'LIBRE', 6, 6, '2020-02-05'),
(27, 'LIBRE', 6, 10, '2020-03-02'),
(28, 'LIBRE', 7, 7, '2020-02-12'),
(29, 'LIBRE', 7, 4, '2020-01-24'),
(30, 'SUBASTA', 7, 3, '2020-01-15'),
(31, 'SUBASTA', 3, 52, '2019-12-25');

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

--
-- Volcado de datos para la tabla `pujas`
--

INSERT INTO `pujas` (`id`, `id_usuario`, `id_subasta`, `monto_apostado`) VALUES
(1, 2, 4, 2100),
(2, 7, 4, 2500),
(3, 14, 5, 4000),
(4, 13, 5, 4500),
(5, 13, 6, 1900),
(7, 5, 6, 2000),
(8, 13, 6, 2100);

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
(4, 'Club Cariló Playa', 'El complejo cuenta con un clubhouse, una sala para leer, un solarium, piscina exterior y cubierta, gimnasio, sauna, acceso directo a la playa y WI-FI. El condominio está formado por 4 edificios con departamentos de 1, 2 y 3 ambientes totalmente equipados con parrillas y balcones individuales. Dichos departamentos tienen una capacidad de 2 a 7 personas, con vista al mar y al bosque. Desarrollados en un amplio parque con salida exclusiva a la playa.             ', 'app/img/residencias/residencia4.jpg', 15, 0, 'Avutarda', 2909, 'Cariló', 'Buenos Aires'),
(6, 'Bahía Manzano', 'Unidades con vista al lago. Limpieza diaria. Piscina climatizada y solárium (octubre a abril). Costa de lago con playa. Fitness center: Gym, sauna y ducha escocesa. Masajes (con costo adicional). Play room. Rinconcito Infantil (niños 3 a 5 años que no usen pañales). ', 'app/img/residencias/bahiamanzano.jpg', 10, 0, 'Ruta Nacional', 231, 'Villa La Angostura', 'Neuquén'),
(7, 'Bahía Montaña', '3 piscinas climatizadas: un gimnasio cerrado y 2 piscinas descubiertas con solarium. Spa con Jacuzzi, ducha escocesa y sauna. Sala de masajes (de pago). Casa club y un bar con chimenea. Restaurante. Kids Club (para niños 3 a 5, que no usan pañales), tenis en polvo de ladrillo. Atraque de barcos Conexión inalámbrica a internet. Seguridad las 24 hs. En la recepción de Golf (Golf Ruca Kuyen con una tarifa preferencial). ', 'app/img/residencias/bahiamontaña.jpg', 15, 0, 'Los Lagos', 231, 'Villa La Angostura', 'Neuquén'),
(8, 'Club Hotel Dut Bariloche', '  Este desarrollo es un lugar ideal para relajarse, y tener una vacaciones apacibles y rejuvenecedoras.', 'app/img/residencias/hoteldutbariloche.jpg', 8, 0, 'Avenida Ezequiel Bustillo, Kilómetro 20.400', 1024, 'San Carlos de Bariloche', 'Río Negro'),
(9, 'Club Hotel Catedral', '  Entre las actividades que se pueden realizar, encontrará senderismo, escalada en hielo y roca, paseos a caballo, camping, canotaje, rafting, pesca y excursiones en vehículos 4x4. Durante el invierno, algunos deportes incluyen snowboard y esquí.', 'app/img/residencias/hotelcatedralbariloche.jpg', 15, 0, 'Cerro Catedral', 601, 'San Carlos de Bariloche', 'Río Negro');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subastas`
--

CREATE TABLE `subastas` (
  `id` int(10) UNSIGNED NOT NULL,
  `estado` varchar(15) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'PENDIENTE',
  `usuario_ganador` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `id_estadia` int(10) UNSIGNED NOT NULL,
  `monto` int(10) NOT NULL,
  `monto_actual` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `subastas`
--

INSERT INTO `subastas` (`id`, `estado`, `usuario_ganador`, `id_estadia`, `monto`, `monto_actual`) VALUES
(1, 'CERRADA', '', 20, 1500, 1500),
(2, 'PENDIENTE', ' ', 21, 1000, 1000),
(3, 'ACTIVA', ' ', 22, 1000, 1000),
(4, 'ACTIVA', ' ', 23, 2000, 2500),
(5, 'ACTIVA', ' ', 15, 3500, 4500),
(6, 'ACTIVA', ' ', 24, 1800, 2100),
(7, 'PENDIENTE', ' ', 30, 3000, 3000),
(8, 'ACTIVA', '', 31, 5000, 5000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tarjetas`
--

CREATE TABLE `tarjetas` (
  `id` int(50) NOT NULL,
  `marca` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `numero` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `titular` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `vencimiento` varchar(11) COLLATE utf8_spanish_ci NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `estado_logico` int(11) NOT NULL DEFAULT '0',
  `principal` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tarjetas`
--

INSERT INTO `tarjetas` (`id`, `marca`, `numero`, `titular`, `vencimiento`, `id_usuario`, `estado_logico`, `principal`) VALUES
(1, 'MASTERCARD', '4444444444444444', 'JORGE PAULOS', '12/23', 6, 0, 1),
(2, 'VISA', '8888888888888894', 'JORGE PAULOS', '05/22', 6, 0, 0);

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
  `rol` varchar(20) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'ESTANDAR',
  `estado_logico` tinyint(1) NOT NULL DEFAULT '0',
  `token` varchar(10) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha_registro` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `email`, `password`, `nombre`, `apellido`, `fecha_nacimiento`, `foto`, `telefono`, `creditos`, `rol`, `estado_logico`, `token`, `fecha_registro`) VALUES
(1, 'admin@homeswitchhome.com', 'admin1234', 'Administrador', 'Administrador', '0000-00-00', NULL, '111', 1000, 'ADMINISTRADOR', 0, '123456', '0000-00-00'),
(2, 'loren@mail.com', 'loren1234', 'Lorenzo', 'Repetto', '1994-04-28', 'app/img/usuarios/user.png', '452710', 1, 'ESTANDAR', 0, NULL, '2019-04-01'),
(5, 'pieri@mail.com', 'pieri1234', 'Pierina', 'Tufillaro', '1999-01-13', 'app/img/usuarios/user.png', '411872', 0, 'ESTANDAR', 0, NULL, '2019-02-15'),
(6, 'jorge@gmail.com', 'jorge1234', 'Jorge', 'Paulos', '1980-04-13', 'app/img/usuarios/jorge.jpg', '0113751314', 2, 'ESTANDAR', 0, NULL, '2019-05-10'),
(7, 'julia@gmail.com', 'julia1234', 'Julia', 'Rosales', '1990-09-04', 'app/img/usuarios/julia.jpg', '0113441586', 2, 'PREMIUM', 0, NULL, '2019-01-12'),
(13, 'raul@gmail.com', 'raul1234', 'Raúl', 'López', '1987-04-15', 'app/img/usuarios/raul.png', '1137881012', 0, 'ESTANDAR', 0, NULL, '2019-06-15'),
(14, 'melisa@gmail.com', 'melisa1234', 'Melisa', 'Onofri', '1999-11-05', 'app/img/usuarios/melisa.jpeg', '4586143', 2, 'ESTANDAR', 0, NULL, '2019-06-15');

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
-- Indices de la tabla `tarjetas`
--
ALTER TABLE `tarjetas`
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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `hotsales`
--
ALTER TABLE `hotsales`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pujas`
--
ALTER TABLE `pujas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `reservas`
--
ALTER TABLE `reservas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `residencias`
--
ALTER TABLE `residencias`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `subastas`
--
ALTER TABLE `subastas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `tarjetas`
--
ALTER TABLE `tarjetas`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
