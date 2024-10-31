<?php
class DireccionDeEnvio{
    private $idDireccion;
    private $calle;

    private $numeroPuerta;

    private $ciudad;

    public function __construct($calle,$numeroPuerta,$ciudad){
        $this->calle = $calle;
        $this->numeroPuerta = $numeroPuerta;
        $this->ciudad = $ciudad;
    }

}



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