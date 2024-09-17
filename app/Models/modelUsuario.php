<?php

require "config\conexionBD.php";

class Usuario extends conexionBD
    {
    //Atributos del objeto usuario.
    private $nombre;
    private $celular;
    private $email;
    private $password;
    private $suscripcion;
    private $conexion;

    //Hereda la conexion a BD
    public function __construct(){
        $this -> conexion = new conexionDb();
        $this -> conexion = $this -> conexion -> obtenerConexion();
    }

    public function registrarUsuarioEnBD($email, $password, $passwordCh, $suscripcion){

    }
}


?>