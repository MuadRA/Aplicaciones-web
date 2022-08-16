<?php
	require_once __DIR__.'/../includes/config.php';
	require_once RUTA_CLASES.'/ofertaObjeto.php';
	require_once RUTA_FORMS.'/formularioSubirComentarioOferta.php';
	require_once RUTA_USUARIO.'/usuarios.php';

	if(isset($_GET['id'])){
		//Busca el articulo
		$id = $_GET['id'];
		$ofertaObj = ofertaObjeto::buscaOferta($id);
	}
	else {
		$ofertaObj = false;
	}
	$productos='';
	
	//Si no ha devuelto false entonces ha encontrado el articulo
	if($ofertaObj != false) {
		$ruta=POSTEAR;
		$tituloPagina = $ofertaObj->muestraNombre();
		$productos .= $ofertaObj->muestraOfertaString();
		if(estaLogado() ){
			$form = new formularioSubirComentarioOferta();
			$htmlFormRegistro = $form->gestiona();
			$productos.=$htmlFormRegistro;	
		}
		else{
			$ruta = SESION;//RUTA_VISTAS;
			$ruta.='/login.php';
			$productos.=<<<EOS
				<div class="tarjetacomentario">
					<h3>Para poder publicar comentarios, inicia sesión <a href=$ruta>aquí</a>.</h3>	
				</div>
			EOS;	
		}
	}
	//Si no
	else{
		$productos.=<<<EOS
			<h3>El producto no se ha encontrado o es premium</h3>
		EOS;
		$tituloPagina = "Objeto no encontrado";
	}
	
	$contenidoPrincipal=<<<EOS
		$productos
	EOS;

	require RUTA_LAYOUT.'/layout.php';