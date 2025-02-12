<script>
export default {
  data() {
    return {
      habitacions: [],
      groupedHabitacions: {},
      // Objeto con las URLs de las imágenes según el tipo de habitación
      roomImages: {
        Estandar: [
          'https://i.postimg.cc/7Zypcg6c/estandar1.jpg',
          'https://i.postimg.cc/R0S2C4wL/estandar2.jpg',
        ],
        Deluxe: [
          'https://i.postimg.cc/bvmWsWTc/deluxe1.jpg',
          'https://i.postimg.cc/rmzbWjnd/deluxe2.jpg',
        ],
        Suite: [
          'https://i.postimg.cc/B6yzCFkm/suite1.jpg',
          'https://i.postimg.cc/1Xqj7tZs/suite2.jpg',
        ],
        Adaptada: ['https://i.postimg.cc/tRZw4rnw/adaptada1.jpg'],
      },
    }
  },
  computed: {
    numNights() {
      const query = this.$route.query
      if (!query.startDate || !query.endDate) return 1

      const start = new Date(query.startDate)
      const end = new Date(query.endDate)
      const diffTime = end - start
      const diffDays = Math.max(diffTime / (1000 * 60 * 60 * 24), 1) // Mínimo 1 noche

      return diffDays
    },
    numPeople() {
      const query = this.$route.query
      return parseInt(query.people) || 1 // Asegurarse de que siempre haya al menos 1 persona
    },
  },
  mounted() {
    const query = this.$route.query
    fetch('http://localhost:8000/api/v1/habitacions')
      .then((response) => {
        if (!response.ok) {
          throw new Error('Failed to fetch data')
        }
        return response.json()
      })
      .then((data) => {
        if (data && data.length > 0) {
          this.habitacions = data
          this.filterHabitacions(query)
        } else {
          document.querySelector('#error-message').classList.remove('hidden')
        }
      })
      .catch((error) => {
        console.error('Error fetching data:', error)
        document.querySelector('#error-message').classList.remove('hidden')
      })
  },
  methods: {
    // Función para obtener la imagen aleatoria según el tipo de habitación
    getImageForRoomType(tipus) {
      const images = this.roomImages[tipus]
      if (images) {
        const randomIndex = Math.floor(Math.random() * images.length)
        return images[randomIndex]
      }
      // Imagen por defecto si no se encuentra el tipo de habitación
      return 'https://i.postimg.cc/d3V2vht7/default-room.jpg'
    },

    filterHabitacions(query) {
      const { destination, startDate, endDate, people } = query
      const start = new Date(startDate)
      const end = new Date(endDate)

      // Guardar las fechas en localStorage
      localStorage.setItem('startDate', query.startDate)
      localStorage.setItem('endDate', query.endDate)
      localStorage.setItem('numPeople', query.people)

      fetch('http://localhost:8000/api/v1/reserves')
        .then((response) => response.json())
        .then((reserves) => {
          const reservedHabitacions = reserves
            .filter((reserva) => {
              const reservaStart = new Date(reserva.data_entrada)
              const reservaEnd = new Date(reserva.data_sortida)
              return start <= reservaEnd && end >= reservaStart
            })
            .map((reserva) => reserva.habitacion_id)

          const uniqueHabitacions = {}
          const filteredHabitacions = this.habitacions.filter((habitacio) => {
            const isAvailable = !reservedHabitacions.includes(habitacio.id)
            const matchesDestination = this.matchDestination(habitacio, destination)
            const matchesCapacity = habitacio.llits + habitacio.llits_supletoris >= people

            // Excluir habitaciones con estado "Bloquejada"
            const isBlocked = habitacio.estat === 'Bloquejada'

            if (isAvailable && matchesDestination && matchesCapacity && !isBlocked) {
              const key = `${habitacio.hotel_id}-${habitacio.tipus}`
              if (!uniqueHabitacions[key]) {
                uniqueHabitacions[key] = habitacio
                return true
              }
            }
            return false
          })

          // Orden de prioridad de los tipos de habitación
          const tipusOrder = ['Estandar', 'Deluxe', 'Suite', 'Adaptada']

          // Ordenar habitaciones según el tipo
          const sortedHabitacions = filteredHabitacions.sort((a, b) => {
            return tipusOrder.indexOf(a.tipus) - tipusOrder.indexOf(b.tipus)
          })

          // Agrupar habitaciones por hotel
          this.groupedHabitacions = sortedHabitacions.reduce((acc, habitacio) => {
            if (!acc[habitacio.hotel_id]) {
              acc[habitacio.hotel_id] = []
            }
            acc[habitacio.hotel_id].push(habitacio)
            return acc
          }, {})
        })
    },

    matchDestination(habitacio, destination) {
      const searchString = destination.trim().toLowerCase()
      const hotelDetails = [habitacio.hotel.adreca, habitacio.hotel.ciutat, habitacio.hotel.pais]
        .map((detail) => detail.toLowerCase())
        .join(' ')

      return hotelDetails.includes(searchString)
    },
  },
  watch: {
    '$route.query': {
      handler(newQuery) {
        this.filterHabitacions(newQuery)
      },
      immediate: true,
    },
  },
}
</script>

<template>
  <div>
    <h1 class="text-3xl font-bold text-center mt-16 mb-8 text-gray-800">Habitacions Disponibles</h1>
    <div class="container mx-auto p-4">
      <div
        v-for="(habitacions, hotelId) in groupedHabitacions"
        :key="hotelId"
        class="mb-8 p-4 border border-gray-300 rounded-lg bg-gray-50 max-w-6xl mx-auto"
      >
        <div class="mb-4">
          <h2 class="text-2xl font-bold text-gray-800">{{ habitacions[0].hotel.nom }}</h2>
          <p class="text-sm text-gray-600">
            {{ habitacions[0].hotel.adreca }}, {{ habitacions[0].hotel.ciutat }},
            {{ habitacions[0].hotel.pais }}
          </p>
        </div>
        <div class="w-full flex flex-wrap gap-6">
          <div
            v-for="habitacio in habitacions"
            :key="habitacio.id"
            class="w-full flex bg-white shadow-lg rounded-lg overflow-hidden"
          >
            <div class="flex-shrink-0 w-1/3 h-56 overflow-hidden">
              <!-- Cambiar la imagen basada en el tipo de habitación -->
              <img
                :src="getImageForRoomType(habitacio.tipus)"
                :alt="`Habitación ${habitacio.id}`"
                class="w-full h-full object-cover transition-transform transform hover:scale-110"
              />
            </div>
            <div class="p-4 flex flex-col justify-between w-2/3">
              <h5 class="text-xl font-semibold">Habitació {{ habitacio.tipus }}</h5>
              <p class="text-sm text-gray-700">
                <strong>Descripció: </strong>Habitació {{ habitacio.tipus }} amb
                {{ habitacio.llits }} llits y {{ habitacio.llits_supletoris }} llits
                supletoris.<span v-if="habitacio.id % 2 === 0">
                  Balconada amb vistes exteriors.</span
                >
              </p>
              <p class="text-sm text-gray-700">
                <strong>Capacitat:</strong>
                {{ habitacio.llits + habitacio.llits_supletoris }} persones
              </p>
              <div class="flex justify-between items-center">
                <span class="text-xl font-bold text-orange-500">
                  {{ (habitacio.preu * numNights * numPeople).toFixed(2) }} €
                </span>
                <p class="text-s text-gray-500">
                  (Preu per {{ numNights }} nits i {{ numPeople }} persones)
                </p>
              </div>
              <RouterLink :to="`/reserva/${habitacio.id}`">
                <button
                  class="focus:outline-none text-white bg-orange-500 hover:bg-orange-400 focus:ring-4 font-medium rounded-lg text-sm px-5 py-2.5 mt-4 w-full cursor-pointer"
                >
                  Reservar
                </button>
              </RouterLink>
            </div>
          </div>
        </div>
      </div>
      <div
        id="error-message"
        class="alert alert-danger hidden bg-red-100 text-red-700 p-4 rounded-lg mt-4"
        role="alert"
      >
        No se ha podido conectar con el servidor. Por favor, inténtelo más tarde.
      </div>
    </div>
  </div>
</template>
