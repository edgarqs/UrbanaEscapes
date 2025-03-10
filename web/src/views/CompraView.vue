<script setup>
'use strict'
import { ref, onMounted, computed } from 'vue'
import { useRoute } from 'vue-router'
import Header from '../components/HeaderStaticSection.vue'
import Footer from '../components/FooterSection.vue'

const API_URL = import.meta.env.VITE_API_URL

const habitacio = ref(null)
const hotels = ref(null)
const route = useRoute()

const startDate = ref(localStorage.getItem('startDate'))
const endDate = ref(localStorage.getItem('endDate'))

const diesTotals = computed(() => {
  if (startDate.value && endDate.value) {
    return Math.ceil((new Date(endDate.value) - new Date(startDate.value)) / (1000 * 60 * 60 * 24))
  }
  return 0
})

onMounted(() => {
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

function copyAddress() {
  const address = `${hotels.value.adreca}, ${hotels.value.ciutat}, ${hotels.value.pais}`
  navigator.clipboard.writeText(address)
}

function formatDate(date) {
  const isoString = date.toISOString()
  const [datePart, timePart] = isoString.split('T')
  const [hour, minute, second] = timePart.split(':')
  const [sec, ms] = second.split('.')

  return `${datePart}T${hour}:${minute}:${sec}.000000Z`
}

const userID = ref(localStorage.getItem('userId'))
const idHabitacio = route.params.id
const dadesReserva = computed(() => ({
  habitacion_id: habitacio.value ? habitacio.value.id : null,
  usuari_id: userID.value,
  data_entrada: formatDate(new Date(startDate.value)),
  data_sortida: formatDate(new Date(endDate.value)),
  preu_total: habitacio.value
    ? (
        habitacio.value.preu * diesTotals.value -
        ((habitacio.value.preu * diesTotals.value) / 100) * 30
      ).toFixed(2)
    : 0,
  estat: 'Reservada',
}))

function crearReserva(data) {
  fetch(`${API_URL}/v1/reserves`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify(data),
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error('Network response was not ok')
      }
      return response.json()
    })
    .catch((error) => console.error('Error:', error))
}
</script>

<template>
  <Header />
  <div class="bg-gray-100 p-6 min-h-screen">
    <div class="container mx-auto px-4 max-w-4xl mt-10">
      <!-- Ajusta el ancho máximo del contenedor -->
      <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- Tarjeta 1: Información del Hotel -->
        <div class="md:col-span-2">
          <!-- Ocupa 2 columnas en pantallas medianas y grandes -->
          <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex items-center justify-between">
              <div class="text-xl font-bold" v-if="hotels">{{ hotels.nom }}</div>
              <div class="text-yellow-400">★★★★</div>
            </div>
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
            <p class="text-gray-600 text-sm mt-2" v-if="habitacio">
              {{ habitacio.preu }} € per nit
            </p>
            <p class="text-gray-600 text-sm mt-2" v-if="habitacio">
              {{ habitacio.llits + habitacio.llits_supletoris }} persones
            </p>
            <div class="px-6 pt-4 pb-2" v-if="habitacio">
              <span
                class="inline-block bg-green-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2"
                >✔ Animals admesos</span
              >
              <span
                class="inline-block bg-green-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2"
                >✅ WiFi gratis</span
              >
              <span
                class="inline-block bg-green-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2"
                >✅ Aparcament</span
              >
            </div>
            <button
              @click="copyAddress"
              class="mt-4 bg-orange-500 hover:bg-orange-400 font-bold text-white py-2 px-4 rounded w-full"
              v-if="habitacio"
            >
              {{ $t('boton-copia-adreca') }}
            </button>
            <p v-else>{{ $t('cargando-datos') }}</p>
          </div>
        </div>

        <!-- Tarjeta 2 y 3: Detalles de la Reserva y Resumen del Pago -->
        <div class="md:col-span-2">
          <!-- Ocupa 2 columnas en pantallas medianas y grandes -->
          <!-- Tarjeta 2: Detalles de la Reserva -->
          <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <div class="font-bold text-xl mb-4">{{ $t('dades-reserva-titol') }}</div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
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
              Durada total de l’estada: <span class="font-semibold"> {{ diesTotals }} nits </span>
            </p>
          </div>

          <!-- Tarjeta 3: Resumen del Pago -->
          <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="font-bold text-xl mb-4">{{ $t('resum-pagament-titol') }}</div>
            <div class="space-y-4" v-if="habitacio">
              <div class="flex justify-between">
                <p class="text-gray-700">Preu original</p>
                <p class="text-gray-700">{{ (habitacio.preu * diesTotals).toFixed(2) }} €</p>
              </div>
              <div class="flex justify-between">
                <p class="text-gray-700">Descompte</p>
                <p class="text-green-500">
                  - {{ (((habitacio.preu * diesTotals) / 100) * 30).toFixed(2) }} €
                </p>
              </div>
              <div class="border-t pt-4">
                <div class="flex justify-between">
                  <p class="text-gray-700 font-semibold">TOTAL</p>
                  <p class="text-2xl font-bold text-orange-500">
                    {{
                      (
                        habitacio.preu * diesTotals -
                        ((habitacio.preu * diesTotals) / 100) * 30
                      ).toFixed(2)
                    }}
                    €
                  </p>
                </div>
              </div>
            </div>
            <div v-else>
              <p class="text-gray-700">{{ $t('cargando-datos') }}</p>
            </div>
            <RouterLink :to="`/review-compra/${idHabitacio}`" class="mt-4 w-full">
              <button
                @click="crearReserva(dadesReserva)"
                class="bg-orange-500 hover:bg-orange-400 font-bold text-white py-2 px-4 rounded w-full"
              >
                {{ $t('boton-pagar') }}
              </button>
            </RouterLink>
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

.button-pagar {
  text-align: center;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
  width: 100%;
}

button {
  text-align: center;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
}
</style>
