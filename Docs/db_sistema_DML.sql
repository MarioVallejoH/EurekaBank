-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 21-08-2021 a las 11:53:29
-- Versión del servidor: 10.4.20-MariaDB
-- Versión de PHP: 7.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `dbsistema`
--





INSERT INTO `tipo_moneda` (`id_mon`, `desc_mon`) VALUES
(1, 'USD'),
(2, 'COP');

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id_rol`, `nombre_rol`) VALUES
(1, 'administrador'),
(2, 'empleados'),
(3, 'clientes');


--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre_usu`, `contraseña_usu`, `estado`, `id_rol`) VALUES
(1, '1', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 1, 1),
(2, '2', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 1, 1),
(3, '3', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 1, 1),
(4, '4', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 1, 1),
(5, '5', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 1, 1),
(6, '9999', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 0, 2);

--
-- Volcado de datos para la tabla `sucursales`
--

INSERT INTO `sucursales` (`id_sucursal`, `nombre_sucur`, `ciudad_sucur`, `direccion_sucur`, `num_ctas_sucur`, `id_usuario`) VALUES
(1, 'Sucursal 1', 'Bucaramanga', 'Calle 34 # 21', 0, 1),
(2, 'Succursal 2', 'Bogota', 'Calle 57 # 36 -7', 0, 2),
(3, 'Succursal 3', 'Cali', 'Calle 57 # 36 -7', 0, 3),
(4, 'Succursal 4', 'Barranquilla', 'Calle 57 # 36 -7', 0, 4),
(5, 'Succursal 5', 'Cartagena', 'Calle 57 # 36 -7', 0, 5);






--
-- Volcado de datos para la tabla `persona`
--

INSERT INTO `persona` (`id_persona`, `nombre_per`, `primer_ape_per`, `segundo_ape_per`, `cedula_per`, `ciudad_resid_per`, `dir_resid_per`) VALUES
(1, 'internet', 'internet', 'internet', 'internet', 'internet', 'internet');


--
-- Volcado de datos para la tabla `costos`
--

INSERT INTO `costos` (`id_costo`, `id_mon`, `valor`) VALUES
(1, 2, 2000),
(2, 1, 0.6);

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`id_empleado`, `correo_emp`, `telefono_emp`, `fecha_creacion_emp`, `fecha_baja_emp`, `id_persona`, `id_usuario`, `id_sucursal`) VALUES
(1, 'internet', 'internet', '2021-08-20', NULL, 1, 6, 1);

--
-- Volcado de datos para la tabla `intereses`
--

INSERT INTO `intereses` (`id_interes`, `id_mon`, `valor`) VALUES
(1, 1, '0.60000000'),
(2, 2, '0.70000000');

--
-- Volcado de datos para la tabla `mantenimientos`
--

INSERT INTO `mantenimientos` (`id_mantenimiento`, `id_mon`, `valor`) VALUES
(1, 2, 7000),
(2, 1, 2.5);






--
-- Volcado de datos para la tabla `tipo_moneda`
--


--
-- Volcado de datos para la tabla `tipo_movimiento`
--

INSERT INTO `tipo_movimiento` (`id_tipo_mov`, `estado`, `nombre_mov`, `accion_tipo_mov`) VALUES
(1, 1, 'Apertura de cuenta', 'Ingreso'),
(2, 1, 'Cancelación de la cuenta', 'Salida'),
(3, 1, 'Depósitos', 'Ingreso'),
(4, 1, 'Retiros', 'Salida'),
(5, 1, 'Interés', 'Ingreso'),
(6, 1, 'Transferencias', 'Salida'),
(7, 1, 'Mantenimiento', 'Salida'),
(8, 1, 'ITF', 'Salida');

-- --------------------------------------------------------


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
