<?php
    session_start();
    if($_SESSION !=[]){
        if (!isset($_SESSION['user_email']) || $_SESSION['rol']!="admin") {
            header('Location:'.URL_PATH.'/index.php?controller=controllerHome&action=mostrarLogin');
            exit();
        }
    }
    //Quitar require cuando se maneje todo desde el controlador.
    require_once dirname(__DIR__,2)."/config/paths.php";
    $css = URL_PATH.'/public/css/styles.css';
    $img = URL_PATH.'/public/img/';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href=<?php echo $css; ?> rel="stylesheet" type="text/css">
    <title>Backoffice</title>
</head>
<body>

   <?php include_once 'viewHeaderAdmin.php';?>

    <!-- Contenido Principal -->
    <main>
        <section class="text-admin">
            <h1>Pagina de gestión de negocio</h1>
            <p>Simplemente seleccione, del menu en la esquina superior derecha, la opción que desea y el sistema desplegara las funciones necesarias para ayudarle.</p>
        </section>
    </main>

    <?php include_once 'viewFooter.php';?>

</body>
</html>
