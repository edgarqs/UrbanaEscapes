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
