<?php
require_once RUTA_FORMS.'/form.php';
require_once RUTA_USUARIO.'/usuarioBD.php';


class formularioRegistro extends form{

    public function __construct() {
        parent::__construct('formRegistro');
    }

    protected function generaCamposFormulario($datos,$errores = array()){
     
        $nombreUsuario = $datos['nombreUsuario'] ?? '';
        $nombre = $datos['nombre'] ?? '';

        $htmlErroresGlobales = self::generaListaErroresGlobales($errores);
        $errorNombreUsuario = self::createMensajeError($errores, 'email', 'span', array('class' => 'error'));
        $errorNombre = self::createMensajeError($errores, 'username', 'span', array('class' => 'error'));
        $errorCalle=self::createMensajeError($errores, 'calle', 'span', array('class' => 'error'));
        $errorPassword = self::createMensajeError($errores, 'password1', 'span', array('class' => 'error'));
        $errorPassword2 = self::createMensajeError($errores, 'password2', 'span', array('class' => 'error'));

        $html = <<<EOF
        <div class="iniciosesion">
            <h1>Registro de usuario</h1>
           
            <p><label> Usuario:  </label> <input type="text" name="username"/>$errorNombre</p>
       
            <p><label>E-mail:</label> <input type="text" name="email" />$errorNombreUsuario</p>
            <p><label>Direccion:</label> <input type="text" name="calle" />$errorCalle</p>
           
            <p><label>Contraseña:</label> <input type="password" name="password1" />$errorPassword</p>
            
             <p><label>Confirmar contraseña:</label> <input type="password" name="password2" />$errorPassword2</p>
             $htmlErroresGlobales
            <input type="checkbox" name="cb-terminosservicio" required> Acepto los términos del servicio<br>
            <input type="submit" value="crear">
        </div>
        EOF;
    
        return $html;
    }
    
    protected function procesaFormulario($datos){
        $result = array();
        
        $nombreUsuario = $datos['username'] ?? null;
        if (empty($nombreUsuario) || mb_strlen($nombreUsuario) < 5 ) {
            $result['username'] = "El nombre de usuario tiene que tener una longitud de al menos 5 caracteres.";
        }
        
        $correo = isset($datos["email"]) ? $datos["email"] : null;
        if (empty($correo) || mb_strlen($correo) < 5 ) {
            $result['email']  = "El nombre tiene que tener una longitud de al menos 5 caracteres.";
        }

        $calle = isset($datos["calle"]) ? $datos["calle"] : null;
        if (empty($calle)) {
            $result['calle']  = "el campo no puede estar vacio.";
        }
        
        $password1 = isset($datos["password1"]) ? $datos["password1"] : null;
        if (empty($password1) || mb_strlen($password1) < 5 ) {
            $result['password1'] = "El password tiene que tener una longitud de al menos 5 caracteres.";
        }
        $password2 = isset($datos['password2']) ? $datos['password2'] : null;
        if (empty($password2) || strcmp($password1, $password2) !== 0 ) {
            $result['password2'] = "Los passwords deben coincidir";
        }
      
        if (count($result) === 0) {
            if(usuario::altaNuevoUsuario($correo,$nombreUsuario,$password1,$password2,$calle)){
                $result ="Usuario registrado con exito!";
                $_SESSION['login'] = true;
                $_SESSION['nombre'] = $nombreUsuario;
                $_SESSION["correo"] = $correo;
                $_SESSION["esPremium"] = false;
                $_SESSION["esAdministrador"] = false;
                $result = RUTA_APP.'/index.php';
            }
            else{
                $result[]="¡Error en el registro!";
            }
        }
        return $result;
    }

    protected function muestraResultadoCorrecto() {
        return false;
    }
}
?>