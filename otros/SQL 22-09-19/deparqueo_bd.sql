-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-09-2019 a las 17:05:53
-- Versión del servidor: 5.7.14
-- Versión de PHP: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `deparqueo_bd`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `accesocaja`
--

CREATE TABLE `accesocaja` (
  `caja` int(11) NOT NULL,
  `usuario` int(11) NOT NULL,
  `fechainicio` datetime NOT NULL,
  `fechacierre` datetime DEFAULT NULL,
  `totalrecibido` decimal(8,0) DEFAULT NULL COMMENT 'Almacena el total de la caja al momento del cierre',
  `totalcierre` decimal(8,0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `accesocaja`
--

INSERT INTO `accesocaja` (`caja`, `usuario`, `fechainicio`, `fechacierre`, `totalrecibido`, `totalcierre`) VALUES
(1, 3, '2019-06-30 17:11:05', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `caja`
--

CREATE TABLE `caja` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `caja`
--

INSERT INTO `caja` (`id`, `descripcion`) VALUES
(1, 'CAJA 1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `id` int(11) NOT NULL,
  `documento` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fechanacimiento` date DEFAULT NULL,
  `direccion` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `telefono` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `tipocliente` int(11) DEFAULT NULL COMMENT 'Almacena informaci?n de los tipos de clientes',
  `usuario` int(11) DEFAULT NULL COMMENT 'Almacena el id del usuario que registro al cliente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`id`, `documento`, `nombre`, `fechanacimiento`, `direccion`, `telefono`, `email`, `tipocliente`, `usuario`) VALUES
(1, '1091661138', 'YAN ANGARITA', '2019-06-05', 'Av Calle', '3166760041', 'yan@gmail.com', 1, 1),
(2, '1091657040', 'LORENA GARCIA', '2019-06-07', 'CALLE 11AN # 11AE-68', '572326722', 'lore@gmail.com', 2, 2),
(3, '37317569', 'CARLOS RENE ANGARITA', '1984-06-08', 'CUCUTA', '3138776936', 'crangarita@gmail.com', 1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingreso`
--

CREATE TABLE `ingreso` (
  `id` int(11) NOT NULL,
  `tipo` int(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `fechaingreso` datetime DEFAULT NULL,
  `fechasalida` datetime DEFAULT NULL,
  `numero` varchar(12) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Almacena el numero o identificacion del ticket para el codigo de barra'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Almacena la informaci?n de los ingresos al uso del parqueadero por parte de los vehiculos.';

--
-- Volcado de datos para la tabla `ingreso`
--

INSERT INTO `ingreso` (`id`, `tipo`, `fecha`, `fechaingreso`, `fechasalida`, `numero`) VALUES
(2, 1, NULL, '2019-06-20 19:43:22', NULL, '463'),
(3, 1, NULL, '2019-06-19 21:43:27', NULL, '824'),
(4, 1, NULL, '2019-06-19 21:44:03', NULL, '736'),
(5, 1, NULL, '2019-06-19 21:44:34', NULL, '731'),
(6, 1, NULL, '2019-06-19 21:45:04', NULL, '759'),
(7, 2, NULL, '2019-06-19 21:46:32', NULL, '206'),
(8, 2, NULL, '2019-06-19 21:58:37', '2019-06-24 18:56:10', '689'),
(9, 1, NULL, '2019-06-22 22:08:09', NULL, NULL),
(10, 1, NULL, '2019-06-22 22:08:47', '2019-06-30 19:54:03', NULL),
(11, 1, NULL, '2019-06-24 11:22:56', '2019-06-24 11:42:45', '812'),
(12, 1, NULL, '2019-06-30 12:58:06', '2019-06-30 19:41:56', '547'),
(13, 1, NULL, '2019-07-17 18:20:44', NULL, '712'),
(14, 1, NULL, '2019-08-29 20:00:54', NULL, '932'),
(15, 3, NULL, '2019-08-28 22:29:53', '2019-08-28 22:44:05', '127'),
(16, 1, NULL, '2019-08-28 22:14:58', NULL, 'AUT290819002'),
(24, 3, '2019-08-29', '2019-08-29 22:35:15', NULL, 'BIC290819001'),
(25, 2, '2019-08-29', '2019-08-29 22:35:25', NULL, 'MOT290819002'),
(26, 1, '2019-08-29', '2019-08-29 22:35:28', NULL, 'AUT290819003'),
(27, 1, '2019-08-30', '2019-08-30 20:23:03', NULL, 'AUT300819001'),
(28, 2, '2019-08-30', '2019-08-30 21:57:15', '2019-08-30 22:48:44', 'MOT300819002'),
(29, 1, '2019-08-30', '2019-08-30 22:31:33', NULL, 'AUT300819003'),
(30, 1, '2019-08-30', '2019-08-30 22:31:43', NULL, 'AUT300819004'),
(35, 1, '2019-08-31', '2019-08-31 11:48:44', '2019-08-31 11:55:40', NULL),
(36, 1, '2019-08-31', '2019-08-31 11:48:54', '2019-08-31 11:55:55', NULL),
(37, 2, '2019-08-31', '2019-08-31 11:49:11', '2019-08-31 11:59:43', 'MOT310819003'),
(38, 1, '2019-08-31', '2019-08-31 11:49:22', '2019-08-31 11:59:59', 'AUT310819004'),
(39, 1, '2019-08-31', '2019-08-31 12:47:23', NULL, 'AUT310819005'),
(40, 1, '2019-08-31', '2019-08-31 13:07:19', '2019-08-31 13:59:03', NULL),
(41, 1, '2019-08-31', '2019-08-31 13:19:37', NULL, 'AUT310819007'),
(42, 1, '2019-08-31', '2019-08-31 13:22:12', NULL, 'AUT310819008'),
(43, 1, '2019-08-31', '2019-08-31 13:22:52', NULL, 'AUT310819009'),
(44, 1, '2019-08-31', '2019-08-31 13:29:19', '2019-09-03 00:00:00', NULL),
(45, 1, '2019-08-31', '2019-08-31 13:32:38', '2019-08-31 14:12:21', NULL),
(46, 1, '2019-08-31', '2019-08-31 13:36:35', NULL, 'AUT310819012'),
(47, 1, '2019-08-31', '2019-08-31 13:40:29', NULL, 'AUT310819013'),
(48, 2, '2019-08-31', '2019-08-31 13:56:38', NULL, 'MOT310819014'),
(49, 1, '2019-08-31', '2019-08-31 14:02:41', '2019-08-31 14:02:57', NULL),
(50, 1, '2019-08-31', '2019-08-31 15:55:30', NULL, 'AUT310819016'),
(51, 1, '2019-09-04', '2019-09-04 15:05:48', NULL, 'AUT040919001'),
(52, 2, '2019-09-04', '2019-09-04 15:05:50', NULL, 'MOT040919002'),
(53, 3, '2019-09-04', '2019-09-04 15:05:53', NULL, 'BIC040919003'),
(54, 1, '2019-09-04', '2019-09-04 15:05:55', NULL, 'AUT040919004'),
(55, 2, '2019-09-04', '2019-09-04 15:05:57', NULL, 'MOT040919005'),
(56, 3, '2019-09-04', '2019-09-04 15:06:01', NULL, 'BIC040919006'),
(57, 1, '2019-09-04', '2019-09-04 16:39:43', '2019-09-10 00:00:00', NULL),
(58, 1, '2019-09-05', '2019-09-05 07:33:25', NULL, 'AUT050919001'),
(59, 2, '2019-09-05', '2019-09-05 07:33:27', NULL, 'MOT050919002'),
(60, 3, '2019-09-05', '2019-09-05 07:33:29', NULL, 'BIC050919003'),
(61, 1, '2019-09-13', '2019-09-13 21:14:23', NULL, 'AUT130919001'),
(62, 2, '2019-09-13', '2019-09-13 21:14:26', NULL, 'MOT130919002'),
(63, 3, '2019-09-13', '2019-09-13 21:14:28', NULL, 'BIC130919003'),
(64, 2, '2019-09-13', '2019-09-13 21:14:31', NULL, 'MOT130919004'),
(65, 1, '2019-09-13', '2019-09-13 21:14:33', NULL, 'AUT130919005'),
(66, 1, '2019-09-14', '2019-09-14 07:12:06', NULL, 'AUT140919001'),
(67, 2, '2019-09-14', '2019-09-14 07:12:08', NULL, 'MOT140919002'),
(68, 1, '2019-09-15', '2019-09-15 19:37:33', NULL, 'AUT150919001'),
(69, 2, '2019-09-15', '2019-09-15 19:37:40', NULL, 'MOT150919002'),
(70, 3, '2019-09-15', '2019-09-15 19:37:42', NULL, 'BIC150919003'),
(71, 1, '2019-09-17', '2019-09-17 21:50:28', '2019-09-17 21:55:30', NULL),
(72, 1, '2019-09-17', '2019-09-17 21:55:44', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingresocancelado`
--

CREATE TABLE `ingresocancelado` (
  `id` int(11) NOT NULL,
  `ingreso` int(11) DEFAULT NULL,
  `observacion` varchar(300) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `usuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Almacena la información de los ingresos cancelados';

--
-- Volcado de datos para la tabla `ingresocancelado`
--

INSERT INTO `ingresocancelado` (`id`, `ingreso`, `observacion`, `fecha`, `usuario`) VALUES
(1, 60, 'PRUEBA DE CANCELACION', '2019-09-05 10:32:02', 2),
(2, 62, 'anulacion', '2019-09-13 21:36:04', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingresonormal`
--

CREATE TABLE `ingresonormal` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `ingresonormal`
--

INSERT INTO `ingresonormal` (`id`) VALUES
(2),
(3),
(4),
(5),
(6),
(7),
(8),
(11),
(12),
(13),
(14),
(15),
(16),
(24),
(25),
(26),
(27),
(28),
(29),
(30),
(37),
(38),
(39),
(41),
(42),
(43),
(46),
(47),
(48),
(50),
(51),
(52),
(53),
(54),
(55),
(56),
(58),
(59),
(60),
(61),
(62),
(63),
(64),
(65),
(66),
(67),
(68),
(69),
(70);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingresotarjeta`
--

CREATE TABLE `ingresotarjeta` (
  `id` int(11) NOT NULL,
  `tarjeta` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `ingresotarjeta`
--

INSERT INTO `ingresotarjeta` (`id`, `tarjeta`) VALUES
(35, '1'),
(44, '1'),
(57, '1'),
(71, '1'),
(40, '1508271901'),
(49, '1508271901'),
(36, '2'),
(45, '2'),
(72, '3');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nopagoservicio`
--

CREATE TABLE `nopagoservicio` (
  `id` int(11) NOT NULL,
  `ingreso` int(11) DEFAULT NULL,
  `observacion` varchar(300) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `usuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Almacena la información de los pagos de servicios no cobrados';

--
-- Volcado de datos para la tabla `nopagoservicio`
--

INSERT INTO `nopagoservicio` (`id`, `ingreso`, `observacion`, `fecha`, `usuario`) VALUES
(7, 27, 'Prueba de No Pago', '2019-08-30 21:04:45', 2),
(8, 51, 'Prueba de No Pago y tabla...', '2019-09-04 17:10:35', 2),
(9, 59, 'NO PAGAR', '2019-09-05 07:44:51', 2),
(10, 61, 'PRUEBA PASE DE CORTESIA', '2019-09-13 21:35:22', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pago`
--

CREATE TABLE `pago` (
  `id` int(11) NOT NULL,
  `fecha` datetime DEFAULT NULL,
  `valor` decimal(8,0) DEFAULT NULL,
  `ingreso` int(11) DEFAULT NULL,
  `entrego` decimal(8,0) DEFAULT NULL,
  `cambio` decimal(8,0) DEFAULT NULL,
  `iva` decimal(8,0) DEFAULT NULL,
  `usuario` int(11) DEFAULT NULL,
  `caja` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Almacena la informaci?n de los pagos del ingreso';

--
-- Volcado de datos para la tabla `pago`
--

INSERT INTO `pago` (`id`, `fecha`, `valor`, `ingreso`, `entrego`, `cambio`, `iva`, `usuario`, `caja`) VALUES
(2, '2019-06-22 07:55:58', '2000', 2, NULL, NULL, NULL, 3, 1),
(3, '2019-06-24 11:42:03', '2000', 11, NULL, NULL, NULL, 3, 1),
(4, '2019-06-24 11:42:09', '2000', 11, NULL, NULL, NULL, 3, 1),
(5, '2019-06-24 11:42:45', '2000', 11, NULL, NULL, NULL, 3, 1),
(6, '2019-06-30 15:16:33', '10000', 12, NULL, NULL, NULL, 3, 1),
(7, '2019-06-30 16:11:30', '120000', NULL, NULL, NULL, NULL, 3, 1),
(8, '2019-08-28 22:03:03', '9000', 14, NULL, NULL, NULL, 3, 1),
(9, '2019-08-28 22:42:29', '500', 15, NULL, NULL, NULL, 3, 1),
(10, '2019-08-30 22:48:30', '2000', 28, NULL, NULL, NULL, 3, 1),
(11, '2019-08-31 11:57:35', '500', 37, NULL, NULL, NULL, 3, 1),
(12, '2019-08-31 11:59:31', '1000', 38, NULL, NULL, NULL, 3, 1),
(13, '2019-08-31 13:04:09', '2000', 39, NULL, NULL, NULL, 3, 1),
(14, '2019-09-05 07:41:22', '1000', 58, NULL, NULL, NULL, 3, 1),
(15, '2019-09-14 08:21:12', '5000', 66, NULL, NULL, NULL, 3, 1),
(16, '2019-09-15 20:09:00', '2952', 68, '5000', '2000', '48', 3, 1),
(17, '2019-09-15 20:33:50', '1680', 69, '10000', '8000', '320', 3, 1),
(18, '2019-09-17 21:00:17', '100800', NULL, '150000', '30000', '19200', 3, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagomensual`
--

CREATE TABLE `pagomensual` (
  `id` int(11) NOT NULL,
  `tarjeta` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `valor` decimal(10,0) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `fecharegistro` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `pagomensual`
--

INSERT INTO `pagomensual` (`id`, `tarjeta`, `valor`, `fecha`, `fecharegistro`) VALUES
(7, '1', '120000', '2019-06-30', '2019-06-30 16:11:30'),
(18, '1', '120000', '2019-09-17', '2019-09-17 21:00:17');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagoservicio`
--

CREATE TABLE `pagoservicio` (
  `id` int(11) NOT NULL,
  `ingreso` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `pagoservicio`
--

INSERT INTO `pagoservicio` (`id`, `ingreso`) VALUES
(2, 2),
(3, 11),
(4, 11),
(5, 11),
(6, 12),
(8, 14),
(9, 15),
(10, 28),
(11, 37),
(12, 38),
(13, 39),
(14, 58),
(15, 66),
(16, 68),
(17, 69);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id`, `descripcion`) VALUES
(1, 'ADMINISTRADOR'),
(2, 'AUXILIAR'),
(3, 'CAJERO'),
(4, 'PORTERO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tarifa`
--

CREATE TABLE `tarifa` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fechainicio` date DEFAULT NULL,
  `fechafin` date DEFAULT NULL,
  `valor` decimal(9,0) DEFAULT NULL,
  `tipovehiculo` int(11) DEFAULT NULL,
  `tipotarifa` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Almacena la informaci?n de las tarifas por el uso del servicio de parqueader de los distintos tipos de vehiculo';

--
-- Volcado de datos para la tabla `tarifa`
--

INSERT INTO `tarifa` (`id`, `descripcion`, `fechainicio`, `fechafin`, `valor`, `tipovehiculo`, `tipotarifa`) VALUES
(1, 'CARRO HORA', '2019-01-01', '2019-12-31', '4000', 1, 1),
(2, 'CARRO FRACCION', '2019-01-01', '2019-12-31', '1000', 1, 2),
(3, 'CARRO MENSUAL OITI', '2019-01-01', '2019-12-31', '120000', 1, 3),
(4, 'MOTO FRACCION', '2019-08-01', '2019-12-31', '500', 2, 2),
(5, 'MOTO HORA', '2019-08-01', '2019-12-31', '1000', 2, 1),
(6, 'MOTO MENSUAL OITI', '2019-08-01', '2019-12-31', '30000', 2, 3),
(7, 'BICICLETA FRACCION', '2019-08-01', '2019-12-31', '500', 3, 2),
(8, 'BICICLETA HORA', '2019-08-01', '2019-12-31', '1000', 3, 1),
(9, 'BICICLETA MENSUAL', '2019-08-01', '2019-12-31', '20000', 3, 3),
(10, 'MOTO MENSUAL EXTERNO', '2019-09-01', '2019-09-30', '50000', 2, 5),
(11, 'CARRO MENSUAL EXTERNO', '2019-09-01', '2019-09-30', '180000', 1, 5),
(12, 'PERDIDA TICKET', '2019-09-01', '2019-09-30', '5000', 1, 4),
(13, 'PERDIDA TARJETA', '2019-09-01', '2019-09-30', '10000', 1, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tarjeta`
--

CREATE TABLE `tarjeta` (
  `rfid` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `estado` int(11) DEFAULT NULL,
  `fechainicio` date DEFAULT NULL,
  `fechafin` date DEFAULT NULL,
  `usuarioactivo` int(11) DEFAULT NULL,
  `cliente` int(11) DEFAULT NULL,
  `tipovehiculo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tarjeta`
--

INSERT INTO `tarjeta` (`rfid`, `estado`, `fechainicio`, `fechafin`, `usuarioactivo`, `cliente`, `tipovehiculo`) VALUES
('1', 1, '2019-01-09', '2019-02-05', 2, 1, 1),
('1508271901', 1, '2019-08-01', '2019-12-31', 2, 3, 1),
('2', 1, '2019-01-06', '2019-04-06', 2, 2, 1),
('3', 1, '2019-09-04', '2019-09-27', 2, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipocliente`
--

CREATE TABLE `tipocliente` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tipocliente`
--

INSERT INTO `tipocliente` (`id`, `descripcion`) VALUES
(1, 'CLIENTE OITI'),
(2, 'CLIENTE EXTERNO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipotarifa`
--

CREATE TABLE `tipotarifa` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Almacena los distintos tipos de tarifas que hay';

--
-- Volcado de datos para la tabla `tipotarifa`
--

INSERT INTO `tipotarifa` (`id`, `descripcion`) VALUES
(1, 'TARIFA POR HORA'),
(2, 'TARIFA POR FRACCION'),
(3, 'TARIFA MENSUAL OITI'),
(4, 'TARIFA SANCION'),
(5, 'TARIFA MENSUAL EXTERNO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipovehiculo`
--

CREATE TABLE `tipovehiculo` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `resumen` varchar(3) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Almacena la informaci?n del tipo de vehiculo que puede ingresar al parqueadero';

--
-- Volcado de datos para la tabla `tipovehiculo`
--

INSERT INTO `tipovehiculo` (`id`, `descripcion`, `resumen`) VALUES
(1, 'AUTOMOVIL', 'AUT'),
(2, 'MOTOCICLETA', 'MOT'),
(3, 'BICICLETA', 'BIC');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `usuario` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `clave` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `rfid` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `documento` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fechanacimiento` date DEFAULT NULL,
  `rol` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Almacena la informaci?n del usuario';

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `usuario`, `clave`, `rfid`, `email`, `nombre`, `documento`, `fechanacimiento`, `rol`) VALUES
(1, 'admin', '54fe09b530a7abf6d9aff98c623be922185c7568', '', 'admin@deparqueo.co', 'Administrador', '123456', '2019-05-01', 1),
(2, 'auxiliar', '54fe09b530a7abf6d9aff98c623be922185c7568', '', 'auxiliar@deparqueo.co', 'Auxiliar', '123456', '2019-06-17', 2),
(3, 'caja', '7b78d2321e160fa16a08c12f92acd70764b8a295', '', 'caja@deparqueo.co', 'Caja', '123456', '2019-06-17', 3),
(4, 'puerta', '54fe09b530a7abf6d9aff98c623be922185c7568', '1508271901', 'puerta@deparqueo.co', 'Puerta', '123456', '2019-06-17', 4),
(5, 'prueba', '54fe09b530a7abf6d9aff98c623be922185c7568', NULL, 'lore@gmail.com', 'dsads', '120332432', '2019-09-13', 3);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `accesocaja`
--
ALTER TABLE `accesocaja`
  ADD PRIMARY KEY (`caja`,`usuario`,`fechainicio`),
  ADD KEY `IXFK_accesocaja_caja` (`caja`),
  ADD KEY `IXFK_accesocaja_usuario` (`usuario`);

--
-- Indices de la tabla `caja`
--
ALTER TABLE `caja`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IXFK_cliente_tipocliente` (`tipocliente`),
  ADD KEY `IXFK_cliente_usuario` (`usuario`);

--
-- Indices de la tabla `ingreso`
--
ALTER TABLE `ingreso`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IXFK_ingreso_tipovehiculo` (`tipo`);

--
-- Indices de la tabla `ingresocancelado`
--
ALTER TABLE `ingresocancelado`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_ingresocancelado_ingresonormal` (`ingreso`),
  ADD KEY `FK_ingresocancelado_usuario` (`usuario`);

--
-- Indices de la tabla `ingresonormal`
--
ALTER TABLE `ingresonormal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IXFK_ingresonormal_ingreso` (`id`);

--
-- Indices de la tabla `ingresotarjeta`
--
ALTER TABLE `ingresotarjeta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IXFK_ingresotarjeta_ingreso` (`id`),
  ADD KEY `IXFK_ingresotarjeta_tarjeta` (`tarjeta`);

--
-- Indices de la tabla `nopagoservicio`
--
ALTER TABLE `nopagoservicio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_nopagoservicio_ingresonormal` (`ingreso`),
  ADD KEY `FK_nopagoservicio_usuario` (`usuario`);

--
-- Indices de la tabla `pago`
--
ALTER TABLE `pago`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IXFK_pago_caja` (`caja`),
  ADD KEY `IXFK_pago_ingresonormal` (`ingreso`),
  ADD KEY `IXFK_pago_usuario` (`usuario`);

--
-- Indices de la tabla `pagomensual`
--
ALTER TABLE `pagomensual`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IXFK_pagomensual_pago` (`id`),
  ADD KEY `IXFK_pagomensual_tarjeta` (`tarjeta`);

--
-- Indices de la tabla `pagoservicio`
--
ALTER TABLE `pagoservicio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IXFK_pagoservicio_ingresonormal` (`ingreso`),
  ADD KEY `IXFK_pagoservicio_pago` (`id`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tarifa`
--
ALTER TABLE `tarifa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IXFK_tarifa_tipotarifa` (`tipotarifa`),
  ADD KEY `IXFK_tarifa_tipovehiculo` (`tipovehiculo`);

--
-- Indices de la tabla `tarjeta`
--
ALTER TABLE `tarjeta`
  ADD PRIMARY KEY (`rfid`),
  ADD KEY `IXFK_tarjeta_cliente` (`cliente`),
  ADD KEY `IXFK_tarjeta_tipovehiculo` (`tipovehiculo`),
  ADD KEY `IXFK_tarjeta_usuario` (`usuarioactivo`);

--
-- Indices de la tabla `tipocliente`
--
ALTER TABLE `tipocliente`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipotarifa`
--
ALTER TABLE `tipotarifa`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipovehiculo`
--
ALTER TABLE `tipovehiculo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IXFK_usuario_rol` (`rol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `caja`
--
ALTER TABLE `caja`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `ingreso`
--
ALTER TABLE `ingreso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;
--
-- AUTO_INCREMENT de la tabla `ingresocancelado`
--
ALTER TABLE `ingresocancelado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `nopagoservicio`
--
ALTER TABLE `nopagoservicio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT de la tabla `pago`
--
ALTER TABLE `pago`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `tarifa`
--
ALTER TABLE `tarifa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT de la tabla `tipocliente`
--
ALTER TABLE `tipocliente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `tipotarifa`
--
ALTER TABLE `tipotarifa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `tipovehiculo`
--
ALTER TABLE `tipovehiculo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `accesocaja`
--
ALTER TABLE `accesocaja`
  ADD CONSTRAINT `FK_accesocaja_caja` FOREIGN KEY (`caja`) REFERENCES `caja` (`id`),
  ADD CONSTRAINT `FK_accesocaja_usuario` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD CONSTRAINT `FK_cliente_tipocliente` FOREIGN KEY (`tipocliente`) REFERENCES `tipocliente` (`id`),
  ADD CONSTRAINT `FK_cliente_usuario` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `ingreso`
--
ALTER TABLE `ingreso`
  ADD CONSTRAINT `FK_ingreso_tipovehiculo` FOREIGN KEY (`tipo`) REFERENCES `tipovehiculo` (`id`);

--
-- Filtros para la tabla `ingresocancelado`
--
ALTER TABLE `ingresocancelado`
  ADD CONSTRAINT `FK_ingresocancelado_ingresonormal` FOREIGN KEY (`ingreso`) REFERENCES `ingresonormal` (`id`),
  ADD CONSTRAINT `FK_ingresocancelado_usuario` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `ingresonormal`
--
ALTER TABLE `ingresonormal`
  ADD CONSTRAINT `FK_ingresonormal_ingreso` FOREIGN KEY (`id`) REFERENCES `ingreso` (`id`);

--
-- Filtros para la tabla `ingresotarjeta`
--
ALTER TABLE `ingresotarjeta`
  ADD CONSTRAINT `FK_ingresotarjeta_ingreso` FOREIGN KEY (`id`) REFERENCES `ingreso` (`id`),
  ADD CONSTRAINT `FK_ingresotarjeta_tarjeta` FOREIGN KEY (`tarjeta`) REFERENCES `tarjeta` (`rfid`);

--
-- Filtros para la tabla `nopagoservicio`
--
ALTER TABLE `nopagoservicio`
  ADD CONSTRAINT `FK_nopagoservicio_ingresonormal` FOREIGN KEY (`ingreso`) REFERENCES `ingresonormal` (`id`),
  ADD CONSTRAINT `FK_nopagoservicio_usuario` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `pago`
--
ALTER TABLE `pago`
  ADD CONSTRAINT `FK_pago_caja` FOREIGN KEY (`caja`) REFERENCES `caja` (`id`),
  ADD CONSTRAINT `FK_pago_usuario` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `pagomensual`
--
ALTER TABLE `pagomensual`
  ADD CONSTRAINT `FK_pagomensual_pago` FOREIGN KEY (`id`) REFERENCES `pago` (`id`),
  ADD CONSTRAINT `FK_pagomensual_tarjeta` FOREIGN KEY (`tarjeta`) REFERENCES `tarjeta` (`rfid`);

--
-- Filtros para la tabla `pagoservicio`
--
ALTER TABLE `pagoservicio`
  ADD CONSTRAINT `FK_pagoservicio_ingresonormal` FOREIGN KEY (`ingreso`) REFERENCES `ingresonormal` (`id`),
  ADD CONSTRAINT `FK_pagoservicio_pago` FOREIGN KEY (`id`) REFERENCES `pago` (`id`);

--
-- Filtros para la tabla `tarifa`
--
ALTER TABLE `tarifa`
  ADD CONSTRAINT `FK_tarifa_tipotarifa` FOREIGN KEY (`tipotarifa`) REFERENCES `tipotarifa` (`id`),
  ADD CONSTRAINT `FK_tarifa_tipovehiculo` FOREIGN KEY (`tipovehiculo`) REFERENCES `tipovehiculo` (`id`);

--
-- Filtros para la tabla `tarjeta`
--
ALTER TABLE `tarjeta`
  ADD CONSTRAINT `FK_tarjeta_cliente` FOREIGN KEY (`cliente`) REFERENCES `cliente` (`id`),
  ADD CONSTRAINT `FK_tarjeta_tipovehiculo` FOREIGN KEY (`tipovehiculo`) REFERENCES `tipovehiculo` (`id`),
  ADD CONSTRAINT `FK_tarjeta_usuario` FOREIGN KEY (`usuarioactivo`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `FK_usuario_rol` FOREIGN KEY (`rol`) REFERENCES `rol` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
