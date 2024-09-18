<?php

require_once "../../config/conexionBD.php";

class Usuario extends conexionBD {
    //Atributos del objeto usuario.
    private $id;
    protected $email;
    protected $password;
    private $tipoDeUsuario;
    protected $conexion;

    //Hereda la conexion a BD
    public function __construct($tipoDeUsuario){
        $this -> tipoDeUsuario = $tipoDeUsuario;
        $this -> conexion = new conexionBD();
        $this -> conexion = $this -> conexion -> obtenerConexion();
    }

    
}


?>