function changeMainImage(thumbnail) {
    // Obtiene la ruta de la miniatura clicada
    const newSrc = thumbnail.src;
    // Reemplaza la imagen principal
    document.getElementById('mainImage').src = newSrc;

    const thumbnails = document.querySelectorAll('.thumbnail');

    thumbnails.forEach((thumb) => {
        thumb.style.border = "none"; 
    });

    thumbnail.style.border = "2px solid black";
}