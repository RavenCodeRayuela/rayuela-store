<?php
require_once (dirname(__FILE__,3) ."/config/paths.php");

$css = URL_PATH.'/public/css/estilos-emp.css';
$img = URL_PATH.'/public/img/Rbanner.png';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href=<?php echo $css; ?>>
    <title>Raven Code</title>
</head>
<body>
    <header>
        <h1>Raven Code</h1>
    </header>
  
    <nav>
        <ul>
            <li><a href="#que-es">¿Qué es Raven Code?</a></li> 
            <li><a href="#integrantes">¿Quiénes son sus integrantes?</a></li>
            <li><a href="#valores">¿Por que nos llamamos así?</a></li>
            <li><a href="#mision-vision">¿Cuál es la visión y la misión de la empresa?</a></li>
        </ul>
    </nav>
    <div class="banner"><img src=<?php echo $img; ?> alt="banner"></div>
    <main>
        <section id="que-es">
            <h2>Raven Code:</h2>
            <p>Raven Code es una nueva empresa dedicada a la creación de software. Su objetivo es desarrollar software seguro y duradero que cumpla con los requisitos de los clientes.<br>
            La empresa surgió ante la necesidad de tener un referente en cuanto a software en la región, facilitando así el acceso de las pequeñas y medianas empresas a la creación de software.</p>
        </section>

        <section id="integrantes">
            <h2> Integrantes:</h2>
            <p>- Jefe de proyecto/Ing. de software: Juan Letamendía<br>
            - Miembro/Programador: Ingrid Etchevarrén<br>
            - Miembro/Desarrollador de BD: Carlos Sugasti<br>
            - Miembro/Diseñador Web: Gerónimo Ferré</p>
        </section>

        <section id="valores">
            <h2> Nombre de la empresa:</h2>
            <p>
                Se eligió como nombre de la empresa "Raven Code", que al español se traduce como cuervo y código. Se decidió poner el nombre en inglés porque es un idioma universal y ayudará a llegar a más personas, lo que atraerá a más clientes.
                <br>
                El animal que representa a la empresa es un cuervo. Este fue elegido porque, en la mitología nórdica, el cuervo Hugin representa Pensamiento y Razonamiento Lógico, y el cuervo Munin representa la memoria. Además, el cuervo es capaz de trabajar en equipo, ya sea con su especie o con otras especies. Se desea que la empresa esté relacionada con estas cualidades y que sus productos sean creados bajo estas características, siendo el pensamiento y el razonamiento lógico las herramientas básicas para la creación de soluciones, la memoria representando el compromiso con la correcta documentación de las soluciones, y la capacidad de trabajar en equipo reflejando tanto la cooperación dentro de la empresa como con los equipos de las empresas clientes.
                </p>
        </section>

        <section id="mision-vision">
            <h2>Visión y la misión de la empresa:</h2>
            <br>
            <h3>Misión</h3>
            <p>Ofrecer soluciones de software, productos y servicios, basándonos en el razonamiento lógico, el trabajo en equipo y el cumplimiento de estándares de calidad para brindarle al cliente la satisfacción deseada.</p>
<br>
            <h3>Visión</h3>
            <p>Ser una empresa líder en el sector de desarrollo de software en la región, que nuestros productos sean destacados por su utilidad y fiabilidad, y nuestros servicios sean reconocidos por su prontitud y calidad tanto en el trato humano como en las soluciones ofrecidas.</p>
        
        </section>
    </main>

    <footer>
        <p>© 2024 Raven Code. Todos los derechos reservados.</p>
    </footer>
</body>
</html>