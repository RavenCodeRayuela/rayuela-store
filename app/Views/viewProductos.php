<?php
    $css = URL_PATH.'/public/css/styles.css';
    $img = URL_PATH.'/public/img/';
    
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
        }

        $singleProduct= URL_PATH.'/index.php?controller=controllerHome&action=mostrarSingleProduct&id=';
        
        $listarCatalogo =URL_PATH.'/index.php?controller=controllerHome&action=mostrarProductos&categoria='.$categoria;

        $productosPorCategoriaURL= URL_PATH.'/index.php?controller=controllerHome&action=mostrarProductos&categoria=';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href=<?php echo $css; ?> rel="stylesheet" type="text/css">
    <link rel="icon" type="image/x-icon" href="<?= $img."favicon.png";?>">
    <title>Productos</title>
</head>
<body>

<?php include_once 'viewHeader.php'?>
    
<!-- Lista de categorías -->
 <div class="main-container-prod">

        <aside class="sidebar-productos">
            <h2>Categorías</h2>
            <hr>
            <nav class="category-list">
                <?php foreach ($categorias as $cat):?>
                <a href="<?php echo $productosPorCategoriaURL.$cat['Id_categoria']; ?>"><?php echo $cat['Nombre_categoria'];?></a>
                <?php endforeach;?>
            </nav>
        </aside>

    <!-- Sección de productos -->
    <section class="products">
        <h2><?php echo $categoria == 'all' ? 'Todos los productos' : $category->getNombre()  ?></h2>
        <h3 class="no-compras" style="margin-top:-30px"><?php echo $categoria == 'all' ? 'Aqui se muestran todos los productos sin filtrar.' : $category->getDescripcion();  ?></h3>
        <p style="margin-left:auto; margin-right:auto;">Cantidad de artículos: <?php echo $totalProductos;?></p>
        <hr>
        
        <div class="product-grid">

            <?php foreach ($productos as $producto):?>

           <a class="product-item-container" href="<?php echo $singleProduct.$producto['Id_producto'];?>" >
                <div class="product-item">
                    <div class="product-image">
                        <img src="<?php echo URL_PATH.$producto['imagenes'][0]?>" alt="Producto" class="default-img">
                        <?php if(isset($producto['imagenes'][1])):?>
                            <img src="<?php echo URL_PATH.$producto['imagenes'][1]?>" alt="Producto Hover" class="hover-img">
                        <?php else:?>
                            <img src="<?php echo $img;?>rayuela.png" alt="Producto Back Hover" class="hover-img">
                        <?php endif;?>
                    </div>
                    <p><?php echo $producto['Nombre']?></p>
                    <?php if($producto['Descuento']!=0):?>
                    <p class ="precio-cancel-oferta"><?php echo 'UYU '.$producto['Precio_actual']?></p>
                        <p class="precio-oferta"><?php echo 'UYU '.($producto['Precio_actual']-($producto['Precio_actual']*($producto['Descuento']/100)))?></p>
                        <p><?php echo $producto['Descuento'].'% Descuento'?></p>
                    <?php else:?>
                        <p><?php echo 'UYU '.$producto['Precio_actual']?></p>
                    <?php endif;?>
                </div>
            </a>
            <?php endforeach;?>

        </div>

        <div>
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

        </div>

    </section>
  
 </div>          
    <?php include_once 'viewFooter.php'?>
</body>
</html>