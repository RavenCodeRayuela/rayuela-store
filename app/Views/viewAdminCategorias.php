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
    $agregarCategoria = URL_PATH.'/index.php?controller=controllerGestion&action=agregarCategoria';
    $modificarCategoria = URL_PATH.'/index.php?controller=controllerGestion&action=modificarCategoria';
    $eliminarCategoria = URL_PATH.'/index.php?controller=controllerGestion&action=eliminarCategoria';
    $js = URL_PATH.'/public/js/categorias-script.js';
    $img = URL_PATH.'/public/img/';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href=<?php echo $css; ?> rel="stylesheet" type="text/css">
    <title>Gestion de categorias</title>
</head>
<body>

    
   <?php include_once 'viewHeaderAdmin.php'?>

    <!-- Contenido Principal -->
    <main>
        <section class="text-admin">
            <h1>Pagina de gestión de categorias</h1>

            <!-- Botones para elegir qué formulario mostrar -->
      <hr class="hr-separador">       
    <button class="button-forms" onclick="mostrarFormulario('agregar')">Agregar categorias</button>
    <button class="button-forms" onclick="mostrarFormulario('modificar')">Modificar categorias</button>
    <button class="button-forms" onclick="mostrarFormulario('eliminar')">Eliminar categorias</button>
    <button class="button-forms" onclick="mostrarFormulario('listar')">Listar categorias</button>
 
    <hr class="hr-separador">

    <!-- Formulario para Agregar Categoria -->
    <div id="agregar" class="form-container-productos">
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

    <!-- Formulario para Modificar Categoria -->
    <div id="modificar" class="form-container-productos">
        <h3>Modificar categoria</h3>
        <form action=<?php echo $modificarCategoria; ?> method="POST">
            <label for="id_categoria">ID de la categoria a modificar:</label><br>
            <input type="text" id="id_categoria" name="id_categoria" required><br><br>

            <label for="nombre">Nuevo nombre de la categoria:</label><br>
            <input type="text" id="nombre_modificar" name="nombre"><br><br>

            <label for="descripcion">Nueva descripción:</label><br>
            <textarea id="descripcion_modificar" name="descripcion" rows="4"></textarea><br><br>

            <input type="submit" value="Modificar categoria">
        </form>
    </div>

    <!-- Formulario para Eliminar categoria -->
    <div id="eliminar" class="form-container-productos">
        <h3>Eliminar categoria</h3>
        <form action=<?php echo $eliminarCategoria; ?> method="POST">
            <label for="id_categoria_eliminar">ID de la categoria a eliminar:</label><br>
            <input type="text" id="id_categoria_eliminar" name="id_categoria_eliminar" required><br><br>

            <input type="submit" value="Eliminar categoria">
        </form>
    </div>

        <!-- Listar Productos -->
    <div id="listar" class="form-container-productos">
        <h3>Lista de Productos</h3>
        <div id="tablaProductos"></div>
    </div>
        </section>
    </main>

    <?php
        // Mostrar errores si existen
            if (!empty($errores)) {
                echo "<p style='color:red; text-align:center; font-size:1.5rem; margin-bottom: 10px;'>$errores</p>";
            }
        ?>

    <script src=<?php echo $js; ?>></script>
    <?php include_once 'viewFooter.php'?>

</body>
</html>