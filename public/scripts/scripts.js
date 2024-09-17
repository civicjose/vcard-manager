 //script para crear la vcard

 document.addEventListener('DOMContentLoaded', function() {
    const addButton = document.querySelector('.add-contact-button');

    addButton.addEventListener('click', function() {
        // Obtener el nombre
        const nameElement = document.querySelector('.header h2');
        const name = nameElement ? nameElement.innerText : 'Desconocido';

        // Obtener el teléfono
        const phoneElement = document.querySelector('.contact-info .phone');
        const phone = phoneElement ? phoneElement.innerText : 'Desconocido';

        // Obtener el email
        const emailElement = document.querySelector('.contact-info .email');
        const email = emailElement ? emailElement.innerText : 'Desconocido';

        // Crear el contenido vCard con codificación UTF-8
        const vCardData = `
BEGIN:VCARD
VERSION:3.0
FN;CHARSET=UTF-8:${name}
TEL;CHARSET=UTF-8:${phone}
EMAIL;CHARSET=UTF-8:${email}
END:VCARD
        `;

        // Crear un Blob con el contenido vCard en UTF-8
        const vCardBlob = new Blob([vCardData], { type: 'text/vcard;charset=utf-8' });
        const url = URL.createObjectURL(vCardBlob);

        // Crear un enlace para descargar el archivo
        const a = document.createElement('a');
        a.href = url;
        a.download = `${name.replace(/\s+/g, '_')}.vcf`; // Nombre del archivo
        document.body.appendChild(a); // Añadir el enlace al DOM
        a.click(); // Iniciar la descarga
        document.body.removeChild(a); // Eliminar el enlace del DOM

        // Liberar el objeto URL
        URL.revokeObjectURL(url);
    });
});



//script para copiar el pinchar en el telefono o email
document.addEventListener('DOMContentLoaded', function() {
    // Función para copiar al portapapeles
    function copyToClipboard(text) {
        const tempInput = document.createElement('input');
        tempInput.value = text;
        document.body.appendChild(tempInput);
        tempInput.select();
        document.execCommand('copy');
        document.body.removeChild(tempInput);

        // Mostrar el mensaje de confirmación
        const confirmMessage = document.getElementById('copy-confirm');
        confirmMessage.classList.add('show');
        setTimeout(function() {
            confirmMessage.classList.remove('show');
        }, 2000); // Oculta el mensaje después de 2 segundos
    }

    // Selecciona los elementos para el evento de click
    const phoneInfo = document.getElementById('phone-info');
    const emailInfo = document.getElementById('email-info');

    // Añade el evento para copiar el teléfono
    phoneInfo.addEventListener('click', function() {
        const phone = document.querySelector('.contact-info .phone').innerText.trim();
        copyToClipboard(phone);
    });

    // Añade el evento para copiar el email
    emailInfo.addEventListener('click', function() {
        const email = document.querySelector('.contact-info .email').innerText.trim();
        copyToClipboard(email);
    });
  });