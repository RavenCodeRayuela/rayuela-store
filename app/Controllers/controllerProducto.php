<?php
require_once 'validaciones.php';
function agregarProducto(){
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        require_once ROOT_PATH.'/app/Models/modelGestion.php';
       
        //Asignaciones
            $nombre = $_POST["nombre"];
            $descripcion = $_POST["descripcion"];
            $cantidad = $_POST["cantidad"];
            $precioUnitario = $_POST["precio_unitario"];
            $descuento =$_POST["descuento"];
            $imagenSubida = $_FILES;
            
        //Procesos    
            $nombre = sanearTexto($nombre);
            $descripcion = sanearTexto($descripcion);
            $cantidad = validarInt($cantidad);
            $precioUnitario = validarFloatPositivo($precioUnitario);
            $descuento = validarFloatPorcentaje($descuento);
            $imagenSubida = validarImagen($imagenSubida);
            $imagenSubida = moverImagen($imagenSubida);
            

        //Modificar BD
            if($nombre != false && $descripcion != false && $precioUnitario != false && $descuento != false && $imagenSubida != false){
                //Volver a hacer este codigo
                $producto= new Producto();
               $producto->addProducto($nombre,$descripcion,$precioUnitario,$descuento,"Gorro",$cantidad,$imagenSubida);
            }else{
                $errores= "Todo el formulario debe ser completado";
                require_once ROOT_PATH.'/app/Views/viewAdminProductos.php'; 
            }
   

    
    }
}
?>