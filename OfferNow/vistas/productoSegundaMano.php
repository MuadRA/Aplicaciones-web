<?php
	require_once __DIR__.'/../includes/config.php';
	require_once RUTA_CLASES.'/art2ManoObjeto.php';
	require_once RUTA_FORMS.'/formularioSubirComentario2Mano.php';
	require_once RUTA_USUARIO.'/usuarios.php';

	if(isset($_GET['id'])){
		//Busca el articulo
		$id = $_GET['id'];
		$ofertaObj = art2ManoObjeto::buscaArt2Mano($id);
	}
	else {
		$ofertaObj =false;
	}
	$productos='';
	
	//Ha devuelto un objeto
	if($ofertaObj != false) {
		$ruta=POSTEAR;
		$tituloPagina = $ofertaObj->muestraNombre();
		$productos.=$ofertaObj->muestraOfertaString();
		if(estaLogado() ){
			$form = new formularioSubirComentario2Mano();
			$htmlFormRegistro = $form->gestiona();
			$productos.=$htmlFormRegistro;	
		}
		else{
			$ruta = SESION;//RUTA_VISTAS;
			$ruta.='/login.php';
			$productos.=<<<EOS
				<div class="tarjetacomentario">
					<h3>Para poder publicar comentarios o agregar al carrito, inicia sesión <a href='$ruta'>aquí</a>.</h3>
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