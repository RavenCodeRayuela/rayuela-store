<?php
//Las rutas

require_once __DIR__."/config/paths.php";

//La carpeta donde buscaremos los controladores
define ('CONTROLLERS_FOLDER', "app/Controllers/");
//Si no se indica un controlador, este es el controlador que se usará
define ('DEFAULT_CONTROLLER', "controllerHome");
//Si no se indica una acción, esta acción es la que se usará
define ('DEFAULT_ACTION', "mostrarHome");

$controller =  obtenerControlador();
$action = obtenerAction();


if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    if ( is_callable ($action) ){
        switch ($action) {
            case 'editarProducto':
                $action($_GET[ 'id' ]);
                break;
            case 'eliminarProducto':
                $action($_GET[ 'id' ]);
                break;
            case 'editarCategoria':
                $action($_GET[ 'id' ]);
                break;
            case 'eliminarCategoria':
                $action($_GET[ 'id' ]);
                break;
            case 'listarProductos':
                if(isset($_GET['page'])){
                    $action($_GET['page']);
                }else{
                $action(1);
                }
                break;
            case 'listarCategorias':
                if(isset($_GET['page'])){
                    $action($_GET['page']);
                }else{
                    $action(1);
                }
                break;
            default:
                $action();
                break;
        }
    }else{
        die ('La accion no existe - 404 not found');
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (is_callable ($action)){
        $action();
        
    }else{
        die ('La accion no existe - 404 not found');
    }
}





function obtenerControlador(){
    //Obtenemos el controlador.
    //Si el usuario no lo introduce, seleccionamos el de por defecto.
    $controller = DEFAULT_CONTROLLER;

    if ( !empty ( $_GET[ 'controller' ] ) ){
        $controller = $_GET[ 'controller' ];
    }


    $controller = CONTROLLERS_FOLDER . $controller . '.php';


    //Si la variable ($controller) es un fichero lo requerimos
    if ( is_file ( $controller ) ){
        require_once ($controller);
    }else{
        die ('El controlador no existe - 404 not found');
    }

    return $controller;
}

function obtenerAction(){
    
    $action = DEFAULT_ACTION;

    // Obtenemos la acción seleccionada.
    // Si el usuario no la introduce, seleccionamos la de por defecto.
    if ( !empty ( $_GET [ 'action' ] ) ){
        $action = $_GET [ 'action' ];
    }

    return $action;
}

?>