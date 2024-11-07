<?php
$css = URL_PATH.'/public/css/styles.css';
$img = URL_PATH.'/public/img/';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href=<?php echo $css; ?> rel="stylesheet" type="text/css">
    <title>Contacto Rayuela</title>
</head>
<body>

    <!-- Encabezado -->
    <?php include_once 'viewHeader.php'?>
    <section class="nosotros">
        <h1>Contacto</h1>
        <p>¿Tienes alguna pregunta o deseas más información? Escríbenos y te responderemos a la brevedad.</p>
    </section>

    <!-- Formulario de contacto -->
     <section class="main-content">
    <div class="form-container">
        <form action="#" method="POST">

            <div class="form-group">
                <label for="name">Nombre</label>
                <input type="text" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="email">Correo Electrónico</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="message">Mensaje</label>
                <textarea id="message" name="message" rows="5" required></textarea>
            </div>
            <input type="submit" value="Enviar Mensaje" class="submit-btn">
        </form>
    </div>
    </section>
    <!-- Footer -->
    <?php include_once 'viewFooter.php'?>
</body>
</html>