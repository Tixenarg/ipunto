-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-02-2026 a las 22:19:19
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
-- Base de datos: `blog_gemini`
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
(1, 'Política', 'Análisis y verificación de discursos políticos', 1),
(2, 'Economía', 'Datos sobre inflación, dólar y finanzas públicas', 1),
(3, 'Salud', 'Verificaciones sobre medicina y bienestar', 1),
(4, 'Justicia', 'Seguimiento de causas judiciales y leyes', 1),
(5, 'Educación', 'Información sobre el sistema educativo', 1),
(6, 'Sociedad', 'Temas de actualidad social y derechos humanos', 1);

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
  `cuerpo` text NOT NULL,
  `imagen` varchar(100) DEFAULT NULL,
  `autor` varchar(100) DEFAULT NULL,
  `fecha_publicacion` datetime DEFAULT current_timestamp(),
  `calificacion` enum('Verdadero','Casi Verdadero','Apresurado','Engañoso','Falso') DEFAULT NULL,
  `explicacion_calificacion` varchar(255) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `noticia`
--

INSERT INTO `noticia` (`idnoticia`, `idusuario`, `idcategoria`, `titulo`, `resumen`, `cuerpo`, `imagen`, `autor`, `fecha_publicacion`, `calificacion`, `explicacion_calificacion`, `estado`) VALUES
(1, NULL, 1, 'boca', 'Goleó el campeón', '<p><span style=\"color: rgb(255, 255, 255); font-family: Akzidenz, Arial, sans-serif; font-size: 20px; letter-spacing: -0.3px; background-color: rgb(34, 57, 107);\">La Reserva de Boca le ganó 3-0 a Deportivo Riestra. Anotaron Bacidalupe, Ventos y Aranda.</span></p>', '1770897653.avif', '', '2026-02-12 09:00:52', 'Verdadero', '', 1),
(2, NULL, 2, 'Caída en Liniers', 'Boca perdió 2-1 ante Vélez, puntero del Grupo A. Iker Zufiaurre marcó el gol xeneize.', '<p style=\"margin-bottom: 32px; font-family: Akzidenz, Arial, sans-serif; font-size: 20px; line-height: 32px; --_text-style---font-family: Akzidenz,Arial,sans-serif; --_text-style---font-size: 16px; --_text-style---font-weight: 400; --_text-style---letter-spacing: 0px; --_text-style---line-height: 22px; color: rgb(255, 255, 255); background-color: rgb(34, 57, 107);\">Fue derrota 2-1 de Boca en la visita a Liniers. Matías Pellegrini, a los 18 y 20 minutos del segundo tiempo, convirtió los goles de Vélez, que es líder del Grupo A del Torneo Apertura con 10 puntos. Iker Zufiaurre descontó cerca del final, antes de los tres minutos de descuento que otorgó Nazareno Arasa.</p><p style=\"margin-bottom: 32px; font-family: Akzidenz, Arial, sans-serif; font-size: 20px; line-height: 32px; --_text-style---font-family: Akzidenz,Arial,sans-serif; --_text-style---font-size: 16px; --_text-style---font-weight: 400; --_text-style---letter-spacing: 0px; --_text-style---line-height: 22px; color: rgb(255, 255, 255); background-color: rgb(34, 57, 107);\">Claudio Úbeda inició con estos 11: Agustín Marchesín; Juan Barinaga, Lautaro Di Lollo, Ayrton Costa, Lautaro Blanco; Santiago Ascacibar, Leandro Paredes (capitán), Milton Delgado, Kevin Zenón; Gonzalo Gelini y Miguel Merentiel.</p><p style=\"margin-bottom: 32px; font-family: Akzidenz, Arial, sans-serif; font-size: 20px; line-height: 32px; --_text-style---font-family: Akzidenz,Arial,sans-serif; --_text-style---font-size: 16px; --_text-style---font-weight: 400; --_text-style---letter-spacing: 0px; --_text-style---line-height: 22px; color: rgb(255, 255, 255); background-color: rgb(34, 57, 107);\">Zufiaurre ingresó al comienzo del complemento por Gelini. Luego entraron Ángel Romero (Merentiel), Tomás Aranda (Zenón) y Marcelo Weigandt (Barinaga).&nbsp;&nbsp;</p><p style=\"margin-bottom: 32px; font-family: Akzidenz, Arial, sans-serif; font-size: 20px; line-height: 32px; --_text-style---font-family: Akzidenz,Arial,sans-serif; --_text-style---font-size: 16px; --_text-style---font-weight: 400; --_text-style---letter-spacing: 0px; --_text-style---line-height: 22px; color: rgb(255, 255, 255); background-color: rgb(34, 57, 107);\">El anterior enfrentamiento en esta cancha había sido hace casi tres años. El 25 de febrero de 2023, con goles de Luca Langoni y Jorge Figal, Boca ganó 2-1. Lucas Janson, de penal, anotó para Vélez. Yael Falcón Pérez expulsó a Ezequiel Fernández a los 22 minutos de la segunda etapa.</p><p style=\"margin-bottom: 32px; font-family: Akzidenz, Arial, sans-serif; font-size: 20px; line-height: 32px; --_text-style---font-family: Akzidenz,Arial,sans-serif; --_text-style---font-size: 16px; --_text-style---font-weight: 400; --_text-style---letter-spacing: 0px; --_text-style---line-height: 22px; color: rgb(255, 255, 255); background-color: rgb(34, 57, 107);\">Boca volverá a jugar el próximo domingo. Por la fecha 5 recibirá desde las 19.30 en la Bombonera a Platense.</p>', '1770897823.2', 'TuQ', '2026-02-12 09:03:42', 'Verdadero', '', 1),
(3, NULL, 2, 'Pisó fuerte en Rosario', 'Pisó fuerte en Rosario\r\nBoca superó 3-1 como visitante a Náutico Avellaneda y cerró el fin de semana con una sonrisa en la LAF 2026.', '<p style=\"margin-bottom: 32px; font-family: Akzidenz, Arial, sans-serif; font-size: 20px; line-height: 32px; --_text-style---font-family: Akzidenz,Arial,sans-serif; --_text-style---font-size: 16px; --_text-style---font-weight: 400; --_text-style---letter-spacing: 0px; --_text-style---line-height: 22px; color: rgb(255, 255, 255); background-color: rgb(34, 57, 107);\">Luego de la derrota ante Sonder, el equipo de Eduardo Allona sabía que tenía que sumar un triunfo ante Náutico Avellaneda. Más allá de algún susto en el segundo set, el Xeneize impuso en la cancha su diferencia de jerarquía y lo ganó bien.</p><p style=\"font-family: Akzidenz, Arial, sans-serif; font-size: 20px; line-height: 32px; --_text-style---font-family: Akzidenz,Arial,sans-serif; --_text-style---font-size: 16px; --_text-style---font-weight: 400; --_text-style---letter-spacing: 0px; --_text-style---line-height: 22px; color: rgb(255, 255, 255); background-color: rgb(34, 57, 107); margin-bottom: 0px !important;\">Parciales de 12-25, 25-22, 22-25 y 21-25 para terminar el fin de semana con 12 puntos en 5 partidos jugados. Tercero en la tabla de posiciones, Boca volverá al ruedo el próximo sábado en el Quinquela a partir de las 21 horas ante Ferro.</p>', '1770898009.3', 'TuQ', '2026-02-12 09:06:32', 'Verdadero', '', 1),
(4, NULL, 4, 'Cómodo triunfo sobre Ferro', 'Boca superó 3-0 al equipo de Caballito en un partido más de la LAF 2026.', '<p style=\"margin-bottom: 32px; font-family: Akzidenz, Arial, sans-serif; font-size: 20px; line-height: 32px; --_text-style---font-family: Akzidenz,Arial,sans-serif; --_text-style---font-size: 16px; --_text-style---font-weight: 400; --_text-style---letter-spacing: 0px; --_text-style---line-height: 22px; color: rgb(255, 255, 255); background-color: rgb(34, 57, 107);\">Luego de la caída ante Vélez el pasado viernes, el equipo dirigido por Eduardo Allona salió decidido a retomar la senda triunfal, le ganó sin mayores problemas a Ferro y cumplió con su objetivo en la noche de domingo del Quinquela.</p><p style=\"font-family: Akzidenz, Arial, sans-serif; font-size: 20px; line-height: 32px; --_text-style---font-family: Akzidenz,Arial,sans-serif; --_text-style---font-size: 16px; --_text-style---font-weight: 400; --_text-style---letter-spacing: 0px; --_text-style---line-height: 22px; color: rgb(255, 255, 255); background-color: rgb(34, 57, 107); margin-bottom: 0px !important;\">Parciales de 25-22, 25-14 y 25-20 para llegar a 16 puntos en 7 partidos jugados hasta el momento en la LAF 2026. Cuarto momentáneamente en la tabla de posiciones, el próximo rival del Xeneize será River en día y hora a confirmar.</p>', '1770898150.4', 'TuQ', '2026-02-12 09:09:09', 'Verdadero', '', 1),
(5, NULL, 4, '&quot;No tuvimos el rendimiento que esperábamos&quot;', 'Claudio Úbeda analizó en rueda de prensa el partido de este domingo ante Vélez.', '<p style=\"margin-bottom: 32px; font-family: Akzidenz, Arial, sans-serif; font-size: 20px; line-height: 32px; --_text-style---font-family: Akzidenz,Arial,sans-serif; --_text-style---font-size: 16px; --_text-style---font-weight: 400; --_text-style---letter-spacing: 0px; --_text-style---line-height: 22px; color: rgb(255, 255, 255); background-color: rgb(34, 57, 107);\">El Xeneize no pudo sumar en su visita a Liniers. Tras el encuentro, llegó el análisis del entrenador.</p><p style=\"margin-bottom: 32px; font-family: Akzidenz, Arial, sans-serif; font-size: 20px; line-height: 32px; --_text-style---font-family: Akzidenz,Arial,sans-serif; --_text-style---font-size: 16px; --_text-style---font-weight: 400; --_text-style---letter-spacing: 0px; --_text-style---line-height: 22px; color: rgb(255, 255, 255); background-color: rgb(34, 57, 107);\"><span style=\"font-weight: 700;\">Todas las declaraciones</span></p><p style=\"margin-bottom: 32px; font-family: Akzidenz, Arial, sans-serif; font-size: 20px; line-height: 32px; --_text-style---font-family: Akzidenz,Arial,sans-serif; --_text-style---font-size: 16px; --_text-style---font-weight: 400; --_text-style---letter-spacing: 0px; --_text-style---line-height: 22px; color: rgb(255, 255, 255); background-color: rgb(34, 57, 107);\">\"Hoy no fue un buen partido, creo que no es una excusa decir que el fútbol argentino es competitivo y todos se hacen fuertes de local y se compite de igual a igual en todas las canchas. No tuvimos el rendimiento que esperábamos\".</p><p style=\"margin-bottom: 32px; font-family: Akzidenz, Arial, sans-serif; font-size: 20px; line-height: 32px; --_text-style---font-family: Akzidenz,Arial,sans-serif; --_text-style---font-size: 16px; --_text-style---font-weight: 400; --_text-style---letter-spacing: 0px; --_text-style---line-height: 22px; color: rgb(255, 255, 255); background-color: rgb(34, 57, 107);\">\"Lógico que esté preocupado porque Boca tiene salir a ganar en todos lados y jugar de otra manera, mucho mejor de lo que hicimos hoy. Nos faltó un poco más de juego, más de intención de ataque y es por eso que estamos preocupados\".</p><p style=\"margin-bottom: 32px; font-family: Akzidenz, Arial, sans-serif; font-size: 20px; line-height: 32px; --_text-style---font-family: Akzidenz,Arial,sans-serif; --_text-style---font-size: 16px; --_text-style---font-weight: 400; --_text-style---letter-spacing: 0px; --_text-style---line-height: 22px; color: rgb(255, 255, 255); background-color: rgb(34, 57, 107);\">\"Los equipos se construyen de atrás para adelante y siendo sólidos defensivamente. Sabíamos que ante presión alta dividían y estiraban al equipo rival. Indefectiblemente nos pasó parecido porque tenían centrodelanteros que descargaban. Así nos pasó en los dos goles, de los cuales pasaron solo tres minutos y son los momentos donde más calma hay que tener\".</p><p style=\"margin-bottom: 32px; font-family: Akzidenz, Arial, sans-serif; font-size: 20px; line-height: 32px; --_text-style---font-family: Akzidenz,Arial,sans-serif; --_text-style---font-size: 16px; --_text-style---font-weight: 400; --_text-style---letter-spacing: 0px; --_text-style---line-height: 22px; color: rgb(255, 255, 255); background-color: rgb(34, 57, 107);\">\"De esto se sale ganando. La única manera es mostrando una gran actitud y ganando lo más rápido posible. El próximo partido en casa hay que ganarlo y tratar de volver a la senda en la que estuvimos el año pasado. Es la única manera para revertir situaciones complejas\".</p><p style=\"font-family: Akzidenz, Arial, sans-serif; font-size: 20px; line-height: 32px; --_text-style---font-family: Akzidenz,Arial,sans-serif; --_text-style---font-size: 16px; --_text-style---font-weight: 400; --_text-style---letter-spacing: 0px; --_text-style---line-height: 22px; color: rgb(255, 255, 255); background-color: rgb(34, 57, 107); margin-bottom: 0px !important;\">\"Recién estamos en el comienzo del torneo y obviamente uno analiza todo lo que va pasando fecha tras fecha. Tenemos plena confianza en revertir esta situación. No nos gusta haber ganado dos y perdidos dos. Tenemeos la obligación de estar mejor y tratar para poder doblegar esta situación y salir adelante\".</p>', '1770898360.5', 'TuQ', '2026-02-12 09:12:39', 'Verdadero', 'fasdf', 1),
(6, NULL, 2, 'Objetivo cumplido', 'Boca venció en Belo Horizonte, ganó su zona y espera rival de cuartos en la Champions.', '<p style=\"margin-bottom: 32px; font-family: Akzidenz, Arial, sans-serif; font-size: 20px; line-height: 32px; --_text-style---font-family: Akzidenz,Arial,sans-serif; --_text-style---font-size: 16px; --_text-style---font-weight: 400; --_text-style---letter-spacing: 0px; --_text-style---line-height: 22px; color: rgb(255, 255, 255); background-color: rgb(34, 57, 107);\">Boca se impuso 77-67 a Minas Tenis en Belo Horizonte y vuelve de Brasil con el pasaje a cuartos de final de la Basketball Champions League, la primera posición del Grupo C y la firme convicción de que tiene los recursos humanos suficientes para llegar otra vez, como en 2025, a la instancia decisiva del certamen de clubes más importante de la región.</p><p style=\"margin-bottom: 32px; font-family: Akzidenz, Arial, sans-serif; font-size: 20px; line-height: 32px; --_text-style---font-family: Akzidenz,Arial,sans-serif; --_text-style---font-size: 16px; --_text-style---font-weight: 400; --_text-style---letter-spacing: 0px; --_text-style---line-height: 22px; color: rgb(255, 255, 255); background-color: rgb(34, 57, 107);\">Ausente Francisco Cáffaro por un esguince de tobillo, según el parte médico, Agustín Barreiro (14 puntos, 10 rebotes) y Franco Giorgetti ( cuatro, 10) se hicieron fuertes en la pintura. Lucas Faggiano (ocho asistencias) condujo con acierto y Michael Smith (16 tantos) cumplió con su cuota goleadora.&nbsp;</p><p style=\"margin-bottom: 32px; font-family: Akzidenz, Arial, sans-serif; font-size: 20px; line-height: 32px; --_text-style---font-family: Akzidenz,Arial,sans-serif; --_text-style---font-size: 16px; --_text-style---font-weight: 400; --_text-style---letter-spacing: 0px; --_text-style---line-height: 22px; color: rgb(255, 255, 255); background-color: rgb(34, 57, 107);\">A la espera de conocer su rival en la próxima fase del torneo, el equipo dirigido por Nicolás Casalánguida empieza a pensar en sus próximos compromisos de la Liga Nacional: martes 10 con Argentino en Junín y jueves 12 con Racing en Chivilcoy.</p>', '1770899137.6', 'TuQ', '2026-02-12 09:25:36', 'Verdadero', '', 1),
(7, 1, 2, 'Boca juniors  dddddddd  dddddddddd', 'El detalle en la presentación de la nueva camiseta de Boca que expone el complicado presente del equipoddddddddddddddddddddddddddd', '<div id=\"lipsum\" style=\"margin: 0px; padding: 0px; text-align: justify; font-family: &quot;Open Sans&quot;, Arial, sans-serif;\"><h1 style=\"color: rgb(0, 0, 0); margin-bottom: 15px; padding: 0px;\">dddddddddddddddddddddeste es ddddun titulo</h1><p style=\"color: rgb(0, 0, 0); margin-bottom: 15px; padding: 0px;\"><a href=\"http://www.google.com.ar\" target=\"_blank\">visitar google</a></p><p style=\"margin-bottom: 15px; padding: 0px;\"><font color=\"#000000\">Lorem ipsum dolor sit amet, cons</font><font color=\"#ff0000\">ectetur adipiscing elit. Integer aliquet ultrices scelerisque. Duis at dolor sit amet erat soda</font><font color=\"#000000\">les facilisis. Duis ornare justo ut fringilla hendrerit. Mauris sit amet tincidunt eros. Maecenas dapibus imperdiet varius. Cras molestie elit a diam tempor, vitae cursus nulla condimentum. Praesent molestie ut nibh vel vulputate. Aliquam porta condimentum diam, non finibus felis dapibus non.</font></p><p style=\"color: rgb(0, 0, 0); margin-bottom: 15px; padding: 0px;\">Proin a sem vel lacus fermentum vehicula ut non nisl. Praesent id posuere turpis. Sed quis maximus justo, in tincidunt nibh. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Pellentesque at semper tortor. Ut ut nisi vitae augue sagittis vehicula eu et mi. Fusce tincidunt eros eu urna faucibus tincidunt. Donec in nulla nibh. Sed convallis mollis eros sed sodales.</p><p style=\"color: rgb(0, 0, 0); margin-bottom: 15px; padding: 0px;\">Fusce nec gravida lorem. In hac habitasse platea dictumst. Phasellus quis leo fermentum, suscipit nisl eget, commodo nibh. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Donec venenatis nunc ut turpis commodo, sed ornare elit dictum. Maecenas ullamcorper blandit nulla, vel malesuada diam dictum eu. Aliquam consectetur eros at tincidunt venenatis. Sed sit amet egestas enim. Quisque at nisl ex. Donec faucibus nunc eget aliquet feugiat. Vestibulum tellus mi, suscipit sed orci eu, dignissim posuere enim. Sed non felis eros.</p><p style=\"color: rgb(0, 0, 0); margin-bottom: 15px; padding: 0px;\">Duis ut laoreet magna. Etiam consequat ante a accumsan luctus. Quisque eget faucibus ligula. Nulla maximus enim ut justo placerat tristique. In hac habitasse platea dictumst. Donec ac mattis velit. Nunc eu neque ut magna ornare maximus. Mauris malesuada tortor eu imperdiet vulputate.</p><p style=\"color: rgb(0, 0, 0); margin-bottom: 15px; padding: 0px;\">Phasellus id imperdiet metus. Integer eget arcu eget purus viverra porttitor. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Duis felis diam, iaculis eu eleifend nec, vehicula non odio. Nam odio orci, cursus sit amet tincidunt ac, luctus a risus. Praesent vehicula nec dui id ornare. Fusce sagittis vulputate odio, quis pulvinar mi aliquet sit amet. In maximus felis at turpis condimentum, sed convallis metus vehicula. Vivamus auctor, odio tincidunt luctus fringilla, nulla enim tincidunt elit, maximus egestas ex orci sed magna. Fusce scelerisque a libero consequat finibus. Donec ut leo sit amet ipsum dignissim dignissim eu nec sapien. Praesent molestie aliquet massa at maximus.</p></div><div id=\"generated\" style=\"margin: 0px; padding: 0px; font-weight: 700; color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif;\">Generated 5 paragraphs, 362 words, 2406 bytes of&nbsp;<a href=\"https://www.lipsum.com/\" title=\"Lorem Ipsum\" style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0);\">Lorem Ipsum</a></div><div id=\"generated\" style=\"margin: 0px; padding: 0px; font-weight: 700; color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif;\"><br></div><div id=\"generated\" style=\"margin: 0px; padding: 0px; font-weight: 700; color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif;\"><br></div>', '1771162393.PNG', 'Admin Principal', '2026-02-12 16:35:46', 'Casi Verdadero', '', 0),
(8, 2, 2, 'riber', 'haaaaaaaaaaaaaaaa', 'cualquier cosa', '1771352764.jpg', 'ivan', '2026-02-17 15:26:04', 'Verdadero', '', 0);

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
(3, 'ruben', 'correa', 'rcorrea', '$2y$10$fQ2ygLqFpfCsf1D8RRR5guiXpXLj6sG1l3pXIFOhRQBfnt40ow2jS', 'Administrador', '', 0);

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
  MODIFY `idnoticia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
