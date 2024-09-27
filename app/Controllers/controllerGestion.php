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
            $imagenSubida = $_FILES;
            $categoriaId = $_POST["categoria"];
            
        //Procesos    
            $nombre = sanearTexto($nombre);
            $descripcion = sanearTexto($descripcion);
            $cantidad = validarInt($cantidad);
            $precioUnitario = validarFloatPositivo($precioUnitario);
            $descuento = validarFloatPorcentaje($descuento);
            $imagenSubida = validarImagen($imagenSubida);
            $imagenSubida = moverImagen($imagenSubida);
            $categoriaId = validarInt($categoriaId);

        //Modificar BD
        if($nombre != false && $descripcion != false && $precioUnitario != false && $descuento != false && $imagenSubida != false && $categoriaId != false){
                       
                if (isset($_SESSION['usuario'])) {
                    
                    $admin = unserialize($_SESSION['usuario']);
                    $admin ->agregarProducto($nombre,$descripcion,$precioUnitario,$descuento,$categoriaId,$cantidad,$imagenSubida);
                    
                    $mensajeExito="El producto ha sido ingresado.";
                    
                    $producto= new Producto();

                    $_SESSION['Productos'] = $producto -> getProductos();
                    $admin -> imprimir();
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
            $imagenSubida = $_FILES;
            $categoriaId = $_POST["categoria"];
            $id = $_POST['productoModificar'];
            
        //Procesos    
            $nombre = sanearTexto($nombre);
            $descripcion = sanearTexto($descripcion);
            $cantidad = validarInt($cantidad);
            $precioUnitario = validarFloatPositivo($precioUnitario);
            $descuento = validarFloatPorcentaje($descuento);
            $imagenSubida = validarImagen($imagenSubida);
            $imagenSubida = moverImagen($imagenSubida);
            $categoriaId = validarInt($categoriaId);
            $id = validarInt($id);
            
        //Modificar BD
        if($nombre != false && $descripcion != false && $precioUnitario != false && $descuento != false && $imagenSubida != false && $categoriaId != false && $id != false && $cantidad != false){
                       
                if (isset($_SESSION['Productos'])) {

                    $producto= new Producto();
                    
                    $producto ->updateProducto($id ,$nombre,$descripcion,$precioUnitario,$descuento,$categoriaId,$cantidad,$imagenSubida);
                    
                    $mensajeExito="El producto ha sido modificado.";
                    
                    

                    $_SESSION['Productos'] = $producto -> getProductos();
                    require_once ROOT_PATH.'/app/Views/viewAdminProductos.php';
                }else{
                    echo "Error al obtener el producto";
                }
            }else{
                $errores= "Todo el formulario debe ser completado";
                require_once ROOT_PATH.'/app/Views/viewAdminProductos.php'; 
            }
         }
}

function eliminarProducto(){
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        require_once ROOT_PATH.'/app/Models/modelGestion.php';

        $id = $_POST['productoEliminar'];
        $id = validarInt($id);

        if($id != false){
            if (isset($_SESSION['Productos'])) {

                $producto= new Producto();
                
                $producto ->removeProducto($id);
                
                $mensajeExito="El producto ha sido eliminado.";
                
                

                $_SESSION['Productos'] = $producto -> getProductos();
                require_once ROOT_PATH.'/app/Views/viewAdminProductos.php';
            }else{
                echo "Error al obtener el producto";
            }
        }else{
            $errores= "Todo el formulario debe ser completado";
            require_once ROOT_PATH.'/app/Views/viewAdminProductos.php'; 
        }
     

        }


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

                    require_once ROOT_PATH.'/app/Views/viewAdminCategorias.php';
                }else{
                    echo "Error al obtener el usuario";
                }
            }else{
                $errores= "Todo el formulario debe ser completado";
                require_once ROOT_PATH.'/app/Views/viewAdminCategorias.php'; 
            }
         }
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
            $id = $_POST['categoria'];
            
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
                    require_once ROOT_PATH.'/app/Views/viewAdminCategorias.php';
                }else{
                    echo "Error al obtener la categoría";
                }
            }else{
                $errores= "Todo el formulario debe ser completado";
                require_once ROOT_PATH.'/app/Views/viewAdminCategorias.php'; 
            }
         }
}


function eliminarCategoria(){
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        require_once ROOT_PATH.'/app/Models/modelGestion.php';

        $id = $_POST['categoriaEliminar'];
        $id = validarInt($id);

        if($id != false){
            if (isset($_SESSION['Categorias'])) {

                $categoria= new Categoria();
                
                $categoria ->removeCategoria($id);
                
                $mensajeExito="La categoria ha sido eliminada.";
                
                

                $_SESSION['Categorias'] = $categoria -> getCategorias();
                require_once ROOT_PATH.'/app/Views/viewAdminCategorias.php';
            }else{
                echo "Error al obtener la categoria";
            }
        }else{
            $errores= "Todo el formulario debe ser completado";
            require_once ROOT_PATH.'/app/Views/viewAdminCategorias.php'; 
        }
     

    }
}
?>