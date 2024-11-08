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

        //Recordar & para poder aplicar cambios en el foreach
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
    
}
?>