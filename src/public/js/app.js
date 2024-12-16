document.addEventListener('DOMContentLoaded', function() {
    setTimeout(function() {
        var flashMessage = document.querySelector('#status-message');
        if (flashMessage) {
            flashMessage.style.display = 'none';
        }
    }, 10000); // 10 segundos
});