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

    public function addProducto($nombre,$descripcion,$precio,$descuento, $categoria, $cantidad, $rutaImagen, $idAdmin){
        try{
            $conexion=ConexionBD::getInstance();
            $conexion -> beginTransaction();

            $sql = "INSERT INTO productos (Nombre, Precio_actual, Descuento, Descripcion_producto, Ruta_imagen_producto, Cantidad, Id_admin, Id_categoria) VALUES (:Nombre, :Precio_actual, :Descuento, :Descripcion_producto, :Ruta_imagen_producto, :Cantidad, :Id_admin, :Id_categoria)";
            
            $stmt = $conexion->prepare($sql);

            $stmt->execute([
                ':Nombre' => $nombre,
                ':Precio_actual' => $precio,
                ':Descuento'=> $descuento,
                ':Descripcion_producto'=> $descripcion,
                ':Ruta_imagen_producto'=> $rutaImagen,
                ':Cantidad' => $cantidad,
                ':Id_admin' => $idAdmin,
                ':Id_categoria' => $categoria
            ]);

            $conexion-> commit();
            return true;
        } catch(Exception $e){
            $conexion->rollBack();

            echo "Error: ". $e -> getMessage();
        }
    }

    
    public function removeProducto($idProducto){}
    public function updateProducto($id,$nombre,$descripcion,$precio,$descuento, $categoria, $cantidad, $rutaImagen){
        
        try {
            $conexion=ConexionBD::getInstance();

            $stmt = $conexion->prepare("UPDATE productos SET Nombre = $nombre, Precio_actual = $precio, Descuento = $descuento, Descripcion_producto = $descripcion, Ruta_imagen_producto = $rutaImagen, Cantidad = $cantidad, Id_categoria = $categoria  WHERE id = $id");
        
            if ($stmt->execute()) {
            
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
            
            $stmt = $conexion->query ("SELECT prod.Id_producto, prod.Nombre, prod.Descripcion_producto, prod.Cantidad, prod.Precio_actual, prod.Descuento, prod.Ruta_imagen_producto, cat.Nombre_categoria AS categoria 
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
    public function removeCategoria(){}
    public function updateCategoria(){}

    public function obtenerCategoria($nombre){
        $conexion=ConexionBD::getInstance();

        $sql = "SELECT * FROM categorias WHERE Nombre_categoria = :Nombre_categoria";
        $stmt = $conexion ->prepare($sql);
     
        // Ejecutar la consulta SQL, pasando el nombre de usuario como parámetro        
      $stmt->execute([':Nombre_categoria' => $nombre]);
     
      // Obtener la fila del usuario de la base de datos
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