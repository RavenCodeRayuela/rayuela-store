<?php
    $css = URL_PATH.'/public/css/styles.css';
    $js = URL_PATH.'/public/js/admin-script.js';
    $img = URL_PATH.'/public/img/';

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
        }
        
    if($_SESSION !=[]){
        if (!isset($_SESSION['user_email'])) {
            header('Location:'.URL_PATH.'/index.php?controller=controllerHome&action=mostrarLogin');
            exit();
        }
        if(isset($_SESSION['nombre']) && $_SESSION['nombre']!='Nombre no asignado'){
            $nombre = $_SESSION['nombre'];
        }
    }

    $paginaActualSidebar = "historialDeCompras";
    $mostrarHistorial= URL_PATH."/index.php?controller=controllerHome&action=mostrarPerfilHistorial";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href=<?php echo $css; ?> rel="stylesheet" type="text/css">
    <title>Rayuela Store</title>
</head>
<body>

    <?php include_once 'viewHeader.php'?>

    <!-- Contenido Principal -->
    <main class="container comienzoPagina">

        <!-- Barra lateral -->
        <?php include_once 'viewSidebarCliente.php'?>

        <!-- Contenido principal -->
        <div class="main-content" id="contenido">
        <h1>Listado de Compras</h1>
            <?php if (isset($compras) && count($compras) > 0): ?>
                <table class="tabla-compras">
                    <thead>
                        <tr>
                            <th class="primer-columna">ID</th>
                            <th>Fecha</th>
                            <th>Total</th>
                            <th>Valoración</th>
                            <th>Estado</th>
                            <th>Tipo de Pago</th>
                            <th>Productos</th>
                            <th>Dirección de Envío</th>
                            <th>e-Ticket</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($compras as $compra): ?>
                            <tr>
                                <td class="primer-columna"><?= htmlspecialchars($compra['Id_compra']) ?></td>
                                <td><?= htmlspecialchars($compra['Fecha']) ?></td>
                                <td><?= "$ ".htmlspecialchars($compra['total'])?></td>
                                <td><?php if (($compra['Valoracion']!="")): ?>
                                    <?= htmlspecialchars($compra['Valoracion']) ?>
                                    <?php else:?>
                                        <a href="" class="valoracion-link">Tu opinión importa. ¡Déjanos tu valoración!</a>
                                    <?php endif;?>
                                </td>
                                <td><?= htmlspecialchars($compra['Estado']) ?></td>
                                <td style="text-align:center;">
                                    <?= htmlspecialchars($compra['Tipo_de_pago']) ?>
                                    <?php if($compra['Tipo_de_pago']=="transferencia"):?>
                                        <a href="" class="valoracion-link">Sube aquí el comprobante</a>
                                    <?php endif;?>
                                </td>
                                <td>
                                    <?php foreach($compra['productos'] as $producto):?>
                                    <?= "- ".htmlspecialchars($producto['Nombre']) ?><br>
                                    <?php endforeach;?>
                                </td>
                                <td class="direccion-envio">
                                    <?= htmlspecialchars($compra['Ciudad']) ?>, 
                                    <?= htmlspecialchars($compra['Calle']) ?> # 
                                    <?= htmlspecialchars($compra['NroCasa']) ?> 
                                    <?php if (!empty($compra['Comentario'])): ?>
                                        (<?= htmlspecialchars($compra['Comentario']) ?>)
                                    <?php endif; ?>
                                </td>
                                <td>
                                <a href="" class="valoracion-link">Generar e-ticket</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="no-compras">No se encontraron compras para este cliente.</p>
            <?php endif; ?>

            <?php if (isset($totalPaginas) && $totalPaginas > 1): ?>
                    <div class="pagination">
                        <?php if ($paginaActual > 1): ?>
                            <a href="<?php echo $mostrarHistorial;?>&page=<?= $paginaActual - 1 ?>">&laquo; Anterior</a>
                        <?php endif; ?>
                
                        <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                            <a href="<?php echo  $mostrarHistorial;?>&page=<?= $i ?>" class="<?= $i == $paginaActual ? 'active' : '' ?>">
                                <?= $i ?>
                            </a>
                        <?php endfor; ?>
                
                        <?php if ($paginaActual < $totalPaginas): ?>
                            <a href="<?php echo  $mostrarHistorial;?>&page=<?= $paginaActual + 1 ?>">Siguiente &raquo;</a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
        </div>

       
    </main>

    <?php include 'viewMensaje.php'?>
    <?php include_once 'viewFooter.php'?>

</body>
</html>