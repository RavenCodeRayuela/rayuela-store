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

    $paginaActual = "direccionesDeEnvio";
    $agregarDireccion = URL_PATH.'/index.php?controller=controllerHome&action=mostrarAgregarDireccion';
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

        <div class="main-content" id="contenido">
            <h1>Direcciones de envio</h1>
            <hr>

        <div id="listar" class="container-listar">
            <div class="direccion-header">
                <h2>Direcciones</h2>
                <?php if(count($direcciones)<3):?>
                    <a href="<?php echo $agregarDireccion;?>" class="submit-btn" style="width: 30%">Agregar Direccion</a>
                <?php else:?>
                    <p>Solo puedes almacenar 3 direcciones.</p>
                <?php endif;?>
            </div>
           <?php if(!empty($direcciones)):?>
            <div class="direccion-lista">
                    <?php foreach ($direcciones as $direccion):?>
                        <div class="direccion-card">
                            <h3><?php echo htmlspecialchars($direccion->getCiudad());?></h3>
                            <p><strong>Calle: </strong><?php echo htmlspecialchars($direccion->getCalle());?></p>
                            <p><strong>Nro casa:</strong><?php echo htmlspecialchars($direccion->getNumeroPuerta()); ?></p>
                            <p><strong>Comentario:</strong><?php echo htmlspecialchars($direccion->getComentario()); ?></p>
                            <a class='btn modificar'>Modificar</a>
                            <a class='btn eliminar' >Eliminar</a>
                        </div>
                    <?php endforeach;?>
                </div>
            <?php else:?>
                <div>
                    <p>No hay direcciones, por favor agrega una.</p>
                </div>
            <?php endif;?>
        </div>
    </div>

    </main>

    <?php include 'viewMensaje.php'?>
    <?php include_once 'viewFooter.php'?>

</body>
</html>