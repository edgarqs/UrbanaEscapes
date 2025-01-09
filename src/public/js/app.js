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


function hidePopup() {
    document.querySelector("#popup").style.display = "none";
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