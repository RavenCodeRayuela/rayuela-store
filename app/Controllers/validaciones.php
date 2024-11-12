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
        
        $texto= htmlspecialchars($texto);
        $texto= trim($texto);
        
        return $texto;
    } else{
        return false;
    }
}

function textoSinCaracteresEspeciales($texto){
    $mensajeDeError = '';
    if (!preg_match("/^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s.,!?;:'()\"_-]+$/", $texto)) {
        $mensajeDeError .= "Alguno de los campos contiene caracteres especiales.";
        return $mensajeDeError;
    } else {
        return $mensajeDeError;
    }
}

function validarNombre($nombre) {
    $mensajeDeError = '';
    
    if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/", $nombre)) {
        $mensajeDeError .= "El nombre contiene caracteres no permitidos.";
        return $mensajeDeError;
    } else {
        return $mensajeDeError;
    }
}

function validarCelular($celular) {
    $mensajeDeError = '';
    
    
    if (!preg_match("/^[0-9]{9}$/", $celular)) {
        $mensajeDeError .= "El número de celular no es válido. Debe contener exactamente 9 dígitos, sin el código de pais(+598).";
        return $mensajeDeError;
    } else {
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
        $tiposPermitidos = array("image/jpg", "image/jpeg", "image/png", "image/gif","image/webp");
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

    $tiposPermitidos = array("image/jpg", "image/jpeg", "image/png", "image/gif","image/webp");

    
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

function validarNroPuerta($numeroEntero){

    $numeroEntero = filter_var($numeroEntero, FILTER_VALIDATE_INT);

    if ($numeroEntero !== false && $numeroEntero >= 0) {
        return $numeroEntero;
    }else{
        return false;
    }
}

function validarLargoCampo($campo, $longitudMax) {
    if (strlen($campo) > $longitudMax) {
        return "El campo debe tener como máximo $longitudMax caracteres.";
    }
    return "";  
}

function enviarCorreo($destinatario, $asunto, $mensaje, $from = "Ovidiodiaz605@gmail.com") {
    
    $headers = "From: $from\r\n";
    $headers .= "Reply-To: $from\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8\r\n";

    // Enviar el correo y verificar si fue exitoso
    if (mail($destinatario, $asunto, $mensaje, $headers)) {
        return "Correo enviado exitosamente";
    } else {
        return "Error al enviar el correo";
    }
}

function generarETicketHTML($nombreCliente, $rut, $serie, $numeroTicket, $fecha, $detallesCompra,$total, $direccion,$comentario) {
   
    $html = "
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; }
            .ticket { width: 80%; margin: auto; text-align: center; border: solid 1px #000; padding: 20px; }
            .nombre{ text-align:left; font-weight:bolder}
            .header { font-size: 20px; font-weight: bold; }
            .rut {text-align: right; margin-bottom: 10px;}
            .details { text-align: left; margin-top: 20px; }
            .details p { margin: 5px 0; }
            .items { margin-top: 20px; width: 100%; border-collapse: collapse; }
            .items th, .items td { border: 1px solid #000; padding: 8px; text-align: center; }
            .items th { background-color: #f2f2f2; }
            .total{text-align:right; font-weight:bold}
        </style>
    </head>
    <body>
        <div class='ticket'>
            <div class='nombre'>Rayuela Store</div>
            <div class='rut'><strong>RUT:</strong> $rut</div>
            <div class='rut'><strong>CONTADO</strong></div>
            <div class='rut'><strong>Serie:</strong> $serie <strong>Nro:</strong> $numeroTicket</div>
             <div class='rut'><strong>Fecha:</strong> $fecha</div>
            <div class='header'>E-Ticket de Compra</div>
            <hr>
            <div class='details'>
                <p><strong>Cliente:</strong> $nombreCliente</p>
                <p><strong>Dirección:</strong> $direccion</p>
                <p><strong>Comentario sobre dirección:</strong> $comentario</p>
            </div>
            <hr>
            <table class='items'>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                </tr>";

    
    foreach ($detallesCompra as $detalle) {
        $html .= "
        <tr>
            <td>{$detalle['productoNombre']}</td>
            <td>{$detalle['Cantidad_producto']}</td>
            <td>{$detalle['precio']}</td>
        </tr>";
    }

    $html .= "<tr>
            <td colspan='3'><p class='total'>Total: $total</p></td>    
        </tr>
            </table>
        </div>
    </body>
    </html>
    ";

    header("Content-type: text/html");
    header("Content-Disposition: attachment; filename=eticket.html");
    // Mostrar el contenido HTML que se descarga como PDF
    echo $html;
}?>