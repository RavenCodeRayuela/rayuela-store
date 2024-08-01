<?php
$mensajeDeError='';

/**
 * Hacer validaciones con FILTER VALIDATE
 * Falta Email, y contraseña(Encriptar), luego subir elementos a JSON.
 */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //Para validar que los campos sean correctos y crear el nombre de usuario.
    if(!empty($_POST['nombre']) && !empty($_POST['apellido']) ){
        
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];


        if ((is_string($nombre) && is_string($apellido))) {
        
            $nombre = filter_var($nombre, FILTER_SANITIZE_STRING);
            $apellido = filter_var($apellido, FILTER_SANITIZE_STRING);


            if((ctype_alpha($nombre) && ctype_alpha($apellido)) && ((strlen($nombre) > 2 && strlen($nombre) < 20) && (strlen($apellido) > 2 && strlen($apellido) < 20)) ){

                $nombreDeUsuario = $nombre." ".$apellido;

                echo $nombreDeUsuario;

            }else{
            
                $mensajeDeError.='No ha insertado un formato valido de nombre y apellido, estos no deben  contener numeros, y poseer entre 2 y 20 caracteres.<br>';

                echo $mensajeDeError;
            }

        }else{
            $mensajeDeError.= 'Al parecer la información ingresada no es una secuencia de caracteres.<br>';
        }
        
    }else{
        $mensajeDeError.='Usted no ha rellenado los campos nombre y apellido.<br>';
        echo $mensajeDeError;
    }

    if(!empty($_POST['ciudad']) && !empty($_POST['calle']) && !empty($_POST['numCasa'])){

        $ciudad = $_POST['ciudad'];
        $calle = $_POST['calle'];
        $numeroDeCasa = $_POST['numCasa'];

        

        $ciudad = filter_var($ciudad, FILTER_SANITIZE_STRING);
        $calle = filter_var($calle, FILTER_SANITIZE_STRING);
        $numeroDeCasa = filter_var($numeroDeCasa, FILTER_SANITIZE_NUMBER_INT);

        echo $numeroDeCasa;

        if((ctype_alpha($ciudad) && ctype_alpha($calle) && ctype_digit($numeroDeCasa)) && ((strlen($ciudad) > 2 && strlen($ciudad) < 20) && (strlen($calle) > 2 && strlen($calle) < 20) && (strlen($numeroDeCasa) > 2 && strlen($numeroDeCasa) < 5))){

            echo 'todo bien';
        }else{
            $mensajeDeError.='No se han introducido valores correctos en los campos, ciudad, calle o numero de casa.<br>Estos deben ser solamente letras para ciudad y calle y solo 3 o 4 numeros para el numero de casa';

            echo $mensajeDeError;
        }


    }

    if(!empty($_POST['celular'])){

        $celular = $_POST['celular'];
        echo gettype($celular);
        $celular = filter_var($celular, FILTER_SANITIZE_NUMBER_INT);
    }
}

?>