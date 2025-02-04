
<style scoped>
.card-container {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
}

.card {
    background-color: #ffffff;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    overflow: hidden;
    width: 100%;
    display: flex;
    flex-direction: row;
    height: 200px; 
}

.image-container {
    flex: 1; 
    height: 100%;
}

.card-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.card-body {
    flex: 2; 
    padding: 0.5rem;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.card-title {
    font-size: 1.2rem; 
    font-weight: bold;
    margin-bottom: 0.5rem;
}

.card-text {
    font-size: 0.9rem; 
    margin-bottom: 0.5rem;
}

.card-price {
    font-size: 1.2rem;  
    font-weight: bold;
    color: rgb(100% 53% 0%); 
    text-align: right;
}
</style>
<template>
    <div>
        <h1>Habitacions</h1>
        <div class="container mx-auto p-4">
            <div class="w-full relative">
                <div class="swiper centered-slide-carousel swiper-container relative">
                    <div class="swiper-wrapper card-container" id="card-container">
                        <div v-for="habitacio in habitacions" :key="habitacio.id" class="swiper-slide card">
                            <div class="image-container">
                                <img :src="`https://picsum.photos/200/150?random=${Math.floor(Math.random() * 1000)}`" :alt="`Habitació ${habitacio.numHabitacion}`" class="card-image">
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">Habitació {{ habitacio.numHabitacion }}</h5>
                                <p class="card-text"><strong>Tipus:</strong> {{ habitacio.tipus }}</p>
                                <p class="card-text"><strong>Descripció:</strong> Aquesta és una descripció falsa.</p>
                                <p class="card-text"><strong>Capacitat:</strong> {{ habitacio.llits + habitacio.llits_supletoris }} persones</p>
                                <div class="card-price">{{ habitacio.preu }}€ /nit</div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>

            <div id="error-message" class="alert alert-danger hidden bg-red-100 text-red-700 p-4 rounded-lg mt-4"
                role="alert">
                No s'ha pogut conectar amb el servidor. Si us plau, torna a intentar-ho més tard.
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            habitacions: []
        };
    },
    mounted() {
        fetch('http://localhost:8000/api/v1/habitacions')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to fetch data');
                }
                return response.json();
            })
            .then(data => {
                if (data && data.length > 0) {
                    this.habitacions = data;
                } else {
                    document.querySelector('#error-message').classList.remove('hidden');
                }
            })
            .catch(error => {
                console.error('Error fetching data:', error);
                document.querySelector('#error-message').classList.remove('hidden');
            });
    }
};
</script>
