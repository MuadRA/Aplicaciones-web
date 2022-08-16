<?php
require_once RUTA_FORMS.'/form.php';
require_once RUTA_USUARIO.'/usuarioBD.php';

class formularioAniadirTarjeta extends form{

    private $usuario;

    public function __construct() {
        parent::__construct('formCarrito');
        $this->usuario = usuario::buscaUsuario($_SESSION['correo']);
    }

    protected function generaCamposFormulario($datos,$errores = array()){
        $htmlErroresGlobales = self::generaListaErroresGlobales($errores);
        $errorNumeroTarjeta = self::createMensajeError($errores, 'numeroTarjeta', 'span', array('class' => 'error'));
        $errorNombre = self::createMensajeError($errores, 'username', 'span', array('class' => 'error'));
        $errorPassword = self::createMensajeError($errores, 'password', 'span', array('class' => 'error'));

        $tarjeta = $this->usuario->getTarjeta();
        if($tarjeta != false) {
            $tarjeta = "<h1>Actualmente su tarjeta es:</h1><p>".$tarjeta."</p>";
        }
        else{
            $tarjeta = "<h1>Actualmente no tiene tarjeta</h1>";
        }
        $html = <<<EOF
        <div class="iniciosesion">
            $tarjeta
            <h1>Crear nueva tarjeta:</h1>
            <p><label>Numero de tarjeta:  </label> <input type="number" name="numeroTarjeta"/>$errorNumeroTarjeta</p>
            <p><label>Titular:</label> <input type="text" name="username" />$errorNombre</p>
            <p><label>Codigo C/V:</label> <input type="password" name="password" />$errorPassword</p>
            $htmlErroresGlobales
            <input type="checkbox" name="cb-terminosservicio" required> Acepto los términos del servicio<br>
            <input type="submit" value="Actualizar tarjeta">
        </div>
        EOF;
    
        return $html;
    }
    
    protected function procesaFormulario($datos){
        $result = array();
        $numeroTarjeta = $datos['numeroTarjeta'] ?? '';
        //$nombre = $datos['nombre'] ?? '';
        $nombreUsuario = $datos['username'] ?? null;
        
        if (empty($numeroTarjeta) || mb_strlen($numeroTarjeta) != 16 ) {
            $result['numeroTarjeta'] = "El numero de la tarjeta debe que tener 16 caracteres.";
        }
        
        $titular = isset($datos["username"]) ? $datos["username"] : null;
        if (empty($titular)) {
            $result['username']  = "Tienes que poner un titular.";
        }

        $codigo = isset($datos["password"]) ? $datos["password"] : null;
        if ( empty($codigo) || mb_strlen($codigo) != 3 ) {
            $result['password'] = "El password tiene que tener una longitud de 3 caracteres.";
        }

        if(count($result) == 0){
            $usuario = usuario::buscaUsuario($_SESSION['correo']);
            if($usuario->altaNuevaTarjeta($numeroTarjeta)){
                $result = RUTA_APP.'/nuestraTienda.php';
            }
            else{
                $result[] = "Error";
            }
        }
        return $result;
    }
     protected function muestraResultadoCorrecto() {
        return "Tarjeta actualizada con exito, ya puede pagar si lo desea";
    }
}
?>