<?php
require_once 'validaciones.php';
function agregarProductoCarrito(){

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    setMensaje("Producto agregado al carrito!",'exito');

        $id = htmlspecialchars($_POST['id']);
        $cantidad = htmlspecialchars($_POST['cantidad']);

        $productoExistente = false;

        //Recordar & para poder aplicar cambios en el foreach!!
        foreach ($_SESSION['carrito'] as &$producto) {
            if ($producto['id'] == $id) {
                $producto['cantidad'] += $cantidad; 
                $productoExistente = true; 
                break;
            }
        }
    
        if (!$productoExistente) {
            $_SESSION['carrito'][] = ['id' => $id, 'cantidad' => $cantidad];
        }
    contarCarrito();

    
    // Redirigir al usuario
    header('Location:'.URL_PATH."/index.php?controller=controllerHome&action=mostrarSingleProduct&id=".$id);
    exit();
   
}

function contarCarrito(){
    $totalArticulos = 0;
    
        foreach ($_SESSION['carrito'] as $producto) {
            $totalArticulos += $producto['cantidad'];
        }
    $_SESSION['articulosEnCarrito'] = $totalArticulos;

}

function eliminarProductoCarrito($id){
   
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $id = validarInt($id);

        if($id != false){

        if (isset($_SESSION['carrito'])) {
            
            foreach ($_SESSION['carrito'] as $key => $producto) {
                
                if ($producto['id'] == $id) {
                    if ($producto['cantidad'] == 1) {

                        unset($_SESSION['carrito'][$key]);
                        
                    }elseif ($producto['cantidad'] > 1) {
            
                        $_SESSION['carrito'][$key]['cantidad'] -= 1;
                    }

                    break;
                }
            }
        }

        // Reindexar el array
        $_SESSION['carrito'] = array_values($_SESSION['carrito']);
    }

        contarCarrito();

        setMensaje("Producto eliminado del carrito","exito");
     // Redirigir al usuario
     header('Location:'.URL_PATH.'/index.php?controller=controllerHome&action=mostrarCarrito');
     exit();
}


function procesarCompra(){
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    require_once ROOT_PATH.'/app/Models/modelGestion.php';
    require_once ROOT_PATH.'/app/Models/modelCliente.php';
    require_once ROOT_PATH.'/app/Models/modelCompra.php';

    //Variables del form carrito.

    //Para almacenar los errores.
    $errores="";

    //Usuario para obtener el id.
    $usuario= new Usuario(null,$_SESSION['user_email']);
    $idCliente= $usuario->getId();

    //Arreglo de productos
    $productos = array();
    $productos = $_POST['productos'];

    //Calculo de total de la compra
    $total = 0.0;
    foreach ($productos as $item) {
        $total += $item['precioProducto'] * $item['cantidadProducto'];
    }
    validarFloatPositivo($total);

    //Direccion de envio
    $idDireccion= $_POST['idDireccion'];
    validarInt($idDireccion);

    //Metodo de pago
    $metodoDePago = $_POST['metodoPago'];
    sanearTexto($metodoDePago);
    $errores=textoSinCaracteresEspeciales($metodoDePago);

    if($errores=="" && $total !== false && $idDireccion !== false && !empty($productos)){

        $valoracion="";
        $estado="Preparandose";
        $fecha = date("Y-m-d");

        //Declarar la compra para poder utilizar sus métodos
        $compra = new Compra();

        //La compra devuelve un id de la compra, con el cual poder añadir los detalles a la tabla detalle de compra
        $idCompra=$compra->addCompra($idCliente,$fecha,$total,$estado,$metodoDePago,$idDireccion);

        var_dump($idCompra);
        if($idCompra !== false){
            $detalleCompra = new DetalleCompra();
            //Por si una transaccion da problemas
            $bandera = true;

            foreach ($productos as $producto) {
                if($detalleCompra->addDetalleCompra($idCompra, $producto['idProducto'],$producto['cantidadProducto'],$producto['precioProducto'] )){

                }else{
                    $bandera = false;
                } 
            }
            if($bandera){
                //Preparar el mail y enviarlo
                $asunto="Nuevo pedido";
                $cuerpo= "<h1>Un nuevo pedido ha sido ingresado a Rayuela Store</h1><br>
                <p>El pedido: $idCompra ha sido ingresado en el sistema en la fecha: $fecha <br>
                 Por favor entra en el sistema para obtener más información</p>";
                
                $mensajeExito="El pedido ha sido ingresado, ahora lo prepararemos.\n";
                $mensajeExito.= enviarCorreo("admin@gmail.com",$asunto,$cuerpo,"rayuelaStore-noreply@gmail.com");
                setMensaje($mensajeExito, 'exito');

                
                $_SESSION['carrito'] = [];
                contarCarrito();
                
                header("Location: index.php?controller=controllerHome&action=mostrarPerfilHistorial");
                exit();
            }else{

                $mensajeError="Ha habido un problema al ingresar el pedido, lo sentimos";
                setMensaje($mensajeError, 'error');

                header("Location: index.php?controller=controllerHome&action=mostrarCarrito");
                exit();
            }
        }
       
    }else{
        $mensajeError="Ha habido un problema al ingresar el pedido, lo sentimos, compruebe que no haya campos sin completar, y que haya productos en el carrito.";
                setMensaje($mensajeError, 'error');

                header("Location: index.php?controller=controllerHome&action=mostrarCarrito");
                exit();
    }
}

function marcarPedidoEntregado($id, $page){
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    require_once ROOT_PATH.'/app/Models/modelGestion.php';
    require_once ROOT_PATH.'/app/Models/modelCompra.php';
 
    $compra = new Compra();
    $producto= new Producto();
    $estado = "Entregado"; 

    $producto= new Producto();
    $compraRealizada = $compra->getCompra($id);
    $bandera= true;


           
            foreach ($compraRealizada['productos'] as $productoCompra) {    
                $idProducto = $productoCompra['Id_producto'];
                $cantidad = $productoCompra['Cantidad_producto'];
        
                if ($producto->actualizarStock($idProducto, $cantidad)) {
                    // Siga siga diría un arbitro de futbol
                } else {
                    $bandera = false;  // Marca como falso si hay algun error
                }
            }
        

        if($bandera==true){
              //Preparar el mail y enviarlo
              $asunto="Compra lista";
              $cuerpo= "<h1>¡Tu compra en Rayuela Store esta lista y llegando a tí!</h1><br>
              <p>La compra con el id: $id en el sistema ha sido marcada como entregada y debe estar en viaje<br>
               Por favor entra en el sistema para obtener más información sobre tu compra</p>";

            $compra->updateCompra($id,$estado);
            $mensajeExito="Se ha cambiado el estado del pedido y actualizado el stock";
            $mensajeExito.= enviarCorreo($compraRealizada['cliente_email'],$asunto,$cuerpo,"rayuelaStore-noreply@gmail.com");

            setMensaje($mensajeExito, 'exito');
            header("Location: index.php?controller=controllerHome&action=mostrarBackoffice&page=".$page);
            exit();
        }else{

            setMensaje("Ha ocurrido un error al cambiar el estado del pedido, por favor comprobar stock de productos por posible falta de stock", 'error');
            
            header("Location: index.php?controller=controllerHome&action=mostrarBackoffice&page=".$page);
            exit();
        }
        
}

function cancelarPedido($id, $page){
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
   
    require_once ROOT_PATH.'/app/Models/modelCompra.php';

    $compra = new Compra();

    if($compra->removeCompra($id)){

        //Agregar envio de correo a cliente
        setMensaje("El pedido ha sido cancelado.", 'exito');

                
        header("Location: index.php?controller=controllerHome&action=mostrarBackoffice&page=".$page);
        exit();
    }else{
        setMensaje("Ha ocurrido un error al eliminar el pedido.", 'error');
        require_once ROOT_PATH.'/app/Views/viewAdmin.php';
    }
    
}

function procesarFormComprobantePago(){
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
 
    require_once ROOT_PATH.'/app/Models/modelCompra.php';

    $idCompra=$_POST['idCompra'];
    $pagina=$_POST['pagina'];

    $imagenComprobante = $_FILES;

     

    $imagenComprobante = validarImagen($imagenComprobante);


    if($imagenComprobante){
        $imagenComprobante = moverImagen($imagenComprobante);
        $compra= new Compra();

        $compra->updateCompra($idCompra,null,null,null,$imagenComprobante);
        
        setMensaje("El comprobante ha sido subido.", 'exito');

       
        header("Location: index.php?controller=controllerHome&action=mostrarPerfilHistorial&page=".$pagina);
        exit();
        
    }else{
        setMensaje("Ha ocurrido un error al subir el comprobante.", 'error');
        require_once ROOT_PATH.'/app/Views/viewClienteSubirComprobante.php';
    }
}

function procesarValoracion(){
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
 
    require_once ROOT_PATH.'/app/Models/modelCompra.php';

    $idCompra=$_POST['idCompra'];
    $pagina=$_POST['pagina'];
    $errores="";

    $comentario = sanearTexto($_POST['comentario']);
    $errores.= textoSinCaracteresEspeciales($comentario);
    $errores.= validarLargoCampo($comentario,300);


    if($errores==""){

        $compra= new Compra();

        $compra->updateCompra($idCompra,null,null,$comentario);
        
        setMensaje("¡Gracias por compartirnos tu experiencia!", 'exito');

       
        header("Location: index.php?controller=controllerHome&action=mostrarPerfilHistorial&page=".$pagina);
        exit();

    }else{
        setMensaje("Ha ocurrido un error al subir tu valoración.", 'error');
        require_once ROOT_PATH.'/app/Views/viewClienteValorarCompra.php';
    }


}

function generarEticket($idCompra){
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
 
    require_once ROOT_PATH.'/app/Models/modelCompra.php';

    $compra = new Compra();
    
    $compraRealizada= $compra->getCompra($idCompra);
    $rut= "043331230011";
    $serie="A";
    $numeroTicket="0321";
   

    $fecha = $compraRealizada['Fecha'];
    $nombre = $compraRealizada['cliente_nombre'];
    $detalleItems =$compraRealizada['productos'];
    $direccion=$compraRealizada['Ciudad']." - Calle:".$compraRealizada['Calle']." - NºCasa: ".$compraRealizada['NroCasa'];
    $comentario=$compraRealizada['Comentario']; 
    $subTotal=0.0;
    $ivaBasico=0.22;


    foreach ($detalleItems as $item) {
        $subTotal+=$item['precio']*$item['Cantidad_producto'];
    }

    $valorIva=$subTotal*$ivaBasico;

    generarETicketHTML($nombre,$rut,$serie,$numeroTicket,$fecha,$detalleItems,$subTotal,$valorIva,$direccion,$comentario);


}

function eliminarComprasEntregadas(){
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
        }
 
    require_once ROOT_PATH.'/app/Models/modelCompra.php';
    require_once ROOT_PATH.'/app/Models/modelUsuario.php';

    
    $compraModel= new Compra();

    $comprasEntregadas= $compraModel->getCompras();
    $contador=0;

    foreach ($comprasEntregadas as $compra) {
        if($compra['Estado']=="Entregado"){
            $compraModel->removeCompra($compra['Id_compra']);
            $contador++;
        }else{
            
        }
    }

    if($contador!=0){
        $mensajeExito="Las compras entregadas han sido eliminadas de la base de datos.";
    
        setMensaje($mensajeExito,"exito");    
    }else{
        $mensajeExito="No hay compras con estado de 'Entregado' para eliminar";
    
        setMensaje($mensajeExito,"exito");  
    }
   
    header("Location: index.php?controller=controllerHome&action=mostrarHistorialCompras");
    exit();
}
?>