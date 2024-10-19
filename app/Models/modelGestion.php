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
    
    public function __construct($id=null){

        if($id!=null){
            $productoMom= $this->getProducto($id);
            $this->id=$productoMom['Id_producto'];
            $this->nombre=$productoMom['Nombre'];
            $this->descripcion=$productoMom['Descripcion_producto'];
            $this->precio=$productoMom['Precio_actual'];
            $this->descuento=$productoMom['Descuento'];
            $this->categoria=$productoMom['Id_categoria'];
            $this->cantidad=$productoMom['Cantidad'];
        }
    }

    //Getters y setters

    public function getId(){
        return $this->id;
    }
    public function setId($id){
        $this->id=$id;
    }

    public function getNombre(){
        return $this->nombre;
    }

    public function setNombre($nombre){
        $this->nombre=$nombre;
    }

    public function getDescripcion(){
        return $this->descripcion;
    }
    public function setDescripcion($descripcion){
        $this->descripcion=$descripcion;
    }

    public function getPrecio(){
        return $this->precio;
    }

    public function setPrecio($precio){
        $this->precio=$precio;
    }

    public function getDescuento(){
        return $this->descuento;
    }

    public function setDescuento($descuento){
        $this->descuento=$descuento;
    }

    public function getCategoria(){
        return $this->categoria;
    }

    public function setCategoria($categoria){
        $this->categoria=$categoria;
    }

    public function getCantidad(){
        return $this->cantidad;
    }
    public function setCantidad($cantidad){
        $this->cantidad=$cantidad;
    }


    //Funciones de BBDD
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
    
    private function updateImagenes($imagenes, $idProducto) {

        $conexion = ConexionBD::getInstance();

        if (empty($imagenes) || empty($idProducto)) {
            return false;
        }

        $resultadoIdImagenes= $this->selectImagenes($idProducto);
       

        $sql = "UPDATE imagen_producto SET Ruta_imagen_producto = :Ruta_imagen_producto WHERE Id_imagen = :Id_imagen";
        $stmt = $conexion->prepare($sql);
    
        $limite= count($resultadoIdImagenes);
        $iteraciones=0;

        foreach ($imagenes as $rutaImagen) {
            
            if($iteraciones==($limite)){
                return false;
            }
            if (!$stmt->execute([':Id_imagen' => $resultadoIdImagenes[$iteraciones]['Id_imagen'], ':Ruta_imagen_producto' => $rutaImagen])) {
                return false; 
            }
            $iteraciones++;
        }
    
        return true; 
    }

    public function selectImagenes($idProducto){
        if (empty($idProducto)) {
            return false;
        }
        $conexion = ConexionBD::getInstance();

        $sqlSelect = "SELECT Id_imagen, Ruta_imagen_producto FROM imagen_producto WHERE Id_producto = :id";
        $stmtSelect = $conexion->prepare($sqlSelect);

        $stmtSelect->execute([':id'=>$idProducto]);

        return $stmtSelect->fetchAll();
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
        try {
        $conexion=ConexionBD::getInstance();

            $conexion -> beginTransaction();
        
            //Borrar imagenes relacionadas con el id
            $stmtImagenes = $conexion->prepare("DELETE FROM imagen_producto WHERE Id_producto = :id");
            $stmtImagenes->execute([':id' => $idProducto ]);

            //Borrar producto relacionado con el id
            $stmtProducto = $conexion->prepare("DELETE FROM productos WHERE Id_producto = :id");
            $stmtProducto->execute([':id' => $idProducto ]);


            $conexion->commit();
            return true;
        } catch (Exception $e) {
            
            $conexion->rollback();
            echo "Transacción fallida: " . $e->getMessage();
        }
    }
    public function updateProducto($id,$nombre,$descripcion,$precio,$descuento, $categoria, $cantidad, $imagenes){
        
        try {
            $conexion=ConexionBD::getInstance();
            $conexion -> beginTransaction();

            $stmt = $conexion->prepare("UPDATE productos SET Nombre = :nombre, Precio_actual = :precio, Descuento = :descuento, Descripcion_producto = :descripcion, Cantidad = :cantidad, Id_categoria = :categoria WHERE Id_producto = :id");
            
            if ($stmt->execute([
                ':nombre' => $nombre,
                ':precio' => $precio,
                ':descuento' => $descuento,
                ':descripcion' => $descripcion,
                ':cantidad' => $cantidad,
                ':categoria' => $categoria,
                ':id' => $id
            ])) {

              
            if (!$this->updateImagenes($imagenes, $id)) {
                throw new Exception("Error al agregar imagenes, asegurese que el numero de imagenes sea igual al numero de imagenes anterior");
            }
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
            
            $stmt = $conexion->query ("SELECT prod.Id_producto, prod.Nombre, prod.Descripcion_producto, prod.Cantidad, prod.Precio_actual, prod.Descuento, GROUP_CONCAT(img.Ruta_imagen_producto) AS imagenes,
            cat.Nombre_categoria AS categoria
            FROM productos AS prod
            JOIN categorias AS cat ON prod.Id_categoria = cat.Id_categoria
            JOIN imagen_producto AS img ON prod.Id_producto = img.Id_producto GROUP BY prod.Id_producto;");

            $productos = array();

             while ( $producto = $stmt->fetch() ){

                $producto['imagenes'] = explode(',', $producto['imagenes']);

                //Para eliminar el string del cual se hizo el explode para generar el array de imagenes
                unset($producto[6]);


                $productos[] = $producto;
            }
                return $productos;
        }
    
        public function getProducto($idProducto){
            $conexion = ConexionBD::getInstance();
        
            $stmt = $conexion->prepare("SELECT Id_producto, Nombre, Descripcion_producto, Cantidad, Precio_actual, Descuento, Id_categoria FROM productos WHERE Id_producto = :id");
    
            if ($stmt->execute([':id' => $idProducto])) {
                return $stmt->fetch();
            }
            
            return false; 
        }

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