<?php
require_once RUTA_FORMS.'/form.php';
require_once RUTA_CLASES.'/comentarioObjeto.php';

class formularioSubirComentario2Mano extends form{

    public function __construct() {
        parent::__construct('formSubirComentario2Mano');
    }

    protected function generaCamposFormulario($datos, $errores = array()){
        $htmlErroresGlobales = self::generaListaErroresGlobales($errores);
        $errorNombre = self::createMensajeError($errores, 'errorNombre', 'span', array('class' => 'error'));
        $errorDescripcion = self::createMensajeError($errores, 'errorDescripcion', 'span', array('class' => 'error'));

        $id = $_GET['id'];
        $html = <<<EOF
            <div class="tarjetacomentario">		
                <h1>Subir Comentario</h1>
                <p>Titulo $errorNombre</p>
                <input type="text" name="comentarioTitulo"/>
                <p>Descripcion: $errorDescripcion</p>
                <textarea name="comentarioDescripcion" rows="5" cols="48"></textarea>
                <input type="hidden" value="$id" name="comentarioUrlDeOferta"/>
                <input type="hidden" value="false" name="esOferta"/>
                <p><input type="submit" value="Publicar"></p>
            </div>
        EOF;
        return $html;
    }

    protected function procesaFormulario($datos){
        $result = array();
        $titulo = htmlspecialchars(trim(strip_tags($_POST["comentarioTitulo"])));
        $descripcion = htmlspecialchars(trim(strip_tags($_POST["comentarioDescripcion"])));
        $urlOferta = htmlspecialchars(trim(strip_tags($_POST["comentarioUrlDeOferta"])));
        $esOferta = htmlspecialchars(trim(strip_tags($_POST["esOferta"])));
        $creador = $_SESSION["correo"];
        //Errores
        if(empty($titulo)){
            $result['errorNombre']= "Error: especifica un titulo";
        }
        if(empty($descripcion)){
            $result['errorDescripcion']= "Error: especifica una descripcion";
        }
        
        if(sizeof($result) == 0) {
            if (comentarioObjeto::subeComentario2ManoBD($titulo,$descripcion,$urlOferta,$esOferta,$creador)) {
                $result = $_SERVER['REQUEST_URI'];
            } else {
                $result[] = "Error: al crear el comentario";
            }
        }
        return $result;
    }

    protected function muestraResultadoCorrecto() {
        return "¡Tu comentario ha sido creado!";
    } 
}
?>