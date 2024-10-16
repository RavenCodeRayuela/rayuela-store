CREATE DATABASE RAYUELA;

CREATE TABLE TIPO_DE_USUARIO(    
    Id_tipo int NOT NULL PRIMARY KEY,
    Rol varchar(50) NOT NULL
    );


CREATE TABLE USUARIOS(
    Id_usuario int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Nombre varchar(50) DEFAULT "Nombre no asignado",
    Email varchar(100) NOT NULL,
    password varchar(255) NOT NULL,
    Id_tipo int NOT NULL,
    FOREIGN KEY(Id_tipo) REFERENCES TIPO_DE_USUARIO(Id_tipo)
     );

CREATE TABLE CLIENTES(
    Id_cliente int NOT NULL PRIMARY KEY,
    Suscripcion_newsletter boolean NOT NULL,
    FOREIGN KEY(Id_cliente) REFERENCES USUARIOS(Id_usuario)
);

CREATE TABLE DIRECCIONES_DE_ENVIO(
    Id_direccion int NOT NULL PRIMARY KEY,
    Ciudad varchar(60) DEFAULT "Ciudad no asignada",
    Calle varchar(60) DEFAULT "Calle no asignada",
    NroCasa varchar(60) DEFAULT "Nro de casa no asignada",
    Id_cliente int NOT NULL,
    FOREIGN KEY(Id_cliente) REFERENCES CLIENTES(Id_cliente)
);

CREATE TABLE CELULARES(
    Numero_cel varchar(15) NOT NULL,
    Id_cliente int NOT NULL,
    PRIMARY KEY(Numero_cel,Id_cliente),
    FOREIGN KEY(Id_cliente) REFERENCES CLIENTES(Id_cliente)
);

CREATE TABLE ADMINISTRADOR(
    Id_admin int NOT NULL PRIMARY KEY,
    FOREIGN KEY(Id_admin) REFERENCES USUARIOS(Id_usuario)
);

CREATE TABLE CATEGORIAS(
    Id_categoria int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Id_admin int NOT NULL,
    Nombre_categoria varchar(60),
    Descripcion_categoria varchar(125),
    Ruta_imagen_categoria varchar(300),
    FOREIGN KEY(Id_admin) REFERENCES ADMINISTRADOR(Id_admin)
);

CREATE TABLE COMPRAS(
    Id_compra int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    Id_cliente int NOT NULL,
    Costo_total DOUBLE(9,2),
    Valoracion varchar(300),
    Estado varchar(30),
    Tipo_de_pago varchar(30),
    FOREIGN KEY(Id_cliente) REFERENCES CLIENTES(Id_cliente)
);

CREATE TABLE PRODUCTOS(
    Id_producto int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    Id_admin int NOT NULL,
    Id_categoria int NOT NULL,
    Nombre varchar(60),
    Precio_actual DOUBLE(7,2),
    Descuento DOUBLE(5,2),
    Descripcion_producto varchar(300),
    Cantidad int,
    FOREIGN KEY(Id_admin) REFERENCES ADMINISTRADOR(Id_admin),
    FOREIGN KEY(Id_categoria) REFERENCES CATEGORIAS(Id_categoria)
);

CREATE TABLE IMAGEN_PRODUCTO(
    Ruta_imagen_producto varchar(300) NOT NULL,
    Id_imagen int NOT NULL AUTO_INCREMENT,
    Id_producto int NOT NULL,
    PRIMARY KEY(Id_imagen,Id_producto),
    FOREIGN KEY(Id_producto) REFERENCES PRODUCTOS(Id_producto)
);

CREATE TABLE COMPRA_CONTIENE_PRODUCTO(
    Id_compra int NOT NULL,
    Id_producto int NOT NULL,
    Fecha DATE,
    Cantidad_producto int,
    Precio_por_producto DOUBLE(7,2),
    PRIMARY KEY(Id_compra,Id_producto),
    FOREIGN KEY(Id_compra) REFERENCES COMPRAS(Id_compra),
    FOREIGN KEY(Id_producto) REFERENCES PRODUCTOS(Id_producto)
);


/*Agregar luego de creada la base de datos*/
INSERT INTO `tipo_de_usuario` (`Id_tipo`, `Rol`) VALUES
(1, 'Admin'),
(2, 'Cliente');

INSERT INTO `usuarios` (`Id_usuario`, `Nombre`, `Email`, `password`, `Id_tipo`) VALUES
(1, 'Nombre no asignado', 'admin@gmail.com', '$2y$10$pLG0bldc5y7t/9uWQaTo3OGHxvCdk6zDltxYbNJ19SsoacQsYqmXa', 1),
(3, 'Nombre no asignado', 'usuario1@gmail.com', '$2y$10$pLG0bldc5y7t/9uWQaTo3OGHxvCdk6zDltxYbNJ19SsoacQsYqmXa', 2);


INSERT INTO `clientes` (`Id_cliente`, `Suscripcion_newsletter`) VALUES
(3, 0);


INSERT INTO `administrador` (`Id_admin`) VALUES
(1);
