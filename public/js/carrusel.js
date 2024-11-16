// Carrusel ofertas
// Selección de elementos
const carouselSlide = document.querySelector('.carousel-slide');
const carouselContainer = document.querySelector('.carousel-container');

// Verifico que los elementos hijos sean mayor a cero, porque los estoy generando dinamicamente.
if (carouselSlide && carouselSlide.children.length > 0) {

    // Duplico el contenido del carrusel con innerHtml que devuelve un string con los elementos internos de un elemento html
    // innerHTML tambien permite modificar dicho elemento
    const originalContent = carouselSlide.innerHTML;
    carouselSlide.innerHTML += originalContent;

    // Con el selector > selecciono a los elementos hijos directos de la clase, y * es el comodin normal
    //Esto significa seleccionar todos los elementos hijos directos de la clase
    //offsetWidth, es una propiedad solo de lectura que devuelve el ancho del elemento incluido los bordes.
    const carouselItems = document.querySelectorAll('.carousel-slide > *'); 
    const itemWidth = carouselItems[0].offsetWidth; 
    let contador = 0;

    //Ajustar el ancho a la cantidad de elementos, el modificador ${} permite asignar expresiones variables.
    //Para ello se utiliza backticks, entonces, el numero de items por el ancho del mismo en px da (al menos en teoria)
    //el ancho total, y el mismo lo aplico a el contenedor de slides
    carouselSlide.style.width = `${carouselItems.length * itemWidth}px`;

    // Configuración inicial de transición
    carouselSlide.style.transition = 'transform 0.5s ease-in-out';

    // Función para mover el carrusel
    //Aqui movemos el carrusel, se duplican los items pero cuando se llega al final de los primeros items, se para el slide
    //Se reinica el contador, se mueve al principio, y se retoma la transición con una pausa para que no arranque antes
    function moveCarousel() {
        carouselSlide.style.transform = `translateX(${-itemWidth * contador}px)`;

        
        if (contador >= carouselItems.length / 2) {
            setTimeout(() => {
                carouselSlide.style.transition = 'none';
                contador = 0; 
                carouselSlide.style.transform = `translateX(${0}px)`;
                setTimeout(() => {
                    carouselSlide.style.transition = 'transform 0.5s ease-in-out';
                }, 50); 
            }, 500); 
        }
    }
   
    //Aqui hacemos una repeticion en intervalos, esta funcion recibe una funcion o codigo mediante una funcion anonima,
    // y despues se le otorga un delay, en este caso de 3 segundos.
      setInterval(() => {
        contador++;
        moveCarousel();
    }, 3000);
}