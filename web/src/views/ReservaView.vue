<script setup>
import { ref, onMounted } from 'vue'
import { RouterLink, useRoute, useRouter } from 'vue-router'
import emailjs from 'emailjs-com'
import Header from '../components/HeaderStaticSection.vue'
import Footer from '../components/FooterSection.vue'

const API_URL = import.meta.env.VITE_API_URL

const habitacio = ref(null)
const hotels = ref(null)
const route = useRoute()
const router = useRouter()

const startDate = ref(localStorage.getItem('startDate'))
const endDate = ref(localStorage.getItem('endDate'))
const diesTotals = Math.ceil(
  (new Date(endDate.value) - new Date(startDate.value)) / (1000 * 60 * 60 * 24),
)

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

const generateToken = Math.floor(100000 + Math.random() * 900000)

const nom = ref('')
const email = ref('')
const token = ref(generateToken)

const mostrarReserva = ref(true)
const mostrarVerificacio = ref(false)
const codigoIngresado = ref('')
const errorMensaje = ref('')

const isLoading = ref(false)

const sendEmail = () => {
  isLoading.value = true

  const templateParams = {
    to_name: nom.value,
    to_email: email.value,
    token: token.value,
  }

  emailjs
    .send('service_sdxck6f', 'template_g6pkddi', templateParams, '7TB2Yf7rUGPIaApvH')
    .then(() => {
      mostrarReserva.value = false
      mostrarVerificacio.value = true
    })
    .catch((error) => {
      console.error('FAILED...', error)
    })
    .finally(() => {
      isLoading.value = false
    })
}

const verificarCodigo = () => {
  if (codigoIngresado.value == token.value) {
    router.push(`/compra/${habitacio.value.id}`)
  } else {
    errorMensaje.value = 'El código no es correcto. Inténtelo de nuevo.'
  }
}
</script>

<template>
  <main>
    <Header />

    <div
      v-if="mostrarReserva"
      class="reservas flex flex-col m-4 justify-center items-center mt-10 mb-20"
    >
      <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="detallsReserva md:col-span-2">
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
        <div class="md:col-span-2">
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

          <div class="bg-white rounded-lg shadow-lg p-6">
            <form @submit.prevent="sendEmail">
              <h2 class="text-2xl font-bold">{{ $t('dades-client-titol') }}</h2>
              <div class="form-group">
                <label for="to_name">Nom:</label>
                <input type="text" id="to_name" v-model="nom" required />
              </div>
              <div class="form-group">
                <label for="to_email">Correu electrònic:</label>
                <input type="email" id="to_email" v-model="email" required />
              </div>
              <button
                class="mt-4 bg-orange-500 hover:bg-orange-400 font-bold text-white py-2 px-4 rounded w-full"
                type="submit"
                :disabled="isLoading"
              >
                {{ $t('enviar-boton') }}
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div v-if="mostrarVerificacio" class="flex justify-center items-center bg-gray-100 p-4">
      <div
        class="verificacio bg-white shadow-lg rounded-lg p-6 w-full sm:w-96 text-center mt-20 mb-20"
      >
        <h2 class="text-2xl font-bold text-gray-700">{{ $t('titol-verificacio') }}</h2>
        <p class="text-gray-600 mt-2">
          Un correu electrònic ha estat enviat a <span class="font-semibold">{{ email }}</span> amb
          un codi de verificació.
        </p>
        <p class="text-gray-600 mt-1">
          Si us plau, introdueixi el codi de verificació per confirmar la seva reserva.
        </p>

        <input
          type="text"
          v-model="codigoIngresado"
          required
          class="mt-4 w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-orange-400"
          placeholder="Introduïu el codi"
        />

        <button
          class="mt-4 bg-orange-500 hover:bg-orange-400 font-bold text-white py-2 px-4 rounded w-full transition duration-300"
          @click="verificarCodigo"
        >
          {{ $t('verificar-boton') }}
        </button>

        <p v-if="errorMensaje" class="text-red-500 mt-2">{{ errorMensaje }}</p>
      </div>
    </div>

    <div v-if="isLoading" class="loading-overlay">
      <div class="loading-spinner"></div>
    </div>

    <Footer />
  </main>
</template>

<style scoped>
.form-group {
  margin-bottom: 1rem;
}

input {
  width: 100%;
  padding: 0.5rem;
  border: 1px solid #ccc;
}

.text-red-500 {
  color: red;
}

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