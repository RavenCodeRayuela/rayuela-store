function changeMainImage(thumbnail) {
    // Obtiene la ruta de la miniatura clicada
    const newSrc = thumbnail.src;

    // Reemplaza la imagen principal
    document.getElementById('mainImage').src = newSrc;
}