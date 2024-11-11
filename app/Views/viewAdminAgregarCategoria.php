<?php

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if($_SESSION !=[]){
        if (!isset($_SESSION['user_email']) || $_SESSION['rol']!="admin") {
            header('Location:'.URL_PATH.'/index.php?controller=controllerHome&action=mostrarLogin');
            exit();
        }
        if(isset($_SESSION['Categorias']) && isset($_SESSION['Productos'])){
            $categorias = $_SESSION['Categorias'];
            $productos = $_SESSION['Productos'];
        }
    }
    //General
    $css = URL_PATH.'/public/css/styles.css';
    $img = URL_PATH.'/public/img/';

    //Productos
    $agregarCategoria = URL_PATH.'/index.php?controller=controllerGestion&action=agregarCategoria';   
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href=<?php echo $css; ?> rel="stylesheet" type="text/css">
    <link rel="icon" type="image/x-icon" href="<?= $img."favicon.png";?>">
    <title>Agregar Categorías</title>
</head>
<body>

    
   <?php include_once 'viewHeaderAdmin.php'?>

    <!-- Contenido Principal -->
    <main class="comienzoPagina">
        <section class="text-admin">
        <h1>Agregar Categoría</h1>           
    <hr class="hr-separador">

    <!-- Formulario para Agregar Categoria -->
    <div id="agregarCategoria" class="form-container-productos">
                <form action= <?php echo $agregarCategoria;?> method="POST" enctype="multipart/form-data">
                
                <div class="form-item">
                        <label class="label-gestion" for="nombre">Nombre de la categoria</label>
                        <input type="text" id="nombre" name="nombre" required>
                </div>
                
                <div class="form-item">
                    <label for="descripcion">Descripción</label>
                    <textarea id="descripcion" name="descripcion" rows="4" required style="resize:none; width:100%;"></textarea>
                </div>
                
                <div class="form-item">
                    <label for="imagen">Subir imagen de la categoria</label>
                    <input type="file" id="imagen" name="imagen" accept="image/*" required>
                </div>
                
                <div class="form-item">
                    <input type="submit" value="Agregar categoria">
                </div>
                </form>
            </div>
        </section>
    </main>
    
    <?php include 'viewMensaje.php'?>
    
    <?php include_once 'viewFooter.php'?>

</body>
</html>