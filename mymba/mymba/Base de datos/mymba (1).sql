-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-09-2023 a las 00:28:30
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `mymba`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administradores`
--

CREATE TABLE `administradores` (
  `idAdmin` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `apellido` varchar(30) NOT NULL,
  `telefono` varchar(10) NOT NULL,
  `email` varchar(40) NOT NULL,
  `funciones` varchar(200) NOT NULL,
  `clave` varchar(260) NOT NULL
) ;

--
-- Volcado de datos para la tabla `administradores`
--

INSERT INTO `administradores` (`idAdmin`, `nombre`, `apellido`, `telefono`, `email`, `funciones`, `clave`) VALUES
(3123, 'Julio', 'Delgado', '3123764423', 'juanperez123@outlook.com', 'Gestionar Productos', '??#????\rı*??e?');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asesores`
--

CREATE TABLE `asesores` (
  `id` varchar(11) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `apellido` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `especialidad` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asesoria`
--

CREATE TABLE `asesoria` (
  `id` int(11) NOT NULL,
  `usuario` int(11) DEFAULT NULL,
  `asesor` varchar(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `categoria` varchar(15) NOT NULL,
  `descripcion` varchar(80) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`categoria`, `descripcion`) VALUES
('1', 'Aseo'),
('2', 'Comida');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallepedido`
--

CREATE TABLE `detallepedido` (
  `idPedido` varchar(11) NOT NULL,
  `idProducto` varchar(11) NOT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `total` decimal(14,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados`
--

CREATE TABLE `estados` (
  `estado` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marcas`
--

CREATE TABLE `marcas` (
  `idMarca` varchar(10) NOT NULL,
  `marca` varchar(35) DEFAULT NULL,
  `telefono` varchar(12) DEFAULT NULL,
  `correo` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `marcas`
--

INSERT INTO `marcas` (`idMarca`, `marca`, `telefono`, `correo`) VALUES
('1', 'Canisan', NULL, NULL),
('2', 'Dog Chow', NULL, NULL),
('3', 'Smartbones SA', NULL, NULL),
('4', 'Royal Canin', '3214214', 'royalcanin@mail.com'),
('5', 'Pet Spa', NULL, NULL),
('7', 'GANADOR PREMIUM', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `idPedido` varchar(11) NOT NULL,
  `usuario` int(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `estado` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `idProducto` varchar(11) NOT NULL,
  `proveedor` varchar(11) DEFAULT NULL,
  `nombre` varchar(30) DEFAULT NULL,
  `descripcion` varchar(200) DEFAULT NULL,
  `contenido` varchar(10) DEFAULT NULL,
  `precio` decimal(14,2) DEFAULT NULL,
  `marca` varchar(10) DEFAULT NULL,
  `categoria` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`idProducto`, `proveedor`, `nombre`, `descripcion`, `contenido`, `precio`, `marca`, `categoria`) VALUES
('1', '3123', 'Purgante Canisan', 'Purgante para gato', '2.5', 200000.00, '1', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productosagregados`
--

CREATE TABLE `productosagregados` (
  `producto` varchar(11) NOT NULL,
  `admin` int(11) NOT NULL,
  `fechaRegistro` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productosagregados`
--

INSERT INTO `productosagregados` (`producto`, `admin`, `fechaRegistro`) VALUES
('1', 3123, '2023-09-08');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `idProveedor` varchar(11) NOT NULL,
  `nombre` varchar(30) DEFAULT NULL,
  `ciudad` varchar(20) DEFAULT NULL,
  `correo` varchar(30) DEFAULT NULL,
  `telefono` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`idProveedor`, `nombre`, `ciudad`, `correo`, `telefono`) VALUES
('3123', 'Juguetes Bogota', 'Bogota', 'juguebog@mail.com', '2346347');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tiposid`
--

CREATE TABLE `tiposid` (
  `codId` int(11) NOT NULL,
  `id` varchar(11) NOT NULL
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
  `id` int(11) NOT NULL,
  `identificacion` varchar(12) NOT NULL,
  `tipoId` int(11) DEFAULT NULL,
  `primerNombre` varchar(30) NOT NULL,
  `segundoNombre` varchar(30) DEFAULT NULL,
  `primerApellido` varchar(30) NOT NULL,
  `segundoApellido` varchar(30) DEFAULT NULL,
  `telefono` varchar(12) DEFAULT NULL,
  `email` varchar(30) NOT NULL,
  `clave` varchar(270) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `identificacion`, `tipoId`, `primerNombre`, `segundoNombre`, `primerApellido`, `segundoApellido`, `telefono`, `email`, `clave`) VALUES
(6, '43534253', 1, 'Alex', 'Francisco', 'Perez', 'Gonzales', '328349234', 'juanperez123@outlook.com', '$2y$10$iFqwXRzf.yRgjtaJ91PPvO4tgNJ1zKH6We/PJ/modlsOsrbvjT11m'),
(10, '1023836283', 4, 'Jose', 'Luis', 'Restrepo', 'Duran', '3114343689', 'josdeluis@gmail.com', '$2y$10$hXDuetOuM9LbbjpIz0YbYuVdMPhUr8ayZBy1676Z08KNQZ31M3hVy'),
(11, '1735283734', 1, 'Juan', 'Angel', 'Llanos', 'Grisales', '3125679283', 'juanllaqno@gmail.com', '$2y$10$G0/TZu5ZZDIN.gyQyRQ8EO1WTZX2YW9F/gIC/yTQRguytNOQTE0I2'),
(12, '102836234', 1, 'Ezequiel', 'Santiago', 'Cruz', 'Perez', '3103287363', 'santiperez@gmail.com', '$2y$10$w7Zv7e1abxrZCn3ktc2xAeHnhf7O4PKsu5xpGiraY7wFmAkYlznm6'),
(13, '45652838', 1, 'Juan', 'David', 'Gonzales', 'Suarez', '3046789120', 'suarezjuan35@gmail.com', '$2y$10$AFHB9BYzgieiQW8.VlB6KOdgjWNZZkG.ccX1OCdAEmLoaAkiG769m'),
(16, '1937635434', 1, 'Juan', 'David', 'Gonzales', 'Duran', '311029376', 'juandavid1234@gmail.com', '$2y$10$ft08kV6V4ad7vCf93lXFDeeXXS/jXXDFQMdnN1fvhbF.SIvzEvlT6'),
(18, '131225467457', 1, 'Jose', 'Daniel', 'Perez', 'Urrego', '30006352', 'josead@gmail.com', '$2y$10$DGEM7OFEuLpYgEao9c83euGUz7I70KaAlEadtR/QKgaYFzFPTe986'),
(24, '346273293', 1, 'Julio', 'Steven', 'Zambrano', 'De la Cruz', '3023443235', 'juliozambra@outlook.com', '$2y$10$b/4A.jmqaTmHc/MeMgR64O/ygsSPYQIn01vcYe.7REoPGO2AK16JW'),
(36, '23778423', 2, 'Jose', 'Francisco', 'Jimenez', 'Gonzales', '3016542312', 'jose@outlook.com', '$2y$10$KRSOGijg8Q6MMshNFRKrUuuPuvRM7pi7YMJYyRr2/Er7rJhso6nxG'),
(38, '43274832423', 1, 'Andy', 'Alejandro', 'Cifuentes', 'Cruzes', '3149873215', 'andy@gmail.com', '$2y$10$y0/tt3iBgVCR78iMArJsQedHOmqQn/GH25TZnHGofIGsunn6F0232'),
(41, '4357346', 2, 'Luciano', 'Emdes', 'Hastamorir', 'Rocessi', '465465477', 'luciano@outlook.ar', '$2y$10$MNAdDY1tyAy5aRhTHLvepe0tGcrTAiEe7.K7qbXpLkdihkMbP/U/W');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administradores`
--
ALTER TABLE `administradores`
  ADD PRIMARY KEY (`idAdmin`);

--
-- Indices de la tabla `asesores`
--
ALTER TABLE `asesores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `asesoria`
--
ALTER TABLE `asesoria`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario` (`usuario`),
  ADD KEY `asesor` (`asesor`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`categoria`);

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
  ADD PRIMARY KEY (`estado`);

--
-- Indices de la tabla `marcas`
--
ALTER TABLE `marcas`
  ADD PRIMARY KEY (`idMarca`),
  ADD UNIQUE KEY `telefono` (`telefono`),
  ADD UNIQUE KEY `correo` (`correo`);

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
  ADD KEY `fk_prodadd` (`producto`),
  ADD KEY `fk_adminadd` (`admin`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`idProveedor`),
  ADD UNIQUE KEY `correo` (`correo`),
  ADD UNIQUE KEY `telefono` (`telefono`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `asesoria`
--
ALTER TABLE `asesoria`
  ADD CONSTRAINT `asesoria_ibfk_1` FOREIGN KEY (`usuario`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `asesoria_ibfk_2` FOREIGN KEY (`asesor`) REFERENCES `asesores` (`id`);

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
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`estado`) REFERENCES `estados` (`estado`),
  ADD CONSTRAINT `pedidos_ibfk_2` FOREIGN KEY (`usuario`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`proveedor`) REFERENCES `proveedores` (`idProveedor`),
  ADD CONSTRAINT `productos_ibfk_2` FOREIGN KEY (`marca`) REFERENCES `marcas` (`idMarca`),
  ADD CONSTRAINT `productos_ibfk_3` FOREIGN KEY (`categoria`) REFERENCES `categorias` (`categoria`);

--
-- Filtros para la tabla `productosagregados`
--
ALTER TABLE `productosagregados`
  ADD CONSTRAINT `fk_adminadd` FOREIGN KEY (`admin`) REFERENCES `administradores` (`idAdmin`),
  ADD CONSTRAINT `fk_prodadd` FOREIGN KEY (`producto`) REFERENCES `productos` (`idProducto`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `tipoid` FOREIGN KEY (`tipoId`) REFERENCES `tiposid` (`codId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
