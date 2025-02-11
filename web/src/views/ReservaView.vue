<script setup>
import { ref, onMounted } from 'vue';
import { RouterLink, useRoute, useRouter } from 'vue-router';
import emailjs from 'emailjs-com';
import Header from '../components/HeaderStaticSection.vue';
import Footer from '../components/FooterSection.vue';

const habitacio = ref(null);

const route = useRoute();
const router = useRouter();

const startDate = ref(localStorage.getItem('startDate'));
const endDate = ref(localStorage.getItem('endDate'));
const diesTotals = Math.ceil((new Date(endDate.value) - new Date(startDate.value)) / (1000 * 60 * 60 * 24));

onMounted(() => {
  fetch(`http://localhost:8000/api/v1/habitacions/${route.params.id}`)
    .then(response => response.json())
    .then(data => {
      habitacio.value = data;
    })
    .catch(error => {
      console.error('Error fetching data:', error);
    });
});

const generateToken = Math.floor(100000 + Math.random() * 900000);

const nom = ref('');
const email = ref('');
const token = ref(generateToken);


const mostrarReserva = ref(true);
const mostrarVerificacio = ref(false);
const codigoIngresado = ref('');
const errorMensaje = ref('');

const isLoading = ref(false);

const sendEmail = () => {
  isLoading.value = true;

  const templateParams = {
    to_name: nom.value,
    to_email: email.value,
    token: token.value
  };

  emailjs.send('service_ibvhq01', 'template_h2287v9', templateParams, 'RZvzJ3Yx8E4c1O3tK')
    .then((response) => {
      mostrarReserva.value = false;
      mostrarVerificacio.value = true;
    })
    .catch((error) => {
      console.error('FAILED...', error);
    })
    .finally(() => {
      isLoading.value = false;
    });
};

const verificarCodigo = () => {
  if (codigoIngresado.value == token.value) {
    router.push(`/compra/${habitacio.value.id}`);
  } else {
    errorMensaje.value = 'El código no es correcto. Inténtelo de nuevo.';
  }
};
</script>

<template>
  <main>
    <Header />
    <RouterLink to="/habitacions" class="mt-4 bg-blue-500 text-white py-2 px-4 rounded">Tornar</RouterLink>

    <div v-if="mostrarReserva" class="reservas flex flex-col m-4 justify-center items-center">
      <div class="flex justify-between p-4 px-8">
        <div class="detallsReserva">
          <div class="reserva" v-if="habitacio">
            <h2 class="text-2xl font-bold">Habitació {{ habitacio.tipus }}</h2>
            <p><strong>Descripció:</strong> Habitació {{ habitacio.tipus }} amb {{ habitacio.llits }} llits y {{
              habitacio.llits_supletoris }} llits supletoris.</p>
            <p><strong>Capacitat:</strong> {{ habitacio.llits + habitacio.llits_supletoris }} persones</p>
            <p><strong>Preu total:</strong> {{ habitacio.preu * diesTotals }} €</p>
            <p><strong>Data d'entrada:</strong> {{ startDate }}</p>
            <p><strong>Data de sortida:</strong> {{ endDate }}</p>
          </div>
          <div v-else>
            <p>Carregant dades de la habitació...</p>
          </div>
        </div>

        <div class="detallsClient">
          <form @submit.prevent="sendEmail">
            <h2 class="text-2xl font-bold">Dades del client</h2>
            <div class="form-group">
              <label for="to_name">Nom:</label>
              <input type="text" id="to_name" v-model="nom" required>
            </div>
            <div class="form-group">
              <label for="to_email">Correu electrònic:</label>
              <input type="email" id="to_email" v-model="email" required>
            </div>
            <button type="submit" :disabled="isLoading">Enviar</button>
          </form>
        </div>
      </div>
    </div>

    <div v-if="mostrarVerificacio" class="verificacio flex flex-col items-center">
      <h2 class="text-2xl font-bold">Verificació</h2>
      <p>Un correu electrònic ha estat enviat a {{ email }} amb un codi de verificació.</p>
      <p>Si us plau, introdueixi el codi de verificació per confirmar la seva reserva.</p>

      <input type="text" v-model="codigoIngresado" required>
      <button @click="verificarCodigo">Confirmar reserva</button>

      <p v-if="errorMensaje" class="text-red-500 mt-2">{{ errorMensaje }}</p>
    </div>

  
    <div v-if="isLoading" class="loading-overlay">
      <div class="loading-spinner"></div>
    </div>

    <Footer />
  </main>
</template>

<style scoped>
.detallsReserva,
.detallsClient {
  width: 50%;
}

.form-group {
  margin-bottom: 1rem;
}

.tornar {
  margin-top: 1rem;
}

input {
  width: 100%;
  padding: 0.5rem;
  border: 1px solid #ccc;
}

button {
  padding: 0.5rem 1rem;
  background-color: #3182ce;
  color: white;
  border: none;
  cursor: pointer;
}

button:hover {
  background-color: #2c5282;
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
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>
