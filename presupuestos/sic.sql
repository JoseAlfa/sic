-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         10.1.37-MariaDB-0+deb9u1 - Debian 9.6
-- SO del servidor:              debian-linux-gnu
-- HeidiSQL Versión:             9.5.0.5196
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Volcando estructura de base de datos para sic_db
CREATE DATABASE IF NOT EXISTS `sic_db` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `sic_db`;

-- Volcando estructura para tabla sic_db.clientes
CREATE TABLE IF NOT EXISTS `clientes` (
  `id_cliente` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificador del registro',
  `nombre` varchar(20) NOT NULL COMMENT 'nombre del cliente',
  `correo` varchar(100) NOT NULL COMMENT 'correo del cliente',
  `telefono` varchar(15) DEFAULT NULL COMMENT 'telefono del cliente',
  `direccion` varchar(200) DEFAULT NULL COMMENT 'direccion del cliente',
  `empresa` tinyint(4) DEFAULT '0' COMMENT 'determina si es empresa o persona fisica',
  `mostrar` tinyint(4) DEFAULT '0' COMMENT 'determina si se muestra en el curriculum emresarial',
  `cp` varchar(50) DEFAULT NULL,
  `atn` varchar(200) DEFAULT NULL,
  `foto` varchar(200) DEFAULT 'cliente.png',
  PRIMARY KEY (`id_cliente`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla sic_db.clientes: ~3 rows (aproximadamente)
DELETE FROM `clientes`;
/*!40000 ALTER TABLE `clientes` DISABLE KEYS */;
INSERT INTO `clientes` (`id_cliente`, `nombre`, `correo`, `telefono`, `direccion`, `empresa`, `mostrar`, `cp`, `atn`, `foto`) VALUES
	(1, 'nissan', 'nisan@gmail.com', '3322211', 'Av. 16 de Septiembre ', 1, 1, '333222', '', 'CLI_1agLRmep5Bl.png'),
	(2, 'Alfonzo Carreta', 'alfonzo@gmail.com', '2751093240', 'conocida ayer', 0, 1, '9999999', '', 'cliente.png');
/*!40000 ALTER TABLE `clientes` ENABLE KEYS */;

-- Volcando estructura para tabla sic_db.componenetes
CREATE TABLE IF NOT EXISTS `componenetes` (
  `id_componenete` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identiiacor del registro',
  `id_user` int(11) NOT NULL DEFAULT '0' COMMENT 'creador del componente',
  `nombre` varchar(50) DEFAULT NULL COMMENT 'nombre delcomponente',
  `contenido` text COMMENT 'contenido del componente',
  PRIMARY KEY (`id_componenete`),
  KEY `FK_componenetes_usuarios` (`id_user`),
  CONSTRAINT `FK_componenetes_usuarios` FOREIGN KEY (`id_user`) REFERENCES `usuarios` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='son los cmponentes de la pagina web y tambin los compnentes para la creación de los arcivos pdf';

-- Volcando datos para la tabla sic_db.componenetes: ~0 rows (aproximadamente)
DELETE FROM `componenetes`;
/*!40000 ALTER TABLE `componenetes` DISABLE KEYS */;
/*!40000 ALTER TABLE `componenetes` ENABLE KEYS */;

-- Volcando estructura para tabla sic_db.empresa
CREATE TABLE IF NOT EXISTS `empresa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `direccion` varchar(300) DEFAULT NULL,
  `telefono` varchar(50) DEFAULT NULL,
  `movil` varchar(50) DEFAULT NULL,
  `correo` varchar(50) DEFAULT NULL,
  `firma` varchar(150) DEFAULT NULL,
  `detalles` text,
  `ceo` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_empresa_personas` (`ceo`),
  CONSTRAINT `FK_empresa_personas` FOREIGN KEY (`ceo`) REFERENCES `personas` (`id_persona`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='datos de la empresa';

-- Volcando datos para la tabla sic_db.empresa: ~0 rows (aproximadamente)
DELETE FROM `empresa`;
/*!40000 ALTER TABLE `empresa` DISABLE KEYS */;
INSERT INTO `empresa` (`id`, `nombre`, `direccion`, `telefono`, `movil`, `correo`, `firma`, `detalles`, `ceo`) VALUES
	(1, 'Soluciones Integrales & Comunicación', 'Andador Antono Soler #114 Col Infonavit Atasta C.P. 86100. Villahermosa, Centro, Tabasco.', '(993) 4123782', '9931526143 ', 'soluciones_integral@hotmail.com', 'Rigoberto Nava Díaz', 'Empresa de servicios integrales', 1);
/*!40000 ALTER TABLE `empresa` ENABLE KEYS */;

-- Volcando estructura para tabla sic_db.imagenes
CREATE TABLE IF NOT EXISTS `imagenes` (
  `id_imagen` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificador',
  `nombre` varchar(200) NOT NULL COMMENT 'nombre de la imagen',
  PRIMARY KEY (`id_imagen`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla sic_db.imagenes: ~7 rows (aproximadamente)
DELETE FROM `imagenes`;
/*!40000 ALTER TABLE `imagenes` DISABLE KEYS */;
INSERT INTO `imagenes` (`id_imagen`, `nombre`) VALUES
	(1, 'gallery-image-1.jpg'),
	(2, 'gallery-image-3.jpg'),
	(3, 'gallery-image-8.jpg'),
	(4, 'battery.png'),
	(5, 'mobile.png'),
	(6, 'gallery-image-1.jpg'),
	(7, 'blog-image-1.jpg');
/*!40000 ALTER TABLE `imagenes` ENABLE KEYS */;

-- Volcando estructura para tabla sic_db.marcas
CREATE TABLE IF NOT EXISTS `marcas` (
  `id_marca` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificador',
  `nombre` varchar(100) NOT NULL COMMENT 'nombre de la marca',
  `clave` varchar(100) NOT NULL COMMENT 'clave de la marca',
  `detalles` varchar(100) NOT NULL COMMENT 'detalles de la marca',
  `imagen` varchar(50) NOT NULL COMMENT 'foto o logo',
  PRIMARY KEY (`id_marca`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sic_db.marcas: ~5 rows (aproximadamente)
DELETE FROM `marcas`;
/*!40000 ALTER TABLE `marcas` DISABLE KEYS */;
INSERT INTO `marcas` (`id_marca`, `nombre`, `clave`, `detalles`, `imagen`) VALUES
	(1, 'Phillss', '09888ERR', 'Sin detalles', ''),
	(2, 'Petrul', '0099333', 'Mas detalles', 'd'),
	(19, 'Truper', '0888999', 'Sin detalles', 'd'),
	(26, 'marca', '0998882', 'nueva marca', '');
/*!40000 ALTER TABLE `marcas` ENABLE KEYS */;

-- Volcando estructura para tabla sic_db.personas
CREATE TABLE IF NOT EXISTS `personas` (
  `id_persona` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificador',
  `nombre` varchar(100) DEFAULT NULL COMMENT 'nombre de la persona',
  `apellidos` varchar(100) DEFAULT NULL COMMENT 'apellidos',
  `correo` varchar(100) DEFAULT NULL COMMENT 'correo electronico',
  `telefono` varchar(15) DEFAULT NULL COMMENT 'telefono de la persona',
  `titulo` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_persona`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sic_db.personas: ~3 rows (aproximadamente)
DELETE FROM `personas`;
/*!40000 ALTER TABLE `personas` DISABLE KEYS */;
INSERT INTO `personas` (`id_persona`, `nombre`, `apellidos`, `correo`, `telefono`, `titulo`) VALUES
	(1, 'Rigoberto', 'Nava Diaz', 'rigo@gmail.com', '9931234567', 'Ing. en TI'),
	(2, 'Jose Alfredo', 'Jimenez', 'joshdev2812@gmail.com', '9331111111', NULL),
	(5, 'Manuel', 'Morales Ulin', 'manuelulin@gmail.com', 'manuelulin@gmai', NULL);
/*!40000 ALTER TABLE `personas` ENABLE KEYS */;

-- Volcando estructura para tabla sic_db.presupuestos
CREATE TABLE IF NOT EXISTS `presupuestos` (
  `id_presupuesto` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificador',
  `id_cliente` int(11) DEFAULT NULL COMMENT 'cliente',
  `id_usuario` int(11) DEFAULT NULL COMMENT 'usuario que registra',
  `clave` varchar(50) DEFAULT NULL COMMENT 'clave del presupuesto',
  `detalles` text COMMENT 'detalles del presupuesto',
  `liberado` tinyint(4) DEFAULT '0' COMMENT 'para saver si es un borrador',
  `plantilla` tinyint(4) DEFAULT '0' COMMENT 'Para saber si es plantilla',
  `fecha_ini` datetime DEFAULT CURRENT_TIMESTAMP COMMENT 'fecha de creación',
  `fecha_fin` datetime DEFAULT NULL COMMENT 'fecha de terminanción',
  `forma_pago` varchar(200) DEFAULT NULL,
  `vencimiento` varchar(200) DEFAULT NULL,
  `otros_datos` text,
  `iva` decimal(10,0) DEFAULT '16',
  PRIMARY KEY (`id_presupuesto`),
  KEY `FK_presupuestos_save_clientes` (`id_cliente`),
  KEY `FK_presupuestos_usuarios` (`id_usuario`),
  CONSTRAINT `FK_presupuestos_save_clientes` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`),
  CONSTRAINT `FK_presupuestos_usuarios` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='Presupuestos guardados';

-- Volcando datos para la tabla sic_db.presupuestos: ~1 rows (aproximadamente)
DELETE FROM `presupuestos`;
/*!40000 ALTER TABLE `presupuestos` DISABLE KEYS */;
INSERT INTO `presupuestos` (`id_presupuesto`, `id_cliente`, `id_usuario`, `clave`, `detalles`, `liberado`, `plantilla`, `fecha_ini`, `fecha_fin`, `forma_pago`, `vencimiento`, `otros_datos`, `iva`) VALUES
	(4, 2, 1, 'SIC_PRE004', 'Presupuesto cerrado', 0, 1, '2019-04-01 23:04:18', '2019-04-04 23:04:27', 'una sola exibición', '1 mes', NULL, 16);
/*!40000 ALTER TABLE `presupuestos` ENABLE KEYS */;

-- Volcando estructura para tabla sic_db.presupuesto_productos
CREATE TABLE IF NOT EXISTS `presupuesto_productos` (
  `id_pre_pro` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificador',
  `id_producto` int(11) NOT NULL COMMENT 'producto',
  `id_presupuesto` int(11) NOT NULL COMMENT 'presupuesto',
  `precio` float NOT NULL COMMENT 'precio de producto',
  `cantidad` float NOT NULL COMMENT 'cantidad del producto',
  `detalles` varchar(250) NOT NULL,
  PRIMARY KEY (`id_pre_pro`),
  KEY `FK_pre_save_productos_presupuestos_save` (`id_presupuesto`),
  KEY `FK_pre_save_productos_productos` (`id_producto`),
  CONSTRAINT `FK_pre_save_productos_presupuestos_save` FOREIGN KEY (`id_presupuesto`) REFERENCES `presupuestos` (`id_presupuesto`),
  CONSTRAINT `FK_pre_save_productos_productos` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COMMENT='para los presupuestos ya guardados';

-- Volcando datos para la tabla sic_db.presupuesto_productos: ~3 rows (aproximadamente)
DELETE FROM `presupuesto_productos`;
/*!40000 ALTER TABLE `presupuesto_productos` DISABLE KEYS */;
INSERT INTO `presupuesto_productos` (`id_pre_pro`, `id_producto`, `id_presupuesto`, `precio`, `cantidad`, `detalles`) VALUES
	(17, 3, 4, 30000, 1, 'ooo'),
	(18, 1, 4, 3000, 1, ''),
	(20, 2, 4, 5, 30, '');
/*!40000 ALTER TABLE `presupuesto_productos` ENABLE KEYS */;

-- Volcando estructura para tabla sic_db.productos
CREATE TABLE IF NOT EXISTS `productos` (
  `id_producto` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificador',
  `id_marca` int(11) DEFAULT NULL COMMENT 'marca',
  `id_tipo` int(11) DEFAULT NULL COMMENT 'tipo',
  `nombre` varchar(100) DEFAULT NULL COMMENT 'nombre de producto',
  `clave` varchar(100) DEFAULT NULL COMMENT 'clave de prducto',
  `detalles` varchar(200) DEFAULT 'Sin detalles' COMMENT 'detalles de producto',
  `imagen` varchar(100) DEFAULT 'producto.png' COMMENT 'foto o imagende producto',
  `medida` varchar(70) DEFAULT NULL,
  `precio` decimal(10,0) DEFAULT NULL,
  `servicio` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id_producto`),
  KEY `FK_productos_marcas` (`id_marca`),
  KEY `FK_productos_tipos_producto` (`id_tipo`),
  CONSTRAINT `FK_productos_marcas` FOREIGN KEY (`id_marca`) REFERENCES `marcas` (`id_marca`),
  CONSTRAINT `FK_productos_tipos_producto` FOREIGN KEY (`id_tipo`) REFERENCES `tipos_producto` (`id_tipo`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sic_db.productos: ~6 rows (aproximadamente)
DELETE FROM `productos`;
/*!40000 ALTER TABLE `productos` DISABLE KEYS */;
INSERT INTO `productos` (`id_producto`, `id_marca`, `id_tipo`, `nombre`, `clave`, `detalles`, `imagen`, `medida`, `precio`, `servicio`) VALUES
	(1, NULL, 1, 'cableado', '099923', 'Sin detalles', 'PRO_2N0yEg2YMXG.jpg', 'pieza', 12, 0),
	(2, 26, 2, 'Conectores', '9888222', 'Sin detalles', 'PRO_26HLfp07lJt.jpg', NULL, NULL, 0),
	(3, 19, 2, 'Antena', 'dd', 'Sin detalles', 'producto.png', NULL, NULL, 0),
	(4, 19, 5, 'pinzas', '00122', 'Sin detalles', 'PRO_1xpJ5mKMitd.jpg', NULL, NULL, 0),
	(5, 1, 2, 'producto', '099', 'dsf', 'PRO_2amx5WjPt98.jpg', NULL, NULL, 0);
/*!40000 ALTER TABLE `productos` ENABLE KEYS */;

-- Volcando estructura para tabla sic_db.proyectos
CREATE TABLE IF NOT EXISTS `proyectos` (
  `id_proyecto` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificador',
  `id_usuario` int(11) NOT NULL COMMENT 'usuario que registro el proyecto',
  `nombre` varchar(100) NOT NULL COMMENT 'nombre de proyecto',
  `descripcion` varchar(500) NOT NULL COMMENT 'detalles',
  `id_imagen` int(11) NOT NULL COMMENT 'imagen',
  `iva` int(11) NOT NULL DEFAULT '16',
  PRIMARY KEY (`id_proyecto`),
  KEY `imagenes_proyectos_fk` (`id_imagen`),
  KEY `FK_proyectos_usuarios` (`id_usuario`),
  CONSTRAINT `FK_proyectos_imagenes` FOREIGN KEY (`id_imagen`) REFERENCES `imagenes` (`id_imagen`),
  CONSTRAINT `FK_proyectos_usuarios` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla sic_db.proyectos: ~1 rows (aproximadamente)
DELETE FROM `proyectos`;
/*!40000 ALTER TABLE `proyectos` DISABLE KEYS */;
/*!40000 ALTER TABLE `proyectos` ENABLE KEYS */;

-- Volcando estructura para tabla sic_db.servicios
CREATE TABLE IF NOT EXISTS `servicios` (
  `id_servicio` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificador',
  `id_usuario` int(11) NOT NULL COMMENT 'Usuario que registro este el servicio',
  `nombre` varchar(150) NOT NULL COMMENT 'nombre de sevico',
  `descripcion` varchar(1000) NOT NULL COMMENT 'descripción del servicio',
  `id_imagen` int(11) NOT NULL COMMENT 'imagen',
  PRIMARY KEY (`id_servicio`),
  KEY `imagenes_servicios_fk` (`id_imagen`),
  KEY `FK_servicios_usuarios` (`id_usuario`),
  CONSTRAINT `FK_servicios_usuarios` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`),
  CONSTRAINT `imagenes_servicios_fk` FOREIGN KEY (`id_imagen`) REFERENCES `imagenes` (`id_imagen`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla sic_db.servicios: ~2 rows (aproximadamente)
DELETE FROM `servicios`;
/*!40000 ALTER TABLE `servicios` DISABLE KEYS */;
INSERT INTO `servicios` (`id_servicio`, `id_usuario`, `nombre`, `descripcion`, `id_imagen`) VALUES
	(2, 1, 'Servicio 03', 'Tercer servicio', 5),
	(3, 1, 'servicio 4', 'servicio 4', 7);
/*!40000 ALTER TABLE `servicios` ENABLE KEYS */;

-- Volcando estructura para tabla sic_db.tipos_producto
CREATE TABLE IF NOT EXISTS `tipos_producto` (
  `id_tipo` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificador',
  `nombre` varchar(100) DEFAULT NULL COMMENT 'nombre de tipo',
  `detalles` varchar(200) DEFAULT NULL COMMENT 'detalles de tipo',
  PRIMARY KEY (`id_tipo`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sic_db.tipos_producto: ~4 rows (aproximadamente)
DELETE FROM `tipos_producto`;
/*!40000 ALTER TABLE `tipos_producto` DISABLE KEYS */;
INSERT INTO `tipos_producto` (`id_tipo`, `nombre`, `detalles`) VALUES
	(1, 'Servicio', 'Servicio'),
	(2, 'Antena', 'conexion inalambrica'),
	(5, 'General', 'Tipos de productos no clasificados aún');
/*!40000 ALTER TABLE `tipos_producto` ENABLE KEYS */;

-- Volcando estructura para tabla sic_db.usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificador',
  `id_persona` int(11) NOT NULL COMMENT 'persona',
  `nombre` varchar(50) NOT NULL COMMENT 'nombre para usuario',
  `contrasena` varchar(100) NOT NULL COMMENT 'contraseña para usuario',
  `color` varchar(50) DEFAULT 'red' COMMENT 'color de la interfaz',
  `administrador` tinyint(4) DEFAULT '0' COMMENT 'determina si es administrador',
  `activo` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`id_usuario`),
  KEY `FK_usuarios_personas` (`id_persona`),
  CONSTRAINT `FK_usuarios_personas` FOREIGN KEY (`id_persona`) REFERENCES `personas` (`id_persona`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sic_db.usuarios: ~3 rows (aproximadamente)
DELETE FROM `usuarios`;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` (`id_usuario`, `id_persona`, `nombre`, `contrasena`, `color`, `administrador`, `activo`) VALUES
	(1, 1, 'rigo', '202cb962ac59075b964b07152d234b70', 'green', 1, 1),
	(2, 2, 'root', '202cb962ac59075b964b07152d234b70', 'red', 1, 1),
	(5, 5, 'manuel', '202cb962ac59075b964b07152d234b70', 'red', 0, 1);
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
