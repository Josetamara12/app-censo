-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-08-2024 a las 04:41:21
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `censo_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_personas`
--

CREATE TABLE `tbl_personas` (
  `DNI` varchar(10) NOT NULL,
  `NOMBRE` varchar(100) DEFAULT NULL,
  `FECNAC` date DEFAULT NULL,
  `DIR` varchar(255) DEFAULT NULL,
  `TFNO` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_personas`
--

INSERT INTO `tbl_personas` (`DNI`, `NOMBRE`, `FECNAC`, `DIR`, `TFNO`) VALUES
('1040', 'David Pardo', '1997-07-07', 'Calle 765, Ciudad N', '2147483647'),
('1041', 'Luciana Arias', '1982-11-11', 'Carrera 543, Ciudad O', '2147483647'),
('1042', 'Tomas Reyes', '1985-03-29', 'Avenida 876, Ciudad P', '2147483647'),
('1043', 'Catalina Ramirez', '1992-02-13', 'Calle 654, Ciudad Q', '2147483647'),
('1044', 'Esteban Ortiz', '1990-06-01', 'Carrera 432, Ciudad R', '2147483647'),
('1045', 'Angela Soto', '1981-09-10', 'Avenida 765, Ciudad S', '2147483647'),
('1046', 'Javier Diaz', '1983-04-14', 'Calle 987, Ciudad T', '2147483647'),
('1049', 'Gustavo Sanchez Perez', '1989-12-30', 'Calle 654, Ciudad W - b', '2147483647');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
