<script setup>
import { ref, onMounted, computed } from 'vue'
import { useRoute } from 'vue-router'
import Header from '../components/HeaderStaticSection.vue'
import Footer from '../components/FooterSection.vue'

const API_URL = import.meta.env.VITE_API_URL
const route = useRoute()

const isLoading = ref(true)
const habitacio = ref(null)
const hotels = ref(null)
const dataActual = new Date().toLocaleDateString('es-ES', { year: 'numeric', month: '2-digit', day: '2-digit' })
const startDate = ref(localStorage.getItem('startDate'))
const endDate = ref(localStorage.getItem('endDate'))
const email = ref(localStorage.getItem('emailusuari'))

const diesTotals = computed(() => {
  if (startDate.value && endDate.value) {
    return Math.ceil((new Date(endDate.value) - new Date(startDate.value)) / (1000 * 60 * 60 * 24))
  }
  return 0
})

onMounted(() => {
  setTimeout(() => {
    isLoading.value = false
  }, 2000),
    fetch(`${API_URL}/v1/habitacions/${route.params.id}`)
      .then((response) => response.json())
      .then((data) => {
        habitacio.value = data
        fetch(`${API_URL}/v1/hotels/${habitacio.value.hotel_id}`)
          .then((response) => response.json())
          .then((data) => {
            hotels.value = data
          })
          .catch((error) => {
            console.error('Error fetching data:', error)
          })
      })
      .catch((error) => {
        console.error('Error fetching data:', error)
      })
})
</script>

<template>
  <main class="bg-white min-h-screen flex flex-col">
    <!-- Header -->
    <Header />

    <div class="flex flex-col items-center min-h-screen bg-gray-100 p-4">
      <div class="w-full max-w-lg bg-white rounded-2xl shadow-md p-6">
        <div class="flex flex-col items-center">
          <span class="material-symbols-outlined" style="color: green; font-size: 3rem;">
            check_circle
          </span>
          <h2 class="text-lg font-semibold">GRÀCIES PER LA TEVA COMANDA!</h2>
          <p class="text-gray-500 text-sm text-center">
            La teva confirmació de la comanda ha estat enviada al correu electrònic
            {{ email }}.
          </p>
        </div>
        <div class="mt-6">
          <h3 class="font-semibold">Data transacció</h3>
          <p class="text-gray-600">{{ dataActual }}</p>
        </div>
        <div class="mt-4">
          <h3 class="font-semibold">Mètode de pagament</h3>
          <p class="text-gray-600">Mastercard finalitzada en 2145</p>
        </div>
        <div class="mt-4 border-t pt-4">
          <h3 class="font-semibold">La teva reserva</h3>
          <div class="flex items-center mt-2">
            <div class="ml-4">
              <p class="font-medium" v-if="hotels">{{ hotels.nom }}</p>
              <p class="text-gray-700 mt-2" v-if="hotels">
                {{ hotels.adreca }}
              </p>
              <p class="text-gray-700 mt-2" v-if="hotels">{{ hotels.ciutat }}, {{ hotels.pais }}</p>
              <p class="text-gray-900 font-semibold mt-2" v-if="habitacio">
                Habitació {{ habitacio.tipus }}
              </p>
              <p class="text-gray-600 text-sm mt-2" v-if="habitacio">
                Habitació {{ habitacio.tipus }} amb {{ habitacio.llits }} llits y
                {{ habitacio.llits_supletoris }} llits supletoris.
              </p>

              <p class="text-gray-700 mt-4">Durada total de l’estada: {{ diesTotals }} nits</p>
            </div>
            <div class="flex-col items-center mt-2">
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
        </div>
        <div class="mt-4 border-t pt-4 text-right">
          <p class="text-2xl font-bold text-black-500" v-if="habitacio">
            {{
              (
                habitacio.preu * diesTotals -
                ((habitacio.preu * diesTotals) / 100) * 30
              ).toFixed(2)
            }}
            €
          </p>
        </div>
        <RouterLink to="/" class="mt-4 w-full">
          <button
            class="w-full mt-6 bg-orange-500 text-white py-2 rounded-lg font-medium hover:bg-orange-400 transition"
          >
            Torna a l'inici
          </button>
        </RouterLink>
      </div>
    </div>

    <!-- Overlay de carga -->
    <div
      v-if="isLoading"
      class="fixed inset-0 bg-white bg-opacity-90 flex items-center justify-center z-50"
    >
      <div
        class="w-10 h-10 border-4 border-t-indigo-500 border-gray-200 rounded-full animate-spin"
      ></div>
    </div>

    <!-- Footer -->
    <Footer />
  </main>
</template>

<style>
.loading-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(255, 255, 255, 0.8);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000;
}

.loading-spinner {
  border: 4px solid #f3f3f3;
  border-top: 4px solid #3498db;
  border-radius: 50%;
  width: 40px;
  height: 40px;
  animation: spin 1s linear infinite;
}

@keyframes spin {
  0% {
    transform: rotate(0deg);
  }

  100% {
    transform: rotate(360deg);
  }
}
</style>
