<?php

function registrarUsuario(){
    
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['email'] && !empty($_POST['password']) && !empty($_POST['passwordCh']))) {

        require_once '../Models/modelCliente.php';
        //Datos del form
        $email= $_POST['email'];
        $password= $_POST['password'];
        $passwordCh= $_POST['passwordCh'];
        //Agregar suscripcion a form
        $suscripcion= $_POST['suscripcion'];
        
        $cliente = new Cliente('Cliente');
        $cliente->registrarCliente($email, $password, $passwordCh, $suscripcion);
        
        }else{
            
        }
    
    
}

function loginUsuario(){
    
}
?>