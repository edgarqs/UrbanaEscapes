// Oculta els missatges flash passats 10 segons
document.addEventListener("DOMContentLoaded", function () {
    setTimeout(function () {
        let flashMessage = document.querySelector("#status-message");
        if (flashMessage) {
            flashMessage.style.display = "none";
        }
    }, 10000); // 10 segundos
});

// Mostra el popup amb els detalls de la habitació
document.addEventListener("DOMContentLoaded", function () {
    setTimeout(function () {
        let flashMessage = document.querySelector("#status-message");
        if (flashMessage) {
            flashMessage.classList.add("message-content--hidden");
            setTimeout(() => flashMessage.style.display = "none", 500); // Esperar transición
        }
    }, 10000); // 10 segundos
});

function showPopup(habitacioId) {
    // Verificar si el clic proviene de un botón con la clase 'no-popup'
    if (event.target.closest('.no-popup')) {
        return;
    }

    // Hacer una llamada AJAX para obtener los detalles de la habitación
    fetch(`/habitacions/${habitacioId}/detalls`)
        .then(response => response.text())
        .then(data => {
            // Verificar si el elemento #popup-details existe
            const popupDetails = document.querySelector("#popup-details");
            if (popupDetails) {
                // Insertar el contenido en el popup
                popupDetails.innerHTML = data;
                // Mostrar el popup
                document.querySelector("#popup").style.display = "grid";
            } else {
                // console.error('Elemento #popup-details no encontrado');
            }
        })
        // .catch(error => console.error('Error:', error));
}

function hidePopup() {
    document.querySelector("#popup").style.display = "none";
}

// Cerrar el popup cuando se hace clic fuera de él
window.onclick = function(event) {
    const modal = document.querySelector('#popup');
    const backdrop = document.querySelector('#popup-backdrop');
    if (event.target === modal || event.target === backdrop) {
        hidePopup();
    }
}

// Formulari usuaris reserva rapida
function mostrarFormUsuari() {
    let tipusUsuari = document.querySelector('#tipus_usuari').value;
    let usuariRegistrat = document.querySelector('.usuariRegistrat');
    let usuariNou = document.querySelector('.usuariNou');
    
    if (tipusUsuari === 'registrat') {
        usuariRegistrat.style.display = 'block';
        usuariNou.style.display = 'none';
    } else if (tipusUsuari === 'nou') {
        usuariRegistrat.style.display = 'none';
        usuariNou.style.display = 'block';
    } else {
        usuariRegistrat.style.display = 'none';
        usuariNou.style.display = 'none';
    }
}

// Función para manejar el botón de "Tornar" sin redirigir a /login
function Tornar() {
    if (document.referrer.includes('/login')) {
        window.location.href = '/'; // Redirigir a la página principal o cualquier otra página
    } else {
        window.history.back();
    }
}