<?php
	require_once __DIR__.'/../includes/config.php';
	require_once RUTA_CLASES.'/productoObjeto.php';

	producto::incrementarVotosComentarioProducto(file_get_contents('php://input'));
?>