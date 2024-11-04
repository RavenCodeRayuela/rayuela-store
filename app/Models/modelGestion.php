<?php
require_once "config/conexionBD.php";
require_once "modelAdministrador.php";

/**
 * Clase producto contiene lo referente a los productos y las funciónes necesarias
 * para realizar el CRUD de productos
 */
class Producto{

    private $id;
    private $nombre;
    private $descripcion;
    private $precio;
    private $descuento;
    private $categoria;
    private $cantidad;

    private array $imagenes;
    /**
     * El constructor puede recibir el id o ser vacio, dependiendo del uso necesario.
     * en caso de tener el id busca en la base de datos los datos correspondientes a dicho id
     * y los aplica al objeto
     * @param mixed $id
     */
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

            $imagenesMom=$this->selectImagenes($id);

            foreach ($imagenesMom as $imagen) {
                $this->imagenes[]= $imagen['Ruta_imagen_producto'];
            }
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
    //Modificar getPrecio para incluir descuento 
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

    public function getTotalDeImagenes(){
        return count($this->imagenes);
    }

    public function getImagenes(){
        return $this->imagenes;
    }

    //public function getImagen($)

    //Funciones de BBDD

    /**
     * Permite añadir imagenes a un producto utiliza el id para vincular las tablas.
     * En caso de exito retorna true de lo contrario false
     * @param mixed $imagenes
     * @param mixed $idProducto
     * @return bool
     */
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
    
    /**
     * Modifica las imagenes existentes, mediante el id.
     * En caso de exito modifica las imagenes y retorna true
     * @param mixed $imagenes
     * @param mixed $idProducto
     * @return bool
     */
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

    /**
     * Busca mediante un id en la BBDD y retorna un arreglo con
     * las filas correspondientes a esa id de producto.
     * @param mixed $idProducto
     * @return array|bool
     */
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
    /**
     * Agrega productos a la base de datos, recibe todos los parametros ya saneados
     * del controller y los inserta en la BD, utiliza transacciones para asegurarse
     * de la integridad de la información, haciendo un roll-back en caso de error
     * retorna true en caso de exito tira una excepcion en caso de fallo
     * @param mixed $nombre
     * @param mixed $descripcion
     * @param mixed $precio
     * @param mixed $descuento
     * @param mixed $categoria
     * @param mixed $cantidad
     * @param mixed $imagenes
     * @param mixed $idAdmin
     * @throws \Exception
     * @return bool
     */
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

    /**
     * Remueve un producto buscando por su id.
     * Retorna true en caso de exito, caso contrario tira una excepción
     * @param mixed $idProducto
     * @return bool
     */
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
    /**
     * Realiza una modificacion en la BD en las tablas de imagenes y productos
     * utiliza el id para distinguir entre los productos.
     * @param mixed $id
     * @param mixed $nombre
     * @param mixed $descripcion
     * @param mixed $precio
     * @param mixed $descuento
     * @param mixed $categoria
     * @param mixed $cantidad
     * @param mixed $imagenes
     * @throws \Exception
     * @return bool
     */
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

    /**
     * Obtiene y retorna un array asociativo con los productos almacenados en la BD
     * Obtiene datos de varias tablas(productos, categoria e imagen_producto), las imagenes y sus ids las 
     * almacena en un array interno con la clave asociativa 'imagenes'
     * @return array
     */
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
        /**
         * Obtiene un producto especifico de la BD mediante su id
         * @param mixed $idProducto
         * @return mixed
         */
        public function getProducto($idProducto){
            $conexion = ConexionBD::getInstance();
        
            $stmt = $conexion->prepare("SELECT Id_producto, Nombre, Descripcion_producto, Cantidad, Precio_actual, Descuento, Id_categoria FROM productos WHERE Id_producto = :id");
    
            if ($stmt->execute([':id' => $idProducto])) {
                return $stmt->fetch();
            }
            
            return false; 
        }

        /**
         * Obtiene los productos de la base de datos para poder paginarlos,
         * recibe como parametros la pagina actual, la cantidad de elementos a mostrar por pagina(que puede ser null)
         * Utiliza el limit y el offset para obtener datos de la BD.
         * @param mixed $paginaActual
         * @param mixed $elementosPorPagina
         * @return array
         */
        public function getProductosPaginados($paginaActual, $elementosPorPagina = 10) {
            $conexion = ConexionBD::getInstance();
        
        
            $offset = ($paginaActual - 1) * $elementosPorPagina;
        
            $stmt = $conexion->prepare("
                SELECT prod.Id_producto, prod.Nombre, prod.Descripcion_producto, prod.Cantidad, prod.Precio_actual, prod.Descuento, GROUP_CONCAT(img.Ruta_imagen_producto) AS imagenes, cat.Nombre_categoria AS categoria
                FROM productos AS prod
                JOIN categorias AS cat ON prod.Id_categoria = cat.Id_categoria
                JOIN imagen_producto AS img ON prod.Id_producto = img.Id_producto 
                GROUP BY prod.Id_producto
                 LIMIT :limit OFFSET :offset
                ");

               
                $stmt->bindParam(':limit', $elementosPorPagina, PDO::PARAM_INT);
                $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);

        
    
            $stmt->execute();
        
            $productos = array();
        
            while ($producto = $stmt->fetch()) {
                $producto['imagenes'] = explode(',', $producto['imagenes']);
                // Para eliminar el string del cual se hizo el explode
                unset($producto[6]);
                $productos[] = $producto;
            }
        
            return $productos;
        }
        /**
         * Obtiene los productos de una categoria de la base de datos para poder paginarlos,
         * recibe como parametros la pagina actual, la cantidad de elementos a mostrar por pagina(que puede ser null),
         * y la categoria por la cual filtrara.
         * Utiliza el limit y el offset para obtener datos de la BD, tambien  
         * @param mixed $paginaActual
         * @param mixed $elementosPorPagina
         * @param mixed $idCategoria
         * @return array
         */
        public function getProductosPaginadosPorCategoria($paginaActual, $elementosPorPagina = 10, $idCategoria) {
            $conexion = ConexionBD::getInstance();
        
            $offset = ($paginaActual - 1) * $elementosPorPagina;
        
            $stmt = $conexion->prepare("
                SELECT prod.Id_producto, prod.Nombre, prod.Descripcion_producto, prod.Cantidad, prod.Precio_actual, prod.Descuento, GROUP_CONCAT(img.Ruta_imagen_producto) AS imagenes, cat.Nombre_categoria AS categoria
                FROM productos AS prod
                JOIN categorias AS cat ON prod.Id_categoria = cat.Id_categoria
                JOIN imagen_producto AS img ON prod.Id_producto = img.Id_producto 
                WHERE prod.Id_categoria = :idCategoria
                GROUP BY prod.Id_producto
                LIMIT :limit OFFSET :offset
            ");
        
            $stmt->bindParam(':idCategoria', $idCategoria, PDO::PARAM_INT);
            $stmt->bindParam(':limit', $elementosPorPagina, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        
            $stmt->execute();
        
            $productos = array();
        
            while ($producto = $stmt->fetch()) {
                $producto['imagenes'] = explode(',', $producto['imagenes']);
                unset($producto[6]);
                $productos[] = $producto;
            }
        
            return $productos;
        }
        /**
         * Cuenta el total de productos en la BBDD
         * @return mixed
         */
        public function contarTotalProductos() {
            $conexion = ConexionBD::getInstance();
            $stmt = $conexion->query("SELECT COUNT(*) as total FROM productos");
            $total = $stmt->fetch()['total'];
            return $total;
        }
        /**
         * Cuenta el total de productos por categoría en la BD
         * @param mixed $idCategoria
         * @return mixed
         */
        public function contarTotalProductosPorCategoria($idCategoria){
            $conexion = ConexionBD::getInstance();
            $stmt = $conexion->prepare("SELECT COUNT(*) as total FROM productos WHERE Id_categoria = :Id_categoria");
            

            
            if ($stmt->execute([':Id_categoria' => $idCategoria])) {
                $total = $stmt->fetch()['total']; 
                return $total;
            }else{
                return false;
            }
           
        }

}

/**
 * Contiene lo referente a las categorias de los productos
 */
class Categoria{
    private $id;
    private $nombre;
    private $descripcion;

    private $rutaImagenCategoria;
    
    /**
     * El constructor admite el parametro id o ningun parametro,
     * en caso de tener el id busca en la BD para aplicar los datos al objeto. 
     * @param mixed $id
     */
    public function __construct($id=null){
        
        if($id!=null){
            $categoriaMom= $this->getCategoria($id);
            
            $this->id=$categoriaMom['Id_categoria'];
            $this->nombre=$categoriaMom['Nombre_categoria'];
            $this->descripcion=$categoriaMom['Descripcion_categoria'];
            $this->rutaImagenCategoria=$categoriaMom['Ruta_imagen_categoria'];
            
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

    public function getRutaImagenCategoria(){
        return $this->rutaImagenCategoria;
    }

    public function setRutaImagenCategoria($rutaImagenCategoria){
        $this->rutaImagenCategoria=$rutaImagenCategoria;
    }


    /**
     * Agrega una categoria a la BD, recibe del controlador parametros saneados
     * y mediante un insert persiste los datos.
     * @param mixed $nombre
     * @param mixed $descripcion
     * @param mixed $rutaImagen
     * @param mixed $idAdmin
     * @return bool
     */
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
    /**
     * Elimina una categoria seleccionada, recibe el id de la categoria como parametro.
     * @param mixed $idCategoria
     * @return bool
     */
    public function removeCategoria($idCategoria){
        $conexion=ConexionBD::getInstance();

            $stmt = $conexion->prepare("DELETE FROM categorias WHERE Id_categoria = :id");
            return $stmt->execute([':id' => $idCategoria ]);

    }
    /**
     * Actualiza una categoría, buscando por id que se inserta como parametro en la funcion.
     * @param mixed $nombre
     * @param mixed $descripcion
     * @param mixed $rutaImagen
     * @param mixed $id
     * @throws \Exception
     * @return bool
     */
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
    /**
     * Obtiene la categoría por id o por nombre, en caso de no pasar
     * ninguno de los dos por parametro, retorna falso.
     * En caso de exito retorna la fila correspondiente a la categoría
     * @param mixed $id
     * @param mixed $nombre
     * @return mixed
     */
    public function getCategoria($id=null,$nombre=null){
        
        $conexion=ConexionBD::getInstance();

        if($id == null){        
            $sql = "SELECT * FROM categorias WHERE Nombre_categoria = :Nombre_categoria";
            $stmt = $conexion ->prepare($sql);
        
                
            $stmt->execute([':Nombre_categoria' => $nombre]);
        
        
            $categoria = $stmt->fetch(PDO::FETCH_ASSOC);

            return $categoria;
        }
        
        if($nombre == null){
            $sql = "SELECT * FROM categorias WHERE Id_categoria = :Id_categoria";
            $stmt = $conexion ->prepare($sql);
        
                
            $stmt->execute([':Id_categoria' => $id]);
        
        
            $categoria = $stmt->fetch(PDO::FETCH_ASSOC);

            return $categoria;
        }

        if(($id && $nombre) == null){
            return false;
        }
    }

    /**
     * Obtiene todas las categorias de la base de datos.
     * @return array
     */
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
    /**
     * Cuenta el total de las categorias en la BD
     * @return mixed
     */
    public function contarTotalCategorias() {
        $conexion = ConexionBD::getInstance();
        $stmt = $conexion->query("SELECT COUNT(*) as total FROM categorias");
        $total = $stmt->fetch()['total'];
        return $total;
    }

    /**
     * Obtiene las categorias con formato para paginar,
     * recibe la pagina actual y los elementos por pagina como parametros
     * En caso de exito retorna un array con las categorias
     * @param mixed $paginaActual
     * @param mixed $elementosPorPagina
     * @return array
     */
    public function getCategoriasPaginadas($paginaActual, $elementosPorPagina = 10) {
        
        $conexion = ConexionBD::getInstance();
    
        $offset = ($paginaActual - 1) * $elementosPorPagina;
    
         $stmt = $conexion->prepare ("SELECT Id_categoria, Nombre_categoria, Descripcion_categoria, Ruta_imagen_categoria FROM categorias LIMIT :limit OFFSET :offset");

           
            $stmt->bindParam(':limit', $elementosPorPagina, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);

    

        $stmt->execute();
    
        $categorias = array();

        while ( $categoria = $stmt->fetch() ){
           $categorias[] = $categoria;
       }
       
           return $categorias;
    }

    }




?>