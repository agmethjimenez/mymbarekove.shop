-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 30-11-2023 a las 01:41:39
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
-- Base de datos: `mymba`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administradores`
--

CREATE TABLE `administradores` (
  `id` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `clave` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `administradores`
--

INSERT INTO `administradores` (`id`, `username`, `email`, `clave`, `activo`) VALUES
('432534634', 'carlos567', 'carlosgo@mymba.com', '$2y$10$uWOFT6G7WEhqHPV63c7yiu0W0RlphP.2EL8ZY.E.1AV6oVfz0p2fG', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asesores`
--

CREATE TABLE `asesores` (
  `id` int NOT NULL,
  `nombre` varchar(40) COLLATE utf8mb4_general_ci NOT NULL,
  `apellido` int NOT NULL,
  `especialidad` text COLLATE utf8mb4_general_ci NOT NULL
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
  `categoria` varchar(15) COLLATE utf8mb4_general_ci NOT NULL,
  `descripcion` varchar(80) COLLATE utf8mb4_general_ci DEFAULT NULL
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
-- Estructura de tabla para la tabla `detallepedido`
--

CREATE TABLE `detallepedido` (
  `idPedido` varchar(11) COLLATE utf8mb4_general_ci NOT NULL,
  `idProducto` varchar(11) COLLATE utf8mb4_general_ci NOT NULL,
  `cantidad` int DEFAULT NULL,
  `total` decimal(14,0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detallepedido`
--

INSERT INTO `detallepedido` (`idPedido`, `idProducto`, `cantidad`, `total`) VALUES
('45436', '1', 3, 42335),
('45436', '12334', 1, 76999),
('645654', '33523', 1, 16920),
('6747', '7456', 2, 110000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados`
--

CREATE TABLE `estados` (
  `codEst` int NOT NULL,
  `estado` varchar(15) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estados`
--

INSERT INTO `estados` (`codEst`, `estado`) VALUES
(1, 'Cancelado'),
(2, 'En proceso'),
(3, 'Finalizado'),
(4, 'Pendiente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marcas`
--

CREATE TABLE `marcas` (
  `idMarca` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `marca` varchar(35) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `marcas`
--

INSERT INTO `marcas` (`idMarca`, `marca`) VALUES
('1', 'Canisan'),
('10', 'QualiVet'),
('2', 'Dog Chow'),
('3', 'Smartbones SA'),
('4', 'Royal Canin'),
('5', 'Pet Spa'),
('7', 'GANADOR PREMIUM'),
('8', 'Pedigree'),
('9', 'Basti cat');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `idPedido` varchar(11) COLLATE utf8mb4_general_ci NOT NULL,
  `usuario` int DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `estado` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`idPedido`, `usuario`, `fecha`, `estado`) VALUES
('45436', 13, '2023-09-12', 3),
('645654', 18, '2023-10-05', 3),
('6747', 12, '2023-09-19', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `idProducto` varchar(11) COLLATE utf8mb4_general_ci NOT NULL,
  `proveedor` varchar(11) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nombre` varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `descripcionP` varchar(200) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `contenido` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `precio` decimal(10,0) DEFAULT NULL,
  `marca` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `categoria` varchar(15) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `cantidadDisponible` int NOT NULL,
  `imagen` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`idProducto`, `proveedor`, `nombre`, `descripcionP`, `contenido`, `precio`, `marca`, `categoria`, `cantidadDisponible`, `imagen`, `activo`) VALUES
('1', '3123', 'Purgante Canisan', 'Purgante para gato 100 EFECTIVOI', '2.5 ML', 200000, '1', '1', 54, 'purgante canisan 2,5ml.jpg', 1),
('12334', '103', 'Artri-Vet Suplemento Alimentic', 'ARTRI-VET es un suplemento alimenticio, cuya fórmula contiene ingredientes coadyuvantes en el regeneramiento articular, especial para el tratamiento y prevención de problemas articulares y enfermedade', '60 TAB', 76999, '10', '4', 45, '5959459405940000013-min.jpg', 1),
('1346', '103', 'Royal Canin-SHN Starter M&B Do', 'Es especial para la salud digestiva: Resultado de la investigación de Royal Canin, start complex es una combinación exclusiva de sustancias nutricionales presentes en la leche materna, reforzada con n', '145 G', 11500, '4', '2', 54, '111103887-min.jpg', 1),
('32449', '102', 'Royal Canin lata gastrointesti', 'El Royal Canin Dog Lata Gastro Intestinal es un alimento para perros de alta energía, altamente digestible, apetecible, completo y equilibrado . Especies: Caninos.\r\nSeguridad Digestiva. Ayuda a manten', '385 GR', 28000, '4', '2', 54, '00030111470713e-cf.jpg', 1),
('33523', '105', 'Basti Cat - Arena Estandar', 'Basti Cat - Arena Estandar, es un producto con una aglomeración consistente, fácil de limpiar y muy agradable para tu mascota', '4 KG', 16920, '9', '6', 76, '68936_161035_Basti_Cat_Arena_Est.jpg', 1),
('42356', '242435', 'Juguete de goma', 'el mejor', '500 LB', 10000, '5', '2', 34, '', 0),
('6435', '242435', 'Diamond Naturals Perros Adulto', 'Diamond Naturals Perros Adultos Light es un concentrado para perros Adultos Premium elaborado con ingredientes de alta calidad para proporcionar una nutrición completa y balanceada pero con menos calo', '3 LB', 285597, '7', '2', 64, '111100193_ed-min.jpg', 1),
('7343', '104', 'Pedigree-SHN Starter M&B Dog W', 'Pedigree - Alimento Húmedo Para Perro Adulto Raza Pequeña Pollo Sobre, es 100% completo y balanceado. Con los nutrientes necesarios para que tu perro tenga una vida sana y feliz. Incluye comida húmeda', '100 GR', 3145, '8', '2', 29, '1475_189662_Pedigree___Alimento.jpg', 1),
('7456', '242435', 'Dog Chow Adultos', 'Comida con vitaminas y nutrientes para tu mascota', '8 KG', 55000, '2', '2', 35, 'dog chow adulto raza pequeña 8kg.jpg', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productosagregados`
--

CREATE TABLE `productosagregados` (
  `producto` varchar(11) COLLATE utf8mb4_general_ci NOT NULL,
  `administrador` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `fecha_registro` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `idProveedor` varchar(11) COLLATE utf8mb4_general_ci NOT NULL,
  `nombreP` varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ciudad` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `correo` varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `telefono` varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `estado` varchar(2) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`idProveedor`, `nombreP`, `ciudad`, `correo`, `telefono`, `estado`) VALUES
('101', 'PetPro Supplies', 'Medellin', 'petpro@proveedormascotas.com', '123-4567', 'NO'),
('102', 'Animalia Pet Shop', 'Medellin', 'animalia@emailmascotas.net', '987-6543', 'SI'),
('103', 'Paws & Tails Distribuciones', 'Bogota', 'pawsntailsdistri@petmail.com', '321-7890', 'SI'),
('104', 'FurFriend Supplies', 'Bucaramanga', 'info@furfriend-supplies.com', '555-5555', 'SI'),
('105', 'HappyPets Inc.', 'Bogota', 'info@happypets-inc.com', '234-5678', 'SI'),
('242435', 'Foot Pet SA', 'New York', 'petfoot@fpa.usa', '1283726', 'SI'),
('245', 'FOO S.A', 'Bogota', 'foo.sa@gmail.com', '3143667879', 'NO'),
('3123', 'Juguetes Bogota', 'Bogota', 'juguebog@mail.com', '2346347', 'NO'),
('4323', 'Empresa Distribuidora SAS', 'Bogota', 'empresa@gmail.com', '76242432', 'SI');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tiposid`
--

CREATE TABLE `tiposid` (
  `codId` int NOT NULL,
  `id` varchar(11) COLLATE utf8mb4_general_ci NOT NULL
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
  `identificacion` varchar(15) COLLATE utf8mb4_general_ci NOT NULL,
  `tipoId` int DEFAULT NULL,
  `primerNombre` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `segundoNombre` varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `primerApellido` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `segundoApellido` varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `telefono` varchar(12) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `activo` tinyint NOT NULL DEFAULT '1',
  `clave` varchar(270) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `identificacion`, `tipoId`, `primerNombre`, `segundoNombre`, `primerApellido`, `segundoApellido`, `telefono`, `email`, `activo`, `clave`) VALUES
(10, '1023836283', 4, 'Jose', 'Luis', 'Restrepo', 'Mora', '3144343689', 'josdeluis@gmail.com', 1, '$2y$10$hXDuetOuM9LbbjpIz0YbYuVdMPhUr8ayZBy1676Z08KNQZ31M3hVy'),
(11, '1735283734', 1, 'Juan', 'Angel', 'Llanos', 'Grisales', '3125679283', 'juanllaqno@gmail.com', 1, '$2y$10$G0/TZu5ZZDIN.gyQyRQ8EO1WTZX2YW9F/gIC/yTQRguytNOQTE0I2'),
(12, '102836234', 1, 'Ezequiel', 'Santiago', 'Cruz', 'Perez', '3103287363', 'santiperez@gmail.com', 1, '$2y$10$w7Zv7e1abxrZCn3ktc2xAeHnhf7O4PKsu5xpGiraY7wFmAkYlznm6'),
(13, '45652838', 1, 'Juan', 'David', 'Gonzales', 'Suarez', '3046789120', 'suarezjuan35@gmail.com', 1, '$2y$10$AFHB9BYzgieiQW8.VlB6KOdgjWNZZkG.ccX1OCdAEmLoaAkiG769m'),
(16, '1937635434', 1, 'Juan', 'David', 'Gonzales', 'Duran', '311029376', 'juandavid1234@gmail.com', 1, '$2y$10$ft08kV6V4ad7vCf93lXFDeeXXS/jXXDFQMdnN1fvhbF.SIvzEvlT6'),
(18, '131225467457', 1, 'Jose', 'Daniel', 'Perez', 'Urrego', '30006352', 'josead@gmail.com', 1, '$2y$10$DGEM7OFEuLpYgEao9c83euGUz7I70KaAlEadtR/QKgaYFzFPTe986'),
(24, '346273293', 1, 'Julio', 'Steven', 'Zambrano', 'Cruz', '3023443235', 'juliozambra@outlook.com', 1, '$2y$10$oByubwyngAuqmFAjumw5z.ewU6qRqv527VUA8uuMbVPGDCNAXYeD6'),
(36, '23778423', 2, 'Jose', 'Francisco', 'Jimenez', 'Gonzales', '3016542312', 'jose@outlook.com', 1, '$2y$10$KRSOGijg8Q6MMshNFRKrUuuPuvRM7pi7YMJYyRr2/Er7rJhso6nxG'),
(38, '43274832423', 1, 'Andy', 'Alejandro', 'Cifuentes', 'Cruzes', '3149873215', 'andy@gmail.com', 1, '$2y$10$y0/tt3iBgVCR78iMArJsQedHOmqQn/GH25TZnHGofIGsunn6F0232'),
(42, '1032406273', 1, 'Luz', 'Mery', 'Castro', 'Hernandez', '3058103503', 'luz.mery@gmail.com', 1, '$2y$10$5LiYFFtY9Mr4EbjRUtOOAOhcZ5lJwLjgiUnGzAv6G1RWkjQ7IdOsC'),
(43, '324356', 3, 'John', 'Stuart', 'Domingo', 'Chandlers', '12734645', 'johnstuart@gmail.com', 1, '$2y$10$cKRL0gS6ah6LAs9IoykBbu.8kQS3pT6EkD.O8rjFddFfz1V22dZUC'),
(655, '1010223456', 1, 'Alberto', 'David', 'Gonzales', 'Jimenez', '6014332392', 'alberto@gmail.com', 1, '$2y$10$cO8qTFIMBxZ7yyuiNoIyEef7HHJiSMOhkJrfYIdAG0yagy5HWbacW'),
(656, '9836273623', 1, 'Luan', 'Luis', 'Gonzales', 'Duran', '3114234567', 'LUANLUIS@GMAIL.COM', 1, '$2y$10$gMXGT5r7bG/4dBhf.Szdj.hsQpscXsUoYR4HflO7oZzXLynWxOdaS'),
(657, '41455854', 1, 'Ezequiel', 'Esteban', 'Gonzales', 'Trujillo', '3147894588', 'ezequiel@gmail.com', 1, '$2y$10$cDQleOQ19sNoC8a.FmLeJuE/pPXrLO34YDUqULJ.rwa19zSj0gpGK'),
(658, '3473658345', 1, 'Jose', 'Steven', 'Restrepo', 'Perez', '3125635855', 'joser@gmail.com', 1, '$2y$10$LB81p89bHu/.pxl/Rtp44e4b1JAflbxx5cIfVjWR4KiXrTp0OAQTy'),
(671, '3213244342', 1, 'Juan', 'Alberto', 'Jimenez', 'Rosa', '6043127456', 'delarodsa@hotmail.com', 1, '$2y$10$A0STF0haGEPIMIhL5jJXKOrMf98QQ/Wah4ojBcTWP76k0JuOAvG9.');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administradores`
--
ALTER TABLE `administradores`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=673;

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
