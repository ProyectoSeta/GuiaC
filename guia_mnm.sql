-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-06-2024 a las 21:51:35
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
(1, 1, 9, '2024-06-13', 'VERIFICACIÓN DE USUARIO APROBADA, Contribuyente: ARAGUA MINAS Y CANTERAS (ARAMICA) S.A..', NULL, NULL),
(2, 1, 10, '2024-06-13', 'VERIFICACIÓN APROBADA, Cantera: Unidad Técnica de Producción El Apamate, Contribuyente: ARAGUA MINAS Y CANTERAS (ARAMICA) S.A..', NULL, NULL),
(3, 1, 7, '2024-06-13', 'SOLICITUD NRO.2 APROBADA, Talonarios: 1, Contribuyente: ARAGUA MINAS Y CANTERAS (ARAMICA) S.A.', NULL, NULL),
(4, 1, 7, '2024-06-13', 'SOLICITUD NRO.1 APROBADA, Talonarios: 1, Contribuyente: ARAGUA MINAS Y CANTERAS (ARAMICA) S.A.', NULL, NULL),
(5, 1, 7, '2024-06-13', 'SOLICITUD NRO.5 APROBADA, Talonarios: 1, Contribuyente: ARAGUA MINAS Y CANTERAS (ARAMICA) S.A.', NULL, NULL),
(6, 1, 7, '2024-06-13', 'SOLICITUD NRO.4 APROBADA, Talonarios: 1, Contribuyente: ARAGUA MINAS Y CANTERAS (ARAMICA) S.A.', NULL, NULL),
(7, 1, 7, '2024-06-13', 'SOLICITUD NRO.3 APROBADA, Talonarios: 1, Contribuyente: ARAGUA MINAS Y CANTERAS (ARAMICA) S.A.', NULL, NULL),
(8, 1, 7, '2024-06-13', 'SOLICITUD NRO.7 APROBADA, Talonarios: 2, Contribuyente: ARAGUA MINAS Y CANTERAS (ARAMICA) S.A.', NULL, NULL),
(9, 1, 24, '2024-06-13', 'EMISIÓN DE 1 TALONARIOS DE RESERVA (COD: 12-)', NULL, NULL),
(10, 1, 7, '2024-06-14', 'SOLICITUD NRO.8 APROBADA, Talonarios: 1, Contribuyente: ARAGUA MINAS Y CANTERAS (ARAMICA) S.A.', NULL, NULL),
(11, 1, 14, '2024-06-14', 'LÍMITE DE SOLICITUD DE GUÍAS ACTUALIZADO A 300 GUÍAS, CANTERA: Unidad Técnica de Producción El Apamate.', NULL, NULL),
(12, 1, 7, '2024-06-14', 'SOLICITUD NRO.9 APROBADA, Talonarios: 1, Contribuyente: ARAGUA MINAS Y CANTERAS (ARAMICA) S.A.', NULL, NULL);

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
(1, 1, 'Unidad Técnica de Producción El Apamate', 'Zamora', 'Zamora', 'Carretera Nacional Cagua – Villa de Cura, Troncal 2. Haciendita El Banco, Municipio Zamora.', 'Verificada', NULL, NULL, NULL);

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

--
-- Volcado de datos para la tabla `detalle_reservas`
--

INSERT INTO `detalle_reservas` (`correlativo`, `tipo_talonario`, `cantidad`, `id_reserva`, `created_at`, `updated_at`) VALUES
(1, '50', 1, 1, NULL, NULL);

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
(7, '50', 2, 7, NULL, NULL),
(8, '50', 1, 8, NULL, NULL),
(9, '50', 1, 9, NULL, NULL);

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
(10, 10, 1, 1, 1, 50, 'assets/qr/qrcode_T10.svg', 5, NULL, NULL, NULL),
(11, 11, 1, 1, 51, 100, 'assets/qr/qrcode_T11.svg', 5, NULL, NULL, NULL),
(12, 13, 1, 1, 151, 200, 'assets/qr/qrcode_T13.svg', 5, NULL, NULL, NULL),
(13, 14, 1, 1, 201, 250, 'assets/qr/qrcode_T14.svg', 5, NULL, NULL, NULL);

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
(1, 1, 1, 300, 300, '2024-06-13', '2024-09-13', NULL, NULL);

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
(24, 'Granzón', NULL, NULL);

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
(1, 1, 5, NULL, NULL),
(2, 1, 11, NULL, NULL);

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

--
-- Volcado de datos para la tabla `reservas`
--

INSERT INTO `reservas` (`id_reserva`, `id_user`, `fecha`, `created_at`, `updated_at`) VALUES
(1, 1, '2024-06-13 14:27:52', NULL, NULL);

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
(7, 1, 1, 500, '2024-06-13 14:25:43', 17, NULL, NULL, NULL),
(8, 1, 1, 250, '2024-06-14 09:02:09', 17, NULL, NULL, NULL),
(9, 1, 1, 250, '2024-06-14 12:49:45', 17, NULL, NULL, NULL);

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

--
-- Volcado de datos para la tabla `solicitud_reservas`
--

INSERT INTO `solicitud_reservas` (`id_solicitud_reserva`, `id_sujeto`, `id_cantera`, `cantidad_guias`, `fecha`, `total_ucd`, `estado`, `observaciones`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 10, '2024-06-13 14:49:08', 50, 4, NULL, NULL, NULL);

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
(1, 1, 'G', '200108240', 'No', 'ARAGUA MINAS Y CANTERAS (ARAMICA) S.A.', 'Urbanización Canta Rana Av. El Canal, edificio Hotel Golf. Maracay Estado Aragua', '04120505962', NULL, 'V', '0001', 'V', '0001', 'Aramica, S.A.', '04125002215', 'Verificado', NULL, '2024-06-13 17:04:26', '2024-06-13 17:04:26');

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
(10, 7, NULL, '50', 1, 50, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(11, 7, NULL, '50', 51, 100, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(12, NULL, 1, '50', 101, 150, 6, 20, 0, NULL, NULL, NULL, NULL, NULL),
(13, 8, NULL, '50', 151, 200, 5, 20, 50, NULL, NULL, NULL, NULL, NULL),
(14, 9, NULL, '50', 201, 250, 5, 20, 50, NULL, NULL, NULL, NULL, NULL);

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
  `total` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `total_guias_reservas`
--

INSERT INTO `total_guias_reservas` (`total`, `created_at`, `updated_at`) VALUES
(50, NULL, NULL);

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
(1, 39.55, 'Euro', '2024-06-13', NULL, NULL);

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
(1, 'Aramica, S.A.', 'aramica@gmail.com', NULL, '$2y$12$w1QZn25fM6WSl7FwYx2/aeUucAoXzHFy5k4Rss8069bwFlfo54OM.', 3, NULL, '2024-06-13 17:04:26', '2024-06-13 17:04:26');

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
  ADD KEY `control_guias_id_mineral_foreign` (`id_mineral`);

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
  ADD KEY `libros_id_sujeto_foreign` (`id_sujeto`);

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
  MODIFY `correlativo` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `canteras`
--
ALTER TABLE `canteras`
  MODIFY `id_cantera` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  MODIFY `correlativo` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `detalle_solicituds`
--
ALTER TABLE `detalle_solicituds`
  MODIFY `id_detalle` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `detalle_talonarios`
--
ALTER TABLE `detalle_talonarios`
  MODIFY `correlativo` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

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
  MODIFY `cod` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `minerals`
--
ALTER TABLE `minerals`
  MODIFY `id_mineral` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

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
  MODIFY `id_produccion` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `reservas`
--
ALTER TABLE `reservas`
  MODIFY `id_reserva` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `solicituds`
--
ALTER TABLE `solicituds`
  MODIFY `id_solicitud` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `solicitud_reservas`
--
ALTER TABLE `solicitud_reservas`
  MODIFY `id_solicitud_reserva` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `sujeto_pasivos`
--
ALTER TABLE `sujeto_pasivos`
  MODIFY `id_sujeto` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `talonarios`
--
ALTER TABLE `talonarios`
  MODIFY `id_talonario` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `tipos`
--
ALTER TABLE `tipos`
  MODIFY `id_tipo` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `ucds`
--
ALTER TABLE `ucds`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  ADD CONSTRAINT `control_guias_id_cantera_foreign` FOREIGN KEY (`id_cantera`) REFERENCES `canteras` (`id_cantera`) ON DELETE CASCADE,
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
