<?php
require_once 'modelCliente.php';



class Compra{

    
    private $idCompra;
    private $costoTotal;
    private $valoracion;
    private $estado;
    private $tipoDePago;
    private $idDireccion;

    private array $detalleArticulos;
}

class DetalleCompra{
    private $idCompra;
    private $idProducto;
    private $cantidadProducto;
    private $precioPorProducto;
    private $precioDeLinea;
    private $fecha;
    
}
?>