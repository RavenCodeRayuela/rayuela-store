<?php
    require_once (dirname(__FILE__,3) ."/config/paths.php");
    require_once ROOT_PATH.'/app/Controllers/validaciones.php';
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

        //Categorias para la sidebar y nombre de pagina
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

function mostrarBackoffice($paginaActual){
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
        }
 
    require_once ROOT_PATH.'/app/Models/modelCompra.php';
    require_once ROOT_PATH.'/app/Models/modelUsuario.php';

    
    $compra= new Compra();

    $comprasPorPagina = 4;                
        
    $totalCompras= $compra->contarTotalComprasPreparandose();
    $totalPaginas = ceil($totalCompras / $comprasPorPagina);

    $compras= $compra->getComprasPaginadasPreparandose($paginaActual,$comprasPorPagina);
    

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
    require_once ROOT_PATH.'/app/Models/modelCliente.php';

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
        }

        //Cliente, para obtener las direcciones del cliente.
        $usuario= new Usuario(null,$_SESSION['user_email']);
        $cliente= new Cliente($usuario->getId());
    
        //Direcciones
        $direcciones = $cliente->getDireccionesDeEnvio();
        
        //Tipos de pago
        $pagoAlContadoEfectivo="Pago al contado en efectivo";
        $pagoAlContadoTransferencia="Pago al contado por transferencia";

        $productos= array();
        
    if($_SESSION!=[] && $_SESSION['carrito']!=null){

        foreach ($_SESSION['carrito'] as $item) {
            
            $idProducto = $item['id'];
            $producto = new Producto($idProducto);
            $img = $producto->getImagenes();

            //Verificar si existe, sino se le asigna null a imagen
            $img = $img[0] ?? null;

             $productos[] = [
            'producto' => $producto,
            'cantidad' => $item['cantidad'],
            'imagen' => $img
        ];
        }
        
    }else{
        $mensaje= 'Aún no hay productos en tu carrito';
    }
    require_once ROOT_PATH.'/app/Views/viewCarrito.php';
}
function mostrarPerfil(){
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
        }
    
    require_once ROOT_PATH.'/app/Models/modelCliente.php';
    require_once ROOT_PATH.'/app/Models/modelUsuario.php';

    $usuario= new Usuario(null,$_SESSION['user_email']);
    $cliente= new Cliente($usuario->getId());

    $nombre= $usuario->getNombre();
    $email= $usuario->getEmail();
    $newsletter= $cliente->getSuscripcion();
    $celulares = $cliente->getCelulares();
    

    require_once ROOT_PATH.'/app/Views/viewClientePerfil.php';
}

function mostrarPerfilHistorial($paginaActual){
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
        }

    require_once ROOT_PATH.'/app/Models/modelCompra.php';
    require_once ROOT_PATH.'/app/Models/modelUsuario.php';
    require_once ROOT_PATH.'/app/Models/modelCliente.php';

    $usuario= new Usuario(null,$_SESSION['user_email']);
    $idCliente= $usuario->getId();

    $compra= new Compra();

    $comprasPorPagina = 4;                
        
    $totalComprasCliente= $compra->contarTotalComprasPorId($idCliente);
    $totalPaginas = ceil($totalComprasCliente / $comprasPorPagina);

    $compras= $compra->getComprasDeClientePaginadas($idCliente,$paginaActual,$comprasPorPagina);
    
   

    require_once ROOT_PATH.'/app/Views/viewClienteHistorial.php';
}

function mostrarFormComprobantePago($idCompra,$pagina){
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
        }
    
   
    require_once ROOT_PATH.'/app/Views/viewClienteSubirComprobante.php';
}
function mostrarPerfilDirecciones(){
    require_once ROOT_PATH.'/app/Models/modelUsuario.php';
    require_once ROOT_PATH.'/app/Models/modelCliente.php';

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
        }

    $usuario= new Usuario(null,$_SESSION['user_email']);
    $cliente= new Cliente($usuario->getId());

    $direcciones = $cliente->getDireccionesDeEnvio();

    require_once ROOT_PATH.'/app/Views/viewClienteDirecciones.php';
}

function mostrarAgregarDireccion(){
    require_once ROOT_PATH.'/app/Views/viewClienteAgregarDireccion.php';
}
function mostrarModificarDireccion($id){
    require_once ROOT_PATH.'/app/Models/modelCliente.php';
    
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
        }
    
    $direccion= new DireccionDeEnvio($id);
    
    require_once ROOT_PATH.'/app/Views/viewClienteModificarDireccion.php';
}
function mostrarPerfilEliminarCuenta(){
    require_once ROOT_PATH.'/app/Views/viewClienteEliminarCuenta.php';
}

function mostrarNosotros(){
    require_once ROOT_PATH.'/app/Views/viewNosotros.php';
}

function mostrarInfoContacto(){
    require_once ROOT_PATH.'/app/Views/viewContacto.php';
}
function mostrarFormValoracion($idCompra,$pagina){
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
        }
    

    require_once ROOT_PATH.'/app/Views/viewClienteValorarCompra.php';
}

function mostrarStock($paginaActual){
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
        }
   
    require_once ROOT_PATH.'/app/Models/modelGestion.php';

    $productosPorPagina = 20;
    
    $producto = new Producto();
    
    $totalProductos= $producto->contarTotalProductos();
    $totalPaginas = ceil($totalProductos / $productosPorPagina);

    $productos = $producto->getProductosPaginados($paginaActual, $productosPorPagina);

    require_once ROOT_PATH.'/app/Views/viewAdminStock.php';
}

function mostrarEstadisticasVentas(){
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
        }
   
    require_once ROOT_PATH.'/app/Models/modelGestion.php';
    require_once ROOT_PATH.'/app/Models/modelCompra.php';

    $compra = new Compra();
    $productosVendidos = $compra->getTopProductosVendidos();
    $ventasAnio= $compra->getGananciasPorPeriodo('anio');
    $ventasMes= $compra->getGananciasPorPeriodo('mes');
    $ventasSemana= $compra->getGananciasPorPeriodo('semana');

    require_once ROOT_PATH.'/app/Views/viewAdminEstadisticas.php';
}


function mostrarHistorialCompras($paginaActual){
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
        }
 
    require_once ROOT_PATH.'/app/Models/modelCompra.php';
    require_once ROOT_PATH.'/app/Models/modelUsuario.php';

    
    $compra= new Compra();

    $comprasPorPagina = 4;                
        
    $totalCompras= $compra->contarTotalCompras();
    $totalPaginas = ceil($totalCompras / $comprasPorPagina);

    $compras= $compra->getComprasPaginadas($paginaActual,$comprasPorPagina);
    

    require_once ROOT_PATH.'/app/Views/viewAdminHistorial.php';
}

?>