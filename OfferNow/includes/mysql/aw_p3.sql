-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: vm13.db.swarm.test
-- Tiempo de generación: 14-05-2021 a las 16:27:06
-- Versión del servidor: 10.5.9-MariaDB-1:10.5.9+maria~focal
-- Versión de PHP: 7.4.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `aw_p2`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulos_segunda_mano`
--

CREATE TABLE `articulos_segunda_mano` (
  `Numero` int(32) NOT NULL,
  `Nombre` varchar(64) COLLATE utf8_spanish_ci NOT NULL,
  `Descripcion` varchar(1024) COLLATE utf8_spanish_ci NOT NULL,
  `Unidades` int(32) UNSIGNED NOT NULL,
  `Precio` int(32) UNSIGNED NOT NULL,
  `Imagen` varchar(128) COLLATE utf8_spanish_ci NOT NULL,
  `Premium` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `articulos_segunda_mano`
--

INSERT INTO `articulos_segunda_mano` (`Numero`, `Nombre`, `Descripcion`, `Unidades`, `Precio`, `Imagen`, `Premium`) VALUES
(4, 'Lavadora 2 mano', 'Con la lavadora Siemens obtendrás los mejores resultados en un abrir y cerrar de ojos. Resultados perfectos gracias a la mejor tecnología y a sus innovadoras funciones que no solo proporcionan resultados excepcionales en tu colada, sino que facilitan las tareas diarias. Olvida poner detergente y suavizante gracias a la autodosificación inteligente, consigue unos resultados perfectos para la colada diaria en menos de 1 hora con powerSpeed 59, pon la lavadora desde el trabajo con Home Connect y ahorra agua y electricidad gracias a la tecnología waterPerfect plus.', 2, 200, 'Lavadora_Siemens.jpg', 0),
(9, 'Uncharted 4', 'Tres años después de los hechos acaecidos en Uncharted 3: La traición de Drake, Nathan Drake ha dejado atrás la búsqueda de tesoros. Sin embargo, el destino no tarda en llamar a su puerta cuando su hermano Sam reaparece pidiéndole ayuda para salvar su vida, además de ofrecerle participar en una aventura ante la que Nathan no puede resistirse.', 32, 19, 'Uncharted4.jpg', 0),
(10, 'Pesas 2kg', 'Set de 2 pesas de vinilo de 2 kg perfectas para sus entrenamientos habituales.', 3, 15, 'Pesas.jpg', 0),
(11, 'Redmi Note 8T', 'El Xiaomi Redmi Note 8T es un smartphone Android con una pantalla Full HD+ de 6.3 pulgadas y potenciado por un procesador Snapdragon 665 de ocho núcleos, acompañado de 3GB de memoria RAM con 32GB de almacenamiento o 4GB de memoria RAM con opciones de 64GB o 128GB de almacenamiento interno.', 2, 189, 'Redmi_Note_8T.jpg', 1),
(12, 'Super Mario 3D World + Bowsers Fury', '¡Únete a Mario, Luigi, Peach y Toad en su misión para salvar el reino de las hadas en Super Mario 3D World + Bowser’s Fury para Nintendo Switch! Rescata a la princesa hada y a sus amigas, en solitario o con hasta 3 jugadores más, en esta versión mejorada de Super Mario 3D World. Y después, también en solitario o con un amigo, ayuda a Bowsy a devolver a su papi a la normalidad en una aventura totalmente nueva: ¡Bowsers Fury!', 5, 40, 'Super_Mario_3D_World.jpg', 1),
(13, 'BenQ_ZOWIE_XL2411K Monitor', 'La nueva generación de monitores de PC para e-sports de la serie XL aumenta aún más la flexibilidad y precisión de ajuste, así como la comodidad de los jugadores, lo que les permite centrarse en su rendimiento en el juego, con 144hz una base mas pequeña y un ajuste fluido y flexible incluyendo la nueva tecnología DyAc', 3, 279, 'monitorbenq.jpg', 0),
(14, 'Seagate Expansion 2 4TB USB 3', 'Las unidades portátiles Expansion de Seagate son compactas y perfectas para un estilo de vida activo. Añada más espacio de almacenamiento instantáneamente a su equipo, y lleve sus archivos de gran tamaño a cualquier parte con este disco duro portátil de 2.5\" y una capacidad de 4TB.', 5, 95, 'usb4tb.jpg', 1),
(25, 'Television LG 32LM6370PLA 32 pulgadas LED FullHD', 'Televisor 32LM6370PLA de LG, su pantalla Full HD ofrece imágenes precisas con una resolución extraordinaria y colores ricos. Estado bueno con un rasguño en la parte superior', 41, 278, 'televisionLG.jpg', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito`
--

CREATE TABLE `carrito` (
  `id` int(32) NOT NULL,
  `idProducto` int(32) NOT NULL,
  `idUsuario` varchar(32) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentariosoferta`
--

CREATE TABLE `comentariosoferta` (
  `ID` int(32) NOT NULL,
  `Texto` varchar(512) COLLATE utf8_spanish_ci NOT NULL,
  `Titulo` varchar(64) COLLATE utf8_spanish_ci NOT NULL,
  `ValoracionUtilidad` int(32) NOT NULL,
  `UsuarioID` varchar(32) COLLATE utf8_spanish_ci NOT NULL,
  `OfertaID` int(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `comentariosoferta`
--

INSERT INTO `comentariosoferta` (`ID`, `Texto`, `Titulo`, `ValoracionUtilidad`, `UsuarioID`, `OfertaID`) VALUES
(9, 'Ratón ergonómico aunque muy pequeño pero con buen reconocimiento', 'Muy buen raton', 0, 'admin@admin.com', 2453),
(10, 'Tenía dolores de espalda, pero con esta silla estoy mucho mejor, su diseño ergonómico es de lo mejor para largas horas jugando/trabajando/estudiando', 'Muy comoda la silla', 0, 'muad_ra@gmail.com', 2451),
(11, 'ratón inalámbrico se adapta perfectamente a tu mano y obtienes una gran velocidad y facilidad al moverlo... Lo recomiendo', 'Buen diseño', 0, 'muad_ra@gmail.com', 2453);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentariossegundamano`
--

CREATE TABLE `comentariossegundamano` (
  `ID` int(32) NOT NULL,
  `Texto` varchar(512) COLLATE utf8_spanish_ci NOT NULL,
  `Titulo` varchar(64) COLLATE utf8_spanish_ci NOT NULL,
  `ValoracionUtilidad` int(32) NOT NULL,
  `UsuarioID` varchar(32) COLLATE utf8_spanish_ci NOT NULL,
  `SegundaManoID` int(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `comentariossegundamano`
--

INSERT INTO `comentariossegundamano` (`ID`, `Texto`, `Titulo`, `ValoracionUtilidad`, `UsuarioID`, `SegundaManoID`) VALUES
(8, 'Excelente juego, da muchas horas de diversion', 'Muy buen juego!', 0, 'luis@gmail.com', 12),
(9, 'Las cogí con el miedo de estar en un mal estado como suele pasar con los artículos de segunda mano pero para mi sorpresa estaban en muy buenas condiciones', 'Buen estado', 0, 'muad_ra@gmail.com', 10),
(10, 'Estos USB 3.0 que se usan de disco duro no suelen tener una gran velocidad, pero este es todo lo contrario me ha gustado mucho', 'Muy veloz', 0, 'muad_ra@gmail.com', 14),
(11, 'estaba buscando un sitio donde encontrarlo más barato y aquí lo conseguí al igual con el estado del producto muy satisfecho', 'Bueno juego y en buen estado', 0, 'muad_ra@gmail.com', 12);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oferta`
--

CREATE TABLE `oferta` (
  `Numero` int(32) NOT NULL,
  `Nombre` varchar(52) COLLATE utf8_spanish_ci NOT NULL,
  `Descripcion` varchar(1024) COLLATE utf8_spanish_ci NOT NULL,
  `URL_Oferta` varchar(512) COLLATE utf8_spanish_ci NOT NULL,
  `URL_Imagen` varchar(512) COLLATE utf8_spanish_ci NOT NULL,
  `Valoracion` int(32) UNSIGNED NOT NULL,
  `Precio` int(32) UNSIGNED NOT NULL,
  `Creador` varchar(32) COLLATE utf8_spanish_ci NOT NULL,
  `Premium` tinyint(1) NOT NULL DEFAULT 0,
  `segundaMano` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `oferta`
--

INSERT INTO `oferta` (`Numero`, `Nombre`, `Descripcion`, `URL_Oferta`, `URL_Imagen`, `Valoracion`, `Precio`, `Creador`, `Premium`, `segundaMano`) VALUES
(2443, 'Nevera Samsung 1000', 'Nevera Samsung, Entrega e Instalación Gratuita, 100 dias de prueba y TV Samsung de Regalo, Tecnología SpaceMax, Metal Cooling, Balda Plegable, Compresor Digital Inverter', 'https://www.samsung.com/es/refrigerators/bottom-mount-freezer/385l-black-doi-rb38t776cb1-ef/', 'nevera.png', 920, 637, 'admin@admin.com', 0, 0),
(2444, 'Intel Core I7', 'El Core i7-10700K es un procesador de 8 núcleos y 16 hilos de proceso gracias a la tecnología HyperThreading de la marca, con una velocidad base de 3,8 GHz pero que aumenta hasta 5,1 GHz en modo Turbo. Cuenta con 16 MB Smart Cache de Intel, y su TDP es de 125 vatios (con descenso de TDP configurable a 95W)', 'https://www.amazon.es/Intel-Core-i7-10700K-Procesador-Casquillo/dp/B0883P8CNM/ref=sr_1_3?__mk_es_ES=%C3%85M%C3%85%C5%BD%C3%95%C3%91&dchild=1&keywords=intel-core-i7-10700k-380-ghz&qid=1621008996&sr=8-3', 'Intel.png', 760, 313, 'luis@gmail.com', 1, 0),
(2449, 'Willful Smartwatch', 'El Willful Smartwatch tiene una pantalla TFT táctil de 1,3 pulgadas. Con un giro de muñeca se activa la pantalla sin necesidad de tocarla. Dispones de tres niveles de brillo para adaptarte a diferentes intensidades de luz. Su batería te proporciona una autonomía de hasta 7 días con un tiempo de carga de 2,5 horas.', 'https://www.ebay.es/itm/174513466795?_trkparms=aid%3D1110006%26algo%3DHOMESPLICE.SIM%26ao%3D1%26asc%3D20200818143230%26meid%3D611e8a4b66404ead87ad97d6aff37794%26pid%3D101224%26rk%3D2%26rkt%3D5%26sd%3D293686484016%26itm%3D174513466795%26pmt%3D0%26noa%3D1%26pg%3D2047675%26algv%3DDefaultOrganic&_trksid=p2047675.c101224.m-1', 'reloj.png', 420, 55, 'admin@admin.com', 0, 0),
(2450, 'Monopoly para malos perdedores', 'Este toque divertido al juego Monopoly cambia el sentido de la palabra “perder” y lo celebra. Los jugadores pueden ganar dinero en efectivo al hacer cosas que, por lo general, generan frustración en el juego, como ir a la Cárcel, pagar el alquiler de una propiedad o entrar en bancarrota.', 'https://www.amazon.es/Monopoly-Malos-Perdedores-Hasbro-E9972105/dp/B085LZPKJN/ref=asc_df_B085LZPKJN/?tag=googshopes-21&linkCode=df0&hvadid=469243523727&hvpos=&hvnetw=g&hvrand=6946940141870944332&hvpone=&hvptwo=&hvqmt=&hvdev=c&hvdvcmdl=&hvlocint=&hvlocphy=9061040&hvtargid=pla-977351439750&psc=1', 'monopoly.png', 259, 24, 'pablo@gmail.com', 1, 0),
(2451, 'Silla gaming', 'La silla de diseño Racing, Stinger Station Alien está creada para que disfrutes al máximo de una experiencia envolvente y confortable en tus largas e intensas sesiones de juegos y también en tus jornadas de trabajo o estudios. Podrás disfrutar de un diseño deportivo y ergonómico, fabricado en materiales de máxima calidad, muy duraderos, suaves y acolchados que duplican su confort. La serie ALIEN se define por su estética racing, su diseño \"de otra galaxia\" y su máxima calidad en la configuración de sus materiales.', 'https://www.pccomponentes.com/woxter-stinger-station-alien-silla-gaming-blue', 'sillagaming.jpg', 211, 109, 'paco@gmail.com', 0, 0),
(2452, 'Logitech Stereo Speakers Z120', 'Te presentamos los Logitech Stereo Speakers Z120, unos compactos altavoces USB con controles de volumen y encendido integrados facilitan la conexión de casi cualquier fuente de audio. Para que pueda disfrutar fácilmente de la música, el vídeo, etc. que prefiera. Estos altavoces compactos y versátiles son fáciles de conectar y controlar.', 'https://www.pccomponentes.com/logitech-stereo-speakers-z120', 'altavoceslogitech.jpg', 158, 15, 'luis@gmail.com', 0, 0),
(2453, 'Logitech M705 Raton Inalambrico', 'El ratón Logitech Marathon Mouse M705 dura... y dura... y dura. Usa mucha menos energía que los ratones inalámbricos comparables de otras empresas, por lo que pueden pasar hasta tres años sin tener que cambiar las pilas. Además, cuenta con un receptor inalámbrico minúsculo que está acoplado permanentemente al ordenador, para que el ratón siempre esté listo para funcionar, en cualquier momento, en cualquier lugar y durante el tiempo necesario. Asimismo, el desplazamiento superrápido te permitirá desplazarte a gran velocidad por documentos largos para buscar lo que necesites sin pérdida de tiempo. El seguimiento láser ofrece un control preciso y uniforme del cursor. Y el diseño contorneado del ratón para la mano derecha resulta cómodo de principio a fin de la sesión.', 'https://www.pccomponentes.com/logitech-m705-marathon-mouse-raton-inalambrico-1000-dpi', 'raton.jpg', 80, 38, 'admin@admin.com', 0, 0),
(2454, 'Television LG 32LM6370PLA 32 pulgadas LED FullHD', 'Nuevo televisor 32LM6370PLA de LG, su pantalla Full HD ofrece imágenes precisas con una resolución extraordinaria y colores ricos.', 'https://www.pccomponentes.com/lg-32lm6370pla-32-led-fullhd-hdr10', 'televisionLG.jpg', 41, 278, 'pablo@gmail.com', 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `posiblescompras`
--

CREATE TABLE `posiblescompras` (
  `Numero` int(32) NOT NULL,
  `Nombre` varchar(64) COLLATE utf8_spanish_ci NOT NULL,
  `Descripcion` varchar(128) COLLATE utf8_spanish_ci NOT NULL,
  `Unidades` int(32) UNSIGNED NOT NULL,
  `Precio` int(32) UNSIGNED NOT NULL,
  `Imagen` varchar(128) COLLATE utf8_spanish_ci NOT NULL,
  `UsuarioVendedor` varchar(32) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `Correo` varchar(32) COLLATE utf8_spanish_ci NOT NULL,
  `Nombre` varchar(32) COLLATE utf8_spanish_ci NOT NULL,
  `Contraseña` varchar(64) COLLATE utf8_spanish_ci NOT NULL,
  `Premium` tinyint(1) NOT NULL DEFAULT 0,
  `Admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`Correo`, `Nombre`, `Contraseña`, `Premium`, `Admin`) VALUES
('admin@admin.com', 'Admin1', '$2y$10$Lg9eC/a5y6EG4ImYqlX6WeHyE/03UGW6SUE8qD3nUHAbvZhmgIT5y', 1, 1),
('luis@gmail.com', 'Luis Premium', '$2y$10$HDRa/.8XW/ZCh3I0VpOHI.CEm1XQaC5SN1q/IgIbF6hcqyIRp1iOi', 1, 0),
('luisRoman', 'luisRoman', '$2y$10$pTSRPIxFTVwuCPFJnIP1zu103rs9gZWzBfie2P/dtmwiSFHlxSANm', 1, 1),
('muad_ra@gmail.com', 'muadRoh', '$2y$10$IhGouHLvmS3KiG/XmGs9cef54.I.FzyaRtzwSE/2OUojaHFIv2/cu', 0, 0),
('pablo@gmail.com', 'Pablo', '$2y$10$AfE.i.LSxEUL3KZ9iyhn/OzgW1u.qtYDf8k159zoNAJ6gCPgEXn2.', 0, 0),
('paco@gmail.com', 'Paco Admin', '$2y$10$4UcIO5u2Mu91/cNpV5QOw.U3PIP1czSl53eYsLtRJt8NnhZS0ekMu', 0, 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `articulos_segunda_mano`
--
ALTER TABLE `articulos_segunda_mano`
  ADD PRIMARY KEY (`Numero`);

--
-- Indices de la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idProducto` (`idProducto`),
  ADD KEY `idUsuario` (`idUsuario`);

--
-- Indices de la tabla `comentariosoferta`
--
ALTER TABLE `comentariosoferta`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `OfertaID` (`OfertaID`),
  ADD KEY `CreadorID` (`UsuarioID`);

--
-- Indices de la tabla `comentariossegundamano`
--
ALTER TABLE `comentariossegundamano`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Creador` (`UsuarioID`),
  ADD KEY `SegundaManoID` (`SegundaManoID`);

--
-- Indices de la tabla `oferta`
--
ALTER TABLE `oferta`
  ADD PRIMARY KEY (`Numero`),
  ADD KEY `Nombre` (`Nombre`),
  ADD KEY `Creador` (`Creador`);

--
-- Indices de la tabla `posiblescompras`
--
ALTER TABLE `posiblescompras`
  ADD PRIMARY KEY (`Numero`),
  ADD KEY `usuarioVendedor` (`UsuarioVendedor`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`Correo`),
  ADD KEY `Nombre` (`Nombre`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `articulos_segunda_mano`
--
ALTER TABLE `articulos_segunda_mano`
  MODIFY `Numero` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `carrito`
--
ALTER TABLE `carrito`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `comentariosoferta`
--
ALTER TABLE `comentariosoferta`
  MODIFY `ID` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `comentariossegundamano`
--
ALTER TABLE `comentariossegundamano`
  MODIFY `ID` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `oferta`
--
ALTER TABLE `oferta`
  MODIFY `Numero` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2579;

--
-- AUTO_INCREMENT de la tabla `posiblescompras`
--
ALTER TABLE `posiblescompras`
  MODIFY `Numero` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD CONSTRAINT `carrito_ibfk_1` FOREIGN KEY (`idProducto`) REFERENCES `articulos_segunda_mano` (`Numero`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `carrito_ibfk_2` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`Correo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `comentariosoferta`
--
ALTER TABLE `comentariosoferta`
  ADD CONSTRAINT `comentariosoferta_ibfk_1` FOREIGN KEY (`OfertaID`) REFERENCES `oferta` (`Numero`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comentariosoferta_ibfk_2` FOREIGN KEY (`UsuarioID`) REFERENCES `usuario` (`Correo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `comentariossegundamano`
--
ALTER TABLE `comentariossegundamano`
  ADD CONSTRAINT `comentariossegundamano_ibfk_1` FOREIGN KEY (`SegundaManoID`) REFERENCES `articulos_segunda_mano` (`Numero`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comentariossegundamano_ibfk_2` FOREIGN KEY (`UsuarioID`) REFERENCES `usuario` (`Correo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `oferta`
--
ALTER TABLE `oferta`
  ADD CONSTRAINT `oferta_ibfk_1` FOREIGN KEY (`Creador`) REFERENCES `usuario` (`Correo`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `posiblescompras`
--
ALTER TABLE `posiblescompras`
  ADD CONSTRAINT `posiblescompras_ibfk_1` FOREIGN KEY (`UsuarioVendedor`) REFERENCES `usuario` (`Correo`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
