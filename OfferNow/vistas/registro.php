<?php
	require_once __DIR__.'/../includes/config.php';
	require_once RUTA_FORMS.'/formularioRegistro.php';
	require_once RUTA_USUARIO.'/usuarios.php';

	$tituloPagina = 'Registro';

	if(estaLogado()){
		$ruta = SESION;//RUTA_VISTAS;
		$ruta.='/logout.php';
		$contenidoPrincipal = <<<EOS
			<div class="iniciosesion">
				<h2>Ya tienes la sesión iniciada.</h2>
				<h2>Para crear una nueva cuenta salte de la actual pulsando <a href=$ruta>aquí</a>.</h2>
			</div>	
		EOS;
	}
	else{
		$form = new formularioRegistro();
		$htmlFormRegistro = $form->gestiona();
		$contenidoPrincipal = <<<EOS
			$htmlFormRegistro
		EOS;
	}

	require RUTA_LAYOUT.'/layout.php';