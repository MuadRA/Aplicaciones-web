<?php
	require_once __DIR__.'/../includes/config.php';
	require_once RUTA_FORMS.'/formularioVentasUsuario.php';

	$tituloPagina = 'Validar solicitudes de compra';
	//////////////////implementacion:				
	$form = new formularioVentasUsuario();
	$htmlFormOferta = $form->gestiona();

	$contenidoPrincipal=<<<EOS
		$htmlFormOferta
	EOS;
	
	require RUTA_LAYOUT.'/layout.php';