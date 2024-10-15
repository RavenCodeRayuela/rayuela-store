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
    //Quitar require cuando se maneje todo desde el controlador.
    require_once dirname(__DIR__,2)."/config/paths.php";
    $css = URL_PATH.'/public/css/styles.css';
    $agregarCategoria = URL_PATH.'/index.php?controller=controllerGestion&action=agregarCategoria';
    $modificarCategoria = URL_PATH.'/index.php?controller=controllerGestion&action=modificarCategoria';
    $eliminarCategoria = URL_PATH.'/index.php?controller=controllerGestion&action=eliminarCategoria';
    $js = URL_PATH.'/public/js/mostrar-form-script.js';
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

            <!-- Botones para elegir que formulario mostrar -->
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
        <form action=<?php echo $modificarCategoria; ?> method="POST" enctype="multipart/form-data">
            
        <div class="form-item">
                <label for="categoria">Seleccionar categoría</label>
                <select id="categoria" name="categoria" required>
                    <option value="">-- Selecciona una categoría --</option>
                        <?php foreach ($categorias as $categoria): ?>
                            <option value="<?php echo $categoria['Id_categoria']; ?>"><?php echo $categoria['Nombre_categoria']; ?></option>
                        <?php endforeach; ?>
                </select>
            </div>
            
            <div class="form-item">
                <label for="nombre">Nuevo nombre de la categoria:</label><br>
                <input type="text" id="nombre_modificar" name="nombre"><br><br>
            </div>

            <div class="form-item">
                <label for="descripcion">Nueva descripción:</label><br>
                <textarea id="descripcion_modificar" name="descripcion" rows="4" required style="resize:none; width:100%;"></textarea><br><br>
            </div>

             <div class="form-item">
                <label for="imagen">Nueva imagen de la categoria</label>
                <input type="file" id="imagen" name="imagen" accept="image/*" required>
            </div>
            
            <div class="form-item">
                <input type="submit" value="Modificar categoria">
            </div>
        </form>
    </div>

    <!-- Formulario para Eliminar categoria -->
    <div id="eliminar" class="form-container-productos">
        <h3>Eliminar categoria</h3>
        
        <form action=<?php echo $eliminarCategoria; ?> method="POST">
        
            <div class="form-item">
                <label for="categoria">Eliminar categoría</label>
                <select id="categoria" name="categoriaEliminar" required>
                    <option value="">-- Selecciona una categoría --</option>
                        <?php foreach ($categorias as $categoria): ?>
                            <option value="<?php echo $categoria['Id_categoria']; ?>"><?php echo $categoria['Nombre_categoria']; ?></option>
                        <?php endforeach; ?>
                </select>
            </div>
       
            <div class="form-item">
                <input type="submit" value="Eliminar categoria">
            </div>
        </form>
    </div>

        <!-- Listar Productos -->
    <div id="listar" class="form-container-productos">
        <h3>Lista de categorias</h3>

        <div  id="tablaProductos">
            <?php
                if ($categorias) {
                        echo "<table class='tabla-listar'>";
                        echo "<tr><th>ID</th><th>Nombre</th><th>Descripción</th><th>Imagen</th></tr>";
                        foreach ($categorias as $categoria) {
                            echo "<tr>";
                            echo "<td>" . $categoria['Id_categoria']. "</td>";
                            echo "<td>" . $categoria['Nombre_categoria'] . "</td>";
                            echo "<td>" . $categoria['Descripcion_categoria'] . "</td>";
                            echo "<td><img src='" . URL_PATH.$categoria['Ruta_imagen_categoria'] . "'alt'='Imagen de producto' width='100'></td>";
                            echo "</tr>";
                        }
                        echo "</table>";
                    } else {
                        echo "No hay productos disponibles.";
                    }
            ?>
        </div>
    </div>
        </section>
    </main>

    <?php
        // Mostrar errores si existen
            if (!empty($errores)) {
                echo "<p style='color:red; text-align:center; font-size:1.5rem; margin-bottom: 10px;'>$errores</p>";
            }

            // Mostrar msj exito si existe
            if(!empty($mensajeExito)){
                echo "<p id='mensajeEstado' style='color:green; text-align:center; font-size:1.5rem; margin-bottom: 10px;'>$mensajeExito</p>";
            }
        ?>

    <script src=<?php echo $js; ?>></script>
    <?php include_once 'viewFooter.php'?>

</body>
</html>