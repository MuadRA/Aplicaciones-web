<?php

	require_once __DIR__.'/includes/config.php';
	require RUTA_CLASES.'/ofertaObjeto.php';
	require_once RUTA_USUARIO.'/usuarios.php';
	require_once RUTA_FORMS.'/formularioCantidad.php';
	require_once RUTA_FORMS.'/formularioEliminarCarrito.php';

	$tituloPagina = 'carrito';
	$contenidoPrincipal = '';
	$productos = '';
	if(estaLogado()){
		
		$user=usuario::buscaUsuario( $_SESSION["correo"]);
		
		$carritoArray=$user->muestraCarrito();
		$precioTotal=$user->Precio();
		//echo $precioTotal;
		$productos.=<<<EOS
			<div class ="iniciosesion">
			<table>
				<caption>TU PEDIDO</caption>
				<thead>
					<tr>
						<th>PRODUCTO</th>
						<th>DESCRIPCION</th>
						<th>PRECIO</th>
						<th>CANTIDAD</th>
						<th>ELIMINAR</th>
					</tr>
				</thead>
				</div	
			EOS;
		
		for ($i = 0; $i < sizeof($carritoArray); $i++) {
			$nombreOferta=strval($carritoArray[$i]->muestraNombre());
			$precioOferta=strval($carritoArray[$i]->muestraPrecio());
			$urlImagen=strval($carritoArray[$i]->muestraURLImagen());
			$Descripcion=strval($carritoArray[$i]->muestraDescripcion());
			$cantidad=$carritoArray[$i]->cantidad();
			$productos.=<<<EOS
				<tr>
					<div class="imgProducto">
						<td> <img src=$urlImagen width="200" height="200" alt="Producto" /> </td>
					</div>
				
					<div class="descripcion">
						<td>$Descripcion</td>
					</div>
					<div class="info">
						<div class="precio">
							<td>$precioOferta</td>
						</div>
					</div>
					<div class="cantidad">
						<td>
			EOS;
			
			$form = new formularioCantidad($carritoArray[$i]->muestraID(),$cantidad );
			$htmlFormAniadirCarrito = $form->gestiona();
			$productos.=<<<EOS
							$htmlFormAniadirCarrito
						</td>
					</div>
					<div class="eliminar">
						<td>
			EOS;
			$form = new formularioEliminarCarrito($carritoArray[$i]->muestraID());
			$htmlFormEliminarCarrito = $form->gestiona();
			$productos.=<<<EOS
							$htmlFormEliminarCarrito
						</td>
					</div>
				</tr>
			EOS;
		}
		$ruta = 'vistas/pagos.php';
		$contenidoPrincipal.=<<<EOS
			$productos
				<div class="precioTotal">
					<td>total:$precioTotal</td>
				</div>
				</table>
				<form action= $ruta>
				<h2><button type ="submit">Pagar</button></h2>	
				</form>
			</div>
		EOS;
	}
	else{
		$contenidoPrincipal=<<<EOS
		<div class="iniciosesion">
			<h2>Para poder ver tu carrito, inicia sesión <a href='vistas/login.php'>aquí</a>.</h2>	
		</div>
		EOS;
	}
	
	require RUTA_LAYOUT.'/layout.php';