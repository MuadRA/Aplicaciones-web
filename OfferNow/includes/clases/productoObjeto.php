<?php

require_once __DIR__.'/../config.php';
require_once RUTA_CLASES.'/comentarioObjeto.php';

abstract class producto{
    protected $id;
	private $nombre;
	private $descripcion;
	private $urlImagen;
	private $precio;
	private $comentariosArray;

    /*//No vale para nada ya que es abstracto
    function __construct($id, $nombre, $descripcion, $urlImagen, $precio) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->urlImagen = $urlImagen;
        $this->precio = $precio;
    }
    */

    protected function creaPadre($id, $nombre, $descripcion, $urlImagen, $precio, $tablaDondeBuscarComentarios) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->urlImagen = $urlImagen;
        $this->precio = $precio;
        $this->cargaComentarios($tablaDondeBuscarComentarios);
    }

    protected function cargaComentarios($tablaDondeBuscarComentarios) {
        if($tablaDondeBuscarComentarios == "comentariosoferta"){
            $result = $this->hacerConsulta("SELECT * FROM comentariosoferta WHERE OfertaID = '$this->id' ORDER BY ValoracionUtilidad");
            if($result != null) {
                for ($i = 0; $i < $result->num_rows; $i++) {
                    $fila = $result->fetch_assoc();
                    $this->comentariosArray[] = new comentarioObjeto($fila['ID'],$fila['Texto'],$fila['Titulo'],
                            $fila['ValoracionUtilidad'], $fila['UsuarioID'],$fila['OfertaID']);
                }
            }
        } else if ($tablaDondeBuscarComentarios == "comentariossegundamano"){
            $result = $this->hacerConsulta("SELECT * FROM comentariossegundamano WHERE SegundaManoID = '$this->id' ORDER BY ValoracionUtilidad");
            if($result != null) {
                for ($i = 0; $i < $result->num_rows; $i++) {
                    $fila = $result->fetch_assoc();
                    $this->comentariosArray[] = new comentarioObjeto($fila['ID'],$fila['Texto'],$fila['Titulo'],
                            $fila['ValoracionUtilidad'], $fila['UsuarioID'],$fila['SegundaManoID']);
                }
            }
        } else{
            $result = null;
        }
	}

	public static function incrementarVotosComentarioProducto($idProducto){
		var_dump($idProducto);

		$result = producto::hacerConsulta("SELECT ValoracionUtilidad FROM comentariosoferta WHERE OfertaID = $idProducto LIMIT 1");
		$valoracion = $result->fetch_object()->ValoracionUtilidad + 1;
		producto::hacerConsulta("UPDATE comentariosoferta SET ValoracionUtilidad = $valoracion WHERE OfertaID = $idProducto");

		$result = producto::hacerConsulta("SELECT ValoracionUtilidad FROM comentariossegundamano WHERE SegundaManoID = $idProducto LIMIT 1");
		$valoracion = $result->fetch_object()->ValoracionUtilidad + 1;
		producto::hacerConsulta("UPDATE comentariossegundamano SET ValoracionUtilidad = $valoracion WHERE SegundaManoID = $idProducto");
	}

	protected static function hacerConsulta($query){
		$app = aplicacion::getSingleton();
		$mysqli = $app->conexionBd();
		$result = $mysqli->query($query);
		if($result) {
			return $result;
		}
		else{
			return null;
		}
	}

	//--------------------------------------------------Vista--------------------------------------------------		
    protected function muestraComentariosString() {
        $ruta = POSTEAR."/votosComentarioProductoBD.php";
		$RutaFoto = RUTA_APP;
		$productos = '';
		if(is_array($this->comentariosArray)){	//Comprueba si es un array para no dar un error
			for($i = 0; $i < sizeof($this->comentariosArray); $i++){
				$comTitulo = $this->comentariosArray[$i]->muestraTitulo();
				$comTexto = $this->comentariosArray[$i]->muestraTexto();
				$comValoracion = $this->comentariosArray[$i]->muestraValoracion();
				$comUsuario = $this->comentariosArray[$i]->muestraUsuario();
				$productos.=<<<HTML
					<div class="tarjetacomentario">
						<p>$comTitulo - $comUsuario - </p>
						
					<button class="button" type="button"   
						onclick="incrementarVotosComentarioProducto$this->id(this)">    
						<img src="{$RutaFoto}/imagenes/iconos/estrella.png" width="15" height="15" alt="votos"/>    
						Valoración comentario: <span class = "count">$comValoracion</span>
					</button>

					<script type="text/javascript">
					const rutaLocall = "$ruta";
					console.log("El contenido de la variable es: " + rutaLocall)
					function incrementarVotosComentarioProducto$this->id(button){	
						var xhttp = new XMLHttpRequest();
						xhttp.open("POST", rutaLocall, true); 
						xhttp.onreadystatechange = function() {
							if (this.readyState == 4 && this.status == 200) {	
								button.querySelector('.count').innerText = parseInt (button.querySelector('.count').innerText)+1 ;
								//console.log(button.querySelector('.count').innerText);
								//console.log(button);
								//console.log(this);
							}
						};
						xhttp.send($this->id);
					}
					</script>

						<p>$comTexto</p>
					</div>
				HTML;
			}
		}
		return $productos;
	}
    //--------------------------------------------------SETTERS--------------------------------------------------
    protected function setComentariosArray($arrayComent){
        $this->comentariosArray = $arrayComent;
    }
    //--------------------------------------------------GETTERS--------------------------------------------------
    public function muestraID() {
		return $this->id;
	}
	
	public function muestraNombre() {
		return $this->nombre;
	}
	public function muestraDescripcion() {
		return $this->descripcion;
	}

    function muestraURLImagen() {
        return $this->urlImagen;
	}

    public function muestraPrecio() {
		return $this->precio;
	}
	
	public function muestraComentarios() {
		return $this->comentariosArray;
	}
}