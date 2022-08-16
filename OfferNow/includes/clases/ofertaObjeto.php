<?php

require_once __DIR__.'/../config.php';
require_once RUTA_CLASES.'/comentarioObjeto.php';
require_once RUTA_CLASES.'/productoObjeto.php';

class ofertaObjeto extends producto{
	private $urlOferta;
	private $valoracion;
	private $creador;
	private $segundaMano;
	
	function __construct($id, $nombre, $descripcion, $urlOferta, $urlImagen, $valoracion, $precio, $creador,$segundaMano) {
		parent::creaPadre($id, $nombre, $descripcion, $urlImagen, $precio, "comentariosoferta");
			//"SELECT * FROM comentariosoferta WHERE OfertaID = '$id' ORDER BY ValoracionUtilidad");
		$this->urlOferta = $urlOferta;
		$this->valoracion = $valoracion;
		$this->creador = $creador;
		$this->segundaMano=$segundaMano;
	}
	
	//--------------------------------------------Funciones estaticas----------------------------------------------
	public static function subeOfertaBD($nombre,$descripcion,$urlOferta,$urlImagen,$precio,$creador,$url2Mano) {
		//NECESARIO PARA EL FILTRADO
		$app = Aplicacion::getSingleton();
		$mysqli = $app->conexionBd();
		
		$nombreFiltrado=$mysqli->real_escape_string($nombre);
		$descripcionFiltrado=$mysqli->real_escape_string($descripcion);;
		$urlOfertaFiltrado=$mysqli->real_escape_string($urlOferta);
		$urlImagenFiltrado=$mysqli->real_escape_string($urlImagen);
		$precioFiltrado=$mysqli->real_escape_string($precio);
		$creadorFiltrado=$mysqli->real_escape_string($creador);
		
		$result = parent::hacerConsulta("INSERT INTO oferta (Nombre, Descripcion, URL_Oferta,
											URL_Imagen, Valoracion, Precio, Creador, ID2Mano)
										VALUES ('$nombreFiltrado', '$descripcionFiltrado', '$urlOfertaFiltrado',
											'$urlImagenFiltrado', 0, '$precioFiltrado', '$creadorFiltrado','$url2Mano')");
		if ($result) {
			return true;
		} else {
			return false;
		}
	}

	public static function buscaOferta($id) {
		if(estaLogado() && $_SESSION["esPremium"]) {
			$result = parent::hacerConsulta("SELECT * FROM oferta WHERE Numero = '$id'");
		}
		else{
			$result = parent::hacerConsulta("SELECT * FROM oferta WHERE Numero = '$id' AND Premium = 0");
		}

		if($result && $result->num_rows == 1) {
			$fila = $result->fetch_assoc();
			$ofertaObj = new ofertaObjeto($fila['Numero'],$fila['Nombre'],$fila['Descripcion'],$fila['URL_Oferta'],
									$fila['URL_Imagen'],$fila['Valoracion'],$fila['Precio'],$fila['Creador'],$fila['ID2Mano']);
			
			return $ofertaObj;
		} else{
			return false;
		}	
	}

	/*$busquedaPremium = 0 -> por defecto busca los no premium y cuando queremos que busque los
	premium le pasamos un 1*/
	public static function cargarOfertas($orden, $tipo, $busquedaPremium = 0){
		//Array con las posibles ordenaciones
		$filtrosBusqueda = array("Nombre","Valoracion","Precio","Numero");
		$filtrosTipo = array("ASC", "DESC");
		//Si $orden esta en $filtrosBusqueda, se ordena con ese orden, sino se ordena por Valoracion
		if(in_array($orden, $filtrosBusqueda) && in_array($tipo, $filtrosTipo) &&
		($busquedaPremium == 0 || $busquedaPremium == 1)) {
			$result = parent::hacerConsulta("SELECT * FROM oferta WHERE Premium = $busquedaPremium ORDER BY $orden $tipo");
		}
		else{
			$result = parent::hacerConsulta("SELECT * FROM oferta WHERE Premium = $busquedaPremium ORDER BY Valoracion DESC");
		}

		$ofertasArray;
		if($result != null) {
			for ($i = 0; $i < $result->num_rows; $i++) {
				$fila = $result->fetch_assoc();
				
				$ofertasArray[] = new ofertaObjeto($fila['Numero'],$fila['Nombre'],$fila['Descripcion'],$fila['URL_Oferta'],
											$fila['URL_Imagen'],$fila['Valoracion'],$fila['Precio'],$fila['Creador'],$fila['ID2Mano']);
			}
			return $ofertasArray;
		}
		else{
			echo "Error in ".$query."<br>".$mysqli->error;
		}
	}

	public static function incrementarVotos($idOferta){
		var_dump($idOferta);
		$result = parent::hacerConsulta("SELECT Valoracion FROM oferta WHERE Numero = $idOferta LIMIT 1");
		//var_dump($result->fetch_object()->Valoracion);
		$valoracion = $result->fetch_object()->Valoracion + 1;
		parent::hacerConsulta("UPDATE oferta SET Valoracion = $valoracion WHERE Numero = $idOferta");
	}
	
	//--------------------------------------------------Vista-----------------------------------------------------
	public function muestraOfertaString(){
		$Ruta = RUTA_APP;
		$DIRimagen = $this->muestraURLImagen();
		
		$nombreAux = parent::muestraNombre();
		$descripcionAux = parent::muestraDescripcion();
		$creadornAux = $this->muestraCreador();
		$valorSegundaMano=$this->getSegundamano();
		
		$productos = '';
		$productos.=<<<EOS
			<div class="imgProducto">
			<img src="$DIRimagen" width="200" height="200" alt=$nombreAux />
			</div>
			<div class="desProducto">
			<p>Nombre del producto: $nombreAux</p>
			<p>Descripcion:</p>
			<p>$descripcionAux</p>
			<p>
				Enlaces:
				<a href="$this->urlOferta" rel="nofollow" >Enlace Oferta</a>
			</p>
		EOS;
		//Si la oferta la tenemos como producto de segunda mano ponemos su enlace
		if($this->segundaMano != 0) {
			$IDSegundaMano = PRODUCTOS.'/productoSegundaMano.php?id='.$this->segundaMano;
			$productos.=<<<EOS
				<p>Tenemos el producto en nuestra tienda, <a href="{$IDSegundaMano}" rel="nofollow" >MIRALO.</a></p>
			EOS;
		}
		$ruta = POSTEAR."/votosBD.php";
				
		$productos.=<<<HTML
			<button class="button" type="button"
				onclick="incrementarVotos$this->id(this)">    
				<img src="{$Ruta}/imagenes/iconos/ok.png" width="15" height="15" alt="votos"/>    
				VOTOS: <span class = "count">$this->valoracion</span>
			</button>
			
			<script type="text/javascript">
				const rutaLocal = "$ruta";
				//console.log("El contenido de la variable es: " + rutaLocal)
				function incrementarVotos$this->id(button){	
					var xhttp = new XMLHttpRequest();
					xhttp.open("POST", rutaLocal, true); 
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
			</div>
		HTML;
		$productos.= parent::muestraComentariosString();
		return $productos;
	}

	//--------------------------------------------------GETTERS-----------------------------------------------------
	function muestraURLImagen() {
		$DIRimagen=RUTA_IMGS."/ofertas/";
		$DIRimagen.=parent::muestraURLImagen();
		return $DIRimagen;
	}
	
	function muestraCreador() {
		return $this->creador;
	}

	function muestraValoracion() {
		return $this->valoracion;
	}

	function muestraURLOferta() {
		return $this->urlOferta;
	}
	public function getSegundamano(){
		return $this->segundaMano;
	}
  }
?>
