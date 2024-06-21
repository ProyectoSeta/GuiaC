-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-06-2024 a las 21:29:07
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `guia_mnm`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bitacoras`
--

CREATE TABLE `bitacoras` (
  `correlativo` int(10) UNSIGNED NOT NULL,
  `id_user` int(10) UNSIGNED NOT NULL,
  `modulo` int(10) UNSIGNED NOT NULL,
  `fecha` date NOT NULL DEFAULT current_timestamp(),
  `accion` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `bitacoras`
--

INSERT INTO `bitacoras` (`correlativo`, `id_user`, `modulo`, `fecha`, `accion`, `created_at`, `updated_at`) VALUES
(1, 1, 15, '2024-06-19', 'DATOS DEL USUARIO: Aramica, S.A. ACTUALIZADOS.', NULL, NULL),
(2, 1, 9, '2024-06-19', 'VERIFICACIÓN DE USUARIO APROBADA, Contribuyente: TECNOCOMODITY, C.A..', NULL, NULL),
(3, 1, 9, '2024-06-19', 'VERIFICACIÓN DE USUARIO APROBADA, Contribuyente: UNIDAD PRODUCTIVA FAMILIAR PIEDRA AZUL.', NULL, NULL),
(4, 1, 9, '2024-06-19', 'VERIFICACIÓN DE USUARIO APROBADA, Contribuyente: UNIDAD PRODUCTIVA FAMILIAR MINEROS DEL SUR.', NULL, NULL),
(5, 1, 9, '2024-06-19', 'VERIFICACIÓN DE USUARIO APROBADA, Contribuyente: ARAGUA MINAS Y CANTERAS, S.A..', NULL, NULL),
(6, 1, 10, '2024-06-19', 'VERIFICACIÓN APROBADA, Cantera: UNIDAD TÉCNICA DE PRODUCCIÓN EL BANCO, Contribuyente: ARAGUA MINAS Y CANTERAS, S.A..', NULL, NULL),
(7, 1, 10, '2024-06-19', 'VERIFICACIÓN APROBADA, Cantera: UNIDAD TÉCNICA DE PRODUCCIÓN APAMATE, Contribuyente: ARAGUA MINAS Y CANTERAS, S.A..', NULL, NULL),
(8, 1, 10, '2024-06-19', 'VERIFICACIÓN APROBADA, Cantera: UNIDAD TÉCNICA DE PRODUCCIÓN EL SAMAN, Contribuyente: ARAGUA MINAS Y CANTERAS, S.A..', NULL, NULL),
(9, 1, 10, '2024-06-19', 'VERIFICACIÓN APROBADA, Cantera: UNIDAD TÉCNICA DE PRODUCCIÓN EL CARMEN, Contribuyente: ARAGUA MINAS Y CANTERAS, S.A..', NULL, NULL),
(10, 1, 10, '2024-06-19', 'VERIFICACIÓN APROBADA, Cantera: UNIDAD TÉCNICA DE PRODUCCIÓN AGUA VIVA II, Contribuyente: ARAGUA MINAS Y CANTERAS, S.A..', NULL, NULL),
(11, 1, 10, '2024-06-19', 'VERIFICACIÓN APROBADA, Cantera: UNIDAD TÉCNICA DE PRODUCCIÓN EL PAITO, Contribuyente: ARAGUA MINAS Y CANTERAS, S.A..', NULL, NULL),
(12, 1, 10, '2024-06-19', 'VERIFICACIÓN APROBADA, Cantera: UNIDAD TÉCNICA DE PRODUCCIÓN CHUPADERO, Contribuyente: ARAGUA MINAS Y CANTERAS, S.A..', NULL, NULL),
(13, 1, 10, '2024-06-19', 'VERIFICACIÓN APROBADA, Cantera: UNIDAD TÉCNICA DE PRODUCCIÓN PARDILLAL, Contribuyente: ARAGUA MINAS Y CANTERAS, S.A..', NULL, NULL),
(14, 1, 10, '2024-06-19', 'VERIFICACIÓN APROBADA, Cantera: RÍO LIMÓN, Contribuyente: TECNOCOMODITY, C.A..', NULL, NULL),
(15, 1, 10, '2024-06-19', 'VERIFICACIÓN APROBADA, Cantera: MINEROS DEL SUR, Contribuyente: UNIDAD PRODUCTIVA FAMILIAR MINEROS DEL SUR.', NULL, NULL),
(16, 1, 10, '2024-06-19', 'VERIFICACIÓN APROBADA, Cantera: PIEDRA AZUL, Contribuyente: UNIDAD PRODUCTIVA FAMILIAR PIEDRA AZUL.', NULL, NULL),
(17, 1, 7, '2024-06-20', 'SOLICITUD NRO.1 APROBADA, Talonarios: 10, Contribuyente: ARAGUA MINAS Y CANTERAS, S.A.', NULL, NULL),
(18, 1, 7, '2024-06-21', 'SOLICITUD NRO.2 APROBADA, Talonarios: 10, Contribuyente: ARAGUA MINAS Y CANTERAS, S.A.', NULL, NULL),
(19, 1, 7, '2024-06-21', 'SOLICITUD NRO.3 APROBADA, Talonarios: 10, Contribuyente: ARAGUA MINAS Y CANTERAS, S.A.', NULL, NULL),
(20, 1, 7, '2024-06-21', 'SOLICITUD NRO.4 APROBADA, Talonarios: 10, Contribuyente: ARAGUA MINAS Y CANTERAS, S.A.', NULL, NULL),
(21, 1, 7, '2024-06-21', 'SOLICITUD NRO.5 APROBADA, Talonarios: 10, Contribuyente: ARAGUA MINAS Y CANTERAS, S.A.', NULL, NULL),
(22, 1, 7, '2024-06-21', 'SOLICITUD NRO.6 APROBADA, Talonarios: 10, Contribuyente: ARAGUA MINAS Y CANTERAS, S.A.', NULL, NULL),
(23, 1, 7, '2024-06-21', 'SOLICITUD NRO.7 APROBADA, Talonarios: 10, Contribuyente: ARAGUA MINAS Y CANTERAS, S.A.', NULL, NULL),
(24, 1, 7, '2024-06-21', 'SOLICITUD NRO.8 APROBADA, Talonarios: 10, Contribuyente: ARAGUA MINAS Y CANTERAS, S.A.', NULL, NULL),
(25, 1, 7, '2024-06-21', 'SOLICITUD NRO.9 APROBADA, Talonarios: 10, Contribuyente: TECNOCOMODITY, C.A.', NULL, NULL),
(26, 1, 7, '2024-06-21', 'SOLICITUD NRO.10 APROBADA, Talonarios: 10, Contribuyente: UNIDAD PRODUCTIVA FAMILIAR MINEROS DEL SUR', NULL, NULL),
(27, 1, 7, '2024-06-21', 'SOLICITUD NRO.11 APROBADA, Talonarios: 10, Contribuyente: UNIDAD PRODUCTIVA FAMILIAR PIEDRA AZUL', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `canteras`
--

CREATE TABLE `canteras` (
  `id_cantera` int(10) UNSIGNED NOT NULL,
  `id_sujeto` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `municipio_cantera` varchar(255) NOT NULL,
  `parroquia_cantera` varchar(255) NOT NULL,
  `lugar_aprovechamiento` varchar(255) NOT NULL,
  `status` enum('Verificando','Verificada','Denegada') NOT NULL,
  `observaciones` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `canteras`
--

INSERT INTO `canteras` (`id_cantera`, `id_sujeto`, `nombre`, `municipio_cantera`, `parroquia_cantera`, `lugar_aprovechamiento`, `status`, `observaciones`, `created_at`, `updated_at`) VALUES
(1, 4, 'UNIDAD TÉCNICA DE PRODUCCIÓN EL BANCO', 'Zamora', 'Zamora', 'CARRETERA NACIONAL CAGUA - VILLA DE CURA, TRONCAL 2. HACIENDITA EL BANCO', 'Verificada', NULL, NULL, NULL),
(2, 4, 'UNIDAD TÉCNICA DE PRODUCCIÓN APAMATE', 'San Sebastián', 'San Sebastián', 'AL MARGEN NORTE DE LA CARRETERA NACIONAL TRONCAL 11, TRAMO SAN JUAN DE LOS MORROS', 'Verificada', NULL, NULL, NULL),
(3, 4, 'UNIDAD TÉCNICA DE PRODUCCIÓN EL SAMAN', 'San Sebastián', 'San Sebastián', 'AL MARGEN NORTE DE LA CARRETERA NACIONAL TRONCAL 11, TRAMO SAN JUAN DE LOS MORROS', 'Verificada', NULL, NULL, NULL),
(4, 4, 'UNIDAD TÉCNICA DE PRODUCCIÓN EL CARMEN', 'San Sebastián', 'San Sebastián', 'AL MARGEN NORTE DE LA CARRETERA NACIONAL TRONCAL 11, TRAMO SAN JUAN DE LOS MORROS', 'Verificada', NULL, NULL, NULL),
(5, 4, 'UNIDAD TÉCNICA DE PRODUCCIÓN AGUA VIVA II', 'San Sebastián', 'San Sebastián', 'AL MARGEN NORTE DE LA CARRETERA NACIONAL TRONCAL 11, TRAMO SAN JUAN DE LOS MORROS', 'Verificada', NULL, NULL, NULL),
(6, 4, 'UNIDAD TÉCNICA DE PRODUCCIÓN EL PAITO', 'San Sebastián', 'San Sebastián', 'HACIENDA EL PAITO', 'Verificada', NULL, NULL, NULL),
(7, 4, 'UNIDAD TÉCNICA DE PRODUCCIÓN CHUPADERO', 'San Sebastián', 'San Sebastián', 'SECTOR CHUPADERO', 'Verificada', NULL, NULL, NULL),
(8, 4, 'UNIDAD TÉCNICA DE PRODUCCIÓN PARDILLAL', 'San Casimiro', 'San Casimiro', 'CARRETERA NACIONAL SAN SEBASTIÁN DE LOS REYES - PARDILLAL - CAMATAGUA. TRONCAL 11. SECTOR EL RODEO', 'Verificada', NULL, NULL, NULL),
(9, 1, 'RÍO LIMÓN', 'Mario Briceño Iragorry', 'El Limón', 'RÍO LIMÓN SECTOR DACOPAM, FINAL AV BOLIVAR, SECTOR TAPATAPA, MARACAY', 'Verificada', NULL, NULL, NULL),
(10, 3, 'MINEROS DEL SUR', 'San Casimiro', 'San Casimiro', 'CALLE PRINCIPAL CASA NRO S/N SECTOR EL RODEO SAN CASIMIRO ARAGUA', 'Verificada', NULL, NULL, NULL),
(11, 2, 'PIEDRA AZUL', 'San Casimiro', 'San Casimiro', 'CALLE PRINCIPAL CASA NRO S/N SECTOR EL RODEO SAN CASIMIRO ARAGUA', 'Verificada', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cierre_libros`
--

CREATE TABLE `cierre_libros` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_user` int(10) UNSIGNED NOT NULL,
  `dia_cierre` int(11) NOT NULL,
  `last_update` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clasificacions`
--

CREATE TABLE `clasificacions` (
  `id_clasificacion` int(10) UNSIGNED NOT NULL,
  `nombre_clf` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `clasificacions`
--

INSERT INTO `clasificacions` (`id_clasificacion`, `nombre_clf`, `created_at`, `updated_at`) VALUES
(1, 'Declarado', NULL, NULL),
(2, 'Sin Declarar', NULL, NULL),
(3, 'Extemporanea', NULL, NULL),
(4, 'Verificando', NULL, NULL),
(5, 'Verificado', NULL, NULL),
(6, 'Negado', NULL, NULL),
(7, 'Aprobacion de Solicitudes', NULL, NULL),
(8, 'Actualización de Estado - Solicitudes', NULL, NULL),
(9, 'Nuevos Usuarios', NULL, NULL),
(10, 'Canteras registradas', NULL, NULL),
(11, 'Declaraciones', NULL, NULL),
(12, 'Sujetos Pasivos', NULL, NULL),
(13, 'Talonarios', NULL, NULL),
(14, 'Control de Canteras', NULL, NULL),
(15, 'Usuarios', NULL, NULL),
(16, 'UCD', NULL, NULL),
(17, 'En Proceso', NULL, NULL),
(18, 'Por retirar', NULL, NULL),
(19, 'Entregado', NULL, NULL),
(20, 'Por enviar', NULL, NULL),
(21, 'Enviado', NULL, NULL),
(22, 'Recibido', NULL, NULL),
(23, 'Retirado', NULL, NULL),
(24, 'Reservas', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `control_guias`
--

CREATE TABLE `control_guias` (
  `correlativo` int(10) UNSIGNED NOT NULL,
  `id_talonario` int(10) UNSIGNED NOT NULL,
  `id_sujeto` int(10) UNSIGNED NOT NULL,
  `id_cantera` int(10) UNSIGNED NOT NULL,
  `id_libro` int(10) UNSIGNED NOT NULL,
  `nro_guia` varchar(255) NOT NULL,
  `id_declaracion` int(10) UNSIGNED DEFAULT NULL,
  `fecha` date NOT NULL,
  `razon_destinatario` varchar(255) NOT NULL,
  `ci_destinatario` varchar(15) NOT NULL,
  `tlf_destinatario` varchar(15) NOT NULL,
  `municipio_destino` varchar(255) NOT NULL,
  `parroquia_destino` varchar(255) NOT NULL,
  `destino` varchar(255) NOT NULL,
  `nro_factura` varchar(255) DEFAULT NULL,
  `fecha_facturacion` date DEFAULT NULL,
  `id_mineral` int(10) UNSIGNED NOT NULL,
  `unidad_medida` enum('Toneladas','Metros cúbicos') NOT NULL,
  `cantidad_facturada` double(8,2) DEFAULT NULL,
  `saldo_anterior` double(8,2) DEFAULT NULL,
  `cantidad_despachada` double(8,2) NOT NULL,
  `saldo_restante` double(8,2) DEFAULT NULL,
  `modelo_vehiculo` varchar(255) NOT NULL,
  `placa` varchar(255) NOT NULL,
  `nombre_conductor` varchar(255) NOT NULL,
  `ci_conductor` varchar(15) NOT NULL,
  `tlf_conductor` varchar(15) NOT NULL,
  `capacidad_vehiculo` varchar(255) NOT NULL,
  `hora_salida` varchar(255) NOT NULL,
  `anulada` enum('No','Si') NOT NULL,
  `motivo` varchar(255) DEFAULT NULL,
  `estado` int(10) UNSIGNED DEFAULT NULL,
  `declaracion` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `declaracions`
--

CREATE TABLE `declaracions` (
  `id_declaracion` int(10) UNSIGNED NOT NULL,
  `id_sujeto` int(10) UNSIGNED NOT NULL,
  `id_libro` int(10) UNSIGNED NOT NULL,
  `year_declarado` int(11) NOT NULL,
  `mes_declarado` int(11) NOT NULL,
  `nro_guias_declaradas` int(11) NOT NULL,
  `total_ucd` int(11) NOT NULL,
  `monto_total` double(8,2) NOT NULL,
  `id_ucd` int(10) UNSIGNED NOT NULL,
  `referencia` varchar(255) DEFAULT NULL,
  `fecha` date NOT NULL DEFAULT current_timestamp(),
  `estado` int(10) UNSIGNED NOT NULL,
  `tipo` int(10) UNSIGNED NOT NULL,
  `observaciones` varchar(400) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_reservas`
--

CREATE TABLE `detalle_reservas` (
  `correlativo` int(10) UNSIGNED NOT NULL,
  `tipo_talonario` enum('50') NOT NULL,
  `cantidad` int(11) NOT NULL,
  `id_reserva` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_solicituds`
--

CREATE TABLE `detalle_solicituds` (
  `id_detalle` int(10) UNSIGNED NOT NULL,
  `tipo_talonario` enum('50') NOT NULL,
  `cantidad` int(11) NOT NULL,
  `id_solicitud` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `detalle_solicituds`
--

INSERT INTO `detalle_solicituds` (`id_detalle`, `tipo_talonario`, `cantidad`, `id_solicitud`, `created_at`, `updated_at`) VALUES
(1, '50', 10, 1, NULL, NULL),
(2, '50', 10, 2, NULL, NULL),
(3, '50', 10, 3, NULL, NULL),
(4, '50', 10, 4, NULL, NULL),
(5, '50', 10, 5, NULL, NULL),
(6, '50', 10, 6, NULL, NULL),
(7, '50', 10, 7, NULL, NULL),
(8, '50', 10, 8, NULL, NULL),
(9, '50', 10, 9, NULL, NULL),
(10, '50', 10, 10, NULL, NULL),
(11, '50', 10, 11, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_talonarios`
--

CREATE TABLE `detalle_talonarios` (
  `correlativo` int(10) UNSIGNED NOT NULL,
  `id_talonario` int(10) UNSIGNED NOT NULL,
  `id_cantera` int(10) UNSIGNED NOT NULL,
  `id_sujeto` int(10) UNSIGNED NOT NULL,
  `desde` int(11) NOT NULL,
  `hasta` int(11) NOT NULL,
  `qr` varchar(255) DEFAULT NULL,
  `clase` int(10) UNSIGNED NOT NULL,
  `id_solicitud_reserva` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `detalle_talonarios`
--

INSERT INTO `detalle_talonarios` (`correlativo`, `id_talonario`, `id_cantera`, `id_sujeto`, `desde`, `hasta`, `qr`, `clase`, `id_solicitud_reserva`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 4, 1, 50, 'assets/qr/qrcode_T1.svg', 5, NULL, NULL, NULL),
(2, 2, 1, 4, 51, 100, 'assets/qr/qrcode_T2.svg', 5, NULL, NULL, NULL),
(3, 3, 1, 4, 101, 150, 'assets/qr/qrcode_T3.svg', 5, NULL, NULL, NULL),
(4, 4, 1, 4, 151, 200, 'assets/qr/qrcode_T4.svg', 5, NULL, NULL, NULL),
(5, 5, 1, 4, 201, 250, 'assets/qr/qrcode_T5.svg', 5, NULL, NULL, NULL),
(6, 6, 1, 4, 251, 300, 'assets/qr/qrcode_T6.svg', 5, NULL, NULL, NULL),
(7, 7, 1, 4, 301, 350, 'assets/qr/qrcode_T7.svg', 5, NULL, NULL, NULL),
(8, 8, 1, 4, 351, 400, 'assets/qr/qrcode_T8.svg', 5, NULL, NULL, NULL),
(9, 9, 1, 4, 401, 450, 'assets/qr/qrcode_T9.svg', 5, NULL, NULL, NULL),
(10, 10, 1, 4, 451, 500, 'assets/qr/qrcode_T10.svg', 5, NULL, NULL, NULL),
(11, 11, 2, 4, 501, 550, 'assets/qr/qrcode_T11.svg', 5, NULL, NULL, NULL),
(12, 12, 2, 4, 551, 600, 'assets/qr/qrcode_T12.svg', 5, NULL, NULL, NULL),
(13, 13, 2, 4, 601, 650, 'assets/qr/qrcode_T13.svg', 5, NULL, NULL, NULL),
(14, 14, 2, 4, 651, 700, 'assets/qr/qrcode_T14.svg', 5, NULL, NULL, NULL),
(15, 15, 2, 4, 701, 750, 'assets/qr/qrcode_T15.svg', 5, NULL, NULL, NULL),
(16, 16, 2, 4, 751, 800, 'assets/qr/qrcode_T16.svg', 5, NULL, NULL, NULL),
(17, 17, 2, 4, 801, 850, 'assets/qr/qrcode_T17.svg', 5, NULL, NULL, NULL),
(18, 18, 2, 4, 851, 900, 'assets/qr/qrcode_T18.svg', 5, NULL, NULL, NULL),
(19, 19, 2, 4, 901, 950, 'assets/qr/qrcode_T19.svg', 5, NULL, NULL, NULL),
(20, 20, 2, 4, 951, 1000, 'assets/qr/qrcode_T20.svg', 5, NULL, NULL, NULL),
(21, 21, 3, 4, 1001, 1050, 'assets/qr/qrcode_T21.svg', 5, NULL, NULL, NULL),
(22, 22, 3, 4, 1051, 1100, 'assets/qr/qrcode_T22.svg', 5, NULL, NULL, NULL),
(23, 23, 3, 4, 1101, 1150, 'assets/qr/qrcode_T23.svg', 5, NULL, NULL, NULL),
(24, 24, 3, 4, 1151, 1200, 'assets/qr/qrcode_T24.svg', 5, NULL, NULL, NULL),
(25, 25, 3, 4, 1201, 1250, 'assets/qr/qrcode_T25.svg', 5, NULL, NULL, NULL),
(26, 26, 3, 4, 1251, 1300, 'assets/qr/qrcode_T26.svg', 5, NULL, NULL, NULL),
(27, 27, 3, 4, 1301, 1350, 'assets/qr/qrcode_T27.svg', 5, NULL, NULL, NULL),
(28, 28, 3, 4, 1351, 1400, 'assets/qr/qrcode_T28.svg', 5, NULL, NULL, NULL),
(29, 29, 3, 4, 1401, 1450, 'assets/qr/qrcode_T29.svg', 5, NULL, NULL, NULL),
(30, 30, 3, 4, 1451, 1500, 'assets/qr/qrcode_T30.svg', 5, NULL, NULL, NULL),
(31, 31, 4, 4, 1501, 1550, 'assets/qr/qrcode_T31.svg', 5, NULL, NULL, NULL),
(32, 32, 4, 4, 1551, 1600, 'assets/qr/qrcode_T32.svg', 5, NULL, NULL, NULL),
(33, 33, 4, 4, 1601, 1650, 'assets/qr/qrcode_T33.svg', 5, NULL, NULL, NULL),
(34, 34, 4, 4, 1651, 1700, 'assets/qr/qrcode_T34.svg', 5, NULL, NULL, NULL),
(35, 35, 4, 4, 1701, 1750, 'assets/qr/qrcode_T35.svg', 5, NULL, NULL, NULL),
(36, 36, 4, 4, 1751, 1800, 'assets/qr/qrcode_T36.svg', 5, NULL, NULL, NULL),
(37, 37, 4, 4, 1801, 1850, 'assets/qr/qrcode_T37.svg', 5, NULL, NULL, NULL),
(38, 38, 4, 4, 1851, 1900, 'assets/qr/qrcode_T38.svg', 5, NULL, NULL, NULL),
(39, 39, 4, 4, 1901, 1950, 'assets/qr/qrcode_T39.svg', 5, NULL, NULL, NULL),
(40, 40, 4, 4, 1951, 2000, 'assets/qr/qrcode_T40.svg', 5, NULL, NULL, NULL),
(41, 41, 5, 4, 2001, 2050, 'assets/qr/qrcode_T41.svg', 5, NULL, NULL, NULL),
(42, 42, 5, 4, 2051, 2100, 'assets/qr/qrcode_T42.svg', 5, NULL, NULL, NULL),
(43, 43, 5, 4, 2101, 2150, 'assets/qr/qrcode_T43.svg', 5, NULL, NULL, NULL),
(44, 44, 5, 4, 2151, 2200, 'assets/qr/qrcode_T44.svg', 5, NULL, NULL, NULL),
(45, 45, 5, 4, 2201, 2250, 'assets/qr/qrcode_T45.svg', 5, NULL, NULL, NULL),
(46, 46, 5, 4, 2251, 2300, 'assets/qr/qrcode_T46.svg', 5, NULL, NULL, NULL),
(47, 47, 5, 4, 2301, 2350, 'assets/qr/qrcode_T47.svg', 5, NULL, NULL, NULL),
(48, 48, 5, 4, 2351, 2400, 'assets/qr/qrcode_T48.svg', 5, NULL, NULL, NULL),
(49, 49, 5, 4, 2401, 2450, 'assets/qr/qrcode_T49.svg', 5, NULL, NULL, NULL),
(50, 50, 5, 4, 2451, 2500, 'assets/qr/qrcode_T50.svg', 5, NULL, NULL, NULL),
(51, 51, 6, 4, 2501, 2550, 'assets/qr/qrcode_T51.svg', 5, NULL, NULL, NULL),
(52, 52, 6, 4, 2551, 2600, 'assets/qr/qrcode_T52.svg', 5, NULL, NULL, NULL),
(53, 53, 6, 4, 2601, 2650, 'assets/qr/qrcode_T53.svg', 5, NULL, NULL, NULL),
(54, 54, 6, 4, 2651, 2700, 'assets/qr/qrcode_T54.svg', 5, NULL, NULL, NULL),
(55, 55, 6, 4, 2701, 2750, 'assets/qr/qrcode_T55.svg', 5, NULL, NULL, NULL),
(56, 56, 6, 4, 2751, 2800, 'assets/qr/qrcode_T56.svg', 5, NULL, NULL, NULL),
(57, 57, 6, 4, 2801, 2850, 'assets/qr/qrcode_T57.svg', 5, NULL, NULL, NULL),
(58, 58, 6, 4, 2851, 2900, 'assets/qr/qrcode_T58.svg', 5, NULL, NULL, NULL),
(59, 59, 6, 4, 2901, 2950, 'assets/qr/qrcode_T59.svg', 5, NULL, NULL, NULL),
(60, 60, 6, 4, 2951, 3000, 'assets/qr/qrcode_T60.svg', 5, NULL, NULL, NULL),
(61, 61, 7, 4, 3001, 3050, 'assets/qr/qrcode_T61.svg', 5, NULL, NULL, NULL),
(62, 62, 7, 4, 3051, 3100, 'assets/qr/qrcode_T62.svg', 5, NULL, NULL, NULL),
(63, 63, 7, 4, 3101, 3150, 'assets/qr/qrcode_T63.svg', 5, NULL, NULL, NULL),
(64, 64, 7, 4, 3151, 3200, 'assets/qr/qrcode_T64.svg', 5, NULL, NULL, NULL),
(65, 65, 7, 4, 3201, 3250, 'assets/qr/qrcode_T65.svg', 5, NULL, NULL, NULL),
(66, 66, 7, 4, 3251, 3300, 'assets/qr/qrcode_T66.svg', 5, NULL, NULL, NULL),
(67, 67, 7, 4, 3301, 3350, 'assets/qr/qrcode_T67.svg', 5, NULL, NULL, NULL),
(68, 68, 7, 4, 3351, 3400, 'assets/qr/qrcode_T68.svg', 5, NULL, NULL, NULL),
(69, 69, 7, 4, 3401, 3450, 'assets/qr/qrcode_T69.svg', 5, NULL, NULL, NULL),
(70, 70, 7, 4, 3451, 3500, 'assets/qr/qrcode_T70.svg', 5, NULL, NULL, NULL),
(71, 71, 8, 4, 3501, 3550, 'assets/qr/qrcode_T71.svg', 5, NULL, NULL, NULL),
(72, 72, 8, 4, 3551, 3600, 'assets/qr/qrcode_T72.svg', 5, NULL, NULL, NULL),
(73, 73, 8, 4, 3601, 3650, 'assets/qr/qrcode_T73.svg', 5, NULL, NULL, NULL),
(74, 74, 8, 4, 3651, 3700, 'assets/qr/qrcode_T74.svg', 5, NULL, NULL, NULL),
(75, 75, 8, 4, 3701, 3750, 'assets/qr/qrcode_T75.svg', 5, NULL, NULL, NULL),
(76, 76, 8, 4, 3751, 3800, 'assets/qr/qrcode_T76.svg', 5, NULL, NULL, NULL),
(77, 77, 8, 4, 3801, 3850, 'assets/qr/qrcode_T77.svg', 5, NULL, NULL, NULL),
(78, 78, 8, 4, 3851, 3900, 'assets/qr/qrcode_T78.svg', 5, NULL, NULL, NULL),
(79, 79, 8, 4, 3901, 3950, 'assets/qr/qrcode_T79.svg', 5, NULL, NULL, NULL),
(80, 80, 8, 4, 3951, 4000, 'assets/qr/qrcode_T80.svg', 5, NULL, NULL, NULL),
(81, 81, 9, 1, 4001, 4050, 'assets/qr/qrcode_T81.svg', 5, NULL, NULL, NULL),
(82, 82, 9, 1, 4051, 4100, 'assets/qr/qrcode_T82.svg', 5, NULL, NULL, NULL),
(83, 83, 9, 1, 4101, 4150, 'assets/qr/qrcode_T83.svg', 5, NULL, NULL, NULL),
(84, 84, 9, 1, 4151, 4200, 'assets/qr/qrcode_T84.svg', 5, NULL, NULL, NULL),
(85, 85, 9, 1, 4201, 4250, 'assets/qr/qrcode_T85.svg', 5, NULL, NULL, NULL),
(86, 86, 9, 1, 4251, 4300, 'assets/qr/qrcode_T86.svg', 5, NULL, NULL, NULL),
(87, 87, 9, 1, 4301, 4350, 'assets/qr/qrcode_T87.svg', 5, NULL, NULL, NULL),
(88, 88, 9, 1, 4351, 4400, 'assets/qr/qrcode_T88.svg', 5, NULL, NULL, NULL),
(89, 89, 9, 1, 4401, 4450, 'assets/qr/qrcode_T89.svg', 5, NULL, NULL, NULL),
(90, 90, 9, 1, 4451, 4500, 'assets/qr/qrcode_T90.svg', 5, NULL, NULL, NULL),
(91, 91, 10, 3, 4501, 4550, 'assets/qr/qrcode_T91.svg', 5, NULL, NULL, NULL),
(92, 92, 10, 3, 4551, 4600, 'assets/qr/qrcode_T92.svg', 5, NULL, NULL, NULL),
(93, 93, 10, 3, 4601, 4650, 'assets/qr/qrcode_T93.svg', 5, NULL, NULL, NULL),
(94, 94, 10, 3, 4651, 4700, 'assets/qr/qrcode_T94.svg', 5, NULL, NULL, NULL),
(95, 95, 10, 3, 4701, 4750, 'assets/qr/qrcode_T95.svg', 5, NULL, NULL, NULL),
(96, 96, 10, 3, 4751, 4800, 'assets/qr/qrcode_T96.svg', 5, NULL, NULL, NULL),
(97, 97, 10, 3, 4801, 4850, 'assets/qr/qrcode_T97.svg', 5, NULL, NULL, NULL),
(98, 98, 10, 3, 4851, 4900, 'assets/qr/qrcode_T98.svg', 5, NULL, NULL, NULL),
(99, 99, 10, 3, 4901, 4950, 'assets/qr/qrcode_T99.svg', 5, NULL, NULL, NULL),
(100, 100, 10, 3, 4951, 5000, 'assets/qr/qrcode_T100.svg', 5, NULL, NULL, NULL),
(101, 101, 11, 2, 5001, 5050, 'assets/qr/qrcode_T101.svg', 5, NULL, NULL, NULL),
(102, 102, 11, 2, 5051, 5100, 'assets/qr/qrcode_T102.svg', 5, NULL, NULL, NULL),
(103, 103, 11, 2, 5101, 5150, 'assets/qr/qrcode_T103.svg', 5, NULL, NULL, NULL),
(104, 104, 11, 2, 5151, 5200, 'assets/qr/qrcode_T104.svg', 5, NULL, NULL, NULL),
(105, 105, 11, 2, 5201, 5250, 'assets/qr/qrcode_T105.svg', 5, NULL, NULL, NULL),
(106, 106, 11, 2, 5251, 5300, 'assets/qr/qrcode_T106.svg', 5, NULL, NULL, NULL),
(107, 107, 11, 2, 5301, 5350, 'assets/qr/qrcode_T107.svg', 5, NULL, NULL, NULL),
(108, 108, 11, 2, 5351, 5400, 'assets/qr/qrcode_T108.svg', 5, NULL, NULL, NULL),
(109, 109, 11, 2, 5401, 5450, 'assets/qr/qrcode_T109.svg', 5, NULL, NULL, NULL),
(110, 110, 11, 2, 5451, 5500, 'assets/qr/qrcode_T110.svg', 5, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fechas`
--

CREATE TABLE `fechas` (
  `id_fecha` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `fecha` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `fechas`
--

INSERT INTO `fechas` (`id_fecha`, `nombre`, `fecha`, `created_at`, `updated_at`) VALUES
(1, 'cierre_libro', 1, NULL, NULL),
(2, 'inicio_declaracion', 1, NULL, NULL),
(3, 'fin_declaracion', 10, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libros`
--

CREATE TABLE `libros` (
  `id_libro` int(10) UNSIGNED NOT NULL,
  `id_sujeto` int(10) UNSIGNED NOT NULL,
  `mes` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `estado` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `limite_guias`
--

CREATE TABLE `limite_guias` (
  `cod` int(10) UNSIGNED NOT NULL,
  `id_sujeto` int(10) UNSIGNED NOT NULL,
  `id_cantera` int(10) UNSIGNED NOT NULL,
  `total_guias_periodo` int(11) DEFAULT NULL,
  `total_guias_solicitadas_periodo` int(11) DEFAULT NULL,
  `inicio_periodo` date NOT NULL,
  `fin_periodo` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `limite_guias`
--

INSERT INTO `limite_guias` (`cod`, `id_sujeto`, `id_cantera`, `total_guias_periodo`, `total_guias_solicitadas_periodo`, `inicio_periodo`, `fin_periodo`, `created_at`, `updated_at`) VALUES
(1, 4, 1, 1000, 500, '2024-06-20', '2024-09-20', NULL, NULL),
(2, 4, 2, 1000, 500, '2024-06-20', '2024-09-20', NULL, NULL),
(3, 4, 3, 1000, 500, '2024-06-20', '2024-09-20', NULL, NULL),
(4, 4, 4, 1000, 500, '2024-06-20', '2024-09-20', NULL, NULL),
(5, 4, 5, 1000, 500, '2024-06-20', '2024-09-20', NULL, NULL),
(6, 4, 6, 1000, 500, '2024-06-20', '2024-09-20', NULL, NULL),
(7, 4, 7, 1000, 500, '2024-06-20', '2024-09-20', NULL, NULL),
(8, 4, 8, 1000, 500, '2024-06-20', '2024-09-20', NULL, NULL),
(9, 1, 9, 1000, 500, '2024-06-20', '2024-09-20', NULL, NULL),
(10, 3, 10, 1000, 500, '2024-06-20', '2024-09-20', NULL, NULL),
(11, 2, 11, 1000, 500, '2024-06-20', '2024-09-20', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_09_12_000000_creation_tipos_table', 1),
(2, '2014_10_12_000000_create_users_table', 1),
(3, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(4, '2014_10_12_100000_create_password_resets_table', 1),
(5, '2019_08_19_000000_create_failed_jobs_table', 1),
(6, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(7, '2024_03_04_000000_creation_clasificacions_table', 1),
(8, '2024_03_04_013642_create_sujeto_pasivos_table', 1),
(9, '2024_04_02_003327_creation_reservas_table', 1),
(10, '2024_04_02_003410_creation_detalle_reservas_table', 1),
(11, '2024_04_02_003459_creation_total_guias_reservas_table', 1),
(12, '2024_04_02_143634_creation_ucds_table', 1),
(13, '2024_04_02_143655_creation_canteras_table', 1),
(14, '2024_04_02_143708_creation_minerals_table', 1),
(15, '2024_04_02_143723_creation_produccions_table', 1),
(16, '2024_04_02_143744_creation_solicituds_table', 1),
(17, '2024_04_02_143810_creation_detalle_solicituds_table', 1),
(18, '2024_04_02_143827_creation_nro_controls_table', 1),
(19, '2024_04_02_143840_creation_solicitud_reservas_table', 1),
(20, '2024_04_02_143841_creation_talonarios_table', 1),
(21, '2024_04_02_143842_creation_detalle_talonarios_table', 1),
(22, '2024_04_02_143911_creation_limite_guias_table', 1),
(23, '2024_04_24_143856_creation_cierre_libros_table', 1),
(24, '2024_05_09_164708_creation_libros_table', 1),
(25, '2024_05_09_164746_creation_declaracions_table', 1),
(26, '2024_05_09_164816_creation_control_guias_table', 1),
(27, '2024_05_09_164846_creation_fechas_table', 1),
(28, '2024_05_17_165432_creation_bitacoras_table', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `minerals`
--

CREATE TABLE `minerals` (
  `id_mineral` int(10) UNSIGNED NOT NULL,
  `mineral` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `minerals`
--

INSERT INTO `minerals` (`id_mineral`, `mineral`, `created_at`, `updated_at`) VALUES
(1, 'Caliza (EN BRUTO)', NULL, NULL),
(2, 'Piedra Caliza (¾ - 1)', NULL, NULL),
(3, 'Arrocillo de Caliza (3/8)', NULL, NULL),
(4, 'Polvillo de Caliza', NULL, NULL),
(5, 'Carbonato de Calcio', NULL, NULL),
(6, 'Ripio', NULL, NULL),
(7, 'Dolomita - Dolomita (EN BRUTO)', NULL, NULL),
(8, 'Piedra Blanca Dolomita', NULL, NULL),
(9, 'Cal Hidratada', NULL, NULL),
(10, 'Cal Agrícola', NULL, NULL),
(11, 'Concreto', NULL, NULL),
(12, 'Cemento', NULL, NULL),
(13, 'Arena de Río', NULL, NULL),
(14, 'Arena Lavada', NULL, NULL),
(15, 'Arena Cernida', NULL, NULL),
(16, 'Gravilla ¾', NULL, NULL),
(17, 'Ceramicos', NULL, NULL),
(18, 'Arcillas', NULL, NULL),
(19, 'Adoquines', NULL, NULL),
(20, 'Gravilla (¾ - 1)', NULL, NULL),
(21, 'Bloques', NULL, NULL),
(22, 'Piedra Integral', NULL, NULL),
(23, 'Gavión', NULL, NULL),
(24, 'Granzón', NULL, NULL),
(25, 'PIEDRA CALIZA 3/4', NULL, NULL),
(26, 'PIEDRA CALIZA 4', NULL, NULL),
(27, 'PIEDRA CALIZA 1', NULL, NULL),
(28, 'Asfalto', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nro_controls`
--

CREATE TABLE `nro_controls` (
  `cod` int(10) UNSIGNED NOT NULL,
  `id_solicitud` int(10) UNSIGNED NOT NULL,
  `nro_guia` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `produccions`
--

CREATE TABLE `produccions` (
  `id_produccion` int(10) UNSIGNED NOT NULL,
  `id_cantera` int(10) UNSIGNED NOT NULL,
  `id_mineral` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `produccions`
--

INSERT INTO `produccions` (`id_produccion`, `id_cantera`, `id_mineral`, `created_at`, `updated_at`) VALUES
(5, 2, 3, NULL, NULL),
(6, 2, 4, NULL, NULL),
(7, 2, 25, NULL, NULL),
(8, 4, 26, NULL, NULL),
(9, 4, 25, NULL, NULL),
(10, 5, 3, NULL, NULL),
(11, 5, 25, NULL, NULL),
(12, 5, 26, NULL, NULL),
(13, 5, 27, NULL, NULL),
(14, 6, 14, NULL, NULL),
(15, 7, 25, NULL, NULL),
(16, 8, 28, NULL, NULL),
(17, 10, 1, NULL, NULL),
(18, 11, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservas`
--

CREATE TABLE `reservas` (
  `id_reserva` int(10) UNSIGNED NOT NULL,
  `id_user` int(10) UNSIGNED NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicituds`
--

CREATE TABLE `solicituds` (
  `id_solicitud` int(10) UNSIGNED NOT NULL,
  `id_sujeto` int(10) UNSIGNED NOT NULL,
  `id_cantera` int(10) UNSIGNED NOT NULL,
  `total_ucd` int(11) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `estado` int(10) UNSIGNED NOT NULL,
  `observaciones` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `solicituds`
--

INSERT INTO `solicituds` (`id_solicitud`, `id_sujeto`, `id_cantera`, `total_ucd`, `fecha`, `estado`, `observaciones`, `created_at`, `updated_at`) VALUES
(1, 4, 1, 2500, '2024-06-19 21:19:38', 17, NULL, NULL, NULL),
(2, 4, 2, 2500, '2024-06-19 21:19:54', 17, NULL, NULL, NULL),
(3, 4, 3, 2500, '2024-06-19 21:20:07', 17, NULL, NULL, NULL),
(4, 4, 4, 2500, '2024-06-19 21:20:32', 17, NULL, NULL, NULL),
(5, 4, 5, 2500, '2024-06-19 21:20:45', 17, NULL, NULL, NULL),
(6, 4, 6, 2500, '2024-06-19 21:20:59', 17, NULL, NULL, NULL),
(7, 4, 7, 2500, '2024-06-19 21:21:18', 17, NULL, NULL, NULL),
(8, 4, 8, 2500, '2024-06-19 21:21:30', 17, NULL, NULL, NULL),
(9, 1, 9, 2500, '2024-06-19 21:22:39', 17, NULL, NULL, NULL),
(10, 3, 10, 2500, '2024-06-19 21:23:22', 17, NULL, NULL, NULL),
(11, 2, 11, 2500, '2024-06-19 21:23:59', 17, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitud_reservas`
--

CREATE TABLE `solicitud_reservas` (
  `id_solicitud_reserva` int(10) UNSIGNED NOT NULL,
  `id_sujeto` int(10) UNSIGNED NOT NULL,
  `id_cantera` int(10) UNSIGNED NOT NULL,
  `cantidad_guias` int(10) UNSIGNED NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `total_ucd` int(11) NOT NULL,
  `estado` int(10) UNSIGNED NOT NULL,
  `observaciones` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sujeto_pasivos`
--

CREATE TABLE `sujeto_pasivos` (
  `id_sujeto` int(10) UNSIGNED NOT NULL,
  `id_user` int(10) UNSIGNED NOT NULL,
  `rif_condicion` enum('G','J') NOT NULL,
  `rif_nro` varchar(12) NOT NULL,
  `artesanal` enum('No','Si') NOT NULL,
  `razon_social` varchar(255) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `tlf_movil` varchar(18) NOT NULL,
  `tlf_fijo` varchar(18) DEFAULT NULL,
  `ci_condicion_repr` enum('V','E') NOT NULL,
  `ci_nro_repr` varchar(10) NOT NULL,
  `rif_condicion_repr` enum('V','E') NOT NULL,
  `rif_nro_repr` varchar(10) NOT NULL,
  `name_repr` varchar(255) NOT NULL,
  `tlf_repr` varchar(15) NOT NULL,
  `estado` enum('Verificando','Verificado','Rechazado') NOT NULL,
  `observaciones` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `sujeto_pasivos`
--

INSERT INTO `sujeto_pasivos` (`id_sujeto`, `id_user`, `rif_condicion`, `rif_nro`, `artesanal`, `razon_social`, `direccion`, `tlf_movil`, `tlf_fijo`, `ci_condicion_repr`, `ci_nro_repr`, `rif_condicion_repr`, `rif_nro_repr`, `name_repr`, `tlf_repr`, `estado`, `observaciones`, `created_at`, `updated_at`) VALUES
(1, 2, 'J', '500570155', 'No', 'TECNOCOMODITY, C.A.', 'DIRECCIÓN', '04140000000', NULL, 'V', '18642293', 'V', '18642293', 'JARO LABRADOR', '04140000000', 'Verificado', NULL, '2024-06-19 18:07:42', '2024-06-19 18:07:42'),
(2, 3, 'J', '412689789', 'Si', 'UNIDAD PRODUCTIVA FAMILIAR PIEDRA AZUL', 'CALLE PRINCIPAL CASA NRO S/N SECTOR EL RODEO SAN CASMIRO ARAGUA, MUNICIPIO SAN CASIMIRO', '04140000000', NULL, 'V', '20757676', 'V', '20757676', 'AMALIO FERRER', '04140000000', 'Verificado', NULL, '2024-06-19 18:11:54', '2024-06-19 18:11:54'),
(3, 4, 'J', '412663941', 'Si', 'UNIDAD PRODUCTIVA FAMILIAR MINEROS DEL SUR', 'CALLE PRINCIPAL CASA NRO S/N SECTOR EL RODEO SAN CASMIRO ARAGUA', '04140000000', NULL, 'V', '26715191', 'V', '26715191', 'ROANGEL RODRIGUEZ', '04140000000', 'Verificado', NULL, '2024-06-19 18:13:55', '2024-06-19 18:13:55'),
(4, 5, 'G', '200108240', 'No', 'ARAGUA MINAS Y CANTERAS, S.A.', 'DIRECCIÓN', '04140000000', NULL, 'V', '00000000', 'V', '00000000', 'LEON', '04140000000', 'Verificado', NULL, '2024-06-19 18:17:28', '2024-06-19 18:17:28');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `talonarios`
--

CREATE TABLE `talonarios` (
  `id_talonario` int(10) UNSIGNED NOT NULL,
  `id_solicitud` int(10) UNSIGNED DEFAULT NULL,
  `id_reserva` int(10) UNSIGNED DEFAULT NULL,
  `tipo_talonario` enum('50') NOT NULL,
  `desde` int(11) NOT NULL,
  `hasta` int(11) NOT NULL,
  `clase` int(10) UNSIGNED NOT NULL,
  `estado` int(10) UNSIGNED NOT NULL,
  `asignado` int(11) NOT NULL,
  `fecha_enviado_imprenta` date DEFAULT NULL,
  `fecha_recibido_imprenta` date DEFAULT NULL,
  `fecha_retiro` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `talonarios`
--

INSERT INTO `talonarios` (`id_talonario`, `id_solicitud`, `id_reserva`, `tipo_talonario`, `desde`, `hasta`, `clase`, `estado`, `asignado`, `fecha_enviado_imprenta`, `fecha_recibido_imprenta`, `fecha_retiro`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, '50', 1, 50, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(2, 1, NULL, '50', 51, 100, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(3, 1, NULL, '50', 101, 150, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(4, 1, NULL, '50', 151, 200, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(5, 1, NULL, '50', 201, 250, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(6, 1, NULL, '50', 251, 300, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(7, 1, NULL, '50', 301, 350, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(8, 1, NULL, '50', 351, 400, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(9, 1, NULL, '50', 401, 450, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(10, 1, NULL, '50', 451, 500, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(11, 2, NULL, '50', 501, 550, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(12, 2, NULL, '50', 551, 600, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(13, 2, NULL, '50', 601, 650, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(14, 2, NULL, '50', 651, 700, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(15, 2, NULL, '50', 701, 750, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(16, 2, NULL, '50', 751, 800, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(17, 2, NULL, '50', 801, 850, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(18, 2, NULL, '50', 851, 900, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(19, 2, NULL, '50', 901, 950, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(20, 2, NULL, '50', 951, 1000, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(21, 3, NULL, '50', 1001, 1050, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(22, 3, NULL, '50', 1051, 1100, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(23, 3, NULL, '50', 1101, 1150, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(24, 3, NULL, '50', 1151, 1200, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(25, 3, NULL, '50', 1201, 1250, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(26, 3, NULL, '50', 1251, 1300, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(27, 3, NULL, '50', 1301, 1350, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(28, 3, NULL, '50', 1351, 1400, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(29, 3, NULL, '50', 1401, 1450, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(30, 3, NULL, '50', 1451, 1500, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(31, 4, NULL, '50', 1501, 1550, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(32, 4, NULL, '50', 1551, 1600, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(33, 4, NULL, '50', 1601, 1650, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(34, 4, NULL, '50', 1651, 1700, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(35, 4, NULL, '50', 1701, 1750, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(36, 4, NULL, '50', 1751, 1800, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(37, 4, NULL, '50', 1801, 1850, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(38, 4, NULL, '50', 1851, 1900, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(39, 4, NULL, '50', 1901, 1950, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(40, 4, NULL, '50', 1951, 2000, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(41, 5, NULL, '50', 2001, 2050, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(42, 5, NULL, '50', 2051, 2100, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(43, 5, NULL, '50', 2101, 2150, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(44, 5, NULL, '50', 2151, 2200, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(45, 5, NULL, '50', 2201, 2250, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(46, 5, NULL, '50', 2251, 2300, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(47, 5, NULL, '50', 2301, 2350, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(48, 5, NULL, '50', 2351, 2400, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(49, 5, NULL, '50', 2401, 2450, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(50, 5, NULL, '50', 2451, 2500, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(51, 6, NULL, '50', 2501, 2550, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(52, 6, NULL, '50', 2551, 2600, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(53, 6, NULL, '50', 2601, 2650, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(54, 6, NULL, '50', 2651, 2700, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(55, 6, NULL, '50', 2701, 2750, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(56, 6, NULL, '50', 2751, 2800, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(57, 6, NULL, '50', 2801, 2850, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(58, 6, NULL, '50', 2851, 2900, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(59, 6, NULL, '50', 2901, 2950, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(60, 6, NULL, '50', 2951, 3000, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(61, 7, NULL, '50', 3001, 3050, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(62, 7, NULL, '50', 3051, 3100, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(63, 7, NULL, '50', 3101, 3150, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(64, 7, NULL, '50', 3151, 3200, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(65, 7, NULL, '50', 3201, 3250, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(66, 7, NULL, '50', 3251, 3300, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(67, 7, NULL, '50', 3301, 3350, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(68, 7, NULL, '50', 3351, 3400, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(69, 7, NULL, '50', 3401, 3450, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(70, 7, NULL, '50', 3451, 3500, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(71, 8, NULL, '50', 3501, 3550, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(72, 8, NULL, '50', 3551, 3600, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(73, 8, NULL, '50', 3601, 3650, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(74, 8, NULL, '50', 3651, 3700, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(75, 8, NULL, '50', 3701, 3750, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(76, 8, NULL, '50', 3751, 3800, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(77, 8, NULL, '50', 3801, 3850, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(78, 8, NULL, '50', 3851, 3900, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(79, 8, NULL, '50', 3901, 3950, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(80, 8, NULL, '50', 3951, 4000, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(81, 9, NULL, '50', 4001, 4050, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(82, 9, NULL, '50', 4051, 4100, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(83, 9, NULL, '50', 4101, 4150, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(84, 9, NULL, '50', 4151, 4200, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(85, 9, NULL, '50', 4201, 4250, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(86, 9, NULL, '50', 4251, 4300, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(87, 9, NULL, '50', 4301, 4350, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(88, 9, NULL, '50', 4351, 4400, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(89, 9, NULL, '50', 4401, 4450, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(90, 9, NULL, '50', 4451, 4500, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(91, 10, NULL, '50', 4501, 4550, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(92, 10, NULL, '50', 4551, 4600, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(93, 10, NULL, '50', 4601, 4650, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(94, 10, NULL, '50', 4651, 4700, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(95, 10, NULL, '50', 4701, 4750, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(96, 10, NULL, '50', 4751, 4800, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(97, 10, NULL, '50', 4801, 4850, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(98, 10, NULL, '50', 4851, 4900, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(99, 10, NULL, '50', 4901, 4950, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(100, 10, NULL, '50', 4951, 5000, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(101, 11, NULL, '50', 5001, 5050, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(102, 11, NULL, '50', 5051, 5100, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(103, 11, NULL, '50', 5101, 5150, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(104, 11, NULL, '50', 5151, 5200, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(105, 11, NULL, '50', 5201, 5250, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(106, 11, NULL, '50', 5251, 5300, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(107, 11, NULL, '50', 5301, 5350, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(108, 11, NULL, '50', 5351, 5400, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(109, 11, NULL, '50', 5401, 5450, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(110, 11, NULL, '50', 5451, 5500, 5, 20, 50, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos`
--

CREATE TABLE `tipos` (
  `id_tipo` int(10) UNSIGNED NOT NULL,
  `nombre_tipo` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tipos`
--

INSERT INTO `tipos` (`id_tipo`, `nombre_tipo`, `created_at`, `updated_at`) VALUES
(1, 'Declaración de Libro', NULL, NULL),
(2, 'Declaración de Guías Extemporáneas', NULL, NULL),
(3, 'Contribuyente', NULL, NULL),
(4, 'Administrativo', NULL, NULL),
(5, 'Regular', NULL, NULL),
(6, 'Reserva', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `total_guias_reservas`
--

CREATE TABLE `total_guias_reservas` (
  `correlativo` int(10) UNSIGNED NOT NULL,
  `total` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ucds`
--

CREATE TABLE `ucds` (
  `id` int(10) UNSIGNED NOT NULL,
  `valor` double(8,2) NOT NULL,
  `moneda` varchar(255) NOT NULL,
  `fecha` date NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `ucds`
--

INSERT INTO `ucds` (`id`, `valor`, `moneda`, `fecha`, `created_at`, `updated_at`) VALUES
(1, 39.09, 'Euro', '2024-06-19', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `type` int(10) UNSIGNED NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `type`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'administrador@gmail.com', NULL, '$2y$12$MmWJKmrJdJfX5eyRDuNhI.eRkQkKPJ4R.iR5Kf63ZBbcmz5lNEOiu', 4, NULL, NULL, NULL),
(2, 'TECNOCOMODITY, C.A.', 'tecnocomodity@gmail.com', NULL, '$2y$12$cnpFuj2zFLx4ZubGox4c8edxBzKTW2tXMYbd/JmHWQomBN3QmRVg6', 3, NULL, '2024-06-19 18:07:42', '2024-06-19 18:07:42'),
(3, 'UNIDAD PRODUCTIVA FAMILIAR PIEDRA AZUL', 'piedrazul@gmail.com', NULL, '$2y$12$ZrnlHW2fwPReT8RtkF.mpex7NLKu1xwKbhZcGejytl32xZfKAyVQS', 3, NULL, '2024-06-19 18:11:54', '2024-06-19 18:11:54'),
(4, 'UNIDAD PRODUCTIVA FAMILIAR MINEROS DEL SUR', 'minerosdelsur@gmail.com', NULL, '$2y$12$fbe7LsY82.aSniE7leIC8uVIcWmZOYHBrH2DUncFhNfMbfX2CzdHi', 3, NULL, '2024-06-19 18:13:55', '2024-06-19 18:13:55'),
(5, 'Aramica, S.A.', 'aramica@gmail.com', NULL, '$2y$12$OWfq0Iu6P6TsxU7pYyfPNu/9l.1MuwlnKYj3CG10.KV3OcLi.0nVO', 3, NULL, '2024-06-19 18:17:28', '2024-06-19 18:17:28');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `bitacoras`
--
ALTER TABLE `bitacoras`
  ADD PRIMARY KEY (`correlativo`),
  ADD KEY `bitacoras_id_user_foreign` (`id_user`),
  ADD KEY `bitacoras_modulo_foreign` (`modulo`);

--
-- Indices de la tabla `canteras`
--
ALTER TABLE `canteras`
  ADD PRIMARY KEY (`id_cantera`),
  ADD KEY `canteras_id_sujeto_foreign` (`id_sujeto`);

--
-- Indices de la tabla `cierre_libros`
--
ALTER TABLE `cierre_libros`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cierre_libros_id_user_foreign` (`id_user`);

--
-- Indices de la tabla `clasificacions`
--
ALTER TABLE `clasificacions`
  ADD PRIMARY KEY (`id_clasificacion`);

--
-- Indices de la tabla `control_guias`
--
ALTER TABLE `control_guias`
  ADD PRIMARY KEY (`correlativo`),
  ADD UNIQUE KEY `control_guias_nro_guia_unique` (`nro_guia`),
  ADD KEY `control_guias_id_talonario_foreign` (`id_talonario`),
  ADD KEY `control_guias_id_sujeto_foreign` (`id_sujeto`),
  ADD KEY `control_guias_id_cantera_foreign` (`id_cantera`),
  ADD KEY `control_guias_id_libro_foreign` (`id_libro`),
  ADD KEY `control_guias_id_declaracion_foreign` (`id_declaracion`),
  ADD KEY `control_guias_id_mineral_foreign` (`id_mineral`),
  ADD KEY `control_guias_estado_foreign` (`estado`),
  ADD KEY `control_guias_declaracion_foreign` (`declaracion`);

--
-- Indices de la tabla `declaracions`
--
ALTER TABLE `declaracions`
  ADD PRIMARY KEY (`id_declaracion`),
  ADD KEY `declaracions_id_sujeto_foreign` (`id_sujeto`),
  ADD KEY `declaracions_id_libro_foreign` (`id_libro`),
  ADD KEY `declaracions_id_ucd_foreign` (`id_ucd`),
  ADD KEY `declaracions_estado_foreign` (`estado`),
  ADD KEY `declaracions_tipo_foreign` (`tipo`);

--
-- Indices de la tabla `detalle_reservas`
--
ALTER TABLE `detalle_reservas`
  ADD PRIMARY KEY (`correlativo`),
  ADD KEY `detalle_reservas_id_reserva_foreign` (`id_reserva`);

--
-- Indices de la tabla `detalle_solicituds`
--
ALTER TABLE `detalle_solicituds`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `detalle_solicituds_id_solicitud_foreign` (`id_solicitud`);

--
-- Indices de la tabla `detalle_talonarios`
--
ALTER TABLE `detalle_talonarios`
  ADD PRIMARY KEY (`correlativo`),
  ADD KEY `detalle_talonarios_id_talonario_foreign` (`id_talonario`),
  ADD KEY `detalle_talonarios_id_cantera_foreign` (`id_cantera`),
  ADD KEY `detalle_talonarios_id_sujeto_foreign` (`id_sujeto`),
  ADD KEY `detalle_talonarios_clase_foreign` (`clase`),
  ADD KEY `detalle_talonarios_id_solicitud_reserva_foreign` (`id_solicitud_reserva`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `fechas`
--
ALTER TABLE `fechas`
  ADD PRIMARY KEY (`id_fecha`);

--
-- Indices de la tabla `libros`
--
ALTER TABLE `libros`
  ADD PRIMARY KEY (`id_libro`),
  ADD KEY `libros_id_sujeto_foreign` (`id_sujeto`),
  ADD KEY `libros_estado_foreign` (`estado`);

--
-- Indices de la tabla `limite_guias`
--
ALTER TABLE `limite_guias`
  ADD PRIMARY KEY (`cod`),
  ADD KEY `limite_guias_id_sujeto_foreign` (`id_sujeto`),
  ADD KEY `limite_guias_id_cantera_foreign` (`id_cantera`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `minerals`
--
ALTER TABLE `minerals`
  ADD PRIMARY KEY (`id_mineral`);

--
-- Indices de la tabla `nro_controls`
--
ALTER TABLE `nro_controls`
  ADD PRIMARY KEY (`cod`),
  ADD UNIQUE KEY `nro_controls_nro_guia_unique` (`nro_guia`),
  ADD KEY `nro_controls_id_solicitud_foreign` (`id_solicitud`);

--
-- Indices de la tabla `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indices de la tabla `produccions`
--
ALTER TABLE `produccions`
  ADD PRIMARY KEY (`id_produccion`),
  ADD KEY `produccions_id_cantera_foreign` (`id_cantera`),
  ADD KEY `produccions_id_mineral_foreign` (`id_mineral`);

--
-- Indices de la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD PRIMARY KEY (`id_reserva`),
  ADD KEY `reservas_id_user_foreign` (`id_user`);

--
-- Indices de la tabla `solicituds`
--
ALTER TABLE `solicituds`
  ADD PRIMARY KEY (`id_solicitud`),
  ADD KEY `solicituds_id_sujeto_foreign` (`id_sujeto`),
  ADD KEY `solicituds_id_cantera_foreign` (`id_cantera`),
  ADD KEY `solicituds_estado_foreign` (`estado`);

--
-- Indices de la tabla `solicitud_reservas`
--
ALTER TABLE `solicitud_reservas`
  ADD PRIMARY KEY (`id_solicitud_reserva`),
  ADD KEY `solicitud_reservas_id_sujeto_foreign` (`id_sujeto`),
  ADD KEY `solicitud_reservas_id_cantera_foreign` (`id_cantera`),
  ADD KEY `solicitud_reservas_estado_foreign` (`estado`);

--
-- Indices de la tabla `sujeto_pasivos`
--
ALTER TABLE `sujeto_pasivos`
  ADD PRIMARY KEY (`id_sujeto`),
  ADD UNIQUE KEY `sujeto_pasivos_rif_nro_unique` (`rif_nro`),
  ADD KEY `sujeto_pasivos_id_user_foreign` (`id_user`);

--
-- Indices de la tabla `talonarios`
--
ALTER TABLE `talonarios`
  ADD PRIMARY KEY (`id_talonario`),
  ADD KEY `talonarios_id_solicitud_foreign` (`id_solicitud`),
  ADD KEY `talonarios_id_reserva_foreign` (`id_reserva`),
  ADD KEY `talonarios_clase_foreign` (`clase`),
  ADD KEY `talonarios_estado_foreign` (`estado`);

--
-- Indices de la tabla `tipos`
--
ALTER TABLE `tipos`
  ADD PRIMARY KEY (`id_tipo`);

--
-- Indices de la tabla `total_guias_reservas`
--
ALTER TABLE `total_guias_reservas`
  ADD PRIMARY KEY (`correlativo`);

--
-- Indices de la tabla `ucds`
--
ALTER TABLE `ucds`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_type_foreign` (`type`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `bitacoras`
--
ALTER TABLE `bitacoras`
  MODIFY `correlativo` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `canteras`
--
ALTER TABLE `canteras`
  MODIFY `id_cantera` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `cierre_libros`
--
ALTER TABLE `cierre_libros`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `clasificacions`
--
ALTER TABLE `clasificacions`
  MODIFY `id_clasificacion` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `control_guias`
--
ALTER TABLE `control_guias`
  MODIFY `correlativo` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `declaracions`
--
ALTER TABLE `declaracions`
  MODIFY `id_declaracion` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_reservas`
--
ALTER TABLE `detalle_reservas`
  MODIFY `correlativo` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_solicituds`
--
ALTER TABLE `detalle_solicituds`
  MODIFY `id_detalle` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `detalle_talonarios`
--
ALTER TABLE `detalle_talonarios`
  MODIFY `correlativo` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `fechas`
--
ALTER TABLE `fechas`
  MODIFY `id_fecha` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `libros`
--
ALTER TABLE `libros`
  MODIFY `id_libro` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `limite_guias`
--
ALTER TABLE `limite_guias`
  MODIFY `cod` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `minerals`
--
ALTER TABLE `minerals`
  MODIFY `id_mineral` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `nro_controls`
--
ALTER TABLE `nro_controls`
  MODIFY `cod` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `produccions`
--
ALTER TABLE `produccions`
  MODIFY `id_produccion` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `reservas`
--
ALTER TABLE `reservas`
  MODIFY `id_reserva` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `solicituds`
--
ALTER TABLE `solicituds`
  MODIFY `id_solicitud` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `solicitud_reservas`
--
ALTER TABLE `solicitud_reservas`
  MODIFY `id_solicitud_reserva` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `sujeto_pasivos`
--
ALTER TABLE `sujeto_pasivos`
  MODIFY `id_sujeto` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `talonarios`
--
ALTER TABLE `talonarios`
  MODIFY `id_talonario` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT de la tabla `tipos`
--
ALTER TABLE `tipos`
  MODIFY `id_tipo` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `total_guias_reservas`
--
ALTER TABLE `total_guias_reservas`
  MODIFY `correlativo` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ucds`
--
ALTER TABLE `ucds`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `bitacoras`
--
ALTER TABLE `bitacoras`
  ADD CONSTRAINT `bitacoras_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bitacoras_modulo_foreign` FOREIGN KEY (`modulo`) REFERENCES `clasificacions` (`id_clasificacion`) ON DELETE CASCADE;

--
-- Filtros para la tabla `canteras`
--
ALTER TABLE `canteras`
  ADD CONSTRAINT `canteras_id_sujeto_foreign` FOREIGN KEY (`id_sujeto`) REFERENCES `sujeto_pasivos` (`id_sujeto`) ON DELETE CASCADE;

--
-- Filtros para la tabla `cierre_libros`
--
ALTER TABLE `cierre_libros`
  ADD CONSTRAINT `cierre_libros_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `control_guias`
--
ALTER TABLE `control_guias`
  ADD CONSTRAINT `control_guias_declaracion_foreign` FOREIGN KEY (`declaracion`) REFERENCES `clasificacions` (`id_clasificacion`) ON DELETE CASCADE,
  ADD CONSTRAINT `control_guias_estado_foreign` FOREIGN KEY (`estado`) REFERENCES `clasificacions` (`id_clasificacion`) ON DELETE CASCADE,
  ADD CONSTRAINT `control_guias_id_cantera_foreign` FOREIGN KEY (`id_cantera`) REFERENCES `canteras` (`id_cantera`) ON DELETE CASCADE,
  ADD CONSTRAINT `control_guias_id_declaracion_foreign` FOREIGN KEY (`id_declaracion`) REFERENCES `declaracions` (`id_declaracion`) ON DELETE CASCADE,
  ADD CONSTRAINT `control_guias_id_libro_foreign` FOREIGN KEY (`id_libro`) REFERENCES `libros` (`id_libro`) ON DELETE CASCADE,
  ADD CONSTRAINT `control_guias_id_mineral_foreign` FOREIGN KEY (`id_mineral`) REFERENCES `minerals` (`id_mineral`) ON DELETE CASCADE,
  ADD CONSTRAINT `control_guias_id_sujeto_foreign` FOREIGN KEY (`id_sujeto`) REFERENCES `sujeto_pasivos` (`id_sujeto`) ON DELETE CASCADE,
  ADD CONSTRAINT `control_guias_id_talonario_foreign` FOREIGN KEY (`id_talonario`) REFERENCES `talonarios` (`id_talonario`) ON DELETE CASCADE;

--
-- Filtros para la tabla `declaracions`
--
ALTER TABLE `declaracions`
  ADD CONSTRAINT `declaracions_estado_foreign` FOREIGN KEY (`estado`) REFERENCES `clasificacions` (`id_clasificacion`) ON DELETE CASCADE,
  ADD CONSTRAINT `declaracions_id_libro_foreign` FOREIGN KEY (`id_libro`) REFERENCES `libros` (`id_libro`) ON DELETE CASCADE,
  ADD CONSTRAINT `declaracions_id_sujeto_foreign` FOREIGN KEY (`id_sujeto`) REFERENCES `sujeto_pasivos` (`id_sujeto`) ON DELETE CASCADE,
  ADD CONSTRAINT `declaracions_id_ucd_foreign` FOREIGN KEY (`id_ucd`) REFERENCES `ucds` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `declaracions_tipo_foreign` FOREIGN KEY (`tipo`) REFERENCES `tipos` (`id_tipo`) ON DELETE CASCADE;

--
-- Filtros para la tabla `detalle_reservas`
--
ALTER TABLE `detalle_reservas`
  ADD CONSTRAINT `detalle_reservas_id_reserva_foreign` FOREIGN KEY (`id_reserva`) REFERENCES `reservas` (`id_reserva`) ON DELETE CASCADE;

--
-- Filtros para la tabla `detalle_solicituds`
--
ALTER TABLE `detalle_solicituds`
  ADD CONSTRAINT `detalle_solicituds_id_solicitud_foreign` FOREIGN KEY (`id_solicitud`) REFERENCES `solicituds` (`id_solicitud`) ON DELETE CASCADE;

--
-- Filtros para la tabla `detalle_talonarios`
--
ALTER TABLE `detalle_talonarios`
  ADD CONSTRAINT `detalle_talonarios_clase_foreign` FOREIGN KEY (`clase`) REFERENCES `tipos` (`id_tipo`) ON DELETE CASCADE,
  ADD CONSTRAINT `detalle_talonarios_id_cantera_foreign` FOREIGN KEY (`id_cantera`) REFERENCES `canteras` (`id_cantera`) ON DELETE CASCADE,
  ADD CONSTRAINT `detalle_talonarios_id_solicitud_reserva_foreign` FOREIGN KEY (`id_solicitud_reserva`) REFERENCES `solicitud_reservas` (`id_solicitud_reserva`) ON DELETE CASCADE,
  ADD CONSTRAINT `detalle_talonarios_id_sujeto_foreign` FOREIGN KEY (`id_sujeto`) REFERENCES `sujeto_pasivos` (`id_sujeto`) ON DELETE CASCADE,
  ADD CONSTRAINT `detalle_talonarios_id_talonario_foreign` FOREIGN KEY (`id_talonario`) REFERENCES `talonarios` (`id_talonario`) ON DELETE CASCADE;

--
-- Filtros para la tabla `libros`
--
ALTER TABLE `libros`
  ADD CONSTRAINT `libros_estado_foreign` FOREIGN KEY (`estado`) REFERENCES `clasificacions` (`id_clasificacion`) ON DELETE CASCADE,
  ADD CONSTRAINT `libros_id_sujeto_foreign` FOREIGN KEY (`id_sujeto`) REFERENCES `sujeto_pasivos` (`id_sujeto`) ON DELETE CASCADE;

--
-- Filtros para la tabla `limite_guias`
--
ALTER TABLE `limite_guias`
  ADD CONSTRAINT `limite_guias_id_cantera_foreign` FOREIGN KEY (`id_cantera`) REFERENCES `canteras` (`id_cantera`) ON DELETE CASCADE,
  ADD CONSTRAINT `limite_guias_id_sujeto_foreign` FOREIGN KEY (`id_sujeto`) REFERENCES `sujeto_pasivos` (`id_sujeto`) ON DELETE CASCADE;

--
-- Filtros para la tabla `nro_controls`
--
ALTER TABLE `nro_controls`
  ADD CONSTRAINT `nro_controls_id_solicitud_foreign` FOREIGN KEY (`id_solicitud`) REFERENCES `solicituds` (`id_solicitud`) ON DELETE CASCADE;

--
-- Filtros para la tabla `produccions`
--
ALTER TABLE `produccions`
  ADD CONSTRAINT `produccions_id_cantera_foreign` FOREIGN KEY (`id_cantera`) REFERENCES `canteras` (`id_cantera`) ON DELETE CASCADE,
  ADD CONSTRAINT `produccions_id_mineral_foreign` FOREIGN KEY (`id_mineral`) REFERENCES `minerals` (`id_mineral`) ON DELETE CASCADE;

--
-- Filtros para la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD CONSTRAINT `reservas_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `solicituds`
--
ALTER TABLE `solicituds`
  ADD CONSTRAINT `solicituds_estado_foreign` FOREIGN KEY (`estado`) REFERENCES `clasificacions` (`id_clasificacion`) ON DELETE CASCADE,
  ADD CONSTRAINT `solicituds_id_cantera_foreign` FOREIGN KEY (`id_cantera`) REFERENCES `canteras` (`id_cantera`) ON DELETE CASCADE,
  ADD CONSTRAINT `solicituds_id_sujeto_foreign` FOREIGN KEY (`id_sujeto`) REFERENCES `sujeto_pasivos` (`id_sujeto`) ON DELETE CASCADE;

--
-- Filtros para la tabla `solicitud_reservas`
--
ALTER TABLE `solicitud_reservas`
  ADD CONSTRAINT `solicitud_reservas_estado_foreign` FOREIGN KEY (`estado`) REFERENCES `clasificacions` (`id_clasificacion`) ON DELETE CASCADE,
  ADD CONSTRAINT `solicitud_reservas_id_cantera_foreign` FOREIGN KEY (`id_cantera`) REFERENCES `canteras` (`id_cantera`) ON DELETE CASCADE,
  ADD CONSTRAINT `solicitud_reservas_id_sujeto_foreign` FOREIGN KEY (`id_sujeto`) REFERENCES `sujeto_pasivos` (`id_sujeto`) ON DELETE CASCADE;

--
-- Filtros para la tabla `sujeto_pasivos`
--
ALTER TABLE `sujeto_pasivos`
  ADD CONSTRAINT `sujeto_pasivos_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `talonarios`
--
ALTER TABLE `talonarios`
  ADD CONSTRAINT `talonarios_clase_foreign` FOREIGN KEY (`clase`) REFERENCES `tipos` (`id_tipo`) ON DELETE CASCADE,
  ADD CONSTRAINT `talonarios_estado_foreign` FOREIGN KEY (`estado`) REFERENCES `clasificacions` (`id_clasificacion`) ON DELETE CASCADE,
  ADD CONSTRAINT `talonarios_id_reserva_foreign` FOREIGN KEY (`id_reserva`) REFERENCES `reservas` (`id_reserva`) ON DELETE CASCADE,
  ADD CONSTRAINT `talonarios_id_solicitud_foreign` FOREIGN KEY (`id_solicitud`) REFERENCES `solicituds` (`id_solicitud`) ON DELETE CASCADE;

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_type_foreign` FOREIGN KEY (`type`) REFERENCES `tipos` (`id_tipo`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
