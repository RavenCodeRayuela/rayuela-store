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
    Ciudad varchar(60) DEFAULT "Ciudad no asignada",
    Calle varchar(60) DEFAULT "Calle no asignada",
    NroCasa varchar(60) DEFAULT "Nro de casa no asignada",
    FOREIGN KEY(Id_cliente) REFERENCES USUARIOS(Id_usuario)
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
    Descripcion_categoria varchar(300),
    Ruta_imagen_categoria varchar(300),
    FOREIGN KEY(Id_admin) REFERENCES ADMINISTRADOR(Id_admin)
);

CREATE TABLE COMPRAS(
    Id_compra int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    Id_cliente int NOT NULL,
    Costo_total DOUBLE(9,2),
    Valoracion varchar(300),
    FOREIGN KEY(Id_cliente) REFERENCES CLIENTES(Id_cliente)
);

CREATE TABLE PRODUCTOS(
    Id_producto int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    Id_admin int NOT NULL,
    Id_categoria int NOT NULL,
    Nombre varchar(60),
    Precio_actual DOUBLE(5,2),
    Descuento DOUBLE(3,2),
    Descripcion_producto varchar(300),
    Ruta_imagen_producto varchar(300),
    Cantidad int,
    FOREIGN KEY(Id_admin) REFERENCES ADMINISTRADOR(Id_admin),
    FOREIGN KEY(Id_categoria) REFERENCES CATEGORIAS(Id_categoria)
);

CREATE TABLE COMPRA_CONTIENE_PRODUCTO(
    Id_compra int NOT NULL,
    Id_producto int NOT NULL,
    Fecha DATE,
    Cantidad_producto int,
    Precio_por_producto DOUBLE(5,2),
    PRIMARY KEY(Id_compra,Id_producto),
    FOREIGN KEY(Id_compra) REFERENCES COMPRAS(Id_compra),
    FOREIGN KEY(Id_producto) REFERENCES PRODUCTOS(Id_producto)
);