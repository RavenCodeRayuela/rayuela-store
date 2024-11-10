<?php
require_once 'modelUsuario.php';


class Cliente extends Usuario {

    
    private array $celulares;

    private array $direccionesDeEnvio;

    private $suscripcion;
    private $carrito;


    public function __construct($id = null, $email = null, $password = null, $tipoDeUsuario = null) {

        parent::__construct($id, $email, $password, $tipoDeUsuario);
        $this->direccionesDeEnvio = array();
        $this->celulares = array();
        
         if($this -> obtenerClienteBD($id)){
            
            $clienteMom = $this -> obtenerClienteBD($id);
            $this ->setSuscripcion($clienteMom['Suscripcion_newsletter']);
            
            if($this->getNumerosCliente($id)){
                $this ->setCelulares($this->getNumerosCliente($id));
            }
           
            
             }

        $dirs= new DireccionDeEnvio();

        if($dirs->getDirecciones($id)){
            $this->setDireccionesDeEnvio($id);
        }
    }
    private function setDireccionesDeEnvio($id){
        
        $direccion= new DireccionDeEnvio();
        
        if($direccion->getDirecciones($id)){
            $dirMom= $direccion->getDirecciones($id);

            foreach ($dirMom as $direccion) {
                $this->addDireccionDeEnvio($direccion['Id_direccion'],$direccion['Calle'],$direccion['NroCasa'],$direccion['Ciudad'],$direccion['Comentario']);
            }
        }

    }
    private function addDireccionDeEnvio($id,$calle, $numeroPuerta, $ciudad,$comentario){
        $this->direccionesDeEnvio[]= new DireccionDeEnvio($id,$calle,$numeroPuerta,$ciudad,$comentario);
    }
    
    public function getDireccionesDeEnvio(){
        return $this->direccionesDeEnvio;
    }

    public function setSuscripcion($suscripcion){
        $this->suscripcion = $suscripcion;
    }
    public function getSuscripcion(){
        return $this->suscripcion;
    }

    public function addCelular($celular){
        $this->celulares[] = $celular;
    }

    public function setCelulares($celulares){
        $this->celulares = $celulares;
    }

    public function getCelulares(){
        return $this->celulares;
    }
    //Operaciones con BD
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

    public function getNumerosCliente($id){
        $conexion=ConexionBD::getInstance();

        $sql = "SELECT * FROM celulares WHERE Id_cliente = :Id_cliente";
        $stmt = $conexion ->prepare($sql);
     
               
        $stmt->execute([':Id_cliente' => $id]);
     
        
        $celulares = $stmt->fetchAll(PDO::FETCH_ASSOC);

          return $celulares;
    }

    public function cuClienteNombre($id, $nombre) {
        try{
        $conexion = ConexionBD::getInstance();
        $conexion -> beginTransaction();
        
        
        $sql = "INSERT INTO usuarios (Id_usuario, Nombre) VALUES (:Id_usuario, :Nombre) 
                     ON DUPLICATE KEY UPDATE Nombre = :Nombre";
        
        
        $stmt = $conexion->prepare($sql);
        
        $stmt->bindValue(':Id_usuario', $id, PDO::PARAM_INT);
        $stmt->bindValue(':Nombre', $nombre, PDO::PARAM_STR);
        
        if ($stmt->execute()) {
            $conexion->commit();
            return true;
        } else {
            return false;
        }
    }catch (Exception $e) {       
        // Revertir transaccion
        $conexion->rollBack();
        echo "Error: ". $e -> getMessage();
        return false;
    } 
}

    public function cuClienteCelular($id, $celular){
        try{
            $conexion = ConexionBD::getInstance();
            $conexion -> beginTransaction();
            
            
            $sql = "INSERT INTO celulares (Id_cliente, Numero_cel) VALUES (:Id_cliente, :Numero_cel) 
                        ON DUPLICATE KEY UPDATE Numero_cel = :Numero_cel";
            
            
            $stmt = $conexion->prepare($sql);
            
            $stmt->bindValue(':Id_cliente', $id, PDO::PARAM_INT);
            $stmt->bindValue(':Numero_cel', $celular, PDO::PARAM_STR);
            
            if ($stmt->execute()) {
                $conexion->commit();
                return true;
            } else {
                return false;
            }
        }catch (Exception $e) {       
            // Revertir transaccion
            $conexion->rollBack();
            echo "Error: ". $e -> getMessage();
            return false;
        } 
    }

    public function updateOpcionNewsletter($id,$newsletter){
        try{
            $conexion = ConexionBD::getInstance();
            $conexion -> beginTransaction();

            $sql = "UPDATE clientes SET Suscripcion_newsletter = :Suscripcion_newsletter
            WHERE Id_cliente = :Id_cliente";


            $stmt = $conexion->prepare($sql);

            $stmt->execute([
                ':Suscripcion_newsletter' => $newsletter,
                ':Id_cliente' => $id,
            ]);

            $conexion-> commit();
            return true;
        }catch (Exception $e) {       
            // Revertir transaccion
            $conexion->rollBack();
            echo "Error: ". $e -> getMessage();
            return false;
        } 

    }
}

class DireccionDeEnvio{
    private $idDireccion;
    private $calle;

    private $numeroPuerta;

    private $ciudad;
    private $comentario;

    public function __construct($id=null,$calle=null,$numeroPuerta=null,$ciudad=null,$comentario=null){
        $this->idDireccion = $id;
        $this->calle = $calle;
        $this->numeroPuerta = $numeroPuerta;
        $this->ciudad = $ciudad;
        $this->comentario = $comentario;

        if($id!=null && $calle==null && $numeroPuerta==null && $ciudad == null && $comentario  == null){
            if($this->obtenerDireccionPorId($id)){
                $dirMom= $this->obtenerDireccionPorId($id);

                $this->idDireccion = $id;
                $this->calle = $dirMom['Calle'];
                $this->numeroPuerta = $dirMom['NroCasa'];
                $this->ciudad = $dirMom['Ciudad'];
                $this->comentario = $dirMom['Comentario'];
            }
        }
    }

    //Getters y setters

    public function getIdDireccion(){
        return $this->idDireccion;
    }

    public function setIdDireccion($idDireccion){
        $this->idDireccion = $idDireccion;
    }

    public function getCalle(){
        return $this->calle;
    }

    public function setCalle($calle){
        $this->calle = $calle;
    }

    public function getNumeroPuerta(){
        return $this->numeroPuerta;
    }

    public function setNumeroPuerta($numeroPuerta){
        $this->numeroPuerta = $numeroPuerta;
    }

    public function getCiudad(){
        return $this->ciudad;
    }

    public function setCiudad($ciudad){
        $this->ciudad = $ciudad;
    }
    public function getComentario(){
        return $this->comentario;
    }
    public function setComentario($comentario){
        $this->comentario = $comentario;
    }

    public function obtenerDireccionPorId($id){

        $conexion=ConexionBD::getInstance();
            
        $stmt = $conexion->prepare ("SELECT Id_direccion, Ciudad, Calle, NroCasa, Comentario FROM direcciones_de_envio WHERE Id_direccion = :Id_direccion");

        if ($stmt->execute([':Id_direccion' => $id])) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        
        return false; 
    }

    public function getDirecciones($idCliente){

        $conexion=ConexionBD::getInstance();
            
        $stmt = $conexion->prepare ("SELECT Id_direccion, Ciudad, Calle, NroCasa, Comentario FROM direcciones_de_envio WHERE Id_cliente = :Id_cliente");

        if ($stmt->execute([':Id_cliente' => $idCliente])) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        
        return false; 
    }

    public function insertDireccion($idCliente,$calle,$numeroPuerta,$ciudad,$comentario){
        try{
            $conexion=ConexionBD::getInstance();
            $conexion -> beginTransaction();

            $sql = "INSERT INTO direcciones_de_envio (Ciudad, Calle, NroCasa, Comentario, Id_cliente) VALUES (:Ciudad, :Calle, :NroCasa, :Comentario, :Id_cliente)";
            
            $stmt = $conexion->prepare($sql);

            $stmt->execute([
                ':Ciudad' => $ciudad,
                ':Calle' => $calle,
                ':NroCasa'=> $numeroPuerta,
                ':Comentario'=> $comentario,
                ':Id_cliente' => $idCliente,
            ]);

            $conexion-> commit();
            return true;
        } catch(Exception $e){
            $conexion->rollBack();

            echo "Error: ". $e -> getMessage();
        }
        
    }

    public function updateDireccion($id,$calle,$numeroPuerta,$ciudad,$comentario){
        try{
            $conexion=ConexionBD::getInstance();
            $conexion -> beginTransaction();

            $sql = "UPDATE direcciones_de_envio SET Ciudad = :Ciudad, Calle = :Calle, NroCasa = :NroCasa,
            Comentario = :Comentario WHERE Id_direccion = :Id";
            
            $stmt = $conexion->prepare($sql);

            $stmt->execute([
                ':Ciudad' => $ciudad,
                ':Calle' => $calle,
                ':NroCasa'=> $numeroPuerta,
                ':Comentario'=> $comentario,
                ':Id' => $id,
            ]);

            $conexion-> commit();
            return true;

        } catch(Exception $e){
            $conexion->rollBack();

            echo "Error: ". $e -> getMessage();
        }
        
    }

    public function removeDireccion($id){
        $conexion=ConexionBD::getInstance();

            $stmt = $conexion->prepare("DELETE FROM direcciones_de_envio WHERE Id_direccion = :id");
            return $stmt->execute([':id' => $id ]);
    }
}

?>