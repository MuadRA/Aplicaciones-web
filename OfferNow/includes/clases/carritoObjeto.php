<?php
require_once __DIR__.'/ofertaObjeto.php';
require_once RUTA_CLASES.'/productoObjeto.php';
require_once RUTA_CLASES.'/art2ManoObjeto.php';

class carritoObjeto{

    private $id;
    private $contador;
    private $usuario;
    private $productos;

    function __construct($userId) {
	    $this->usuario=$userId;
		$this->contador = 0;
        $this->contDeseos = 0;
        $this->productos = array();     
	}

    public static function listaDePedidos($userId){
        $app = aplicacion::getSingleton();
		$mysqli = $app->conexionBd(); 
        $consultaCarritoPedidos = sprintf("SELECT * FROM carrito WHERE  Comprado = 1 and idUsuario='%s'",
                    $mysqli->real_escape_string($userId));
        $result = $mysqli->query($consultaCarritoPedidos);
        $ListaPedidos;
        if(($result && $result->num_rows > 0)  ){
            for($i=0; $i < $result->num_rows; $i++){  
                $fila=$result->fetch_assoc();
                $producto = art2ManoObjeto::buscaArt2Mano($fila['idProducto']);
                $producto->agregarCantidad($fila['unidades']);
                $ListaPedidos[$i]=$producto;
            }
        }
        else{
            $ListaPedidos="vacia";
        }
        return $ListaPedidos;
    }

    // en caso de colocar 2 productos iguales y se quiera borrar  se va a seleccionar el primero
    // que encuentre
    public function CompruebaCantidadProducto($producto){
        $app = aplicacion::getSingleton();
		$mysqli = $app->conexionBd(); 
        $consultaCarritoCount = sprintf("SELECT COUNT(*) total FROM carrito WHERE idProducto=$producto and idUsuario='%s'",
                    $mysqli->real_escape_string($this->usuario));
           
        $result1 = $mysqli->query($consultaCarritoCount);
        $fila1=$result1->fetch_assoc();
        //agregar consulta  stock
        
        if($fila1['total']>0 ){
           return true;
        }
        else{
            return false;
        }

    }
    public function AgregarCarrito($producto,$cantidad) {   
        $app = aplicacion::getSingleton();
        $mysqli = $app->conexionBd(); 
        $sql;
        /*
        cantidad=0 -> inserto un nuevo producto
        cantidad=1 -> incremento en 1 las unidades del producto
        cantidad!=0 -> modifico con la cantidad adecuada
        */
        $cantidadesRestadas=0;
        if($cantidad===0){       
            $this->productos[$this->contador]=art2ManoObjeto::buscaArt2Mano($producto);
            $this->contador++;       
            $sql=" INSERT INTO carrito (idProducto,idUsuario,Comprado,unidades)
                        VALUES ('$producto','$this->usuario',0,1)";
         
        }
        elseif($cantidad===1){
            $consultaCarritoCount = sprintf("SELECT unidades FROM carrito
                        WHERE idProducto=$producto and idUsuario='%s'",
            $mysqli->real_escape_string($this->usuario));
            $result1 = $mysqli->query($consultaCarritoCount);
            $fila1=$result1->fetch_assoc();
            $cont=$fila1['unidades'];
            $cont=$cont+1;
            
            $sql=sprintf("UPDATE carrito SET unidades='$cont'
                        WHERE IdProducto='$producto'and idUsuario='%s'",
            $mysqli->real_escape_string($this->usuario));
            
        }
        else{
            $sql=sprintf("UPDATE carrito SET unidades='$cantidad'
            WHERE IdProducto='$producto'and idUsuario='%s'",
            $mysqli->real_escape_string($this->usuario));
          
            header("location:procesarCarrito.php");        
        }

        if (mysqli_query($mysqli, $sql)) {
          

            return true;
        } else {
            //echo "Error: " . $sql . "<br>" . mysqli_error($mysqli);
            return false;
        }
        //header("location:procesarCarrito.php");
    }
 
  
    public function eliminarCarrito($producto){
        $app = aplicacion::getSingleton();
        $mysqli = $app->conexionBd();
        
        $nombreUsuario = $_SESSION['correo'];
        $producto = $_POST["idProducto"];

        $sql = "DELETE FROM carrito WHERE idProducto = '$producto' AND idUsuario = '$nombreUsuario'"; // filtrar por usuario
        $this->contador--;

        if (mysqli_query($mysqli, $sql)) {
            return true;
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($mysqli);
            return false;
        }
    }

    public function precioTotal(){
        $precioTotal=0;
		if(is_array($this->productos)){	//Comprueba si es un array para no dar un error
			for($i = 0; $i < sizeof($this->productos); $i++){
                $unidades = carritoObjeto::getUnidadesProducto($this->productos[$i]->muestraID());
                $precio = $this->productos[$i]->muestraPrecio() * $unidades;
                $precioTotal +=$precio;
            }
		}
		return $precioTotal;     
    }

    public function cargarCarrito($idUser){
        $app = aplicacion::getSingleton();
		$mysqli = $app->conexionBd(); 
        $consultaCarritoCount = sprintf("SELECT COUNT(*) total FROM carrito WHERE Comprado = 0 AND
                    idUsuario='%s'", $mysqli->real_escape_string($idUser));
        $consultaCarrito = sprintf("SELECT * FROM carrito WHERE Comprado = 0 AND
                    idUsuario='%s'", $mysqli->real_escape_string($idUser));

        $result = $mysqli->query($consultaCarrito);
        $result1 = $mysqli->query($consultaCarritoCount);
        $fila1=$result1->fetch_assoc();
        if(($result && $result->num_rows >0) && $fila1['total']>0 ){
            $this->contador=$fila1['total'];
            for($i=0; $i < $result->num_rows; $i++){
                $fila=$result->fetch_assoc();
                $producto = art2ManoObjeto::buscaArt2Mano($fila['idProducto']);
                $this->productos[$i]=$producto;
            }
        }
        return $this->productos;
    }

    //-----------------------------------------------------Getters---------------------------------------------
    public function getCont(){
        return $this->contador;
    }

    public function getUsuario(){
        return $this->usuario;
    }

    public function getUnidades(){
        return $this->contador;
    }

    public function getProductos(){
        return $this->productos;
    }

    public static function getUnidadesProducto($idProducto){
        $app = aplicacion::getSingleton();
        $mysqli = $app->conexionBd();
        $unidades = $mysqli->query("SELECT unidades FROM carrito WHERE idProducto = $idProducto");
    
        $fila=$unidades->fetch_assoc();
        return $fila['unidades'];
    }
}
?>