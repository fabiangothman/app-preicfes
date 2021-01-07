-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 12-07-2017 a las 17:47:02
-- Versión del servidor: 5.5.52-0ubuntu0.14.04.1
-- Versión de PHP: 7.0.11-1+deb.sury.org~trusty+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `preicfes`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `avatar`
--

CREATE TABLE `avatar` (
  `id_avatar` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `ruta` varchar(100) DEFAULT NULL,
  `id_sexo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `avatar`
--

INSERT INTO `avatar` (`id_avatar`, `nombre`, `ruta`, `id_sexo`) VALUES
(1, '/hombre/avatar2_.png', '/images/modules/perfil/avatars/hombre/avatar2.png', 1),
(2, '/hombre/avatar3_.png', '/images/modules/perfil/avatars/hombre/avatar3.png', 1),
(3, '/hombre/avatar5_.png', '/images/modules/perfil/avatars/hombre/avatar5.png', 1),
(4, '/hombre/avatar7_.png', '/images/modules/perfil/avatars/hombre/avatar7.png', 1),
(5, '/mujer/avata1_.png', '/images/modules/perfil/avatars/mujer/avata1.png', 2),
(6, '/mujer/avatar4_.png', '/images/modules/perfil/avatars/mujer/avatar4.png', 2),
(7, '/mujer/avatar6_.png', '/images/modules/perfil/avatars/mujer/avatar6.png', 2),
(8, '/mujer/avatar8_.png', '/images/modules/perfil/avatars/mujer/avatar8.png', 2),
(9, '/mujer/avatar9_.png', '/images/modules/perfil/avatars/mujer/avatar9.png', 2),
(10, '/hombre/avatar10_.png', '/images/modules/perfil/avatars/hombre/avatar10.png', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiante`
--

CREATE TABLE `estudiante` (
  `id_estudiante` int(11) NOT NULL,
  `identificacion` varchar(45) NOT NULL,
  `contrasena` char(100) DEFAULT NULL,
  `correo` varchar(40) NOT NULL,
  `nombres` varchar(45) DEFAULT NULL,
  `apellidos` varchar(45) DEFAULT NULL,
  `id_sexo` int(11) NOT NULL,
  `id_avatar` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `estudiante`
--

INSERT INTO `estudiante` (`id_estudiante`, `identificacion`, `contrasena`, `correo`, `nombres`, `apellidos`, `id_sexo`, `id_avatar`) VALUES
(1, '1030636016', 'XnCOFXzvzFGHXS/GZ5kVEZ9PAE2N+oCeqydK87yGuwo=', 'fabian_murillo_rock@hotmail.com', 'Edward Fabian', 'Murillo Rodriguez', 1, 2),
(5, 'e.murillo', 'Tk36p1tOVaKwZYRC0JokC3r5NrPDRdSX9zc76vGrOQk=', 'fabianmurillo.01@gmail.com', 'Usuaria Admin', 'Mujer', 2, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sexo`
--

CREATE TABLE `sexo` (
  `id_sexo` int(11) NOT NULL,
  `sexo` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `sexo`
--

INSERT INTO `sexo` (`id_sexo`, `sexo`) VALUES
(1, 'M'),
(2, 'F');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `avatar`
--
ALTER TABLE `avatar`
  ADD PRIMARY KEY (`id_avatar`),
  ADD KEY `fk_avatar_sexo1_idx` (`id_sexo`);

--
-- Indices de la tabla `estudiante`
--
ALTER TABLE `estudiante`
  ADD PRIMARY KEY (`id_estudiante`),
  ADD UNIQUE KEY `identificacion_UNIQUE` (`identificacion`),
  ADD UNIQUE KEY `correo` (`correo`),
  ADD KEY `fk_estudiante_sexo_idx` (`id_sexo`),
  ADD KEY `fk_estudiante_avatar1_idx` (`id_avatar`);

--
-- Indices de la tabla `sexo`
--
ALTER TABLE `sexo`
  ADD PRIMARY KEY (`id_sexo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `avatar`
--
ALTER TABLE `avatar`
  MODIFY `id_avatar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT de la tabla `estudiante`
--
ALTER TABLE `estudiante`
  MODIFY `id_estudiante` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT de la tabla `sexo`
--
ALTER TABLE `sexo`
  MODIFY `id_sexo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `avatar`
--
ALTER TABLE `avatar`
  ADD CONSTRAINT `fk_avatar_sexo1` FOREIGN KEY (`id_sexo`) REFERENCES `sexo` (`id_sexo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `estudiante`
--
ALTER TABLE `estudiante`
  ADD CONSTRAINT `fk_estudiante_avatar1` FOREIGN KEY (`id_avatar`) REFERENCES `avatar` (`id_avatar`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_estudiante_sexo` FOREIGN KEY (`id_sexo`) REFERENCES `sexo` (`id_sexo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
