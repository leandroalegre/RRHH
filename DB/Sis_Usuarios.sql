-- phpMyAdmin SQL Dump
-- version 4.0.10.14
-- http://www.phpmyadmin.net
--
-- Servidor: localhost:3306
-- Tiempo de generación: 24-06-2016 a las 12:46:22
-- Versión del servidor: 5.6.30
-- Versión de PHP: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `villacar_salud`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Sis_Usuarios`
--

CREATE TABLE IF NOT EXISTS `Sis_Usuarios` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Usuario` text CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `Password` text CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `Mail` text CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `Tipo` int(11) NOT NULL,
  `Id_Usu` int(11) NOT NULL,
  `Id_Persona` int(11) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=28 ;

--
-- Volcado de datos para la tabla `Sis_Usuarios`
--

INSERT INTO `Sis_Usuarios` (`Id`, `Usuario`, `Password`, `Mail`, `Tipo`, `Id_Usu`, `Id_Persona`) VALUES
(20, 'SCARDENAS', '$2y$10$VaVP/PlPqD2.N39nMEKxveg30fk3AxnRrqCrE57oR7nlitmWR5/TS', 'changocardenas31@hotmail.com', 1, 3, 2184),
(3, 'UsercxAdm', '$2y$10$WSbcnxCoEkFYis8tF5L2HuiAwJsP6t9pc.H0zG5nWcdOAh.9ZWjhu', 'vacuinacion@villacarlospaz.gov.ar', 1, 1, 1),
(19, 'OperITalla', '$2y$10$v0LKFCz5OxoBff2fTxap0OSRXhkniUGkk/8wZYj50.pu/XCKcxTpW', 'federicovongromann@gmail.com', 2, 3, 3465),
(21, 'BARRIONUEVO', '$2y$10$bQpUBNs/Z68u9wz3uo7wBe4qjQWBDCOPJ3W/9YypLLVLu6oU1c9M2', 'CAPSCOLINAS@VILLACARLOSPAZ.GOV.AR', 2, 3, 3469),
(22, 'olga', '$2y$10$64BsCyFg6/D9IOYBcePIN.A06bDbZopp504ux7/AFfH2H9O/i5fjK', 'olgatbarrionuevo@hotmail.com', 1, 3, 3467),
(23, 'VIVI', '$2y$10$r/GjUBF41u1gkzv5MhQJkuXnOJz8vWUqdFmW8qZOAO4x92hVDbyKq', 'colinas@villacarlospaz.gov.ar', 2, 22, 3471),
(24, 'GISELITA', '$2y$10$HJZNDYi3J/.mLdgD9nsTb.9dHP.3Okhrt3iDq70nTfgsBRo7ci2sC', 'srecibo@villacarlospaz.gov.ar', 2, 22, 3474),
(25, 'TEST', '$2y$10$FGG09DF4ZR6FnsXkS3ZW1uXvg6vPFj8zBvcbbTgChjROJppFK8RnS', 'RECIBOS@VILLACARLOSPAZ.GOV.AR', 2, 3, 3475),
(26, 'FROMERO', '$2y$10$Qq.70iIJ3txVGhhh7RSez.t.AmL8qflTd16rlzXI5lLCEM0xCPF5q', 'recibo@villacarlospaz.gov.ar', 2, 3, 3477),
(27, 'LALLENDE', '$2y$10$cSky5HXpGiexiFBkY2Xm9.kuKZ85wqzBNWv7AznmAAjL0Ckg8hJDS', 'LAIALLENDE77@GMAIL.COM', 2, 20, 3734);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
