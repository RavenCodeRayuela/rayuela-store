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

    $cat= new Categoria();
    $categorias= $cat->getCategorias();

    $productosPorPagina = 9;
    
    $producto = new Producto();

    if($categoria=='all'){
        $totalProductos= $producto->contarTotalProductos();
        $totalPaginas = ceil($totalProductos / $productosPorPagina);
        $productos = $producto->getProductosPaginados($paginaActual, $productosPorPagina);
    }


    require_once ROOT_PATH.'/app/Views/viewProductos.php';
}

function mostrarSingleProduct($id){
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

function mostrarNosotros(){

}

function mostrarInfoContacto(){}
function mostrarPerfil(){
    require_once ROOT_PATH.'/app/Views/viewClientePerfil.php';
}
?>