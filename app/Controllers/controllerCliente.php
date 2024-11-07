<?php
require_once (dirname(__FILE__,3) ."/config/paths.php");
require_once 'validaciones.php';

function agregarDireccion(){
    require_once ROOT_PATH.'/app/Models/modelUsuario.php';
    require_once ROOT_PATH.'/app/Models/modelCliente.php';
    
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $usuario= new Usuario(null,$_SESSION['user_email']);
    $cliente = new Cliente($usuario->getId() );

    $ciudad = $_POST["ciudad"];
    $calle = $_POST["calle"];
    $nroCasa = $_POST["nroCasa"];
    $comentario = $_POST["comentario"];
    $errores="";

    $ciudad = sanearTexto($ciudad);
    $errores.= textoSinCaracteresEspeciales($ciudad);

    $calle = sanearTexto($calle);
    $errores.= textoSinCaracteresEspeciales($calle);

    $nroCasa = validarNroPuerta($nroCasa);

    $comentario = sanearTexto($comentario);
    $errores.= textoSinCaracteresEspeciales($comentario);


    if($ciudad != false && $calle != false && $nroCasa != false && $comentario != false && $errores==""){

        $mensajeExito="La dirección ha sido ingresada.";
        setMensaje($mensajeExito, 'exito');

        $direccion = new DireccionDeEnvio();

        $direccion->insertDireccion($cliente->getId(),$calle,$nroCasa,$ciudad,$comentario);


        header("Location: ".URL_PATH."/index.php?controller=controllerHome&action=mostrarPerfilDirecciones");
        exit();
    }else{
        setMensaje($errores, 'error');
        require_once ROOT_PATH.'/app/Views/viewClienteAgregarDireccion.php';
    }
}
?>