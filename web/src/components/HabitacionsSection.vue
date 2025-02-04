<style scoped>
.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem;
}

h1 {
    font-size: 2.5rem;
    font-weight: bold;
    text-align: center;
    margin-bottom: 2rem;
    color: #333;
}

.card-container {
    display: flex;
    flex-wrap: wrap;
    gap: 1.5rem;
    justify-content: center;
}

.card {
    background-color: #ffffff;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    border-radius: 15px;
    overflow: hidden;
    width: 300px;
    display: flex;
    flex-direction: column;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card:hover {
    transform: translateY(-10px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
}

.image-container {
    height: 200px;
    overflow: hidden;
}

.card-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.card:hover .card-image {
    transform: scale(1.1);
}

.card-body {
    padding: 1rem;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    height: 100%;
}

.card-title {
    font-size: 1.5rem;
    font-weight: bold;
    margin-bottom: 0.5rem;
    color: #333;
}

.card-text {
    font-size: 1rem;
    margin-bottom: 0.5rem;
    color: #666;
}

.card-price {
    font-size: 1.2rem;
    font-weight: bold;
    color: #ff8533;
    text-align: right;
}

.alert {
    text-align: center;
    font-size: 1rem;
    margin-top: 2rem;
}
</style>

<template>
    <div>
        <h1>{{ $t('habitacions-titol') }}</h1>
        <div class="container mx-auto p-4">
            <div class="w-full relative">
                <div class="swiper centered-slide-carousel swiper-container relative">
                    <div class="swiper-wrapper card-container" id="card-container">
                        <div v-for="habitacio in habitacions" :key="habitacio.id" class="swiper-slide card">
                            <div class="image-container">
                                <img :src="`https://picsum.photos/300/200?random=${Math.floor(Math.random() * 1000)}`" :alt="`Habitació ${habitacio.numHabitacion}`" class="card-image">
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">{{ $t('habitacions-habitacio')}} {{ habitacio.numHabitacion }}</h5>
                                <p class="card-text"><strong>{{ $t('habitacions-tipus')}}</strong> {{ habitacio.tipus }}</p>
                                <p class="card-text"><strong>{{ $t('habitacions-descripcio')}}</strong> Aquesta és una descripció falsa.</p>
                                <p class="card-text"><strong>{{ $t('habitacions-capacitat') }}</strong> {{ habitacio.llits + habitacio.llits_supletoris }} persones</p>
                                <div class="card-price">{{ habitacio.preu }}{{ $t('habitacions-preu')}}</div>
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