<?php
require_once 'validaciones.php';
function agregarProducto(){
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        require_once ROOT_PATH.'/app/Models/modelGestion.php';
        /**
         * Cambiar este codigo
         */
        // Validar el campo 'nombre'
    $nombre = trim($_POST["nombre"]);
    if (empty($nombre)) {
        die("El campo 'Nombre' es obligatorio.");
    }

    // Validar el campo 'descripcion'
    $descripcion = trim($_POST["descripcion"]);
    if (empty($descripcion)) {
        die("El campo 'Descripción' es obligatorio.");
    }

    // Validar el campo 'cantidad'
    $cantidad = filter_var($_POST["cantidad"], FILTER_VALIDATE_INT);
    if ($cantidad === false || $cantidad < 1) {
        die("El campo 'Cantidad' debe ser un número entero mayor que 0.");
    }

    // Validar el campo 'precio_unitario'
    $precio_unitario = filter_var($_POST["precio_unitario"], FILTER_VALIDATE_FLOAT);
    if ($precio_unitario === false || $precio_unitario < 0) {
        die("El campo 'Precio unitario' debe ser un número positivo.");
    }

    // Validar el campo 'descuento' (opcional, puede estar vacío)
    $descuento = filter_var($_POST["descuento"], FILTER_VALIDATE_FLOAT);
    if ($descuento !== false && ($descuento < 0 || $descuento > 100)) {
        die("El campo 'Descuento' debe estar entre 0 y 100.");
    }

    // Validar el archivo de imagen
    if (!isset($_FILES['imagen']) || $_FILES['imagen']['error'] !== UPLOAD_ERR_OK) {
        die("Error al subir la imagen.");
    }

    // Validar el tipo de archivo (solo imágenes)
    $permitidos = array("image/jpg", "image/jpeg", "image/png", "image/gif");
    if (!in_array($_FILES['imagen']['type'], $permitidos)) {
        die("Solo se permiten archivos de imagen (jpg, jpeg, png, gif).");
    }

    // Mover el archivo a la carpeta deseada
    $ruta_destino = ROOT_PATH."/storage/uploads/" . basename($_FILES['imagen']['name']);
    if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta_destino)) {
        die("Error al mover la imagen al servidor.");
    }

    $producto= new Producto();
    $producto->addProducto($nombre,$descripcion,$precio_unitario,$descuento,"Gorro",$cantidad,$ruta_destino);
    }
}
?>