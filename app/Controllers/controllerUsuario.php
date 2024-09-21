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

        //Pasar a booleano el valor de la suscripcion.
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
            $cliente = new Cliente();
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
        //Requires
        require_once ROOT_PATH.'/app/Models/modelUsuario.php';
        require_once ROOT_PATH.'/app/Controllers/validacionDeCampos.php';

        $email= htmlspecialchars($_POST['email']);
        $password= htmlspecialchars($_POST['password']);

        $errores= validarFormLogin($email);

        if ($errores != '') {
            // Si hay errores, pasarlos a la vista
            require_once ROOT_PATH.'/app/Views/viewFormLogin.php';
         } else {
            $usuario = new Usuario();
            $usuarioLogueado= $usuario ->loginUsuario($email, $password);
            
            if ($usuarioLogueado) {
                // Iniciar sesión de PHP para mantener al usuario autenticado
                session_start();
                // Almacenar el ID de usuario en la sesión para identificar al usuario
                $_SESSION['user_email'] = $usuarioLogueado['email'];
                // Redirigir al usuario
                header('Location:'.URL_PATH.'/app/Views/viewFormRegistro.php');
                exit();
            } else {
                // Mostrar un mensaje de error
                $errores .= "El usuario al que intenta acceder no existe en la base de datos";
                require_once ROOT_PATH.'/app/Views/viewFormLogin.php';
            }

        }
    }
   
}
?>