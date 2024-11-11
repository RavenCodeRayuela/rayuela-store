<?php
 if (session_status() === PHP_SESSION_NONE) {
    session_start();
    }
    
    $css = URL_PATH.'/public/css/styles.css';
    $js = URL_PATH.'/public/js/cliente-perfil-script.js';
    $img = URL_PATH.'/public/img/';
    $action = URL_PATH.'/index.php?controller=controllerCliente&action=modificarInfoPerfil';
   
    if($_SESSION !=[]){
        if (!isset($_SESSION['user_email'])) {
            header('Location:'.URL_PATH.'/index.php?controller=controllerHome&action=mostrarLogin');
            exit();
        }
        if(isset($_SESSION['nombre']) && $_SESSION['nombre']!='Nombre no asignado'){
            $nombre = $_SESSION['nombre'];
        }
    }

    $paginaActualSidebar = "datosPersonales";
    
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href=<?php echo $css; ?> rel="stylesheet" type="text/css">
    <link rel="icon" type="image/x-icon" href="<?= $img."favicon.png";?>">
    <title>Perfil de usuario</title>
</head>
<body>

    <?php include_once 'viewHeader.php'?>

    <!-- Contenido Principal -->
    <main class="container comienzoPagina">

        <!-- Barra lateral -->
        <?php include_once 'viewSidebarCliente.php'?>

        <!-- Contenido principal -->
        <div class="main-content" id="contenido">
            <h1>Datos personales</h1>
            <h2>Añade o modifica información sobre tí</h2>
                <hr>
            <div class="form-container">
                <h3>Información básica</h3>
                <form action="<?php echo $action;?>" method="POST">

                    <div class="form-group">
                        <label for="name">Nombre</label>
                        <input type="text" id="name" name="nombre" placeholder="Ingresa tu nombre" required value="<?php if($nombre== "Nombre no asignado"){
                            echo "";
                        }else{
                            echo htmlspecialchars($nombre);
                        }?>">
                    </div>

                    <div class="form-group">
                        <label for="phone">Celular(es)</label>
                        <div id="phone-container">
                            <?php
                             if (!empty($celulares)) {
                                foreach ($celulares as $celular) {
                                    echo '<input type="tel" name="celular[]" value="' . htmlspecialchars($celular['Numero_cel']) . '" placeholder="Ingresa tu número de celular">';
                                }
                            } else {
                                echo '<input type="tel" name="celular[]" placeholder="Ingresa tu número de celular">';
                            }
                            ?>
                        </div>
                        <button type="button" onclick="addPhoneField()" class="submit-btn" style="margin-top:5px;">Añadir otro número</button>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="tel" id="email" name="email" placeholder="Ingresa tu email" required value="<?= htmlspecialchars($email);?>" readonly>
                        <span class="text-info">Este campo no es modificable</span>
                    </div>

                    <div class="form-group checkbox-container">
                        <label for="newsletter">Suscribirse al Newsletter</label>
                        <input type="checkbox" id="newsletter" name="newsletter"
                            <?= $newsletter ? 'checked' : ''; ?>>
                    </div>

                    <input type="submit" value="Guardar" class="submit-btn">
                </form>
            </div>
        </div>

    </main>

    <script src="<?= $js;?>"></script>
    <?php include 'viewMensaje.php'?>
    <?php include_once 'viewFooter.php'?>

</body>
</html>