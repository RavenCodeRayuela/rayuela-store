<?php

//Eliminar require cuando el controlador este terminado
require_once dirname(__DIR__,2)."/config/paths.php";
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
     <!-- Encabezado con barra de navegación -->
     <header>
        <div class="logo">
            <a href="#inicio">
                <img src="<?php echo $img;?>rayuela.png" alt="Logo Rayuela">
            </a>
        </div>
        <nav>
            <ul>
                <li><a href="#inicio">Inicio</a></li>
                <li><a href="#productos">Productos</a></li>
                <li><a href="#ofertas">Ofertas</a></li>
                <li><a href="#categorias">Categorias</a></li>
                <li><a href="#nosotros">Nosotros</a></li>
                <li><a href="#contacto">Contacto</a></li>
            </ul>
        </nav>
    </header>

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
        <h3 class="titulo titulo-centrado">¿No eres usuario? <a href=<?php echo URL_PATH.'/app/Views/viewFormRegistro.php'?>> Regístrate </a></h3>       
    </main>
    <script src=<?php echo $js; ?>></script>

    <!-- Pie de página -->
    <footer>
            <div class="social-icons">
                <a href="https://facebook.com" target="_blank" aria-label="Facebook"><img src="<?php echo $img;?>facebook.png" alt="Facebook" width="5%"></a>
                <a href="https://web.whatsapp.com/" target="_blank" aria-label="Whatsapp"><img src="<?php echo $img;?>whatsapp.png" alt="Whatsapp" width="5%"></a>
                <a href="https://instagram.com" target="_blank" aria-label="Instagram"><img src="<?php echo $img;?>instagram.png" alt="Instagram" width="5%"></a>
            </div>
        
            <ul class="contact-info">
                <li>Teléfono: ...</li>
                <li>Email: ...</li>
                <li>Dirección: ...</li>
            </ul>
    </footer>
</body>
</html>