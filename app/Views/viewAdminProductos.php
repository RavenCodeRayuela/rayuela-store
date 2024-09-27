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
    $agregarProducto = URL_PATH.'/index.php?controller=controllerGestion&action=agregarProducto';
    $modificarProducto = URL_PATH.'/index.php?controller=controllerGestion&action=modificarProducto';
    $eliminarProducto = URL_PATH.'/index.php?controller=controllerGestion&action=eliminarProducto';
    $js = URL_PATH.'/public/js/productos-script.js';
    $img = URL_PATH.'/public/img/';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href=<?php echo $css; ?> rel="stylesheet" type="text/css">
    <title>Gestion de productos</title>
</head>
<body>

    
   <?php include_once 'viewHeaderAdmin.php'?>

    <!-- Contenido Principal -->
    <main>
        <section class="text-admin">
            <h1>Pagina de gestión de productos</h1>

            <!-- Botones para elegir qué formulario mostrar -->
      <hr class="hr-separador">       
    <button class="button-forms" onclick="mostrarFormulario('agregar')">Agregar Producto</button>
    <button class="button-forms" onclick="mostrarFormulario('modificar')">Modificar Producto</button>
    <button class="button-forms" onclick="mostrarFormulario('eliminar')">Eliminar Producto</button>
    <button class="button-forms" onclick="mostrarFormulario('listar')">Listar Productos</button>
 
    <hr class="hr-separador">

    <!-- Formulario para Agregar Producto -->
    <div id="agregar" class="form-container-productos">
        <h3>Agregar Producto</h3>
        
        
        <form action= <?php echo URL_PATH.'/index.php?controller=controllerGestion&action=agregarProducto';?> method="POST" enctype="multipart/form-data">
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
                <label for="imagen">Subir imagen del producto</label>
                <input type="file" id="imagen" name="imagen" accept="image/*" required>
            </div>
            <div class="form-item">
                <input type="submit" value="Agregar producto">
            </div>
        </form>
    </div>

    <!-- Formulario para Modificar Producto -->
    <div id="modificar" class="form-container-productos">
        
        <h3>Modificar Producto</h3>
        
        <form action=<?php echo $modificarProducto ?> method="POST" enctype="multipart/form-data">
            <div class="form-item">
                <select id="producto_modificar" name="productoModificar" required>
                    <option value="">-- Selecciona un producto --</option>
                        <?php foreach ($productos as $producto): ?>
                            <option value="<?php echo $producto['Id_producto']; ?>"><?php echo $producto['Nombre']; ?></option>
                        <?php endforeach; ?>
                </select>
            </div>
            <div class="form-item">
                <label for="nombre">Nuevo nombre del producto:</label><br>
                <input type="text" id="nombre_modificar" name="nombre"><br><br>
            </div>
            
            <div class="form-item">
                <label for="descripcion">Nueva descripción:</label><br>
                <textarea id="descripcion_modificar" name="descripcion" rows="4" style="resize:none; width:100%;"></textarea><br><br>
            </div>

            <div class="form-item">
                <label for="categoria">Seleccionar categoría</label>
                <select id="categoria_modificar" name="categoria" required>
                    <option value="">-- Selecciona una categoría --</option>
                        <?php foreach ($categorias as $categoria): ?>
                            <option value="<?php echo $categoria['Id_categoria']; ?>"><?php echo $categoria['Nombre_categoria']; ?></option>
                        <?php endforeach; ?>
                </select>
            </div>
            
            <div class="form-item">
                <label for="cantidad">Nueva cantidad:</label><br>
                <input type="number" id="cantidad_modificar" name="cantidad" min="1"><br><br>
            </div>

            <div class="form-item">
                <label for="precio_unitario">Nuevo precio unitario:</label><br>
                <input type="number" id="precio_unitario_modificar" name="precio_unitario" step="0.01" min="0"><br><br>
            </div>
            
            <div class="form-item">
                <label for="descuento">Nuevo descuento (%):</label><br>
                <input type="number" id="descuento_modificar" name="descuento" step="0.01" min="0" max="100"><br><br>
            </div>

            <div class="form-item">
                <label for="imagen">Subir imagen del producto</label>
                <input type="file" id="imagen_modificar" name="imagen" accept="image/*" required>
            </div>

            <div class="form-item">
                <input type="submit" value="Modificar producto">
            </div>
        </form>
    </div>

    <!-- Formulario para Eliminar Producto -->
    
    <div id="eliminar" class="form-container-productos">
    
        <h3>Eliminar Producto</h3>
        
        <form action=<?php echo $eliminarProducto ?> method="POST">
            
            <div class="form-item">
                <select id="productoEliminar" name="productoEliminar" required>
                    <option value="">-- Selecciona un producto --</option>
                        <?php foreach ($productos as $producto): ?>
                            <option value="<?php echo $producto['Id_producto']; ?>"><?php echo $producto['Nombre']; ?></option>
                        <?php endforeach; ?>
                </select>
            </div>

            <div class="form-item">
                <input type="submit" value="Eliminar producto">
            </div>
        </form>
    </div>

        <!-- Listar Productos -->
    <div id="listar" class="form-container-productos">
        <h3>Lista de Productos</h3>
        
        <div  id="tablaProductos">
            <?php
                if ($productos) {
                        echo "<table class='tabla-listar'>";
                        echo "<tr><th>ID</th><th>Nombre</th><th>Descripción</th><th>Cantidad</th><th>Precio</th><th>Descuento</th><th>Imagen</th><th>Categoría</th></tr>";
                        foreach ($productos as $producto) {
                            echo "<tr>";
                            echo "<td>" . $producto['Id_producto']. "</td>";
                            echo "<td>" . $producto['Nombre'] . "</td>";
                            echo "<td>" . $producto['Descripcion_producto'] . "</td>";
                            echo "<td>" . $producto['Cantidad'] . "</td>";
                            echo "<td>" . $producto['Precio_actual'] . "</td>";
                            echo "<td>" . $producto['Descuento'] . "%</td>";
                            echo "<td><img src='" . URL_PATH.$producto['Ruta_imagen_producto'] . "'alt'='Imagen de producto' width='100'></td>";
                            echo "<td>" . $producto['categoria'] . "</td>";
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
    <script src=<?php echo $js; ?>></script>
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
