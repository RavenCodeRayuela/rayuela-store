<?php
require_once 'modelUsuario.php';

class Cliente extends Usuario {

    private $nombre;
    private $celular;
    private $direccionesDeEnvio;
    private $carrito;


    public function registrarCliente($email, $password, $suscripcion) {
        
        // Comprobar si el email ya está registrado
        if ($this->existeEmail($email)) {
            return false;
        }

        // Insertar el nuevo usuario en la base de datos
        $sql = "INSERT INTO usuarios (email, password, suscripcion) VALUES (:email, :password, :suscripcion)";
        $stmt = $this->conexion->prepare($sql);

        //Encriptar contraseña
        $passwordEnc = password_hash($password, PASSWORD_BCRYPT);

        return $stmt->execute([
            ':email' => $email,
            ':password' => $passwordEnc,
            ':suscripcion' => $suscripcion
        ]);
    }

    private function existeEmail($email) {
        $sql = "SELECT * FROM usuarios WHERE email = :email";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([':email' => $email]);
        return $stmt->fetch() !== false;
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