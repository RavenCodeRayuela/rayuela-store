<?php
require_once 'modelUsuario.php';

class Administrador extends Usuario{

    private $productos;
    private $categorias;

    public function __construct($id = null, $email = null, $password = null, $tipoDeUsuario = null) {
        parent::__construct();
        $this -> id = $id;
        $this -> email = $email;
        $this -> password = $password;
        $this ->tipoDeUsuario = $tipoDeUsuario;

        if($tipoDeUsuario == 1){
            //Llamar a metodos que busquen en la BD la información de los productos.
        }
    }

    public function obtenerIdAdmin(){
        $sql = "SELECT Id_usuario FROM usuarios WHERE Id_tipo = :Id_tipo";
        $stmt = $this-> conexion ->prepare($sql);
     
        // Ejecutar la consulta SQL, pasando el nombre de usuario como parámetro        
      $stmt->execute([':Id_tipo' => 1]);
     
      // Obtener la fila del usuario de la base de datos
      $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

      return $usuario['Id_usuario'];
    }
    
    public function mostrarEstadisticas(){}
    




}


?>