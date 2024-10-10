-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-10-2024 a las 06:46:53
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
  `Descripcion_categoria` varchar(300) DEFAULT NULL,
  `Ruta_imagen_categoria` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`Id_categoria`, `Id_admin`, `Nombre_categoria`, `Descripcion_categoria`, `Ruta_imagen_categoria`) VALUES
(10, 1, 'Buzo', 'Abrigado', '/public/storage/uploads/buzo.jpg'),
(12, 1, 'Camiseta', 'Para el cuerpo', '/public/storage/uploads/camiseta.jpg'),
(13, 1, 'Zapatos', 'Para los pies', '/public/storage/uploads/zapatos.jpg');

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
  `Suscripcion_newsletter` tinyint(1) NOT NULL,
  `Ciudad` varchar(60) DEFAULT 'Ciudad no asignada',
  `Calle` varchar(60) DEFAULT 'Calle no asignada',
  `NroCasa` varchar(60) DEFAULT 'Nro de casa no asignada'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`Id_cliente`, `Suscripcion_newsletter`, `Ciudad`, `Calle`, `NroCasa`) VALUES
(3, 0, 'Ciudad no asignada', 'Calle no asignada', 'Nro de casa no asignada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `Id_compra` int(11) NOT NULL,
  `Id_cliente` int(11) NOT NULL,
  `Costo_total` double(9,2) DEFAULT NULL,
  `Valoracion` varchar(300) DEFAULT NULL
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
  `Precio_por_producto` double(8,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `Id_producto` int(11) NOT NULL,
  `Id_admin` int(11) NOT NULL,
  `Id_categoria` int(11) NOT NULL,
  `Nombre` varchar(60) DEFAULT NULL,
  `Precio_actual` double(8,2) DEFAULT NULL,
  `Descuento` double(5,2) DEFAULT NULL,
  `Descripcion_producto` varchar(300) DEFAULT NULL,
  `Ruta_imagen_producto` varchar(300) DEFAULT NULL,
  `Cantidad` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`Id_producto`, `Id_admin`, `Id_categoria`, `Nombre`, `Precio_actual`, `Descuento`, `Descripcion_producto`, `Ruta_imagen_producto`, `Cantidad`) VALUES
(16, 1, 10, 'BuzoMo', 300.00, 1.00, 'Desc', '/public/storage/uploads/buzo.jpg', 30),
(17, 1, 13, 'ZapatosMO', 200.00, 0.00, 'Desc', '/public/storage/uploads/zapatos.jpg', 10),
(18, 1, 12, 'CamisetaMO', 200.00, 0.00, 'Desc', '/public/storage/uploads/camiseta.jpg', 10);

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
(3, 'Nombre no asignado', 'usuario1@gmail.com', '$2y$10$pLG0bldc5y7t/9uWQaTo3OGHxvCdk6zDltxYbNJ19SsoacQsYqmXa', 2);

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
  ADD KEY `Id_cliente` (`Id_cliente`);

--
-- Indices de la tabla `compra_contiene_producto`
--
ALTER TABLE `compra_contiene_producto`
  ADD PRIMARY KEY (`Id_compra`,`Id_producto`),
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
  MODIFY `Id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `Id_compra` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `Id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `Id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
  ADD CONSTRAINT `compras_ibfk_1` FOREIGN KEY (`Id_cliente`) REFERENCES `clientes` (`Id_cliente`);

--
-- Filtros para la tabla `compra_contiene_producto`
--
ALTER TABLE `compra_contiene_producto`
  ADD CONSTRAINT `compra_contiene_producto_ibfk_1` FOREIGN KEY (`Id_compra`) REFERENCES `compras` (`Id_compra`),
  ADD CONSTRAINT `compra_contiene_producto_ibfk_2` FOREIGN KEY (`Id_producto`) REFERENCES `productos` (`Id_producto`);

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
