<?php
	require_once __DIR__.'/includes/config.php';
	require RUTA_CLASES.'/art2ManoObjeto.php';
    //require RUTA_CLASES.'/ofertaObjeto.php';

	$tituloPagina = 'Zona Premium';
	$productos = '';
	//------------------------------Carga de articulos 2 mano premium-----------------------------------------
		$productos.=<<<EOS
			<div="producto">
			<ul class="rejilla">
			<h2>¡¡¡Aqui puedes ver todos los articulos de segunda mano para usuarios Premium!!!</h2>
			</ul>
			<ul class="rejilla">
		EOS;

		//Carga los productos de 2 mano en un array
		if(isset($_GET['ordenNombre']) && isset($_GET['ordenTipo'])) {
			$articulos2ManoArray = art2ManoObjeto::cargarProductos2Mano($_GET['ordenNombre'], $_GET['ordenTipo'], 1);
		}
		else{
			$articulos2ManoArray = art2ManoObjeto::cargarProductos2Mano("Precio", "DESC", 1);
		}
		$articulosPremiumString;
		if(is_array($articulos2ManoArray)) {
			for ($i = 0; $i < sizeof($articulos2ManoArray); $i++) {
				$nombreArticulo=strval($articulos2ManoArray[$i]->muestraNombre());
				$precioArticulo=strval($articulos2ManoArray[$i]->muestraPrecio());
				$urlImagen=strval($articulos2ManoArray[$i]->muestraURLImagen());
				//URL del producto junto con el id
				$id = PRODUCTOS.'/productoSegundaMano.php?id='.$articulos2ManoArray[$i]->muestraID();
				$productos.=<<<EOS
					<li>
						<a href=$id rel="nofollow">
							<img src=$urlImagen width="200" height="200" alt=$nombreArticulo />
							<h3>$nombreArticulo</h3>
							<p>$precioArticulo €</p>
						</a>
					</li>	
				EOS;
			}
		} else{
			$productos.="<h3> No hay articulos premium de SEGUNDA MANO en este momento en la tienda </h3>";
		}

	//----------------------------------Carga de ofertas premium---------------------------------------------
		$productos.=<<<EOS
			</ul>
			<div="producto">
				<ul class="rejilla">
					<h2>¡¡¡Aqui puedes ver todas ofertas para usuarios Premium!!!</h2>
				</ul>
				<ul class="rejilla">
		EOS;
		
		//Carga las ofertas en un array
		if(isset($_GET['ordenNombre']) && isset($_GET['ordenTipo'])) {
			$ofertasArray = ofertaObjeto::cargarOfertas($_GET['ordenNombre'], $_GET['ordenTipo'], 1);
		}
		else{
			$ofertasArray = ofertaObjeto::cargarOfertas("Precio", "DESC", 1);
		}
		if(is_array($ofertasArray)) {
			for ($i = 0; $i < sizeof($ofertasArray); $i++) {
				$nombreArticulo=strval($ofertasArray[$i]->muestraNombre());
				$precioArticulo=strval($ofertasArray[$i]->muestraPrecio());
				$urlImagen=strval($ofertasArray[$i]->muestraURLImagen());
				//URL del producto junto con el id
				$id = PRODUCTOS.'/producto.php?id='.$ofertasArray[$i]->muestraID();
				$productos.=<<<EOS
				<li>
					<a href=$id rel="nofollow">
						<img src=$urlImagen width="200" height="200" alt=$nombreArticulo />
						<h3>$nombreArticulo</h3>
						<p>$precioArticulo €</p>
					</a>
				</li>	
				EOS;
			}
		} else{
			$productos.="<h3> No hay OFERTAS premium en este momento en la tienda </h3>";
		}

	//Muestra todos los productos premium
	$contenidoPrincipal=<<<EOS
		$productos
		</ul>
		</div>
	EOS;

	require RAIZ_APP.'/includes/comun/layout.php';