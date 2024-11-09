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

    $paginaActualSidebar = "direccionesDeEnvio";
    $action = URL_PATH.'/index.php?controller=controllerCliente&action=modificarDireccion';
    
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href=<?php echo $css; ?> rel="stylesheet" type="text/css">
    <title>Rayuela Store</title>
</head>
<body>

    <?php include_once 'viewHeader.php'?>

    <!-- Contenido Principal -->
    <main class="container comienzoPagina">

        <!-- Barra lateral -->
        <?php include_once 'viewSidebarCliente.php'?>

            <!-- Formulario de contacto -->
            <section class="main-content">
            <div class="form-container">
                <form action="<?php echo $action;?>" method="POST">


                    <div class="form-group">
                        <label for="ciudad">Ciudad</label>
                        <input type="text" id="ciudad" name="ciudad" required value="<?php echo $direccion->getCiudad();?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="calle">Calle</label>
                        <input type="text" id="calle" name="calle" required value="<?php echo $direccion->getCalle();?>">
                    </div>

                    <div class="form-group">
                        <label for="nroCasa">Número de casa</label>
                        <input type="text" id="nroCasa" name="nroCasa" required value="<?php echo $direccion->getNumeroPuerta();?>">
                        <span class="text-info">Solo números, si tu direccion no tiene número de casa pon 0 y detallanos como ubicarte en la sección de comentarios</span>
                    </div>
                   
                    <div class="form-group">
                        <label for="comentario">Comentario</label>
                        <textarea id="comentario" name="comentario" rows="5" required><?php echo $direccion->getComentario();?></textarea>
                        <span class="text-info">Cualquier información que nos pueda ayudar en la entrega, el comentario debe tener un máximo de 280 caracteres que equivalen a aprox. 55 palabras o un tweet :D</span>
                    </div>
                    <div class="form-group" style="display:none">
                        <input type="text" id="id" name="id"  value="<?php echo $direccion->getIdDireccion();?>">
                    </div>
                    <input type="submit" value="Modificar dirección" class="submit-btn">
                </form>
            </div>
            </section>
    </main>

    <?php include 'viewMensaje.php'?>
    <?php include_once 'viewFooter.php'?>

</body>
</html>