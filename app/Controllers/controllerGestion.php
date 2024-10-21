<?php
require_once 'validaciones.php';
function agregarProducto(){
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    
        require_once ROOT_PATH.'/app/Models/modelGestion.php';
        require_once ROOT_PATH.'/app/Models/modelAdministrador.php';

        //Asignaciones
            $nombre = $_POST["nombre"];
            $descripcion = $_POST["descripcion"];
            $cantidad = $_POST["cantidad"];
            $precioUnitario = $_POST["precio_unitario"];
            $descuento =$_POST["descuento"];
            $imagenes = $_FILES['imagen'];
            $categoriaId = $_POST["categoria"];
            
        //Procesos    
            $nombre = sanearTexto($nombre);
            $descripcion = sanearTexto($descripcion);
            $cantidad = validarInt($cantidad);
            $precioUnitario = validarFloatPositivo($precioUnitario);
            $descuento = validarFloatPorcentaje($descuento);
            $imagenes = validarImagenes($imagenes);
            $imagenes = moverImagenes($imagenes);
            $categoriaId = validarInt($categoriaId);
            
        //Modificar BD
        if($nombre != false && $descripcion != false && $precioUnitario != false && is_float($descuento) && $imagenes != false && $categoriaId != false){
                       
                if (isset($_SESSION['usuario'])) {
                    
                    $admin = unserialize($_SESSION['usuario']);
                    $admin ->agregarProducto($nombre,$descripcion,$precioUnitario,$descuento,$categoriaId,$cantidad,$imagenes);
                    
                    $mensajeExito="El producto ha sido ingresado.";
                    
                    $producto= new Producto();

                    $_SESSION['Productos'] = $producto -> getProductos();
                    
                    header("Location: index.php?controller=controllerGestion&action=listarProductos");
                    exit();
                }else{
                    echo "Error al obtener el usuario";
                }
            }else{
                $errores= "Todo el formulario debe ser completado";
                require_once ROOT_PATH.'/app/Views/viewAdminAgregarProducto.php'; 
            }
         }
}

function editarProducto($id){
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    require_once ROOT_PATH.'/app/Models/modelGestion.php';
    require_once ROOT_PATH.'/app/Models/modelAdministrador.php';
    $producto= new Producto($id);
    $categoria= new Categoria();
    $categorias= $categoria -> getCategorias();

    require_once ROOT_PATH."/app/Views/viewAdminModificarProducto.php";
    
    
}
function modificarProducto(){
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    
        require_once ROOT_PATH.'/app/Models/modelGestion.php';
        require_once ROOT_PATH.'/app/Models/modelAdministrador.php';

        //Asignaciones
            $nombre = $_POST["nombre"];
            $descripcion = $_POST["descripcion"];
            $cantidad = $_POST["cantidad"];
            $precioUnitario = $_POST["precio_unitario"];
            $descuento =$_POST["descuento"];
            $imagenes = $_FILES['imagen'];
            $categoriaId = $_POST["categoria"];
            $id = $_POST['id'];
            
        //Procesos    
            $nombre = sanearTexto($nombre);
            $descripcion = sanearTexto($descripcion);
            $cantidad = validarInt($cantidad);
            $precioUnitario = validarFloatPositivo($precioUnitario);
            $descuento = validarFloatPorcentaje($descuento);
            $imagenes = validarImagenes($imagenes);
            $imagenes = moverImagenes($imagenes);
            $categoriaId = validarInt($categoriaId);
            $id = validarInt($id);
            
        //Modificar BD
        if($nombre != false && $descripcion != false && $precioUnitario != false && is_float($descuento) && $imagenes != false && $categoriaId != false && $id != false && $cantidad != false){
                       
                if (isset($_SESSION['Productos'])) {

                    $producto= new Producto();
                    
                    $producto ->updateProducto($id ,$nombre,$descripcion,$precioUnitario,$descuento,$categoriaId,$cantidad,$imagenes);
                    
                    $mensajeExito="El producto ha sido modificado.";
                    
                    

                    $_SESSION['Productos'] = $producto -> getProductos();
                    
                    header("Location: index.php?controller=controllerGestion&action=listarProductos");
                    exit();
                }else{
                    echo "Error al obtener el producto";
                }
            }else{
                $errores= "Todo el formulario debe ser completado";
                require_once ROOT_PATH.'/app/Views/viewAdminProductos.php'; 
            }
         }
}

function eliminarProducto($id){

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        require_once ROOT_PATH.'/app/Models/modelGestion.php';

        $id = validarInt($id);

        if($id != false){
            
                $producto= new Producto();

                $imagenes= $producto->selectImagenes($id);

                eliminarImagenes($imagenes);
                
                $producto ->removeProducto($id);
                
                $mensajeExito="El producto ha sido eliminado.";
                
                $productos = $producto-> getProductosPaginados(1);
                $_SESSION['Productos'] = $producto -> getProductos();
                require_once ROOT_PATH.'/app/Views/viewAdminListarProductos.php';
             
            }else{
            echo "Error al obtener el producto";
            require_once ROOT_PATH.'/app/Views/viewAdminListarProductos.php'; 
        }
}

function listarProductos($paginaActual){
    require_once ROOT_PATH.'/app/Models/modelGestion.php';

    $productosPorPagina = 10;
    
    $producto = new Producto();
    
    $totalProductos= $producto->contarTotalProductos();
    $totalPaginas = ceil($totalProductos / $productosPorPagina);

    $productos = $producto->getProductosPaginados($paginaActual, $productosPorPagina);

    require_once ROOT_PATH.'/app/Views/viewAdminListarProductos.php';
}


function agregarCategoria(){
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    
        require_once ROOT_PATH.'/app/Models/modelGestion.php';
        require_once ROOT_PATH.'/app/Models/modelAdministrador.php';

        //Asignaciones
            $nombre = $_POST["nombre"];
            $descripcion = $_POST["descripcion"];
            $imagenSubida = $_FILES;
            
        //Procesos    
            $nombre = sanearTexto($nombre);
            $descripcion = sanearTexto($descripcion);
            $imagenSubida = validarImagen($imagenSubida);
            $imagenSubida = moverImagen($imagenSubida);
            

        //Modificar BD
        if($nombre != false && $descripcion != false && $imagenSubida != false){

                if (isset($_SESSION['usuario'])) {
                    $admin = unserialize($_SESSION['usuario']);
                    $admin ->agregarCategoria($nombre,$descripcion,$imagenSubida);
                    $mensajeExito =" Categoría agregada correctamente.";

                    $categoria = new Categoria();

                    $_SESSION['Categorias'] = $categoria -> getCategorias();

                    require_once ROOT_PATH.'/app/Views/viewAdminProductos.php'; 
                }else{
                    echo "Error al obtener el usuario";
                }
            }else{
                $errores= "Todo el formulario debe ser completado";
                require_once ROOT_PATH.'/app/Views/viewAdminProductos.php'; 
            }
         }
}

function editarCategoria($id){
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    require_once ROOT_PATH.'/app/Models/modelGestion.php';
    require_once ROOT_PATH.'/app/Models/modelAdministrador.php';

    $categoria= new Categoria($id);
    require_once ROOT_PATH."/app/Views/viewAdminModificarCategoria.php";
    
    
}
function modificarCategoria(){
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    
        require_once ROOT_PATH.'/app/Models/modelGestion.php';
        require_once ROOT_PATH.'/app/Models/modelAdministrador.php';

        //Asignaciones
            $nombre = $_POST["nombre"];
            $descripcion = $_POST["descripcion"];
            $imagenSubida = $_FILES;
            $id = $_POST['id'];
            
        //Procesos    
            $nombre = sanearTexto($nombre);
            $descripcion = sanearTexto($descripcion);
            $imagenSubida = validarImagen($imagenSubida);
            $imagenSubida = moverImagen($imagenSubida);
            $id = validarInt($id);
            
        //Modificar BD
        if($nombre != false && $descripcion != false && $imagenSubida != false && $id != false){
                       
                if (isset($_SESSION['Categorias'])) {

                    $categoria= new Categoria();
                    
                    $categoria ->updateCategoria($nombre ,$descripcion,$imagenSubida,$id);
                    
                    $mensajeExito="La categoría ha sido modificada.";
                    
                
                    $_SESSION['Categorias'] = $categoria -> getCategorias();
                    require_once ROOT_PATH.'/app/Views/viewAdminProductos.php'; 
                }else{
                    echo "Error al obtener la categoría";
                }
            }else{
                $errores= "Todo el formulario debe ser completado";
                require_once ROOT_PATH."/app/Views/viewAdminModificarCategoria.php";
            }
         }
}


function eliminarCategoria($id){

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        require_once ROOT_PATH.'/app/Models/modelGestion.php';

        $id = validarInt($id);

        if($id != false){

                $categoria= new Categoria($id);
                
                $imagen= $categoria->getRutaImagenCategoria();
                
                eliminarImagenes($imagen);
                
                $categoria ->removeCategoria($id);

                $mensajeExito="La categoria ha sido eliminada.";
                
                

                $_SESSION['Categorias'] = $categoria -> getCategorias();

                require_once ROOT_PATH.'/app/Views/viewAdminProductos.php'; 
        }else{
            echo "Error al obtener la categoria";
            }
        
     
}
?>