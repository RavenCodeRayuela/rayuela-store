<?php


class Pedido{
    private $id;
    private $fecha;
    private $carritoAsociado;
    private $estado;
    private $valoracion;
    private $lineasDePedido;
    private $pago;

    public function calcularTotal(){}
    public function añadirValoracion(){}
    public function pagarPedido(){}
}

class LineaDePedido{
    private $nombreDeProducto;
    private $cantidadDeProducto;
    private $precioDeLinea;
}

?>