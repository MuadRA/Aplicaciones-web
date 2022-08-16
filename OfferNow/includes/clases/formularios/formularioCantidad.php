<?php

require_once RUTA_FORMS.'/form.php';
require_once RUTA_USUARIO.'/usuarioBD.php';
require_once RUTA_USUARIO.'/usuarios.php';
require_once RUTA_CLASES.'/carritoObjeto.php';

class formularioCantidad extends form{

    private $idProducto;
    private $cantidad;
    
    public function __construct($id,$cant) {
        parent::__construct('formCantidad');
        $this->idProducto=$id;
        $this->cantidad=$cant;
        $this->ok=false;
    }

    protected function generaCamposFormulario($datos, $errores = array()){
   
        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($errores);
        $errorCantidad = self::createMensajeError($errores, 'addCarrito', 'span', array('class' => 'error'));
       
        /*mostrar el contenido previo*/
        $html=<<<EOS
            <input type="hidden" name="idProducto" value="{$this->idProducto}" />
            <p>Total uds: <input type="number" name="cantidad" min="1" value="{$this->cantidad}"> 
            <input type="submit" value="Actualizar cantidad"> 
            </p>
            <p>$errorCantidad</p>
        EOS;
        return $html;
    }

    protected function procesaFormulario($datos){
        $result = array();
        if(isset($datos['cantidad']) && isset($_SESSION["login"])){       
            $cantidad = $datos['cantidad'] ?? '' ;
        
            $nombreUsuario =$_SESSION['correo'];
            $idProducto=$datos['idProducto'];
            $this->ok=true;
            //$result= RUTA_APP.'/nuestraTienda.php';
        
            $user=usuario::buscaUsuario($nombreUsuario); 
                
            //Comprueba que no se selcciona mas unidades de las que tenemos
           $stockActual = art2ManoObjeto::buscaUnidadesArticulo($idProducto);
            if($cantidad > $stockActual) {
                $result['addCarrito'] = "Has seleccionado mas unidades de las que tenemos en stock (".$stockActual.")";
            }
            else{
                $user=usuario::buscaUsuario($nombreUsuario);
                $user->addCarrito($idProducto,$cantidad);  
            }
        }
        else{
            $result=SESION.'/login.php';
        }
        return $result;
    }
    protected function muestraResultadoCorrecto() {
        if($this->ok){
            return "producto añadido al carrito";
        }
        else{
            return "no estas logeado";
        }
    }
}

?>
