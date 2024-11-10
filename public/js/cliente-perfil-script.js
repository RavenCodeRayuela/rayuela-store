function addPhoneField() {
    const phoneContainer = document.getElementById('phone-container');
    const phoneFields = phoneContainer.getElementsByTagName('input');
    
    // Limitar a 3 campos de celular
    if (phoneFields.length < 3) {
        const newPhoneInput = document.createElement('input');
        newPhoneInput.type = 'tel';
        newPhoneInput.name = 'celular[]';
        newPhoneInput.placeholder = 'Ingresa otro número de celular';
        phoneContainer.appendChild(newPhoneInput);
    } else {
        alert("Solo puedes agregar hasta 3 números de celular.");
    }
}