<?php
require_once RUTA_FORMS.'/form.php';
require_once RUTA_CLASES.'/art2ManoObjeto.php';

class formularioSubir2Mano extends form{
    public function __construct() {
        parent::__construct('formOferta2Mano');
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
                <h1>Subir Articulo Segunda Mano</h1>                
                    <p>Nombre Articulo:$errorNombre</p>
                    <input type="text" name="articuloNombre"/>
                    <p>Descripción:$errorDescripcion</p>
                    <textarea name="articuloDescripcion" rows="10" cols="30"></textarea>
                    <p>Precio:$errorPrecio</p>
                    <input type="number" name="articuloPrecio"  />
                    <p>Nº Unidades:$errorUnidades</p>
                    <input type="number" name="articuloUnidades"/>
                    <p>Imagen:$errorImagen</p>
                    <input type="file" name="productoImagen"/>
                    <p><input type="checkbox" name="premium" value="false">¿Es Premium?</p>
                    
                    <p><input type="submit" value="Publicar"></p>
            </div>
        </div>
        EOF;
        return $html;
    }

    protected function procesaFormulario($datos){
        $result = array();
        
        $nombre = htmlspecialchars(trim(strip_tags($datos["articuloNombre"])));
        $descripcion = htmlspecialchars(trim(strip_tags($datos["articuloDescripcion"])));
        $unidades = htmlspecialchars(trim(strip_tags($datos["articuloUnidades"])));
        $precio = htmlspecialchars(trim(strip_tags($datos["articuloPrecio"])));

        if(isset($_POST['premium'])){
            $esPremium = 1;
        }
        else{
            $esPremium = 0;
        }
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
                if (art2ManoObjeto::subeArt2ManoBD($nombre,$descripcion,$unidades,
                            $precio, $nombreNuevo, $esPremium)) {
                    $result = RUTA_APP.'/nuestraTienda.php';
                } else {
                    $result[]="Error: al crear articulo de segunda mano";
                }
            } else {
                $result[]= "Error: al subir la imagen, solo permite extensiones .png, .jpg, .jpeg y .gif";
            }
        }
        return $result;
    }

    protected function muestraResultadoCorrecto() {
        return "Articulo de segunda mano creado";
    } 
}
?>