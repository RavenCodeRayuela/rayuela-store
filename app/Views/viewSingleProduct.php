<?php
    $css = URL_PATH.'/public/css/styles.css';
    $img = URL_PATH.'/public/img/';
    $js =URL_PATH.'/public/js/single-product.js';
    $agregarAcarrito= URL_PATH.'/index.php?controller=controllerCompra&action=agregarProductoCarrito&';

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
    <title><?php echo $producto->getNombre()?></title>
</head>
<body>

    <?php include_once 'viewHeader.php'?>
    <main class="single-product-main comienzoPagina">
    <div class="single-product-container">
        <div class="single-product-images">
            <div class="main-image">
                <img id="mainImage" src="<?php echo URL_PATH.$imagenes[0]; ?>" alt="Imagen principal de <?php echo $producto->getNombre(); ?>">
            </div>
            <div class="thumbnail-images">
                <!--Cambiar por un foreach-->
                <img src="<?php echo URL_PATH.$imagenes[0]; ?>" alt="Miniatura 1" onclick="changeMainImage(this)">
                <img src="<?php echo URL_PATH.$imagenes[1]; ?>" alt="Miniatura 2" onclick="changeMainImage(this)">
                <img src="<?php echo URL_PATH.$imagenes[2]; ?>" alt="Miniatura 3" onclick="changeMainImage(this)">
            </div>
        </div>
        <div class="single-product-details">
            
            <h1><?php echo $producto->getNombre(); ?></h1>

            <div class="precio-producto"><?php echo 'UYU '.$producto->getPrecio(); ?></div>
            
            <div class="cantidad-producto">
                <form method="POST" action="<?php echo $agregarAcarrito;?>">

                    <input type="hidden" name="id" value="<?php echo $producto->getId(); ?>">

                    <label for="cantidad">Cantidad</label>
                    <select name="cantidad" id="cantidad">
                        <?php for ($i = 1; $i <= $producto->getCantidad(); $i++): ?>
                            <option value="<?php echo $i;?>"><?php echo $i; ?></option>
                        <?php endfor; ?>
                    </select>
                
                    <input type="submit" class="add-to-cart" value="Agregar al carrito">
                </form>
            </div>
            <div class="descripcion-producto">
                <h2>Descripción del Producto</h2>
                <p><?php echo $producto->getDescripcion(); ?></p>
            </div>
            <div class="categoria-s-producto">
                Categoría: <span><?php echo $categoria->getNombre(); ?></span>
            </div>

            <?php if(isset($_SESSION['msjProdAgregadoACarrito'])):?>
                <p style="color: green; font-size: large;" ><?php echo $_SESSION['msjProdAgregadoACarrito'];?></p>
             <?php endif;?>
        </div>
    </div>
   
</main>
<script src="<?php echo $js;?>"></script>
    <?php include_once 'viewFooter.php'?>
</body>
</html>