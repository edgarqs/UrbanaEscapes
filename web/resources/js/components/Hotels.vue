<style scoped>
h1 {
    text-align: center;
    margin: 20px 0;
    font-size: 2rem;
    font-weight: 700;
    line-height: 1.5;
    color: #333;
    margin-bottom: 1rem;
}
.card-container {
  display: flex;
  flex-direction: row;
  flex-wrap: nowrap;
  overflow-x: auto;
}
</style>

<template>
    <h1>Hotels</h1>
    <div class="container mx-auto p-4">
        <div class="w-full relative">
            <div class="swiper centered-slide-carousel swiper-container relative">
                <div class="swiper-wrapper card-container" id="card-container">
                    <!-- Las cards serán cargadas aquí -->
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>

        <div id="error-message" class="alert alert-danger hidden bg-red-100 text-red-700 p-4 rounded-lg mt-4"
            role="alert">
            No s'ha pogut conectar amb el servidor. Si us plau, torna a intentar-ho més tard.
        </div>
    </div>
</template>

<script>
document.addEventListener('DOMContentLoaded', function () {
    fetch('http://localhost:8000/api/v1/hotels')
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to fetch data');
            }
            return response.json();
        })
        .then(data => {
            if (data && data.length > 0) {
                data.forEach(user => {
                    const card = document.createElement('div');
                    card.classList.add('bg-gray-100', 'rounded-lg', 'shadow-lg', 'w-72', 'p-4', 'm-4');

                    const cardBody = document.createElement('div');
                    cardBody.classList.add('space-y-4');

                    const cardTitle = document.createElement('h5');
                    cardTitle.classList.add('text-xl', 'font-bold');
                    cardTitle.textContent = `${user.nom}`;

                    const dataFields = [
                        { label: 'Adreça', value: user.adreca },
                        { label: 'Ciutat', value: user.ciutat },
                        { label: 'Pais', value: user.pais },
                        { label: 'Email', value: user.email },
                        { label: 'Telefon', value: user.telefon }
                    ];

                    dataFields.forEach(field => {
                        const fieldElement = document.createElement('p');
                        fieldElement.classList.add('text-sm');
                        fieldElement.innerHTML = `<strong>${field.label}:</strong> ${field.value}`;
                        cardBody.appendChild(fieldElement);
                    });

                    card.appendChild(cardTitle);
                    card.appendChild(cardBody);

                    document.querySelector('#card-container').appendChild(card);
                });
            } else {
                document.querySelector('#error-message').classList.remove('hidden');
            }
        })
        .catch(error => {
            console.error('Error fetching data:', error);
            document.querySelector('#error-message').classList.remove('hidden');
        });
});
</script>