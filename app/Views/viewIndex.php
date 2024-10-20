<?php
    $css = URL_PATH.'/public/css/styles.css';
    $jsOfertas = URL_PATH.'/public/js/carrusel.js';
    $img = URL_PATH.'/public/img/';
    $jsCategorias= URL_PATH.'/public/js/carrusel-categorias.js';
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

    <!-- Sección Inicio -->
    <section id="inicio" class="hero">
        <div class="hero-item">
            <h1>Rayuela Store</h1>
            <p>La mejor tienda de ropa de diseñador a tu alcance.</p>
            <h3>¿Por qué elegirnos?</h3>
            <p> Ofrecemos diseños exclusivos y calidad superior.<br>Nuestra prioridad es que luzcas bien.</p>
            <hr>
                <div class="botones-container">
                    <div>
                        <p>Empieza a buscar tu estilo</p>
                        <button class="btn loguearse">Loguearse</button>
                    </div>
                    <div>
                        <p>¿No estas registrado?</p>
                        <button class="btn registrarse">Registrarse</button>
                    </div>
                        <!-- Agregar luego comprobación para saber si el cliente esta logueado o no y dependiendo de éso mostrar distintos botones<button class="btn productos">Productos</button>-->
                </div>
        </div>
        <div>
            <img src="<?php echo $img."hero-shot.jpg";?>" alt="hero-foto" class="hero-shot">
        </div>
    </section>

    <!-- Sección de Ofertas(Insertar logica de selección de ofertas) -->
    <section id="ofertas" class="carrusel">
        <h2>Ofertas</h2>
        <div class="carousel-container">
            <div class="carousel-slide">
                <img src="img1.jpg" alt="Oferta 1">
                <img src="img2.jpg" alt="Oferta 2">
                <img src="img3.jpg" alt="Oferta 3">
            </div>
        </div>
    </section>

    <!-- Sección Categorías -->
    <section id="categorias">
            <h2>Categorías</h2>

            <!-- Contenedor de Carrusel -->
            <div class="categorias-carrusel">
                <button class="carrusel-btn left-btn" id="left-btn">&#10094;</button>
                <div class="categorias-container" id="categorias-container">
                    <div class="categoria-item">Ropa</div>
                    <div class="categoria-item">Accesorios</div>
                    <div class="categoria-item">Zapatos</div>
                    <div class="categoria-item">Bolsos</div>
                    <div class="categoria-item">Joyas</div>
                    <div class="categoria-item">Sombreros</div>
                    <div class="categoria-item">Bufandas</div>
                    <div class="categoria-item">Bufandas</div>
                    <div class="categoria-item">Bufandas</div>
                </div>
                <button class="carrusel-btn right-btn" id="right-btn">&#10095;</button>
            </div>
        </section>


    <script src=<?php echo $jsOfertas;?>></script>
    <script src=<?php echo $jsCategorias;?>></script>
    <?php include_once 'viewFooter.php'?>

</body>
</html>