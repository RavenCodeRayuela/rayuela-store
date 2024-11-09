<?php
    $css = URL_PATH.'/public/css/styles.css';
    $js = URL_PATH.'/public/js/admin-script.js';
    $img = URL_PATH.'/public/img/';

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
        }
        
    if($_SESSION !=[]){
        if (!isset($_SESSION['user_email'])) {
            header('Location:'.URL_PATH.'/index.php?controller=controllerHome&action=mostrarLogin');
            exit();
        }
        if(isset($_SESSION['nombre']) && $_SESSION['nombre']!='Nombre no asignado'){
            $nombre = $_SESSION['nombre'];
        }
    }

    $paginaActualSidebar = "datosPersonales";
    
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href=<?php echo $css; ?> rel="stylesheet" type="text/css">
    <title>Rayuela Store</title>
</head>
<body>

    <?php include_once 'viewHeader.php'?>

    <!-- Contenido Principal -->
    <main class="container comienzoPagina">

        <!-- Barra lateral -->
        <?php include_once 'viewSidebarCliente.php'?>

        <!-- Contenido principal -->
        <div class="main-content" id="contenido">
            <h1>Datos personales</h1>
            <h2>Añade información sobre tí</h2>
                <hr>
            <div class="form-container">
                <h3>Información básica</h3>
                <form action="#" method="POST">

                    <div class="form-group">
                        <label for="name">Nombre</label>
                        <input type="text" id="name" name="name" placeholder="Ingresa tu nombre" required>
                    </div>

                    <div class="form-group">
                        <label for="phone">Celular</label>
                        <input type="tel" id="phone" name="phone" placeholder="Ingresa tu número de celular" required>
                    </div>

                    <div class="form-group checkbox-container">
                        <label for="newsletter">Suscribirse al Newsletter</label>
                        <input type="checkbox" id="newsletter" name="newsletter">
                        
                    </div>

                    <input type="submit" value="Guardar" class="submit-btn">
                </form>
            </div>
        </div>

    </main>


    <?php include_once 'viewFooter.php'?>

</body>
</html>