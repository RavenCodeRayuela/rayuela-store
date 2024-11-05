

// Ocultar el mensaje despues de 5seg
setTimeout(() => {
    const mensaje = document.getElementById('mensaje');
    if (mensaje) {
        mensaje.style.opacity = '0';
        setTimeout(() => mensaje.remove(), 500); // Eliminar el elemento
    }
}, 5000);
