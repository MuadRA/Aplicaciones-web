<?php

require_once RUTA_FORMS.'/form.php';
require_once RUTA_USUARIO.'/usuarioBD.php';
require_once RUTA_USUARIO.'/usuarios.php';


class formularioPremium extends form{
    public function __construct() {
        parent::__construct('formPremium');
        $this->ok=false;
    }

    protected function generaCamposFormulario($datos, $errores = array()){
        $premium1 = RUTA_APP.'/imagenes/iconos/1mes.png';
        $premium2 = RUTA_APP.'/imagenes/iconos/3meses.png';
        $premium3 = RUTA_APP.'/imagenes/iconos/12meses.png';
   
        $html = <<<EOS
            <h1>¿QUIERES ENTERARTE DE LAS OFERTAS ANTES QUE NADIE?</h1>
            <h2>ESCOGE TU PACK: </h2>
            <div id="contenedor">
                <ul class="rejilla">
                    <li>
                        <img src="$premium1" class="logo" alt="logo"/>
                        <input type="submit" value="1 mes por 3 euros."></p>
                    </li>
                    <li>
                        <img src="$premium2" class="logo" alt="logo"/>
                        <input type="submit" value="3 meses por 7 euros."></p>
                    </li>
                    <li>
                        <img src="$premium3" class="logo" alt="logo"/>
                        <input type="submit" value="12 meses por 25 euros."></p>
                    </li>
                </ul>
            </div>
            EOS;
        return $html;
    }

    protected function procesaFormulario($datos){
        $result = array();
        if(isset($_SESSION["login"])){
            $nombreUsuario =$_SESSION['correo'];

            $this->ok=true;
            $user=usuario::buscaUsuario($nombreUsuario);
            $user->hacerPremium(); 
            $result= RUTA_APP.'/nuestraTienda.php';
        }
        else{
            $result=SESION.'/login.php';
        }
        return $result;
    }
    protected function muestraResultadoCorrecto() {
        if($this->ok){
            return "Importaremos de tu cuenta la cantidad. ¡Disfruta del contenido!";
        }
        else{
            return "no estas logeado";
        }
    }
}

?>