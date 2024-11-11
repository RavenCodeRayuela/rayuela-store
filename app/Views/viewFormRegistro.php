<?php
    $css = URL_PATH.'/public/css/styles.css';
    $action = URL_PATH.'/index.php?controller=controllerUsuario&action=registrarUsuario';
    $js = URL_PATH.'/public/js/registro-script.js';
    $img = URL_PATH.'/public/img/';
    
?>
<!DOCTYPE html>
<html lang="es">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href=<?php echo $css;?> rel="stylesheet" type="text/css">
    <link rel="icon" type="image/x-icon" href="<?= $img."favicon.png";?>">
    <title>Registro</title>
</head>
<body>
    
    <?php include_once 'viewHeader.php';?>
    
    <!-- Contenido Principal -->
    <main class="comienzoPagina">
        <h1 class="titulo titulo-centrado">Registro Rayuela Store</h1>

        <hr>
        <div class="main-content">
        <div class="form-container">
        <form id="form-registro" method="POST" action=<?php echo htmlspecialchars($action);?>>
                <div class="form-group">
                    <label for="email">Correo </label>
                    <input type="email" id="email" name="email" autocomplete="email" required/>
                </div>
                <p class="aviso-off" id="avisoEmail"> *El campo correo es necesario, debe ser un formato de correo valido. <br> Ej: juan@gmail.com</p>
                <div class="form-group">
                    <label for="password">Contraseña </label>
                    <input type="password" id="password" name="password" autocomplete="new-password" required/>
                </div>
                <p class="aviso-off" id="avisoPassword"> *El campo contraseña es necesario, debe contener entre 8 y 20 digitos, <br>mayusculas, minusculas y al menos un número, sin caracteres especiales.</p>
                <div class="form-group">
                    <label for="passwordCh">Confirmación de contraseña </label>
                    <input type="password" id="passwordCh" name="passwordCh" autocomplete="new-password" required/>
                </div>
                <p class="aviso-off" id="avisoConfirmacion"> *El campo confirmacion es necesario y debe coincidir con el campo contraseña</p>
                <div class="form-group checkbox-container">
                    <label for="suscripcion">Suscripcion a Newsletter </label>
                    <input type="checkbox" id="suscripcion" name="suscripcion"/>
                </div>  
                <input type="submit" value="Registrarse" class="submit-btn"/>
        </form>
        </div>
        </div>
        <?php include 'viewMensaje.php';?>
        <hr>
        <h3 class="titulo titulo-centrado">¿Ya eres usuario? <a href=<?php echo URL_PATH.'/index.php?controller=controllerHome&action=mostrarLogin'?>> Acceder </a></h3>
    </main>
    <script src=<?php echo $js;?>></script>
    
    <?php include_once 'viewFooter.php';?>


</body>
</html>