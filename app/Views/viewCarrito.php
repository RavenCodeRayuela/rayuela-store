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
            <?php foreach ($productos as $indice => $item): ?>
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
                        
                        <input type="hidden" name="productos[<?php echo $indice; ?>][idProducto]" value="<?php echo $item['producto']->getId(); ?>">
                        <input type="hidden" name="productos[<?php echo $indice; ?>][cantidadProducto]" value="<?php echo $item['cantidad']; ?>">
                        <input type="hidden" name="productos[<?php echo $indice; ?>][precioProducto]" value="<?php echo $item['producto']->getPrecioConDescuento(); ?>">
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

            <?php if(!empty($direcciones)):?>
                <h4>Selecciona una dirección de envío</h4>
                <div class="direccion-lista">
                <?php foreach ($direcciones as $key => $direccion): ?>
                        <div class="direccion-card">
                            <input type="radio" id="direccion-<?php echo $key; ?>" name="idDireccion" value="<?php echo $direccion->getIdDireccion(); ?>" required>
                            <label for="direccion-<?php echo $key;?>">
                                <h3><?php echo htmlspecialchars($direccion->getCiudad()); ?></h3>
                                <p><strong>Calle: </strong><?php echo htmlspecialchars($direccion->getCalle()); ?></p>
                                <p><strong>Nro casa:</strong><?php echo htmlspecialchars($direccion->getNumeroPuerta()); ?></p>
                                <p><strong>Comentario:</strong><?php echo htmlspecialchars($direccion->getComentario()); ?></p>
                            </label>
                        </div>
                <?php endforeach; ?>
                </div>

                <div>
                    <h4>Selecciona un método de pago</h4>
                    <div class="metodo-pago-container">
                        <div class="metodo-pago">
                            <input type="radio" id="pago-efectivo" name="metodoPago" value="efectivo" required>
                            <label for="pago-efectivo">Pago al contado en efectivo</label>
                        </div>
                        <div class="metodo-pago">
                            <input type="radio" id="pago-transferencia" name="metodoPago" value="transferencia" required>
                            <label for="pago-transferencia">Pago al contado por transferencia</label>
                        </div>
                    </div>
                </div>

                <input type="submit" class="checkout-btn" value="Comprar">
            <?php else: ?>
                <a class="checkout-btn" href="<?php echo URL_PATH."/index.php?controller=controllerHome&action=mostrarPerfilDirecciones" ?>">No tienes direcciones de envío, por favor ingresa al menos una</a>
            <?php endif; ?>
        </div>
    </form>
</main>

<?php include 'viewMensaje.php'; ?>
<?php include_once 'viewFooter.php' ?>
</body>
</html>