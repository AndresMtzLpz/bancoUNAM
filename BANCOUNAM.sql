-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 23-02-2020 a las 05:45:23
-- Versión del servidor: 10.4.11-MariaDB
-- Versión de PHP: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

/*******************************************************************/
-- Base de datos: `bancoUNAM`
/*******************************************************************/



/*******************************************************************/
-- Estructura de tabla para la tabla `accesoAdmin`

CREATE TABLE `accesoAdmin` (
  `id_admin` int(4) NOT NULL,
  `contra_admin` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- Insertando datos para la tabla `accesoAdmin`
INSERT INTO `accesoAdmin` (`id_admin`, `contra_admin`) VALUES
(1234, 'contra1'),
(1235, 'contra2'),
(1236, 'contra3');

/*******************************************************************/


/*******************************************************************/
-- Estructura de tabla para la tabla `datosAdmin`

CREATE TABLE `datosAdmin` (
  `id_admin` int(4) NOT NULL,
  `nombre_admin` varchar(20) NOT NULL,
  `puesto_admin` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- Insertando datos para la tabla `datosAdmin`
INSERT INTO `datosAdmin` (`id_admin`, `nombre_admin`, `puesto_admin`) VALUES
(1234, 'Andres', 'administrador'),
(1235, 'Amós', 'administrador'),
(1236, 'Oscar', 'administrador');

/*******************************************************************/


/*******************************************************************/
-- Estructura de tabla para la tabla `datosCliente`

CREATE TABLE `datosCliente` (
  `id_cliente` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_cliente` varchar(20) NOT NULL,
  `A_Paterno_cliente` varchar(20) NOT NULL,
  `A_Materno_cliente` varchar(20) NOT NULL,
  `Contraseña` varchar(20) NOT NULL,
  `Telefono` int(15) NOT NULL,
  `Email` varchar(30) NOT NULL,
  `edad_cliente` int(3) NOT NULL,
  PRIMARY KEY (`id_cliente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insertando datos para la tabla `datosCliente`
INSERT INTO `datosCliente` (`nombre_cliente`, `A_Paterno_cliente`, `A_Materno_cliente`,`Contraseña`,
  `Telefono`,`Email`, `edad_cliente`) VALUES
('Rodrigo', 'Martínez','Lopez','micontraseña1',5540519495,'correo',33),
('Andres','Martínez','Lopez','micontraseña2',5540519495,'correo', 30),
('Ulises','Hernandez','Cuellar','micontraseña3',5540519495,'correo', 45);

/*******************************************************************/


/*******************************************************************/
-- Estructura de tabla para la tabla `tarjeta_cliente`

CREATE TABLE `tarjeta_cliente` (
  `id_cliente` int(11) NOT NULL AUTO_INCREMENT ,
  `num_cuenta` int(11) NOT NULL ,
  `saldo` float NOT NULL,
   PRIMARY KEY (`num_cuenta`),
  FOREIGN KEY (id_cliente) REFERENCES datosCliente(id_cliente)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insertando datos para la tabla `tarjeta_cliente`
INSERT INTO `tarjeta_cliente` (`num_cuenta`, `saldo`) VALUES
(314046, 5000000),
(314047, 250000),
(314048, 125000);

/*******************************************************************/


/*******************************************************************/
-- Estructura de tabla para la tabla `depositos_cliente`

CREATE TABLE `depositos_cliente` (
  `id_deposito` int(11) NOT NULL AUTO_INCREMENT,
  `id_cliente` int(11) NOT NULL ,
  `num_cuenta` int(11) NOT NULL,
  `cantidad_deposito` float NOT NULL,
  `date_deposito` date NOT NULL,
  `saldo_corte` int(11) NOT NULL,
  PRIMARY KEY (`id_deposito`),
  FOREIGN KEY (id_cliente) REFERENCES datosCliente(id_cliente),
  FOREIGN KEY (num_cuenta) REFERENCES tarjeta_cliente(num_cuenta)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insertando datos para la tabla `depositos_cliente`
INSERT INTO `depositos_cliente` (`id_deposito`,`id_cliente`,`num_cuenta`,  `cantidad_deposito`, `date_deposito`,`saldo_corte`) VALUES
(0001,1, 314046, 2000, '2021-02-12',SYSDATE()),
(0002,2, 314047, 50000, '2021-02-01',SYSDATE()),
(0003,3, 314048, 50500, '2021-02-14',SYSDATE());

/*******************************************************************/


/*******************************************************************/
-- Indices de la tabla `accesoAdmin`
--
ALTER TABLE `accesoAdmin`
  ADD PRIMARY KEY (`id_admin`);

-- Indices de la tabla `datosAdmin`
--
ALTER TABLE `datosAdmin`
  ADD PRIMARY KEY (`id_admin`);


/*******************************************************************/
-- Constraints para la tabla `accesoAdmin`
ALTER TABLE `accesoAdmin`
  ADD CONSTRAINT `eliminaAdmin` FOREIGN KEY (`id_admin`) REFERENCES `datosAdmin` (`id_admin`) ON DELETE CASCADE;

commit;