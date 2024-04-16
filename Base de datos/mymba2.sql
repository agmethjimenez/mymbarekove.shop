-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 09-04-2024 a las 10:11:56
-- Versión del servidor: 8.0.31
-- Versión de PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `mymba2`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administradores`
--

CREATE TABLE `administradores` (
  `id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `token` varchar(300) COLLATE utf8mb4_general_ci NOT NULL,
  `clave` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `administradores`
--

INSERT INTO `administradores` (`id`, `username`, `email`, `token`, `clave`, `activo`) VALUES
('432534634', 'carlos567', 'carlosgo@mymba.com', 'hWAwFUEudBUJRy9X1CxgZxtuJW3BZGzBhF0ejORfX3RIvE6IhREfc8gJiqL4vebgU0TB4QzPhMrJ5rugH5Ok1A51OUOLxTmP2hpI3hsoSzwMvgrV3MeKg2fcTgmY9EQMYJKCJrjulO99bEryW2BWw0r70dUTQSMDuzO1w9wJsQhGaXLebfhQlutlWjvdRaWOElMiB0Yomw', '$2y$10$uWOFT6G7WEhqHPV63c7yiu0W0RlphP.2EL8ZY.E.1AV6oVfz0p2fG', 1),
('6571f15f04', 'jhorman43', 'jhorman@gmail.com', 'Rp1Eu4JxIkO9tIL6Pjbq77RWoAFjHBVHX8S07DWQidmSXO9VLSDmolVZ6PilosFeHrfhAyF1LJ6RXQvvohifKMhU392ZmgviqPQwIrx9xBjCTu3kKJQp01fLFbToYMQ3uyzSuld1eu2wZeuxdVthbejXSqxVzg58Jcc2Jj8tvRZF02f49SvgQsGxzAa6f4CxevREvbjLxp', '$2y$10$ItOpGi4SKkXxUAeDoVnH6u7o5kzyN/GnZAM3e6qM/KGilrPCvSuZu', 1),
('6576374227', 'test1', 'test@gmail.com', 'CbshEraJTtW4EgacaPsj13GKwlSLRqugy0Pr3eQt4PilwRkaQDbMgQw3qQtYSW9ovW5q16ERskemsLUD4OsJTAgHXUEYasP6zMgYDpdVgwKlEIOZwjHiZOkouBVJB5YOF2vP95xQSZDgoCsQOf5fkwiU7hLP4M37FQhkuGaC9XyhSHaWVdcOMxiGhzjfXj2j7uHXJQxWsM', '$2y$10$TxUefpGtxOpMr7Kndo0PQunQO9hXpo4BVihcOZ0uMJfDKrwjsmBBS', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asesores`
--

CREATE TABLE `asesores` (
  `id` int NOT NULL,
  `nombre` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `apellido` int NOT NULL,
  `especialidad` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asesoria`
--

CREATE TABLE `asesoria` (
  `id` int NOT NULL,
  `id_cliente` int NOT NULL,
  `id_asesor` int NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `categoria` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `descripcion` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`categoria`, `descripcion`) VALUES
('1', 'Aseo'),
('2', 'Alimento'),
('3', 'Juguetes'),
('4', 'Medicamentos\r\n'),
('5', 'Accesorios'),
('6', 'Higiene y Cuidado\r\n');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `credenciales`
--

CREATE TABLE `credenciales` (
  `id` int NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `token` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `codigo` int DEFAULT NULL,
  `fecha_cambio` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `activo` tinyint NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `credenciales`
--

INSERT INTO `credenciales` (`id`, `email`, `token`, `codigo`, `fecha_cambio`, `password`, `activo`) VALUES
(680, 'aurelio2000@mail.com', '2539c2c3e19d537e0603270d79171017', 9331, '2024-02-22 23:27:01', '$2y$10$TC1XEjJOGupQ1R5kVnIAce25Rf3rKf0eCIoW7.YtbBK5g/6a.FRhy', 0),
(699, 'agmeth.jimenez2005@gmail.com', '7a9d1368db0a4ae240eded377d915c9a', 6799, '2024-04-05 17:15:47', '$2y$10$ZjA3M55vNawI26DJbjvi/e/DTzc2o79PQS.AUyBIeflnOh/JIZ7Vi', 1),
(717, 'romeo@gmail.com', '953ffd0d7891c2f836c7394b846c68ca', 5982, '2024-02-29 00:55:23', '$2y$10$N2Hq/3407R/FfKH8BZMZEO3S99vJyWbY8ovDj7.nf9AzjJTsuhoAq', 1),
(718, 'joseemilio@gmail.com', '05cf516a0366d0de0df31fb274da0caf', 3249, '2024-02-29 00:56:32', '$2y$10$UFiJKM9JSfKwwCQ7mbTF5uhNdDlki55EfzCWPZxS4L.p.mj8Tr0JG', 1),
(719, 'segundon@mail.com', '651129532e967ab083a6d91ada971cbb', 1077, '2024-02-29 00:57:50', '$2y$10$j6nxmcPxJiLHbxGrsvlMbOX8lpvsVslo5oqNjPEOUWRl0wZJ8BD3y', 1),
(722, 'luan@hotmail.com', '0fb17b5a7cd94efca266b719c315460c', 5588, '2024-02-29 01:01:10', '$2y$10$bjnpAnzCbMTSitwUTjclPulT/MDZn0aYV3Cttvd/soykMpNvKMW6e', 1),
(723, 'juliandomin@gmail.com', '44ebe82e77e8f62f64558d0563dc2023', 1448, '2024-02-29 01:37:29', '$2y$10$utFj1HVG/W3cGiUR8OB9G.tu65sV7x5p.fFqJqyzriG7SrgvaUdZW', 0),
(724, 'jorge@gmail.com', 'ee28296e96313c8a0f5f4e9b2e4d5730', 2611, '2024-03-03 23:39:58', '$2y$10$Eg3MP9g87wc.kZt7ebr6a.iOEtxCOpJAG1OtkJ3.9CwmQbeS9jlGC', 1),
(725, 'john.doe@example.com', '365d3780f931e06131695d1c4591edb5', 7155, '2024-03-09 23:12:55', '$2y$10$48UMd653xWoxwaJCnD.D7.tCLN/.xVXoiuGnI3rkUSqYUkYsHrwgK', 1),
(726, 'pruebaapi@gmail.com', '42c588236b4cb899125b8cd1ff7c3aa2', 9500, '2024-03-09 23:21:21', '$2y$10$ePCGDw.SEYA8uSIkBz3S3OOhbuOjDsI.rs07j1IZ/MQg64AE/185K', 1),
(727, 'tokenprueba123@gmail.com', '127fd61660fb2a04e7cfa3939ad1b3e3', 4362, '2024-03-13 15:21:40', '$2y$10$mMFAEgWmKPUOG27TGVTo1.ZRy15J6bb0Wz2Dg5eN47EfKicLnF2l.', 1),
(728, 'nicocolas@outlook.es', '8cf53460d35ccef0dcf1ff79d5835556', 2821, '2024-03-14 00:51:11', '$2y$10$bLF/oTqKe3/vT66Hdf6Msu5PDpPdW9HO7RaacGBPJU6W8yU.Dy2BG', 0),
(729, 'enriques@outlook.es', 'e824833426bba0a27313a77f733951cf', 1702, '2024-03-14 14:29:40', '$2y$10$6E8ibKCkpXk/ZXKTstX9pe./mcESa7.ThtZrzFESETMMy/jqHLIPG', 0),
(730, 'enriques@outlook.com', 'df16cf06503ba448d4ead7f62ffdd48e', 6493, '2024-04-02 02:26:29', '$2y$10$RW3MGlLd10xuafa8MFOCPuRf1Z7nJ5o68j6cz.j9t9Z9VX6qR.ZeC', 1),
(731, 'enriques@yahoo.com', 'ce9593ea40fd14735681849cf68a3712', 3441, '2024-04-02 22:43:03', '$2y$10$cxzHPUTvApPHEglUMXpZpeQTcGP3rFjAnwUzvL4OxuJGiAdaRpgbe', 0),
(763, 'jesudeo@outlook.com', '27865e9e7890f9ab43b0d76af36ae24c', 6075, '2024-04-02 23:44:18', '$2y$10$fC//iyt0TotZmHbpczh/V.JNPxxDNUOX7Ui7qVQomFQo2FOoQyWEi', 1),
(766, 'nicocru@gmail.com', '5c3ebee7426597916db7ffb6be49ec00', 2650, '2024-04-02 23:47:35', '$2y$10$gRZL7nn4kYDQUUqL.FXI.ur0hypytA55WLMMcXNPHHuZ8RyJyvArW', 1),
(767, 'luis@gmail.com', '08976d266f59ce2087f4fc92f06957ca', 3300, '2024-04-03 00:03:31', '$2y$10$5pw6tdXCMvFb4u2v9A4HXeQ9BKgGLzQvZW1P6iRZMIY5JKgkd58Hq', 1),
(768, 'agmeth.jimenez@misena.edu.co', '9c0d5cbc91af597375257f1fbda4e8b4', 6072, '2024-04-03 00:31:14', '$2y$10$2WtFdM1AUJXfzUQ5Fa/yO.MzkucQwblLbp5sMsKB/tq7oBomWQK2e', 1),
(769, 'jujuan@gmail.com', '260910f5aab4a7de14b6702808131832', 2185, '2024-04-03 13:44:54', '$2y$10$KD3UESec5tEeXf/kIK0um.rQ.R.I3SiJbRLXhNMv4yfYvoa74vJx6', 1),
(770, 'julioromeo@outlook.com', '4f5a9789c3ee7918b54eae8929779d05', 6443, '2024-04-04 03:10:21', '$2y$10$F5z8NKVxlCUBLfns52gWBuwvB60J4K2QsTP4YU5Kw6EYihGEO5Q3W', 1),
(774, 'juntrujillo123@gmail.com', '72303e3ed3e010c818ecda1fd932a485', 3818, '2024-04-04 04:16:28', '$2y$10$iEaXBQtfEMkQXGvkD3mQiuzoZ.h7w1bL.gWtZlSvEx0llshocWti6', 0),
(775, 'lauraricaute@gmail.com', '1694fc28cd943e3eef3af9ee7ece8aca', 4479, '2024-04-04 04:18:13', '$2y$10$Se0RcRTrx1tE/G2FE.iUq.yHWGQV2uSmg8RJtF3tDPzLuO9.OSVDq', 0),
(779, 'mariojose@gmail.com', '9b78499c6eaa955c81417dedfccaefef', 6693, '2024-04-07 19:40:24', '$2y$10$Eu7xxSiFCa5PmwVNfOIgZ.rTabjh42XOQLR.QKcd4VxY8FYVrRWoi', 1),
(780, 'ezequieleduardo@gmail.com', '7aaa31a8afa682c07fcf2c5d0eb29cfe', 8734, '2024-04-09 09:33:36', '$2y$10$cP9kwHoWKd4d3WGtZj9//OUNxVD/WvNDnICZxcEaRo7xNnHRiRROW', 1),
(781, 'lauragomez@gmail.com', '98fe34e2a1eb18a1f03829ed68d3ed90', 7898, '2024-04-09 10:03:17', '$2y$10$SnwUW07LPQq6MdQEYtlEVe/mKetp0QqxzcPNz53A.tuyXAFVbgy.2', 1),
(782, 'alejandro1234@gmail.com', 'd022d6570b29484a2c817926a8188b3c', 2041, '2024-04-09 10:06:55', '$2y$10$GaVOFY.nHOY70iAd76BYleFAkS9jbvcU1KgqDaT7i70nUeDysP1jS', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallepedido`
--

CREATE TABLE `detallepedido` (
  `idPedido` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `idProducto` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `cantidad` int DEFAULT NULL,
  `total` decimal(14,0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detallepedido`
--

INSERT INTO `detallepedido` (`idPedido`, `idProducto`, `cantidad`, `total`) VALUES
('65de34b14d', '7456', 1, 55000),
('65de34b14d', '9634 ', 2, 204600),
('65e5321736', '12334', 1, 76999),
('65e5321736', '33523', 1, 16920),
('65e5321736', '5662 ', 1, 110000),
('65e5321736', '9634 ', 1, 102300),
('65ee45a6a6', '3168 ', 1, 7200),
('65ee45a6a6', '32449', 1, 28000),
('65ee45a6a6', '6435', 1, 285597),
('65ee45a6a6', '7343', 1, 3145),
('65ee45a6a6', '7456', 1, 55000),
('65ee45a6a6', '9634 ', 1, 102300),
('65f20cdf6f', '1', 1, 200000),
('65f20cdf6f', '1346', 1, 11500),
('65f20cdf6f', '3168 ', 2, 14400),
('65f20cdf6f', '32449', 8, 224000),
('65f20cdf6f', '33523', 1, 16920),
('65f20cdf6f', '4231', 2, 39998),
('65f20cdf6f', '5555', 4, 23960),
('65f20cdf6f', '9634 ', 7, 716100),
('65f30cb4c6', '1', 4, 800000),
('65f30cb4c6', '4231', 2, 39998),
('65f66c6653', '1346', 1, 11500),
('65f66c6653', '2708', 1, 3450),
('65f66c6653', '3014', 1, 19099),
('65f7128d58', '1346', 1, 11500),
('65f7128d58', '3168 ', 1, 7200),
('65f7128d58', '32449', 1, 28000),
('6608796bf4', '12334', 2, 153332),
('6608796bf4', '1346', 2, 23000),
('6608796bf4', '2708', 2, 6900),
('6608796bf4', '3014', 2, 38198),
('6608796bf4', '33523', 2, 33840),
('6608796bf4', '5555', 2, 11980),
('6608a3c368', '1', 4, 800000),
('660edef4ad', '1346', 2, 23000),
('660edef4ad', '2628', 2, 34002),
('660edef4ad', '3168 ', 2, 14400);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados`
--

CREATE TABLE `estados` (
  `codEst` int NOT NULL,
  `estado` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estados`
--

INSERT INTO `estados` (`codEst`, `estado`) VALUES
(1, 'Pagado'),
(2, 'En proceso'),
(3, 'Entregado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marcas`
--

CREATE TABLE `marcas` (
  `idMarca` int NOT NULL,
  `marca` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `marcas`
--

INSERT INTO `marcas` (`idMarca`, `marca`) VALUES
(1, 'Canisan'),
(2, 'Dog Chow'),
(3, 'Smartbones SA'),
(4, 'Royal Canin'),
(5, 'Pet Spa'),
(7, 'GANADOR PREMIUM'),
(8, 'Pedigree'),
(9, 'Basti cat'),
(10, 'QualiVet'),
(11, 'KYRA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `idPedido` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `usuario` int NOT NULL,
  `ciudad` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `direccion` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `fecha` timestamp NULL DEFAULT NULL,
  `total` decimal(15,0) NOT NULL,
  `detalles_pago` varchar(300) COLLATE utf8mb4_general_ci NOT NULL,
  `estado` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`idPedido`, `usuario`, `ciudad`, `direccion`, `fecha`, `total`, `detalles_pago`, `estado`) VALUES
('65de34b14d', 699, 'Bogota', 'Carrera 98 #2 -20 Int 20 Apto 501', '2024-02-27 19:14:57', 259600, '{\"payment_id\":\"1321396553\",\"status\":\"approved\",\"payment_type\":\"debit_card\",\"order_id\":\"16157797761\"}', 3),
('65e5321736', 699, 'Pereira', 'Transversal 42 #65 -8 ', '2024-03-04 02:29:43', 306219, '{\"payment_id\":\"1317305692\",\"status\":\"approved\",\"payment_type\":\"debit_card\",\"order_id\":\"16319447919\"}', 2),
('65ee45a6a6', 699, 'Buga', 'Carrera 88 #88 -8 ', '2024-03-10 23:43:34', 481242, '{\"payment_id\":\"1317395804\",\"status\":\"approved\",\"payment_type\":\"credit_card\",\"order_id\":\"16549402559\"}', 2),
('65f20cdf6f', 699, 'Manizales', 'Carrera 546 #5 -5 ', '2024-03-13 20:30:23', 1246878, '{\"payment_id\":\"1321782409\",\"status\":\"approved\",\"payment_type\":\"debit_card\",\"order_id\":\"16641429520\"}', 2),
('65f30cb4c6', 699, 'Buga', 'Avenida Calle 65 #56 -55 ', '2024-03-14 14:41:56', 839998, '{\"payment_id\":\"1317456668\",\"status\":\"approved\",\"payment_type\":\"credit_card\",\"order_id\":\"16655058283\"}', 2),
('65f66c6653', 699, 'Barranquilla', 'Calle 76 #90 -7 ', '2024-03-17 04:07:02', 34049, '{\"payment_id\":\"1321853505\",\"status\":\"approved\",\"payment_type\":\"account_money\",\"order_id\":\"16750985245\"}', 2),
('65f7128d58', 699, 'Barranquilla', 'Calle 76 #90 -7 ', '2024-03-17 15:55:57', 46700, '{\"payment_id\":\"1321857383\",\"status\":\"approved\",\"payment_type\":\"account_money\",\"order_id\":\"16765179224\"}', 2),
('6608796bf4', 699, 'Pereira', 'Diagonal 54 #43 -33 ', '2024-03-30 20:43:24', 267250, '{\"payment_id\":\"1322158295\",\"status\":\"approved\",\"payment_type\":\"credit_card\",\"order_id\":\"17169800860\"}', 2),
('6608a3c368', 699, 'Pereira', 'Diagonal 54 #43 -33 ', '2024-03-30 23:44:03', 800000, '{\"payment_id\":\"1317673988\",\"status\":\"approved\",\"payment_type\":\"debit_card\",\"order_id\":\"17169963551\"}', 2),
('660edef4ad', 699, 'Envigado', 'Carrera 12 #54 -34 ', '2024-04-04 17:10:12', 71402, '{\"payment_id\":\"1322217339\",\"status\":\"approved\",\"payment_type\":\"debit_card\",\"order_id\":\"17308344386\"}', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `idProducto` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `proveedor` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nombre` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `descripcionP` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `contenido` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `precio` decimal(10,0) DEFAULT NULL,
  `marca` int DEFAULT NULL,
  `categoria` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `cantidadDisponible` int NOT NULL,
  `imagen` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`idProducto`, `proveedor`, `nombre`, `descripcionP`, `contenido`, `precio`, `marca`, `categoria`, `cantidadDisponible`, `imagen`, `activo`) VALUES
('1', '3123', 'Purgante Canisan', 'Purgante para gato 100 EFECTIVOI', '2.5 ML', 200000, 1, '6', 60, 'https://i.postimg.cc/tTP2SzDz/156397-800-auto.jpg', 1),
('12334', '103', 'Artri-Vet Suplemento Alimentics', 'ARTRI-VET es un suplemento alimenticio, cuya fórmula contiene ingredientes coadyuvantes en el regeneramiento articular, especial para el tratamiento y prevención de problemas articulares y enfermedade', '60 TAB', 76666, 10, '4', 33, 'https://i.postimg.cc/Ss7cY1DH/5959459405940000013-min.jpg', 1),
('1346', '103', 'Royal Canin-SHN Starter M&B Do', 'Es especial para la salud digestiva: Resultado de la investigación de Royal Canin, start complex es una combinación exclusiva de sustancias nutricionales presentes en la leche materna, reforzada con n', '145 G', 11500, 4, '2', 47, 'https://i.postimg.cc/hvDTL8Yv/111103887-min.jpg', 1),
('2035', '104', 'Nombre del producto', 'Descripción del producto', '10 GR', 19099, 5, '2', 10, 'URL de la imagen del producto', 0),
('2628', '1068', 'Besties - Huesos Masticables Medianos Mix de Sabores', 'BESTIES huesos masticables es un suplemento alimenticio para suministrar a perros adultos de todas las razas, Mantenga suficiente agua fresca disponible para su mascota.', '5 USD', 17001, 5, '2', 175, 'https://i.postimg.cc/Vv5rcsM9/2d3e5bc54e7edd029a290fa69193397b.jpg', 1),
('2708', '102', 'Galletas Hos', 'Galletas', '200g', 3450, 5, '3', 44, 'www.imagen.jpg', 0),
('3014', '104', 'Nombre del producto', 'Descripción del producto', '10 GR', 19099, 5, '2', 10, 'URL de la imagen del producto', 0),
('3168 ', '103', 'Kyra - Alimento Completo Horneada Perro', 'Kyra - Alimento Completo Horneada Perro, es un alimento nutritivo de 500gr. Diseñado para perros de todas las edades y razas.', '500 G', 7200, 11, '2', 308, 'https://i.postimg.cc/sX02SVNh/f3ccdd27d2000e3f9255a7e3e2c48800.jpg', 1),
('32449', '102', 'Royal Canin lata gastrointesti', 'El Royal Canin Dog Lata Gastro Intestinal es un alimento para perros de alta energía, altamente digestible, apetecible, completo y equilibrado . Especies: Caninos.\r\nSeguridad Digestiva. Ayuda a manten', '385 GR', 28000, 4, '2', 45, 'https://i.postimg.cc/VNtqmkMf/00030111470713e-cf.jpg', 1),
('33523', '105', 'Basti Cat - Arena Estandar', 'Basti Cat - Arena Estandar, es un producto con una aglomeración consistente, fácil de limpiar y muy agradable para tu mascota', '4 KG', 16920, 9, '6', 76, 'https://i.postimg.cc/9FBNHJ28/68936-161035-Basti-Cat-Arena-Est.jpg', 1),
('4034', '104', 'Nombre del producto2', 'Descripción del producto2', '10 GR', 9999, 5, '2', 10, 'URL de la imagen del producto', 0),
('4231', '6656', 'prueba magica', 'Esta es una prueba de producto xdscd', '100 GR', 19999, 7, '3', 2, 'https://i.postimg.cc/3wmK6tML/guantee.avif', 0),
('42356', '242435', 'Juguete de goma', 'el mejor', '500 LB', 10000, 5, '2', 2, '', 0),
('5555', '4323', 'Comida mojada', 'comida mojada', '2LB', 5990, 10, '5', 77, 'https://i.postimg.cc/BQJMpHFx/111101967-min.jpg', 1),
('5662 ', '242435', 'Royal Canin - Mini Puppy', 'Royal Canin - Mini Puppy, es ideal para el crecimiento es una fase muy importante de la vida del perro: es una época de grandes cambios, descubrimientos y nuevos encuentros. Durante este período clave, el sistema inmunológico del cachorro se desarrolla de forma gradual. Mini puppy ayuda a reforzar las defensas naturales del cachorro gracias a un complejo patentado* de antioxidantes que incluye vitamina E. Salud digestiva: Combinación de nutrientes con proteínas de gran calidad (L.I.P.)* y prebióticos (FOS) que favorece la salud digestiva y el equilibro de la flora intestinal, contribuyendo a la calidad de las heces. *Proteína seleccionada por su elevada digestibilidad. Alto contenido energético: Responde a las necesidades energéticas de los cachorros de razas pequeñas durante el período de crecimiento y satisface los apetitos caprichosos.', '4 KG', 110000, 4, '2', 167, 'https://i.postimg.cc/RF5zYN3Z/528-173857-Royal-Canin-Mini-Pupp.jpg', 1),
('6256', '104', 'EXCELLENT PUPPY SMALL BREED X 3 KG', 'En su primer año de vida los cachorros necesitan una nutrición óptima para favorecer su desarrollo y crecimiento. PURINA® Excellent® CACHORROS POLLO Y ARROZ RAZAS PEQUEÑAS ofrece una fórmula completa y balanceada a base de proteínas de alta calidad,incluyendo tocoferoles mezclados -fuente de vitamina E- y sin colorantes ni saborizantes artiﬁciales, para garantizar la calidad nutricional de sus fórmulas y un sabor único e irresistible.', '3 KG', 69900, 7, '2', 24, 'https://i.postimg.cc/C1j4LbwW/64-400x.jpg', 1),
('6435', '242435', 'Diamond Naturals Perros Adulto', 'Diamond Naturals Perros Adultos Light es un concentrado para perros Adultos Premium elaborado con ingredientes de alta calidad para proporcionar una nutrición completa y balanceada pero con menos calo', '3 LB', 285597, 7, '2', 64, 'https://i.postimg.cc/XNfs9Qrj/111100193-ed-min.jpg', 1),
('7343', '104', 'Pedigree-SHN Starter M&B Dog W', 'Pedigree - Alimento Húmedo Para Perro Adulto Raza Pequeña Pollo Sobre, es 100% completo y balanceado. Con los nutrientes necesarios para que tu perro tenga una vida sana y feliz. Incluye comida húmeda', '100 GR', 3145, 8, '2', 20, 'https://i.postimg.cc/BQJMpHFx/111101967-min.jpg', 1),
('7456', '242435', 'Dog Chow Adultos', 'Comida con vitaminas y nutrientes para tu mascota', '8 KG', 55000, 2, '2', 35, 'https://i.postimg.cc/kGT8f6rc/dog-chow-adulto-raza-peque-a-8kg.jpg', 1),
('7463', '104', 'Nombre del producto2', 'Descripción del producto2', '10 GR', 11099, 5, '2', 10, 'URL de la imagen del producto', 1),
('8406', '102', 'Galletas Hos', 'Galletas', '200g', 3450, 5, '3', 44, 'www.imagen.jpg', 0),
('9634 ', '4323', 'Royal Canin - Mini Adult', 'Alimento seco para perros adultos pequeños formulado con una nutrición precisa hecha específicamente para perros pequeños de 10 meses a 8 años de edad que pesen entre 9 y 22 lb. Satisface las altas necesidades de energía de las razas de perros pequeños mientras ayuda a mantener un peso saludable con L-carnitina.', '2 KG', 102300, 4, '2', 200, 'https://i.postimg.cc/bvB3d5hw/459-62312-Royal-Canin-Mini-Adult.jpg', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productosagregados`
--

CREATE TABLE `productosagregados` (
  `producto` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `administrador` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `fecha_registro` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `idProveedor` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nombreP` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ciudad` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `correo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `telefono` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `estado` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'SI'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`idProveedor`, `nombreP`, `ciudad`, `correo`, `telefono`, `estado`) VALUES
('101', 'PetPro Supplies', 'Medellin', 'petpro@proveedormascotas.com', '123-4567', 'NO'),
('102', 'Animalia Pet Shop', 'Medellin', 'animalia@emailmascotas.net', '987-6543', 'NO'),
('103', 'Paws & Tails Distribuciones', 'Bogota', 'pawsntailsdistri@petmail.com', '321-7890', 'NO'),
('104', 'FurFriend Supplieses', 'Bucaramanga', 'info@furfriend-supplies.com', '555-5555', 'SI'),
('105', 'HappyPets Inc.', 'Bogota', 'info@happypets-inc.com', '234-5678', 'SI'),
('1068', 'South Desings Distribuciones', 'Quito', 'southdesing@desouth.com', '4387545', 'SI'),
('1170', 'Blass Asociacion ', 'Bogota', 'blass@gmail.com', '3434123', 'SI'),
('1542', 'Oficial Logares', 'Bogota', 'logaficial@gmail.com', '9657443', 'SI'),
('2072', 'Occidente Enterprise', 'Buenos Aires', 'ociidenteneter@occ.com', '4637843', 'SI'),
('242435', 'Foot Pet SAS', 'New Jersey', 'petfoot@fpa.usa.com', '1283726', 'SI'),
('245', 'FOO S.A', 'Bogota', 'foo.sa@gmail.com', '3143667879', 'NO'),
('3123', 'Juguetes Bogota', 'Bogota', 'juguebog@mail.com', '2346347', 'NO'),
('3582', 'Capital Distribuitors', 'Cali', 'capitaldistribiutors@capital.com', '8768343', 'SI'),
('4320', NULL, NULL, NULL, NULL, 'NO'),
('4323', 'Empresa Distribuidora SAS', 'Bogota', 'empresa@gmail.com', '76242432', 'SI'),
('4326', 'Oficial Logares', 'Bogota', 'logaficial@gmail.com', '9657443', 'SI'),
('5245', NULL, NULL, NULL, NULL, 'NO'),
('6656', 'North Down PetShops', 'California', 'nrthdouwn@petshn.us', '1435654', 'SI'),
('6816', 'Deshop Road', 'Bogota', 'deshp@gmail.com', '91265343', 'SI'),
('7544', 'Sood S.AS.', 'Bogota', 'sooscompany@outlook.com', '77755553', 'NO'),
('7777', NULL, NULL, NULL, NULL, 'NO'),
('8517', NULL, NULL, NULL, NULL, 'NO'),
('9449', NULL, NULL, NULL, NULL, 'NO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tiposid`
--

CREATE TABLE `tiposid` (
  `codId` int NOT NULL,
  `id` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tiposid`
--

INSERT INTO `tiposid` (`codId`, `id`) VALUES
(1, 'C.C'),
(2, 'C.E'),
(3, 'P.A'),
(4, 'P.E.P');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int NOT NULL,
  `identificacion` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tipoId` int DEFAULT NULL,
  `primerNombre` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `segundoNombre` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `primerApellido` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `segundoApellido` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `telefono` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `activo` tinyint NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `identificacion`, `tipoId`, `primerNombre`, `segundoNombre`, `primerApellido`, `segundoApellido`, `telefono`, `email`, `activo`) VALUES
(680, '5442343', 4, 'Aurelio', 'Gilberto', 'Andaluz', 'Sanchez', '2322423435', 'aurelio2000@mail.com', 0),
(683, '1119873234', 1, 'Jose', 'Luis', 'Restrepo', 'Perez', '3121010762', 'josdeluis@gmail.com', 0),
(698, '1023836283', 2, 'Joiber', 'Daniel', 'Moreno', 'Sepulveda', '3112225464', 'jhoiber@gmail.com', 1),
(699, '1027400956', 1, 'Agmeth', 'Emilio', 'Jimenez', 'Castro', '3124376338', 'agmeth.jimenez2005@gmail.com', 1),
(717, '8370047334', 1, 'Romeo', 'Jesus', 'Gonzales', 'Duran', '3107891234', 'romeo@gmail.com', 1),
(718, '6789765432', 1, 'Jose', 'Emilio', 'Mosaquera', 'Honstara', '3126789090', 'joseemilio@gmail.com', 1),
(719, '7364724545', 4, 'Jua', 'David', 'Segundon', 'Perdedor', '3387463875', 'segundon@mail.com', 1),
(722, '9123667344', 1, 'Luan', 'Esteban', 'Jimenez', 'Jimenez', '3034568719', 'luan@hotmail.com', 1),
(723, '1022876123', 1, 'Mario', 'Julian', 'Gay', 'Dominguez', '3202569856', 'juliandomin@gmail.com', 0),
(724, '1233345445', 1, 'Jorge', 'Camilo', 'Ariases', 'Pineda', '2432432432', 'jorge@gmail.com', 1),
(725, '123456789', 1, 'John', 'Doe', 'Smith', 'Johnson', '1234567890', 'john.doe@example.com', 1),
(726, '4353456676', 1, 'Prueba', 'DelAPI', 'DER', 'Registro', '9291337475', 'pruebaapi@gmail.com', 1),
(727, '1323435435', 2, 'Preubae', 'Token', 'Jimene', 'Jimenez', '4312466774', 'tokenprueba123@gmail.com', 1),
(728, '9837463836', 2, 'Nicolas', 'Jesus', 'Gonzalez', 'Gomez', '3117651234', 'nicocolas@outlook.es', 0),
(729, '4738543554', 2, 'Enrique', 'Eduardo', 'Perezs', 'Gomez', '3117651284', 'enriques@outlook.es', 0),
(730, '4735543554', 2, 'Juan', 'Eduardo', 'Cacerez', 'Gomez', '3117651284', 'enriques@outlook.com', 1),
(731, '4735543553', 2, 'Juan', 'SAPAS', 'DDD', 'GFD', '3167651284', 'enriques@yahoo.com', 0),
(763, '6362727637', 1, 'Alberto', 'Jesus', 'Mora', 'Cedeña', '3175429812', 'jesudeo@outlook.com', 1),
(766, '9812346386', 2, 'Nicolas', 'Eduardo', 'Cruz ', 'Jiménez ', '3047896521', 'nicocru@gmail.com', 1),
(767, '3627282728', 1, 'Luis', 'David', 'Garcia', 'Suares', '3076231287', 'luis@gmail.com', 1),
(768, '1027400954', 1, 'Emilio ', 'Agmeth ', 'Castro ', 'Jiménez ', '3124376337', 'agmeth.jimenez@misena.edu.co', 1),
(769, '2735373443', 1, 'Juan', 'Juan', 'Gomez', 'Rojas', '3134569812', 'jujuan@gmail.com', 1),
(770, '5462489321', 1, 'Julio', 'Romeo', 'Cepeda', 'Rojas', '3198542369', 'julioromeo@outlook.com', 1),
(774, '67891267387', 2, 'Juan', 'Carlos', 'Trujillo', 'Meza', '3008794312', 'juntrujillo123@gmail.com', 0),
(775, '56712340173', 1, 'Laura', 'Sofia', 'Rodríguez ', 'Ricaurte ', '315789234', 'lauraricaute@gmail.com', 0),
(779, '2343454567', 1, 'Mario', 'Jose', 'Velazquez', 'Junior', '3127812341', 'mariojose@gmail.com', 1),
(780, '8784597164', 2, 'Ezequiel', 'Eduardo', 'Monsalve', 'Cruz', '3179864598', 'ezequieleduardo@gmail.com', 1),
(781, '6548955456', 1, 'Juliana', 'Alejandra', 'Rodriguez', 'Gomez', '3116987412', 'lauragomez@gmail.com', 1),
(782, '7612983451', 1, 'Daniel', 'Alejandro', 'Pineda', 'Rodriguez', '3178912365', 'alejandro1234@gmail.com', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administradores`
--
ALTER TABLE `administradores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indices de la tabla `asesores`
--
ALTER TABLE `asesores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `asesoria`
--
ALTER TABLE `asesoria`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_pk` (`id_cliente`),
  ADD KEY `assor_pk` (`id_asesor`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`categoria`);

--
-- Indices de la tabla `credenciales`
--
ALTER TABLE `credenciales`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `detallepedido`
--
ALTER TABLE `detallepedido`
  ADD PRIMARY KEY (`idPedido`,`idProducto`),
  ADD KEY `idProducto` (`idProducto`);

--
-- Indices de la tabla `estados`
--
ALTER TABLE `estados`
  ADD PRIMARY KEY (`codEst`);

--
-- Indices de la tabla `marcas`
--
ALTER TABLE `marcas`
  ADD PRIMARY KEY (`idMarca`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`idPedido`),
  ADD KEY `estado` (`estado`),
  ADD KEY `usuario` (`usuario`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`idProducto`),
  ADD KEY `proveedor` (`proveedor`),
  ADD KEY `marca` (`marca`),
  ADD KEY `categoria` (`categoria`);

--
-- Indices de la tabla `productosagregados`
--
ALTER TABLE `productosagregados`
  ADD KEY `admin_fk` (`administrador`),
  ADD KEY `prductos_fk` (`producto`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`idProveedor`);

--
-- Indices de la tabla `tiposid`
--
ALTER TABLE `tiposid`
  ADD PRIMARY KEY (`codId`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `identificacion` (`identificacion`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `tipoid` (`tipoId`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `asesoria`
--
ALTER TABLE `asesoria`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `marcas`
--
ALTER TABLE `marcas`
  MODIFY `idMarca` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=783;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `asesoria`
--
ALTER TABLE `asesoria`
  ADD CONSTRAINT `assor_pk` FOREIGN KEY (`id_asesor`) REFERENCES `asesores` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `user_pk` FOREIGN KEY (`id_cliente`) REFERENCES `usuarios` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `credenciales`
--
ALTER TABLE `credenciales`
  ADD CONSTRAINT `id_idpk` FOREIGN KEY (`id`) REFERENCES `usuarios` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `detallepedido`
--
ALTER TABLE `detallepedido`
  ADD CONSTRAINT `detallepedido_ibfk_1` FOREIGN KEY (`idPedido`) REFERENCES `pedidos` (`idPedido`),
  ADD CONSTRAINT `detallepedido_ibfk_2` FOREIGN KEY (`idProducto`) REFERENCES `productos` (`idProducto`);

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `estados_pedio` FOREIGN KEY (`estado`) REFERENCES `estados` (`codEst`),
  ADD CONSTRAINT `pedidos_ibfk_2` FOREIGN KEY (`usuario`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `categoria` FOREIGN KEY (`categoria`) REFERENCES `categorias` (`categoria`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `marca` FOREIGN KEY (`marca`) REFERENCES `marcas` (`idMarca`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `provedor` FOREIGN KEY (`proveedor`) REFERENCES `proveedores` (`idProveedor`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `productosagregados`
--
ALTER TABLE `productosagregados`
  ADD CONSTRAINT `admin_fk` FOREIGN KEY (`administrador`) REFERENCES `administradores` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `prductos_fk` FOREIGN KEY (`producto`) REFERENCES `productos` (`idProducto`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `tipoid` FOREIGN KEY (`tipoId`) REFERENCES `tiposid` (`codId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
