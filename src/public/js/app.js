// Oculta els missatges flash passats 10 segons
document.addEventListener("DOMContentLoaded", function () {
    setTimeout(function () {
        var flashMessage = document.querySelector("#status-message");
        if (flashMessage) {
            flashMessage.style.display = "none";
        }
    }, 10000); // 10 segundos
});

// Mostra el popup amb els detalls de la habitació
function showPopup(habitacioId) {
    fetch(`/habitacions/${habitacioId}/detalls`)
        .then((response) => response.text())
        .then((html) => {
            document.querySelector("#popup-details").innerHTML = html;
            document.querySelector("#popup").style.display = "block";
        });
}

function hidePopup() {
    document.querySelector("#popup").style.display = "none";
}
