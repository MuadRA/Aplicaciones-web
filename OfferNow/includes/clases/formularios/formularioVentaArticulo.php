<?php

require_once RUTA_FORMS.'/form.php';
require_once RUTA_CLASES.'/posiblesVentasObjeto.php';

class formularioVentaArticulo extends form{

    public function __construct() {
        parent::__construct('formVentaArticulo');
    }

    protected function generaCamposFormulario($datos, $errores = array()){
        $htmlErroresGlobales = self::generaListaErroresGlobales($errores);
        $errorImagen = self::createMensajeError($errores, 'errorImagen', 'span', array('class' => 'error'));
        $errorNombre = self::createMensajeError($errores, 'errorNombre', 'span', array('class' => 'error'));
        $errorDescripcion = self::createMensajeError($errores, 'errorDescripcion', 'span', array('class' => 'error'));
        $errorPrecio = self::createMensajeError($errores, 'errorPrecio', 'span', array('class' => 'error'));
        $errorUnidades = self::createMensajeError($errores, 'errorUnidades', 'span', array('class' => 'error'));

        $html = <<<EOF
            <div class="subirOferta">
            <div class="producto">
                <h1>Vender Articulo</h1>
                    <p>Nombre Articulo:$errorNombre</p>
                    <input type="text" name="articuloNombre"/>
                    <p>Descripción:$errorDescripcion</p>
                    <textarea name="articuloDescripcion" rows="10" cols="30"></textarea>
                    <p>Precio de venta:$errorPrecio</p>
                    <input type="number" name="articuloPrecio"  />
                    <p>Nº Unidades:$errorUnidades</p>
                    <input type="number" name="articuloUnidades"/>
                    <p>Imagen: $errorImagen</p>
                    <input type="file" name="productoImagen"/>
                    <p><input type="submit" value="Publicar"></p>
            </div>
            </div>
        EOF;
        return $html;
    }

    protected function procesaFormulario($datos){
        $result = array();

        $nombre = htmlspecialchars(trim(strip_tags($_POST["articuloNombre"])));
        $descripcion = htmlspecialchars(trim(strip_tags($_POST["articuloDescripcion"])));
        $precio = htmlspecialchars(trim(strip_tags($_POST["articuloPrecio"])));
        $unidades = htmlspecialchars(trim(strip_tags($_POST["articuloUnidades"])));
        //$imagen = htmlspecialchars(trim(strip_tags($_POST["productoImagen"])));
        $usuario = $_SESSION["correo"];
        if(empty($nombre)){
            $result['errorNombre']= "Error: especifica un nombre";
        }
        if(empty($descripcion)){
            $result['errorDescripcion']= "Error: especifica una descripcion";
        }
        if(empty($precio) || $precio == 0){
            $result['errorPrecio']= "Error: especifica un precio";
        }
        if(empty($unidades) || $unidades == 0){
            $result['errorUnidades']= "Error: especifica las unidades";
        }
        
        if(sizeof($result) == 0) {
            $nombreNuevo = aplicacion::comprobarImagen("/art2mano/");
            if($nombreNuevo != false){
                if (posiblesVentasObjeto::subePeticionVentaArticuloBD($nombre, $descripcion, $unidades,
                            $precio, $nombreNuevo, $usuario)) {
                    $result = RUTA_APP.'/index.php';
                } else {
                    $result[]="Error al enviar la peticion de venta</h3>";
                }
            }  else {
                $result[]="Error: al subir la imagen, solo permite extensiones .png, .jpg, .jpeg y .gif";
            }
        }
        return $result;
    }

    protected function muestraResultadoCorrecto() {
        return "¡Tu peticion de venta ha sido enviada!";
    } 
}
?>