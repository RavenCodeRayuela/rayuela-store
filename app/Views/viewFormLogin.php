<?php
//Eliminar require cuando el controlador este terminado
require_once dirname(__DIR__,2)."/config/paths.php";
//RUTAS
$css = URL_PATH.'/public/css/styles.css';
$action = URL_PATH.'\index.php?controller=controllerUsuario&action=loginUsuario';
$js = URL_PATH.'/public/js/login-script.js';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href=<?php echo $css; ?> rel="stylesheet" type="text/css">
    <title>Login Rayuela</title>
</head>
<body>
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
        
        <hr>
        <h3 class="titulo titulo-centrado">¿No eres usuario? <a href="#"> Regístrate </a></h3>       
    </main>
    <script src=<?php echo $js; ?>></script>
</body>
</html>