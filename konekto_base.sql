-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-05-2016 a las 21:25:06
-- Versión del servidor: 5.6.17
-- Versión de PHP: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `konekto`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aparece`
--

CREATE TABLE IF NOT EXISTS `aparece` (
  `Id_usuario` int(11) NOT NULL,
  `Archivo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentario`
--

CREATE TABLE IF NOT EXISTS `comentario` (
  `Id_comentario` int(10) NOT NULL,
  `Texto` text NOT NULL,
  `Fecha` date NOT NULL,
  `Id_usuario` int(6) NOT NULL,
  PRIMARY KEY (`Id_comentario`),
  UNIQUE KEY `Id_usuario` (`Id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fotografia`
--

CREATE TABLE IF NOT EXISTS `fotografia` (
  `Archivo` varchar(40) NOT NULL,
  `Descripcion` varchar(320) NOT NULL,
  `Id_usuario` int(6) NOT NULL,
  PRIMARY KEY (`Archivo`),
  KEY `Id_usuario` (`Id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lista_amigos`
--

CREATE TABLE IF NOT EXISTS `lista_amigos` (
  `Nick` varchar(6) NOT NULL,
  `Correo` varchar(320) NOT NULL,
  `Nombre` varchar(20) NOT NULL,
  `Id_Usuarios` int(6) NOT NULL,
  `Id_amigos` int(6) NOT NULL,
  PRIMARY KEY (`Id_amigos`),
  UNIQUE KEY `Id_Usuarios` (`Id_Usuarios`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `Correo` varchar(320) NOT NULL,
  `Nombre` varchar(20) NOT NULL,
  `Nick` varchar(6) NOT NULL,
  `Clave_acceso` varchar(16) NOT NULL,
  `Id_Usuario` int(6) NOT NULL,
  PRIMARY KEY (`Id_Usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comentario`
--
ALTER TABLE `comentario`
  ADD CONSTRAINT `comentario_ibfk_1` FOREIGN KEY (`Id_usuario`) REFERENCES `usuarios` (`Id_Usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `fotografia`
--
ALTER TABLE `fotografia`
  ADD CONSTRAINT `fotografia_ibfk_1` FOREIGN KEY (`Id_usuario`) REFERENCES `usuarios` (`Id_Usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `lista_amigos`
--
ALTER TABLE `lista_amigos`
  ADD CONSTRAINT `lista_amigos_ibfk_1` FOREIGN KEY (`Id_Usuarios`) REFERENCES `usuarios` (`Id_Usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
