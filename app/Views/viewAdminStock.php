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
    $mostrarStock= URL_PATH."/index.php?controller=controllerHome&action=mostrarStock";
    
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href=<?php echo $css; ?> rel="stylesheet" type="text/css">
    <link rel="icon" type="image/x-icon" href="<?= $img."favicon.png";?>">
    <title>Stock</title>
</head>
<body>

   <?php include_once 'viewHeaderAdmin.php';?>

    <!-- Contenido Principal -->
    <main class="comienzoPagina">
    <div class="main-content" id="contenido">
        <h1>Productos en stock</h1>
            <?php if (isset($productos) && count($productos) > 0): ?>
                <table class="tabla-listar">
                    <thead>
                        <tr>
                            <th class="primer-columna">ID</th>
                            <th>Nombre de producto</th>
                            <th>Cantidad</th>
                            <th>Agregar producto</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($productos as $producto): ?>
                            <tr>
                                <td class="primer-columna"><?= htmlspecialchars($producto['Id_producto']) ?></td>
                                <td><?= htmlspecialchars($producto['Nombre']) ?></td>
                                <td><?= htmlspecialchars($producto['Cantidad']) ?></td>
                                <td><a  href="<?=URL_PATH.'/index.php?controller=controllerGestion&action=editarProducto'."&id=".$producto['Id_producto']."&modImagen=false"?>">Modificar</a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="no-compras">No hay productos en stock</p>
            <?php endif; ?>

            <?php if (isset($totalPaginas) && $totalPaginas > 1): ?>
                    <div class="pagination">
                        <?php if ($paginaActual > 1): ?>
                            <a href="<?php echo $mostrarStock;?>&page=<?= $paginaActual - 1 ?>">&laquo; Anterior</a>
                        <?php endif; ?>
                
                        <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                            <a href="<?php echo $mostrarStock;?>&page=<?= $i ?>" class="<?= $i == $paginaActual ? 'active' : '' ?>">
                                <?= $i ?>
                            </a>
                        <?php endfor; ?>
                
                        <?php if ($paginaActual < $totalPaginas): ?>
                            <a href="<?php echo  $mostrarStock;?>&page=<?= $paginaActual + 1 ?>">Siguiente &raquo;</a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
        </div>
    </main>
    <?php include_once 'viewMensaje.php';?>
    <?php include_once 'viewFooter.php';?>

</body>
</html>
