<?php
require_once 'modelUsuario.php';

class Cliente extends Usuario {

    private $nombre;
    private $celular;
    private $direccionesDeEnvio;
    private $carrito;


    public function registrarCliente($email, $password, $passwordCh, $suscripcion){
        $mensajeDeError='';

        //Email
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
           
        if(!filter_var($email, FILTER_VALIDATE_EMAIL))
        $mensajeDeError.='Usted ha ingresado un email no valido.<br>';


        //Password
        

    }
    

    public function addCelular(){}
    public function updateCelular(){}
    public function addNombre(){}
    public function updateNombre(){}
    public function addDireccionDeEnvio(){}
    public function updateDireccionDeEnvio(){}
    public function removeDireccionDeEnvio(){}
}

class DireccionDeEnvio{

    private $calle;
    private $numero;
    private $ciudad;

}

class Carrito{
    private $productos;
    private $costoAcumulado;


    public function generarPedido(){}
    public function addProducto(){}
}


?>