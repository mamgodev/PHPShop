-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 09, 2019 at 12:18 AM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tiendadb`
--
CREATE DATABASE IF NOT EXISTS `tiendadb` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `tiendadb`;

-- --------------------------------------------------------

--
-- Table structure for table `categoriaproductos`
--

CREATE TABLE `categoriaproductos` (
  `id` int(11) NOT NULL,
  `categoria` varchar(20) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categoriaproductos`
--

INSERT INTO `categoriaproductos` (`id`, `categoria`) VALUES
(8, 'CPU'),
(6, 'Memoria RAM'),
(9, 'Tarjeta Grafica'),
(5, 'Torre');

-- --------------------------------------------------------

--
-- Table structure for table `cestacompra`
--

CREATE TABLE `cestacompra` (
  `idUsuario` int(11) NOT NULL,
  `usernameUsuario` varchar(50) NOT NULL,
  `cestaCompra` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `comprasfinalizadas`
--

CREATE TABLE `comprasfinalizadas` (
  `nombreUsuario` varchar(100) NOT NULL,
  `numeroPedido` int(11) NOT NULL,
  `fechaPedido` datetime NOT NULL,
  `cestaPedido` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comprasfinalizadas`
--

INSERT INTO `comprasfinalizadas` (`nombreUsuario`, `numeroPedido`, `fechaPedido`, `cestaPedido`) VALUES
('shinix', 1, '2019-12-07 11:38:20', 'a:0:{}'),
('shinix', 2, '2019-12-07 11:38:42', 'a:0:{}'),
('shinix', 3, '2019-12-07 17:07:04', 'a:1:{i:1;a:2:{i:0;s:1:\"4\";i:1;s:1:\"1\";}}'),
('shinix', 4, '2019-12-08 13:59:32', 'a:1:{i:0;a:2:{i:0;s:2:\"14\";i:1;s:1:\"1\";}}'),
('juan', 5, '2019-12-08 16:55:45', 'a:3:{i:0;a:2:{i:0;s:2:\"14\";i:1;s:1:\"1\";}i:1;a:2:{i:0;s:2:\"13\";i:1;s:1:\"1\";}i:2;a:2:{i:0;s:2:\"12\";i:1;s:1:\"1\";}}'),
('shinix', 6, '2019-12-08 20:53:45', 'a:1:{i:0;a:2:{i:0;s:2:\"14\";i:1;s:1:\"2\";}}'),
('shinix', 7, '2019-12-08 23:59:59', 'a:4:{i:0;a:2:{i:0;s:2:\"18\";i:1;s:1:\"1\";}i:1;a:2:{i:0;s:2:\"19\";i:1;s:1:\"1\";}i:2;a:2:{i:0;s:2:\"12\";i:1;s:1:\"1\";}i:3;a:2:{i:0;s:2:\"13\";i:1;i:4;}}');

-- --------------------------------------------------------

--
-- Table structure for table `productos`
--

CREATE TABLE `productos` (
  `idProducto` int(11) NOT NULL,
  `nombreProducto` varchar(25) NOT NULL,
  `descripcionProducto` varchar(50) DEFAULT NULL,
  `precioProducto` decimal(10,0) NOT NULL,
  `stockProducto` int(10) NOT NULL,
  `categoriaProducto` varchar(20) NOT NULL,
  `imgDirProducto` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `productos`
--

INSERT INTO `productos` (`idProducto`, `nombreProducto`, `descripcionProducto`, `precioProducto`, `stockProducto`, `categoriaProducto`, `imgDirProducto`) VALUES
(12, 'Nfortec Draco V2 Cristal ', 'Torre con cristal templado y rgb', '70', 120, 'Torre', 'torreNfortecDracoV2.PNG'),
(13, 'Memoria RAM', '', '12', 1, 'Memoria RAM', 'ram.jpg'),
(14, 'Memoria RAM sin imagen', 'prueba sin imagen', '3', 20, 'Memoria RAM', ''),
(18, 'Procesador AMD Ryzen 5 26', 'Te presentamos el AMD Ryzen 5 2600, un procesador ', '125', 57, 'CPU', 'ryzen.PNG'),
(19, 'XFX AMD Radeon RX 580 GTS', '', '170', 100, 'Tarjeta Grafica', '');

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `username` varchar(50) NOT NULL,
  `password` text NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `email` varchar(20) NOT NULL,
  `nacimiento` date NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `rol` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`username`, `password`, `nombre`, `email`, `nacimiento`, `idUsuario`, `rol`) VALUES
('fernandez', '$2y$10$WDXXjsPYCtcVSYgaLjKchuuzGgL1HYf61UWr2TgvHvxML4gZkzLYW', 'Alvaro', 'asdasd@gmail.com', '2012-10-15', 3, 'usuario'),
('Ivan', '$2y$10$Uz1VppffL3obGN/73HPqMeoS.9.U1FDoP0XlvY.mdeRsY.lCG4BQW', 'Ivan', 'ivan@correo.es', '2019-08-25', 4, 'usuario'),
('juan', '$2y$10$1AmoJI6L3S7FU71JtoEp6ePwrgnprLxOZs10NMCftWMCbFxLGnsle', 'juan', 'juan@correo.es', '2015-10-04', 5, 'usuario'),
('shinix', '$2y$10$Fx8huxu7Rw94/dlV8aC1se39UnVKnCR4hVGfhygK3HhWAeYTrS4LO', 'M.Angel', 'prueba@gmail.com', '2019-01-14', 2, 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categoriaproductos`
--
ALTER TABLE `categoriaproductos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categoria` (`categoria`),
  ADD KEY `categoria_2` (`categoria`);

--
-- Indexes for table `comprasfinalizadas`
--
ALTER TABLE `comprasfinalizadas`
  ADD PRIMARY KEY (`numeroPedido`);

--
-- Indexes for table `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`idProducto`),
  ADD KEY `categoriaProducto` (`categoriaProducto`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`username`),
  ADD UNIQUE KEY `idUsuario` (`idUsuario`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categoriaproductos`
--
ALTER TABLE `categoriaproductos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `comprasfinalizadas`
--
ALTER TABLE `comprasfinalizadas`
  MODIFY `numeroPedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `productos`
--
ALTER TABLE `productos`
  MODIFY `idProducto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`categoriaProducto`) REFERENCES `categoriaproductos` (`categoria`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
