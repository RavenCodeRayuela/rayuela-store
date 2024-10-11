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

    public function __construct(){
    }

    private function addImagenes($imagenes, $idProducto) {
        if (empty($imagenes) || empty($idProducto)) {
            return false;
        }
    
        $conexion = ConexionBD::getInstance();
        $sql = "INSERT INTO imagen_producto (Id_producto, Ruta_imagen_producto) VALUES (:Id_producto, :Ruta_imagen_producto)";
        $stmt = $conexion->prepare($sql);
    
        foreach ($imagenes as $rutaImagen) {
            if (!$stmt->execute([':Id_producto' => $idProducto, ':Ruta_imagen_producto' => $rutaImagen])) {
                return false; 
            }
        }
    
        return true; 
    }

    public function addProducto($nombre,$descripcion,$precio,$descuento, $categoria, $cantidad, $imagenes, $idAdmin){
        try{
            $conexion=ConexionBD::getInstance();
            $conexion -> beginTransaction();

            $sql = "INSERT INTO productos (Nombre, Precio_actual, Descuento, Descripcion_producto, Cantidad, Id_admin, Id_categoria) VALUES (:Nombre, :Precio_actual, :Descuento, :Descripcion_producto, :Cantidad, :Id_admin, :Id_categoria)";
            
            $stmt = $conexion->prepare($sql);

            $stmt->execute([
                ':Nombre' => $nombre,
                ':Precio_actual' => $precio,
                ':Descuento'=> $descuento,
                ':Descripcion_producto'=> $descripcion,
                ':Cantidad' => $cantidad,
                ':Id_admin' => $idAdmin,
                ':Id_categoria' => $categoria
            ]);

            $idProducto= (int) $conexion->lastInsertId();

            if (!$this->addImagenes($imagenes, $idProducto)) {
                throw new Exception("Error al agregar imagenes");
            }

            $conexion-> commit();
            return true;
        } catch(Exception $e){
            $conexion->rollBack();

            echo "Error: ". $e -> getMessage();
        }
    }

    
    public function removeProducto($idProducto){
        $conexion=ConexionBD::getInstance();

            $stmt = $conexion->prepare("DELETE FROM productos WHERE Id_producto = :id");
            return $stmt->execute([':id' => $idProducto ]);

    }
    public function updateProducto($id,$nombre,$descripcion,$precio,$descuento, $categoria, $cantidad, $imagenes){
        
        try {
            $conexion=ConexionBD::getInstance();
            $conexion -> beginTransaction();

            $stmt = $conexion->prepare("UPDATE productos SET Nombre = :nombre, Precio_actual = :precio, Descuento = :descuento, Descripcion_producto = :descripcion, Ruta_imagen_producto = :rutaImagen, Cantidad = :cantidad, Id_categoria = :categoria WHERE Id_producto = :id");
            
            if ($stmt->execute([
                ':nombre' => $nombre,
                ':precio' => $precio,
                ':descuento' => $descuento,
                ':descripcion' => $descripcion,
                ':cantidad' => $cantidad,
                ':categoria' => $categoria,
                ':id' => $id
            ])) {

                $this->addImagenes($imagenes,$id);
            
                $conexion->commit();
                return true;
            } else {
                throw new Exception("Error en la actualización: " . $stmt->error);
            }
        
        } catch (Exception $e) {
            
            $conexion->rollback();
            echo "Transacción fallida: " . $e->getMessage();
        }
    }

    public function getProductos(){
        
            $conexion=ConexionBD::getInstance();
            
            $stmt = $conexion->query ("SELECT prod.Id_producto, prod.Nombre, prod.Descripcion_producto, prod.Cantidad, prod.Precio_actual, prod.Descuento, cat.Nombre_categoria AS categoria 
            FROM productos prod
            JOIN categorias cat ON prod.Id_categoria = cat.Id_categoria;");

            $productos = array();

             while ( $producto = $stmt->fetch() ){
                $productos[] = $producto;
            }
            
                return $productos;
        }
    
    public function verProducto($idProducto){}

}


class Categoria{
    private $id;
    private $nombre;
    private $descripcion;

    private $rutaImagenCategoria;
    
    public function __construct(){}

    public function addCategoria($nombre, $descripcion,$rutaImagen,$idAdmin){
        try{
            $conexion=ConexionBD::getInstance();

            $conexion -> beginTransaction();

            $sql = "INSERT INTO categorias (Nombre_categoria,Descripcion_categoria, Ruta_imagen_categoria, Id_admin) VALUES (:Nombre_categoria, :Descripcion_categoria, :Ruta_imagen_categoria, :Id_admin)";
            
            $stmt = $conexion->prepare($sql);

            $stmt->execute([
                ':Nombre_categoria' => $nombre,
                ':Descripcion_categoria'=> $descripcion,
                ':Ruta_imagen_categoria'=> $rutaImagen,
                ':Id_admin' => $idAdmin,
            ]);

            $conexion-> commit();
            return true;
        } catch(Exception $e){
            $conexion->rollBack();

            echo "Error: ". $e -> getMessage();
        }
    }
    public function removeCategoria($idCategoria){
        $conexion=ConexionBD::getInstance();

            $stmt = $conexion->prepare("DELETE FROM categorias WHERE Id_categoria = :id");
            return $stmt->execute([':id' => $idCategoria ]);

    }
    public function updateCategoria($nombre,$descripcion,$rutaImagen,$id){
        try {
            $conexion=ConexionBD::getInstance();
            $conexion -> beginTransaction();

            $stmt = $conexion->prepare("UPDATE categorias SET Nombre_categoria = :nombre, Descripcion_categoria = :descripcion, Ruta_imagen_categoria = :rutaImagen WHERE Id_categoria = :id");
            
            if ($stmt->execute([
                ':nombre' => $nombre,
                ':descripcion' => $descripcion,
                ':rutaImagen' => $rutaImagen,
                ':id' => $id
            ])) {
            
                $conexion->commit();
                return true;
            } else {
                throw new Exception("Error en la actualización: " . $stmt->error);
            }
        
        } catch (Exception $e) {
            
            $conexion->rollback();
            echo "Transacción fallida: " . $e->getMessage();
        }
    }

    public function obtenerCategoria($nombre){
        $conexion=ConexionBD::getInstance();

        $sql = "SELECT * FROM categorias WHERE Nombre_categoria = :Nombre_categoria";
        $stmt = $conexion ->prepare($sql);
     
               
      $stmt->execute([':Nombre_categoria' => $nombre]);
     
      
      $categoria = $stmt->fetch(PDO::FETCH_ASSOC);

      return $categoria;
    }

    public function getCategorias(){
        
        $conexion=ConexionBD::getInstance();
            
        $stmt = $conexion->query ("SELECT Id_categoria, Nombre_categoria, Descripcion_categoria, Ruta_imagen_categoria
        FROM categorias");

        $categorias = array();

         while ( $categoria = $stmt->fetch() ){
            $categorias[] = $categoria;
        }
        
            return $categorias;
    }   
    }




?>