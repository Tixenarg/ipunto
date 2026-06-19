-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 19-06-2026 a las 13:46:57
-- Versión del servidor: 11.8.6-MariaDB-log
-- Versión de PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `u736192581_ipuntov2`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `noticia`
--

INSERT INTO `noticia` (`idnoticia`, `idusuario`, `idcategoria`, `titulo`, `resumen`, `cuerpo`, `imagen`, `autor`, `fecha_publicacion`, `calificacion`, `explicacion_calificacion`, `estado`) VALUES
(1, 1, 1, 'Ajuste, inversiones y causas judiciales: los temas que marcaron la jornada', 'Reformas, ajuste, inversiones y causas judiciales marcaron la agenda del día.', '', '1781615175.webp', 'Redacción I.', '2026-06-16 13:06:15', '', '', 1),
(2, 1, 1, 'Consumo, austeridad y causas judiciales: las claves de la jornada', 'La caída del consumo, las subas en alimentos, nuevas señales de austeridad y distintas investigaciones judiciales marcaron la agenda del día', '', '1781615592.webp', 'Redacción I.', '2026-06-16 13:13:12', '', '', 1),
(3, 1, 1, 'Internas, investigaciones y cruces políticos: las claves de la jornada', 'Las tensiones dentro del oficialismo, el avance de causas de alto impacto y un nuevo cruce entre Nación y Provincia marcaron la agenda del día.', '', '1781617272.webp', 'Redacción I.', '2026-06-16 13:41:12', '', '', 1),
(4, 1, 1, 'Ni Una Menos y tensiones políticas: las claves de la jornada', 'A diez años de la primera movilización, miles de personas marcharon en todo el país. El Gobierno busca dejar atrás la disputa con Patricia Bullrich y avanzar con su agenda legislativa.', '', '1781617513.webp', 'Redacción I.', '2026-06-16 13:45:13', '', '', 1),
(5, 1, 1, 'Senado, Justicia y poder: una jornada adversa para el Gobierno', 'La aprobación del pliego de Ana María Michelli expuso nuevas diferencias dentro del oficialismo y abrió una disputa política y judicial que dejó ganadores y perdedores.', '', '1781617805.webp', 'Redacción I.', '2026-06-16 13:50:04', '', '', 1),
(6, 1, 1, 'La muerte del Indio Solari, la economía y los movimientos políticos del día', 'El fallecimiento del Indio Solari generó repercusión en todo el país, mientras la economía volvió a mostrar señales mixtas y la política sumó nuevos movimientos de cara al escenario que viene.', '', '1781618112.webp', 'Redacción I.', '2026-06-16 13:55:11', '', '', 1),
(7, 1, 1, 'Adorni se sumó al nuevo régimen simplificado de Ganancias', '', '', '1781618394.webp', 'Redacción I.', '2026-06-16 13:59:53', '', '', 1),
(8, 1, 1, 'El Gobierno avanzó con recortes y desregulación, pero suma nuevos frentes de tensión', 'Diputados aprobó cambios en subsidios al gas y avanzó la Ley Hojarasca. Mientras tanto, crecen las tensiones por salud, provincias y política exterior.', '', '1781648048.webp', 'Redacción I.', '2026-06-16 22:14:08', '', '', 0),
(9, 1, 1, 'Argentina debuta en el Mundial: las claves del día', 'El estreno de la Selección en el Mundial 2026 concentra la atención de una jornada marcada por el fútbol y las primeras historias del torneo.', '', '1781724392.webp', 'Redacción I.', '2026-06-17 19:26:31', '', '', 1),
(10, 1, 1, 'Adorni, el Mundial y la Justicia: las claves del día', 'La situación de Manuel Adorni, el debut ganador de Argentina en el Mundial y un fallo sobre AySA marcaron la agenda de la jornada.', '', '1781866625.webp', 'Redacción I.', '2026-06-19 10:57:05', '', '', 1),
(11, 1, 1, 'Adorni, voto joven e Hidrovía: las claves del día', 'Las repercusiones en torno a Manuel Adorni, una iniciativa para ampliar la participación política de los jóvenes y la adjudicación de la Hidrovía marcaron la agenda de la jornada.', '', '1781866903.webp', 'Redacción I.', '2026-06-19 11:01:43', '', '', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `noticia_seccion`
--

CREATE TABLE `noticia_seccion` (
  `idseccion` int(11) NOT NULL,
  `idnoticia` int(11) NOT NULL,
  `categoria_seccion` varchar(100) DEFAULT NULL,
  `subtitulo` varchar(255) NOT NULL,
  `cuerpo` text NOT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `orden` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `noticia_seccion`
--

INSERT INTO `noticia_seccion` (`idseccion`, `idnoticia`, `categoria_seccion`, `subtitulo`, `cuerpo`, `imagen`, `orden`) VALUES
(100, 1, 'Economía', 'El debate por el ajuste llegó a las provincias', 'Un informe volvió a poner el foco sobre los compromisos asumidos en el Pacto de Mayo y el esfuerzo fiscal que deberían realizar las provincias para acompañar las metas económicas planteadas por el Gobierno.\r\n\r\nLa discusión aparece en un contexto donde gobernadores y Nación mantienen tensiones por recursos, transferencias y equilibrio fiscal.', '', 1),
(101, 1, 'Inversiones', 'Dudas sobre el alcance del RIGI', 'Un análisis de JP Morgan planteó interrogantes sobre la capacidad del Régimen de Incentivo para Grandes Inversiones (RIGI) para atraer inversiones genuinas y sostenidas en el tiempo.\r\n\r\nEl esquema es una de las principales apuestas económicas del Gobierno para captar capitales y acelerar proyectos de gran escala', '', 2),
(102, 1, 'Congreso', 'El Gobierno impulsa una nueva ley de sociedades', 'El Ejecutivo enviará al Congreso un proyecto para reformar el régimen societario argentino.\r\n\r\nLa iniciativa busca simplificar trámites, modernizar estructuras empresariales y adaptar la normativa a nuevas formas de organización económica.', '', 3),
(103, 1, 'Justicia', 'Hallaron dinero y droga en una investigación judicial', 'Una causa judicial derivó en el hallazgo de más de US$650.000 y droga en una propiedad vinculada a un funcionario que pasó por las administraciones de Alberto Fernández y Javier Milei.\r\n\r\nLa Justicia investiga el origen de los fondos y las posibles responsabilidades.', '', 4),
(104, 1, 'Sociedad', 'Continúan los allanamientos por el caso Agostina Vega', 'La investigación por la desaparición de la adolescente en Córdoba sumó nuevos procedimientos en las últimas horas.\r\n\r\nLos investigadores continúan reuniendo pruebas para reconstruir los hechos y avanzar en el esclarecimiento del caso.', '', 5),
(105, 1, 'La síntesis', '', 'El Gobierno busca avanzar con reformas económicas y sostener el rumbo fiscal mientras crecen los debates sobre inversiones, recursos provinciales y el impacto del ajuste.\r\n\r\nAl mismo tiempo, causas judiciales y policiales de alto perfil siguen ocupando un lugar central en la agenda pública.\r\n\r\nY ahora sí, ya estás al día.', '', 6),
(106, 2, 'Economía', 'La recaudación del IVA volvió a encender alarmas sobre el consumo', 'La recaudación asociada al IVA mostró una caída real en mayo, un dato seguido de cerca porque suele reflejar el nivel de actividad y consumo.\r\n\r\nEl indicador aparece en un contexto donde algunos números fiscales muestran mejoras, pero la recuperación económica sigue generando dudas.', '', 1),
(107, 2, 'Bolsillo', 'La carne volvió a subir', 'Los precios de la carne vacuna, el cerdo y el pollo registraron nuevos aumentos durante las últimas semanas.\r\n\r\nEl movimiento impacta sobre uno de los consumos más habituales de los hogares y vuelve a poner presión sobre el costo de vida.\r\n\r\n', '', 2),
(108, 2, 'Política', 'Kicillof prohibió viajes al Mundial para funcionarios bonaerenses', 'El gobernador Axel Kicillof dispuso que funcionarios de la Provincia no viajen al Mundial 2026 con recursos públicos.\r\n\r\nLa medida fue presentada como una señal de austeridad en medio de un contexto económico marcado por restricciones presupuestarias y reclamos por recursos.', '', 3),
(109, 2, 'Justicia', 'Avanza la investigación por el caso Agostina Vega', 'La causa por la muerte de la adolescente en Córdoba incorporó nuevos elementos tras conocerse resultados preliminares de la autopsia.\r\n\r\nLos investigadores continúan reuniendo pruebas para esclarecer las circunstancias del hecho.', '', 4),
(110, 2, 'Investigación', 'Un robo de fibra óptica derivó en una causa de mayor escala', 'La investigación iniciada por el robo de cableado abrió nuevas líneas vinculadas a presuntas irregularidades, drogas y posibles responsabilidades de funcionarios.\r\n\r\nLa Justicia continúa analizando la información reunida durante los procedimientos.', '', 5),
(111, 2, 'La síntesis', '', 'La jornada dejó una combinación de temas que atraviesan la vida cotidiana y la política: señales de debilidad en el consumo, nuevas subas en alimentos, gestos de austeridad y causas judiciales que siguen avanzando.', '', 6),
(112, 3, 'Política', 'Bullrich volvió a tensar la relación con Milei', 'Las diferencias en torno a la estrategia legislativa y la conducción política del oficialismo volvieron a exponer tensiones entre Patricia Bullrich y sectores cercanos al Presidente.\r\n\r\nLa discusión reabrió interrogantes sobre el equilibrio interno dentro de La Libertad Avanza y sus aliados, en un momento donde el Gobierno busca consolidar apoyos para avanzar con su agenda.', '', 1),
(113, 3, 'Economía y política', 'Caputo cruzó a Kicillof con una frase que generó repercusiones', 'El ministro de Economía, Luis Caputo, volvió a cuestionar al gobernador bonaerense Axel Kicillof y dejó una de las declaraciones más comentadas del día.\r\n\r\nLa frase se sumó a una serie de cruces que reflejan la creciente confrontación entre el Gobierno nacional y la administración bonaerense.', '', 2),
(114, 3, 'Salud', 'La investigación por el fentanilo sigue avanzando', 'La Justicia continúa investigando la distribución de fentanilo contaminado vinculada a decenas de fallecimientos registrados en distintos puntos del país.\r\n\r\nLa causa busca determinar responsabilidades y analizar el rol de distintos actores involucrados en la cadena de producción, distribución y control.', '', 3),
(115, 3, 'Sociedad', 'El caso Agostina Vega sumó nuevos elementos', 'Los resultados preliminares de la autopsia incorporaron información relevante a la investigación por la muerte de la adolescente en Córdoba.\r\n\r\nLa Justicia continúa reuniendo pruebas para reconstruir los hechos y esclarecer las circunstancias del caso.', '', 4),
(116, 3, 'Economía', 'Nuevo capítulo en la disputa por la deuda argentina', 'Un fallo judicial en el exterior volvió a poner el foco sobre los litigios vinculados a la deuda argentina y los reclamos de fondos de inversión.\r\n\r\nAunque el impacto inmediato aún está bajo análisis, la decisión suma un nuevo capítulo a una disputa que lleva años en los tribunales internacionales.', '', 5),
(117, 3, 'La síntesis', '', 'La jornada estuvo marcada por tensiones políticas dentro y fuera del oficialismo, investigaciones que siguen avanzando en causas sensibles y un nuevo frente judicial vinculado a la economía argentina.\r\n\r\nY ahora sí, ya estás al día.', '', 6),
(118, 4, 'Sociedad', 'Ni Una Menos volvió a movilizar a miles de personas', 'A diez años de la primera marcha, la consigna Ni Una Menos volvió a reunir manifestaciones en distintos puntos del país.\r\n\r\nLa movilización estuvo atravesada por la conmoción generada por el caso Agostina Vega y por reclamos vinculados a prevención, asistencia y acceso a la justicia.', '', 1),
(119, 4, 'Debate público', 'La marcha también generó cruces políticos', 'La ministra Patricia Bullrich cuestionó algunos aspectos de la movilización y reabrió el debate sobre las políticas públicas vinculadas a la problemática.\r\n\r\nSus declaraciones generaron repercusiones tanto entre dirigentes políticos como entre organizaciones sociales.', '', 2),
(120, 4, 'Política', 'Karina Milei recibió a Bullrich en Casa Rosada', 'En medio de las tensiones generadas por distintos debates legislativos, Karina Milei mantuvo una reunión con Patricia Bullrich en Casa Rosada.\r\n\r\nEl encuentro fue leído como un gesto de acercamiento en un momento donde el oficialismo busca ordenar diferencias internas y fortalecer acuerdos políticos.', '', 3),
(121, 4, 'Congreso', 'El Gobierno busca avanzar con nuevos pliegos', 'La administración nacional trabaja para impulsar el tratamiento de decenas de pliegos pendientes y dejar atrás los conflictos que marcaron las últimas semanas.\r\n\r\nEl objetivo es recuperar iniciativa política y avanzar con parte de la agenda institucional que todavía permanece abierta.', '', 4),
(122, 4, 'La síntesis', '', 'La jornada estuvo marcada por una nueva movilización de Ni Una Menos, que volvió a instalar el tema en la agenda pública a diez años de su primera convocatoria.\r\n\r\nAl mismo tiempo, el Gobierno mostró señales de reordenamiento político en medio de negociaciones y tensiones que siguen abiertas.\r\n\r\nY ahora sí, ya estás al día.', '', 5),
(123, 5, 'Senado', 'El pliego de Michelli consiguió los votos', 'La Cámara alta aprobó el pliego de Ana María Michelli tras una negociación que reunió al peronismo con distintos aliados parlamentarios.\r\n\r\nLa votación representó uno de los movimientos políticos más relevantes de las últimas semanas dentro del Senado.', '', 1),
(124, 5, 'Política', 'Villarruel volvió a quedar en el centro de la escena', 'La vicepresidenta tuvo un papel clave durante una jornada que volvió a mostrar diferencias respecto de sectores del oficialismo.\r\n\r\nSu intervención fue observada de cerca tanto por aliados como por opositores.', '', 2),
(125, 5, 'Justicia', 'Un fallo que reconfigura equilibrios internos', 'La resolución también generó repercusiones dentro del ámbito judicial, donde distintos sectores interpretaron el resultado como una derrota para algunos espacios de poder y un fortalecimiento de otros.', '', 3),
(126, 5, 'La síntesis', '', 'La aprobación del pliego de Michelli terminó convirtiéndose en mucho más que una votación legislativa. La sesión dejó expuestas tensiones políticas, reacomodamientos en el Senado y nuevas señales sobre las disputas de poder que atraviesan al oficialismo.', '', 4),
(127, 6, 'Sociedad', 'Conmoción por la muerte del Indio Solari', 'La muerte del Indio Solari generó una fuerte repercusión entre seguidores, artistas y dirigentes de distintos espacios.\r\n\r\nMientras continúan los estudios para determinar con precisión la causa del fallecimiento, distintas expresiones públicas recordaron su trayectoria y su influencia en la cultura argentina.', '', 1),
(128, 6, 'Política', 'El Congreso rechazó realizar el velatorio en el Palacio Legislativo', 'La Cámara de Diputados desestimó el pedido para realizar una despedida institucional en el Congreso.\r\n\r\nLa decisión abrió debates sobre los criterios para este tipo de homenajes y reconocimientos.', '', 2),
(129, 6, 'Economía', 'Wall Street arrastró a los activos argentinos', 'Los mercados internacionales registraron una jornada negativa que impactó sobre acciones argentinas y volvió a presionar al riesgo país.', '', 3),
(130, 6, 'Banco Central', 'Compras de dólares y caída de reservas', 'Aunque el Banco Central logró cerrar la semana con saldo comprador, las reservas internacionales continuaron mostrando retrocesos.', '', 4),
(131, 6, 'Política', 'Macri volvió a mostrarse junto a Pullaro', 'El encuentro entre Mauricio Macri y Maximiliano Pullaro reactivó especulaciones sobre el rol que buscará ocupar el expresidente en la reorganización opositora.', '', 5),
(132, 6, 'Justicia', 'Lázaro Báez continúa internado', 'El empresario permanece bajo atención médica tras ser internado por un cuadro de neumonía.', '', 6),
(133, 6, 'La síntesis', '', 'La muerte del Indio Solari dominó buena parte de la agenda pública de la jornada. En paralelo, la economía dejó señales contrapuestas y la política volvió a mostrar movimientos que anticipan nuevas disputas y reacomodamientos.', '', 7),
(146, 7, 'Política', 'La oposición puso el foco en funcionarios que se incorporaron al régimen', 'La adhesión de distintos funcionarios nacionales generó cuestionamientos de sectores opositores, que reclamaron mayores precisiones sobre los alcances del sistema.\r\n\r\nEl debate se instaló tanto en el Congreso como en el ámbito político.', '', 1),
(147, 7, 'Mercados', 'Mejoró la calificación de deuda argentina', 'Una nueva agencia internacional elevó la nota de la deuda soberana argentina.\r\n\r\nLa decisión se sumó a otras mejoras recientes y fue interpretada por el Gobierno como una señal positiva sobre la evolución de la economía.', '', 2),
(148, 7, 'Universidades', 'El Gobierno alcanzó un acuerdo y bajó la tensión', 'La administración nacional avanzó en un entendimiento con autoridades universitarias y sectores gremiales que permitió descomprimir uno de los conflictos más sensibles de los últimos meses.\r\n\r\nEl acuerdo fue recibido como un alivio político para la Casa Rosada.', '', 3),
(149, 7, 'Educación', 'Persisten los reclamos por salarios docentes', 'Pese al acercamiento entre las partes, distintos sectores señalaron que los ingresos docentes continúan por debajo de los niveles previos a la aceleración inflacionaria de los últimos años.\r\n\r\nEl debate sobre financiamiento universitario continúa abierto.', '', 4),
(150, 7, 'Justicia', 'Continúan las repercusiones del caso Spagnuolo', 'La causa vinculada a los audios que involucran al funcionario sigue sumando novedades judiciales y pedidos presentados ante los tribunales.\r\n\r\nEl expediente continúa en desarrollo.', '', 5),
(151, 7, 'La síntesis', '', 'La jornada estuvo marcada por el debate sobre el nuevo esquema de Ganancias, señales favorables para la deuda argentina y un acuerdo que permitió reducir la tensión entre el Gobierno y las universidades.', '', 6),
(152, 8, 'Política', 'El Gobierno consiguió una victoria importante en Diputados.', 'La Cámara aprobó la modificación del régimen de Zonas Frías, que recorta el alcance de los subsidios al gas. La votación terminó con 132 votos a favor, 105 en contra y 4 abstenciones. El proyecto ahora pasa al Senado.\r\n\r\nEl cambio busca volver a un esquema más limitado: el beneficio quedaría concentrado en la Patagonia, Malargüe y la Puna, mientras quedarían afuera varias zonas que habían sido incorporadas en 2021, entre ellas sectores de Buenos Aires, Córdoba, Santa Fe y San Luis.\r\n\r\nPara el Gobierno, la medida ordena un sistema de subsidios que considera demasiado amplio y permite ahorrar recursos fiscales. Según datos oficiales, el ahorro estimado sería de $272.099 millones.\r\n\r\nEl punto político estuvo en la negociación. Para conseguir los votos, la Casa Rosada acordó compensaciones vinculadas al suministro eléctrico para provincias del norte y zonas cálidas. En criollo: el oficialismo recortó por un lado, pero tuvo que negociar por otro. No hay motosierra sin calculadora.', '', 1),
(153, 8, 'Estado', 'La otra media sanción relevante fue la Ley Hojarasca.', 'No es una medida solamente económica. Es más amplia: forma parte de la agenda de desregulación y transformación del Estado que impulsa el Gobierno.\r\n\r\nEl proyecto busca derogar 63 leyes y modificar otras normas que, según el oficialismo, quedaron desactualizadas, fueron reemplazadas por legislación posterior, generan trámites innecesarios o sostienen estructuras que ya no cumplen una función clara.\r\n\r\nLa discusión de fondo es bastante más grande que una lista de leyes viejas. Para el Gobierno, es una forma de simplificar el Estado y reducir regulaciones. Para la oposición, el riesgo es avanzar demasiado rápido sobre normas sin discutir cada caso con profundidad.\r\n\r\nEn síntesis: la Ley Hojarasca muestra hacia dónde quiere ir el oficialismo. Menos capas normativas, menos burocracia y un Estado más chico.', '', 2),
(154, 8, 'Sociedad', '', 'El ajuste también abrió otro frente sensible: salud.\r\n\r\nEl Gobierno dispuso un recorte de $63.021 millones en el presupuesto del Ministerio de Salud. La decisión vuelve a tensionar la relación con provincias y prestadores, especialmente por el financiamiento del sistema sanitario y el PAMI.\r\n\r\nEl tema pesa porque no se trata de una discusión abstracta. Salud pública, medicamentos, adultos mayores y atención médica son áreas donde cualquier recorte se siente rápido.\r\n\r\nAhí aparece uno de los límites políticos del ajuste: puede cerrar números, pero también puede abrir conflictos difíciles de administrar.', '', 3),
(155, 8, 'Defensa y seguridad', 'La relación con Estados Unidos también quedó en agenda.', 'Argentina y Estados Unidos lanzaron el programa Protecting Global Commons Program, orientado a fortalecer la seguridad marítima en el Atlántico Sur. El acuerdo se inscribe en un vínculo cada vez más estrecho entre el gobierno argentino y la administración de Donald Trump.\r\n\r\nPara la Casa Rosada, la cooperación con Washington refuerza la agenda de defensa y seguridad. Pero también abre una pregunta de fondo: cuánto margen propio conserva Argentina cuando profundiza su alineamiento estratégico con Estados Unidos.\r\n\r\nNo es un tema menor. Defensa, seguridad y Atlántico Sur no son áreas decorativas del Estado', '', 4),
(156, 8, 'Mundo', 'Bolivia sigue atravesando una crisis política y social fuerte.', 'Las protestas comenzaron con reclamos de sectores campesinos por mejoras salariales, pero escalaron en bloqueos, enfrentamientos y pedidos de renuncia contra el presidente Rodrigo Paz Pereira. El Gobierno boliviano acusa a sectores vinculados a Evo Morales de intentar desestabilizar el orden institucional.\r\nEl conflicto ya generó problemas de abastecimiento en alimentos, combustibles e insumos médicos, especialmente en La Paz y El Alto.\r\n\r\nArgentina no mira esto desde lejos. Bolivia es frontera, energía, comercio y política regional. Cuando el conflicto escala ahí, el norte argentino también presta atención.', '', 5),
(157, 8, 'La síntesis', '', 'El Gobierno tuvo una buena jornada legislativa: avanzó con recortes, desregulación y orden fiscal.\r\n\r\nPero el mismo movimiento abre preguntas difíciles: cuánto impacto tendrán los cambios en las tarifas, cómo se sostiene el ajuste en salud, qué costo político aparece en las provincias y hasta dónde llega el alineamiento internacional.\r\n\r\nLa foto del día es esa: el oficialismo logró avanzar, pero cada avance empieza a tener consecuencias más visibles.\r\n\r\nY ahora sí, ya estás al día.', '', 6),
(158, 9, 'Mundial 2026', 'Argentina pone en marcha su camino', 'La Selección Argentina debuta ante Argelia en su primer partido del Mundial 2026.\r\n\r\nEl equipo de Lionel Scaloni inicia la defensa del título con la expectativa de volver a ser protagonista en la máxima cita del fútbol.', '', 1),
(159, 9, 'Rival', 'Argelia llega con cambios de último momento', 'En la previa del encuentro se conocieron modificaciones dentro del seleccionado africano que alteraron la planificación inicial para el debut.\r\n\r\nLas novedades generaron expectativa a pocas horas del partido.', '', 2),
(160, 9, 'Mundial', 'Mbappé arrancó haciendo historia', 'El delantero francés fue una de las figuras de las primeras jornadas del torneo y volvió a romper récords con su actuación ante Senegal.\r\n\r\nSu nombre aparece nuevamente entre los principales candidatos a marcar el ritmo de la competencia.', '', 3),
(161, 9, 'Curiosidades', 'Los errores que sorprendieron a la delegación argentina', 'La organización del Mundial debió corregir fallas detectadas en un material audiovisual donde aparecían nombres incorrectos de integrantes del plantel argentino.\r\n\r\nLa situación generó repercusión en redes sociales y obligó a una rápida rectificación.', '', 4),
(162, 9, 'Otros partidos', 'El Mundial sigue sumando historias', 'Además del estreno argentino, la jornada dejó actividad en otros grupos y nuevos resultados que comienzan a definir el panorama de la fase inicial.', '', 5),
(163, 9, 'La síntesis', '', 'El debut de Argentina frente a Argelia concentra la atención de una Copa del Mundo que ya empezó a ofrecer figuras, sorpresas y curiosidades dentro y fuera de la cancha.', '', 6),
(164, 10, 'Política', 'Crecen las repercusiones por la declaración jurada de Adorni', 'Las explicaciones brindadas por el vocero presidencial sobre su patrimonio y sus inversiones continuaron generando cuestionamientos políticos y públicos.\r\n\r\nEl tema se mantuvo entre los principales focos de atención de la agenda nacional.', '', 1),
(165, 10, 'Justicia', 'Un fiscal puso la lupa sobre las explicaciones del funcionario', 'La presentación de nuevas explicaciones sobre la evolución patrimonial de Adorni sumó un nuevo capítulo con la intervención de la Justicia.\r\n\r\nEl caso continúa en una etapa preliminar y sigue generando repercusiones políticas.', '', 2),
(166, 10, 'Senado', 'Adorni quedó más cerca de una interpelación', 'La postergación de una sesión prevista para esta semana dejó abierta la posibilidad de que el funcionario sea convocado a brindar explicaciones ante el Congreso.\r\n\r\nLa discusión podría retomarse a comienzos de julio.', '', 3),
(167, 10, 'Mundial 2026', 'Argentina comenzó con una victoria', 'La Selección debutó con un triunfo ante Argelia y ya prepara su próximo compromiso frente a Austria.\r\n\r\nEl equipo de Lionel Scaloni inició la defensa del título con una actuación sólida.', '', 4),
(168, 10, 'Justicia', 'La Justicia frenó el avance sobre AySA', 'Un fallo judicial suspendió el proceso vinculado a la privatización de la empresa y abrió una nueva discusión sobre el alcance de las reformas impulsadas por el Gobierno.', '', 5),
(169, 10, 'Internacional', 'Estados Unidos e Irán avanzaron en un acuerdo', 'Ambos países firmaron un entendimiento orientado a reducir tensiones y abrir una instancia de diálogo en Medio Oriente.', '', 6),
(170, 10, 'La síntesis', '', 'La jornada estuvo marcada por las repercusiones políticas y judiciales en torno a Manuel Adorni, mientras Argentina comenzó su camino en el Mundial con una victoria y la Justicia sumó un nuevo capítulo en el debate sobre AySA.', '', 7),
(171, 11, 'Política', 'Continúan las repercusiones por el caso Adorni', 'La situación del vocero presidencial volvió a generar movimientos dentro del oficialismo luego de que Ramiro Marra difundiera una carta pública dirigida a Javier Milei.\r\n\r\nEl episodio sumó un nuevo capítulo a una discusión que permanece abierta desde hace semanas.', '', 1),
(172, 11, 'Provincia de Buenos Aires', 'La Libertad Avanza busca fortalecer el voto joven', 'El oficialismo impulsa una iniciativa para reducir la edad mínima requerida para ser concejal bonaerense.\r\n\r\nLa propuesta apunta a ampliar la participación de los jóvenes en la política local y forma parte de la estrategia electoral del espacio.', '', 2),
(173, 11, 'Economía', 'El Gobierno adjudicó la concesión de la Hidrovía', 'La administración nacional completó el proceso de adjudicación de la principal vía navegable del país y otorgó la concesión a la empresa belga Jan De Nul.\r\n\r\nLa Hidrovía es una infraestructura clave para el comercio exterior argentino y concentra buena parte de las exportaciones nacionales.', '', 3),
(174, 11, 'Medios y redes', 'Debate por la difusión de una noticia falsa', 'Nicolás Occhiato cuestionó públicamente a Florencia Peña luego de que se viralizara una información incorrecta sobre la salud del padre de Lionel Messi.\r\n\r\nEl episodio volvió a poner en discusión la circulación de contenidos sin verificar en redes sociales.', '', 4),
(175, 11, 'La síntesis', '', 'La jornada estuvo marcada por nuevas repercusiones políticas alrededor de Manuel Adorni, una propuesta orientada al voto joven y una decisión estratégica sobre la Hidrovía, una de las principales infraestructuras para el comercio exterior argentino.', '', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `suscriptores`
--

CREATE TABLE `suscriptores` (
  `idsuscriptor` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `fecha` datetime DEFAULT current_timestamp(),
  `estado` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `suscriptores`
--

INSERT INTO `suscriptores` (`idsuscriptor`, `email`, `fecha`, `estado`) VALUES
(4, 'rcorrea@derecho.uba.ar', '2026-05-07 19:51:05', 1);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idusuario`, `nombre`, `apellido`, `login`, `clave`, `tipo`, `imagen`, `estado`) VALUES
(1, 'Admin', 'Principal', 'admin', '$2y$10$uO2J1K4kyfDKi4GaZ0EYleeY9ApIUAl1fQLnB2GDU8Q.d9jxEyKiu', 'Administrador', NULL, 1),
(2, 'ivan', 'montano', 'ivan', '$2y$10$1da7si6Xhs1BoIfOw4ganeF5KQcveaF86nbpT0bkVbKoD35y1k7gi', 'Editor', '', 1),
(3, 'ruben', '', 'rcorrea', '$2y$10$kpZIO7WMCVywnGMoC5BOoOSxONNRHQIHmH0.K32O8fvzjT3dh9wj2', 'Administrador', '', 1),
(4, 'Candela Giuffre', '', 'Candela', '$2y$10$3OccW/XEo1Tjxdk9y36MjO5x060AlCFlt8OhPABwEZGSpj1bvt2u.', 'Administrador', '', 1);

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
-- Indices de la tabla `noticia_seccion`
--
ALTER TABLE `noticia_seccion`
  ADD PRIMARY KEY (`idseccion`),
  ADD KEY `idnoticia` (`idnoticia`);

--
-- Indices de la tabla `suscriptores`
--
ALTER TABLE `suscriptores`
  ADD PRIMARY KEY (`idsuscriptor`),
  ADD UNIQUE KEY `email` (`email`);

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
  MODIFY `idnoticia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `noticia_seccion`
--
ALTER TABLE `noticia_seccion`
  MODIFY `idseccion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=176;

--
-- AUTO_INCREMENT de la tabla `suscriptores`
--
ALTER TABLE `suscriptores`
  MODIFY `idsuscriptor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `noticia`
--
ALTER TABLE `noticia`
  ADD CONSTRAINT `fk_noticia_categoria` FOREIGN KEY (`idcategoria`) REFERENCES `categoria` (`idcategoria`),
  ADD CONSTRAINT `fk_noticia_usuario` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `noticia_seccion`
--
ALTER TABLE `noticia_seccion`
  ADD CONSTRAINT `noticia_seccion_ibfk_1` FOREIGN KEY (`idnoticia`) REFERENCES `noticia` (`idnoticia`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
