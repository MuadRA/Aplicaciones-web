<?php
	require_once __DIR__.'/../includes/config.php';
	require_once RUTA_FORMS.'/formularioPremium.php';

	$tituloPagina = 'Hazte Premium';
	$form = new formularioPremium();
	$htmlFormPremium = $form->gestiona();
	$contenidoPrincipal=<<<EOS
				$htmlFormPremium
	EOS;
	
	require RUTA_LAYOUT.'/layout.php';