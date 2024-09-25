<?php
require_once 'modelUsuario.php';

class Administrador extends Usuario{

    private $productos;
    private $categorias;

    public function __construct($id, $email, $password, $tipoDeUsuario) {
        $this -> id = $id;
        $this -> email = $email;
        $this -> password = $password;
        $this ->tipoDeUsuario = $tipoDeUsuario;

        if($tipoDeUsuario == 1){
            //Llamar a metodos que busquen en la BD la información de los productos.
        }
    }

    public function addProducto(){}
    public function removeProducto(){}
    public function updateProducto(){}
    public function addCategoria(){}
    public function removeCategoria(){}
    public function updateCategoria(){}
    public function mostrarEstadisticas(){}
    




}


?>