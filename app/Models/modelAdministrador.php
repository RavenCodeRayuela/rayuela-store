<?php
require_once 'modelUsuario.php';
require_once 'modelGestion.php';


class Administrador extends Usuario{

    private $productos;
    private $categorias;

    public function __construct($id = null, $email = null, $password = null, $tipoDeUsuario = null) {
        parent::__construct($id,$email,$password,$tipoDeUsuario);
      
    }

   
    public function obtenerAdmin(){

        $conexion=ConexionBD::getInstance();

        $sql = "SELECT Id_usuario FROM usuarios WHERE Id_tipo = :Id_tipo";
        $stmt = $conexion ->prepare($sql);
           
         $stmt->execute([':Id_tipo' => $this->id]);
     
      // Obtener la fila del usuario de la base de datos
      $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

      return $usuario['Id_usuario'];
    }
    

    public function agregarProducto($nombre,$descripcion,$precio,$descuento, $categoria, $cantidad, $rutaImagen){
        $producto = new Producto();
        $producto -> addProducto($nombre,$descripcion,$precio,$descuento, $categoria, $cantidad, $rutaImagen, $this->getId());
       
    }

    public function agregarCategoria($nombre, $descripcion,$rutaImagen){
        $categoria = new Categoria();
        $categoria -> addCategoria($nombre, $descripcion,$rutaImagen,$this->getId());
        
    }
    

    public function mostrarEstadisticas(){}


    public function imprimir(){
        
    }




}


?>