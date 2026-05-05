-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-05-2026 a las 16:42:44
-- Versión del servidor: 10.4.18-MariaDB
-- Versión de PHP: 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ipunto`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `idcategoria` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `condicion` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`idcategoria`, `nombre`, `descripcion`, `condicion`) VALUES
(1, 'Política', NULL, 1),
(2, 'Economía', NULL, 1),
(3, 'Salud', NULL, 1),
(4, 'Justicia', NULL, 1),
(5, 'Educación', NULL, 1),
(6, 'Sociedad', NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `noticia`
--

CREATE TABLE `noticia` (
  `idnoticia` int(11) NOT NULL,
  `idusuario` int(11) DEFAULT NULL,
  `idcategoria` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `resumen` varchar(500) DEFAULT NULL,
  `cuerpo` longtext NOT NULL,
  `imagen` varchar(100) DEFAULT NULL,
  `autor` varchar(100) DEFAULT NULL,
  `fecha_publicacion` datetime DEFAULT current_timestamp(),
  `calificacion` enum('Noticias','Opinion') DEFAULT NULL,
  `explicacion_calificacion` varchar(255) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `noticia`
--

INSERT INTO `noticia` (`idnoticia`, `idusuario`, `idcategoria`, `titulo`, `resumen`, `cuerpo`, `imagen`, `autor`, `fecha_publicacion`, `calificacion`, `explicacion_calificacion`, `estado`) VALUES
(6, 1, 1, 'Javier Milei y sus medidas, EN VIVO: Manuel Adorni dijo que pagó por sus viajes familiares, pero la', 'El jefe de Gabinete dio una conferencia de prensa tras la reapertura de la sala de periodistas de Casa Rosada.\r\nCuando le preguntaron por las denuncias en su contra, volvió a esgrimir los mismos concep', '<span style=\"color: rgb(0, 0, 0); font-family: ClarinvarVF; font-size: 23px; letter-spacing: -0.12px;\">El Gobierno de&nbsp;</span><strong style=\"font-family: ClarinvarVF; font-variation-settings: &quot;wght&quot; 700, &quot;opsz&quot; 66; color: rgb(0, 0, 0); font-size: 23px; letter-spacing: -0.12px;\">Javier Milei</strong><span style=\"color: rgb(0, 0, 0); font-family: ClarinvarVF; font-size: 23px; letter-spacing: -0.12px;\">&nbsp;reabrió este lunes la&nbsp;</span><strong style=\"font-family: ClarinvarVF; font-variation-settings: &quot;wght&quot; 700, &quot;opsz&quot; 66; color: rgb(0, 0, 0); font-size: 23px; letter-spacing: -0.12px;\">sala de periodistas de la Casa Rosada</strong><span style=\"color: rgb(0, 0, 0); font-family: ClarinvarVF; font-size: 23px; letter-spacing: -0.12px;\">, que fue cerrada a fines de abril en un hecho sin antecedentes en democracia. La reapertura se dio con nuevas restricciones para la circulación de los acreditados. El jefe de Gabinete,&nbsp;</span><strong style=\"font-family: ClarinvarVF; font-variation-settings: &quot;wght&quot; 700, &quot;opsz&quot; 66; color: rgb(0, 0, 0); font-size: 23px; letter-spacing: -0.12px;\">Manuel Adorni dio una conferencia de prensa</strong><span style=\"color: rgb(0, 0, 0); font-family: ClarinvarVF; font-size: 23px; letter-spacing: -0.12px;\">, en la que sostuvo que él pagó los viajes que hizo con su familia, pero&nbsp;</span><strong style=\"font-family: ClarinvarVF; font-variation-settings: &quot;wght&quot; 700, &quot;opsz&quot; 66; color: rgb(0, 0, 0); font-size: 23px; letter-spacing: -0.12px;\">evitó dar precisiones cuando le preguntaron por las denuncias sobre su patrimonio</strong><span style=\"color: rgb(0, 0, 0); font-family: ClarinvarVF; font-size: 23px; letter-spacing: -0.12px;\">. Al igual que en el Congreso, dijo que aclarará todo en la Justicia.</span>', '1777920501.avif', 'Admin', '2026-05-04 15:48:21', 'Noticias', '', 1),
(7, 1, 1, 'Patentes y deuda: el Gobierno incumplió plazos en el Congreso y se apoya en prórrogas y señales inte', 'No llegó a aprobar a tiempo el tratado de patentes ni un acuerdo con holdouts; sin embargo, Estados Unidos sacó a la Argentina de su lista negra en materia de propiedad intelectual y los acreedores ex', '<p class=\"com-paragraph  --capital --s\" style=\"border: 0px; margin-right: 0px; margin-bottom: 2rem; margin-left: 0px; padding: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: 1.875rem; font-family: Georgia, &quot;serif&quot;; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; font-language-override: inherit; font-size: 1.1875rem; vertical-align: baseline; color: rgb(51, 51, 51);\">in capacidad para ordenar la agenda legislativa en medio de las&nbsp;<a href=\"https://www.lanacion.com.ar/politica/un-contratista-declaro-que-manuel-adorni-le-pago-en-efectivo-us-245000-por-remodelar-la-casa-del-nid04052026/\" target=\"_self\" title=\"https://www.lanacion.com.ar/politica/un-contratista-declaro-que-manuel-adorni-le-pago-en-efectivo-us-245000-por-remodelar-la-casa-del-nid04052026/\" class=\"com-link break-word\" data-mrf-recirculation=\"n_link_parrafo\" data-mrf-link=\"https://www.lanacion.com.ar/politica/un-contratista-declaro-que-manuel-adorni-le-pago-en-efectivo-us-245000-por-remodelar-la-casa-del-nid04052026/\" cmp-ltrk=\"n_link_parrafo\" cmp-ltrk-idx=\"0\" mrfobservableid=\"6705f94a-3418-4362-97e9-5b88f0f1090e\" style=\"border: 0px; margin: 0px; padding: 0px; font-style: inherit; font-variant: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; font-language-override: inherit; vertical-align: baseline; outline: none; color: rgb(2, 80, 201); text-decoration: none; word-break: break-word;\">turbulencias internas</a>, el Gobierno dejó vencer dos plazos clave que requerían aval del Congreso: la&nbsp;<span style=\"border: 0px; margin: 0px; padding: 0px; font-style: inherit; font-variant: inherit; font-weight: 700; font-stretch: inherit; line-height: inherit; font-family: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; font-language-override: inherit; vertical-align: baseline;\">adhesión al Tratado de Cooperación en materia de Patentes (PCT)&nbsp;</span>y la&nbsp;<span style=\"border: 0px; margin: 0px; padding: 0px; font-style: inherit; font-variant: inherit; font-weight: 700; font-stretch: inherit; line-height: inherit; font-family: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; font-language-override: inherit; vertical-align: baseline;\">ratificación de un acuerdo con&nbsp;</span><em style=\"border: 0px; margin: 0px; padding: 0px; font-variant: inherit; font-weight: inherit; font-stretch: inherit; line-height: inherit; font-family: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; font-language-override: inherit; vertical-align: baseline;\"><span style=\"border: 0px; margin: 0px; padding: 0px; font-style: inherit; font-variant: inherit; font-weight: 700; font-stretch: inherit; line-height: inherit; font-family: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; font-language-override: inherit; vertical-align: baseline;\">holdouts</span></em><span style=\"border: 0px; margin: 0px; padding: 0px; font-style: inherit; font-variant: inherit; font-weight: 700; font-stretch: inherit; line-height: inherit; font-family: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; font-language-override: inherit; vertical-align: baseline;\">&nbsp;o “fondos buitre”</span>. Ambos debían aprobarse antes del 30 de abril.</p><p class=\"com-paragraph   --s\" style=\"border: 0px; margin-right: 0px; margin-bottom: 2rem; margin-left: 0px; padding: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: 1.875rem; font-family: Georgia, &quot;serif&quot;; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; font-language-override: inherit; font-size: 1.1875rem; vertical-align: baseline; color: rgb(51, 51, 51);\">Pero las dificultades legislativas del oficialismo en el plano doméstico fueron contrarrestadas por la paciencia internacional. Estados Unidos retiró la semana pasada a la Argentina de su&nbsp;<em style=\"border: 0px; margin: 0px; padding: 0px; font-variant: inherit; font-weight: inherit; font-stretch: inherit; line-height: inherit; font-family: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; font-language-override: inherit; vertical-align: baseline;\">“Priority Watch List”</em>&nbsp;-la lista de países cuestionados por el respeto a la propiedad intelectual- tras más de una década, y el Gobierno obtuvo una prórroga hasta el 31 de mayo para cerrar la negociación con los acreedores.</p>', '1777922779.avif', 'Admin', '2026-05-04 16:26:18', 'Noticias', '', 1),
(8, 1, 1, 'Los números de Manuel Adorni bajo la lupa: gastos y deudas por más de US$800.000, ingresos con tope', 'El jefe de Gabinete comenzó a acumular compromisos tres meses después de asumir como vocero presidencial; los interrogantes que se abren en la investigación judicial', '<p class=\"com-paragraph  --capital --s\" style=\"border: 0px; margin-right: 0px; margin-bottom: 2rem; margin-left: 0px; padding: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: 1.875rem; font-family: Georgia, &quot;serif&quot;; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; font-language-override: inherit; font-size: 1.1875rem; vertical-align: baseline; color: rgb(51, 51, 51);\">esde que llegó a la función pública,&nbsp;<span style=\"border: 0px; margin: 0px; padding: 0px; font-style: inherit; font-variant: inherit; font-weight: 700; font-stretch: inherit; line-height: inherit; font-family: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; font-language-override: inherit; vertical-align: baseline;\">Manuel Adorni acumuló compromisos que ya superan los US$800.000&nbsp;</span>mientras que su salario bruto permaneció congelado en $3,5 millones hasta enero de 2026, cuando un decreto firmado por el presidente Javier Milei lo elevó a $7,1 millones, poco menos de US$ 5000 por mes.&nbsp;<span style=\"border: 0px; margin: 0px; padding: 0px; font-style: inherit; font-variant: inherit; font-weight: 700; font-stretch: inherit; line-height: inherit; font-family: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; font-language-override: inherit; vertical-align: baseline;\">Cómo afrontó y afrontará esas deudas y esos pagos</span>, además de&nbsp;<span style=\"border: 0px; margin: 0px; padding: 0px; font-style: inherit; font-variant: inherit; font-weight: 700; font-stretch: inherit; line-height: inherit; font-family: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; font-language-override: inherit; vertical-align: baseline;\">cuál es origen de sus fondos</span>, son los grandes interrogantes de la investigación judicial.</p><p class=\"com-paragraph   --s\" style=\"border: 0px; margin-right: 0px; margin-bottom: 2rem; margin-left: 0px; padding: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: 1.875rem; font-family: Georgia, &quot;serif&quot;; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; font-language-override: inherit; font-size: 1.1875rem; vertical-align: baseline; color: rgb(51, 51, 51);\">Los compromisos se acumulan en el haber del funcionario.&nbsp;<span style=\"border: 0px; margin: 0px; padding: 0px; font-style: inherit; font-variant: inherit; font-weight: 700; font-stretch: inherit; line-height: inherit; font-family: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; font-language-override: inherit; vertical-align: baseline;\">Pagos ya realizados</span>:&nbsp;<span style=\"border: 0px; margin: 0px; padding: 0px; font-style: inherit; font-variant: inherit; font-weight: 700; font-stretch: inherit; line-height: inherit; font-family: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; font-language-override: inherit; vertical-align: baseline;\">US$245.000</span>&nbsp;en refacciones a un contratista,&nbsp;<span style=\"border: 0px; margin: 0px; padding: 0px; font-style: inherit; font-variant: inherit; font-weight: 700; font-stretch: inherit; line-height: inherit; font-family: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; font-language-override: inherit; vertical-align: baseline;\">US$185.000</span>&nbsp;en operaciones inmobiliarias (US$120.000 por la casa de Indio Cua,&nbsp;<span style=\"border: 0px; margin: 0px; padding: 0px; font-style: inherit; font-variant: inherit; font-weight: 700; font-stretch: inherit; line-height: inherit; font-family: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; font-language-override: inherit; vertical-align: baseline;\">US$60.000</span>&nbsp;entre la seña de Caballito y la cancelación parcial de la primera hipoteca, más&nbsp;<span style=\"border: 0px; margin: 0px; padding: 0px; font-style: inherit; font-variant: inherit; font-weight: 700; font-stretch: inherit; line-height: inherit; font-family: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; font-language-override: inherit; vertical-align: baseline;\">US$5.000&nbsp;</span>de ingreso al country),&nbsp;<span style=\"border: 0px; margin: 0px; padding: 0px; font-style: inherit; font-variant: inherit; font-weight: 700; font-stretch: inherit; line-height: inherit; font-family: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; font-language-override: inherit; vertical-align: baseline;\">US$27.658</span>&nbsp;en viajes al exterior y&nbsp;<span style=\"border: 0px; margin: 0px; padding: 0px; font-style: inherit; font-variant: inherit; font-weight: 700; font-stretch: inherit; line-height: inherit; font-family: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; font-language-override: inherit; vertical-align: baseline;\">US$6000</span>&nbsp;en una escapada a Bariloche.&nbsp;<span style=\"border: 0px; margin: 0px; padding: 0px; font-style: inherit; font-variant: inherit; font-weight: 700; font-stretch: inherit; line-height: inherit; font-family: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; font-language-override: inherit; vertical-align: baseline;\">Deudas vigentes</span>:&nbsp;<span style=\"border: 0px; margin: 0px; padding: 0px; font-style: inherit; font-variant: inherit; font-weight: 700; font-stretch: inherit; line-height: inherit; font-family: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; font-language-override: inherit; vertical-align: baseline;\">US$70.000 más intereses&nbsp;</span>por la primera hipoteca,&nbsp;<span style=\"border: 0px; margin: 0px; padding: 0px; font-style: inherit; font-variant: inherit; font-weight: 700; font-stretch: inherit; line-height: inherit; font-family: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; font-language-override: inherit; vertical-align: baseline;\">US$200.000 sin intereses&nbsp;</span>por la segunda y&nbsp;<span style=\"border: 0px; margin: 0px; padding: 0px; font-style: inherit; font-variant: inherit; font-weight: 700; font-stretch: inherit; line-height: inherit; font-family: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; font-language-override: inherit; vertical-align: baseline;\">US$65.000&nbsp;</span>por un acuerdo de palabra con un desarrollador inmobiliario. Total comprometido: más de US$800.000</p>', '1777923136.avif', 'Admin', '2026-05-04 16:32:03', 'Noticias', '', 1),
(9, 1, 1, 'Un contratista declaró que Manuel Adorni le pagó en efectivo US$245.000 por remodelar la casa del co', 'Fuentes judiciales informaron que Matías Tabar percibió ese dinero por las refacciones; no hubo factura por los trabajos; se construyó una pileta y una cascada; queda en Exaltación de la Cruz', '<p class=\"com-paragraph  --capital --s\" style=\"border: 0px; margin-right: 0px; margin-bottom: 2rem; margin-left: 0px; padding: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: 1.875rem; font-family: Georgia, &quot;serif&quot;; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; font-language-override: inherit; font-size: 1.1875rem; vertical-align: baseline; color: rgb(51, 51, 51);\">l contratista&nbsp;<span style=\"border: 0px; margin: 0px; padding: 0px; font-style: inherit; font-variant: inherit; font-weight: 700; font-stretch: inherit; line-height: inherit; font-family: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; font-language-override: inherit; vertical-align: baseline;\">Matías Tabar</span>&nbsp;declaró hoy en la Justicia que el jefe de Gabinete,&nbsp;<span style=\"border: 0px; margin: 0px; padding: 0px; font-style: inherit; font-variant: inherit; font-weight: 700; font-stretch: inherit; line-height: inherit; font-family: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; font-language-override: inherit; vertical-align: baseline;\">Manuel Adorni</span>, le pagó en efectivo 245.000 dólares por remodelar<a href=\"https://www.lanacion.com.ar/politica/adorni-no-habia-declarado-ante-la-oa-la-casa-del-country-la-agrego-ahora-a-su-presentacion-un-ano-nid14042026/\" target=\"_self\" title=\"https://www.lanacion.com.ar/politica/adorni-no-habia-declarado-ante-la-oa-la-casa-del-country-la-agrego-ahora-a-su-presentacion-un-ano-nid14042026/\" class=\"com-link break-word\" data-mrf-recirculation=\"n_link_parrafo\" data-mrf-link=\"https://www.lanacion.com.ar/politica/adorni-no-habia-declarado-ante-la-oa-la-casa-del-country-la-agrego-ahora-a-su-presentacion-un-ano-nid14042026/\" cmp-ltrk=\"n_link_parrafo\" cmp-ltrk-idx=\"0\" mrfobservableid=\"2b0def37-8fc2-4e06-af01-33b9c0f4de02\" style=\"border: 0px; margin: 0px; padding: 0px; font-style: inherit; font-variant: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; font-language-override: inherit; vertical-align: baseline; outline: none; color: rgb(2, 80, 201); text-decoration: none; word-break: break-word;\">&nbsp;la casa del country Indio Cua</a>, en Exaltación de la Cruz. Así lo confirmaron a&nbsp;<span style=\"border: 0px; margin: 0px; padding: 0px; font-style: inherit; font-variant: inherit; font-weight: 700; font-stretch: inherit; line-height: inherit; font-family: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; font-language-override: inherit; vertical-align: baseline;\">LA NACION</span>&nbsp;fuentes judiciales.</p><p class=\"com-paragraph   --s\" style=\"border: 0px; margin-right: 0px; margin-bottom: 2rem; margin-left: 0px; padding: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: 1.875rem; font-family: Georgia, &quot;serif&quot;; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; font-language-override: inherit; font-size: 1.1875rem; vertical-align: baseline; color: rgb(51, 51, 51);\">Las obras consistieron en hacer pisos, paredes, una pileta y una cascada en el jardín, según precisaron las mismas fuentes.</p>', '1777923297.avif', 'Admin', '2026-05-04 16:34:57', 'Noticias', '', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idusuario` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `login` varchar(20) NOT NULL,
  `clave` varchar(255) NOT NULL,
  `tipo` enum('Administrador','Editor') NOT NULL DEFAULT 'Editor',
  `imagen` varchar(100) DEFAULT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idusuario`, `nombre`, `apellido`, `login`, `clave`, `tipo`, `imagen`, `estado`) VALUES
(1, 'Admin', 'Principal', 'admin', '$2y$10$uO2J1K4kyfDKi4GaZ0EYleeY9ApIUAl1fQLnB2GDU8Q.d9jxEyKiu', 'Administrador', NULL, 1),
(2, 'ivan', 'montano', 'ivan', '$2y$10$1da7si6Xhs1BoIfOw4ganeF5KQcveaF86nbpT0bkVbKoD35y1k7gi', 'Editor', '', 1),
(3, 'ruben', '', 'rcorrea', '$2y$10$UpSxYtoqFRiQeLj.kVdHUu591vPwRjqiKROYNT3O7vs9uigvZ7NlO', '', '', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`idcategoria`);

--
-- Indices de la tabla `noticia`
--
ALTER TABLE `noticia`
  ADD PRIMARY KEY (`idnoticia`),
  ADD KEY `idcategoria` (`idcategoria`),
  ADD KEY `fk_noticia_usuario` (`idusuario`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idusuario`),
  ADD UNIQUE KEY `login_unique` (`login`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `idcategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `noticia`
--
ALTER TABLE `noticia`
  MODIFY `idnoticia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `noticia`
--
ALTER TABLE `noticia`
  ADD CONSTRAINT `fk_noticia_categoria` FOREIGN KEY (`idcategoria`) REFERENCES `categoria` (`idcategoria`),
  ADD CONSTRAINT `fk_noticia_usuario` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
