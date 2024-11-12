<?php
require_once "config/paths.php";
//La carpeta donde buscaremos los controladores
define ('CONTROLLERS_FOLDER', "app/Controllers/");
//Si no se indica un controlador, este es el controlador que se usará
define ('DEFAULT_CONTROLLER', "controllerHome");
//Si no se indica una acción, esta acción es la que se usará
define ('DEFAULT_ACTION', "mostrarHome");

$controller =  obtenerControlador();
$action = obtenerAction();

//Si la accion es un get, mediante el nombre obtenemos los parametros necesarios para ejecutar la función
if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    if ( is_callable ($action) ){
        switch ($action) {
            case 'editarProducto':
                $modificaImagen = isset($_GET['modImagen']) ? $_GET['modImagen'] : true;
                $action($_GET[ 'id' ], $modificaImagen);
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

                $page = isset($_GET['page']) ? $_GET['page'] : 1;
                $action($page);
                break;

            case 'listarCategorias':
                
                $page = isset($_GET['page']) ? $_GET['page'] : 1;
                $action($page);
                break;

            case 'mostrarProductos':

                $categoria = isset($_GET['categoria']) ? $_GET['categoria'] : 'all';
                $page = isset($_GET['page']) ? $_GET['page'] : 1;
                $action($categoria,$page);
                break;
                
            case 'mostrarSingleProduct':

                $action($_GET[ 'id' ]);
                break;

            case 'eliminarProductoCarrito':

                $action($_GET[ 'id' ]);
                break;
            
            case 'mostrarModificarDireccion':

                $action($_GET[ 'id'] );
                break;
            
            case 'eliminarDireccion':

                $action($_GET[ 'id'] );
                break;
            
            case 'mostrarPerfilHistorial':
                $page = isset($_GET['page']) ? $_GET['page'] : 1;
                $action($page);
                break;

            case 'mostrarBackoffice':
                $page = isset($_GET['page']) ? $_GET['page'] : 1;
                $action($page);
                break;

            case 'marcarPedidoEntregado':
                $page = isset($_GET['page']) ? $_GET['page'] : 1;
                $action($_GET[ 'id'],$page);
                break;

            case 'cancelarPedido':
                $page = isset($_GET['page']) ? $_GET['page'] : 1;
                $action($_GET[ 'id'],$page);
                break;
            case 'mostrarFormComprobantePago':
                $page = isset($_GET['page']) ? $_GET['page'] : 1;
                $action($_GET[ 'id'],$page);
                break;
             case 'mostrarFormValoracion':
                $page = isset($_GET['page']) ? $_GET['page'] : 1;
                $action($_GET[ 'id'],$page);
                 break;
            case 'mostrarStock':
                $page = isset($_GET['page']) ? $_GET['page'] : 1;
                $action($page);
                break;
            case 'generarEticket':
                $action($_GET[ 'id']);;
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