<?php

function validarFormRegistro($email, $password, $passwordCh){
    $mensajeDeError='';
    $regex = "/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)[A-Za-z\d]{8,30}$/";

    //Email
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);  
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $mensajeDeError.='Usted ha ingresado un email no valido.<br>Ejemplo de email valido: juan@gmail.com';
    }
    //Password
    if(!preg_match($regex, $password) || $password != $passwordCh){
        $mensajeDeError.='Hay un error en los campos relacionados con la contraseña.<br>Recuerde que la misma ha de ser de entre 8 y 30 caracteres y contener al menos 1 mayuscula, 1 minuscula y 1 numero';
    }

    return $mensajeDeError;
}

function validarFormLogin($email){
    $mensajeDeError='';

    //Email
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);  
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $mensajeDeError.='Usted ha ingresado un email no valido.<br>Ejemplo de email valido: juan@gmail.com';
    }
    
    return $mensajeDeError;
}

function sanearTexto($texto){
    $texto= trim($texto);
    $texto= filter_var($texto, FILTER_SANITIZE_STRING) ;

    return $texto;
}
?>