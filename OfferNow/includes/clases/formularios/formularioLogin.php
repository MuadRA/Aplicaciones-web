<?php

require_once RUTA_FORMS.'/form.php';
require_once RUTA_USUARIO.'/usuarioBD.php';
require_once RUTA_USUARIO.'/usuarios.php';

class formularioLogin extends form{

    public function __construct() {
        parent::__construct('formLogin');
    }

    protected function generaCamposFormulario($datos, $errores = array()){
   
        $nombreUsuario =$datos['nombreUsuario'] ?? '';
        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($errores);
        $errorNombreUsuario = self::createMensajeError($errores, 'nombreUsuario', 'span', array('class' => 'error'));
        $errorPassword = self::createMensajeError($errores, 'password', 'span', array('class' => 'error'));
      
        $html = <<<EOF
            <div class="iniciosesion">
                <h1>Acceso al sistema</h1>
            
                <p><label>Correo:</label> <input type="text" name="nombreUsuario" 
                    value="$nombreUsuario"/>$errorNombreUsuario</p>
                <p><label>Password:</label> <input type="password" name="password" />$errorPassword</p>
                $htmlErroresGlobales
                <button type="submit" name="login">Entrar</button>
            </div>
        EOF;
        return $html;
    }

    protected function procesaFormulario($datos){
        $result = array();

        $nombreUsuario =$datos['nombreUsuario'] ?? null;
        if (empty($nombreUsuario) ) {
            $result['nombreUsuario'] = "El nombre de usuario no puede estar vacio";
        }
        
        $password = $datos['password'] ?? null;
        if (empty($password) ) {
            $result['password'] = "El password no puede estar vaci­o.";
        }
       
        if (count($result) === 0) {
            logout();
            $usuario = checkLogin(); 
            if(!$usuario) {
                // No se da pistas a un posible atacante
                $result[] = "El usuario o el password no coinciden";
            }
            else{
                $result = RUTA_APP.'/index.php';
            }
        }
        return $result;
    }

    protected function muestraResultadoCorrecto() {
        return "¡Usuario logueado con exito!";
    }
}
?>