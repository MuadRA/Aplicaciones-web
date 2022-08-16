<?php
	require_once __DIR__.'/../includes/config.php';
	require_once RUTA_USUARIO.'/usuarios.php';
	
	$usuario=$_SESSION['nombre'];
	logout();

	$tituloPagina = 'Logout';
	$contenidoPrincipal=<<<EOS
		<div class="producto">
			<div class="iniciosesion">
				<h2>GRACIAS Y HASTA PRONTO!   </h2> {$usuario}
			</div>
		</div>
	EOS;
	
	require RUTA_LAYOUT.'/layout.php';