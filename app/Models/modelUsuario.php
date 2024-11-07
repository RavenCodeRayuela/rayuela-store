<?php

require_once "config/conexionBD.php";
/**
 * La clase usuario contiene lo referente al usuario, clase padre de cliente y administrador
 */
class Usuario {
    //Atributos del objeto usuario.
    protected $id;
    protected $nombre;
    protected $email;
    protected $password;
    protected $tipoDeUsuario;


    /**
     * El constructor puede recibir parametros o no, en caso de no recibir parametros se les asigna null
     * y se pueden utilizar los metodos. En caso de recibir todos los parametros
     * se aplican, si recibe el email, lo busca en la base de datos y asigna el nombre al usuario
     * @param mixed $id
     * @param mixed $email
     * @param mixed $password
     * @param mixed $tipoDeUsuario
     */
    public function __construct($id = null, $email = null, $password = null, $tipoDeUsuario = null){
        $this -> id = $id;
        $this -> email = $email;
        $this -> password = $password;
        $this ->tipoDeUsuario = $tipoDeUsuario;

        if($email!= null){
            if($this -> obtenerUsuarioBD($email)){
                $usuarioMom= $this->obtenerUsuarioBD($email);
                $this -> nombre = $usuarioMom['Nombre'];
                $this -> id = $usuarioMom['Id_usuario'];
                $this -> email = $email;
                $this -> password = $usuarioMom['password'];
                $this ->tipoDeUsuario = $usuarioMom['Id_tipo'];
            }
        }
    }

    //Getters y setters
    public function  setId($id){
        $this ->id = $id;
    }
    public function setNombre($nombre){
        $this -> nombre = $nombre;
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
    public function getNombre(){
        return $this->nombre;
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




    /**
     * Verifica que el email exista en la base de datos
     * @param mixed $email
     * @return bool
     */
    protected function existeEmail($email) {
        $conexion=ConexionBD::getInstance();

        $sql = "SELECT * FROM usuarios WHERE email = :email";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([':email' => $email]);
        return $stmt->fetch() !== false;
    }
    /**
     * Recibe un email por parametro, y obtiene el usuario mediante el email
     * Devuelve la fila correspondiente al usuario o false en caso de fallo
     * @param mixed $email
     * @return mixed
     */
    protected function obtenerUsuarioBD($email){
        $conexion=ConexionBD::getInstance();

        $sql = "SELECT * FROM usuarios WHERE email = :email";
        $stmt = $conexion ->prepare($sql);
     
        // Ejecutar la consulta SQL, pasando el email de usuario como parametro        
        $stmt->execute([':email' => $email]);
     
      // Obtener la fila del usuario de la base de datos
      $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

      return $usuario;
    }
    /**
     * Recibe el email y la contraseña, verifica que el email exista en la
     * base de datos, si existe verifica la contraseña, en caso de exito
     * devuelve la fila correspondiente al usuario, caso contrario devuelve false
     * @param mixed $email
     * @param mixed $password
     * @return mixed
     */
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