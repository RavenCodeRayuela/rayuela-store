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
    $js = URL_PATH.'/public/js/mostrar-form-script.js';
    $img = URL_PATH.'/public/img/';

    //Productos
    $agregarProducto = URL_PATH.'/index.php?controller=controllerGestion&action=agregarProducto';
    $listarProductos= URL_PATH.'/index.php?controller=controllerGestion&action=listarProductos';
    //Categorias
    $agregarCategoria = URL_PATH.'/index.php?controller=controllerGestion&action=agregarCategoria';
    $editarCategoria = URL_PATH.'/index.php?controller=controllerGestion&action=editarCategoria';
    $eliminarCategoria = URL_PATH.'/index.php?controller=controllerGestion&action=eliminarCategoria';
   
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href=<?php echo $css; ?> rel="stylesheet" type="text/css">
    <title>Gestion de productos y categorias</title>
</head>
<body>

    
   <?php include_once 'viewHeaderAdmin.php'?>

    <!-- Contenido Principal -->
    <main>
        <section class="text-admin">
            <h1>Pagina de gestión de productos y categorias</h1>

            <!-- Botones para elegir qué formulario mostrar -->
      <hr class="hr-separador">       
    <button class="button-forms" onclick="mostrarFormulario('agregar')">Agregar Producto</button>
    <a href="<?php echo $listarProductos;?>" class="btn listar">Listar Productos</a>
    <button class="button-forms" onclick="mostrarFormulario('agregarCategoria')">Agregar categorias</button>
    <button class="button-forms" onclick="mostrarFormulario('listarCategorias')">Listar categorias</button>
 
    <hr class="hr-separador">

        <!-- Formulario para Agregar Categoria -->
        <div id="agregarCategoria" class="form-container-productos">
                <h3>Agregar categoria</h3>
                
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
</body>
</html>
