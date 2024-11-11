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
            $errores="";
            
        //Procesos    
            $nombre = sanearTexto($nombre);
            $errores.= textoSinCaracteresEspeciales($nombre);
            $errores.= validarLargoCampo($nombre,55);

            $descripcion = sanearTexto($descripcion);
            $errores.= textoSinCaracteresEspeciales($descripcion);
            $errores.= validarLargoCampo($descripcion,295);

            $cantidad = validarInt($cantidad);
            $precioUnitario = validarFloatPositivo($precioUnitario);
            $descuento = validarFloatPorcentaje($descuento);

            $imagenes = validarImagenes($imagenes);
           
            
            $categoriaId = validarInt($categoriaId);
            
        //Modificar BD
        if($nombre != false && $descripcion != false && $precioUnitario != false && is_float($descuento) && $imagenes != false && $categoriaId != false && $errores ==""){
            
                if (isset($_SESSION['usuario'])) {
                    
                    $admin = unserialize($_SESSION['usuario']);
                    $imagenes = moverImagenes($imagenes);
                    $admin ->agregarProducto($nombre,$descripcion,$precioUnitario,$descuento,$categoriaId,$cantidad,$imagenes);
                    
                    $mensajeExito="El producto ha sido ingresado.";
                    setMensaje($mensajeExito, 'exito');
                    $producto= new Producto();

                    $_SESSION['Productos'] = $producto -> getProductos();
                    
                    header("Location: index.php?controller=controllerGestion&action=listarProductos");
                    exit();
                }else{
                    echo "Error al obtener el usuario";
                }
            }else{
                $errores.= "Todo el formulario debe ser completado, no se admiten 0 o valores negativos excepto en el campo descuento";
                setMensaje($errores, 'error');
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
            $errores="";

        //Procesos    
            $nombre = sanearTexto($nombre);
            $errores.= textoSinCaracteresEspeciales($nombre);
            $errores.= validarLargoCampo($nombre,55);

            $descripcion = sanearTexto($descripcion);
            $errores.= textoSinCaracteresEspeciales($descripcion);
            $errores.= validarLargoCampo($descripcion,295);

            $cantidad = validarInt($cantidad);
            $precioUnitario = validarFloatPositivo($precioUnitario);
            $descuento = validarFloatPorcentaje($descuento);

            $imagenes = validarImagenes($imagenes);
           

            $categoriaId = validarInt($categoriaId);
            $id = validarInt($id);
            
        //Modificar BD
        if($nombre != false && $descripcion != false && $precioUnitario != false && is_float($descuento) && $imagenes != false && $categoriaId != false && $id != false && $cantidad != false && $errores=""){
                       
                if (isset($_SESSION['Productos'])) {

                    $imagenes = moverImagenes($imagenes);
                    $producto= new Producto();
                    
                    $producto ->updateProducto($id ,$nombre,$descripcion,$precioUnitario,$descuento,$categoriaId,$cantidad,$imagenes);
                    
                    $mensajeExito="El producto ha sido modificado.";
                    setMensaje($mensajeExito,'exito');
                    

                    $_SESSION['Productos'] = $producto -> getProductos();
                    
                    header("Location: index.php?controller=controllerGestion&action=listarProductos");
                    exit();
                }else{
                    setMensaje("Error al obtener el producto",'error');
                }
            }else{
                $errores.="Todo el formulario debe ser completado, no se admiten 0 o valores negativos excepto en el campo descuento, verificar tambien que no se hayan introducido caracteres especiales";
                setMensaje($errores,"error");
                
                header("Location:".URL_PATH.'/index.php?controller=controllerGestion&action=editarProducto&id='.$id);
                exit();
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
                $banderaAcuadros=true;

                foreach ($imagenes as $imagen) {
                    if($producto->comprobarUsoDeImagen($imagen['Ruta_imagen_producto'])){
                       $bandera=false; 
                    }
                }

               if($banderaAcuadros){
                eliminarImagenes($imagenes);
               }
                
                
                if(!$producto ->removeProducto($id)){
                    $mensajeError="El producto está relacionado a compras existentes en el sistema, por ello no se puede eliminar.";
                    setMensaje($mensajeError, 'error');
                    
                    header("Location: index.php?controller=controllerGestion&action=listarProductos");
                    exit();
                }
                
                $mensajeExito="El producto ha sido eliminado.";
                setMensaje($mensajeExito, 'exito');

                $_SESSION['Productos'] = $producto -> getProductos();

                header("Location: index.php?controller=controllerGestion&action=listarProductos");
                    exit();
             
            }else{
            setMensaje("Error al obtener el producto", 'error');
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
            $errores="";

        //Procesos    
            $nombre = sanearTexto($nombre);
            $errores.= textoSinCaracteresEspeciales($nombre);
            $errores.= validarLargoCampo($nombre,55);

            $descripcion = sanearTexto($descripcion);
            $errores.= textoSinCaracteresEspeciales($descripcion);
            $errores.= validarLargoCampo($descripcion,120);

            $imagenSubida = validarImagen($imagenSubida);
            
            

        //Modificar BD
        if($nombre != false && $descripcion != false && $imagenSubida != false && $errores ==""){

                if (isset($_SESSION['usuario'])) {
                    $imagenSubida = moverImagen($imagenSubida);
                    $admin = unserialize($_SESSION['usuario']);
                    $admin ->agregarCategoria($nombre,$descripcion,$imagenSubida);
                    $mensajeExito =" Categoría agregada correctamente.";

                    setMensaje($mensajeExito, 'exito');
                    $categoria = new Categoria();

                    $_SESSION['Categorias'] = $categoria -> getCategorias();

                    header("Location: index.php?controller=controllerGestion&action=listarCategorias");
                    exit();
                }else{
                    echo "Error al obtener el usuario";
                }
            }else{
                $errores.= "Todo el formulario debe ser completado";
                setMensaje($errores, 'error');

                require_once ROOT_PATH.'/app/Views/viewAdminAgregarCategoria.php'; 
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
            $errores='';
        //Procesos    
            $nombre = sanearTexto($nombre);
            $errores.= textoSinCaracteresEspeciales($nombre);
            $errores.= validarLargoCampo($nombre,55);

            $descripcion = sanearTexto($descripcion);
            $errores.= validarLargoCampo($descripcion,120);
            $errores.= textoSinCaracteresEspeciales($descripcion);

            $imagenSubida = validarImagen($imagenSubida);
            
            $id = validarInt($id);
            
        //Modificar BD
        if($nombre != false && $descripcion != false && $imagenSubida != false && $id != false && $errores == '' ){
                       
                if (isset($_SESSION['Categorias'])) {

                    $imagenSubida = moverImagen($imagenSubida);
                    $categoria= new Categoria();
                    
                    $categoria ->updateCategoria($nombre ,$descripcion,$imagenSubida,$id);
                    
                    $mensajeExito="La categoría ha sido modificada.";
                    setMensaje($mensajeExito, 'exito');

                    $_SESSION['Categorias'] = $categoria -> getCategorias();

                    header("Location: index.php?controller=controllerGestion&action=listarCategorias");
                    exit(); 
                }else{
                    echo "Error al obtener la categoría";
                }
            }else{
                $errores.= "Todo el formulario debe ser completado";
                setMensaje($errores, 'error');

                header("Location:".URL_PATH.'/index.php?controller=controllerGestion&action=editarCategoria&id='.$id);
                exit(); 
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
                $producto= new Producto();

                $imagen= $categoria->getRutaImagenCategoria();
                
                if(!$producto->comprobarUsoDeImagen($imagen)){
                    eliminarImagenes($imagen);
                }
                
                if(!$categoria ->removeCategoria($id)){
                    $mensajeError="La categoría contiene productos que están relacionados con compras, por ello no se pueden eliminar";
                    setMensaje($mensajeError, 'error');
                    
                    header("Location: index.php?controller=controllerGestion&action=listarCategorias");
                    exit(); 
                }

                $mensajeExito="La categoria ha sido eliminada.";
                setMensaje($mensajeExito, 'exito');
                
                $_SESSION['Categorias'] = $categoria -> getCategorias();

                header("Location: index.php?controller=controllerGestion&action=listarCategorias");
                    exit(); 

        }else{
            $mensajeError="Error al obtener la categoria";
            setMensaje($mensajeError, 'error');
                    
            header("Location: index.php?controller=controllerGestion&action=listarCategorias");
            exit();
            }
}

function listarCategorias($paginaActual){
    require_once ROOT_PATH.'/app/Models/modelGestion.php';
           
           $categoriasPorPagina = 10;                
           $categoria = new Categoria();
               
           $totalCategorias= $categoria->contarTotalCategorias();
           $totalPaginas = ceil($totalCategorias / $categoriasPorPagina);
           
           $categorias = $categoria->getCategoriasPaginadas($paginaActual, $categoriasPorPagina);
           
           require_once ROOT_PATH.'/app/Views/viewAdminListarCategorias.php';
           }
?>