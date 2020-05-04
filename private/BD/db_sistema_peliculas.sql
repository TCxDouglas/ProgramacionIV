-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-05-2020 a las 04:26:00
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

--
-- Base de datos: `db_sistema_peliculas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alquiler`
--

CREATE TABLE `alquiler` (
  `idAlquiler` int(10) NOT NULL,
  `idCliente` int(10) NOT NULL,
  `idPelicula` int(10) NOT NULL,
  `fechaPrestamo` datetime NOT NULL,
  `fechaDevolucion` date NOT NULL,
  `valor` char(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `alquiler`
--

INSERT INTO `alquiler` (`idAlquiler`, `idCliente`, `idPelicula`, `fechaPrestamo`, `fechaDevolucion`, `valor`) VALUES
(1, 1, 1, '2020-05-03 00:00:00', '2020-02-15', '25'),
(10, 3, 5, '2020-05-03 00:00:00', '2020-05-03', '10.00'),
(11, 2, 3, '2020-05-03 00:00:00', '2020-05-03', '5.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `idCliente` int(10) NOT NULL,
  `nombreC` char(30) COLLATE utf8_spanish2_ci NOT NULL,
  `direccion` char(50) COLLATE utf8_spanish2_ci NOT NULL,
  `telefono` char(9) COLLATE utf8_spanish2_ci NOT NULL,
  `dui` char(9) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`idCliente`, `nombreC`, `direccion`, `telefono`, `dui`) VALUES
(1, 'Douglas', 'Usulutan', '7487-9852', '0245789-9'),
(2, 'Josue', 'Jiquilisco', '7908-4569', '1109789-1'),
(3, 'Carlos', 'Jiquilisco', '8973-0978', '8756542-0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `peliculas`
--

CREATE TABLE `peliculas` (
  `idPelicula` int(10) NOT NULL,
  `nombre` char(50) COLLATE utf8_spanish2_ci NOT NULL,
  `sinopsis` char(75) COLLATE utf8_spanish2_ci NOT NULL,
  `genero` char(50) COLLATE utf8_spanish2_ci NOT NULL,
  `duracion` char(15) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `peliculas`
--

INSERT INTO `peliculas` (`idPelicula`, `nombre`, `sinopsis`, `genero`, `duracion`) VALUES
(1, 'Avengers', 'Un Grupo de Heroes salvan New York', 'Accion, Ciencia Ficcion', '2:05:20'),
(3, 'Fast and Furius', 'Toreto maneja a lo loco GG', 'Accion', '2:05:02'),
(5, 'Avatar', 'Un mundo de fantasia en conflicto con la raza humana', 'Accion, Aventura', '2:30:09');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alquiler`
--
ALTER TABLE `alquiler`
  ADD PRIMARY KEY (`idAlquiler`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`idCliente`);

--
-- Indices de la tabla `peliculas`
--
ALTER TABLE `peliculas`
  ADD PRIMARY KEY (`idPelicula`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alquiler`
--
ALTER TABLE `alquiler`
  MODIFY `idAlquiler` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `idCliente` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `peliculas`
--
ALTER TABLE `peliculas`
  MODIFY `idPelicula` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
