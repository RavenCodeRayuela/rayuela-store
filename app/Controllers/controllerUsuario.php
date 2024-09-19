<?php

function registrarUsuario(){
    
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['email'] && !empty($_POST['password']) && !empty($_POST['passwordCh']))) {

        require_once 'app/Models/modelCliente.php';
        require_once 'app/Controllers/validacionDeCampos.php';

        //Datos del form
        $email= htmlspecialchars($_POST['email']);
        $password= htmlspecialchars($_POST['password']);
        $passwordCh= htmlspecialchars($_POST['passwordCh']);
        
        if(!empty($_POST['suscripcion']) && $_POST['suscripcion'] == 'on'){
        $suscripcion= true;
        }else{
            $suscripcion= false;
        }
        //Se validan los campos
        $errores= validarFormRegistro($email, $password, $passwordCh);
        
        if ($errores != '') {
            // Si hay errores, pasarlos a la vista
            require 'app/Views/viewFormRegistro.php';
        } else {
            // Si no hay errores, interactuar con el modelo
            $cliente = new Cliente('Cliente');
            if ($cliente->registrarCliente($email, $password, $suscripcion)) {
                echo "Usuario registrado correctamente";
            } else {
                echo "Error al registrar el usuario";
            }
        }
        require_once 'app/Views/viewFormRegistro.php';
    }
}
function loginUsuario(){
    
}
?>