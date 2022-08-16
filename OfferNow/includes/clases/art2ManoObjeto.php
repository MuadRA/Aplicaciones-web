<?php

require_once __DIR__.'/../config.php';
require_once RUTA_CLASES.'/comentarioObjeto.php';
require_once RUTA_CLASES.'/productoObjeto.php';
require_once RUTA_FORMS.'/formularioAniadeCarrito.php';

class art2ManoObjeto extends producto{
	
	private $unidades;
	private $cantidad;

	function __construct($id, $nombre, $descripcion, $unidades, $precio, $urlImagen) {
		parent::creaPadre($id, $nombre, $descripcion, $urlImagen, $precio, "comentariossegundamano");
		$this->unidades = $unidades;		
	}

	//--------------------------------------------Funciones estaticas----------------------------------------------
	public static function subeArt2ManoBD($nombre, $descripcion, $unidades, $precio, $imagen, $esPremium) {
		//NECESARIO PARA EL FILTRADO
		$app = Aplicacion::getSingleton();
		$mysqli = $app->conexionBd();
		
		$nombreFiltrado=$mysqli->real_escape_string($nombre);
		$descripcionFiltrado=$mysqli->real_escape_string($descripcion);;
		$unidadesFiltrado=$mysqli->real_escape_string($unidades);
		$precioFiltrado=$mysqli->real_escape_string($precio);
		$imagenFiltrado=$mysqli->real_escape_string($imagen);

		$result = parent::hacerConsulta("INSERT INTO articulos_segunda_mano (Nombre, Descripcion, Unidades,
											Precio, Imagen, Premium)
										VALUES ('$nombreFiltrado', '$descripcionFiltrado', '$unidadesFiltrado',
											'$precioFiltrado', '$imagenFiltrado', '$esPremium')");
		if ($result != null) {
			return true;
		} else {
			return false;
		}
	}
	
	public static function buscaArt2Mano($id) {
		//Si esta logeado y es premium busca todos
		if(estaLogado() && $_SESSION["esPremium"]) {
			$result = parent::hacerConsulta("SELECT * FROM articulos_segunda_mano WHERE Numero = '$id'");
		}
		else{
			$result = parent::hacerConsulta("SELECT * FROM articulos_segunda_mano WHERE Numero = '$id' AND Premium = 0");
		}
		//Si solo hay un id crea el objeto y lo devuelve
		if($result && $result->num_rows == 1) {
			$fila = $result->fetch_assoc();

			$ofertaObj = new art2ManoObjeto($fila['Numero'],$fila['Nombre'],$fila['Descripcion'],
									$fila['Unidades'],$fila['Precio'],$fila['Imagen']);
			if(estaLogado()) {
				$idUser=$_SESSION['correo'];
				$resultCant = parent::hacerConsulta("SELECT unidades FROM carrito WHERE idProducto = '$id' and idUsuario='$idUser'");
					if($resultCant && $resultCant->num_rows >0){
						$filacant = $resultCant->fetch_assoc();
						$cantidad=$filacant['unidades'];
						$ofertaObj->agregarCantidad($cantidad);	
					}
			}	
			return $ofertaObj;
		} else{
			return false;
		}
	}

	/*$busquedaPremium = 0 -> por defecto busca los no premium y cuando queremos que busque los
	premium le pasamos un 1*/
	public static function cargarProductos2Mano($orden, $tipo, $busquedaPremium = 0){
		//Array con las posibles ordenaciones
		if($orden === "Valoracion"){
			$orden = "Unidades";
		}
		$filtrosBusqueda = array("Nombre","Unidades","Precio","Numero");
		$filtrosTipo = array("ASC", "DESC");
		//Si $orden esta en $filtrosBusqueda, se ordena con ese orden, sino se ordena por Valoracion
		if(in_array($orden, $filtrosBusqueda) && in_array($tipo, $filtrosTipo) &&
				($busquedaPremium == 0 || $busquedaPremium == 1)) {
			$result = parent::hacerConsulta("SELECT * FROM articulos_segunda_mano
						WHERE Premium = $busquedaPremium ORDER BY $orden $tipo");
		}
		else{
			$result = parent::hacerConsulta("SELECT * FROM articulos_segunda_mano
						WHERE Premium = $busquedaPremium ORDER BY Precio DESC");
		}
		$ofertasArray;
		
		if($result) {
			for ($i = 0; $i < $result->num_rows; $i++) {
				$fila = $result->fetch_assoc();
				$ofertasArray[] = new art2ManoObjeto($fila['Numero'],$fila['Nombre'],$fila['Descripcion'],
									$fila['Unidades'],$fila['Precio'],$fila['Imagen']);		
			}
			return $ofertasArray;
		}
		else{
			//echo "Error in ".$query."<br>".$mysqli->error;
			return false;
		}
	}

	public static function buscaUnidadesArticulo($idArticulo) {
		$result = parent::hacerConsulta("SELECT Unidades FROM articulos_segunda_mano WHERE Numero = $idArticulo");
		$fila=$result->fetch_assoc();
        return $fila['Unidades'];
	}
	
	//--------------------------------------------------Vista-----------------------------------------------------		
	public function muestraOfertaString(){
		$DIRimagen = $this->muestraURLImagen();
		
		$nombreAux = parent::muestraNombre();
		$descripcionAux = parent::muestraDescripcion();

		$form = new formularioAniadeCarrito(parent::muestraID());
		$htmlFormAniadirCarrito = $form->gestiona();
		
		$productos = '';
		$productos.=<<<EOS
			<div class="imgProducto">
				<img src="$DIRimagen" width="200" height="200" alt=$nombreAux />
			</div>
			<div class="desProducto">
				<p>Nombre del producto: $nombreAux</p>
				<p>Descripcion:</p>
				<p>$descripcionAux</p>
				<p>$htmlFormAniadirCarrito</p>
			</div>
		EOS;
		$productos.= parent::muestraComentariosString();
		return $productos;
	}
	
	//--------------------------------------------------GETTERS-----------------------------------------------------
	public function muestraUnidades() {
		return $this->unidades;
	}
	public function agregarCantidad($cant) {
		$this->cantidad=$cant;
	}
	public function cantidad() {
		return 	$this->cantidad;
	}
	public function muestraURLImagen() {
		$DIRimagen=RUTA_IMGS."/art2mano/";
		$DIRimagen.=parent::muestraURLImagen();
		return $DIRimagen;
	}
}
?>
