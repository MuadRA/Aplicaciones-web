<?php
	require_once __DIR__.'/../includes/config.php';
	require_once RUTA_FORMS.'/formularioDirecciones.php';
	
    $tituloPagina = 'Direcciones';
    $nombreUsuario =$_SESSION['correo'];
    $user=usuario::buscaUsuario($nombreUsuario);
    $listaPedidos=$user->listarPedidos();
    $productos=<<<EOS
	<div class="iniciosesion">
	<table>
	<caption>TUS PEDIDOS REALIZADOS</caption>
			<thead>
				<tr>
					<th>PRODUCTO</th>
					<th>PRECIO</th>
					<th>UNIDADES</th>			
	EOS;

    if(is_array($listaPedidos)) {
        for ($i = 0; $i < sizeof($listaPedidos); $i++) {
			$nombreOferta=strval($listaPedidos[$i]->muestraNombre());
			$precioOferta=strval($listaPedidos[$i]->muestraPrecio());
			$urlImagen=strval($listaPedidos[$i]->muestraURLImagen());
			$cantidad=$listaPedidos[$i]->cantidad();
			//URL del producto junto con el id
			$id = PRODUCTOS.'/productoSegundaMano.php?id='.$listaPedidos[$i]->muestraID();
			$productos.=<<<EOS
			<tr>
				<div class="imgProducto">
					<td><a href=$id rel="nofollow"> <img src=$urlImagen width="150" height="150" alt="Producto" /></a> </td>
				</div>
				<div class="info">
					<div class="precio">
						<td>$precioOferta € </td>
					</div>
				</div>
				<div class="cantidad">
				<td>
				$cantidad
				</td>
				</div>
			</tr>	
			EOS;
		}
    }

    $contenidoPrincipal=<<<EOS
		$productos
		</ul>
		</div>
	EOS;

	require RUTA_LAYOUT.'/layout.php';