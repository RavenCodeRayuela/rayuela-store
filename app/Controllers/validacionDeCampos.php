<?php

function validarFormRegistro($email, $password, $passwordCh){
    $mensajeDeError='';
    $regex = "/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)[A-Za-z\d]{8,30}$/";

    //Email
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);  
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $mensajeDeError.='Usted ha ingresado un email no valido.<br>';
    }
    //Password
    if(!preg_match($regex, $password) || $password != $passwordCh){
        $mensajeDeError.='Hay un error en los campos relacionados con la contraseña.<br>';
    }

    return $mensajeDeError;
}

?>