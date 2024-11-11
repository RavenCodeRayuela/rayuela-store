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
    $agregarProducto = URL_PATH.'/index.php?controller=controllerGestion&action=agregarProducto';   
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href=<?php echo $css; ?> rel="stylesheet" type="text/css">
    <link rel="icon" type="image/x-icon" href="<?= $img."favicon.png";?>">
    <title>Agregar producto</title>
</head>
<body>

    
   <?php include_once 'viewHeaderAdmin.php'?>

    <!-- Contenido Principal -->
    <main class="comienzoPagina">
        <section class="text-admin">
        <h1>Agregar Producto</h1>           
    <hr class="hr-separador">

    <!-- Formulario para Agregar Producto -->
    <div id="agregar" class="form-container-productos">

        
        
        <form action= <?php echo $agregarProducto;?> method="POST" enctype="multipart/form-data">
            <div class="form-item">
                <label class="label-gestion" for="nombre">Nombre del producto</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>
            <div class="form-item">
                <label for="descripcion">Descripción</label>
                <textarea id="descripcion" name="descripcion" rows="4" required style="resize:none; width:100%;"></textarea>
            </div>
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
                <label for="cantidad">Cantidad</label>
                <input type="number" id="cantidad" name="cantidad" min="1" required>
            </div>
            <div class="form-item">
                <label for="precio_unitario">Precio unitario</label>
                <input type="number" id="precio_unitario" name="precio_unitario" step="0.01" min="0" required>
            </div>
            <div class="form-item">
                <label for="descuento">Descuento (%)</label>
                <input type="number" id="descuento" name="descuento" step="0.01" min="0" max="100">
            </div>
            <div class="form-item">
                 <label for="imagen">Subir imágenes del producto</label>
                 <input type="file" id="imagen" name="imagen[]" accept="image/*" multiple required>
            </div>
            <div class="form-item">
                <input type="submit" value="Agregar producto">
            </div>
        </form>
    </div>
        </section>
    </main>
    <?php include 'viewMensaje.php'?>
    <?php include_once 'viewFooter.php'?>

</body>
</html>
