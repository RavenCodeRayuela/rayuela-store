<?php
     if (session_status() === PHP_SESSION_NONE) {
        session_start();
        }
    if($_SESSION !=[]){
        if (!isset($_SESSION['user_email']) || $_SESSION['rol']!="admin") {
            header('Location:'.URL_PATH.'/index.php?controller=controllerHome&action=mostrarLogin');
            exit();
        }
    }
    $css = URL_PATH.'/public/css/styles.css';
    $img = URL_PATH.'/public/img/';
    $mostrarBackoffice= URL_PATH."/index.php?controller=controllerHome&action=mostrarBackoffice";
    $cambiarEntregado= URL_PATH."/index.php?controller=controllerCompra&action=marcarPedidoEntregado";
    $cancelarPedido= URL_PATH."/index.php?controller=controllerCompra&action=cancelarPedido";
    
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href=<?php echo $css; ?> rel="stylesheet" type="text/css">
    <link rel="icon" type="image/x-icon" href="<?= $img."favicon.png";?>">
    <title>Pedidos</title>
</head>
<body>

   <?php include_once 'viewHeaderAdmin.php';?>

    <!-- Contenido Principal -->
    <main class="comienzoPagina">
    <div class="main-content" id="contenido">
        <h1>Listado de pedidos para preparar</h1>
            <?php if (isset($compras) && count($compras) > 0): ?>
                <table class="tabla-listar" style="margin-top: 15px;">
                    <thead>
                        <tr>
                            <th class="primer-columna">ID</th>
                            <th>Fecha</th>
                            <th>Nombre de cliente</th>
                            <th>Email de cliente</th>
                            <th>Total</th>
                            <th>Valoración</th>
                            <th>Estado de pedido</th>
                            <th>Tipo de Pago</th>
                            <th>Productos</th>
                            <th>Dirección de Envío</th>
                            <th>e-Ticket</th>
                            <th>Cancelar pedido</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($compras as $compra): ?>
                            <?php if($compra['Estado'] =="Preparandose"):?>
                            <tr>
                                <td class="primer-columna"><?= htmlspecialchars($compra['Id_compra']) ?></td>
                                <td><?= htmlspecialchars($compra['Fecha']) ?></td>
                                <td><?= htmlspecialchars($compra['clienteNombre']) ?></td>
                                <td><?= htmlspecialchars($compra['clienteEmail']) ?></td>
                                <td><?= "$ ".htmlspecialchars($compra['total'])?></td>
                                <td><?php if (($compra['Valoracion']!="")): ?>
                                    <?= htmlspecialchars($compra['Valoracion']) ?>
                                    <?php else:?>
                                       <p>---</p>
                                    <?php endif;?>
                                </td>
                                <td><?= htmlspecialchars($compra['Estado']) ?>
                                    <a href="<?= $cambiarEntregado."&id=".$compra['Id_compra']."&page=".$paginaActual?>" class="btn listar">Cambiar a entregado</a>
                                </td>
                                <td style="text-align:center;">
                                    <?= htmlspecialchars($compra['Tipo_de_pago']) ?> 
                                </td>
                                <td>
                                    <?php foreach($compra['productos'] as $producto):?>
                                    <?= "- ".htmlspecialchars($producto['Nombre']) ?><hr>
                                    <?= "Precio xU: $".htmlspecialchars($producto['Precio']) ?>
                                    <?= "Cantidad:".htmlspecialchars($producto['Cantidad']) ?><br>
                                    <hr>
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
                                    <a href="" class="btn listar">Generar e-ticket</a>
                                </td>
                                <td>
                                    <a href="<?= $cancelarPedido."&id=".$compra['Id_compra']."&page=".$paginaActual?>" class="btn eliminar">Cancelar pedido</a>
                                </td>
                            </tr>
                            <?php endif;?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="no-compras">No se encontraron pendientes de preparación.</p>
            <?php endif; ?>

            <?php if (isset($totalPaginas) && $totalPaginas > 1): ?>
                    <div class="pagination">
                        <?php if ($paginaActual > 1): ?>
                            <a href="<?php echo $mostrarBackoffice;?>&page=<?= $paginaActual - 1 ?>">&laquo; Anterior</a>
                        <?php endif; ?>
                
                        <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                            <a href="<?php echo $mostrarBackoffice;?>&page=<?= $i ?>" class="<?= $i == $paginaActual ? 'active' : '' ?>">
                                <?= $i ?>
                            </a>
                        <?php endfor; ?>
                
                        <?php if ($paginaActual < $totalPaginas): ?>
                            <a href="<?php echo  $mostrarBackoffice;?>&page=<?= $paginaActual + 1 ?>">Siguiente &raquo;</a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
        </div>
    </main>
    <?php include_once 'viewMensaje.php';?>
    <?php include_once 'viewFooter.php';?>

</body>
</html>
