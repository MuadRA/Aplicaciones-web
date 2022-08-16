<header >
	<?php
		require_once __DIR__.'/../config.php';
	?>
    
	<div id= "titulo">      
        <nav class="titulocabecera">
        <ul> 
                <li> 
                        <a href="<?=RUTA_APP.'/index.php'?>" title="inicio">
                                <img src="<?=RUTA_APP.'/imagenes/OfferNow_Logo1.png'?>" class="logo" alt="logo"/>
                        </a>
                </li>
                <li>
                        <h2>Tú página de ofertas preferida</h2>
                <li>      
                        <?php
                                $ruta = SESION;
                                if (isset($_SESSION["login"]) ) {
                                        $ruta.='/logout.php';
                                        echo "Bienvenido, " .$_SESSION['nombre']."<a href=$ruta>(salir)</a>";
                                } else {
                                        $ruta.='/login.php';
                                        echo "Usuario desconocido <a href=$ruta>Login</a>";
                                }
                        ?>
                </li>
                <li>
                        <a href="<?=RUTA_APP.'/perfil.php'?>">Mi Perfil</a>
                        <!-- NO FUNCIONA ESTA RUTA <a href="<?=RUTA_VISTAS.'/perfil.php'?>">Mi Perfil</a>
                        -->
                </li>
                <li>
                        <a href="<?=RUTA_APP.'/procesarCarrito.php'?>" class="button" > 
                        <img src="<?=RUTA_APP.'/imagenes/iconos/carrito.png'?>" class="carrito" alt="carrito"/> </a>
                </li>  
        </ul>
        </nav>
        </div>

	<div id="contenedor1">
		<nav class="menu" class="col-4 my-auto mx-auto">
                <ul>
                        <li><a href="<?=RUTA_APP.'/index.php'?>">Destacados</a></li>          
                        <li><a href="<?=RUTA_APP.'/nuestraTienda.php'?>">Nuestra tienda</a></li>
                        <li><a href="<?=RUTA_APP.'/vistas/login.php'?>">Inicio Sesión</a></li>
                        <li><a href="<?=RUTA_APP.'/vistas/registro.php'?>">Registro</a></li>
                        <!--<li><a href="<?=SESION.'/logout.php'?>">Cerrar Sesión</a></li>-->
                        <?php
                                if(isset($_SESSION["esPremium"]) && !$_SESSION["esPremium"]){
                                        $direccion = RUTA_APP.'/vistas/premium.php';
                                        echo "<li><a href=".$direccion.">Hazte premium</a></li>";
                                }
                        ?>
                </ul>
                </nav>
	</div>
</header>
	