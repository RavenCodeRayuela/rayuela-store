<?php
    $css = URL_PATH.'/public/css/styles.css';
    $img = URL_PATH.'/public/img/';
    $singleProduct= URL_PATH.'/index.php?controller=controllerHome&action=mostrarSingleProduct';
    
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
        }
         
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
            <a href="#">Categoría 1</a>
            <a href="#">Categoría 2</a>
            <a href="#">Categoría 3</a>
            <a href="#">Categoría 4</a>
        </nav>
    </aside>

    <!-- Sección de productos -->
    <section class="products">
        <h2>Nombre de categoría seleccionada</h2>
        
        <div class="sort-filter">
            <span>Cantidad de artículos: 9</span>
            <button>Ordenar por</button>
        </div>
        <hr>
        <div class="product-grid">
            <div class="product-item">
                <div class="product-image">
                    <img src="imagen1.jpg" alt="Producto 1" class="default-img">
                    <img src="imagen1_hover.jpg" alt="Producto 1 Hover" class="hover-img">
                </div>
                <a href="<?php echo $singleProduct;?>">Nombre del Producto</a>
                <p>$50.00</p>
            </div>
            <div class="product-item">
                <div class="product-image">
                    <img src="imagen2.jpg" alt="Producto 2" class="default-img">
                    <img src="imagen2_hover.jpg" alt="Producto 2 Hover" class="hover-img">
                </div>
                <h3>Nombre del Producto</h3>
                <p>$60.00</p>
            </div>
            <div class="product-item">
                <div class="product-image">
                    <img src="imagen2.jpg" alt="Producto 2" class="default-img">
                    <img src="imagen2_hover.jpg" alt="Producto 2 Hover" class="hover-img">
                </div>
                <h3>Nombre del Producto</h3>
                <p>$60.00</p>
            </div>
            <div class="product-item">
                <div class="product-image">
                    <img src="imagen2.jpg" alt="Producto 2" class="default-img">
                    <img src="imagen2_hover.jpg" alt="Producto 2 Hover" class="hover-img">
                </div>
                <h3>Nombre del Producto</h3>
                <p>$60.00</p>
            </div>
            <div class="product-item">
                <div class="product-image">
                    <img src="imagen2.jpg" alt="Producto 2" class="default-img">
                    <img src="imagen2_hover.jpg" alt="Producto 2 Hover" class="hover-img">
                </div>
                <h3>Nombre del Producto</h3>
                <p>$60.00</p>
            </div>
            <div class="product-item">
                <div class="product-image">
                    <img src="imagen2.jpg" alt="Producto 2" class="default-img">
                    <img src="imagen2_hover.jpg" alt="Producto 2 Hover" class="hover-img">
                </div>
                <h3>Nombre del Producto</h3>
                <p>$60.00</p>
            </div>
            <div class="product-item">
                <div class="product-image">
                    <img src="imagen2.jpg" alt="Producto 2" class="default-img">
                    <img src="imagen2_hover.jpg" alt="Producto 2 Hover" class="hover-img">
                </div>
                <h3>Nombre del Producto</h3>
                <p>$60.00</p>
            </div>
            <div class="product-item">
                <div class="product-image">
                    <img src="imagen2.jpg" alt="Producto 2" class="default-img">
                    <img src="imagen2_hover.jpg" alt="Producto 2 Hover" class="hover-img">
                </div>
                <h3>Nombre del Producto</h3>
                <p>$60.00</p>
            </div>
            <div class="product-item">
                <div class="product-image">
                    <img src="imagen2.jpg" alt="Producto 2" class="default-img">
                    <img src="imagen2_hover.jpg" alt="Producto 2 Hover" class="hover-img">
                </div>
                <h3>Nombre del Producto</h3>
                <p>$60.00</p>
            </div>
        </div>
    </section>
    <?php include_once 'viewFooter.php'?>
</body>
</html>