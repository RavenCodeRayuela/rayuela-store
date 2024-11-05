-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-11-2024 a las 03:26:25
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
(18, 1, 'Buzos', 'Buzo', '/public/storage/uploads/buzo.jpg'),
(19, 1, 'Camiseta', 'Camisetas', '/public/storage/uploads/camiseta.jpg'),
(20, 1, 'Zapatos', 'Zapatos', '/public/storage/uploads/zapatos.jpg'),
(21, 1, 'Sombreros', 'Sombreros', '/public/storage/uploads/sombrero.png'),
(22, 1, 'Medias', 'Medias', '/public/storage/uploads/medias.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `celulares`
--

CREATE TABLE `celulares` (
  `Numero_cel` varchar(15) NOT NULL,
  `Id_cliente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(16, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `Id_compra` int(11) NOT NULL,
  `Id_cliente` int(11) NOT NULL,
  `Costo_total` double(9,2) DEFAULT NULL,
  `Valoracion` varchar(300) DEFAULT NULL,
  `Estado` varchar(30) DEFAULT NULL,
  `Tipo_de_pago` varchar(30) DEFAULT NULL,
  `Id_direccion` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra_contiene_producto`
--

CREATE TABLE `compra_contiene_producto` (
  `Id_compra` int(11) NOT NULL,
  `Id_producto` int(11) NOT NULL,
  `Fecha` date DEFAULT NULL,
  `Cantidad_producto` int(11) DEFAULT NULL,
  `Precio_por_producto` double(7,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `direcciones_de_envio`
--

CREATE TABLE `direcciones_de_envio` (
  `Id_direccion` int(11) NOT NULL,
  `Ciudad` varchar(60) DEFAULT 'Ciudad no asignada',
  `Calle` varchar(60) DEFAULT 'Calle no asignada',
  `NroCasa` varchar(60) DEFAULT 'Nro de casa no asignada',
  `Id_cliente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
('/public/storage/uploads/buzo.jpg', 1, 22),
('/public/storage/uploads/buzo.jpg', 2, 22),
('/public/storage/uploads/rayuela.png', 3, 23),
('/public/storage/uploads/camisetavestir.jpg', 4, 23),
('/public/storage/uploads/rayuela.png', 5, 24),
('/public/storage/uploads/camiseta.jpg', 6, 24),
('/public/storage/uploads/rayuela.png', 7, 25),
('/public/storage/uploads/camisetaroja.jpg', 8, 25),
('/public/storage/uploads/rayuela.png', 9, 26),
('/public/storage/uploads/zapatos.jpg', 10, 26),
('/public/storage/uploads/rayuela.png', 11, 27),
('/public/storage/uploads/medias.jpg', 12, 27),
('/public/storage/uploads/rayuela.png', 13, 28),
('/public/storage/uploads/mediasnegras.jpg', 14, 28),
('/public/storage/uploads/rayuela.png', 15, 29),
('/public/storage/uploads/sombrero.png', 16, 29);

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
(22, 1, 18, 'Buzo', 1400.00, 5.00, 'Descubre tu nuevo buzo favorito: diseñado para brindarte el máximo confort y estilo en cualquier momento del día. Confeccionado con algodón premium, este buzo es tan suave que querrás usarlo una y otra vez.', 25),
(23, 1, 19, 'Camisa de vestir rosa', 2400.00, 0.00, 'Elegancia y frescura se encuentran en esta camiseta de vestir rosa, ideal para quienes buscan un estilo clásico con un toque de color.', 5),
(24, 1, 19, 'Camiseta de andar negra', 1100.00, 8.00, 'Dale un giro urbano a tu estilo diario con esta camiseta negra de mangas blancas, diseñada para quienes buscan un look casual sin perder el toque moderno.', 25),
(25, 1, 19, 'Camiseta de andar de mangas rojas', 1100.00, 8.00, 'Combina estilo y comodidad con nuestra camiseta de andar de mangas rojas, pensada para quienes no se conforman con lo básico.', 25),
(26, 1, 20, 'Zapatos de cuero', 3400.00, 0.00, 'Lleva tu estilo a otro nivel con estos zapatos de cuero, perfectos para quienes buscan elegancia y durabilidad en cada paso.', 10),
(27, 1, 22, 'Medias de rayas azules', 100.00, 0.00, 'Añade un toque vibrante a tus pasos con estas medias de rayas azules. Su diseño llamativo es ideal para quienes buscan un detalle diferente y moderno.', 50),
(28, 1, 22, 'Medias de rayas negras', 100.00, 0.00, 'Aporta un toque de estilo y elegancia a tu outfit con estas medias de rayas negras. Su diseño clásico y moderno las hace perfectas para cualquier ocasión.', 50),
(29, 1, 21, 'Sombrero de paja', 750.00, 5.00, 'Este sombrero de paja es el complemento ideal para tus días soleados, ya sea en la playa o en la ciudad.', 15);

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
(16, 'Nombre no asignado', 'juan22@gmail.com', '$2y$10$RD8Mmf.5/ltqRJ4rzX7qVu5yJQTRlSiTcaWxXbi86En6Hv9r3EKrG', 2);

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
  MODIFY `Id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `Id_compra` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `imagen_producto`
--
ALTER TABLE `imagen_producto`
  MODIFY `Id_imagen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `Id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `Id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

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
