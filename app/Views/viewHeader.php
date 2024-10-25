 <!-- Encabezado con barra de navegación -->
 <header>
        <div class="logo">
            <a href="#inicio">
                <img src="<?php echo $img;?>rayuela.png" alt="Logo Rayuela">
            </a>
        </div>
        <nav>
            <ul>
                <li><a href=<?php echo URL_PATH.'/index.php?controller=controllerHome&action=mostrarHome#incio'?>>Inicio</a></li>
                <li><a href=<?php echo URL_PATH.'/index.php?controller=controllerHome&action=mostrarProductos'?>>Productos</a></li>
                <li><a href=<?php echo URL_PATH.'/index.php?controller=controllerHome&action=mostrarHome#ofertas'?>>Ofertas</a></li>
                <li><a href=<?php echo URL_PATH.'/index.php?controller=controllerHome&action=mostrarHome#categorias'?>>Categorias</a></li>
                <li><a href=<?php echo URL_PATH.'/index.php?controller=controllerHome&action=mostrarNosotros'?>>Nosotros</a></li>
                <li><a href=<?php echo URL_PATH.'/index.php?controller=controllerHome&action=mostrarInfoContacto'?>>Contacto</a></li>
                <li><a href=<?php echo URL_PATH.'/index.php?controller=controllerHome&action=mostrarCarrito'?> id="nav-parte-dos"><img src="<?php echo $img;?>carrito.png" alt="Carrito" class="user"></a></li>
                <li><a href=<?php echo URL_PATH.'/index.php?controller=controllerHome&action=mostrarLogin'?>><img src="<?php echo $img;?>user.png" alt="Perfil de usuario" class="user"></a></li>
                <li><a href=<?php echo URL_PATH.'/index.php?controller=controllerUsuario&action=logoutUsuario'?>><img src="<?php echo $img;?>exit.png" alt="Logout" class="user"></a></li>
            </ul>
        </nav>
    </header>