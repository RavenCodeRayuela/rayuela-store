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
        if(isset($_SESSION['nombre'])){
            $nombre = $_SESSION['nombre'];
        }
    }
    
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
    <main class="container">

        <!-- Barra lateral -->
        <div class="sidebar">
            <h3><?php echo "Bienvenido ".$nombre; ?></h3>
            <a href="#" onclick="mostrarContenido('datos')">Datos personales</a>
            <a href="#" onclick="mostrarContenido('historial')">Historial de compras</a>
            <a href="#" onclick="mostrarContenido('direcciones')">Direcciones de envío</a>
            <a href="#" onclick="mostrarContenido('eliminar')">Eliminar cuenta</a>
        </div>

        <!-- Contenido principal -->
        <div class="main-content" id="contenido">
            <h1>Título de subnavegación</h1>
            <p>Aquí irá todo lo relacionado a la opción seleccionada en el menú de subnavegación.</p>
        </div>

    </main>


    <?php include_once 'viewFooter.php'?>

</body>
</html>