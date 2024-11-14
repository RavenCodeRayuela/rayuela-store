<?php
require_once ROOT_PATH.'/app/Controllers/validaciones.php';
$mensajeData = getMensaje();
$jsMsj = URL_PATH.'/public/js/mensajes-script.js';
?>

<?php if ($mensajeData):?>
    <div class="mensaje <?= $mensajeData['tipo'] === 'exito' ? 'mensaje-exito' : 'mensaje-error' ?>" id="mensaje">
        <p><?php echo nl2br(htmlspecialchars($mensajeData['mensaje'])); ?></p>
    </div>
   <script src="<?php echo $jsMsj;?>"></script>
<?php endif;?>