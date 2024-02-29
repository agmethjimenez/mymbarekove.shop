-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 29-02-2024 a las 01:20:23
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
  `clave` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `administradores`
--

INSERT INTO `administradores` (`id`, `username`, `email`, `clave`, `activo`) VALUES
('432534634', 'carlos567', 'carlosgo@mymba.com', '$2y$10$uWOFT6G7WEhqHPV63c7yiu0W0RlphP.2EL8ZY.E.1AV6oVfz0p2fG', 1),
('6571f15f04', 'jhorman43', 'jhorman@gmail.com', '$2y$10$ItOpGi4SKkXxUAeDoVnH6u7o5kzyN/GnZAM3e6qM/KGilrPCvSuZu', 1),
('6576374227', 'test1', 'test@gmail.com', '$2y$10$TxUefpGtxOpMr7Kndo0PQunQO9hXpo4BVihcOZ0uMJfDKrwjsmBBS', 1);

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
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `credenciales`
--

INSERT INTO `credenciales` (`id`, `email`, `token`, `codigo`, `fecha_cambio`, `password`) VALUES
(680, 'aurelio2000@mail.com', '2539c2c3e19d537e0603270d79171017', 9331, '2024-02-22 23:27:01', '$2y$10$TC1XEjJOGupQ1R5kVnIAce25Rf3rKf0eCIoW7.YtbBK5g/6a.FRhy'),
(683, 'josdeluis@gmail.com', NULL, 0, '2024-01-21 22:57:16', '$2y$10$GyYT8Z6KwiYwsV8KcZma3O70alVk/NlwFybSzzzqqjnZsDHg7u2QG'),
(698, 'jhoiber@gmail.com', NULL, 0, '2024-01-21 22:57:16', '$2y$10$/Lpc6TxnSAVkcwW.U8Yy0./R4kEax7ECr4vzyz7ULC4u/itVozbD6'),
(699, 'agmeth.jimenez2005@gmail.com', 'e0e296bd4923ec698c0887977f6ca6a5', 9112, '2024-02-26 17:45:23', '$2y$10$KMCXaEv1btZyx6QaLGOecOiRyGo.yzQ8POiM4CiThbHgMcOoSszoS'),
(717, 'romeo@gmail.com', '953ffd0d7891c2f836c7394b846c68ca', 5982, '2024-02-29 00:55:23', '$2y$10$N2Hq/3407R/FfKH8BZMZEO3S99vJyWbY8ovDj7.nf9AzjJTsuhoAq'),
(718, 'joseemilio@gmail.com', '05cf516a0366d0de0df31fb274da0caf', 3249, '2024-02-29 00:56:32', '$2y$10$UFiJKM9JSfKwwCQ7mbTF5uhNdDlki55EfzCWPZxS4L.p.mj8Tr0JG'),
(719, 'segundon@mail.com', '651129532e967ab083a6d91ada971cbb', 1077, '2024-02-29 00:57:50', '$2y$10$j6nxmcPxJiLHbxGrsvlMbOX8lpvsVslo5oqNjPEOUWRl0wZJ8BD3y'),
(722, 'luan@hotmail.com', '0fb17b5a7cd94efca266b719c315460c', 5588, '2024-02-29 01:01:10', '$2y$10$bjnpAnzCbMTSitwUTjclPulT/MDZn0aYV3Cttvd/soykMpNvKMW6e');

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
('65de34b14d', '9634 ', 2, 204600);

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
(1, 'Cancelado'),
(2, 'En proceso'),
(3, 'Finalizado'),
(4, 'Pendiente'),
(5, 'Vencido');

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
('65de34b14d', 699, 'Bogota', 'Carrera 98 #2 -20 Int 20 Apto 501', '2024-02-27 19:14:57', 259600, '{\"payment_id\":\"1321396553\",\"status\":\"approved\",\"payment_type\":\"debit_card\",\"order_id\":\"16157797761\"}', 4);

--
-- Disparadores `pedidos`
--
DELIMITER $$
CREATE TRIGGER `actualizaCantidadDisponible` AFTER UPDATE ON `pedidos` FOR EACH ROW BEGIN
    DECLARE idPedidoVar CHAR(10);
    DECLARE estadoVar INT;

    -- Obtener el idPedido y el estado después de la actualización
    SELECT NEW.idPedido, NEW.estado INTO idPedidoVar, estadoVar;

    -- Verificar si el estado cambió a "En proceso" (id 2)
    IF estadoVar = 2 THEN
        -- Actualizar la cantidad disponible de productos en la tabla detallepedido
        -- Restar la cantidad de cada producto en detallepedido de su respectivo producto en la tabla productos
        UPDATE productos
        SET cantidadDisponible = cantidadDisponible - (
            SELECT cantidad
            FROM detallepedido
            WHERE idPedido = idPedidoVar
              AND productos.idProducto = detallepedido.idProducto
        )
        WHERE idProducto IN (
            SELECT idProducto
            FROM detallepedido
            WHERE idPedido = idPedidoVar
        );
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `idProducto` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `proveedor` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nombre` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
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
('1', '3123', 'Purgante Canisan', 'Purgante para gato 100 EFECTIVOI', '2.5 ML', 200000, 1, '1', 64, 'https://i.postimg.cc/tTP2SzDz/156397-800-auto.jpg', 1),
('12334', '103', 'Artri-Vet Suplemento Alimentic', 'ARTRI-VET es un suplemento alimenticio, cuya fórmula contiene ingredientes coadyuvantes en el regeneramiento articular, especial para el tratamiento y prevención de problemas articulares y enfermedade', '60 TAB', 76999, 10, '4', 33, 'https://i.postimg.cc/Ss7cY1DH/5959459405940000013-min.jpg', 1),
('1346', '103', 'Royal Canin-SHN Starter M&B Do', 'Es especial para la salud digestiva: Resultado de la investigación de Royal Canin, start complex es una combinación exclusiva de sustancias nutricionales presentes en la leche materna, reforzada con n', '145 G', 11500, 4, '2', 49, 'https://i.postimg.cc/hvDTL8Yv/111103887-min.jpg', 1),
('3168 ', '103', 'Kyra - Alimento Completo Horneada Perro', 'Kyra - Alimento Completo Horneada Perro, es un alimento nutritivo de 500gr. Diseñado para perros de todas las edades y razas.', '500 G', 7200, 11, '2', 310, 'https://i.postimg.cc/50p9bQtx/f3ccdd27d2000e3f9255a7e3e2c48800-1706737511.avif', 1),
('32449', '102', 'Royal Canin lata gastrointesti', 'El Royal Canin Dog Lata Gastro Intestinal es un alimento para perros de alta energía, altamente digestible, apetecible, completo y equilibrado . Especies: Caninos.\r\nSeguridad Digestiva. Ayuda a manten', '385 GR', 28000, 4, '2', 45, 'https://i.postimg.cc/VNtqmkMf/00030111470713e-cf.jpg', 1),
('33523', '105', 'Basti Cat - Arena Estandar', 'Basti Cat - Arena Estandar, es un producto con una aglomeración consistente, fácil de limpiar y muy agradable para tu mascota', '4 KG', 16920, 9, '6', 76, 'https://i.postimg.cc/9FBNHJ28/68936-161035-Basti-Cat-Arena-Est.jpg', 1),
('42356', '242435', 'Juguete de goma', 'el mejor', '500 LB', 10000, 5, '2', 34, '', 0),
('5555', '4323', 'Comida mojada', 'comida mojada', '2LB', 5990, 10, '5', 77, 'https://i.postimg.cc/BQJMpHFx/111101967-min.jpg', 1),
('5662 ', '242435', 'Royal Canin - Mini Puppy', 'Royal Canin - Mini Puppy, es ideal para el crecimiento es una fase muy importante de la vida del perro: es una época de grandes cambios, descubrimientos y nuevos encuentros. Durante este período clave, el sistema inmunológico del cachorro se desarrolla de forma gradual. Mini puppy ayuda a reforzar las defensas naturales del cachorro gracias a un complejo patentado* de antioxidantes que incluye vitamina E. Salud digestiva: Combinación de nutrientes con proteínas de gran calidad (L.I.P.)* y prebióticos (FOS) que favorece la salud digestiva y el equilibro de la flora intestinal, contribuyendo a la calidad de las heces. *Proteína seleccionada por su elevada digestibilidad. Alto contenido energético: Responde a las necesidades energéticas de los cachorros de razas pequeñas durante el período de crecimiento y satisface los apetitos caprichosos.', '4 KG', 110000, 4, '2', 167, 'https://i.postimg.cc/RF5zYN3Z/528-173857-Royal-Canin-Mini-Pupp.jpg', 1),
('6435', '242435', 'Diamond Naturals Perros Adulto', 'Diamond Naturals Perros Adultos Light es un concentrado para perros Adultos Premium elaborado con ingredientes de alta calidad para proporcionar una nutrición completa y balanceada pero con menos calo', '3 LB', 285597, 7, '2', 64, 'https://i.postimg.cc/XNfs9Qrj/111100193-ed-min.jpg', 1),
('7343', '104', 'Pedigree-SHN Starter M&B Dog W', 'Pedigree - Alimento Húmedo Para Perro Adulto Raza Pequeña Pollo Sobre, es 100% completo y balanceado. Con los nutrientes necesarios para que tu perro tenga una vida sana y feliz. Incluye comida húmeda', '100 GR', 3145, 8, '2', 20, 'https://i.postimg.cc/BQJMpHFx/111101967-min.jpg', 1),
('7456', '242435', 'Dog Chow Adultos', 'Comida con vitaminas y nutrientes para tu mascota', '8 KG', 55000, 2, '2', 35, 'https://i.postimg.cc/kGT8f6rc/dog-chow-adulto-raza-peque-a-8kg.jpg', 1),
('9634 ', '4323', 'Royal Canin - Mini Adult', 'Alimento seco para perros adultos pequeños formulado con una nutrición precisa hecha específicamente para perros pequeños de 10 meses a 8 años de edad que pesen entre 9 y 22 lb. Satisface las altas necesidades de energía de las razas de perros pequeños mientras ayuda a mantener un peso saludable con L-carnitina.', '2 KG', 102300, 4, '2', 200, 'https://i.postimg.cc/sg5WYKX1/459-62312-Royal-Canin-Mini-Adulto-1616619959-2186x2186.avif', 1);

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
  `correo` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `telefono` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `estado` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
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
('4323', 'Empresa Distribuidora SAS', 'Bogota', 'empresa@gmail.com', '76242432', 'SI'),
('7544', 'Sood S.AS.', 'Bogota', 'sooscompany@outlook.com', '77755553', 'NO');

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
(680, '5442343', 4, 'Aurelio', 'Gilberto', 'Andaluz', 'Sanchez', '2322423435', 'aurelio2000@mail.com', 1),
(683, '1119873234', 1, 'Jose', 'Luis', 'Restrepo', 'Perez', '3121010762', 'josdeluis@gmail.com', 1),
(698, '1023836283', 2, 'Joiber', 'Daniel', 'Moreno', 'Sepulveda', '3112225464', 'jhoiber@gmail.com', 1),
(699, '1027400956', 1, 'Agmeth', 'Emilio', 'Jimenez', 'Castro', '3124376338', 'agmeth.jimenez2005@gmail.com', 1),
(717, '8370047334', 1, 'Romeo', 'Jesus', 'Gonzales', 'Duran', '3107891234', 'romeo@gmail.com', 1),
(718, '6789765432', 1, 'Jose', 'Emilio', 'Mosaquera', 'Honstara', '3126789090', 'joseemilio@gmail.com', 1),
(719, '7364724545', 4, 'Jua', 'David', 'Segundon', 'Perdedor', '3387463875', 'segundon@mail.com', 1),
(722, '9123667344', 1, 'Luan', 'Esteban', 'Jimenez', 'Jimenez', '3034568719', 'luan@hotmail.com', 1);

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=723;

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
