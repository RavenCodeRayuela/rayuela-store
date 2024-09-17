<?php

function registrarUsuario(){
    
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['email'] && !empty($_POST['password']) && !empty($_POST['passwordCh']))) {
        require '/../Models/modelUsuario.php';

        $email= $_POST['email'];
        $password= $_POST['password'];
        $passwordCh= $_POST['passwordCh'];
        //Agregar suscripcion
        $suscripcion= $_POST['suscripcion'];
        
        registrarUsuarioEnBd($email, $password, $passwordCh, $suscripcion);
        
        }
    
    
}

function loginUsuario(){
    
}
?>