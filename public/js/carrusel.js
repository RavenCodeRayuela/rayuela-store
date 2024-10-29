// Carrusel ofertas
const carouselSlide = document.querySelector('.carousel-slide');
const carouselImages = document.querySelectorAll('.carousel-slide img');

let contador = 0;
const size = carouselImages[0].clientWidth;

function moveCarousel() {
    carouselSlide.style.transform = 'translateX(' + (-size * contador) + 'px)';
}

setInterval(() => {
    if (contador >= carouselImages.length - 7) {
        contador = -1;
    }
    contador++;
    moveCarousel();
}, 3000);
