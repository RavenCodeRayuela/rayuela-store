<?php
require_once "config/conexionBD.php";
require_once "modelAdministrador.php";
class Producto{

    private $id;
    private $nombre;
    private $descripcion;
    private $precio;
    private $descuento;
    private $categoria;
    private $cantidad;
    
    private $rutaImagenProducto;
    private $conexion;

    public function __construct(){
        $this -> conexion = new conexionBD();
        $this -> conexion = $this -> conexion -> obtenerConexion();
    }

    public function addProducto($nombre,$descripcion,$precio,$descuento, $categoria, $cantidad, $rutaImagen){
        try{
            $this-> conexion -> beginTransaction();

            $categoriaMom= new Categoria();
            $admin= new Administrador();

            if($categoriaMom ->obtenerCategoria($categoria) && ($admin -> obtenerIdAdmin()) !=NULL ){
                $categoriaObtenida = $categoriaMom ->obtenerCategoria($categoria);
                $idCategoria = $categoriaObtenida['Id_categoria'];
                $idAdmin =$admin -> obtenerIdAdmin();
            } else{
                throw new Exception("No se puede obtener la información necesaria.");
            }

            $sql = "INSERT INTO productos (Nombre, Precio_actual, Descuento, Descripcion_producto, Ruta_imagen_producto, Cantidad, Id_admin, Id_categoria) VALUES (:Nombre, :Precio_actual, :Descuento, :Descripcion_producto, :Ruta_imagen_producto, :Cantidad, :Id_admin, :Id_categoria)";
            
            $stmt = $this->conexion->prepare($sql);

            $stmt->execute([
                ':Nombre' => $nombre,
                ':Precio_actual' => $precio,
                ':Descuento'=> $descuento,
                ':Descripcion_producto'=> $descripcion,
                ':Ruta_imagen_producto'=> $rutaImagen,
                ':Cantidad' => $cantidad,
                ':Id_admin' => $idAdmin,
                ':Id_categoria' => $idCategoria
            ]);

            $this->conexion-> commit();
            return true;
        } catch(Exception $e){
            $this->conexion->rollBack();

            echo "Error: ". $e -> getMessage();
        }
    }

    
    public function removeProducto($idProducto){}
    public function updateProducto($id,$nombre,$descripcion,$precio,$descuento, $categoria, $cantidad, $rutaImagen){}

    public function listarProductos(){}

    public function verProducto($idProducto){}

}


class Categoria{
    private $id;
    private $nombre;
    private $descripcion;

    private $rutaImagenCategoria;
    private $conexion;

    public function __construct(){
        $this -> conexion = new conexionBD();
        $this -> conexion = $this -> conexion -> obtenerConexion();
    }

    public function addCategoria(){}
    public function removeCategoria(){}
    public function updateCategoria(){}

    public function obtenerCategoria($nombre){
        $sql = "SELECT * FROM categorias WHERE Nombre_categoria = :Nombre_categoria";
        $stmt = $this-> conexion ->prepare($sql);
     
        // Ejecutar la consulta SQL, pasando el nombre de usuario como parámetro        
      $stmt->execute([':Nombre_categoria' => $nombre]);
     
      // Obtener la fila del usuario de la base de datos
      $categoria = $stmt->fetch(PDO::FETCH_ASSOC);

      return $categoria;
    }

}


?>