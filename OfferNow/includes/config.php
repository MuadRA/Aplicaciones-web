<?php
require_once __DIR__.'/aplicacion.php';
//DEFINES PARA EL SERVIDOR
/*
define('BD_HOST', 'vm13.db.swarm.test');
define('BD_NAME', 'aw_p2');
define('BD_USER', 'aw');
define('BD_PASS', 'aw');
define('RUTA_APP', '');	//Ruta del servidor
*/
// Varios defines para los parámetros de configuración de acceso a la BD y la URL desde la que se sirve la aplicación
//*
define('BD_HOST', 'localhost');
define('BD_NAME', 'aw_p2');
define('BD_USER', 'root');
define('BD_PASS', '');

//define('RUTA_APP', '/proyecto/practica4');	//Ruta de Luis
//define('RUTA_APP', '/OfferNow-practica4');			//Ruta de Jorge
//define('RUTA_APP', '/proyecto/OfferNow');	//Ruta de Olga
define('RUTA_APP', '/ProyectoFinal/OfferNow'); //Ruta Muad
//define('RUTA_APP', '/AW/OfferNow');	//Ruta de Pablo
//define('RUTA_APP', '/proyecto/OfferNow');
//*/

define('RUTA_IMGS', RUTA_APP.'/imagenes/productos');
define('RUTA_ICONOS', RUTA_APP.'/imagenes/iconos');
define('RUTA_CSS', RUTA_APP.'/css');
define('COMUN', RUTA_APP.'/includes/comun');
define('USUARIO', RUTA_APP.'/includes/usuario'); //ruta global para usuarios
define('PRODUCTOS', RUTA_APP.'/vistas'); //ruta global para productos
define('SESION', RUTA_APP.'/vistas'); //ruta global para login
define('POSTEAR', RUTA_APP.'/postear'); //ruta global para posts de objetos

define('RAIZ_APP', __DIR__.'/..');	                //Raiz de la aplicacion
define('ALMACEN', RAIZ_APP.'/imagenes/productos');  //Carpeta de subida de imagenes del usuario
define('RUTA_CLASES', RAIZ_APP.'/includes/clases');
define('RUTA_FORMS', RAIZ_APP.'/includes/clases/formularios');
define('RUTA_USUARIO', RAIZ_APP.'/includes/usuario');
define('RUTA_LAYOUT', RAIZ_APP.'/includes/comun');
define('RUTA_VISTAS', RAIZ_APP.'/vistas');

/* */
/* Configuración de Codificación */
/* */

ini_set('default_charset', 'UTF-8');
setLocale(LC_ALL, 'es_ES.UTF.8');

/* */
/* Funciones de gestión de la conexión a la BD */
/* */

$APP =aplicacion::getSingleton();
$APP->init(array('host'=>BD_HOST, 'bd'=>BD_NAME, 'user'=>BD_USER, 'pass'=>BD_PASS));
register_shutdown_function(array($APP, 'shutdown'));