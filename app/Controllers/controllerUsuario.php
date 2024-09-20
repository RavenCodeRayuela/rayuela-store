<?php
    require_once (dirname(__FILE__,3) ."/config/paths.php");
function registrarUsuario(){
    
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['email'] && !empty($_POST['password']) && !empty($_POST['passwordCh']))) {

        require_once ROOT_PATH.'/app/Models/modelCliente.php';
        require_once ROOT_PATH.'/app/Controllers/validacionDeCampos.php';

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
            require_once ROOT_PATH.'/app/Views/viewFormRegistro.php';
        } else {
            // Si no hay errores, interactuar con el modelo
            $cliente = new Cliente('Cliente');
            if ($cliente->registrarCliente($email, $password, $suscripcion)) {
                echo "Usuario registrado correctamente";
            } else {
                echo "Error al registrar el usuario";
            }
        }
        require_once ROOT_PATH.'/app/Views/viewFormRegistro.php';
    }
}
function loginUsuario(){
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['email'] && !empty($_POST['password']))){
        require_once ROOT_PATH.'/app/Models/modelCliente.php';
        require_once ROOT_PATH.'/app/Controllers/validacionDeCampos.php';

        $email= htmlspecialchars($_POST['email']);
        $password= htmlspecialchars($_POST['password']);

        $errores= validarFormLogin($email);

        if ($errores != '') {
            // Si hay errores, pasarlos a la vista
            require_once ROOT_PATH.'/app/Views/viewFormLogin.php';
        } else {
            $cliente = new Cliente('Cliente');
            //Logica para login
        }
    }
    
}
?>