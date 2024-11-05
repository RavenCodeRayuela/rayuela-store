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
    $editarCategoria = URL_PATH.'/index.php?controller=controllerGestion&action=editarCategoria';
    $eliminarCategoria = URL_PATH.'/index.php?controller=controllerGestion&action=eliminarCategoria';
    $agregarCategoria= URL_PATH.'/index.php?controller=controllerHome&action=mostrarAgregarCategoria';
    $listarCategorias= URL_PATH.'/index.php?controller=controllerGestion&action=listarCategorias';

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href=<?php echo $css; ?> rel="stylesheet" type="text/css">
    <title>Lista de categorías</title>
</head>
<body>

    
   <?php include_once 'viewHeaderAdmin.php'?>
        <!-- Listar Categorias -->
    <div id="listar" class="container-listar">
            <div class="header-lista">
                <h1>Lista de categorías</h1><a href="<?php echo $agregarCategoria;?>" class="btn listar">Agregar Categoría</a>
            </div>    
  
        <div>
            <?php
                if ($categorias) {
                        echo "<table class='tabla-listar'>";
                        echo "<tr><th>ID</th><th>Nombre</th><th>Descripción</th><th>Imagen</th><th>Modificar</th><th>Eliminar</th></tr>";
                        foreach ($categorias as $categoria) {
                            echo "<tr>";
                            echo "<td>" . $categoria['Id_categoria']. "</td>";
                            echo "<td>" . $categoria['Nombre_categoria'] . "</td>";
                            echo "<td>" . $categoria['Descripcion_categoria'] . "</td>";
                            echo "<td><img src='" . URL_PATH.$categoria['Ruta_imagen_categoria'] . "'alt'='Imagen de categoria' width='100' class='img-thumbnail'></td>";
                            echo "<td><a class='btn modificar' href=".$editarCategoria."&id=".$categoria['Id_categoria'].">"."Modificar"."</a></td>";
                            echo "<td><a class='btn eliminar' href=".$eliminarCategoria."&id=".$categoria['Id_categoria'].">"."Eliminar"."</a></td>";
                            echo "</tr>";
                        }
                        echo "</table>";
                    } else {
                        echo "No hay productos disponibles.";
                    }
            ?>
        </div>
    

        <?php if (isset($totalPaginas) && $totalPaginas > 1): ?>
                    <div class="pagination">
                        <?php if ($paginaActual > 1): ?>
                            <a href="<?php echo $listarCategorias;?>&page=<?= $paginaActual - 1 ?>">&laquo; Anterior</a>
                        <?php endif; ?>
                
                        <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                            <a href="<?php echo $listarCategorias;?>&page=<?= $i ?>" class="<?= $i == $paginaActual ? 'active' : '' ?>">
                                <?= $i ?>
                            </a>
                        <?php endfor; ?>
                
                        <?php if ($paginaActual < $totalPaginas): ?>
                            <a href="<?php echo $listarCategorias;?>&page=<?= $paginaActual + 1 ?>">Siguiente &raquo;</a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
    </div>
    
    <?php include 'viewMensaje.php'?>
    <?php include_once 'viewFooter.php'?>

</body>
</html>
        
