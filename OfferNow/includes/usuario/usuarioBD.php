<?php

require_once __DIR__.'/../config.php';
require_once RUTA_CLASES.'/carritoObjeto.php';

class usuario{
	
	private $idCorreo;
	private $nombre;
	private $password;
  private $esAdministrador;
  private $esPremium;
  private $carrito;
  private $calle;

  function __construct($correo, $nombre,$Contrasenia,$calle){
    $this->idCorreo = $correo;
    $this->nombre = $nombre;
    $this->password = password_hash($Contrasenia, PASSWORD_DEFAULT);
    $this->esAdministrador=0;
    $this->esPremium=0;
    $this->calle = $calle;
    $this->carrito= new carritoObjeto($this->idCorreo);
  }

  //------------------------------------------Funciones estaticas//------------------------------------------
  public static function login($email, $password){
    $user = self::buscaUsuario($email);
   
    
    if ($user && $user->compruebaPassword($password)) {
      $app = aplicacion::getSingleton();
		  $conn = $app->conexionBd();
      //hacer consulta de premium y Administrador, si devuelve un 1 el usuario es Administradoristrador 
      $consultaEsAdministrador=sprintf("SELECT * FROM usuario WHERE Correo='%s'",
                                $conn->real_escape_string($email));			  
      $rs = $conn->query($consultaEsAdministrador);
      if ($rs){
        $fila1 = $rs->fetch_assoc();
     
        if($fila1['Administrador']==1){
         
          $user->esAdministrador();
        }
        if($fila1['Premium']==1){
        
          $user->esPremium();
        }
        $rs->free();
      } 
      return $user;
    }
    return false;
  }

  public static function buscaUsuario($email){ 
    $app = aplicacion::getSingleton();
    $conn = $app->conexionBd();
    $consultaUsuario = sprintf("SELECT * FROM usuario WHERE Correo='%s'", $conn->real_escape_string($email));
    
    $rs = $conn->query($consultaUsuario);
    if($rs && $rs->num_rows == 1){
      $fila = $rs->fetch_assoc();
  
      $user = new usuario($fila['Correo'], $fila['Nombre'],'',$fila['Direccion']);
      $user->setPass($fila['Contrasenia']);
      if($fila['Administrador']==1){
        $user->esAdministrador();
      }
      if($fila['Premium']==1){
        $user->esPremium();
      }
      $rs->free();
      return $user;
    }
    return false;
  }

	public static function altaNuevoUsuario($email,$username,$password1,$password2,$calle){
		if($password1 != $password2){
			return false;
		}
		else{
      //creo un objeto de tipo usuario para poder usarlo en caso de que el 
      //usuario quisiera seguir navegando y al mismo tiempo  guardo la Contrasenia encriptada

      $user = new usuario($email, $username,$password1,$calle);
      $correo=$user->idCorreo();
      $usuario=$user->nombre();
      $pass=$user->getContrasenia();
			
      //se filtra la informacion que se va a introducir en la BD:
      $app = aplicacion::getSingleton();
		  $mysqli = $app->conexionBd();
      
      $usuarioFiltrado=$mysqli->real_escape_string($username);
      $correoFiltrado=$mysqli->real_escape_string($correo);
      $passFiltrado=$mysqli->real_escape_string($pass);
      $calleAUX=$mysqli->real_escape_string($calle);
      $calleFiltrado=str_replace(' ', ',', $calleAUX);
			$sql="INSERT INTO usuario (Correo, Nombre,Contrasenia,Premium,Administrador,Direccion)
					VALUES ('$correoFiltrado','$usuarioFiltrado','$passFiltrado',0,0,'$calleFiltrado')";
			if (mysqli_query($mysqli, $sql)) {
				return true;
			} else {
				return false;
			}
		}
	}

//------------------------------------------Getters------------------------------------------
  public function esAdministrador(){
    $this->esAdministrador=1;
  }
  public function esPremium(){
     $this->esPremium=1;
  }
  public function getAdministrador(){
    return $this->esAdministrador;
  }
  public function getPremium(){
    return $this->esPremium;
  } 
  public function getContrasenia(){
    return $this->password;
  }
  
  public function idCorreo(){
    return $this->idCorreo;
  }
  public function Direccion(){
    return explode(",",$this->calle);
  }

  public function nombre(){
    return $this->nombre;
  }

  public function compruebaPassword($password)  {  
    return password_verify($password, $this->password);
  }
  public function setPass($pass){
    $this->password = $pass;
  }

  public function getTarjeta(){
    $app = aplicacion::getSingleton();
    $mysqli = $app->conexionBd();
    $query="SELECT tarjeta FROM usuario WHERE Correo='$this->idCorreo'";
    $result = $mysqli->query($query);	
		if($result) {
      $fila = $result->fetch_assoc();
      if($fila['tarjeta'] != 0){
        return $fila['tarjeta'];
      }
      else{
        return false;
      }
		}
		else{
			return false;
		}
  }

  //------------------------------------------Cambio atributos------------------------------------------
  public function cambiarNombre($nuevoNombe)  {
    $app = aplicacion::getSingleton();
    $mysqli = $app->conexionBd();
    $sql="UPDATE usuario SET Nombre='$nuevoNombe' WHERE Correo='$this->idCorreo'";
    if (mysqli_query($mysqli, $sql)) {
      $_SESSION["nombre"] = $nuevoNombe;
      $this->nombre = $nuevoNombe;
      return true;
    } else {
      return false;
    }
  }

  public function cambiaDireccion($nuevaDireccion)  {
    $this->calle = $nuevaDireccion;
    
    $app = aplicacion::getSingleton();
    $mysqli = $app->conexionBd();
    $sql="UPDATE usuario SET Direccion='$nuevaDireccion' WHERE Correo='$this->idCorreo'";
    if (mysqli_query($mysqli, $sql)) {
      return true;
    } else {
      return false;
    }
  }

  public function cambiaPassword($nuevoPassword)  {
    $this->password = password_hash($nuevoPassword, PASSWORD_DEFAULT);
    
    $app = aplicacion::getSingleton();
    $mysqli = $app->conexionBd();
    $sql="UPDATE usuario SET Contrasenia='$this->password' WHERE Correo='$this->idCorreo'";
    if (mysqli_query($mysqli, $sql)) {
      return true;
    } else {
      return false;
    }
  }

  public function hacerPremium(){
    $app = aplicacion::getSingleton();
    $mysqli = $app->conexionBd(); 
    $sql= "UPDATE usuario SET Premium = 1 WHERE Correo = '$this->idCorreo'";
    
    if (mysqli_query($mysqli, $sql)) {
    //$mysqli->close();
      $this->esPremium = 1;
      $_SESSION["esPremium"] = true;
      return true;
    } else {
        //$mysqli->close();
        //echo "Error: " . $sql . "<br>" . mysqli_error($mysqli);
        return false;
    }
  }

  public function altaNuevaTarjeta($numeroTarjeta){
    $app = aplicacion::getSingleton();
    $mysqli = $app->conexionBd();
    //se filtra la informacion que se va a introducir en la BD:

    $correo = $this->idCorreo;
    $numeroTarjetaFiltrado=$mysqli->real_escape_string($numeroTarjeta);
    $sql= "UPDATE usuario SET tarjeta ='$numeroTarjetaFiltrado' WHERE Correo = '$correo'";
    if (mysqli_query($mysqli, $sql)) {
      //$mysqli->close();
      return true;
    } else {
      //$mysqli->close();
      return false;
    }
  }

  //------------------------------------------Carrito usuario------------------------------------------
  public function listarPedidos(){
    $pedidos=carritoObjeto::listaDePedidos($this->idCorreo);
    return $pedidos;
  }

  public function listarPedidosNoComprados(){
    return $this->carrito->cargarCarrito($this->idCorreo);
  }

  public function precio(){
    return $this->carrito->precioTotal();
  }
  public function muestraCarrito(){
    $array=$this->carrito->cargarCarrito($this->idCorreo);
    return $array;
  }

  public function addCarrito($idProducto, $cantidad=1){
    //actualizo
    if(!$this->carrito->CompruebaCantidadProducto($idProducto) && $cantidad==0){
      $this->carrito->AgregarCarrito($idProducto,0);
    }
    elseif($this->carrito->CompruebaCantidadProducto($idProducto) && $cantidad==0){
      $this->carrito->AgregarCarrito($idProducto,1);
    }
    else{
      $this->carrito->AgregarCarrito($idProducto,$cantidad);
    }
  }

  public function quitarCarrito($idProducto){
    $this->carrito->eliminarCarrito($idProducto);
    header("location:procesarCarrito.php");
  }
}