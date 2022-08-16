<?php

require_once RUTA_FORMS.'/form.php';
require_once RUTA_CLASES.'/ofertaObjeto.php';

class formularioSubirOferta extends form{

    public function __construct() {
        parent::__construct('formOferta');
    }

    protected function generaCamposFormulario($datos, $errores = array()){
        $htmlErroresGlobales = self::generaListaErroresGlobales($errores);
        $errorEnlace = self::createMensajeError($errores, 'errorEnlace', 'span', array('class' => 'error'));
        $errorImagen = self::createMensajeError($errores, 'errorImagen', 'span', array('class' => 'error'));
        $errorNombre = self::createMensajeError($errores, 'errorNombre', 'span', array('class' => 'error'));
        $errorDescripcion = self::createMensajeError($errores, 'errorDescripcion', 'span', array('class' => 'error'));
        $errorPrecio = self::createMensajeError($errores, 'errorPrecio', 'span', array('class' => 'error'));
        $errorUrl = self::createMensajeError($errores, 'errorUrl', 'span', array('class' => 'error'));

        $html = <<<EOF
            <div class="subirOferta">
            <div class="producto">
                <h1>Subir Oferta</h1>
                    <p>Nombre oferta:$errorNombre</p>
                    <input type="text" name="ofertaNombre"/>
                    <p>Descripción:$errorDescripcion</p>
                    <textarea name="ofertaDescripcion" rows="10" cols="30"></textarea>
                    <p>Precio:$errorPrecio</p>
                    <input type="number" name="ofertaPrecio"  />
                    <p>Url de la oferta (incluyendo https://):$errorUrl</p>
                    <input type="text" name="ofertaUrl"/>
                    <p>¿Tenemos esta oferta en nuestra tienda? ¡¡Pon el enlace!!:$errorEnlace</p>
                    <input type="text" name="oferta2ManoUrl"/>
                    <p>Imagen:</p>
                    <input type="file" name="productoImagen"/>$errorImagen
                    
                    <p><input type="submit" value="Publicar"></p>
                </div>
            </div>
        EOF;
        return $html;
    }

    protected function procesaFormulario($datos){
        //Si hay un link para el artciulo de 2 mano se procesa
        $url2Mano;

        if(!empty($datos["oferta2ManoUrl"])){
            $cadena_buscada = '?id=';
            $buscarCadena = explode($cadena_buscada, $datos["oferta2ManoUrl"]);
            //Se ha encontrado
            if(is_array($buscarCadena) && (sizeof($buscarCadena) == 2)) {
                $url2Mano = $buscarCadena[1];
            } else {
                $result['errorEnlace']= "Error: el enlace a nuestro producto es incorrecto";
            }
        } else{
            $url2Mano = 0;
        }

        $result = array();
        
        $nombre = htmlspecialchars(trim(strip_tags($datos["ofertaNombre"])));
        $descripcion = htmlspecialchars(trim(strip_tags($datos["ofertaDescripcion"])));
        $urlOferta = htmlspecialchars(trim(strip_tags($datos["ofertaUrl"])));
        $precio = htmlspecialchars(trim(strip_tags($datos["ofertaPrecio"])));
        $creador = $_SESSION["correo"];
        if(empty($nombre)){
            $result['errorNombre']= "Error: especifica un nombre";
        }
        if(empty($descripcion)){
            $result['errorDescripcion']= "Error: especifica una descripcion";
        }
        if(empty($precio) || $precio == 0){
            $result['errorPrecio']= "Error: especifica un precio (mayor que 0)";
        }
        if(empty($urlOferta)){
            $result['errorUrl']= "Error: especifica una url";
        }
        
        if(sizeof($result) == 0) {
            $nombreNuevo = aplicacion::comprobarImagen("/ofertas/");
            if($nombreNuevo != false){
                if (ofertaObjeto::subeOfertaBD($nombre,$descripcion,$urlOferta,
                        $nombreNuevo,$precio,$creador, $url2Mano)) {   
                    $result = RUTA_APP.'/index.php';
                } else {
                    $result[]= "Error: al crear la oferta";
                }
            } else {
                $result['errorImagen']= "Error: al subir la imagen, solo permite extensiones .png, .jpg, .jpeg y .gif";
            }
        } 
        return $result;
    }

    protected function muestraResultadoCorrecto() {
        return "Oferta creada";
    } 
}
?>