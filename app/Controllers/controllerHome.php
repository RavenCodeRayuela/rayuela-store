<?php
    require_once (dirname(__FILE__,3) ."/config/paths.php");
function mostrarHome(){
    require_once ROOT_PATH.'/app/Models/modelGestion.php';

    $cat= new Categoria();
    $catBD= $cat->getCategorias();
    $categorias= array();
    $prod = new Producto();
    //Hacer logica para filtrar datos 
    $prodts = $prod->getProductos();
    $productos = array();

    foreach ($prodts as $producto) {
        if($producto['Descuento']>5){
            $productos[]=$producto;
        }
    }

    
    if(!empty($catBD)){
        
        foreach ($catBD as $categoria) {
            $catMom= new Categoria($categoria['Id_categoria']);
            $categorias[]= $catMom;
        }
    }
    require_once ROOT_PATH.'/app/Views/viewIndex.php';
}

function mostrarProductos($categoria, $paginaActual){
    require_once ROOT_PATH.'/app/Models/modelGestion.php';


    $productosPorPagina = 9;
    
    $producto = new Producto();

    if($categoria=='all'){

        //Categorias para la sidebar
        $cat= new Categoria();
        $categorias= $cat->getCategorias();
        //Todos los productos
        $totalProductos= $producto->contarTotalProductos();
        $totalPaginas = ceil($totalProductos / $productosPorPagina);
        $productos = $producto->getProductosPaginados($paginaActual, $productosPorPagina);
    }else{

        //Categorias para la sidebar y nombre de página
        $category= new Categoria($categoria);
        $categorias= $category->getCategorias();
        
        //Todos los productos de la categoria
        $totalProductos= $producto->contarTotalProductosPorCategoria($categoria);
        $totalPaginas = ceil($totalProductos / $productosPorPagina);

        $productos = $producto->getProductosPaginadosPorCategoria($paginaActual,$productosPorPagina,$categoria);
    }


    require_once ROOT_PATH.'/app/Views/viewProductos.php';
}

function mostrarSingleProduct($id){
    require_once ROOT_PATH.'/app/Models/modelGestion.php';

    $producto = new Producto($id);
    $idCategoria= $producto->getCategoria();

    $imagenes= $producto->getImagenes();
    $categoria= new Categoria($idCategoria);


    require_once ROOT_PATH.'/app/Views/viewSingleProduct.php';
}
function mostrarLogin(){
    require_once ROOT_PATH.'/app/Views/viewFormLogin.php';
}

function mostrarRegistro(){
    require_once ROOT_PATH.'/app/Views/viewFormRegistro.php';
}

function mostrarBackoffice(){
    require_once ROOT_PATH.'/app/Views/viewAdmin.php';
}

function mostrarAgregarProducto(){
    require_once ROOT_PATH.'/app/Views/viewAdminAgregarProducto.php';
}

function mostrarAgregarCategoria(){
    require_once ROOT_PATH.'/app/Views/viewAdminAgregarCategoria.php';
}

function mostrarCarrito(){
    require_once ROOT_PATH.'/app/Models/modelGestion.php';

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
        }
        //$prod= new Producto();
        //$imgProd= $prod->getProductos();    
        $productos= array();
        
    if($_SESSION!=[] && $_SESSION['carrito']!=null){
        foreach ($_SESSION['carrito'] as $idProducto) {
            $producto = new Producto($idProducto);
            $productos[] = $producto;
        }
        
    }else{
        $mensaje= 'Aún no hay productos en tu carrito';
    }
    require_once ROOT_PATH.'/app/Views/viewCarrito.php';
}
function mostrarPerfil(){
    require_once ROOT_PATH.'/app/Views/viewClientePerfil.php';
}

?>