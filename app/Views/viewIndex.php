<?php
    $css = URL_PATH.'/public/css/styles.css';
    $jsOfertas = URL_PATH.'/public/js/carrusel.js';
    $img = URL_PATH.'/public/img/';
    $jsCategorias= URL_PATH.'/public/js/carrusel-categorias.js';
    $login= URL_PATH.'/index.php?controller=controllerHome&action=mostrarLogin';
    $registro= URL_PATH.'/index.php?controller=controllerHome&action=mostrarRegistro';
    $productosURL= URL_PATH.'/index.php?controller=controllerHome&action=mostrarProductos';

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
        }
         
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
    <section id="inicio" class="hero comienzoPagina">
        <div class="hero-item">
            <h1>Rayuela Store</h1>
            <p>La mejor tienda de ropa de diseñador, ahora a tu alcance.</p>
            <?php if (!isset($_SESSION['user_email'])):?>
            <h3>¿Por qué elegirnos?</h3>
            <p> Ofrecemos diseños exclusivos y calidad superior.<br>Nuestra prioridad es que luzcas bien.</p>
            <hr>
                <div class="botones-container">

                
                    <div>
                        <p>Empieza a buscar tu estilo</p>  
                        <a href=<?php echo $login;?> class="btn loguearse">Loguearse</a>
                    </div>
                    <div>
                        <p>¿No estas registrado?</p>
                        <a href=<?php echo $registro;?> class="btn registrarse">Registrarse</a>
                    </div>
                    <?php else:?>
                    <div>
                        <h3>Mira nuestros productos</h3>
                        <a href="<?php echo $productosURL;?>" class="btn productos">Productos</a>
                    </div>
                    <?php endif;?>   
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
                <?php foreach ($productos as $producto):?>
                <div class="product-item-ofertas">
                    <div class="product-image">
                        <img src="<?php echo URL_PATH.$producto['imagenes'][0]?>" alt="Producto 1" class="default-img">
                        <img src="<?php echo URL_PATH.$producto['imagenes'][1]?>" alt="Producto 1 Hover" class="hover-img">
                    </div>
                    <a href="<?php echo $singleProduct;?>"><?php echo $producto['Nombre']?></a>
                    <p><?php echo 'UYU '.$producto['Precio_actual']?></p>
                    <p><?php echo $producto['Descuento'].'% Descuento'?></p>
                </div>
                <?php endforeach;?>
            </div>
        </div>
    </section>

    <?php if(isset($categorias) && !empty($categorias)):?>
    <!-- Sección Categorías -->
    <section id="categorias">
            <h2>Categorías</h2>

            
            <!-- Contenedor de Carrusel -->
            <div class="categorias-carrusel">
                <button class="carrusel-btn left-btn" id="left-btn">&#10094;</button>
                <div class="categorias-container" id="categorias-container">
                <?php foreach($categorias as $categoria):?>
                    <div class="categoria-item">
                        <a href=#><img class="img-categoria" src= <?php echo URL_PATH. $categoria->getRutaImagenCategoria();?> alt="Imagen de categoria" ></a> 
                            <div class="txt-categoria"><?php echo $categoria->getNombre();?></div>
                    </div>
                <?php endforeach;?>
                </div>
                <button class="carrusel-btn right-btn" id="right-btn">&#10095;</button>
            </div>
        </section>
    <?php endif;?>

    <script src=<?php echo $jsOfertas;?>></script>
    <script src=<?php echo $jsCategorias;?>></script>
    <?php include_once 'viewFooter.php'?>

</body>
</html>