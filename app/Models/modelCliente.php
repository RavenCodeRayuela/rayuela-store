<?php
require_once 'modelUsuario.php';
require_once 'modelCompra.php';

class Cliente extends Usuario {

    
    private $celulares;

    private array $direccionesDeEnvio;

    private $suscripcion;
    private $carrito;


    public function __construct($id = null, $email = null, $password = null, $tipoDeUsuario = null) {
        parent::__construct($id, $email, $password, $tipoDeUsuario);
        
         if($this -> obtenerClienteBD($id)!= false){
            
            $clienteMom = $this -> obtenerClienteBD($id);
            $this -> suscripcion  = $clienteMom['Suscripcion_newsletter'];

             }
    }

    public function addDireccionDeEnvio($calle, $numeroPuerta, $ciudad){
        $this->direccionesDeEnvio[]= new DireccionDeEnvio($calle,$numeroPuerta,$ciudad);
    }
    public function removeDireccionDeEnvio($idDireccion){
        //Desarrollar
    }

    public function obtenerClienteBD($idUsuario){
        $conexion=ConexionBD::getInstance();

        $sql = "SELECT * FROM clientes WHERE Id_cliente = :Id_cliente";
        $stmt = $conexion ->prepare($sql);
     
        // Ejecutar la consulta SQL, pasando el nombre de usuario como parámetro        
      $stmt->execute([':Id_cliente' => $idUsuario]);
     
      // Obtener la fila del usuario de la base de datos
      $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

      return $usuario;
    }


    public function registrarCliente($email, $password, $suscripcion) {
        try{
            $conexion=ConexionBD::getInstance();
            //Comenzar la transaccion
            $conexion -> beginTransaction();

            // Comprobar si el email ya está registrado
            if ($this->existeEmail($email)) {
                return false;
            }
            // Insertar el nuevo usuario en la base de datos
            $sql1 = "INSERT INTO usuarios (Email, password, Id_tipo) VALUES (:Email, :password, :Id_tipo)";
            $stmt1 = $conexion->prepare($sql1);
            //Encriptar contraseña
            $passwordEnc = password_hash($password, PASSWORD_BCRYPT);

            $stmt1->execute([
                ':Email' => $email,
                ':password' => $passwordEnc,
                ':Id_tipo'=>2
            ]);

            $idUsuario= (int) $conexion->lastInsertId();
            

            $sql2 = "INSERT INTO clientes (Id_cliente ,Suscripcion_newsletter) VALUES (:Id_cliente, :Suscripcion_newsletter)";
            $stmt2 = $conexion->prepare($sql2);
        
            $stmt2-> execute([
                ':Id_cliente' => $idUsuario,
                ':Suscripcion_newsletter' => $suscripcion
            ]);

            $conexion->commit();
            
            return true;

               }catch (Exception $e) {       
                    // Revertir transaccion
                    $conexion->rollBack();

                    echo "Error: ". $e -> getMessage();
                } 
    }
   
}

?>