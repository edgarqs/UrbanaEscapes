<script setup>
import { ref, onMounted, computed } from 'vue';
import { useRoute } from 'vue-router';
import Header from '../components/HeaderSection.vue';
import Footer from '../components/FooterSection.vue';

const habitacio = ref(null);
const hotels = ref(null);
const route = useRoute();

const startDate = ref(localStorage.getItem('startDate'));
const endDate = ref(localStorage.getItem('endDate'));

console.log(startDate.value);
console.log(endDate.value);

const diesTotals = computed(() => {
  if (startDate.value && endDate.value) {
    return Math.ceil((new Date(endDate.value) - new Date(startDate.value)) / (1000 * 60 * 60 * 24));
  }
  return 0;
});

onMounted(() => {
  fetch(`http://localhost:8000/api/v1/habitacions/${route.params.id}`)
    .then(response => response.json())
    .then(data => {
      habitacio.value = data;
      fetch(`http://localhost:8000/api/v1/hotels/${habitacio.value.hotel_id}`)
        .then(response => response.json())
        .then(data => {
          hotels.value = data;

        })
        .catch(error => {
          console.error('Error fetching data:', error);
        });
    })
    .catch(error => {
      console.error('Error fetching data:', error);
    });
});
</script>

<template>
  <Header />
  <div class="bg-gray-100 p-6 min-h-screen">
    <div class="container mx-auto">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Tarjeta 1: Información del Hotel -->
        <div class="col-span-1">
          <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex items-center justify-between">
              <div class="text-xl font-bold" v-if="hotels">{{ hotels.nom }}</div>
              <div class="text-yellow-400">★★★★</div>
            </div>
            <p class="text-gray-700 mt-2" v-if="hotels">
              {{ hotels.adreca }}
            </p>
            <p class="text-gray-700 mt-2" v-if="hotels">
              {{ hotels.ciutat }}, {{ hotels.pais }}
            </p>
            <p class="text-gray-900 font-semibold mt-2" v-if="habitacio">
              Habitació {{ habitacio.tipus }}
            </p>
            <p class="text-gray-600 text-sm mt-2" v-if="habitacio">
              Habitació {{ habitacio.tipus }} amb {{ habitacio.llits }} llits y {{ habitacio.llits_supletoris }} llits supletoris.
            </p>
            <p class="text-gray-600 text-sm mt-2" v-if="habitacio">
              {{ habitacio.preu }} € per nit
            </p>
            <p class="text-gray-600 text-sm mt-2" v-if="habitacio">
              {{ habitacio.llits + habitacio.llits_supletoris }} persones
            </p>
            <div class="px-6 pt-4 pb-2" v-if="habitacio">
              <span
                class="inline-block bg-green-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">✔
                Animals admesos</span>
              <span
                class="inline-block bg-green-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">✅
                WiFi gratis</span>
              <span
                class="inline-block bg-green-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">✅
                Aparcament</span>
            </div>
            <button class="mt-4 bg-blue-500 text-white py-2 px-4 rounded w-full" v-if="habitacio">
              Copia l'adreça
            </button>
            <p v-else>Cargando datos...</p>
          </div>
        </div>

        <!-- Tarjeta 2: Detalles de la Reserva -->
        <div class="col-span-1">
          <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="font-bold text-xl mb-4">Dades de la teva reserva</div>
            <div class="grid grid-cols-2 gap-4">
              <div>
                <p class="text-gray-700 font-semibold">Entrada</p>
                <p class="text-gray-600">
                  {{ startDate }}
                </p>
                <p class="text-gray-600">A partir de les 14:00</p>
              </div>
              <div>
                <p class="text-gray-700 font-semibold">Sortida</p>
                <p class="text-gray-600">
                  {{ endDate }}
                </p>
                <p class="text-gray-600">Fins a les 12:00</p>
              </div>
            </div>
            <p class="text-gray-700 mt-4">
              Durada total de l’estada: <span class="font-semibold">
                {{ diesTotals }} nits
              </span>
            </p>
          </div>
        </div>

        <!-- Tarjeta 3: Resumen del Pago -->
        <div class="col-span-1 md:col-span-1">
          <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="font-bold text-xl mb-4">Resum del que pagaràs</div>
            <div class="space-y-4" v-if="habitacio">
              <div class="flex justify-between">
                <p class="text-gray-700">Preu original</p>
                <p class="text-gray-700">{{ habitacio.preu * diesTotals }} €</p>
              </div>
              <div class="flex justify-between">
                <p class="text-gray-700">Descompte</p>
                <p class="text-green-500">- {{ ((habitacio.preu * diesTotals) / 100 * 30).toFixed(2) }} €</p>
              </div>
              <div class="border-t pt-4">
                <div class="flex justify-between">
                  <p class="text-gray-700 font-semibold">TOTAL</p>
                  <p class="text-2xl font-bold text-blue-500">{{ habitacio.preu * diesTotals - ((habitacio.preu *
                    diesTotals) /100 * 30) }} €</p>
                </div>
              </div>
            </div>
            <div v-else>
              <p class="text-gray-700">Cargando datos...</p>
            </div>
            <button class="mt-4 bg-blue-500 text-white py-2 px-4 rounded w-full">Pagar</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <Footer />
</template>

<style scoped>
/* CSS */
h3 {
  text-align: center;
  margin: 20px 0;
  font-size: 2rem;
  font-weight: 500;
  line-height: 1.5;
  color: #333;
  margin-bottom: 1.5rem;
}

button:hover {
  background-color: #2c5282;
}
</style>