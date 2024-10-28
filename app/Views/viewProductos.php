<?php
    $css = URL_PATH.'/public/css/styles.css';
    $img = URL_PATH.'/public/img/';
    
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
        }

        $singleProduct= URL_PATH.'/index.php?controller=controllerHome&action=mostrarSingleProduct';
        
        $listarCatalogo =URL_PATH.'/index.php?controller=controllerHome&action=mostrarProductos&categoria='.$categoria;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href=<?php echo $css; ?> rel="stylesheet" type="text/css">
    <title>Productos</title>
</head>
<body>

<?php include_once 'viewHeader.php'?>
    
<!-- Lista de categorías -->
<aside class="sidebar-productos">
        <h2>Categorías</h2>
        <hr>
        <nav class="category-list">
            <?php foreach ($categorias as $cat):?>
            <a href="#"><?php echo $cat['Nombre_categoria'];?></a>
            <?php endforeach;?>
        </nav>
    </aside>

    <!-- Sección de productos -->
    <section class="products">
        <h2><?php echo $categoria == 'all' ? 'Todos los productos' : $categoria  ?></h2>
        
        <div class="sort-filter">
            <span>Cantidad de artículos: <?php echo $totalProductos;?></span>
            <button>Ordenar por</button>
        </div>
        <hr>
        <div class="product-grid">
            <?php foreach ($productos as $producto):?>
                
            <div class="product-item">
                <div class="product-image">
                    <img src="<?php echo URL_PATH.$producto['imagenes'][0]?>" alt="Producto 1" class="default-img">
                    <img src="<?php echo URL_PATH.$producto['imagenes'][1]?>" alt="Producto 1 Hover" class="hover-img">
                </div>
                <a href="<?php echo $singleProduct;?>"><?php echo $producto['Nombre']?></a>
                <p><?php echo 'UYU '.$producto['Precio_actual']?></p>
            </div>
            <?php endforeach;?>
        </div>
    </section>

    <?php if (isset($totalPaginas) && $totalPaginas > 1): ?>
                    <div class="pagination">
                        <?php if ($paginaActual > 1): ?>
                            <a href="<?php echo $listarCatalogo;?>&page=<?= $paginaActual - 1 ?>">&laquo; Anterior</a>
                        <?php endif; ?>
                
                        <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                            <a href="<?php echo $listarCatalogo;?>&page=<?= $i ?>" class="<?= $i == $paginaActual ? 'active' : '' ?>">
                                <?= $i ?>
                            </a>
                        <?php endfor; ?>
                
                        <?php if ($paginaActual < $totalPaginas): ?>
                            <a href="<?php echo $listarCatalogo;?>&page=<?= $paginaActual + 1 ?>">Siguiente &raquo;</a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

    <?php include_once 'viewFooter.php'?>
</body>
</html>