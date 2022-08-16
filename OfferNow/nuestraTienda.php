<?php
	require_once __DIR__.'/includes/config.php';
	require RUTA_CLASES.'/art2ManoObjeto.php';

	//Carga los productos en un array, si hay un metodo de ordenacion se ordena usandolo
	if(isset($_GET['ordenNombre']) && isset($_GET['ordenTipo'])) {
		$ofertasArray = art2ManoObjeto::cargarProductos2Mano($_GET['ordenNombre'], $_GET['ordenTipo']);
	}
	else{
		$ofertasArray = art2ManoObjeto::cargarProductos2Mano("Precio", "DESC");
	}
	
	//Mostrar los productos
	$tituloPagina = 'Nuestra tienda';
	$productos = '';
	$productos.=<<<EOS
		<div="contenedor">
		<ul class="rejilla">
	EOS;
	
	if(is_array($ofertasArray)) {
			for ($i = 0; $i < sizeof($ofertasArray); $i++) {
				$nombreArticulo=strval($ofertasArray[$i]->muestraNombre());
				$precioArticulo=strval($ofertasArray[$i]->muestraPrecio());
				$urlImagen=strval($ofertasArray[$i]->muestraURLImagen());
				$cantidadArticulo = $ofertasArray[$i]->muestraUnidades();
				//URL del producto junto con el id
				$id = PRODUCTOS.'/productoSegundaMano.php?id='.$ofertasArray[$i]->muestraID();
				$productos.=<<<EOS
				<li>
					<a href=$id rel="nofollow">
						<img src=$urlImagen width="200" height="200" alt=$nombreArticulo />
						<h3>$nombreArticulo</h3>
						<p>$precioArticulo €. Stock: $cantidadArticulo</p>
					</a>
				</li>	
				EOS;
			}
		} else{
			$productos.="<h3> No hay articulos de segunda mano en este momento en la tienda </h3>";
		}

	$contenidoPrincipal=<<<EOS
		$productos
		</ul>
		</div>
	EOS;
	
	require RUTA_LAYOUT.'/layout.php';