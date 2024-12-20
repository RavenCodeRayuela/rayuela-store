<?php

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['user_email']) || $_SESSION['rol']!="admin") {
        header('Location:'.URL_PATH.'/index.php?controller=controllerHome&action=mostrarLogin');
        exit();
    }
    
    $css = URL_PATH.'/public/css/styles.css';
    $modificarProducto = URL_PATH.'/index.php?controller=controllerGestion&action=modificarProducto';
    $img = URL_PATH.'/public/img/';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href=<?php echo $css; ?> rel="stylesheet" type="text/css">
    <link rel="icon" type="image/x-icon" href="<?= $img."favicon.png";?>">
    <title>Gestion de productos</title>
</head>
<body>

    
   <?php include_once 'viewHeaderAdmin.php'?>

    <!-- Contenido Principal -->
    <main class="comienzoPagina">
        <section class="text-admin">
            <h1>Modificar producto</h1>
    <hr class="hr-separador">

    <!-- Formulario para Modificar Producto -->
    <div id="modificar" class="form-container-productos" style="display:block;">
        <form action=<?php echo $modificarProducto ?> method="POST" enctype="multipart/form-data">
            
            <div class="form-item">
                <label for="nombre">Nuevo nombre del producto:</label><br>
                <input type="text" id="nombre_modificar" name="nombre" value="<?php echo $producto->getNombre();?>"><br><br>
            </div>
            
            <div class="form-item">
                <label for="descripcion">Nueva descripción:</label><br>
                <textarea id="descripcion_modificar" name="descripcion" rows="4" style="resize:none; width:100%;">
                    <?php echo $producto->getDescripcion();?>
                </textarea><br><br>
            </div>

            <div class="form-item">
                <label for="categoria">Seleccionar categoría</label>
                <select id="categoria_modificar" name="categoria" required>
                    <option value="">-- Selecciona una categoría --</option>
                    <?php foreach ($categorias as $categoria): ?>
                        <option value="<?php echo $categoria['Id_categoria']; ?>" 
                            <?php echo ($categoria['Id_categoria'] == $categoriaSeleccionada) ? 'selected' : ''; ?>>
                            <?php echo $categoria['Nombre_categoria']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="form-item">
                <label for="cantidad">Nueva cantidad:</label><br>
                <input type="number" id="cantidad_modificar" name="cantidad" min="1" value="<?php echo $producto->getCantidad();?>"><br><br>
            </div>

            <div class="form-item">
                <label for="precio_unitario">Nuevo precio unitario:</label><br>
                <input type="number" id="precio_unitario_modificar" name="precio_unitario" step="0.01" min="0" value="<?php echo $producto->getPrecio();?>"><br><br>
            </div>
            
            <div class="form-item">
                <label for="descuento">Nuevo descuento (%):</label><br>
                <input type="number" id="descuento_modificar" name="descuento" step="0.01" min="0" max="100" value="<?php echo $producto->getDescuento();?>"><br><br>
            </div>

            <?php if($modificarImagen != "false"):?>
                <div class="form-item">
                    <label for="imagen">Subir imágenes del producto</label>
                    <input type="file" id="imagen" name="imagen[]" accept="image/*" multiple required>
                </div>
            <?php endif;?>

            <div class="form-item" style="display:none;">
                 <input type="text" id="id_producto" name="id" value="<?php echo $producto->getId();?>">
            </div>
            <div class="form-item">
                <input type="submit" value="Modificar producto">
            </div>
        </form>
    </div>
</div>
</section>
    </main>
    <?php include 'viewMensaje.php'?>

    
    <?php include_once 'viewFooter.php'?>

</body>
</html>
