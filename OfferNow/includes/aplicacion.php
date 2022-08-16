<?php

/**
 * Clase que mantiene el estado global de la aplicación.
 */
class aplicacion
{
	private static $instancia;
	
	/**
	 * Permite obtener una instancia de <code>Aplicacion</code>.
	 * 
	 * @return aplicacion Obtiene la única instancia de la <code>Aplicacion</code>
	 */
	public static function getSingleton() {
		if (  !self::$instancia instanceof self) {
			self::$instancia = new self;
		}
		return self::$instancia;
	}

	/**
	 * @var array Almacena los datos de configuración de la BD
	 */
	private $bdDatosConexion;
	
	/**
	 * Almacena si la Aplicacion ya ha sido inicializada.
	 * 
	 * @var boolean
	 */
	private $inicializada = false;
	
	/**
	 * @var \mysqli Conexión de BD.
	 */
	private $conn;
	
	/**
	 * Evita que se pueda instanciar la clase directamente.
	 */
	private function __construct() {
	}
	
	/**
	 * Evita que se pueda utilizar el operador clone.
	 */
	public function __clone(){
		throw new Exception('No tiene sentido el clonado');
	}
	/**
	 * Evita que se pueda utilizar serialize().
	 */
	public function __sleep()
	{
		throw new Exception('No tiene sentido el serializar el objeto');
	}

	/**
	 * Evita que se pueda utilizar unserialize().
	 */
	public function __wakeup()
	{
		throw new Exception('No tiene sentido el deserializar el objeto');
	}
	
	/**
	 * Inicializa la aplicación.
	 * 
	 * @param array $bdDatosConexion datos de configuración de la BD
	 */
	public function init($bdDatosConexion)
	{
        if ( ! $this->inicializada ) {
    	    $this->bdDatosConexion = $bdDatosConexion;
    		session_start();
    		$this->inicializada = true;
        }
	}
	
	/**
	 * Cierre de la aplicación.
	 */
	public function shutdown()
	{
	    $this->compruebaInstanciaInicializada();
	    if ($this->conn !== null) {
	        $this->conn->close();
	    }
	}
	
	/**
	 * Comprueba si la aplicación está inicializada. Si no lo está muestra un mensaje y termina la ejecución.
	 */
	private function compruebaInstanciaInicializada()
	{
	    if (! $this->inicializada ) {
	        echo "Aplicacion no inicializa";
	        exit();
	    }
	}
	
	/**
	 * Devuelve una conexión a la BD. Se encarga de que exista como mucho una conexión a la BD por petición.
	 * 
	 * @return \mysqli Conexión a MySQL.
	 */
	public function conexionBd()
	{
	    $this->compruebaInstanciaInicializada();
		if (! $this->conn ) {
			$bdHost = $this->bdDatosConexion['host'];
			$bdUser = $this->bdDatosConexion['user'];
			$bdPass = $this->bdDatosConexion['pass'];
			$bd = $this->bdDatosConexion['bd'];
			
			$this->conn = new \mysqli($bdHost, $bdUser, $bdPass, $bd);
			if ( $this->conn->connect_errno ) {
				echo "Error de conexión a la BD: (" . $this->conn->connect_errno . ") " . utf8_encode($this->conn->connect_error);
				exit();
			}
			if ( ! $this->conn->set_charset("utf8mb4")) {
				echo "Error al configurar la codificación de la BD: (" . $this->conn->errno . ") " . utf8_encode($this->conn->error);
				exit();
			}
		}
		return $this->conn;
	}

	/**
	 * Hace las comprobaciones para ver si el fichero subido es una imagen y la guarda en la ruta
	 * El parametro $carpetaImgDir debe ser la subcarpeta dentro de la ruta RUTA_IMGS, ej:
	 * 		"/ofertas/"
	 */

	private static function comprobarExtensionArchivo($filename){
        $extensionesValidas = array('jpg', 'gif', 'png', 'jpeg');

        $end = explode(".", $filename);
        $extensionImagen = strtolower(end($end));
        if (in_array($extensionImagen, $extensionesValidas)) {
            return true;
        } else {
            return false;
        }
    }

    private static function comprobarNombreArchivo($filename) {
        return (bool) ((mb_ereg_match('/^[0-9A-Z-_\.]+$/i',$filename) === 1) ? true : false );
    }

    private static function comprobarLongitudArchivo($filename) {
        return (bool) ((mb_strlen($filename,'UTF-8') < 250) ? true : false);
    }

    private static function quitarCaracteresInvalidos($filename) {
		$newName = mb_ereg_replace('([^A-Za-z0-9.])', '_', $filename);
        $newName = mb_ereg_replace("([\.]{2,})", '', $newName);
        return $newName;
    }

	public static function comprobarImagen($carpetaArchivoDir){
        //Comprueba la extension del archivo
        if (//aplicacion::comprobarNombreArchivo($nuevoNombre) &&
			//aplicacion::comprobarLongitudArchivo($nuevoNombre) &&
            aplicacion::comprobarExtensionArchivo($_FILES["productoImagen"]["name"])) {
			
			$tmp_name = $_FILES['productoImagen']['tmp_name'];
			$nuevoNombre = aplicacion::quitarCaracteresInvalidos($_FILES["productoImagen"]["name"]);
			
            $directorioServerArchivo = ALMACEN.$carpetaArchivoDir.$nuevoNombre;
            //Si la extension es correcta comprueba que el fichero no exista
            if(!file_exists($directorioServerArchivo)) {
                if (move_uploaded_file($tmp_name, $directorioServerArchivo)) {
                    return $nuevoNombre;
                } else {
                    return false;
                }
            } else {
                //El fichero existe por lo que no se copia y se devuelve el nuevo nombre
                return $nuevoNombre;
            }
        } else {
            return false;
        }       
    }
}