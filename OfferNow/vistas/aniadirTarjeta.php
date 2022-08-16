<?php
	require_once __DIR__.'/../includes/config.php';
	require_once RUTA_FORMS.'/formularioAniadirTarjeta.php';


	$tituloPagina = 'Pagos';

	$form = new formularioAniadirTarjeta();
	$htmlFormCarrito = $form->gestiona();
	
	$contenidoPrincipal = <<<EOS
		$htmlFormCarrito
	EOS;

	require RUTA_LAYOUT.'/layout.php';