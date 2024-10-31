<?php
    
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
        }

    
        if (!isset($_SESSION['user_email']) || $_SESSION['rol']!="cliente") {
            header('Location:'.URL_PATH.'/index.php?controller=controllerHome&action=mostrarLogin');
            exit();
        }

    
    $css = URL_PATH.'/public/css/styles.css';
    $img = URL_PATH.'/public/img/';
    $eliminarItem= URL_PATH.'/index.php?controller=controllerCompra&action=eliminarProductoCarrito&id=';;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href=<?php echo $css; ?> rel="stylesheet" type="text/css">
    <title>Carrito de Compras</title>
    <link rel="stylesheet" href="carrito.css">
</head>
<body>
<?php include_once 'viewHeader.php'?>
    <main class="cart-container">
        <h1>Carrito de Compras</h1>
        
        <div class="cart-items">
            <?php foreach ($productos as $item):?>
                <div class="cart-item">
                    <img src="ruta/imagen-producto.jpg" alt="Producto 1">
                    <div class="product-details">
                        <h2><?php echo $item['producto']->getNombre();?></h2>
                        <p class="precio-cart">Costo de producto/s: <?php echo $item['producto']->getPrecio()*$item['cantidad'];?> UYU</p>
                        <div class="cantidad-cart">
                            <label for="cantidad">Cantidad:</label>
                            <input type="number" id="cantidad" min="1" value="<?php echo $item['cantidad']?>">
                        </div>
                        <a class="remove-btn" href="<?php echo $eliminarItem.$item['producto']->getId();?>">Eliminar</a>
                    </div>
                </div>
            <?php endforeach;?>
        </div>
        
        <div class="resumen-cart">
            <h3>Resumen del Pedido</h3>
            <div class="item-resumen">
                <span>Total:</span>
                <span class="precio-cart-total"></span>
            </div>
            <a class="checkout-btn">Comprar</a>
        </div>
    </main>
<?php include_once 'viewFooter.php'?>
</body>
</html>