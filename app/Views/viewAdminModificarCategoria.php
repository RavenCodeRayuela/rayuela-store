<?php

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['user_email']) || $_SESSION['rol']!="admin") {
        header('Location:'.URL_PATH.'/index.php?controller=controllerHome&action=mostrarLogin');
        exit();
    }
    

    $css = URL_PATH.'/public/css/styles.css';
    $modificarCategoria = URL_PATH.'/index.php?controller=controllerGestion&action=modificarCategoria';
    $img = URL_PATH.'/public/img/';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href=<?php echo $css; ?> rel="stylesheet" type="text/css">
    <title>Modificar categoría</title>
</head>
<body>

    
   <?php include_once 'viewHeaderAdmin.php'?>

    <!-- Contenido Principal -->
    <main>
        <section class="text-admin">
            <h1>Modificar categoría</h1>
    <hr class="hr-separador">

     <!-- Formulario para Modificar Categoria -->
        <div id="modificar" class="form-container-productos" style="display:block;">
            <h3>Modificar categoria</h3>
            <form action=<?php echo $modificarCategoria; ?> method="POST" enctype="multipart/form-data">
                
                <div class="form-item">
                    <label for="nombre">Nuevo nombre de la categoria:</label><br>
                    <input type="text" id="nombre_modificar" name="nombre" value="<?php echo $categoria->getNombre()?>"><br><br>
                </div>

                <div class="form-item">
                    <label for="descripcion">Nueva descripción:</label><br>
                    <textarea id="descripcion_modificar" name="descripcion" rows="4" required style="resize:none; width:100%;"><?php echo $categoria->getDescripcion()?></textarea><br><br>
                </div>

                <div class="form-item">
                    <label for="imagen">Nueva imagen de la categoria</label>
                    <input type="file" id="imagen" name="imagen" accept="image/*" required>
                </div>
                
                <div class="form-item" style="display:none;">
                    <input type="text" id="id_categoria" name="id" value="<?php echo $categoria->getId();?>">
                </div>
                <div class="form-item">
                    <input type="submit" value="Modificar categoria">
                </div>
            </form>
        </div>

    </main>
    <?php
        // Mostrar errores si existen
            if (!empty($errores)) {
                echo "<p id='mensajeEstado' style='color:red; text-align:center; font-size:1.5rem; margin-bottom: 10px;'>$errores</p>";
            }
        // Mostrar msj exito si existe
            if(!empty($mensajeExito)){
                echo "<p id='mensajeEstado' style='color:green; text-align:center; font-size:1.5rem; margin-bottom: 10px;'>$mensajeExito</p>";
            }
        
        ?>

    
    <?php include_once 'viewFooter.php'?>

</body>
</html>
