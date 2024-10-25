<?php
    $css = URL_PATH.'/public/css/styles.css';
    $img = URL_PATH.'/public/img/';
    
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
    <title>Single product</title>
</head>
<body>

    <?php include_once 'viewHeader.php'?>
        <main class="single-product-main comienzoPagina">
            <div class="single-product-container">
                <div class="single-product-images">
                    <div class="main-image">
                        <img src="producto-principal.jpg" alt="Imagen principal del producto">
                    </div>
                    <div class="thumbnail-images">
                        <img src="producto-1.jpg" alt="Miniatura 1">
                        <img src="producto-2.jpg" alt="Miniatura 2">
                        <img src="producto-3.jpg" alt="Miniatura 3">
                        <img src="producto-4.jpg" alt="Miniatura 4">
                    </div>
                </div>
                <div class="single-product-details">
                    <h1>Título del Producto</h1>
                    <div class="precio-producto">Precio: $99.99</div>
                    <div class="cantidad-producto">
                        Cantidad: 
                        <select>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                        </select>
                    </div>
                    <button class="add-to-cart">Agregar al carrito</button>
                    <div class="descripcion-producto">
                        <h2>Descripción del Producto</h2>
                        <p>Esta es una breve descripción del producto. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce nec sagittis dui.</p>
                    </div>
                    <div class="categoria-s-producto">
                        Categoría: <span>Categoría del Producto</span>
                    </div>
                </div>
            </div>
        </main>

    <?php include_once 'viewFooter.php'?>
</body>
</html>