<?php
	require_once __DIR__.'/../includes/config.php';
	require_once RUTA_CLASES.'/ofertaObjeto.php';

    ofertaObjeto::incrementarVotos(file_get_contents('php://input'));
?>