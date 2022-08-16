<?php
	require_once __DIR__.'/../includes/config.php';
	require_once RUTA_FORMS.'/formularioSubirOferta.php';

	$tituloPagina = 'Subir Oferta';
	
//////////////////implementacion:
	$form = new formularioSubirOferta();
	$htmlFormOferta = $form->gestiona();

	$contenidoPrincipal=<<<EOS
		$htmlFormOferta
	EOS;

	require RUTA_LAYOUT.'/layout.php';