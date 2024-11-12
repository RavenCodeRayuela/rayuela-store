<?php
require_once 'modelCliente.php';



class Compra{

    
    private $idCompra;
    private $fecha;
    private $costoTotal;
    private $valoracion;
    private $estado;
    private $tipoDePago;
    private $idDireccion;
    private array $detalleArticulos;

    public function __construct(){

    }

    //Getters y setters

    public function getIdCompra(){
        return $this->idCompra;
    }
    public function setIdCompra($idCompra){
        $this->idCompra = $idCompra;
    }
    public function getFecha(){
        return $this->fecha;
    }
    public function setFecha($fecha){
        $this->fecha = $fecha;
    }
    public function getCostoTotal(){
        return $this->costoTotal;
    }
    public function setCostoTotal($costoTotal){
        $this->costoTotal = $costoTotal;
    }
    public function getValoracion(){
        return $this->valoracion;
    }
    public function setValoracion($valoracion){
        $this->valoracion = $valoracion;
    }
    public function getTipoDePago(){
        return $this->tipoDePago;
    }
    public function setTipoDePago($tipoDePago){
        $this->tipoDePago = $tipoDePago;
    }
    public function getIdDireccion(){
        return $this->idDireccion;
    }
    public function setIdDireccion($idDireccion){
        $this->idDireccion = $idDireccion;
    }

    private function getDetalleArticulos(){
        return $this->detalleArticulos;
    }
    private function setDetalleArticulos($detalleArticulos){
        $this->detalleArticulos[] = $detalleArticulos;
    }

    //Funciones de base de datos

    public function addCompra($idCliente,$fecha,$costoTotal,$estado,$tipoDePago,$idDireccion){
        try{
            $conexion=ConexionBD::getInstance();
            $conexion -> beginTransaction();

            $sql = "INSERT INTO compras (Id_cliente, Fecha, Costo_total, Estado, Tipo_de_pago, Id_direccion) VALUES (:Id_cliente, :Fecha, :Costo_total, :Estado, :Tipo_de_pago, :Id_direccion)";
            
            $stmt = $conexion->prepare($sql);

            $stmt->execute([
                ':Id_cliente' => $idCliente,
                ':Fecha' => $fecha,
                ':Costo_total'=> $costoTotal,
                ':Estado' => $estado,
                ':Tipo_de_pago' => $tipoDePago,
                ':Id_direccion' => $idDireccion
            ]);

            $idCompra= (int) $conexion->lastInsertId();

            $conexion-> commit();
            return $idCompra;
        } catch(Exception $e){
            $conexion->rollBack();

            echo "Error: ". $e -> getMessage();
            return false;
        }
    }

    public function updateCompra($idCompra,$estado=null,$idDireccion=null,$valoracion=null, $comprobante =null){
        try {
            $conexion=ConexionBD::getInstance();
            $conexion -> beginTransaction();
            
            if($estado!= null && $idDireccion==null && $valoracion==null && $comprobante == null){

                $stmt = $conexion->prepare("UPDATE compras SET Estado = :Estado WHERE Id_compra = :id");
               
                    if ($stmt->execute([':Estado' => $estado, ':id' => $idCompra])){
                        $conexion->commit();
                        return true;
                    } else {
                        throw new Exception("Error en la actualización: " . implode(", ", $stmt->errorInfo()));
                    }
            }elseif($estado== null && $idDireccion!=null && $valoracion==null && $comprobante == null){

                $stmt = $conexion->prepare("UPDATE compras SET Id_direccion = :Id_direccion WHERE Id_compra = :id");

                if ($stmt->execute([':Id_direccion' => $idDireccion, ':id' => $idCompra])){
                    $conexion->commit();
                    return true;
                } else {
                    throw new Exception("Error en la actualización: " . implode(", ", $stmt->errorInfo()));
                }
            }elseif($estado== null && $idDireccion==null && $valoracion!=null && $comprobante == null){
                $stmt = $conexion->prepare("UPDATE compras SET Valoracion = :Valoracion WHERE Id_compra = :id");

                if ($stmt->execute([':Valoracion' => $valoracion, ':id' => $idCompra])){
                    $conexion->commit();
                    return true;
                } else {
                    throw new Exception("Error en la actualización: " . implode(", ", $stmt->errorInfo()));
                }
            
            }elseif($estado== null && $idDireccion==null && $valoracion==null && $comprobante != null){
                $stmt = $conexion->prepare("UPDATE compras SET Comprobante = :Comprobante WHERE Id_compra = :id");

                if ($stmt->execute([':Comprobante' => $comprobante, ':id' => $idCompra])){
                    $conexion->commit();
                    return true;
                } else {
                    throw new Exception("Error en la actualización: " . implode(", ", $stmt->errorInfo()));
                }
            }
        } catch (Exception $e) {
            
            $conexion->rollback();
            echo "Transacción fallida: " . $e->getMessage();
            return false;
        }
    }

    public function removeCompra($idCompra){
        try {
            $conexion=ConexionBD::getInstance();
    
                $conexion -> beginTransaction();
            
                //Borrar el detalle de compra relacionadas con el id de la compra
                $stmtDetalleCompra = $conexion->prepare("DELETE FROM compra_contiene_producto WHERE Id_compra = :id");
                $stmtDetalleCompra->execute([':id' => $idCompra ]);
    
                //Borrar la compra relacionado con el id
                $stmtCompra = $conexion->prepare("DELETE FROM compras WHERE Id_compra = :id");
                $stmtCompra->execute([':id' => $idCompra ]);
    
    
                $conexion->commit();
                return true;
            } catch (Exception $e) {
                
                $conexion->rollback();
                echo "Transacción fallida: " . $e->getMessage();
                return false;
            }
    }
    
    public function getCompra($idCompra) {
        $conexion = ConexionBD::getInstance();
    
        // Consulta para obtener los detalles generales de la compra
        $stmtCompra = $conexion->prepare("
            SELECT com.Id_compra, com.Id_cliente, com.Fecha, com.Costo_total AS total, com.Valoracion, com.Estado, com.Tipo_de_pago,
                   dir.Ciudad, dir.Calle, dir.NroCasa, dir.Comentario, us.Nombre AS cliente_nombre, us.Email AS cliente_email
            FROM compras AS com
            JOIN direcciones_de_envio AS dir ON com.Id_direccion = dir.Id_direccion
            JOIN usuarios AS us ON com.Id_cliente = us.Id_usuario
            WHERE com.Id_compra = :idCompra
        ");
        
        $stmtCompra->bindParam(':idCompra', $idCompra, PDO::PARAM_INT);
        $stmtCompra->execute();
        
        // Obtener detalles generales de la compra
        $compra = $stmtCompra->fetch(PDO::FETCH_ASSOC);
        if (!$compra) {
            return null;  // Si no se encuentra la compra, retorna null
        }
    
        // Consulta para obtener los productos asociados a la compra
        $stmtProductos = $conexion->prepare("
            SELECT prod.Nombre AS productoNombre, det.Cantidad_producto, det.Precio_por_producto AS precio, det.Id_producto
            FROM compra_contiene_producto AS det
            JOIN productos AS prod ON det.Id_producto = prod.Id_producto
            WHERE det.Id_compra = :idCompra
        ");
    
        $stmtProductos->bindParam(':idCompra', $idCompra, PDO::PARAM_INT);
        $stmtProductos->execute();
        
        // Obtener los productos y agregarlos al array de compra
        $compra['productos'] = $stmtProductos->fetchAll(PDO::FETCH_ASSOC);
    
        return $compra;
    }

    public function getComprasPaginadas($paginaActual, $elementosPorPagina) {
        $conexion = ConexionBD::getInstance();
        
        // Calcula el offset para la paginación
        $offset = ($paginaActual - 1) * $elementosPorPagina;
    
        // Primera consulta: obtener detalles generales de cada compra
        $stmtCompras = $conexion->prepare("
            SELECT com.Id_compra, com.Id_cliente, com.Fecha, com.Costo_total AS total, com.Valoracion, com.Estado, com.Tipo_de_pago,
                   dir.Ciudad, dir.Calle, dir.NroCasa, dir.Comentario, us.Nombre AS clienteNombre, us.Email AS clienteEmail
            FROM compras AS com
            JOIN direcciones_de_envio AS dir ON com.Id_direccion = dir.Id_direccion
            JOIN usuarios AS us ON com.Id_cliente = us.Id_usuario
            ORDER BY com.Id_compra
            LIMIT :limit OFFSET :offset;
        ");
        
        $stmtCompras->bindParam(':limit', $elementosPorPagina, PDO::PARAM_INT);
        $stmtCompras->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmtCompras->execute();
        
        // Obtener resultados y preparar para unir con productos
        $compras = $stmtCompras->fetchAll(PDO::FETCH_ASSOC);
        if (!$compras) {
            return [];
        }
        
        // Obtener los IDs de compra para buscar productos especificos de cada compra
        $compraIds = array_column($compras, 'Id_compra');
        $placeholders = implode(',', array_fill(0, count($compraIds), '?'));
    
        // Segunda consulta: obtener los productos de cada compra
        $stmtProductos = $conexion->prepare("
            SELECT det.Id_compra, det.Id_producto, prod.Nombre AS producto_nombre, det.Cantidad_producto, det.Precio_por_producto AS precio
            FROM compra_contiene_producto AS det
            JOIN productos AS prod ON det.Id_producto = prod.Id_producto
            WHERE det.Id_compra IN ($placeholders);
        ");
    
        foreach ($compraIds as $k => $id) {
            $stmtProductos->bindValue($k + 1, $id, PDO::PARAM_INT);
        }
        
        $stmtProductos->execute();
        $productos = $stmtProductos->fetchAll(PDO::FETCH_ASSOC);
    
        // Agrupar productos dentro de sus compras respectivas
        $comprasDetalle = [];
        foreach ($compras as $compra) {
            $comprasDetalle[$compra['Id_compra']] = $compra;
            $comprasDetalle[$compra['Id_compra']]['productos'] = [];
        }
    
        foreach ($productos as $producto) {
            $comprasDetalle[$producto['Id_compra']]['productos'][] = [
                'Nombre' => $producto['producto_nombre'],
                'Cantidad' => $producto['Cantidad_producto'],
                'Precio' => $producto['precio'],
                'IdProducto'=>$producto['Id_producto']
            ];
        }
        
        // Convertir el array asociativo en un array numerico para devolver
        return array_values($comprasDetalle);
    }

    public function getComprasPaginadasPreparandose($paginaActual, $elementosPorPagina) {
        $conexion = ConexionBD::getInstance();
        
        // Calcula el offset para la paginación
        $offset = ($paginaActual - 1) * $elementosPorPagina;
    
        // Primera consulta: obtener detalles generales de cada compra con estado "Preparandose"
        $stmtCompras = $conexion->prepare("
            SELECT com.Id_compra, com.Id_cliente, com.Fecha, com.Costo_total AS total, com.Valoracion, com.Estado, com.Tipo_de_pago,
                   dir.Ciudad, dir.Calle, dir.NroCasa, dir.Comentario, us.Nombre AS clienteNombre, us.Email AS clienteEmail
            FROM compras AS com
            JOIN direcciones_de_envio AS dir ON com.Id_direccion = dir.Id_direccion
            JOIN usuarios AS us ON com.Id_cliente = us.Id_usuario
            WHERE com.Estado = 'Preparandose'
            ORDER BY com.Id_compra
            LIMIT :limit OFFSET :offset;
        ");
        
        $stmtCompras->bindParam(':limit', $elementosPorPagina, PDO::PARAM_INT);
        $stmtCompras->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmtCompras->execute();
        
        // Obtener resultados y preparar para unir con productos
        $compras = $stmtCompras->fetchAll(PDO::FETCH_ASSOC);
        if (!$compras) {
            return [];
        }
        
        // Obtener los IDs de compra para buscar productos específicos de cada compra
        $compraIds = array_column($compras, 'Id_compra');
        $placeholders = implode(',', array_fill(0, count($compraIds), '?'));
    
        // Segunda consulta: obtener los productos de cada compra
        $stmtProductos = $conexion->prepare("
            SELECT det.Id_compra, det.Id_producto, prod.Nombre AS producto_nombre, det.Cantidad_producto, det.Precio_por_producto AS precio
            FROM compra_contiene_producto AS det
            JOIN productos AS prod ON det.Id_producto = prod.Id_producto
            WHERE det.Id_compra IN ($placeholders);
        ");
    
        foreach ($compraIds as $k => $id) {
            $stmtProductos->bindValue($k + 1, $id, PDO::PARAM_INT);
        }
        
        $stmtProductos->execute();
        $productos = $stmtProductos->fetchAll(PDO::FETCH_ASSOC);
    
        // Agrupar productos dentro de sus compras respectivas
        $comprasDetalle = [];
        foreach ($compras as $compra) {
            $comprasDetalle[$compra['Id_compra']] = $compra;
            $comprasDetalle[$compra['Id_compra']]['productos'] = [];
        }
    
        foreach ($productos as $producto) {
            $comprasDetalle[$producto['Id_compra']]['productos'][] = [
                'Nombre' => $producto['producto_nombre'],
                'Cantidad' => $producto['Cantidad_producto'],
                'Precio' => $producto['precio'],
                'IdProducto' => $producto['Id_producto']
            ];
        }
        
        // Convertir el array asociativo en un array numerico para devolver
        return array_values($comprasDetalle);
    }
    
        public function getComprasDeClientePaginadas($idCliente, $paginaActual, $elementosPorPagina) {
            $conexion = ConexionBD::getInstance();
            
            // Calcula el offset para la paginación
            $offset = ($paginaActual - 1) * $elementosPorPagina;
        
            // Primera consulta: obtener detalles generales de cada compra
            $stmtCompras = $conexion->prepare("
                SELECT com.Id_compra, com.Id_cliente, com.Fecha, com.Costo_total AS total, com.Valoracion, com.Estado, com.Tipo_de_pago,com.Comprobante,
                       dir.Ciudad, dir.Calle, dir.NroCasa, dir.Comentario
                FROM compras AS com
                JOIN direcciones_de_envio AS dir ON com.Id_direccion = dir.Id_direccion
                WHERE com.Id_cliente = :idCliente
                ORDER BY com.Id_compra
                LIMIT :limit OFFSET :offset;
            ");
            
            $stmtCompras->bindParam(':idCliente', $idCliente, PDO::PARAM_INT);
            $stmtCompras->bindParam(':limit', $elementosPorPagina, PDO::PARAM_INT);
            $stmtCompras->bindParam(':offset', $offset, PDO::PARAM_INT);
            $stmtCompras->execute();
            
            // Obtener resultados y preparar para unir con productos
            $compras = $stmtCompras->fetchAll(PDO::FETCH_ASSOC);
            if (!$compras) {
                return [];
            }
            
            // Obtener los IDs de compra para buscar productos especificos de cada compra
            $compraIds = array_column($compras, 'Id_compra');
            $placeholders = implode(',', array_fill(0, count($compraIds), '?'));
        
            // Segunda consulta: obtener los productos de cada compra
            $stmtProductos = $conexion->prepare("
                SELECT det.Id_compra, prod.Nombre AS producto_nombre, det.Cantidad_producto, det.Precio_por_producto AS precio
                FROM compra_contiene_producto AS det
                JOIN productos AS prod ON det.Id_producto = prod.Id_producto
                WHERE det.Id_compra IN ($placeholders);
            ");
        
            foreach ($compraIds as $i => $id) {
                $stmtProductos->bindValue($i + 1, $id, PDO::PARAM_INT);
            }
            
            $stmtProductos->execute();
            $productos = $stmtProductos->fetchAll(PDO::FETCH_ASSOC);
        
            
            $comprasDetalle = [];
            foreach ($compras as $compra) {
                $comprasDetalle[$compra['Id_compra']] = $compra;
                $comprasDetalle[$compra['Id_compra']]['productos'] = [];
            }
        
            foreach ($productos as $producto) {
                $comprasDetalle[$producto['Id_compra']]['productos'][] = [
                    'Nombre' => $producto['producto_nombre'],
                    'Cantidad' => $producto['Cantidad_producto'],
                    'Precio' => $producto['precio']
                ];
            }
            
            // Convertir el array asociativo en un array numérico para devolver
            return array_values($comprasDetalle);
        }

        public function contarTotalCompras() {
            $conexion = ConexionBD::getInstance();
            $stmt = $conexion->query("SELECT COUNT(*) as total FROM compras");
            $total = $stmt->fetch()['total'];
            return $total;
        }

        public function contarTotalComprasPreparandose() {
            $conexion = ConexionBD::getInstance();
            $stmt = $conexion->query("SELECT COUNT(*) as total FROM compras WHERE Estado ='Preparandose'");
            $total = $stmt->fetch()['total'];
            return $total;
        }
        
        public function contarTotalComprasPorId($idCliente) {
            $conexion = ConexionBD::getInstance();
            $stmt = $conexion->prepare("SELECT COUNT(*) as total FROM compras WHERE Id_cliente = :Id_cliente");

            if ($stmt->execute([':Id_cliente' => $idCliente])) {
                $total = $stmt->fetch()['total']; 
                return $total;
            }else{
                return false;
            }
        }

        public function getTopProductosVendidos($limite = 5) {
            $conexion = ConexionBD::getInstance();
            
            $stmt = $conexion->prepare("
                SELECT prod.Id_producto, prod.Nombre, SUM(det.Cantidad_producto) AS total_vendido, cat.Nombre_categoria AS Categoria
                FROM compra_contiene_producto AS det
                JOIN productos AS prod ON det.Id_producto = prod.Id_producto
                JOIN categorias AS cat ON prod.Id_categoria = cat.Id_categoria
                GROUP BY prod.Id_producto
                ORDER BY total_vendido DESC
                LIMIT :limite
            ");
            
            $stmt->bindParam(':limite', $limite, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getGananciasPorPeriodo($periodo) {
            $conexion = ConexionBD::getInstance();
            
            $intervalo = '';
            if ($periodo == 'anio') {
                $intervalo = 'YEAR';
            } elseif ($periodo == 'mes') {
                $intervalo = 'MONTH';
            } elseif ($periodo == 'semana') {
                $intervalo = 'WEEK';
            }
            
            $stmt = $conexion->prepare("
                SELECT SUM(com.Costo_total) AS ganancias
                FROM compras AS com
                WHERE YEAR(CURDATE()) = YEAR(com.Fecha)
                AND $intervalo(CURDATE()) = $intervalo(com.Fecha)
            ");
            
            $stmt->execute();
            
            return $stmt->fetchColumn();
        }
        public function getCompras() {
            $conexion = ConexionBD::getInstance();
            
            
            $stmtCompras = $conexion->prepare("
                SELECT Id_compra, Estado
                FROM compras
                ORDER BY Id_compra;
            ");
            
            $stmtCompras->execute();
            
           
            $compras = $stmtCompras->fetchAll(PDO::FETCH_ASSOC);
            
            return $compras ?: []; 
        }
}



class DetalleCompra{
    private $idCompra;
    private $idProducto;
    private $cantidadProducto;
    private $precioPorProducto;
    private $precioDeLinea;
    
    public function __construct(){

    }

    public function getIdCompra(){
        return $this->idCompra;
    }
    public function setIdCompra($idCompra){
        $this->idCompra = $idCompra;
    }
    public function getIdProducto(){
        return $this->idProducto;
    }
    public function setIdProducto($idProducto){
        $this->idProducto = $idProducto;
    }
    public function getCantidadProducto(){
        return $this->cantidadProducto;
    }
    public function setCantidadProducto($cantidadProducto){
        $this->cantidadProducto=$cantidadProducto;
    }
    public function getprecioPorProducto(){
        return $this->precioPorProducto;
    }
    public function setPrecioPorProducto($precioPorProducto){
        $this->precioPorProducto=$precioPorProducto;
    }

    public function getPrecioDeLinea(){
        return $this->precioDeLinea;
    }

    public function setPrecioDeLinea($precioDeLinea){
        $this->precioDeLinea=$precioDeLinea;
    }

    //Vamos el Danu!

    //Funciones de BD

    public function addDetalleCompra($idCompra,$idProducto,$cantidadProducto,$precioProducto){
        try{
            $conexion=ConexionBD::getInstance();
            $conexion -> beginTransaction();

            $sql = "INSERT INTO compra_contiene_producto (Id_Compra, Id_producto, Cantidad_producto, Precio_por_producto) VALUES (:Id_Compra, :Id_producto, :Cantidad_producto, :Precio_por_producto)";
            
            $stmt = $conexion->prepare($sql);

            $stmt->execute([
                ':Id_Compra' => $idCompra,
                ':Id_producto' => $idProducto,
                ':Cantidad_producto'=> $cantidadProducto,
                ':Precio_por_producto' => $precioProducto,
            ]);


            $conexion-> commit();
            return true;
        } catch(Exception $e){
            $conexion->rollBack();

            echo "Error: ". $e -> getMessage();
            return false;
        }
    }

}
?>