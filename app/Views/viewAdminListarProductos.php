<?php

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['user_email']) || $_SESSION['rol']!="admin") {
        header('Location:'.URL_PATH.'/index.php?controller=controllerHome&action=mostrarLogin');
        exit();
    }
    
    $css = URL_PATH.'/public/css/styles.css';
    $img = URL_PATH.'/public/img/';
    $editarProducto = URL_PATH.'/index.php?controller=controllerGestion&action=editarProducto';
    $eliminarProducto = URL_PATH.'/index.php?controller=controllerGestion&action=eliminarProducto';
    $agregarProductos= URL_PATH.'/index.php?controller=controllerHome&action=mostrarAgregarProducto';

    $listarProductos= URL_PATH.'/index.php?controller=controllerGestion&action=listarProductos';

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

    
   <?php include_once 'viewHeaderAdmin.php'?>

   <!-- Listar Productos -->
<div id="listar" class="container-listar">
    <div class="header-lista">
        <h1>Lista de Productos</h1><a href="<?php echo $agregarProductos;?>" class="btn listar">Agregar producto</a>
   </div>
    <div id="tablaProductos">
        <?php
            if ($productos) {
                echo "<table class='tabla-listar'>";
                echo "<tr><th>ID</th><th>Nombre</th><th>Descripción</th><th>Cantidad</th><th>Precio</th><th>Descuento</th><th>Imágenes</th><th>Categoría</th><th>Modificar</th><th>Eliminar</th></tr>";
                
                foreach ($productos as $producto) {
                    echo "<tr>";
                    echo "<td>" . $producto['Id_producto']. "</td>";
                    echo "<td>" . $producto['Nombre'] . "</td>";
                    echo "<td>" . $producto['Descripcion_producto'] . "</td>";
                    echo "<td>" . $producto['Cantidad'] . "</td>";
                    echo "<td>" . $producto['Precio_actual'] . "</td>";
                    echo "<td>" . $producto['Descuento'] . "%</td>";
                    echo "<td class='td-imagenes'>";
                    
                    foreach($producto['imagenes'] as $imagen) {
                        echo "<img src='" . URL_PATH . $imagen . "' alt='Imagen de producto' class='img-thumbnail'>";
                    }

                    echo "</td>";
                    echo "<td>" . $producto['categoria'] . "</td>";
                    echo "<td><a class='btn modificar' href=".$editarProducto."&id=".$producto['Id_producto'].">"."Modificar"."</a></td>";
                    echo "<td><a class='btn eliminar' href=".$eliminarProducto."&id=".$producto['Id_producto'].">"."Eliminar"."</a></td>";
                    echo "</tr>";
                }
                
                echo "</table>";

                
            } else {
                echo "No hay productos disponibles.";
            }
        ?>
        <?php if (isset($totalPaginas) && $totalPaginas > 1): ?>
                    <div class="pagination">
                        <?php if ($paginaActual > 1): ?>
                            <a href="<?php echo $listarProductos;?>&page=<?= $paginaActual - 1 ?>">&laquo; Anterior</a>
                        <?php endif; ?>
                
                        <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                            <a href="<?php echo $listarProductos;?>&page=<?= $i ?>" class="<?= $i == $paginaActual ? 'active' : '' ?>">
                                <?= $i ?>
                            </a>
                        <?php endfor; ?>
                
                        <?php if ($paginaActual < $totalPaginas): ?>
                            <a href="<?php echo $listarProductos;?>&page=<?= $paginaActual + 1 ?>">Siguiente &raquo;</a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
    </div>
</div>

<?php
        // Mostrar errores si existen
            if (!empty($errores)) {
                echo "<p id='mensajeEstado' style='color:red; text-align:center; font-size:1.5rem; margin-bottom: 10px;'>$errores</p>";
            }
        // Mostrar msj exito si existe
            if(!empty($mensajeExito)){
                echo "<p id='mensajeEstado' style='color:green; text-align:center; font-size:1.5rem; margin-bottom: 10px;'>$mensajeExito</p>";
            }
        
        ?>
   
    <?php include_once 'viewFooter.php'?>

</body>
</html>
