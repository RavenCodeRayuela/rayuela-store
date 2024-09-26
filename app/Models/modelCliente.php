<?php
require_once 'modelUsuario.php';

class Cliente extends Usuario {

    
    private $celular;
    private $calle;

    private $numeroPuerta;

    private $ciudad;
    private $carrito;


    public function __construct($id = null, $email = null, $password = null, $tipoDeUsuario = null) {
        parent::__construct();
        $this -> id = $id;
        $this -> email = $email;
        $this -> password = $password;
        $this ->tipoDeUsuario = $tipoDeUsuario;

         if($this -> obtenerClienteBD($id)!= false){
              $clienteMom = $this -> obtenerClienteBD($id);

            $this -> calle  = $clienteMom['Calle'];
             $this -> ciudad  = $clienteMom['Ciudad'];
             $this -> numeroPuerta = $clienteMom['NroCasa'];
          }
    }

    public function setCelular($celular){
        $this -> celular = $celular;
    }

    public function getCelular(){
        return $this -> celular;
    }
    public function setNombre($nombre){
        $this -> nombre = $nombre;
    }
    public function getNombre(){
        return $this->nombre;
    }
    public function addDireccionDeEnvio(){

    }
    public function removeDireccionDeEnvio(){}

    public function obtenerClienteBD($idUsuario){
        $sql = "SELECT * FROM clientes WHERE Id_cliente = :Id_cliente";
        $stmt = $this-> conexion ->prepare($sql);
     
        // Ejecutar la consulta SQL, pasando el nombre de usuario como parámetro        
      $stmt->execute([':Id_cliente' => $idUsuario]);
     
      // Obtener la fila del usuario de la base de datos
      $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

      return $usuario;
    }


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
                ':Id_tipo'=>2
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

                    echo "Error: ". $e -> getMessage();
                } 
    }
   
}

class Carrito{
    private $productos;
    private $costoAcumulado;


    public function generarPedido(){}
    public function addProducto(){}
}


?>