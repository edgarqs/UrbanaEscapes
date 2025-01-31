<template>
    <h1>Habitacions</h1>
    <div class="container mx-auto p-4">
        <div class="w-full relative">
            <div class="swiper centered-slide-carousel swiper-container relative">
                <div class="swiper-wrapper card-container" id="card-container">
                    
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
    fetch('http://localhost:8000/api/v1/habitacions')
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to fetch data');
            }
            return response.json();
        })
        .then(data => {
            if (data && data.length > 0) {
                data.forEach(habitacio => {
                    const card = document.createElement('div');
                    card.classList.add('card');

                    const cardBody = document.createElement('div');
                    cardBody.classList.add('card-body');

                    const cardTitle = document.createElement('h5');
                    cardTitle.classList.add('card-title');
                    cardTitle.textContent = `Habitació ${habitacio.numHabitacion}`;

                    // Add a single image
                    const imageContainer = document.createElement('div');
                    imageContainer.classList.add('image-container');

                    const cardImage = document.createElement('img');
                    cardImage.src = `https://picsum.photos/200/150?random=${Math.floor(Math.random() * 1000)}`;
                    cardImage.alt = `Habitació ${habitacio.numHabitacion}`;
                    cardImage.classList.add('card-image');
                    imageContainer.appendChild(cardImage);

                    const dataFields = [
                        { label: 'Tipus', value: habitacio.tipus },
                        { label: 'Descripció', value: 'Aquesta és una descripció falsa.' },
                        { label: 'Capacitat', value: `${habitacio.llits + habitacio.llits_supletoris} persones` }
                    ];

                    dataFields.forEach(field => {
                        const fieldElement = document.createElement('p');
                        fieldElement.classList.add('card-text');
                        fieldElement.innerHTML = `<strong>${field.label}:</strong> ${field.value}`;
                        cardBody.appendChild(fieldElement);
                    });

                    card.appendChild(imageContainer);
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