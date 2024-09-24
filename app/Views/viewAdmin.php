<?php
    session_start();
    if (!isset($_SESSION['user_email']) || $_SESSION['rol']!="admin") {
        header('Location:'.URL_PATH.'viewFormLogin.php');
        exit();
    }
    //Quitar require cuando se maneje todo desde el controlador.
    require_once dirname(__DIR__,2)."/config/paths.php";
    $css = URL_PATH.'/public/css/styles.css';
    $action = URL_PATH.'/index.php?controller=controllerProducto&action=agregarProducto';
    $js = URL_PATH.'/public/js/admin-script.js';
    $img = URL_PATH.'/public/img/';
    
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href=<?php echo $css; ?> rel="stylesheet" type="text/css">
    <title>Gestion de productos</title>
</head>
<body>

    <!-- Encabezado con barra de navegación -->
    <header>
        <div class="logo">
            <a href="#inicio">
                <img src="<?php echo $img;?>rayuela.png" alt="Logo Rayuela">
            </a>
        </div>
        <nav>
            <ul>
                <li><a href="#inicio">Inicio</a></li>
                <li><a href="#productos">Productos</a></li>
                <li><a href="#categorias">Categorias</a></li>
                <li><a href="#stock">Stock</a></li>
            </ul>
        </nav>
    </header>

    <!-- Contenido Principal -->
    <main>
        <section id="inicio">
            <h1>Pagina de gestión de stock</h1>
        </section>
    </main>

    <!-- Pie de página -->
    <footer>
            <div class="social-icons">
                <a href="https://facebook.com" target="_blank" aria-label="Facebook"><img src="<?php echo $img;?>facebook.png" alt="Facebook" width="5%"></a>
                <a href="https://web.whatsapp.com/" target="_blank" aria-label="Whatsapp"><img src="<?php echo $img;?>whatsapp.png" alt="Whatsapp" width="5%"></a>
                <a href="https://instagram.com" target="_blank" aria-label="Instagram"><img src="<?php echo $img;?>instagram.png" alt="Instagram" width="5%"></a>
            </div>
        
            <ul class="contact-info">
                <li>Teléfono: ...</li>
                <li>Email: ...</li>
                <li>Dirección: ...</li>
            </ul>
    </footer>

</body>
</html>
