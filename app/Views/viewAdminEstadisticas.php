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
    <main class="comienzoPagina">
    <div class="main-content">
        <div>
            <h1>Estadísticas de ventas</h1>
            <hr>
        </div>
        <div>
            <h3>Productos más vendidos</h3>
            <hr>
            <table class="tabla-listar">
                        <thead>
                            <tr>
                                <th class="primer-columna">ID</th>
                                <th>Nombre de producto</th>
                                <th>Categoría</th>
                                <th>Ventas</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($productosVendidos as $producto): ?>
                                <tr>
                                    <td class="primer-columna"><?= htmlspecialchars($producto['Id_producto']) ?></td>
                                    <td><?= htmlspecialchars($producto['Nombre']) ?></td>
                                    <td><?= htmlspecialchars($producto['Categoria']) ?></td>
                                    <td><?= htmlspecialchars($producto['total_vendido']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
            </table>
        </div>
        <div>
            <h3>Ganancias generadas</h3>
            <hr>
                <table class="tabla-listar">
                    <thead>
                        <tr>
                            <th>Año</th>    
                            <th>Mes</th>
                            <th>Semana</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Año: $<?= $ventasAnio ?></td>
                            <td>Mes: $<?= $ventasMes ?></td>
                            <td>Semana: $<?= $ventasSemana ?></td>
                        </tr>
                    </tbody>
                </table>
        </div>
    </div>
</main>
    
    <?php include_once 'viewMensaje.php';?>
    <?php include_once 'viewFooter.php';?>

</body>
</html>
