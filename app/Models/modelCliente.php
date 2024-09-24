<?php
require_once 'modelUsuario.php';

class Cliente extends Usuario {

    private $nombre;
    private $celular;
    private $direccionesDeEnvio;
    private $carrito;


    public function registrarCliente($email, $password, $suscripcion) {
        try{
            //Comenzar la transaccion
            $this-> conexion -> beginTransaction();

            // Comprobar si el email ya está registrado
            if ($this->existeEmail($email)) {
                return false;
            }
            // Insertar el nuevo usuario en la base de datos
            $sql1 = "INSERT INTO usuarios (Email, password, Id_tipo) VALUES (:Email, :password, :Id_tipo)";
            $stmt1 = $this->conexion->prepare($sql1);
            //Encriptar contraseña
            $passwordEnc = password_hash($password, PASSWORD_BCRYPT);

            $stmt1->execute([
                ':Email' => $email,
                ':password' => $passwordEnc,
                'Id_tipo'=>2
            ]);

            $idUsuario= (int) $this->conexion->lastInsertId();
            

            $sql2 = "INSERT INTO clientes (Id_cliente ,Suscripcion_newsletter) VALUES (:Id_cliente, :Suscripcion_newsletter)";
            $stmt2 = $this->conexion->prepare($sql2);
        
            $stmt2-> execute([
                ':Id_cliente' => $idUsuario,
                ':Suscripcion_newsletter' => $suscripcion
            ]);

            $this->conexion->commit();
            
            return true;

               }catch (Exception $e) {       
                    // Revertir transaccion
                    $this->conexion->rollBack();
                  throw $e; // Lanzar el error
                } 
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