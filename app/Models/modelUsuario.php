<?php

require_once "config/conexionBD.php";

class Usuario {
    //Atributos del objeto usuario.
    protected $id;
    protected $nombre;
    protected $email;
    protected $password;
    protected $tipoDeUsuario;



    public function __construct(){}

    public function  setId($id){
        $this ->id = $id;
    }

    public function setEmail($email){
        $this -> email = $email;
    }
    public function setPassword($password){
        $this -> password = $password;
    }

    public function setTipoDeUsuario($tipoDeUsuario){
        $this ->tipoDeUsuario = $tipoDeUsuario;
    }

    public function getId(){
        return $this -> id;
    }

    public function getEmail(){
        return $this -> email;
    }

    public function getPassword(){
        return $this -> password;
    }

    public function getTipoDeUsuario(){
        return $this ->tipoDeUsuario;
    }





    protected function existeEmail($email) {
        $conexion=ConexionBD::getInstance();

        $sql = "SELECT * FROM usuarios WHERE email = :email";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([':email' => $email]);
        return $stmt->fetch() !== false;
    }

    protected function obtenerUsuarioBD($email){
        $conexion=ConexionBD::getInstance();

        $sql = "SELECT * FROM usuarios WHERE email = :email";
        $stmt = $conexion ->prepare($sql);
     
        // Ejecutar la consulta SQL, pasando el nombre de usuario como parámetro        
        $stmt->execute([':email' => $email]);
     
      // Obtener la fila del usuario de la base de datos
      $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

      return $usuario;
    }

    public function loginUsuario($email, $password){

        if ($this->existeEmail($email)) {

            $usuario = $this->obtenerUsuarioBD($email);

                if (password_verify($password, $usuario['password'])) {
                // Si la contraseña coincide, devolver la información del usuario
                    return $usuario;
                }else{
                    return false;
                }
           
        }else{
            return false;
        }

    }
}



?>