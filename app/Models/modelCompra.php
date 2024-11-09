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

    public function updateCompra($idCompra,$estado=null,$idDireccion=null,$valoracion=null){
        try {
            $conexion=ConexionBD::getInstance();
            $conexion -> beginTransaction();

            if($estado!= null && $idDireccion==null && $valoracion==null){

                $stmt = $conexion->prepare("UPDATE compras SET Estado = :Estado WHERE Id_compra = :id");
               
                    if ($stmt->execute([':Estado' => $estado, ':id' => $idCompra])){
                        $conexion->commit();
                        return true;
                    } else {
                        throw new Exception("Error en la actualización: " . implode(", ", $stmt->errorInfo()));
                    }
            }elseif($estado== null && $idDireccion!=null && $valoracion==null){

                $stmt = $conexion->prepare("UPDATE compras SET Id_direccion = :Id_direccion WHERE Id_compra = :id");

                if ($stmt->execute([':Id_direccion' => $idDireccion, ':id' => $idCompra])){
                    $conexion->commit();
                    return true;
                } else {
                    throw new Exception("Error en la actualización: " . implode(", ", $stmt->errorInfo()));
                }
            }elseif($estado== null && $idDireccion==null && $valoracion!=null){
                $stmt = $conexion->prepare("UPDATE compras SET Valoracion = :Valoracion WHERE Id_compra = :id");

                if ($stmt->execute([':Valoracion' => $valoracion, ':id' => $idCompra])){
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
    

    public function getCompras(){
        
            $conexion=ConexionBD::getInstance();
                
            $stmt = $conexion->query ("SELECT com.Id_compra, com.Id_cliente, com.Fecha, com.Costo_total AS total, com.Valoracion, com.Estado, com.Tipo_de_pago, prod.Nombre, det.Cantidad_producto, det.Precio_por_producto AS precio,
            dir.Ciudad, dir.Calle, dir.NroCasa, dir.Comentario
            FROM compras AS com
            JOIN compra_contiene_producto AS det ON com.Id_compra = det.Id_compra
            JOIN productos AS prod ON det.Id_producto = prod.Id_producto 
            JOIN direcciones_de_envio AS dir ON com.Id_direccion = dir.Id_direccion
            GROUP BY com.Id_compra;");
    
            $compras = array();
    
             while ( $compra = $stmt->fetch() ){
                $compras[] = $compra;
            }
            
                return $compras;
        }
    
        public function getComprasDeCliente($idCliente) {
            $conexion = ConexionBD::getInstance();

            $stmt = $conexion->prepare("SELECT com.Id_compra, com.Id_cliente, com.Fecha, com.Costo_total AS total, com.Valoracion, com.Estado, com.Tipo_de_pago,
                        dir.Ciudad, dir.Calle, dir.NroCasa, dir.Comentario,
                        prod.Nombre AS producto_nombre, det.Cantidad_producto, det.Precio_por_producto AS precio
                        FROM compras AS com
                        JOIN compra_contiene_producto AS det ON com.Id_compra = det.Id_compra
                        JOIN productos AS prod ON det.Id_producto = prod.Id_producto
                        JOIN direcciones_de_envio AS dir ON com.Id_direccion = dir.Id_direccion
                        WHERE com.Id_cliente = :idCliente
                        ORDER BY com.Id_compra;");
            
            $stmt->bindParam(':idCliente', $idCliente, PDO::PARAM_INT);
            $stmt->execute();
            
            $compras = array();
            $comprasDetalle = array();
            
            
            while ($compra = $stmt->fetch()) {
                
                if (!isset($comprasDetalle[$compra['Id_compra']])) {
                    $comprasDetalle[$compra['Id_compra']] = [
                        'Id_compra' => $compra['Id_compra'],
                        'Id_cliente' => $compra['Id_cliente'],
                        'Fecha' => $compra['Fecha'],
                        'total' => $compra['total'],
                        'Valoracion' => $compra['Valoracion'],
                        'Estado' => $compra['Estado'],
                        'Tipo_de_pago' => $compra['Tipo_de_pago'],
                        'Ciudad' => $compra['Ciudad'],
                        'Calle' => $compra['Calle'],
                        'NroCasa' => $compra['NroCasa'],
                        'Comentario' => $compra['Comentario'],
                        'productos' => []
                    ];
                }
            
            
                $comprasDetalle[$compra['Id_compra']]['productos'][] = [
                    'Nombre' => $compra['producto_nombre'],
                ];
            }
            
            
            foreach ($comprasDetalle as $compra) {
                $compras[] = $compra;
            }
            
            return $compras;
        }

        public function getComprasDeClientePaginadas($idCliente,$paginaActual, $elementosPorPagina) {
            $conexion = ConexionBD::getInstance();

            $offset = ($paginaActual - 1) * $elementosPorPagina;

            $stmt = $conexion->prepare("SELECT com.Id_compra, com.Id_cliente, com.Fecha, com.Costo_total AS total, com.Valoracion, com.Estado, com.Tipo_de_pago,
            dir.Ciudad, dir.Calle, dir.NroCasa, dir.Comentario,
            prod.Nombre AS producto_nombre, det.Cantidad_producto, det.Precio_por_producto AS precio
            FROM compras AS com
            JOIN compra_contiene_producto AS det ON com.Id_compra = det.Id_compra
            JOIN productos AS prod ON det.Id_producto = prod.Id_producto
            JOIN direcciones_de_envio AS dir ON com.Id_direccion = dir.Id_direccion
            WHERE com.Id_cliente = :idCliente
            ORDER BY com.Id_compra
            LIMIT :offset, :limit;");
            
            $stmt->bindParam(':idCliente', $idCliente, PDO::PARAM_INT);
            $stmt->bindParam(':limit', $elementosPorPagina, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);

            $stmt->execute();
            
            $compras = array();
            $comprasDetalle = array();
            
            
            while ($compra = $stmt->fetch()) {
                
                if (!isset($comprasDetalle[$compra['Id_compra']])) {
                    $comprasDetalle[$compra['Id_compra']] = [
                        'Id_compra' => $compra['Id_compra'],
                        'Id_cliente' => $compra['Id_cliente'],
                        'Fecha' => $compra['Fecha'],
                        'total' => $compra['total'],
                        'Valoracion' => $compra['Valoracion'],
                        'Estado' => $compra['Estado'],
                        'Tipo_de_pago' => $compra['Tipo_de_pago'],
                        'Ciudad' => $compra['Ciudad'],
                        'Calle' => $compra['Calle'],
                        'NroCasa' => $compra['NroCasa'],
                        'Comentario' => $compra['Comentario'],
                        'productos' => []
                    ];
                }
            
            
                $comprasDetalle[$compra['Id_compra']]['productos'][] = [
                    'Nombre' => $compra['producto_nombre'],
                ];
            }
            
            
            foreach ($comprasDetalle as $compra) {
                $compras[] = $compra;
            }
            
            return $compras;
        }

        public function contarTotalCompras() {
            $conexion = ConexionBD::getInstance();
            $stmt = $conexion->query("SELECT COUNT(*) as total FROM compras");
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