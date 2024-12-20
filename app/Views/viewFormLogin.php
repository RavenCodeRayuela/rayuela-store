<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if($_SESSION !=[]){
if (isset($_SESSION['user_email']) && $_SESSION['rol']!="admin") {
    header('Location:'.URL_PATH.'/index.php?controller=controllerHome&action=mostrarPerfil');
    exit();
}elseif (isset($_SESSION['user_email']) && $_SESSION['rol']=="admin") {
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
    <link rel="icon" type="image/x-icon" href="<?= $img."favicon.png";?>">
    <title>Login</title>
</head>
<body>
     
    <?php include_once 'viewHeader.php';?>
    <!-- Contenido Principal -->
    <main class="comienzoPagina">
        <h1 class="titulo titulo-centrado">Acceso a Rayuela Store</h1>
        <hr>
        <?php include 'viewMensaje.php';?>
        <div class="main-content">
        <div class="form-container">
            <form id="form-login" method="POST" action=<?php echo $action;?>>

                <div class="form-group">
                    <label  for="correo">Correo </label>
                    <input  type="email" id="correo" name="email" autocomplete="username" required/>
                </div>
                <p class="aviso-off" id="avisoEmail"> *El campo correo es necesario, debe ser un formato de correo valido. <br> Ej: juan@gmail.com</p>
                
                <div class="form-group">
                    <label for="password">Contraseña </label>
                    <input type="password" id="password" name="password" autocomplete="current-password" required/>
                </div>
                <p class="aviso-off" id="avisoPassword"> *El campo contraseña es necesario, debe contener al menos 8 digitos, <br>mayusculas, minusculas y al menos un número, sin caracteres especiales.</p>
                    
                    <input type="submit" value="Acceder" class="submit-btn"/>
            </form>
        </div>
        </div>
        <hr>
        <h3 class="titulo titulo-centrado">¿No eres usuario? <a href=<?php echo URL_PATH.'/index.php?controller=controllerHome&action=mostrarRegistro'?>> Regístrate </a></h3>       
    </main>
    <script src=<?php echo $js; ?>></script>

    <?php include_once 'viewFooter.php';?>
</body>
</html>