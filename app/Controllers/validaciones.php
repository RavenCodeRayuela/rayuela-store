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

    if(!empty($texto)){
        
        $texto= filter_var($texto, FILTER_SANITIZE_STRING) ;
        $texto= trim($texto);
        
        return $texto;
    } else{
        return false;
    }
}

function validarInt($numeroEntero){
    
    $numeroEntero = filter_var($numeroEntero, FILTER_VALIDATE_INT);

    if ($numeroEntero === false || $numeroEntero < 1) {
        return false;
    }else{
        return $numeroEntero;
    }
}

function validarFloatPositivo($numeroFloat){

    $numeroFloat = filter_var($numeroFloat, FILTER_VALIDATE_FLOAT);

    if ($numeroFloat === false || $numeroFloat < 0) {
       return false;
    } else{
        return $numeroFloat;
    }
}

function validarFloatPorcentaje($numeroFloat){

    $numeroFloat = filter_var($numeroFloat, FILTER_VALIDATE_FLOAT);
    
    if ($numeroFloat !== false && ($numeroFloat < 0 || $numeroFloat > 100)) {
       return false;
    } else{
        return $numeroFloat;
    }


}

function validarImagen($imagenSubida){

    if (!isset($imagenSubida['imagen']) || $imagenSubida['imagen']['error'] !== UPLOAD_ERR_OK) {
        return false;
    }else{
        $tiposPermitidos = array("image/jpg", "image/jpeg", "image/png", "image/gif");
        if (!in_array($imagenSubida['imagen']['type'], $tiposPermitidos)) {
           return false;
        }
        return $imagenSubida;
    }
}

function moverImagen($imagenSubida){
    if($imagenSubida == false){
        return false;
    }else{
        $rutaDestino = ROOT_PATH."/public/storage/uploads/" . basename($imagenSubida['imagen']['name']);
        if (!move_uploaded_file($imagenSubida['imagen']['tmp_name'], $rutaDestino)) {
           return false;
        } else{
            $rutaBD = "/public/storage/uploads/" . basename($imagenSubida['imagen']['name']);
            return $rutaBD;
        }
    }
}
?>