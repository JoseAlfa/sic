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
  `id_cliente` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(20) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `direccion` varchar(200) DEFAULT NULL,
  `empresa` tinyint(4) DEFAULT '0',
  `mostrar` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id_cliente`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla sic_db.clientes: ~2 rows (aproximadamente)
DELETE FROM `clientes`;
/*!40000 ALTER TABLE `clientes` DISABLE KEYS */;
INSERT INTO `clientes` (`id_cliente`, `nombre`, `correo`, `telefono`, `direccion`, `empresa`, `mostrar`) VALUES
	(1, 'nissan', 'nisan@gmail.com', '3322211', 'oooooo', 1, 0),
	(2, 'Alfonzo Carreta', 'alfonzo@gmail.com', '2147483647', 'conocida ayer', 0, 0);
/*!40000 ALTER TABLE `clientes` ENABLE KEYS */;

-- Volcando estructura para tabla sic_db.imagenes
CREATE TABLE IF NOT EXISTS `imagenes` (
  `id_imagen` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) NOT NULL,
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
  `id_marca` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `clave` varchar(100) DEFAULT NULL,
  `detalles` varchar(100) DEFAULT NULL,
  `imagen` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_marca`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sic_db.marcas: ~4 rows (aproximadamente)
DELETE FROM `marcas`;
/*!40000 ALTER TABLE `marcas` DISABLE KEYS */;
INSERT INTO `marcas` (`id_marca`, `nombre`, `clave`, `detalles`, `imagen`) VALUES
	(1, 'Phills', '09888ERR', 'Sin detalles', NULL),
	(2, 'Petrul', '0099333', 'Mas detalles', 'd'),
	(19, 'Truper', '0888999', 'Sin detalles', 'd'),
	(26, 'marca', '0998882', 'nueva marca', NULL);
/*!40000 ALTER TABLE `marcas` ENABLE KEYS */;

-- Volcando estructura para tabla sic_db.personas
CREATE TABLE IF NOT EXISTS `personas` (
  `id_persona` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `apellidos` varchar(100) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id_persona`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sic_db.personas: ~4 rows (aproximadamente)
DELETE FROM `personas`;
/*!40000 ALTER TABLE `personas` DISABLE KEYS */;
INSERT INTO `personas` (`id_persona`, `nombre`, `apellidos`, `correo`, `telefono`) VALUES
	(1, 'Rigoberto', 'Nava Diaz', 'rigo@gmail.com', 'rigo@gmail.com'),
	(2, 'Jose Alfredo', 'Jimenez', 'joshdev2812@gmail.com', 'joshdev2812@gma'),
	(5, 'Manuel', 'Morales Ulin', 'manuelulin@gmail.com', 'manuelulin@gmai'),
	(6, 'maria', 'Osorio lopez', 'marioso@gmail.com', 'marioso@gmail.c');
/*!40000 ALTER TABLE `personas` ENABLE KEYS */;

-- Volcando estructura para tabla sic_db.presupuestos
CREATE TABLE IF NOT EXISTS `presupuestos` (
  `id_pre_save` int(11) NOT NULL AUTO_INCREMENT,
  `id_cliente` int(11) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `clave` varchar(50) DEFAULT NULL,
  `detalles` text,
  `liberado` tinyint(4) DEFAULT '0' COMMENT 'para saver si es un borrador',
  `plantilla` tinyint(4) DEFAULT '0' COMMENT 'Para saber si es plantilla',
  PRIMARY KEY (`id_pre_save`),
  KEY `FK_presupuestos_save_clientes` (`id_cliente`),
  KEY `FK_presupuestos_usuarios` (`id_usuario`),
  CONSTRAINT `FK_presupuestos_save_clientes` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`),
  CONSTRAINT `FK_presupuestos_usuarios` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Presupuestos guardados';

-- Volcando datos para la tabla sic_db.presupuestos: ~0 rows (aproximadamente)
DELETE FROM `presupuestos`;
/*!40000 ALTER TABLE `presupuestos` DISABLE KEYS */;
/*!40000 ALTER TABLE `presupuestos` ENABLE KEYS */;

-- Volcando estructura para tabla sic_db.presupuesto_productos
CREATE TABLE IF NOT EXISTS `presupuesto_productos` (
  `id_pre_pro` int(11) NOT NULL AUTO_INCREMENT,
  `id_producto` int(11) NOT NULL DEFAULT '0',
  `id_pre_save` int(11) NOT NULL DEFAULT '0',
  `precio` varchar(70) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_pre_pro`),
  KEY `FK_pre_save_productos_presupuestos_save` (`id_pre_save`),
  KEY `FK_pre_save_productos_productos` (`id_producto`),
  CONSTRAINT `FK_pre_save_productos_presupuestos_save` FOREIGN KEY (`id_pre_save`) REFERENCES `presupuestos` (`id_pre_save`),
  CONSTRAINT `FK_pre_save_productos_productos` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='para los presupuestos ya guardados';

-- Volcando datos para la tabla sic_db.presupuesto_productos: ~0 rows (aproximadamente)
DELETE FROM `presupuesto_productos`;
/*!40000 ALTER TABLE `presupuesto_productos` DISABLE KEYS */;
/*!40000 ALTER TABLE `presupuesto_productos` ENABLE KEYS */;

-- Volcando estructura para tabla sic_db.productos
CREATE TABLE IF NOT EXISTS `productos` (
  `id_producto` int(11) NOT NULL AUTO_INCREMENT,
  `id_marca` int(11) DEFAULT NULL,
  `id_tipo` int(11) DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `clave` varchar(100) DEFAULT NULL,
  `detalles` varchar(200) DEFAULT 'Sin detalles',
  `imagen` varchar(60) DEFAULT 'producto.png',
  PRIMARY KEY (`id_producto`),
  KEY `FK_productos_marcas` (`id_marca`),
  KEY `FK_productos_tipos_producto` (`id_tipo`),
  CONSTRAINT `FK_productos_marcas` FOREIGN KEY (`id_marca`) REFERENCES `marcas` (`id_marca`),
  CONSTRAINT `FK_productos_tipos_producto` FOREIGN KEY (`id_tipo`) REFERENCES `tipos_producto` (`id_tipo`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sic_db.productos: ~6 rows (aproximadamente)
DELETE FROM `productos`;
/*!40000 ALTER TABLE `productos` DISABLE KEYS */;
INSERT INTO `productos` (`id_producto`, `id_marca`, `id_tipo`, `nombre`, `clave`, `detalles`, `imagen`) VALUES
	(1, 2, 1, 'cable utp cat 5', '099923', 'Sin detalles', 'PRO_2N0yEg2YMXG.jpg'),
	(2, 26, 2, 'Conectores', '9888222', 'Sin detalles', 'PRO_26HLfp07lJt.jpg'),
	(3, 19, 2, 'Antena', 'dd', 'Sin detalles', 'producto.png'),
	(4, 19, 5, 'pinza', '00122', 'Sin detalles', 'PRO_2nU4TQfa8N1.jpg'),
	(5, 1, 2, 'producto', '099', 'dsf', 'PRO_2amx5WjPt98.jpg'),
	(6, 26, 5, 'nuevo', '98811', 'Sin detalles', 'PRO_2kMuYVcvz9y.jpg');
/*!40000 ALTER TABLE `productos` ENABLE KEYS */;

-- Volcando estructura para tabla sic_db.proyectos
CREATE TABLE IF NOT EXISTS `proyectos` (
  `id_proyecto` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL DEFAULT '0' COMMENT 'usuario que registro el proyecto',
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(500) NOT NULL,
  `id_imagen` int(11) NOT NULL,
  PRIMARY KEY (`id_proyecto`),
  KEY `imagenes_proyectos_fk` (`id_imagen`),
  KEY `FK_proyectos_usuarios` (`id_usuario`),
  CONSTRAINT `FK_proyectos_imagenes` FOREIGN KEY (`id_imagen`) REFERENCES `imagenes` (`id_imagen`),
  CONSTRAINT `FK_proyectos_usuarios` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla sic_db.proyectos: ~0 rows (aproximadamente)
DELETE FROM `proyectos`;
/*!40000 ALTER TABLE `proyectos` DISABLE KEYS */;
INSERT INTO `proyectos` (`id_proyecto`, `id_usuario`, `nombre`, `descripcion`, `id_imagen`) VALUES
	(1, 1, 'Proyecto 1', 'Site Susuki', 6);
/*!40000 ALTER TABLE `proyectos` ENABLE KEYS */;

-- Volcando estructura para tabla sic_db.servicios
CREATE TABLE IF NOT EXISTS `servicios` (
  `id_servicio` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL DEFAULT '0' COMMENT 'Usuario que registro este el servicio',
  `nombre` varchar(150) NOT NULL,
  `descripcion` varchar(1000) NOT NULL,
  `id_imagen` int(11) NOT NULL,
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
  `id_tipo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `detalles` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id_tipo`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sic_db.tipos_producto: ~2 rows (aproximadamente)
DELETE FROM `tipos_producto`;
/*!40000 ALTER TABLE `tipos_producto` DISABLE KEYS */;
INSERT INTO `tipos_producto` (`id_tipo`, `nombre`, `detalles`) VALUES
	(1, 'Cable', 'De cobre'),
	(2, 'Antena', 'conexion inalambrica'),
	(5, 'General', 'Tipos de productos no clasificados aún');
/*!40000 ALTER TABLE `tipos_producto` ENABLE KEYS */;

-- Volcando estructura para tabla sic_db.usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `id_persona` int(11) NOT NULL DEFAULT '0',
  `nombre` varchar(50) DEFAULT NULL,
  `contrasena` varchar(100) DEFAULT NULL,
  `color` varchar(50) DEFAULT 'red',
  `administrador` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id_usuario`),
  KEY `FK_usuarios_personas` (`id_persona`),
  CONSTRAINT `FK_usuarios_personas` FOREIGN KEY (`id_persona`) REFERENCES `personas` (`id_persona`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sic_db.usuarios: ~4 rows (aproximadamente)
DELETE FROM `usuarios`;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` (`id_usuario`, `id_persona`, `nombre`, `contrasena`, `color`, `administrador`) VALUES
	(1, 1, 'rigo', '202cb962ac59075b964b07152d234b70', 'red', 1),
	(2, 2, 'root', '202cb962ac59075b964b07152d234b70', 'green', 1),
	(5, 5, 'manuel', 'a1c330d04bcf264eaa35ca0706597ea1', 'red', 0),
	(6, 6, 'mari', '202cb962ac59075b964b07152d234b70', 'red', 0);
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
