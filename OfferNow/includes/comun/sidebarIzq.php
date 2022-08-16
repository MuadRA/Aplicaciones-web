<div id="sidebarizq">

	<?php
		require_once __DIR__.'/../config.php';
		require_once RUTA_USUARIO.'/usuarios.php';
	?>

	<nav class="menuizq">
	<ul>
		<h3>¡¡Ordena los productos!!</h3>
		<li>
			Por valoracion/numero de unidades:
			<form action="<?=$_SERVER['REQUEST_URI']?>" method="get">
				<input type="submit", value="Mayor primero">
				<input type="hidden" name="ordenNombre", value = Valoracion><br>
				<input type="hidden" name="ordenTipo", value = DESC><br>
			</form>
			<form action="<?=$_SERVER['REQUEST_URI']?>" method="get">
				<input type="submit", value="Menor primero">
				<input type="hidden" name="ordenNombre", value = Valoracion><br>
				<input type="hidden" name="ordenTipo", value = ASC><br>
			</form>
		</li>
		<li>
			Fecha de creacion
			<form action="<?=$_SERVER['REQUEST_URI']?>" method="get">
				<input type="submit", value="Nuevos primero">
				<input type="hidden" name="ordenNombre", value = Numero><br>
				<input type="hidden" name="ordenTipo", value = DESC><br>
			</form>
			<form action="<?=$_SERVER['REQUEST_URI']?>" method="get">
				<input type="submit", value="Antiguos primero">
				<input type="hidden" name="ordenNombre", value = Numero><br>
				<input type="hidden" name="ordenTipo", value = ASC><br>
			</form>
		</li>
		<li>
			Por precio:
			<form action="<?=$_SERVER['REQUEST_URI']?>" method="get">
				<input type="submit", value="Menor primero">
				<input type="hidden" name="ordenNombre", value = Precio><br>
				<input type="hidden" name="ordenTipo", value = ASC><br>
			</form>
			<form action="<?=$_SERVER['REQUEST_URI']?>" method="get">
				<input type="submit", value="Mayor primero">
				<input type="hidden" name="ordenNombre", value = Precio><br>
				<input type="hidden" name="ordenTipo", value = DESC><br>
			</form>
		</li>
		<li>
			Por nombre:
			<form action="<?=$_SERVER['REQUEST_URI']?>" method="get">
			<input type="submit", value="A-Z">
				<input type="hidden" name="ordenNombre", value = Nombre><br>
				<input type="hidden" name="ordenTipo", value = ASC><br>
			</form>
			<form action="<?=$_SERVER['REQUEST_URI']?>" method="get">
				<input type="submit", value="Z-A">
				<input type="hidden" name="ordenNombre", value = Nombre><br>
				<input type="hidden" name="ordenTipo", value = DESC><br>
			</form>
		</li>
		<?php
			if(estaLogado()){
				?>
				<h3>Navegacion:</h3>
				<li><a href= "<?=RUTA_APP.'/vistas/logout.php'?>">Cerrar Sesión</a></li>
				<li><a href= "<?=RUTA_APP.'/vistas/subirOferta.php'?>">Publica una oferta</a></li>
				<li><a href= "<?=RUTA_APP.'/vistas/peticionVentaArticulo.php'?>">¡¡Vendenos un articulo!!</a></li>
				<?php
			}
			if(estaLogado() && ($_SESSION['esPremium'])){
				?>
				<h4>Opciones premium:</h4>
				<li><a href= "<?=RUTA_APP.'/tiendaPremium.php'?>">Comprueba las ofertas Premium!!</a></li>
				<?php
			}
			if(estaLogado() && ($_SESSION['esAdministrador'])){
				?>
				<h4>Opciones de administrador:</h4>
				<li><a href= "<?=RUTA_APP.'/vistas/subirArticulo2Mano.php'?>">Publica un articulo de segunda mano</a></li>
				<li><a href= "<?=RUTA_APP.'/vistas/ventasUsuarioVista.php'?>">Valida solicitudes de compra</a></li>
				<?php
			}
		?>
	</ul>
</nav>
</div>