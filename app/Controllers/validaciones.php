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
        $mensajeDeError.='Hay un error en los campos relacionados con la contraseña. Recuerde que la misma ha de ser de entre 8 y 30 caracteres y contener al menos 1 mayuscula, 1 minuscula y 1 numero';
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

function textoSinCaracteresEspeciales($texto){
    $mensajeDeError='';
    if (!preg_match("/^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ]+$/", $texto)) {
        $mensajeDeError.="Alguno de los campos contiene caracteres especiales.";
        
        return $mensajeDeError;
    }else{
        return $mensajeDeError;
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


function validarImagen($imagen){

    if (!isset($imagen['imagen']) || $imagen['imagen']['error'] !== UPLOAD_ERR_OK) {
        return false;
    }else{
        $tiposPermitidos = array("image/jpg", "image/jpeg", "image/png", "image/gif");
        if (!in_array($imagen['imagen']['type'], $tiposPermitidos)) {
        return false;
        }
        return $imagen;
    }

}
function moverImagen($imagen){
if($imagen == false){
    return false;
}else{
    $rutaDestino = ROOT_PATH."/public/storage/uploads/" . basename($imagen['imagen']['name']);
    if (!move_uploaded_file($imagen['imagen']['tmp_name'], $rutaDestino)) {
       return false;
    } else{
        $rutaBD = "/public/storage/uploads/" . basename($imagen['imagen']['name']);
        return $rutaBD;
    }
}
}

function validarImagenes($imagenes) {

    $tiposPermitidos = array("image/jpg", "image/jpeg", "image/png", "image/gif");

    
    for ($i = 0; $i < count($imagenes['name']); $i++) {
        
        if (!isset($imagenes['name'][$i]) || $imagenes['error'][$i] !== UPLOAD_ERR_OK) {
            return false; 
        }
        if (!in_array($imagenes['type'][$i], $tiposPermitidos)) {
            return false; 
        }
    }
    
    return $imagenes;
}

function moverImagenes($imagenes) {
    if ($imagenes == false) {
        return false;
    } else {
       
        $rutasBD = array();

       
        for ($i = 0; $i < count($imagenes['name']); $i++) {
            $nombreImagen = basename($imagenes['name'][$i]);
            $rutaTemporal = $imagenes['tmp_name'][$i];
            $rutaDestino = ROOT_PATH . "/public/storage/uploads/" . $nombreImagen;

           
            if (move_uploaded_file($rutaTemporal, $rutaDestino)) {
                
                $rutasBD[] = "/public/storage/uploads/" . $nombreImagen;
            } else {
                
                return false;
            }
        }

       
        return $rutasBD;
    }
}

function eliminarImagenes($imagenes){
   
    if (is_array($imagenes )){
        foreach ($imagenes as $imagen) {
        
            $rutaImagen = ROOT_PATH.$imagen['Ruta_imagen_producto']; 
        
            if (file_exists($rutaImagen)) { 
                unlink($rutaImagen);
            } else {
                echo "La imagen en la ruta $rutaImagen no existe o ya fue eliminada.\n";
            }
        
        }
    }else{
        $rutaImagen = ROOT_PATH.$imagenes;
            if (file_exists($rutaImagen)) { 
                unlink($rutaImagen);
            } else {
                echo "La imagen en la ruta $rutaImagen no existe o ya fue eliminada.\n";
            }
    }
}
/**
 * Recibe el mensaje y su tipo, los tipos admitidos son 'exito' y 'error'
 * @param mixed $mensaje
 * @param mixed $tipo
 * @return void
 */
function setMensaje($mensaje, $tipo) {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $_SESSION['mensaje'] = $mensaje;
    $_SESSION['tipo_mensaje'] = $tipo;
}
/**
 * Devuelve un array con el mensaje y su tipo en caso de que haya mensaje,
 *  sino devuelve null
 * @return array|null
 */
function getMensaje(){
    
        if (isset($_SESSION['mensaje'])) {
            $mensaje = $_SESSION['mensaje'];
            $tipoMensaje = $_SESSION['tipo_mensaje'];

            unset($_SESSION['mensaje']);
            unset($_SESSION['tipo_mensaje']);

            return ['mensaje' => $mensaje, 'tipo' => $tipoMensaje];
        }else{
            return null;
        }
        
}
?>