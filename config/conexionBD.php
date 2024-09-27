<?php
class ConexionBD{
     private $host = 'mysql:host=localhost';
     private $dbname = 'dbname=rayuela';
     private $username = 'root';
     private $passwordBD = '';
     private static $instance = null;
     private $conexion;

     private function __construct(){
      try {
       $this -> conexion = new PDO($this -> host.";".$this -> dbname, $this -> username, $this -> passwordBD);
       $this -> conexion -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
       } catch (PDOException $e) {
             die("Error conectandose a la base de datos: " . $e->getMessage());
       }
     
      }

      public static function getInstance() {
            if (self::$instance === null) {
                self::$instance = new ConexionBD();
            }
            return self::$instance->conexion;
        }
    
        public function __clone() {}
        public function __wakeup() {}

}


?>