// Carrusel ofertas
const carouselSlide = document.querySelector('.carousel-slide');
const carouselImages = document.querySelectorAll('.carousel-slide img');

let counter = 0;
const size = carouselImages[0].clientWidth;

function moveCarousel() {
    carouselSlide.style.transform = 'translateX(' + (-size * counter) + 'px)';
}

setInterval(() => {
    if (counter >= carouselImages.length - 1) counter = -1;
    counter++;
    moveCarousel();
}, 3000);
