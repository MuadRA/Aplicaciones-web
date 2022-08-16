<?php

class comentarioObjeto{
	private $id;
	private $titulo;
	private $texto;
	private $valoracionUtilidad;
	private $usuario;
	private $productoURL;
	
	function __construct($id, $texto, $titulo, $valoracionUtilidad, $usuario, $productoURL) {
		$this->id = $id;
		$this->titulo = $titulo;
		$this->texto = $texto;
		$this->valoracionUtilidad = $valoracionUtilidad;
		$this->usuario = $usuario;
		$this->productoURL = $productoURL;
	}
	
	//--------------------------------------------Funciones estaticas----------------------------------------------
	public static function subeComentarioOfertaBD($titulo,$descripcion,$urlOferta,$esOferta,$creador) {
		
		$app = aplicacion::getSingleton();
		$mysqli = $app->conexionBd();	
		
		$tituloFiltrado=$mysqli->real_escape_string($titulo);
		$descripcionFiltrado=$mysqli->real_escape_string($descripcion);;
		$urlOfertaFiltrado=$mysqli->real_escape_string($urlOferta);
		$esOfertaFiltrado=$mysqli->real_escape_string($esOferta);//no se usa ...
		$creadorFiltrado=$mysqli->real_escape_string($creador);

		$sql = "INSERT INTO comentariosoferta (Texto, Titulo, ValoracionUtilidad, UsuarioID, OfertaID)
				VALUES ('$descripcionFiltrado', '$tituloFiltrado', 0, '$creadorFiltrado', '$urlOfertaFiltrado')";
		
		if (mysqli_query($mysqli, $sql)) {
			return true;
		} else {
			return false;
		}		
	}
	
	public static function subeComentario2ManoBD($titulo,$descripcion,$urlOferta,$esOferta,$creador){
		//Insert into inserta en la tabla comentariossegundamano y las columnas entre parentesis los valores en VALUES
		$app = aplicacion::getSingleton();
		$mysqli = $app->conexionBd();	

		$tituloFiltrado=$mysqli->real_escape_string($titulo);
		$descripcionFiltrado=$mysqli->real_escape_string($descripcion);;
		$urlOfertaFiltrado=$mysqli->real_escape_string($urlOferta);
		$esOfertaFiltrado=$mysqli->real_escape_string($esOferta);//no se usa ...
		$creadorFiltrado=$mysqli->real_escape_string($creador);

		$sql = "INSERT INTO comentariossegundamano (Texto, Titulo, ValoracionUtilidad, UsuarioID, SegundaManoID)
				VALUES ('$descripcionFiltrado', '$tituloFiltrado', 0, '$creadorFiltrado', '$urlOfertaFiltrado')";
		
		if (mysqli_query($mysqli, $sql)) {
			return true;
		} else {
			return false;
		}	
	}
	
	public static function buscaComentarioOferta($id) {
		$app = aplicacion::getSingleton();
		$conn = $app->conexionBd();	
		$query = sprintf("SELECT * FROM comentariosoferta WHERE ID='%id'",
						$conn->real_escape_string($id));

		$rs = $conn->query($query);

		if ($rs && $rs->num_rows == 1) {
			$fila = $rs->fetch_assoc();
			$coment = new comentarioObjeto($fila['Numero'], $fila['Texto'], $fila['Titulo'],
				$fila['ValoracionUtilidad'], $fila['UsuarioID'], $fila['OfertaID']);
			$rs->free();

			return $coment;
		}
		return false;
	}
	
	public static function buscaComentario2Mano($id) {
		$app = aplicacion::getSingleton();
		$conn = $app->conexionBd();
		$query = sprintf("SELECT * FROM comentariossegundamano WHERE ID='%id'",
						$conn->real_escape_string($id));

		$rs = $conn->query($query);
		if ($rs && $rs->num_rows == 1) {
			$fila = $rs->fetch_assoc();
			$coment = new comentarioObjeto($fila['Numero'], $fila['Texto'], $fila['Titulo'],
				$fila['ValoracionUtilidad'], $fila['UsuarioID'], $fila['OfertaID']);
			$rs->free();

			return $coment;
		}
		return false;
	}
	
	//--------------------------------------------------GETTERS-----------------------------------------------------
	public function muestraTitulo() {
		return $this->titulo;
	}
	public function muestraTexto() {
		return $this->texto;
	}
	
	public function muestraValoracion() {
		return $this->valoracionUtilidad;
	}
	
	public function muestraUsuario() {
		//Busca el nombre del usuario en vez de usar el correo
		$app = aplicacion::getSingleton();
		$mysqli = $app->conexionBd();
		$result = $mysqli->query("SELECT Nombre FROM usuario WHERE Correo='$this->usuario'");
		$fila = $result->fetch_assoc();
		return $fila['Nombre'];
	}
}
?>
