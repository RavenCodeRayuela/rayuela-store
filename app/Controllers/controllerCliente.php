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
    $errores.= validarLargoCampo($ciudad,60);

    $calle = sanearTexto($calle);
    $errores.= textoSinCaracteresEspeciales($calle);
    $errores.= validarLargoCampo($calle,60);

    $nroCasa = validarNroPuerta($nroCasa);
    $errores.= validarLargoCampo($nroCasa,40);

    $comentario = sanearTexto($comentario);
    $errores.= textoSinCaracteresEspeciales($comentario);
    $errores.= validarLargoCampo($comentario,280);

    if($ciudad != false && $calle != false && $nroCasa !== false && $comentario != false && $errores==""){

        $mensajeExito="La dirección ha sido ingresada.";
        setMensaje($mensajeExito, 'exito');

        $direccion = new DireccionDeEnvio();

        $direccion->insertDireccion($cliente->getId(),$calle,$nroCasa,$ciudad,$comentario);


        header("Location: ".URL_PATH."/index.php?controller=controllerHome&action=mostrarPerfilDirecciones");
        exit();
    }else{
        if($nroCasa == false){
            $errores.= "Hay un error en el campo de número de casa";
        }
        setMensaje($errores, 'error');
        require_once ROOT_PATH.'/app/Views/viewClienteAgregarDireccion.php';
    }
}

function modificarDireccion(){
    require_once ROOT_PATH.'/app/Models/modelUsuario.php';
    require_once ROOT_PATH.'/app/Models/modelCliente.php';

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $usuario= new Usuario(null,$_SESSION['user_email']);
    $cliente = new Cliente($usuario->getId() );

    $id = $_POST["id"];
    $ciudad = $_POST["ciudad"];
    $calle = $_POST["calle"];
    $nroCasa = $_POST["nroCasa"];
    $comentario = $_POST["comentario"];
    $errores="";

    $id= validarInt($id);
    $ciudad = sanearTexto($ciudad);
    $errores.= textoSinCaracteresEspeciales($ciudad);
    $errores.= validarLargoCampo($ciudad,60);

    $calle = sanearTexto($calle);
    $errores.= textoSinCaracteresEspeciales($calle);
    $errores.= validarLargoCampo($calle,60);

    $nroCasa = validarNroPuerta($nroCasa);
    $errores.= validarLargoCampo($nroCasa,40);

    $comentario = sanearTexto($comentario);
    $errores.= textoSinCaracteresEspeciales($comentario);
    $errores.= validarLargoCampo($comentario,280);

    
    if($id != false && $ciudad != false && $calle != false && $nroCasa !== false && $comentario != false && $errores==""){

        $mensajeExito="La dirección ha sido modificada.";
        setMensaje($mensajeExito, 'exito');

        $direccion = new DireccionDeEnvio();

        $direccion->updateDireccion($id,$calle,$nroCasa,$ciudad,$comentario);


        header("Location: ".URL_PATH."/index.php?controller=controllerHome&action=mostrarPerfilDirecciones");
        exit();

    }else{
        if($nroCasa == false){
            $errores.= "Hay un error en el campo de número de casa";
        }
        setMensaje($errores, 'error');
        
        header("Location: ".URL_PATH.'/index.php?controller=controllerHome&action=mostrarModificarDireccion&id='.$id);
        exit();
    }
}

function eliminarDireccion($id){
    
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    require_once ROOT_PATH.'/app/Models/modelUsuario.php';
    require_once ROOT_PATH.'/app/Models/modelCliente.php';
    require_once ROOT_PATH.'/app/Models/modelCompra.php';

    $id = validarInt($id);
    $compra = new Compra();
    $comprasConDireccion= $compra->getComprasDirecciones();

    foreach ($comprasConDireccion as $compraDir) {
        if($compraDir['Id_direccion']==$id){
            $id=false;
        }
    }

    if($id != false){
        
            $direccion= new DireccionDeEnvio();
    
        $direccion->removeDireccion($id);
            
            $mensajeExito="La dirección ha sido eliminado.";
            setMensaje($mensajeExito, 'exito');

            header("Location: ".URL_PATH."/index.php?controller=controllerHome&action=mostrarPerfilDirecciones");
            exit();
         
        }else{
            setMensaje("Algo ha salido mal al obtener la dirección o la dirección esta anexada a un pedido.", 'error');
            header("Location: ".URL_PATH."/index.php?controller=controllerHome&action=mostrarPerfilDirecciones");
            exit();
    }

}

function modificarInfoPerfil(){
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    require_once ROOT_PATH.'/app/Models/modelUsuario.php';
    require_once ROOT_PATH.'/app/Models/modelCliente.php';

    
    $mensajesDeError='';
    $nombre = htmlspecialchars($_POST['nombre']);
    $newsletter= htmlspecialchars($_POST['newsletter']);
    $celulares = array();
    

    $mensajesDeError.= validarNombre($nombre);
    $mensajesDeError.= validarLargoCampo($nombre,50);

    foreach ($_POST['celular'] as $celular) {
        if(validarCelular($celular)==''){
            $celulares[] = $celular;
        }else{
            $mensajesDeError.= validarCelular($celular);
            break;
        }
    }

    if($mensajesDeError== ''){
        $usuario = new Usuario(null, $_SESSION['user_email']);
        $idCliente = $usuario->getId();
        $cliente = new Cliente($idCliente);
        
        
        $newsletter = ($newsletter == "on") ? 1 : 0;

        $cliente->cuClienteNombre($idCliente, $nombre);
        $cliente->updateOpcionNewsletter($idCliente,$newsletter);

        foreach ($celulares as $celular) {
            $cliente->cuClienteCelular($idCliente, $celular);
        }


        setMensaje("Datos actualizados correctamente",'exito');
        header('Location:'.URL_PATH.'/index.php?controller=controllerHome&action=mostrarPerfil');
        exit();
    }else{

        setMensaje($mensajesDeError,'error');
        header('Location:'.URL_PATH.'/index.php?controller=controllerHome&action=mostrarPerfil');
        exit();
    }

}

?>