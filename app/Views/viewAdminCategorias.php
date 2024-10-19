
<body>
   
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