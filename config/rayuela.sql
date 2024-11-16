-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-11-2024 a las 09:02:54
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `rayuela`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrador`
--

CREATE TABLE `administrador` (
  `Id_admin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `administrador`
--

INSERT INTO `administrador` (`Id_admin`) VALUES
(1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `Id_categoria` int(11) NOT NULL,
  `Id_admin` int(11) NOT NULL,
  `Nombre_categoria` varchar(60) DEFAULT NULL,
  `Descripcion_categoria` varchar(125) DEFAULT NULL,
  `Ruta_imagen_categoria` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`Id_categoria`, `Id_admin`, `Nombre_categoria`, `Descripcion_categoria`, `Ruta_imagen_categoria`) VALUES
(24, 1, 'Contenedores', 'Contenedores en tela', '/public/storage/uploads/Cont.jpeg'),
(25, 1, 'Fundas', 'Fundas en tela', '/public/storage/uploads/Funda_cel_1.jpeg'),
(26, 1, 'Bolsitas tematicas', 'Bolsitas temáticas en tela.', '/public/storage/uploads/Bolsitas_tematicas.jpeg'),
(27, 1, 'Varios', 'Varios productos en tela, no te los pierdas!', '/public/storage/uploads/antifaz_bruj.jpeg'),
(28, 1, 'Primera Infancia', 'Todo para la primera infancia en tela.', '/public/storage/uploads/body_blanco.jpeg'),
(29, 1, 'Mochilas de piola', 'Lo mejor de las mochilas en tela.', '/public/storage/uploads/moch_piola.jpeg'),
(30, 1, 'Organizadores', 'Suavemente organizado', '/public/storage/uploads/organizador1.jpeg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `celulares`
--

CREATE TABLE `celulares` (
  `Numero_cel` varchar(15) NOT NULL,
  `Id_cliente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `celulares`
--

INSERT INTO `celulares` (`Numero_cel`, `Id_cliente`) VALUES
('092123123', 16),
('093129239', 17),
('099319123', 16);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `Id_cliente` int(11) NOT NULL,
  `Suscripcion_newsletter` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`Id_cliente`, `Suscripcion_newsletter`) VALUES
(3, 0),
(16, 1),
(17, 0),
(18, 0),
(19, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `Id_compra` int(11) NOT NULL,
  `Id_cliente` int(11) NOT NULL,
  `Fecha` date NOT NULL,
  `Costo_total` double(9,2) DEFAULT NULL,
  `Valoracion` varchar(300) DEFAULT NULL,
  `Estado` varchar(30) DEFAULT NULL,
  `Tipo_de_pago` varchar(30) DEFAULT NULL,
  `Comprobante` varchar(500) NOT NULL DEFAULT 'No',
  `Id_direccion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `compras`
--

INSERT INTO `compras` (`Id_compra`, `Id_cliente`, `Fecha`, `Costo_total`, `Valoracion`, `Estado`, `Tipo_de_pago`, `Comprobante`, `Id_direccion`) VALUES
(50, 16, '2024-11-14', 200.00, 'asd', 'Entregado', 'efectivo', 'No', 5),
(51, 16, '2024-11-14', 120.00, NULL, 'Entregado', 'efectivo', 'No', 5),
(52, 16, '2024-11-14', 45.00, NULL, 'Preparandose', 'efectivo', 'No', 5),
(53, 16, '2024-11-14', 70.00, NULL, 'Preparandose', 'transferencia', 'No', 5),
(54, 16, '2024-11-14', 385.00, NULL, 'Preparandose', 'efectivo', 'No', 5),
(55, 16, '2024-11-14', 1200.00, NULL, 'Entregado', 'efectivo', 'No', 5),
(56, 16, '2024-11-14', 45.00, NULL, 'Preparandose', 'efectivo', 'No', 5),
(57, 16, '2024-11-14', 200.00, NULL, 'Preparandose', 'efectivo', 'No', 5),
(58, 18, '2024-11-16', 310.00, NULL, 'Preparandose', 'efectivo', 'No', 11),
(59, 18, '2024-11-16', 95.00, NULL, 'Preparandose', 'efectivo', 'No', 11);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra_contiene_producto`
--

CREATE TABLE `compra_contiene_producto` (
  `Id_compra` int(11) NOT NULL,
  `Id_producto` int(11) NOT NULL,
  `Cantidad_producto` int(11) DEFAULT NULL,
  `Precio_por_producto` double(7,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `compra_contiene_producto`
--

INSERT INTO `compra_contiene_producto` (`Id_compra`, `Id_producto`, `Cantidad_producto`, `Precio_por_producto`) VALUES
(50, 53, 1, 200.00),
(51, 41, 1, 120.00),
(52, 42, 1, 45.00),
(53, 39, 1, 70.00),
(54, 32, 1, 95.00),
(54, 33, 1, 190.00),
(54, 34, 1, 100.00),
(55, 44, 5, 240.00),
(56, 42, 1, 45.00),
(57, 53, 1, 200.00),
(58, 33, 1, 190.00),
(58, 41, 1, 120.00),
(59, 32, 1, 95.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `direcciones_de_envio`
--

CREATE TABLE `direcciones_de_envio` (
  `Id_direccion` int(11) NOT NULL,
  `Ciudad` varchar(60) DEFAULT 'Ciudad no asignada',
  `Calle` varchar(60) DEFAULT 'Calle no asignada',
  `NroCasa` varchar(60) DEFAULT 'Nro de casa no asignada',
  `Comentario` varchar(280) NOT NULL DEFAULT 'Sin comentarios',
  `Id_cliente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `direcciones_de_envio`
--

INSERT INTO `direcciones_de_envio` (`Id_direccion`, `Ciudad`, `Calle`, `NroCasa`, `Comentario`, `Id_cliente`) VALUES
(5, 'Colonia Valdense', 'Guanabara', '103', 'Casa con paredes de ladrillo visto.', 16),
(8, 'Colonia Valdense', 'Rincon del rey', '0', 'Los pinos sin numero antes del fin y despues del comienzo', 17),
(11, 'Rosario', 'Greising', '123', '', 18);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagen_producto`
--

CREATE TABLE `imagen_producto` (
  `Ruta_imagen_producto` varchar(300) NOT NULL,
  `Id_imagen` int(11) NOT NULL,
  `Id_producto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `imagen_producto`
--

INSERT INTO `imagen_producto` (`Ruta_imagen_producto`, `Id_imagen`, `Id_producto`) VALUES
('/public/storage/uploads/bolsitas_dinosaurio.jpeg', 18, 31),
('/public/storage/uploads/bolsitas_dinosaurio2.jpeg', 19, 31),
('/public/storage/uploads/bolsitas_dinosaurio3.jpeg', 20, 31),
('/public/storage/uploads/bolsitas_dinosaurio4.jpeg', 21, 31),
('/public/storage/uploads/Bolsitas_tematicas.jpeg', 22, 31),
('/public/storage/uploads/Funda_cel_1.jpeg', 23, 32),
('/public/storage/uploads/contenedor_tul.jpeg', 24, 33),
('/public/storage/uploads/cont_abiertos.jpeg', 25, 34),
('/public/storage/uploads/funda_cel2.jpeg', 26, 35),
('/public/storage/uploads/mascara_bruj.jpeg', 27, 36),
('/public/storage/uploads/mascara_bat.jpeg', 28, 37),
('/public/storage/uploads/masc1.jpeg', 29, 38),
('/public/storage/uploads/masc2.jpeg', 30, 38),
('/public/storage/uploads/moch_piola.jpeg', 31, 39),
('/public/storage/uploads/bol1 (1).jpeg', 32, 40),
('/public/storage/uploads/bol1 (2).jpeg', 33, 40),
('/public/storage/uploads/bol2.jpeg', 34, 40),
('/public/storage/uploads/bol3.jpeg', 35, 40),
('/public/storage/uploads/bol4.jpeg', 36, 40),
('/public/storage/uploads/bol5.jpeg', 37, 40),
('/public/storage/uploads/bol6.jpeg', 38, 40),
('/public/storage/uploads/org_amongus.jpeg', 39, 41),
('/public/storage/uploads/babero1.jpeg', 40, 42),
('/public/storage/uploads/babero2.jpeg', 41, 42),
('/public/storage/uploads/Cambiador1.jpeg', 42, 43),
('/public/storage/uploads/Cambiador2.jpeg', 43, 43),
('/public/storage/uploads/Cambiador3.jpeg', 44, 43),
('/public/storage/uploads/Delantal1.jpeg', 45, 44),
('/public/storage/uploads/Delantal2.jpeg', 46, 44),
('/public/storage/uploads/Delantal3.jpeg', 47, 44),
('/public/storage/uploads/KitCom.jpeg', 48, 45),
('/public/storage/uploads/KitCom2.jpeg', 49, 45),
('/public/storage/uploads/KitCom3.jpeg', 50, 45),
('/public/storage/uploads/KitCom4.jpeg', 51, 45),
('/public/storage/uploads/KitHig1.jpeg', 52, 46),
('/public/storage/uploads/KitHig2.jpeg', 53, 46),
('/public/storage/uploads/pelotasInf.jpeg', 54, 47),
('/public/storage/uploads/MochPio.jpeg', 55, 48),
('/public/storage/uploads/Neccesser.jpeg', 56, 49),
('/public/storage/uploads/Necesser.jpeg', 57, 49),
('/public/storage/uploads/Necesser3.jpeg', 58, 49),
('/public/storage/uploads/Mochila.jpeg', 59, 50),
('/public/storage/uploads/ProtMam (2).jpeg', 60, 51),
('/public/storage/uploads/ProtMam.jpeg', 61, 51),
('/public/storage/uploads/PortaDoc (2).jpeg', 62, 52),
('/public/storage/uploads/PortaDoc.jpeg', 63, 52),
('/public/storage/uploads/KitBabto.jpeg', 64, 53),
('/public/storage/uploads/body3m (2).jpeg', 65, 54),
('/public/storage/uploads/OrganizadorF1.jpeg', 66, 55),
('/public/storage/uploads/mascara_bat.jpeg', 76, 37);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `Id_producto` int(11) NOT NULL,
  `Id_admin` int(11) NOT NULL,
  `Id_categoria` int(11) NOT NULL,
  `Nombre` varchar(60) DEFAULT NULL,
  `Precio_actual` double(7,2) DEFAULT NULL,
  `Descuento` double(5,2) DEFAULT NULL,
  `Descripcion_producto` varchar(300) DEFAULT NULL,
  `Cantidad` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`Id_producto`, `Id_admin`, `Id_categoria`, `Nombre`, `Precio_actual`, `Descuento`, `Descripcion_producto`, `Cantidad`) VALUES
(31, 1, 26, 'Bolsitas de dinosaurio', 20.00, 0.00, 'Bolsitas para cumpleaños con diseños en tela de dinosaurios, surtidas.', 15),
(32, 1, 25, 'Funda Stitch', 100.00, 5.00, 'Funda para celular con este inolvidable personaje.', 10),
(33, 1, 24, 'Contenedor con tul', 200.00, 5.00, 'Ideal para presentar esos panes caseros que tan bien te quedan.', 5),
(34, 1, 24, 'Contenedores abiertos', 100.00, 0.00, 'Todo quedará suavemente contenido.\r\nSe vende el par.', 10),
(35, 1, 25, 'Funda Tostada', 70.00, 0.00, 'Funda para celular con una tostada amigable.', 15),
(36, 1, 27, 'Máscara de bruja', 60.00, 0.00, 'Que asustes y te diviertas!\r\nSe venden por unidad', 15),
(37, 1, 27, 'Máscara de Batman', 70.00, 0.00, 'Que asustes y te diviertas! Se venden por unidad', 20),
(38, 1, 27, 'Máscaras de Halloween', 60.00, 0.00, '¡Que asustes y te diviertas! Se venden por unidad.\r\n¡Comunicate con nosotros, pasanos el id de tu compra y cuéntanos cuál quieres!', 20),
(39, 1, 29, 'Mochila de piola de dinosaurios', 70.00, 0.00, 'Suave, ligera y con dinos!', 10),
(40, 1, 26, 'Bolsitas de animales', 80.00, 10.00, 'Para lo que quieras.\r\n¡Comunicate con nosotros, pasanos el id de tu compra y cuéntanos cuál quieres!', 30),
(41, 1, 30, 'Organizador Among Us', 120.00, 0.00, '¡Donde está el infiltrado, compralo y descúbrelo!\r\n ¡Comunicate con nosotros, pasanos el id de tu compra y cuéntanos si quieres ponerle un nombre!', 7),
(42, 1, 28, 'Baberos', 50.00, 10.00, '¡Comunicate con nosotros, pasanos el id de tu compra y cuéntanos cuál quieres!', 10),
(43, 1, 28, 'Cambiador', 250.00, 10.00, 'Para que cambies tranquilo a tu bebe.', 15),
(44, 1, 28, 'Delantales', 300.00, 20.00, 'Para que los más peques puedan hacer y divertirse sin que te tengas preocupar(tanto) por la ropa.\r\n¡Comunicate con nosotros, pasanos el id de tu compra y cuéntanos como quieres el tuyo!', 5),
(45, 1, 28, 'Kit para las comidas', 350.00, 10.00, 'Para que los más peques tengan todo lo que precisan a la hora de comer.', 10),
(46, 1, 28, 'Kit de higiene', 350.00, 5.00, 'Para que los más peques tengan todo lo que precisan a la hora de limpiarse los dientes y más.', 15),
(47, 1, 28, 'Pelotas infantiles', 350.00, 0.00, 'Suaves, divertidas, simples o complejas.\r\n¡Comunicate con nosotros, pasanos el id de tu compra y cuéntanos cuál quieres!', 20),
(48, 1, 29, 'Mochila de piola personalizada', 300.00, 0.00, 'Suaves, ligeras y adaptadas a tus peques.\r\n¡Comunicate con nosotros, pasanos el id de tu compra y cuéntanos como quieres la tuya!', 10),
(49, 1, 27, 'Neceser', 500.00, 20.00, 'Organiza tus productos de belleza con estilo y en tela suave.\r\n¡Comunicate con nosotros, pasanos el id de tu compra y cuéntanos cuál quieres!', 20),
(50, 1, 27, 'Cartera', 400.00, 5.00, 'Cartera de suave y firme tela.', 10),
(51, 1, 27, 'Protectores mamarios', 120.00, 16.00, '¡Protectores mamarios en tela, porque tambien nos preocupamos por ti!', 15),
(52, 1, 28, 'Porta documentos', 350.00, 10.00, 'Para que tus peques tengan un lugar para sus documentos.', 10),
(53, 1, 28, 'Kit babero y toalla', 200.00, 0.00, 'Para que tu peque pueda comer más libre, y tu más suelto.', 4),
(54, 1, 28, 'Body y gorro', 400.00, 10.00, 'Body con diseño claro, suave y sencillo, con botones a presión en la entrepierna para su fácil apertura.', 20),
(55, 1, 30, 'Organizador', 300.00, 0.00, 'Organiza tus accesorios, con listón a presión para poder colocar pulseras, colitas, etc. y que puedas verlas para hallarlas fácilmente.', 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_de_usuario`
--

CREATE TABLE `tipo_de_usuario` (
  `Id_tipo` int(11) NOT NULL,
  `Rol` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_de_usuario`
--

INSERT INTO `tipo_de_usuario` (`Id_tipo`, `Rol`) VALUES
(1, 'Admin'),
(2, 'Cliente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `Id_usuario` int(11) NOT NULL,
  `Nombre` varchar(50) DEFAULT 'Nombre no asignado',
  `Email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `Id_tipo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`Id_usuario`, `Nombre`, `Email`, `password`, `Id_tipo`) VALUES
(1, 'Nombre no asignado', 'admin@gmail.com', '$2y$10$pLG0bldc5y7t/9uWQaTo3OGHxvCdk6zDltxYbNJ19SsoacQsYqmXa', 1),
(3, 'Nombre no asignado', 'usuario1@gmail.com', '$2y$10$pLG0bldc5y7t/9uWQaTo3OGHxvCdk6zDltxYbNJ19SsoacQsYqmXa', 2),
(16, 'Juan', 'juan22@gmail.com', '$2y$10$RD8Mmf.5/ltqRJ4rzX7qVu5yJQTRlSiTcaWxXbi86En6Hv9r3EKrG', 2),
(17, 'Juan Letamendía', 'juanletamendia22@gmail.com', '$2y$10$dnzDCA7Go2ImTCONAEZH4.9DuuiK1Z/qJ7IDg.rQZxFh9CFU.Nwha', 2),
(18, 'Nombre no asignado', 'juker12xd@gmail.com', '$2y$10$.e7hfl1EZ49PuBxgL5uDLOOk0Lt6AcgCGZEcKhI4BxLb2WMzoSnGe', 2),
(19, 'Nombre no asignado', 'sudalock@gmail.com', '$2y$10$vJJXO5pOm2tGyaFyGEz7w.RuU4Pun7Nq6TT2qmZUDHqiBhcjaWFfi', 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administrador`
--
ALTER TABLE `administrador`
  ADD PRIMARY KEY (`Id_admin`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`Id_categoria`),
  ADD KEY `Id_admin` (`Id_admin`);

--
-- Indices de la tabla `celulares`
--
ALTER TABLE `celulares`
  ADD PRIMARY KEY (`Numero_cel`,`Id_cliente`),
  ADD KEY `Id_cliente` (`Id_cliente`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`Id_cliente`);

--
-- Indices de la tabla `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`Id_compra`),
  ADD KEY `Id_cliente` (`Id_cliente`),
  ADD KEY `Id_direccion` (`Id_direccion`);

--
-- Indices de la tabla `compra_contiene_producto`
--
ALTER TABLE `compra_contiene_producto`
  ADD PRIMARY KEY (`Id_compra`,`Id_producto`),
  ADD KEY `Id_producto` (`Id_producto`);

--
-- Indices de la tabla `direcciones_de_envio`
--
ALTER TABLE `direcciones_de_envio`
  ADD PRIMARY KEY (`Id_direccion`),
  ADD KEY `Id_cliente` (`Id_cliente`);

--
-- Indices de la tabla `imagen_producto`
--
ALTER TABLE `imagen_producto`
  ADD PRIMARY KEY (`Id_imagen`,`Id_producto`),
  ADD KEY `Id_producto` (`Id_producto`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`Id_producto`),
  ADD KEY `Id_admin` (`Id_admin`),
  ADD KEY `Id_categoria` (`Id_categoria`);

--
-- Indices de la tabla `tipo_de_usuario`
--
ALTER TABLE `tipo_de_usuario`
  ADD PRIMARY KEY (`Id_tipo`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`Id_usuario`),
  ADD KEY `Id_tipo` (`Id_tipo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `Id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `Id_compra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT de la tabla `direcciones_de_envio`
--
ALTER TABLE `direcciones_de_envio`
  MODIFY `Id_direccion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `imagen_producto`
--
ALTER TABLE `imagen_producto`
  MODIFY `Id_imagen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `Id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `Id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `administrador`
--
ALTER TABLE `administrador`
  ADD CONSTRAINT `administrador_ibfk_1` FOREIGN KEY (`Id_admin`) REFERENCES `usuarios` (`Id_usuario`);

--
-- Filtros para la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD CONSTRAINT `categorias_ibfk_1` FOREIGN KEY (`Id_admin`) REFERENCES `administrador` (`Id_admin`);

--
-- Filtros para la tabla `celulares`
--
ALTER TABLE `celulares`
  ADD CONSTRAINT `celulares_ibfk_1` FOREIGN KEY (`Id_cliente`) REFERENCES `clientes` (`Id_cliente`);

--
-- Filtros para la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD CONSTRAINT `clientes_ibfk_1` FOREIGN KEY (`Id_cliente`) REFERENCES `usuarios` (`Id_usuario`);

--
-- Filtros para la tabla `compras`
--
ALTER TABLE `compras`
  ADD CONSTRAINT `compras_ibfk_1` FOREIGN KEY (`Id_cliente`) REFERENCES `clientes` (`Id_cliente`),
  ADD CONSTRAINT `compras_ibfk_2` FOREIGN KEY (`Id_direccion`) REFERENCES `direcciones_de_envio` (`Id_direccion`);

--
-- Filtros para la tabla `compra_contiene_producto`
--
ALTER TABLE `compra_contiene_producto`
  ADD CONSTRAINT `compra_contiene_producto_ibfk_1` FOREIGN KEY (`Id_compra`) REFERENCES `compras` (`Id_compra`),
  ADD CONSTRAINT `compra_contiene_producto_ibfk_2` FOREIGN KEY (`Id_producto`) REFERENCES `productos` (`Id_producto`);

--
-- Filtros para la tabla `direcciones_de_envio`
--
ALTER TABLE `direcciones_de_envio`
  ADD CONSTRAINT `direcciones_de_envio_ibfk_1` FOREIGN KEY (`Id_cliente`) REFERENCES `clientes` (`Id_cliente`);

--
-- Filtros para la tabla `imagen_producto`
--
ALTER TABLE `imagen_producto`
  ADD CONSTRAINT `imagen_producto_ibfk_1` FOREIGN KEY (`Id_producto`) REFERENCES `productos` (`Id_producto`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`Id_admin`) REFERENCES `administrador` (`Id_admin`),
  ADD CONSTRAINT `productos_ibfk_2` FOREIGN KEY (`Id_categoria`) REFERENCES `categorias` (`Id_categoria`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`Id_tipo`) REFERENCES `tipo_de_usuario` (`Id_tipo`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
