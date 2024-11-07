<div class="sidebar">
            <h3><?php if(isset($nombre)){
                        echo "Bienvenido ".$nombre;
                        }else{
                            echo "Bienvenido";
                        } ?></h3>
            <a href="<?php echo URL_PATH.'/index.php?controller=controllerHome&action=mostrarPerfil'?>" class="<?php echo $paginaActual == 'datosPersonales' ? 'active' : ''; ?>">Datos personales</a>
            <a href="<?php echo URL_PATH.'/index.php?controller=controllerHome&action=mostrarPerfilHistorial'?>" class="<?php echo $paginaActual == 'historialDeCompras' ? 'active' : ''; ?>">Historial de compras</a>
            <a href="<?php echo URL_PATH.'/index.php?controller=controllerHome&action=mostrarPerfilDirecciones'?>" class="<?php echo $paginaActual == 'direccionesDeEnvio' ? 'active' : ''; ?>">Direcciones de envío</a>
            <a href="<?php echo URL_PATH.'/index.php?controller=controllerHome&action=mostrarPerfilEliminarCuenta'?>" class="<?php echo $paginaActual == 'eliminarCuenta' ? 'active' : ''; ?>">Eliminar cuenta</a>
</div>