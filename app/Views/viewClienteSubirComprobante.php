<?php
    $css = URL_PATH.'/public/css/styles.css';
    $js = URL_PATH.'/public/js/admin-script.js';
    $img = URL_PATH.'/public/img/';

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
        }
        
    if($_SESSION !=[]){
        if (!isset($_SESSION['user_email'])) {
            header('Location:'.URL_PATH.'/index.php?controller=controllerHome&action=mostrarLogin');
            exit();
        }
        if(isset($_SESSION['nombre']) && $_SESSION['nombre']!='Nombre no asignado'){
            $nombre = $_SESSION['nombre'];
        }
    }

    $paginaActualSidebar = "historialDeCompras";
    $action = URL_PATH."/index.php?controller=controllerCompra&action=procesarFormComprobantePago";
    
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href=<?php echo $css; ?> rel="stylesheet" type="text/css">
    <link rel="icon" type="image/x-icon" href="<?= $img."favicon.png";?>">
    <title>Subir comprobante de pago</title>
</head>
<body>

    <?php include_once 'viewHeader.php'?>

    <!-- Contenido Principal -->
    <main class="container comienzoPagina">

        <!-- Barra lateral -->
        <?php include_once 'viewSidebarCliente.php'?>
        
        <!-- Contenido principal -->
        <div class="main-content" id="contenido">
            <h1>Subir comprobante de pago</h1>
            
            <form action="<?php echo $action;?>" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="imagen">Selecciona una imagen (JPG, PNG, WEBP, GIF):</label>
                    <input type="file" id="imagen" name="imagen" accept="image/*" required>
                </div>
                
                
                <input type="hidden" name="idCompra" value="<?php echo $idCompra; ?>">
                <input type="hidden" name="pagina" value="<?php echo $pagina; ?>">

                <input type="submit" value="Subir Comprobante" class="submit-btn">
            </form>
        </div>

    </main>

    <?php include 'viewMensaje.php'?>
    <?php include_once 'viewFooter.php'?>

</body>
</html>