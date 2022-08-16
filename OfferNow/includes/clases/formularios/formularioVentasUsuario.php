<?php

require_once RUTA_FORMS.'/form.php';
require_once RUTA_CLASES.'/posiblesVentasObjeto.php';

class formularioVentasUsuario extends form{

    public function __construct() {
        parent::__construct('formVentasUsuario');
    }

    protected function generaCamposFormulario($datos, $errores = array()){
        //Carga los productos en un array
        $ofertasArray = posiblesVentasObjeto::cargarPosiblesCompras("Numero");

        //Si hay peticiones de venta
        if($ofertasArray != null){
            $numOfertas = sizeof($ofertasArray);
            $mensaje = "<h5>Hay: $numOfertas ofertas, por favor selecciona si aceptas o rechazas esta oferta:</h5>";
        }else{
            $numOfertas = 0;
            $mensaje = "<h3> No hay posibles compras para ser validadas </h3>";
        }
        //Muestra el primer producto
        if($numOfertas > 0) {
            $id = $ofertasArray[0]->muestraID();
            $objString = $ofertasArray[0]->muestraPosibleCompraString();
            $html=<<<EOS
                <div class="rejilla">
                    <a>
                        <h2>¡¡¡Valida las solicitudes de compra de otros usuarios!!!</h2>
                        $mensaje
                        $objString
                        <input type="hidden" name="idVenta" value=$id>
                        <p><input type="radio" name="accion" value=true>Aceptar Oferta</p>
                        <p><input type="radio" name="accion" value=false>Rechazar Oferta</p>
                        <p><input type="checkbox" name="premium" value="false">¿Hacerlo Premium?</p>
                        <p><input type="submit" value="Gestionar peticion"></p>
                    </a>
                </div>
            EOS;
        }
        else{
            $html = $mensaje;
        }
        return $html;
    }

    protected function procesaFormulario($datos){
        $result = array();
        //Acepta la venta
        if(isset($datos["accion"]) && ($datos["accion"] == "true")){
            $id2Mano = htmlspecialchars(trim(strip_tags($_POST["idVenta"])));
            if(isset($_POST['premium'])){
                $esPremium = 1;
            }
            else{
                $esPremium = 0;
            }
            if(posiblesVentasObjeto::aceptaCompra($id2Mano, $esPremium)){
                $result = RUTA_APP.'/vistas/ventasUsuarioVista.php';
            } else {
                $result[]= "<h3>Error al aceptar el producto</h3>";
            }
        }
        //Deniega la venta
        else{
            $id2Mano = htmlspecialchars(trim(strip_tags($_POST["idVenta"])));
            if(posiblesVentasObjeto::rechazaCompra($id2Mano)){
                $result = RUTA_APP.'/ventasUsuarioVista.php';
            } else {
                $result[]= "<h3>Error al rechazar el producto</h3>";
            }
        }
        return $result;
    }

    protected function muestraResultadoCorrecto() {
        return "Producto gestionado correctamente";
    } 
}
?>