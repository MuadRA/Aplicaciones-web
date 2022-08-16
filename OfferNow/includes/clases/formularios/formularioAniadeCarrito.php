<?php

require_once RUTA_FORMS.'/form.php';
require_once RUTA_USUARIO.'/usuarioBD.php';
require_once RUTA_USUARIO.'/usuarios.php';

class formularioAniadeCarrito extends form{
    private $idProducto;
    public function __construct($id) {
        parent::__construct('formAniadeCarrito');
        $this->idProducto=$id;
        $this->ok=false;
    }

    protected function generaCamposFormulario($datos, $errores = array()){
   
        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($errores);
        $errorDireccion = self::createMensajeError($errores, 'addCarrito', 'span', array('class' => 'error'));
        $errorCantidad = self::createMensajeError($errores, 'errorCantidad', 'span', array('class' => 'error'));
       
        /*mostrar el contenido previo*/
        $html = <<<EOF
            <input type="hidden" name="idProducto" value="{$this->idProducto}" />
            <div class="iniciosesion">
                <p><button type="submit" name="login">Añadir Carrito</button>$errorCantidad</p>
            </div>
        EOF;
        return $html;
    }

    protected function procesaFormulario($datos){
        $result = array();
        if(isset($datos['idProducto']) && estaLogado()){
            
            $idProducto = $datos['idProducto'] ?? '' ;
            $nombreUsuario =$_SESSION['correo'];
            $this->ok=true;
            
            $user=usuario::buscaUsuario($nombreUsuario);
            $app = aplicacion::getSingleton();
            //Comprueba la cantidad
            $stockActual = art2ManoObjeto::buscaUnidadesArticulo($idProducto);
            if($stockActual == "0") {
                $result['errorCantidad'] = "Error: No tenemos stock de este producto";
            }
            else{
                $user->addCarrito($idProducto,0);
                $result= RUTA_APP.'/nuestraTienda.php';
            }
        }
        else{
            $result = SESION.'/login.php';
        }
        return $result;
    }
    protected function muestraResultadoCorrecto() {
        if($this->ok){
            return "Producto añadido al carrito";
        }
        else{
            return "No estas logeado";
        }
    }
}
?>