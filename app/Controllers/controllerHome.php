<?php
    require_once (dirname(__FILE__,3) ."/config/paths.php");
function mostrarHome(){
    require_once ROOT_PATH.'/app/Views/viewIndex.php';
}

function mostrarLogin(){
    require_once ROOT_PATH.'/app/Views/viewFormLogin.php';
}

function mostrarRegistro(){
    require_once ROOT_PATH.'/app/Views/viewFormRegistro.php';
}

function mostrarBackoffice(){
    require_once ROOT_PATH.'/app/Views/viewAdmin.php';
}

function mostrarBackofficeProductos(){
    require_once ROOT_PATH.'/app/Views/viewAdminProductos.php';
}
function mostrarBackofficeCategorias(){
    require_once ROOT_PATH.'/app/Views/viewAdminCategorias.php';
}
function mostrarNosotros(){

}

function mostrarInfoContacto(){}
function mostrarPerfil(){
    require_once ROOT_PATH.'/app/Views/viewClientePerfil.php';
}
?>