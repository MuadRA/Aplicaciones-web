<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link rel="stylesheet" type="text/css" href="<?=RUTA_CSS.'/estilo.css'?>" />
		<title><?= $tituloPagina ?></title>
	</head>
	<div class="general">
	
	<div class="cabecera">
	<?php
				require(__DIR__.'/cabecera.php');
				?>
				</div>
		<div class="contenedor">
		<?php

				require(__DIR__.'/sidebarIzq.php');
			?>
			<div class="producto">
		
					<?= $contenidoPrincipal ?>
			</div>
		</div>
</div>
	</body>
</html>

