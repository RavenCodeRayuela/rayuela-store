 <!-- Encabezado con barra de navegación -->
 <header>
        <div class="logo">
            <a href="#inicio">
                <img src="<?php echo $img;?>rayuela.png" alt="Logo Rayuela">
            </a>
        </div>
        <nav>
            <ul>
            <li><a href=<?php echo URL_PATH.'/index.php?controller=controllerHome&action=mostrarHome'?>>Inicio</a></li>
                <li><a href=<?php echo URL_PATH.'/index.php?controller=controllerGestion&action=listarProductos'?>>Productos</a></li>
                <li><a href=<?php echo URL_PATH.'/index.php?controller=controllerGestion&action=listarCategorias'?>>Categorías</a></li>
                <li><a href="#stock">Estadisticas</a></li>
                <li><a href=<?php echo URL_PATH.'/index.php?controller=controllerUsuario&action=logoutUsuario'?>><img src="<?php echo $img;?>exit.png" alt="Logout" class="user"></a></li>
            </ul>
        </nav>
    </header>