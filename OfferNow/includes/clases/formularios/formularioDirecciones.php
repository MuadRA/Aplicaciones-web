<?php

require_once RUTA_FORMS.'/form.php';
require_once RUTA_USUARIO.'/usuarioBD.php';
require_once RUTA_USUARIO.'/usuarios.php';

class formularioDirecciones extends form{

    public function __construct() {
        parent::__construct('formDirecciones');
    }

    protected function generaCamposFormulario($datos, $errores = array()){
   
        $nombreUsuario =$_SESSION['correo'];
        
        $user=usuario::buscaUsuario($nombreUsuario);
        
        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($errores);
        $errorDireccion = self::createMensajeError($errores, 'NuevaDir', 'span', array('class' => 'error'));
        $dir=$user->Direccion();
       
         
        /*mostrar el contenido previo*/
        $html = <<<EOF
        <div class="iniciosesion">
            <h2>TUS DIRECCIONES </h2>
            <p>
            <label>Nueva Direccion:</label> <input type="text" name="NuevaDir" value=$dir[0] />
            <label>Nº:</label> <input type="text" name="numero" value=$dir[1] />
            $errorDireccion
            </p>
            $htmlErroresGlobales
            <button type="submit" name="login">Cambiar</button>
        </div>
      
        EOF;
        return $html;
    }

    protected function procesaFormulario($datos){
        $result = array();
        
        $dir =$datos['NuevaDir'] ?? null;
        $numero =$datos['numero'] ?? null;
        
        if ( empty($dir) ) {
            $result['NuevaDir'] = "La direccion no puede estar vacia";
        }
        if ( empty($numero) ) {
            $result['numero'] = "El número no puede estar vacia";
        }
        
        if (count($result) === 0) {
            //se rompe al coloccar estas funciones que contienen el el codigo que viene abajo
            $nombreUsuario =$_SESSION['correo'];
            $user=usuario::buscaUsuario($nombreUsuario);
            $nuevaDireccion=$dir.','.$numero;
           
            if($user->cambiaDireccion($nuevaDireccion)){
                $result = RUTA_APP.'/perfil.php';
            }
            else{
                $result[]="no se ha podido cambiar la direccion";
            }        
        }
        return $result;
    }

    protected function muestraResultadoCorrecto() {
        return "La dirección se ha modificado correctamente";
    } 
}
?>