<?php
class ConexionBD{
     private $host = 'mysql:host=localhost';
     private $dbname = 'dbname=rayuela';
     private $username = 'root';
     private $passwordBD = '';
     private $conexion;

     public function __construct(){
      try {
       $this -> conexion = new PDO($this -> host.";".$this -> dbname, $this -> username, $this -> passwordBD);
       $this -> conexion -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
       } catch (PDOException $e) {
             die("Error conectandose a la base de datos: " . $e->getMessage());
       }
     
      }

      public function obtenerConexion(){
            return $this -> conexion;
      }


}


?>