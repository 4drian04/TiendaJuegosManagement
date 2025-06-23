CREATE TABLE cliente (
	idCliente INT auto_increment NOT NULL,
	nombre varchar(20) NOT NULL,
	apellido1 varchar(20),
	apellido2 varchar(20),
	usuario varchar(100) NOT NULL,
	contrasenha varchar(8) NOT NULL,
	edad INT,
	CONSTRAINT cliente_pk PRIMARY KEY (idCliente),
	CONSTRAINT cliente_unique UNIQUE KEY (usuario),
	constraint edad_check check (edad>0 and edad<99)
);

CREATE TABLE proveedor (
	idProveedor INT auto_increment NOT NULL,
	nombre varchar(20) NOT NULL,
	telefono varchar(9) DEFAULT NULL,
	CONSTRAINT Proveedor_pk PRIMARY KEY (idProveedor)
);

CREATE TABLE producto (
	idProducto INT auto_increment NOT NULL,
	nombre varchar(50) NOT NULL,
	precio decimal(6,2) NOT NULL,
	plataforma varchar(20),
	idProveedor INT,
	CONSTRAINT producto_pk PRIMARY KEY (idProducto),
	CONSTRAINT producto_proveedor_FK FOREIGN KEY (idProveedor) REFERENCES proveedor(idProveedor),
	constraint precio_check check (precio>0)
);

CREATE TABLE compra (
	idCompra INT auto_increment NOT NULL,
	fecha DATE NOT NULL,
	idCliente INT,
	CONSTRAINT compra_pk PRIMARY KEY (idCompra),
	CONSTRAINT compra_cliente_FK FOREIGN KEY (idCliente) REFERENCES cliente(idCliente)
);

CREATE TABLE linea_compra (
	idCompra INT,
	idProducto INT,
	cantidad INT NOT NULL DEFAULT 1,
	CONSTRAINT linea_compra_pk PRIMARY KEY (idCompra,idProducto),
	CONSTRAINT linea_compra_producto_FK FOREIGN KEY (idProducto) REFERENCES producto(idProducto),
	CONSTRAINT linea_compra_compra_FK FOREIGN KEY (idCompra) REFERENCES compra(idCompra)
);