CREATE OR REPLACE TABLE proveedores(
	id INT PRIMARY KEY AUTO_INCREMENT,
    razon_social VARCHAR(20)UNIQUE,
    email VARCHAR(30)UNIQUE,
   	cif VARCHAR(9) UNIQUE,
    direccion VARCHAR(40),
    codigo_postal INT(6),
    poblacion VARCHAR(30),
    provincia VARCHAR(30),
    telefono INT(9));

CREATE OR REPLACE TABLE clientes(
	id INT PRIMARY KEY AUTO_INCREMENT,
    razon_social VARCHAR(20)UNIQUE,
    email VARCHAR(30) UNIQUE,
   	cif VARCHAR(9) UNIQUE,
    direccion VARCHAR(40),
    codigo_postal INT(6),
    poblacion VARCHAR(30),
    provincia VARCHAR(30),
    telefono INT(9),
    contrasena VARCHAR(20));

CREATE OR REPLACE TABLE empleados( 
	id INT PRIMARY KEY AUTO_INCREMENT,
	nombre VARCHAR(30), 
	apellidos VARCHAR(60), 
	nif VARCHAR(9) UNIQUE, 
	email VARCHAR(30) UNIQUE, 
	contrasena VARCHAR(20));

CREATE OR REPLACE TABLE articulos(
	id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(40),
    p_coste DECIMAL(10,2),
    p_venta DECIMAL (10,2),
    ean BIGINT(13) UNIQUE,
    stock int(3),
    foto varchar(100),
    id_proveedor int references proveedores (id));

CREATE OR REPLACE TABLE compras(
	id INT PRIMARY KEY AUTO_INCREMENT,
    fecha timestamp,
    sesion_compra varchar(50) UNIQUE,
    id_empleado int references empleados (id));
 	

CREATE OR REPLACE TABLE ventas(
	id INT PRIMARY KEY AUTO_INCREMENT,
    fecha timestamp,
    sesion_venta varchar(50) UNIQUE,
    id_cliente int references clientes (id));

CREATE OR REPLACE TABLE articulos_ventas(
	id_venta int references ventas(id),
	id_articulo int references articulos(id),
	cantidad int (3),
	PRIMARY KEY (id_venta,id_articulo));

CREATE OR REPLACE TABLE articulos_compras(
	id_compra int references compras(id),
	id_articulo int references articulos(id),
	cantidad int (3),
	PRIMARY KEY (id_compra,id_articulo));