<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //Para validar que los campos sean correctos y crear el nombre de usuario.
    if(!empty($_POST['nombre']) && !empty($_POST['apellido']) ){
        $nombre= $_POST['nombre'];
        $apellido= $_POST['apellido'];

        $nombre= filter_var($nombre, FILTER_SANITIZE_STRING);
        $apellido= filter_var($apellido, FILTER_SANITIZE_STRING);
        $nombreDeUsuario = $nombre." ".$apellido;

        echo $nombreDeUsuario;
    }
}

?>