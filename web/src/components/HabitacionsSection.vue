<template>
    <div>
        <h1>Habitacions Disponibles</h1>
        <div class="container mx-auto p-4">
            <div v-for="(habitacions, hotelId) in groupedHabitacions" :key="hotelId" class="hotel-container">
                <div class="hotel-info">
                    <h2>{{ habitacions[0].hotel.nom }}</h2>
                    <p>{{ habitacions[0].hotel.adreca }}, {{ habitacions[0].hotel.ciutat }}, {{
                        habitacions[0].hotel.pais }}</p>
                </div>
                <div class="card-container">
                    <div v-for="habitacio in habitacions" :key="habitacio.id" class="card">
                        <div class="image-container">
                            <img :src="`https://picsum.photos/300/200?random=${Math.floor(Math.random() * 1000)}`"
                                :alt="`Habitación ${habitacio.id}`" class="card-image">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title"><strong>Habitació {{ habitacio.tipus }}</strong></h5>
                            <p class="card-text" style="text-transform: initial;"><strong>Descripció: </strong>Habitació {{ habitacio.tipus }} amb {{ habitacio.llits }} llits y {{ habitacio.llits_supletoris }} llits supletoris.<span v-if="habitacio.id % 2 === 0"> Balconada amb vistes exteriors.</span></p>
                            <p class="card-text"><strong>Capacitat:</strong> {{ habitacio.llits +
                                habitacio.llits_supletoris }} persones</p>

                            <div class="card-price">
                                {{ (habitacio.preu * numNights * numPeople).toFixed(2) }} €
                                <p class="text-sm text-gray-500">(Preu per {{ numNights }} nits i {{ numPeople }} persones)</p>
                            </div>

                            <button class="focus:outline-none text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-4 font-medium rounded-lg text-sm px-5 py-2.5">Reservar</button>
                        </div>
                    </div>
                </div>
            </div>
            <div id="error-message" class="alert alert-danger hidden bg-red-100 text-red-700 p-4 rounded-lg mt-4"
                role="alert">
                No se ha podido conectar con el servidor. Por favor, inténtelo más tarde.
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            habitacions: [],
            groupedHabitacions: {}
        };
    },
    computed: {
        numNights() {
            const query = this.$route.query;
            if (!query.startDate || !query.endDate) return 1;

            const start = new Date(query.startDate);
            const end = new Date(query.endDate);
            const diffTime = end - start;
            const diffDays = Math.max(diffTime / (1000 * 60 * 60 * 24), 1); // Mínimo 1 noche

            return diffDays;
        },
        numPeople() {
            const query = this.$route.query;
            return parseInt(query.people) || 1; // Asegurarse de que siempre haya al menos 1 persona
        }
    },
    mounted() {
        const query = this.$route.query;
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
                    this.filterHabitacions(query);
                } else {
                    document.querySelector('#error-message').classList.remove('hidden');
                }
            })
            .catch(error => {
                console.error('Error fetching data:', error);
                document.querySelector('#error-message').classList.remove('hidden');
            });
    },
    methods: {
        filterHabitacions(query) {
            const { destination, startDate, endDate, people } = query;
            const start = new Date(startDate);
            const end = new Date(endDate);

            fetch('http://localhost:8000/api/v1/reserves')
                .then(response => response.json())
                .then(reserves => {
                    const reservedHabitacions = reserves
                        .filter(reserva => {
                            const reservaStart = new Date(reserva.data_entrada);
                            const reservaEnd = new Date(reserva.data_sortida);
                            return (start <= reservaEnd && end >= reservaStart);
                        })
                        .map(reserva => reserva.habitacion_id);

                    const uniqueHabitacions = {};
                    const filteredHabitacions = this.habitacions.filter(habitacio => {
                        const isAvailable = !reservedHabitacions.includes(habitacio.id);
                        const matchesDestination =
                            habitacio.hotel.nom.includes(destination) ||
                            habitacio.hotel.adreca.includes(destination) ||
                            habitacio.hotel.ciutat.includes(destination);
                        const matchesCapacity = (habitacio.llits + habitacio.llits_supletoris) >= people;

                        // Excluir habitaciones con estado "Bloquejada"
                        const isBlocked = habitacio.estat === "Bloquejada";

                        if (isAvailable && matchesDestination && matchesCapacity && !isBlocked) {
                            const key = `${habitacio.hotel_id}-${habitacio.tipus}`;
                            if (!uniqueHabitacions[key]) {
                                uniqueHabitacions[key] = habitacio;
                                return true;
                            }
                        }
                        return false;
                    });

                    // Orden de prioridad de los tipos de habitación
                    const tipusOrder = ["Estandar", "Deluxe", "Suite", "Adaptada"];

                    // Ordenar habitaciones según el tipo
                    const sortedHabitacions = filteredHabitacions.sort((a, b) => {
                        return tipusOrder.indexOf(a.tipus) - tipusOrder.indexOf(b.tipus);
                    });

                    // Agrupar habitaciones por hotel
                    this.groupedHabitacions = sortedHabitacions.reduce((acc, habitacio) => {
                        if (!acc[habitacio.hotel_id]) {
                            acc[habitacio.hotel_id] = [];
                        }
                        acc[habitacio.hotel_id].push(habitacio);
                        return acc;
                    }, {});
                });
        }
    },
    watch: {
        '$route.query': {
            handler(newQuery) {
                this.filterHabitacions(newQuery);
            },
            immediate: true
        }
    }
};
</script>

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

.hotel-container {
    margin-bottom: 2rem;
    padding: 1rem;
    border: 1px solid #ddd;
    border-radius: 8px;
    background-color: #f9f9f9;
}

.hotel-info {
    margin-bottom: 1rem;
}

.hotel-info h2 {
    font-size: 2rem;
    font-weight: bold;
    color: #333;
}

.hotel-info p {
    font-size: 1rem;
    color: #666;
}

.card-container {
    display: flex;
    flex-wrap: wrap;
    gap: 1.5rem;
    justify-content: center;
}

.card {
    display: flex;
    flex-direction: row;
    width: 100%;
    margin-bottom: 1rem;
    background-color: #ffffff;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    border-radius: 15px;
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.image-container {
    flex: 1;
    height: 200px;
    overflow: hidden;
}

.card-image {
    width: 100%;
    height: auto;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.card:hover .card-image {
    transform: scale(1.1);
}

.card-body {
    flex: 2;
    padding: 1rem;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    height: 100%;
}

.card-price {
    font-size: 1.2rem;
    font-weight: bold;
    color: #ff8533;
    text-align: right;
}

.text-sm {
    font-size: 0.875rem;
}
</style>
