
const categoriasContainer = document.getElementById('categorias-container');
const leftBtn = document.getElementById('left-btn');
const rightBtn = document.getElementById('right-btn');

let scrollAmount = 0;
const scrollStep = 300; 

leftBtn.addEventListener('click', () => {
    categoriasContainer.scrollBy({
        left: -scrollStep,
        behavior: 'smooth'
    });
    scrollAmount -= scrollStep;
});

rightBtn.addEventListener('click', () => {
    categoriasContainer.scrollBy({
        left: scrollStep,
        behavior: 'smooth'
    });
    scrollAmount += scrollStep;
});