<?php
require_once 'modelCliente.php';



class Compra{

    
    private $idCompra;
    private $costoTotal;
    private $valoracion;
    private $estado;
    private $tipoDePago;
    private $idDireccion;

    //Contendra los detalles de compra
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