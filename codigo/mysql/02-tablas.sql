-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-04-2018 a las 18:38:26
-- Versión del servidor: 10.1.30-MariaDB
-- Versión de PHP: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tablonucm`
--
CREATE DATABASE IF NOT EXISTS `tablonucm` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `tablonucm`;

-- --------------------------------------------------------

CREATE TABLE `usuarios` (
  `nombreUsuario` varchar(15) NOT NULL,
  `email` varchar(40) NOT NULL,
  `password` varchar(80) NOT NULL,
  `rol` varchar(10) NOT NULL,
  `extensionImagen` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `reportesusuarios` (
  `id` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `asunto` varchar(30) NOT NULL,
  `texto` varchar(280) NOT NULL,
  `usuarioEmisor` varchar(15) NOT NULL,
  `usuarioReceptor` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `eventos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `categoria` varchar(20) NOT NULL,
  `lugar` varchar(30) NOT NULL,
  `fecha` datetime NOT NULL,
  `creador` varchar(15) NOT NULL,
  `descripcion` varchar(140) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `reporteseventos` (
  `id` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `asunto` varchar(30) NOT NULL,
  `texto` varchar(280) NOT NULL,
  `usuarioEmisor` varchar(15) NOT NULL,
  `evento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `asistentes` (
  `idEvento` int(11) NOT NULL,
  `idUsuario` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `asignaturas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(80) NOT NULL,
  `idCurso` int(11) NOT NULL,
  `zip` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `cursos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(80) NOT NULL,
  `idGrado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `grados` (
  `id` int(11) NOT NULL,
  `nombre` varchar(80) NOT NULL,
  `idFacultad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `facultades` (
  `id` int(11) NOT NULL,
  `nombre` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `archivos` (
  `id` int(11) NOT NULL,
  `nombreArchivo` varchar(30) NOT NULL,
  `categoria` varchar(80) NOT NULL,
  `asignatura` int(11) NOT NULL,
  `autor` varchar(15) NOT NULL,
  `observaciones` varchar(140) NOT NULL,
  `tamano` int(15) NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `reportesarchivos` (
  `id` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `asunto` varchar(30) NOT NULL,
  `texto` varchar(280) NOT NULL,
  `usuarioEmisor` varchar(15) NOT NULL,
  `archivo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `valoracionesarchivos` (
  `idArchivo` int(11) NOT NULL,
  `usuarioEmisor` varchar(15) NOT NULL,
  `puntuacion` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `valoracionesusuarios` (
  `usuarioReceptor` varchar(15) NOT NULL,
  `usuarioEmisor` varchar(15) NOT NULL,
  `puntuacion` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `asignaturasmarcadas` (
  `idAsignatura` int(11) NOT NULL,
  `idUsuario` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `novedadeseventos` (
  `fecha` datetime NOT NULL,
  `usuarioEmisor` varchar(15) NOT NULL,
  `idEvento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `novedadesarchivos` (
  `fecha` datetime NOT NULL,
  `usuarioEmisor` varchar(15) NOT NULL,
  `idArchivo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `novedadesvaloracionesusuarios` (
  `fecha` datetime NOT NULL,
  `usuarioEmisor` varchar(15) NOT NULL,
  `usuarioReceptor` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `novedadesvaloracionesarchivos` (
  `fecha` datetime NOT NULL,
  `usuarioEmisor` varchar(15) NOT NULL,
  `idArchivo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`nombreUsuario`);

--
-- Indices de la tabla `eventos`
--
ALTER TABLE `eventos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `asignaturas`
--
ALTER TABLE `asignaturas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cursos`
--
ALTER TABLE `cursos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `grados`
--
ALTER TABLE `grados`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `facultades`
--
ALTER TABLE `facultades`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `archivos`
--
ALTER TABLE `archivos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `reportesusuarios`
--
ALTER TABLE `reportesusuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `reportesarchivos`
--
ALTER TABLE `reportesarchivos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `reporteseventos`
--
ALTER TABLE `reporteseventos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `valoracionesarchivos`
--
ALTER TABLE `valoracionesarchivos`
  ADD PRIMARY KEY (`idArchivo`, `usuarioEmisor`);

--
-- Indices de la tabla `asistentes`
--
ALTER TABLE `asistentes`
  ADD PRIMARY KEY (`idEvento`, `idUsuario`);

--
-- Indices de la tabla `valoracionesusuarios`
--
ALTER TABLE `valoracionesusuarios`
  ADD PRIMARY KEY (`usuarioReceptor`, `usuarioEmisor`);

--
-- Indices de la tabla `asignaturasmarcadas`
--
ALTER TABLE `asignaturasmarcadas`
  ADD PRIMARY KEY (`idAsignatura`, `idUsuario`);

--
-- Indices de la tabla `novedadeseventos`
--
ALTER TABLE `novedadeseventos`
  ADD PRIMARY KEY (`usuarioEmisor`, `idEvento`);

--
-- Indices de la tabla `novedadesarchivos`
--
ALTER TABLE `novedadesarchivos`
  ADD PRIMARY KEY (`usuarioEmisor`, `idArchivo`);

--
-- Indices de la tabla `novedadesvaloracionesusuarios`
--
ALTER TABLE `novedadesvaloracionesusuarios`
  ADD PRIMARY KEY (`usuarioEmisor`, `usuarioReceptor`);

--
-- Indices de la tabla `novedadesvaloracionesarchivos`
--
ALTER TABLE `novedadesvaloracionesarchivos`
  ADD PRIMARY KEY (`usuarioEmisor`, `idArchivo`);
  
--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `eventos`
--
ALTER TABLE `eventos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

--
-- AUTO_INCREMENT de la tabla `reportesusuarios`
--
ALTER TABLE `reportesusuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

--
-- AUTO_INCREMENT de la tabla `reportesarchivos`
--
ALTER TABLE `reportesarchivos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

--
-- AUTO_INCREMENT de la tabla `reporteseventos`
--
ALTER TABLE `reporteseventos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

--
-- AUTO_INCREMENT de la tabla `asignaturas`
--
ALTER TABLE `asignaturas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

--
-- AUTO_INCREMENT de la tabla `cursos`
--
ALTER TABLE `cursos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

--
-- AUTO_INCREMENT de la tabla `grados`
--
ALTER TABLE `grados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

--
-- AUTO_INCREMENT de la tabla `facultades`
--
ALTER TABLE `facultades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

--
-- AUTO_INCREMENT de la tabla `archivos`
--
ALTER TABLE `archivos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

--
-- Claves foráneas de la tabla `archivos`
--
ALTER TABLE `eventos` 
  ADD FOREIGN KEY (`creador`) 
  REFERENCES `usuarios`(`nombreUsuario`)
  ON UPDATE CASCADE
  ON DELETE CASCADE;

--
-- Claves foráneas de la tabla `archivos`
--
ALTER TABLE `archivos` 
  ADD FOREIGN KEY (`autor`) 
  REFERENCES `usuarios`(`nombreUsuario`)
  ON UPDATE CASCADE
  ON DELETE CASCADE,
  ADD FOREIGN KEY (`asignatura`) 
  REFERENCES `asignaturas`(`id`)
  ON UPDATE CASCADE
  ON DELETE CASCADE;

--
-- Claves foráneas de la tabla `valoracionesarchivos`
--
ALTER TABLE `valoracionesarchivos` 
  ADD FOREIGN KEY (`usuarioEmisor`) 
  REFERENCES `usuarios`(`nombreUsuario`)
  ON UPDATE CASCADE
  ON DELETE CASCADE,
  ADD FOREIGN KEY (`idArchivo`) 
  REFERENCES `archivos`(`id`)
  ON UPDATE CASCADE
  ON DELETE CASCADE;

--
-- Claves foráneas de la tabla `asistentes`
--
ALTER TABLE `asistentes` 
  ADD FOREIGN KEY (`idEvento`) 
  REFERENCES `eventos`(`id`)
  ON UPDATE CASCADE
  ON DELETE CASCADE,
  ADD FOREIGN KEY (`idUsuario`) 
  REFERENCES `usuarios`(`nombreUsuario`)
  ON UPDATE CASCADE
  ON DELETE CASCADE;

--
-- Claves foráneas de la tabla `reportesusuarios`
--
ALTER TABLE `reportesusuarios` 
  ADD FOREIGN KEY (`usuarioEmisor`) 
  REFERENCES `usuarios`(`nombreUsuario`)
  ON UPDATE CASCADE
  ON DELETE CASCADE,
  ADD FOREIGN KEY (`usuarioReceptor`) 
  REFERENCES `usuarios`(`nombreUsuario`)
  ON UPDATE CASCADE
  ON DELETE CASCADE;

--
-- Claves foráneas de la tabla `reportesarchivos`
--
ALTER TABLE `reportesarchivos` 
  ADD FOREIGN KEY (`usuarioEmisor`) 
  REFERENCES `usuarios`(`nombreUsuario`)
  ON UPDATE CASCADE
  ON DELETE CASCADE,
  ADD FOREIGN KEY (`archivo`) 
  REFERENCES `archivos`(`id`)
  ON UPDATE CASCADE
  ON DELETE CASCADE;

--
-- Claves foráneas de la tabla `reporteseventos`
--
ALTER TABLE `reporteseventos` 
  ADD FOREIGN KEY (`usuarioEmisor`) 
  REFERENCES `usuarios`(`nombreUsuario`)
  ON UPDATE CASCADE
  ON DELETE CASCADE,
  ADD FOREIGN KEY (`evento`) 
  REFERENCES `eventos`(`id`)
  ON UPDATE CASCADE
  ON DELETE CASCADE;

--
-- Claves foráneas de la tabla `asignaturasmarcadas`
--
ALTER TABLE `asignaturasmarcadas` 
  ADD FOREIGN KEY (`idUsuario`) 
  REFERENCES `usuarios`(`nombreUsuario`)
  ON UPDATE CASCADE
  ON DELETE CASCADE,
  ADD FOREIGN KEY (`idAsignatura`) 
  REFERENCES `asignaturas`(`id`)
  ON UPDATE CASCADE
  ON DELETE CASCADE;

--
-- Claves foráneas de la tabla `asignaturas`
--
ALTER TABLE `asignaturas` 
  ADD FOREIGN KEY (`idCurso`) 
  REFERENCES `cursos`(`id`)
  ON UPDATE CASCADE
  ON DELETE CASCADE;

--
-- Claves foráneas de la tabla `cursos`
--
ALTER TABLE `cursos` 
  ADD FOREIGN KEY (`idGrado`) 
  REFERENCES `grados`(`id`)
  ON UPDATE CASCADE
  ON DELETE CASCADE;

  --
-- Claves foráneas de la tabla `grados`
--
ALTER TABLE `grados` 
  ADD FOREIGN KEY (`idFacultad`) 
  REFERENCES `facultades`(`id`)
  ON UPDATE CASCADE
  ON DELETE CASCADE;

--
-- Claves foráneas de la tabla `novedadeseventos`
--
ALTER TABLE `novedadeseventos` 
  ADD FOREIGN KEY (`usuarioEmisor`) 
  REFERENCES `usuarios`(`nombreUsuario`)
  ON UPDATE CASCADE
  ON DELETE CASCADE,
  ADD FOREIGN KEY (`idEvento`) 
  REFERENCES `eventos`(`id`)
  ON UPDATE CASCADE
  ON DELETE CASCADE;

--
-- Claves foráneas de la tabla `novedadesarchivos`
--
ALTER TABLE `novedadesarchivos` 
  ADD FOREIGN KEY (`usuarioEmisor`) 
  REFERENCES `usuarios`(`nombreUsuario`)
  ON UPDATE CASCADE
  ON DELETE CASCADE,
  ADD FOREIGN KEY (`idArchivo`) 
  REFERENCES `archivos`(`id`)
  ON UPDATE CASCADE
  ON DELETE CASCADE;

--
-- Claves foráneas de la tabla `valoracionesusuarios`
--
ALTER TABLE `valoracionesusuarios` 
  ADD FOREIGN KEY (`usuarioEmisor`) 
  REFERENCES `usuarios`(`nombreUsuario`)
  ON UPDATE CASCADE
  ON DELETE CASCADE,
  ADD FOREIGN KEY (`usuarioReceptor`) 
  REFERENCES `usuarios`(`nombreUsuario`)
  ON UPDATE CASCADE
  ON DELETE CASCADE;

--
-- Claves foráneas de la tabla `novedadesvaloracionesusuarios`
--
ALTER TABLE `novedadesvaloracionesusuarios` 
  ADD FOREIGN KEY (`usuarioEmisor`) 
  REFERENCES `valoracionesusuarios`(`usuarioEmisor`)
  ON UPDATE CASCADE
  ON DELETE CASCADE,
  ADD FOREIGN KEY (`usuarioReceptor`) 
  REFERENCES `valoracionesusuarios`(`usuarioReceptor`)
  ON UPDATE CASCADE
  ON DELETE CASCADE;

--
-- Claves foráneas de la tabla `novedadesvaloracionesarchivos`
--
ALTER TABLE `novedadesvaloracionesarchivos` 
  ADD FOREIGN KEY (`usuarioEmisor`) 
  REFERENCES `valoracionesarchivos`(`usuarioEmisor`)
  ON UPDATE CASCADE
  ON DELETE CASCADE,
  ADD FOREIGN KEY (`idArchivo`) 
  REFERENCES `valoracionesarchivos`(`idArchivo`)
  ON UPDATE CASCADE
  ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;