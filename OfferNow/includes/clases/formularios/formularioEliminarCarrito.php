<?php

require_once RUTA_FORMS.'/form.php';
require_once RUTA_USUARIO.'/usuarioBD.php';
require_once RUTA_USUARIO.'/usuarios.php';


class formularioEliminarCarrito extends form{
    private $idProducto;
    public function __construct($id) {
        parent::__construct('formEliminarCarrito');
        $this->idProducto=$id;
        $this->ok=false;
    }

    protected function generaCamposFormulario($datos, $errores = array()){
        $html = <<<EOF
            <input type="hidden" name="idProducto" value="{$this->idProducto}"/>
            <input type="submit" value="eliminar producto"></p>
        EOF;
        return $html;
    }

    protected function procesaFormulario($datos){
        $result = array();
        if(isset($_SESSION["login"])){
            $nombreUsuario =$_SESSION['correo'];
            $this->ok=true;
            $idPro=$datos['idProducto'];
            $user=usuario::buscaUsuario($nombreUsuario);
            $user->quitarCarrito($idPro);   
        }
        else{
            $result=SESION.'/login.php';
        }
        return $result;
    }
    protected function muestraResultadoCorrecto() {
        if($this->ok){
            return "producto eliminado del carrito";
        }
        else{
            return "no estas logeado";
        } 
    }
}

?>