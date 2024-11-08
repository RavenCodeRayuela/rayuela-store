<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_email']) || $_SESSION['rol'] != "cliente") {
    setMensaje("No eres cliente o no estás logueado, inicia sesión para comprar", "error");
    header('Location:' . URL_PATH . '/index.php?controller=controllerHome&action=mostrarLogin');
    exit();
}

$css = URL_PATH . '/public/css/styles.css';
$img = URL_PATH . '/public/img/';
$eliminarItem = URL_PATH . '/index.php?controller=controllerCompra&action=eliminarProductoCarrito&id=';
$action = URL_PATH ."/index.php?controller=controllerCompra&action=procesarCompra";
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
<?php include_once 'viewHeader.php' ?>
<main class="cart-container">
    <h1>Carrito de Compras</h1>
    
    <form action="<?php echo $action; ?>" method="POST">
    <div class="cart-items">
        <?php foreach ($productos as $index => $item): ?>
            <div class="cart-item">
            <img src="<?php echo URL_PATH . $item['imagen']; ?>" alt="Imagen de <?php echo $item['producto']->getNombre(); ?>" class="img-thumbnail" style="width:100px; height:100px;">
            <div class="product-details">
                <h2><?php echo $item['producto']->getNombre(); ?></h2>
                <span class="oferta-descuento">
                    <?php echo "-" . $item['producto']->getDescuento() . "% "; ?>
                </span>
                <span class="precio-cancel-carrito">
                    <?php echo "UYU " . $item['producto']->getPrecio() * $item['cantidad']; ?>
                </span>
                <p class="precio-cart">Costo de producto/s: 
                    <?php echo $item['producto']->getPrecioConDescuento() * $item['cantidad']; ?> UYU
                </p>
                <div class="cantidad-cart">
                    <label for="cantidad">Cantidad:</label>
                    <span><?php echo $item['cantidad']; ?></span>
                </div>
                <a class="remove-btn" href="<?php echo $eliminarItem . $item['producto']->getId(); ?>">Eliminar</a>
                
                <!-- Inputs ocultos para enviar los datos del carrito -->
                <input type="hidden" name="productos[<?php echo $index; ?>][id]" value="<?php echo $item['producto']->getId(); ?>">
                <input type="hidden" name="productos[<?php echo $index; ?>][cantidad]" value="<?php echo $item['cantidad']; ?>">
                <input type="hidden" name="productos[<?php echo $index; ?>][precio]" value="<?php echo $item['producto']->getPrecioConDescuento(); ?>">
            </div>
        </div>
        <?php endforeach; ?>
    </div>
        
        <div class="resumen-cart">
            <h3>Resumen del Pedido</h3>
            <div class="item-resumen">
                <span class="precio-cart-total">Total: <?php
                    $total = 0;
                    foreach ($productos as $item) {
                        $total += $item['producto']->getPrecioConDescuento() * $item['cantidad'];
                    }
                    echo $total . ' UYU';?>
                </span>
            </div>
            <input type="submit" class="checkout-btn" value="Comprar">
        </div>
    </form>
</main>

<?php include 'viewMensaje.php'; ?>
<?php include_once 'viewFooter.php' ?>
</body>
</html>