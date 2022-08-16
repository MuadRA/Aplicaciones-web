<?php
	require_once __DIR__.'/../includes/config.php';
	require_once RUTA_FORMS.'/formularioPagar.php';


	$tituloPagina = 'Pagos';

	$form = new formularioPagar();
	$htmlFormCarrito = $form->gestiona();
	
	$contenidoPrincipal = <<<EOS
		$htmlFormCarrito
	EOS;
	
	require RUTA_LAYOUT.'/layout.php';