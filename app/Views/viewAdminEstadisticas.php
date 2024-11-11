<?php
     if (session_status() === PHP_SESSION_NONE) {
        session_start();
        }
    if($_SESSION !=[]){
        if (!isset($_SESSION['user_email']) || $_SESSION['rol']!="admin") {
            header('Location:'.URL_PATH.'/index.php?controller=controllerHome&action=mostrarLogin');
            exit();
        }
    }
    $css = URL_PATH.'/public/css/styles.css';
    $img = URL_PATH.'/public/img/';
    
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href=<?php echo $css; ?> rel="stylesheet" type="text/css">
    <link rel="icon" type="image/x-icon" href="<?= $img."favicon.png";?>">
    <title>Estadisticas de ventas</title>
</head>
<body>

   <?php include_once 'viewHeaderAdmin.php';?>

    <!-- Contenido Principal -->
    <main class="comienzoPagina main-content">
    <div>
        <h1>Estadísticas de ventas</h1>
        <hr>
    </div>
    <div>
        <h3>Productos más vendidos</h3>
        <hr>
        <ul>
            <?php 
            foreach ($productosVendidos as $producto) {
                echo "<li>{$producto['Nombre']} - Vendidos: {$producto['total_vendido']}</li>";
            }
            ?>
        </ul>
    </div>
    <div>
        <h3>Ganancias generadas</h3>
        <hr>
        <p>Año: $<?= $ventasAnio ?></p>
        <p>Mes: $<?= $ventasMes ?></p>
        <p>Semana: $<?= $ventasSemana ?></p>
    </div>
</main>
    
    <?php include_once 'viewMensaje.php';?>
    <?php include_once 'viewFooter.php';?>

</body>
</html>
