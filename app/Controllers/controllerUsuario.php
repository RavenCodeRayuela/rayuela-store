<?php
    require_once (dirname(__FILE__,3) ."/config/paths.php");
    
function registrarUsuario(){
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['email'] && !empty($_POST['password']) && !empty($_POST['passwordCh']))) {

        require_once ROOT_PATH.'/app/Models/modelCliente.php';
        require_once ROOT_PATH.'/app/Controllers/validaciones.php';

        //Datos del form
        $errores="";
        $email= htmlspecialchars($_POST['email']);
        $password= htmlspecialchars($_POST['password']);
        $passwordCh= htmlspecialchars($_POST['passwordCh']);
        
        $errores.=validarLargoCampo($email,95);
        $errores.=validarLargoCampo($password,255);
        $errores.=validarLargoCampo($passwordCh,255);

        //Pasar a booleano el valor de la suscripcion.
        if(!empty($_POST['suscripcion']) && $_POST['suscripcion'] == 'on'){
        $suscripcion= true;
        }else{
            $suscripcion= false;
        }
        //Se validan los campos
        $errores.= validarFormRegistro($email, $password, $passwordCh);
        
        if ($errores != '') {
            $msjError=$errores."\n También verifique que no haya espacios en blanco, los mismos pueden ser tratados como caracteres especiales.";
            setMensaje($msjError,'error');
            require_once ROOT_PATH . '/app/Views/viewFormRegistro.php';
            exit();
        } else {
            // Si no hay errores, interactuar con el modelo
            $cliente = new Cliente();

            if ($cliente->registrarCliente($email, $password, $suscripcion)) {
                
                setMensaje("Usuario registrado correctamente","exito");
                  // Redirigir al usuario
                  header('Location:'.URL_PATH.'/index.php?controller=controllerHome&action=mostrarLogin');
                  exit();
            }else {
                setMensaje("Error al registrar el usuario","error");
                require_once ROOT_PATH . '/app/Views/viewFormRegistro.php';
                exit();
            }
        }
        
    }
}
function loginUsuario(){
   
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
     
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['email'] && !empty($_POST['password']))){
        //Requires
        require_once ROOT_PATH.'/app/Models/modelUsuario.php';
        require_once ROOT_PATH.'/app/Controllers/validaciones.php';
        require_once ROOT_PATH.'/app/Models/modelCliente.php';
        require_once ROOT_PATH.'/app/Models/modelAdministrador.php';
        require_once ROOT_PATH. '/app/Models/modelGestion.php';

        $email= htmlspecialchars($_POST['email']);
        $errores=validarLargoCampo($email,95);
        $password= htmlspecialchars($_POST['password']);
        $errores.=validarLargoCampo($password,255);

        $errores.= validarFormLogin($email);

        if ($errores != '') {
            // Si hay errores, pasarlos a la vista
            setMensaje($errores,'error');
            require_once ROOT_PATH.'/app/Views/viewFormLogin.php';
         } else {
            $usuario = new Usuario();
            $usuarioLogueado= $usuario ->loginUsuario($email, $password);
            
            if ($usuarioLogueado) {
              
                $usuario -> setId($usuarioLogueado['Id_usuario']);
                $usuario -> setEmail($usuarioLogueado['Email']);
                $usuario -> setPassword($usuarioLogueado['password']);
                $usuario -> setTipoDeUsuario($usuarioLogueado['Id_tipo']);

                // Almacenar info del usuario en la sesión para identificar al usuario
                if($usuario ->getTipoDeUsuario() == 1){

                    $admin = new Administrador($usuario ->getId(), $usuario ->getEmail(),$usuario ->getPassword(),$usuario ->getTipoDeUsuario() );
                    $producto= new Producto();
                    $categoria= new Categoria();
                    $_SESSION['user_email'] = $admin -> getEmail();
                    $_SESSION['rol'] = "admin";
                    $_SESSION['Productos'] = $producto -> getProductos();
                    $_SESSION['Categorias'] = $categoria -> getCategorias();
                    $_SESSION['usuario'] = serialize($admin);
                    
                    // Redirigir al usuario
                    header('Location:'.URL_PATH.'/index.php?controller=controllerHome&action=mostrarBackoffice');
                    exit();

                }else{
                        $_SESSION['user_email'] = $usuarioLogueado['Email'];
                        $_SESSION['rol'] ="cliente";
                        $cliente = new Cliente($usuario ->getId(), $usuario ->getEmail(),$usuario ->getPassword(),$usuario ->getTipoDeUsuario() );
                        $_SESSION['nombre'] = $cliente->getNombre();
                        $_SESSION['carrito'] = [];

                        // Redirigir al usuario
                        header('Location:'.URL_PATH.'/index.php?controller=controllerHome&action=mostrarPerfil');
                        exit();
                }
            } else {
                // Mostrar un mensaje de error
                $errores .= "El usuario al que intenta acceder no existe en la base de datos";
                setMensaje($errores,'error');
                require_once ROOT_PATH.'/app/Views/viewFormLogin.php';
            }

        }
    }
   
}

function logoutUsuario(){
    
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    
    $_SESSION = [];

    // Destruir la cookie de la sesion
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

   
    session_destroy();

  
    header("Location: index.php?controller=controllerHome&action=mostrarLogin");
    exit();
    }

?>