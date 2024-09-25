<?php

session_start();
if($_SESSION !=[]){
if (isset($_SESSION['user_email']) && $_SESSION['rol']!="admin") {
    header('Location:'.URL_PATH.'/index.php?controller=controllerHome&action=mostrarHome');
    exit();
}elseif (($_SESSION['user_email']) && $_SESSION['rol']=="admin") {
    header('Location:'.URL_PATH.'/index.php?controller=controllerHome&action=mostrarBackoffice');
    exit();
}
}
//RUTAS
$css = URL_PATH.'/public/css/styles.css';
$action = URL_PATH.'/index.php?controller=controllerUsuario&action=loginUsuario';
$js = URL_PATH.'/public/js/login-script.js';
$img = URL_PATH.'/public/img/';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href=<?php echo $css; ?> rel="stylesheet" type="text/css">
    <title>Login</title>
</head>
<body>
     
    <?php include_once 'viewHeader.php';?>
    <!-- Contenido Principal -->
    <main>
        <h1 class="titulo titulo-centrado">Acceso a Rayuela Store</h1>
        <hr>

        <form class="form" id="form-login" method="POST" action=<?php echo $action;?>>
    
                <label class="item-form" for="correo">Correo </label>
                <input class="item-form" type="email" id="correo" name="email" autocomplete="username" required/>
                    <p class="aviso-off" id="avisoEmail"> *El campo correo es necesario, debe ser un formato de correo valido. <br> Ej: juan@gmail.com</p>

                <label class="item-form" for="password">Contraseña </label>
                <input class="item-form" type="password" id="password" name="password" autocomplete="current-password" required/>
                    <p class="aviso-off" id="avisoPassword"> *El campo contraseña es necesario, debe contener al menos 8 digitos, <br>mayusculas, minusculas y al menos un número, sin caracteres especiales.</p>
                
                <input class="item-form" type="submit" value="Acceder"/>
        </form>
        <?php
        // Mostrar errores si existen
            if (!empty($errores)) {
                echo "<p style='color:red;'>$errores</p>";
            }
        ?>
        <hr>
        <h3 class="titulo titulo-centrado">¿No eres usuario? <a href=<?php echo URL_PATH.'/index.php?controller=controllerHome&action=mostrarRegistro'?>> Regístrate </a></h3>       
    </main>
    <script src=<?php echo $js; ?>></script>

    <?php include_once 'viewFooter.php';?>
</body>
</html>