<?php
$css = URL_PATH.'/public/css/styles.css';
$img = URL_PATH.'/public/img/';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href=<?php echo $css; ?> rel="stylesheet" type="text/css">
    <link rel="icon" type="image/x-icon" href="<?= $img."favicon.png";?>">
    <title>Sobre Rayuela</title>
</head>
<body>


    <!-- Encabezado principal -->
    <?php include_once 'viewHeader.php'?>
    <main class="nosotros">
        <h1>Sobre Nosotros</h1>
        <p>Conoce nuestra historia, valores y compromiso con el diseño de moda.</p>
    </main>

    <!-- Sección de historia -->
    <section class="nosotros-section">
        <h2>Nuestra Historia</h2>
        <p>
            Fundada en 2012, nuestra empresa ha crecido con una misión clara: crear soluciones en tela que expresen
            estilo y autenticidad. Inspirados en las últimas tendencias, nuestros diseños combinan elegancia con
            un toque moderno, destacando lo mejor de la moda actual.
        </p>
    </section>

    <!-- Sección de valores -->
    <section class="nosotros-section">
        <h2>Nuestros Valores</h2>
        <ul class="valores-list">
            <li><strong>Innovación:</strong> Buscamos constantemente nuevas formas de reinventar las soluciones en tela.</li>
            <li><strong>Calidad:</strong> Solo utilizamos materiales de alta calidad.</li>
            <li><strong>Sostenibilidad:</strong> Nos comprometemos a reducir el impacto ambiental en cada etapa de producción.</li>
            <li><strong>Compromiso:</strong> Apoyamos a nuestros empleados y respetamos el entorno en el que trabajamos.</li>
        </ul>
    </section>

    <!-- Sección de equipo -->
    <section class="nosotros-section">
        <h2>Nuestro Equipo</h2>
        <p>
            Nuestro equipo está compuesto por diseñadores apasionados, expertos en moda y artesanos dedicados.
            Juntos trabajamos para ofrecer colecciones únicas que realcen la belleza y personalidad de cada cliente.
        </p>
    </section>

    <!-- Footer -->
    <?php include_once 'viewFooter.php'?>
</body>
</html>