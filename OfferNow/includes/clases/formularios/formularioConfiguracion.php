<?php

require_once RUTA_FORMS.'/form.php';
require_once RUTA_USUARIO.'/usuarioBD.php';
require_once RUTA_USUARIO.'/usuarios.php';

class formularioConfiguracion extends form{

    public function __construct() {
        parent::__construct('formConfiguracion');
    }

    protected function generaCamposFormulario($datos, $errores = array()){
   
        $nombreUsuario =$_SESSION['correo'];
        
        $user=usuario::buscaUsuario($nombreUsuario);
        $nombre=$user->nombre();
        $correo=$user->idCorreo();
        $calle= $user->Direccion();//str_replace(' ', '-nº', $user->Direccion());
        if($user->getPremium()){
            $esPremium="Eres premium";
        }
        else{
            $ruta = SESION.'/premium.php';
            $esPremium=<<<EOS
                Puedes serlo pinchando aqui <a href="$ruta">Hazte premium;</a>
            EOS;
        }
        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($errores);
        $errorDireccion = self::createMensajeError($errores, 'NuevoNombre', 'span', array('class' => 'error'));
        
        $errorPasswordOld = self::createMensajeError($errores, 'passwordOld', 'span', array('class' => 'error'));
        $errorPassword = self::createMensajeError($errores, 'password1', 'span', array('class' => 'error'));
        $errorPassword2 = self::createMensajeError($errores, 'password2', 'span', array('class' => 'error'));

        /*mostrar el contenido previo*/
        $html = <<<EOF
        <div class="iniciosesion">
            <h2>TUS DATOS </h2>
            <p><label>Nombre de usuario: </label><input type="text" name="NuevoNombre" value=$nombre /> $errorDireccion </p>  
            <p><label>Correo: </label> $correo</p>  
            <p>
            <label>Direccion: </label>$calle[0]  <label> Nº</label> $calle[1] 
            $errorDireccion
            </p> 
            <p><label>Rango: </label> $esPremium</p>  
            <p>CAMBIAR CONTRASEÑA</p>
            <p><label>Contraseña Antigua:</label> <input type="password" name="passwordOld" />$errorPasswordOld</p>
            <p><label>Contraseña:</label> <input type="password" name="password1" />$errorPassword</p>
            
            <p><label>Confirmar contraseña:</label> <input type="password" name="password2" />$errorPassword2</p>
            
            $htmlErroresGlobales
            <button type="submit" name="login">Cambiar</button>
        </div>
      
        EOF;
        return $html;
    }

    protected function procesaFormulario($datos){
        $result = array();
        
        $nuevoNombre =$datos['NuevoNombre'] ?? null;
        $OldPass=$datos['passwordOld'] ?? null;
        $changePass=false;
        if ( empty($nuevoNombre) ) {
            $result['NuevoNombre'] = "El campo correo no puede estar vacia";
        }
        if(!empty($OldPass)){
            $password1 = isset($datos["password1"]) ? $datos["password1"] : null;
            if ( empty($password1) || mb_strlen($password1) < 5 ) {
                $result['password1'] = "El password tiene que tener una longitud de al menos 5 caracteres.";
            }
            $password2 = isset($datos['password2']) ? $datos['password2'] : null;
            if ( empty($password2) || strcmp($password1, $password2) !== 0 ) {
                $result['password2'] = "Los passwords deben coincidir";
            }
            if (count($result) === 0) {
                $changePass=true;
            }
        }
        if (count($result) === 0) {
            $nombreUsuario = $_SESSION['correo'];
            $user=usuario::buscaUsuario($nombreUsuario);
            if($user->cambiarNombre($nuevoNombre)){
                if($changePass){
                    if($user->compruebaPassword($OldPass)) {
                        $user->cambiaPassword($password1);
                    }
                    else{
                        $result['passwordOld']="No valida";
                    }
                }
                $result = RUTA_APP.'/perfil.php';
            }
            else{
                $result[]="no se ha podido realizar cambios";
            }            
        }
        return $result;
    }

    protected function muestraResultadoCorrecto() {
        return "La configuración se ha modificado correctamente";
    } 
}
?>