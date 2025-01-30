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

.card {
    display: flex;
    flex-direction: row;
    align-items: center;
    background-color: #fff;
    border-radius: 0.5rem;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin: 1rem 0;
    overflow: hidden;
    padding: 1rem;
}

.card img {
    border-radius: 0.5rem;
    object-fit: cover;
    width: 200px;
    height: 150px;
    margin-right: 1rem;
}

.card-body {
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.card-title {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.card-text {
    font-size: 1rem;
    color: #4a5568;
    margin-bottom: 0.5rem;
}
</style>

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
                    card.classList.add('bg-gray-100', 'rounded-lg', 'shadow-lg', 'w-72', 'p-4', 'm-4', 'h-auto');

                    const cardBody = document.createElement('div');
                    cardBody.classList.add('space-y-4');

                    const cardTitle = document.createElement('h5');
                    cardTitle.classList.add('text-xl', 'font-bold');
                    cardTitle.textContent = `Habitació ${habitacio.numHabitacion}`;

                    // Add a single image
                    const imageContainer = document.createElement('div');
                    imageContainer.classList.add('image-container', 'space-y-2');

                    const cardImage = document.createElement('img');
                    cardImage.src = `https://picsum.photos/200/150?random=${Math.floor(Math.random() * 1000)}`;
                    cardImage.alt = `Habitació ${habitacio.numHabitacion}`;
                    cardImage.classList.add('w-full', 'h-48', 'object-cover', 'rounded-t-lg');
                    imageContainer.appendChild(cardImage);

                    const dataFields = [
                        { label: 'Tipus', value: habitacio.tipus },
                        { label: 'Descripció', value: habitacio.descripcio },
                        { label: 'Capacitat', value: `${habitacio.llits + habitacio.llits_supletoris} persones` }
                    ];

                    dataFields.forEach(field => {
                        const fieldElement = document.createElement('p');
                        fieldElement.classList.add('text-sm');
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