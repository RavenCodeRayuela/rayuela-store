<?php
$mensajeDeError='';
$error = false;

/**
 * Falta: -Subir elementos a JSON.
 *          -Verificar que no se encuentre el mismo usuario registrado(correo y contraseña)
 *          -Agregar opcion de subscribirse a Newsletter
 *          -Agregar otro campo de contraseña para verificar que ingrese la misma contraseña en ambos *          casos(Confirmación de contraseña).
 */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $datosDeRegistro;

    //Para validar que los campos sean correctos y crear el nombre de usuario.
    if(!empty($_POST['nombre']) && !empty($_POST['apellido']) ){
        
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];


        if ((is_string($nombre) && is_string($apellido))) {
        
            //Sanear y borrar espacios al final y al comienzo
            $nombre = filter_var($nombre, FILTER_SANITIZE_STRING);
            $nombre = trim($nombre);
            $apellido = filter_var($apellido, FILTER_SANITIZE_STRING);
            $apellido = trim($apellido);

            //Quitar los espacios para poder usar la funcion ctype
            $nombreSinEspacios = str_replace(' ', '', $nombre);
            $apellidoSinEspacios = str_replace(' ', '', $apellido);


            if((ctype_alpha($nombreSinEspacios) && ctype_alpha($apellidoSinEspacios)) && ((strlen($nombre) > 2 && strlen($nombre) < 20) && (strlen($apellido) > 2 && strlen($apellido) < 20)) ){

                $nombreDeUsuario = $nombre." ".$apellido;

                $datosDeRegistro["nombreCompleto"] = $nombreDeUsuario;
                

            }else{
            
                $mensajeDeError.='No ha insertado un formato valido de nombre y apellido, estos no deben  contener numeros, y poseer entre 2 y 20 caracteres.<br>';
                $error = true;
                echo $mensajeDeError;
            }

        }else{
            $mensajeDeError.= 'Al parecer la información ingresada no es una secuencia de caracteres.<br>';
            $error = true;
        }
        
    }else{
        $mensajeDeError.='Usted no ha rellenado los campos nombre y apellido.<br>';
        echo $mensajeDeError;
        $error = true;
    }

    if(!empty($_POST['ciudad']) && !empty($_POST['calle']) && !empty($_POST['numCasa'])){

        $ciudad = $_POST['ciudad'];
        $calle = $_POST['calle'];
        $numeroDeCasa = $_POST['numCasa'];

        
        //Sanear y quitar espacios vacios en comienzo y final
        $ciudad = filter_var($ciudad, FILTER_SANITIZE_STRING);
        $ciudad = trim($ciudad);
        $calle = filter_var($calle, FILTER_SANITIZE_STRING);
        $calle = trim($calle);
        $numeroDeCasa = filter_var($numeroDeCasa, FILTER_SANITIZE_NUMBER_INT);
        


        //Quitar los espacios para poder usar la funcion ctype
        $ciudadSinEspacios = str_replace(' ', '', $ciudad);
        $calleSinEspacios = str_replace(' ', '', $calle);
        
        
        if((ctype_alpha($ciudadSinEspacios) && ctype_alpha($calleSinEspacios) && ctype_digit($numeroDeCasa)) && ((strlen($ciudad) > 2 && strlen($ciudad) < 30) && (strlen($calle) > 2 && strlen($calle) < 30) && (strlen($numeroDeCasa) > 2 && strlen($numeroDeCasa) < 5))){

            $datosDeRegistro["ciudad"] = $ciudad;
            $datosDeRegistro["calle"] = $ciudad;
            $datosDeRegistro["numeroDeCasa"] = $numeroDeCasa;

        }else{

            $mensajeDeError.='No se han introducido valores correctos en los campos, ciudad, calle o numero de casa.<br>Estos deben ser solamente letras para ciudad y calle y solo 3 o 4 numeros para el numero de casa<br>';

            $error = true;
            echo $mensajeDeError;
        }


    }else{
        $mensajeDeError.='Usted no ha rellenado los campos relativos al domicilio.<br>';
        echo $mensajeDeError;
        $error = true;
    }

    if(!empty($_POST['celular'])){

        $celular = $_POST['celular'];
        $celular = filter_var($celular, FILTER_SANITIZE_NUMBER_INT);
        
       

        if(strlen($celular)==9){

            $datosDeRegistro["celular"] = $celular;

        }else{

            $mensajeDeError.='No has introducido un formato de numero correcto, recuerda que el formato utilizado es sin el indicativo de pais<br>';

            echo $mensajeDeError;
            $error = true;
        }
       
    }else{
        $mensajeDeError.='Usted no ha rellenado el campo del celular.<br>';
        $error = true;
        echo $mensajeDeError;
    }
   
    if(!empty($_POST['email'])){
      
        $email = $_POST['email'];
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){

            $datosDeRegistro["email"] = $email;
        
        }else{
            $mensajeDeError.='Usted ha ingresado un email no valido.<br>';
            echo $mensajeDeError;
            $error = true;
        }

    }else{
        $mensajeDeError.='Usted no ha rellenado el campo del email.<br>';
        echo $mensajeDeError;
        $error = true;
    }

    if(!empty($_POST['password'])){
        
        $password = htmlspecialchars($_POST['password']);

        if(strlen($password) > 8 && strlen($password) < 30){

             $encryptedPassword = password_hash($password, PASSWORD_DEFAULT);
             $datosDeRegistro["password"] = $encryptedPassword;

        }else{
            $mensajeDeError.='La contraseña debe tener entre 8 y 30 caracteres.<br>';
            echo $mensajeDeError;
            $error = true;
        }

    }else{
        $mensajeDeError.='Usted no ha rellenado el campo de la contraseña.<br>';
        echo $mensajeDeError;
        $error = true;
    }

    if(!$error){
        guardarRegistro($datosDeRegistro);
    }else{
        echo 'Han ocurrido errores en el registro, y no se ha completado el mismo.';
    }
    

    function guardarRegistro($datos){

        $carpetaJson= "Usuarios/";

        if(!file_exists($carpetaJson)){

            mkdir($carpetaJson, 0777,true);
        
        }

        $usuariosJson = "Usuarios/usuarios.json";

        if (file_exists($usuariosJson)) {
            $contenidoActual = file_get_contents($usuariosJson);
            $arrayDeDatos = json_decode($contenidoActual, true);
        } else {
            $arrayDeDatos = array();
        }
    
            $arrayDeDatos[] = $datos;
        
        file_put_contents($usuariosJson, json_encode($arrayDeDatos, JSON_PRETTY_PRINT));
      
        echo "Registro exitoso.";
    
     }

}
?>