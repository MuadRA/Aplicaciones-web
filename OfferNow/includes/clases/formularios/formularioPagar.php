<?php
require_once RUTA_FORMS.'/form.php';
require_once RUTA_FORMS.'/formularioAniadirTarjeta.php';
require_once RUTA_USUARIO.'/usuarioBD.php';

class formularioPagar extends form{

    private $usuario;
    private $tarjetaNueva = false;

    public function __construct() {
        parent::__construct('formCarrito');
        $this->usuario = usuario::buscaUsuario($_SESSION['correo']);
    }

    protected function generaCamposFormulario($datos,$errores = array()){
        $htmlErroresGlobales = self::generaListaErroresGlobales($errores);
        $errorNumeroTarjeta = self::createMensajeError($errores, 'numeroTarjeta', 'span', array('class' => 'error'));
        $errorNombre = self::createMensajeError($errores, 'username', 'span', array('class' => 'error'));
        $errorPassword = self::createMensajeError($errores, 'password', 'span', array('class' => 'error'));
        $errorMetodoPago = self::createMensajeError($errores, 'metodoPago', 'span', array('class' => 'error'));
        $usu = $_SESSION["correo"];
        //Si tiene tarjeta se muestra y se da la opcion de pagar
        $tarjeta = $this->usuario->getTarjeta();
        if($tarjeta != false) {
            $html= <<<EOS
                <div class="iniciosesion">
                    <h1>Su tarjeta actual es:</h1>
                    <p>$tarjeta</p>
                    <p>$errorMetodoPago</p>
                    <p><input type="radio" name="tarjetaNueva" value=false>Usar tarjeta actual</p>
                    <p><input type="radio" name="tarjetaNueva" value=true>Usar nueva tarjeta</p>
                    <input type="submit" value="Pagar">
                </div>
            EOS;
        }
        //Sino obliga a poner una tarjeta
        else{
            $html= <<<EOS
                <h1>Debe crear una tarjeta:</h1>
                <input type="hidden" name="tarjetaNueva" value=true>
                <input type="submit" value="Crear">
            EOS;
        }
        return $html;
    }
    
    protected function procesaFormulario($datos){
        $result = array();
        if(isset($datos["tarjetaNueva"])){
            $this->tarjetaNueva = $datos["tarjetaNueva"];
            //Añade la nueva tarjeta
            if($this->tarjetaNueva == "true"){
                $result = SESION.'/aniadirTarjeta.php';
            }
            //Realiza el pago
            else{
                if(count($result) == 0){
                    //Lista de los productos en el carrito
                    $compras = $this->usuario->listarPedidosNoComprados();
                    $app = aplicacion::getSingleton();
                    $mysqli = $app->conexionBd();
                    //Obtengo el carrito del usuario
                    if(is_array($compras)) {
                        for ($i=0; $i < sizeof($compras); $i++) {
                            $idProducto = $compras[$i]->muestraID();
                            $unidadesCompradas = carritoObjeto::getUnidadesProducto($idProducto);
                            //Update de la tablla carrito poniendo el bit de comprado a true
                            $mysqli->query("UPDATE carrito SET Comprado = 1 WHERE idProducto = $idProducto");
                            //update de la tabla articulos_segunda_mano restando las unidades compradas
                            $mysqli->query("UPDATE articulos_segunda_mano SET Unidades = (Unidades-$unidadesCompradas)
                                        WHERE Numero = $idProducto");
                        }
                    }
                }
                $result = RUTA_APP.'/nuestraTienda.php';
            }
        }
        else{
            $result['metodoPago']  = "Tienes que seleccionar un metodo de pago.";
        }
        return $result;
    }
    protected function muestraResultadoCorrecto() { 
        if($this->tarjetaNueva == "true"){
            //Ha añadido una tarjeta nueva
            return false;
        }
        else{
            //Ha pagado
            return "GRACIAS POR LA COMPRA!";
        }
    }
}
?>