-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-08-2019 a las 23:43:33
-- Versión del servidor: 10.1.39-MariaDB
-- Versión de PHP: 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `base_bd`
--
CREATE DATABASE IF NOT EXISTS `base_bd` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci;
USE `base_bd`;

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_actualizar_usuario` (IN `nombre` VARCHAR(50), IN `segundo_nombre` VARCHAR(50), IN `apellido` VARCHAR(50), IN `segundo_apellido` VARCHAR(50), IN `correo` VARCHAR(100), IN `rol` INT, IN `estado` VARCHAR(20), IN `usuario` INT)  NO SQL
BEGIN 
UPDATE tbl_usuario 
SET tbl_usuario .str_nombre_usuario  = nombre , 
    tbl_usuario .str_segundo_nombre_usuario  = segundo_nombre,
    tbl_usuario .str_apellido_usuario  = apellido ,
    tbl_usuario .str_segundo_apellido_usuario  = segundo_apellido,
    tbl_usuario .str_correo_usuario  =  correo ,
    tbl_usuario .int_id_rol_usuario  = rol ,
    tbl_usuario .str_estado_usuario  = estado 
WHERE 
    tbl_usuario .int_id_usuario = usuario;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_cambiar_estado_usuario` (IN `id` INT, IN `estado` VARCHAR(20))  NO SQL
BEGIN 
UPDATE tbl_usuario 
  SET  tbl_usuario.str_estado_usuario = estado 
 WHERE tbl_usuario.int_id_usuario = id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_consultar_acceso` (IN `_id_usuario` VARCHAR(100))  NO SQL
BEGIN
SELECT str_token_acceso as token,
       int_id_usuario as id_usuario,
       str_contraseña_acceso as contrasena,
       int_id_usuario as id_usuario       
FROM tbl_acceso
WHERE int_id_usuario = _id_usuario;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_consultar_usuario` (IN `email` VARCHAR(100))  NO SQL
BEGIN 
SELECT int_id_usuario as id,
       str_nombre_usuario as nombre,
       str_segundo_nombre_usuario as segundo_nombre,
       str_apellido_usuario as apellido,
       str_segundo_apellido_usuario as segundo_apellido,
       str_correo_usuario as correo,
       int_id_rol_usuario as rol,
       str_estado_usuario as estado
FROM tbl_usuario 
WHERE str_correo_usuario = email;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_consultar_usuarios` (IN `tipo_consulta` INT(11), IN `id_usuario` INT(11))  NO SQL
    DETERMINISTIC
    COMMENT 'consulta datos tabla usuarios Autor: william jose naranjo ardila'
BEGIN 
if ( tipo_consulta = 1) then
  SELECT int_id_usuario as id,
        str_nombre_usuario as nombre,
        str_segundo_nombre_usuario as segundo_nombre,
        str_apellido_usuario as apellido,
        str_segundo_apellido_usuario as segundo_apellido,
        str_correo_usuario as correo,
        int_id_rol_usuario as rol,
        str_estado_usuario as estado
  FROM tbl_usuario;
END IF; 
if ( tipo_consulta = 2) then
  SELECT int_id_usuario as id,
        str_nombre_usuario as nombre,
        str_segundo_nombre_usuario as segundo_nombre,
        str_apellido_usuario as apellido,
        str_segundo_apellido_usuario as segundo_apellido,
        str_correo_usuario as correo,
        int_id_rol_usuario as rol,
        str_estado_usuario as estado
  FROM tbl_usuario
  WHERE int_id_usuario = id_usuario;
END IF; 
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_crear_acceso` (IN `token` VARCHAR(150), IN `usuario` INT, IN `contrasena` VARCHAR(200))  NO SQL
BEGIN
INSERT INTO tbl_acceso (str_token_acceso,int_id_usuario,str_contraseña_acceso) VALUES (token,usuario,contrasena);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_crear_usuario` (IN `nombre` VARCHAR(50), IN `segundo_nombre` VARCHAR(50), IN `apellido` VARCHAR(50), IN `segundo_apellido` VARCHAR(50), IN `correo` VARCHAR(100), IN `rol` INT, IN `estado` VARCHAR(20), IN `nivel` INT(11))  NO SQL
BEGIN
INSERT INTO tbl_usuario 
 (str_nombre_usuario,
  str_segundo_nombre_usuario,
  str_apellido_usuario,
  str_segundo_apellido_usuario,
  str_correo_usuario,
  int_id_rol_usuario,
  str_estado_usuario,
  int_id_nivel_educativo) 
  VALUES 
 (nombre,
  segundo_nombre,
  apellido,
  segundo_apellido,
  correo,
  rol,
  estado,
  nivel);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_crear_usuario_grupo` (IN `grupo` INT, IN `usu` INT, IN `fecha` DATE)  NO SQL
BEGIN
INSERT INTO tbl_detalle_usuario_grupos 
(int_id_grupos,
int_id_usuario,
dtm_fecha_ingreso_detalle_usuario_grupos) 
VALUES (grupo,usu,fecha);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_editar_perfil` (IN `usuario` INT, IN `nombre` VARCHAR(40), IN `segundo_nombre` VARCHAR(40), IN `apellido` VARCHAR(40), IN `segundo_apellido` VARCHAR(40), IN `correo` VARCHAR(100))  NO SQL
BEGIN 
UPDATE tbl_usuario 
SET tbl_usuario.str_nombre_usuario  = nombre,
    tbl_usuario.str_segundo_nombre_usuario  = segundo_nombre,
    tbl_usuario.str_apellido_usuario  = apellido,
    tbl_usuario.str_segundo_apellido_usuario  = segundo_apellido,
    tbl_usuario.str_correo_usuario  = correo
WHERE tbl_usuario.int_id_usuario = usuario;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ingreso_datos` (`nombre` VARCHAR(50), `fecha` DATE, `ficha` INT, `codigo` INT)  BEGIN
INSERT INTO tbl_proyecto(str_nombre_proyecto,dtm_fecha_inicio_proyecto,int_id_tipo_proyecto) VALUES (nombre, fecha, codigo);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_modificar_acceso` (`usuario` INT, `contrasena` VARCHAR(200))  BEGIN
UPDATE tbl_acceso SET str_contraseña_acceso = contrasena WHERE int_id_usuario = usuario;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_usuario_existente_grupo` (`grupo` INT, `usuario` INT)  SELECT COUNT(int_id_grupos) FROM tbl_detalle_usuario_grupos WHERE tbl_detalle_usuario_grupos.int_id_usuario = usuario AND tbl_detalle_usuario_grupos.int_id_grupos=grupo$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_acceso`
--

CREATE TABLE `tbl_acceso` (
  `str_token_acceso` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `int_id_usuario` int(11) NOT NULL,
  `str_contraseña_acceso` varchar(250) COLLATE utf8_spanish_ci NOT NULL,
  `int_id_acceso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tbl_acceso`
--

INSERT INTO `tbl_acceso` (`str_token_acceso`, `int_id_usuario`, `str_contraseña_acceso`, `int_id_acceso`) VALUES
('sfdksaldkjasd', 1, '$2y$10$ngzwURheVoe.9LDXwxOl7Of6ucudqfjApEQiE9K9DWcnClUIdPfl2', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_detalle_usuario_grupos`
--

CREATE TABLE `tbl_detalle_usuario_grupos` (
  `int_id_grupos` int(11) NOT NULL,
  `int_id_usuario` int(11) NOT NULL,
  `dtm_fecha_ingreso_detalle_usuario_grupos` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tbl_detalle_usuario_grupos`
--

INSERT INTO `tbl_detalle_usuario_grupos` (`int_id_grupos`, `int_id_usuario`, `dtm_fecha_ingreso_detalle_usuario_grupos`) VALUES
(1, 1, '2018-06-05');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_grupos`
--

CREATE TABLE `tbl_grupos` (
  `int_id_grupos` int(11) NOT NULL,
  `str_nombre_grupos` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `str_descripcion_grupos` longtext COLLATE utf8_spanish_ci NOT NULL,
  `dtm_fecha_resgistro_grupos` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tbl_grupos`
--

INSERT INTO `tbl_grupos` (`int_id_grupos`, `str_nombre_grupos`, `str_descripcion_grupos`, `dtm_fecha_resgistro_grupos`) VALUES
(1, 'Biomatic', 'grupo de investigación centro de diseño y manufactura de el cuero', '2018-06-06'),
(3, 'Innova', 'grupo de investigación e innovación centro de confección', '2019-07-29');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_usuario`
--

CREATE TABLE `tbl_usuario` (
  `int_id_usuario` int(11) NOT NULL,
  `str_nombre_usuario` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `str_segundo_nombre_usuario` varchar(40) COLLATE utf8_spanish_ci DEFAULT NULL,
  `str_apellido_usuario` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `str_segundo_apellido_usuario` varchar(40) COLLATE utf8_spanish_ci DEFAULT NULL,
  `str_correo_usuario` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `int_id_rol_usuario` int(11) NOT NULL,
  `str_estado_usuario` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `int_id_nivel_educativo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tbl_usuario`
--

INSERT INTO `tbl_usuario` (`int_id_usuario`, `str_nombre_usuario`, `str_segundo_nombre_usuario`, `str_apellido_usuario`, `str_segundo_apellido_usuario`, `str_correo_usuario`, `int_id_rol_usuario`, `str_estado_usuario`, `int_id_nivel_educativo`) VALUES
(1, 'WILLY', 's', 'NARANJO', 'nuevo', 'eve@gmail.com', 1, 'Activo', 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tbl_acceso`
--
ALTER TABLE `tbl_acceso`
  ADD PRIMARY KEY (`str_token_acceso`),
  ADD KEY `int_id_usuario` (`int_id_usuario`);

--
-- Indices de la tabla `tbl_detalle_usuario_grupos`
--
ALTER TABLE `tbl_detalle_usuario_grupos`
  ADD KEY `usuarioxgrupo_ibfk_1` (`int_id_usuario`),
  ADD KEY `usuarioxgrupo_ibfk_2` (`int_id_grupos`);

--
-- Indices de la tabla `tbl_grupos`
--
ALTER TABLE `tbl_grupos`
  ADD PRIMARY KEY (`int_id_grupos`);

--
-- Indices de la tabla `tbl_usuario`
--
ALTER TABLE `tbl_usuario`
  ADD PRIMARY KEY (`int_id_usuario`),
  ADD UNIQUE KEY `str_correo_usuario` (`str_correo_usuario`),
  ADD KEY `int_id_rol_usuario` (`int_id_rol_usuario`),
  ADD KEY `int_id_nivel_educativo` (`int_id_nivel_educativo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tbl_usuario`
--
ALTER TABLE `tbl_usuario`
  MODIFY `int_id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tbl_acceso`
--
ALTER TABLE `tbl_acceso`
  ADD CONSTRAINT `tbl_acceso_ibfk_1` FOREIGN KEY (`int_id_usuario`) REFERENCES `tbl_usuario` (`int_id_usuario`);

--
-- Filtros para la tabla `tbl_detalle_usuario_grupos`
--
ALTER TABLE `tbl_detalle_usuario_grupos`
  ADD CONSTRAINT `usuarioxgrupo_ibfk_1` FOREIGN KEY (`int_id_usuario`) REFERENCES `tbl_usuario` (`int_id_usuario`) ON UPDATE CASCADE,
  ADD CONSTRAINT `usuarioxgrupo_ibfk_2` FOREIGN KEY (`int_id_grupos`) REFERENCES `tbl_grupos` (`int_id_grupos`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
