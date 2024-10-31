<?php
require_once 'validaciones.php';
function agregarProductoCarrito(){

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
        $id = htmlspecialchars($_POST['id']);
        $cantidad = htmlspecialchars($_POST['cantidad']);

    $_SESSION['carrito'][] = ['id' => $id,  'cantidad' => $cantidad];

    $mensaje= 'Producto agregado al carrito!';

    $_SESSION['msjProdAgregadoACarrito']= $mensaje;

    
    // Redirigir al usuario
    header('Location:'.URL_PATH.'/index.php?controller=controllerHome&action=mostrarSingleProduct&id='.$id);
    exit();
   
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
                    unset($_SESSION['carrito'][$key]);
                    break;
                }
            }
        }

        // Reindexar el array
        $_SESSION['carrito'] = array_values($_SESSION['carrito']);
    }

     // Redirigir al usuario
     header('Location:'.URL_PATH.'/index.php?controller=controllerHome&action=mostrarCarrito');
     exit();
}

?>