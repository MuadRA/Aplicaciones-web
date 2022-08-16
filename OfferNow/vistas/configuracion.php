<?php
	require_once __DIR__.'/../includes/config.php';

  require_once RUTA_FORMS.'/formularioConfiguracion.php';
	
   $tituloPagina = 'Configuracion';
    
    $form = new formularioConfiguracion();
    $htmlFormDireccion = $form->gestiona();
    
    $contenidoPrincipal=<<<EOS
        $htmlFormDireccion
    EOS;

    require RUTA_LAYOUT.'/layout.php';