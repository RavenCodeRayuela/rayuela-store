<?php
require_once 'validaciones.php';
function agregarProductoCarrito($id, $cantidad){

    $_SESSION['carrito'][] = ['id' => $id,  'cantidad' => $cantidad];

   
}

?>