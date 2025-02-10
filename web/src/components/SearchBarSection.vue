<template>
  <div class="search-bar">
    <!-- Camp de destinació -->
    <div class="search-field">
      <label for="destination">{{ $t('cerca-destinacio') }}</label>
      <input
        type="text"
        id="destination"
        v-model="destination"
        placeholder="Ciutat, zona o hotel"
        @blur="checkField('destination')"
      />
      <p v-if="errors.destination" class="error-message">{{ $t('error-destinacio') }}</p>
    </div>

    <!-- Data d'inici -->
    <div class="search-field">
      <label for="start-date">{{ $t('cerca-inici') }}</label>
      <input
        type="date"
        id="start-date"
        v-model="startDate"
        :min="today"
        @change="validateStartDate"
        @blur="checkField('startDate')"
      />
      <p v-if="errors.startDate" class="error-message">{{ $t('error-start-date') }}</p>
    </div>

    <!-- Data final -->
    <div class="search-field">
      <label for="end-date">{{ $t('cerca-final') }}</label>
      <input
        type="date"
        id="end-date"
        v-model="endDate"
        :min="startDate || today"
        @change="validateEndDate"
        @blur="checkField('endDate')"
      />
      <p v-if="errors.endDate" class="error-message">{{ $t('error-end-date') }}</p>
    </div>

    <!-- Quantitat de persones -->
    <div class="search-field">
      <label for="people">{{ $t('cerca-persones') }}</label>
      <div class="people-input">
        <button @click="changePeople(-1)" :disabled="people <= 1">-</button>
        <input
          type="text"
          id="people"
          v-model="people"
          readonly
        />
        <button @click="changePeople(1)" :disabled="people >= 5">+</button>
      </div>
      <p v-if="errors.people" class="error-message">{{ $t('error-people') }}</p>
    </div>

    <!-- Botó de cerca -->
    <button 
      class="search-button" 
      @click="handleSearch"
      :disabled="isFormInvalid"
    >
      {{ $t('cerca-boto') }}
    </button>
  </div>
</template>

<script>
export default {
  name: 'SearchBar',
  data() {
    return {
      destination: '', // Destinació (ciutat, zona o hotel)
      startDate: '', // Data d'inici de la reserva
      endDate: '', // Data final de la reserva
      people: 1, // Quantitat de persones
      today: new Date().toISOString().split('T')[0], // Data actual per a validació
      errors: {
        destination: false,
        startDate: false,
        endDate: false,
        people: false
      }
    }
  },
  computed: {
    // Computed property per verificar si hi ha errors
    isFormInvalid() {
      return (
        this.errors.destination ||
        this.errors.startDate ||
        this.errors.endDate ||
        this.errors.people
      );
    }
  },
  methods: {
    handleSearch() {
      // Validar que tots els camps estiguin omplerts
      this.errors.destination = !this.destination;
      this.errors.startDate = !this.startDate;
      this.errors.endDate = !this.endDate;
      this.errors.people = this.people < 1 || this.people > 5;

      // Si hi ha errors, no continuar
      if (this.errors.destination || this.errors.startDate || this.errors.endDate || this.errors.people) {
        return; // Evitar l'enviament del formulari
      }

      // Redirigir a la pàgina d'habitacions disponibles (RW03)
      this.$router.push({
        name: 'habitacions',
        query: {
          destination: this.destination,
          startDate: this.startDate,
          endDate: this.endDate,
          people: this.people,
        },
      })
    },

    validateStartDate() {
      // Si la data d'inici és posterior a la data d'avui, mostrar error
      if (new Date(this.startDate) < new Date(this.today)) {
        this.errors.startDate = true;
      } else {
        this.errors.startDate = false;
      }
    },

    validateEndDate() {
      // Si la data final és anterior a la data d'inici, mostrar error
      if (this.endDate && new Date(this.endDate) < new Date(this.startDate)) {
        this.errors.endDate = true;
      } else {
        this.errors.endDate = false;
      }
    },

    checkField(field) {
      // Validar si el camp ha estat omplert correctament
      if (this[field] && this[field].trim() !== '') {
        this.errors[field] = false;
      } else {
        this.errors[field] = true;
      }
    },

    changePeople(amount) {
      // Canviar la quantitat de persones amb els botons
      const newPeople = this.people + amount;
      if (newPeople >= 1 && newPeople <= 5) {
        this.people = newPeople;
      }
    }
  }
}
</script>

<style scoped>
.search-bar {
  display: flex;
  flex-wrap: wrap;
  gap: 1rem;
  padding: 1.5rem;
  background-color: rgb(255, 255, 255);
  border-radius: 12px;
  max-width: 1000px;
  margin: 0 auto;
  z-index: 2;
  margin-top: 40px;
  border: 1px solid rgb(255, 136, 0);
}

.search-field {
  flex: 1;
  min-width: 200px;
}

.search-field label {
  display: block;
  margin-bottom: 0.5rem;
  font-weight: bold;
  color: #333;
}

.search-field input {
  width: 100%;
  padding: 0.75rem;
  border: 1px solid #ddd;
  border-radius: 8px;
  font-size: 1rem;
}

.people-input {
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.people-input button {
  padding: 0.5rem;
  background-color: #f1f1f1;
  border: 1px solid #ddd;
  border-radius: 8px;
  font-size: 1.25rem;
  cursor: pointer;
}

.people-input button:disabled {
  background-color: #ccc;
  cursor: not-allowed;
}

.people-input input {
  width: 50px;
  text-align: center;
  font-size: 1.25rem;
  border: 1px solid #ddd;
  padding: 0.5rem;
  border-radius: 8px;
}

.search-button {
  flex: 1;
  padding: 0.75rem;
  background-color: rgb(255, 136, 0);
  color: white;
  border: none;
  border-radius: 8px;
  font-size: 1rem;
  cursor: pointer;
  transition: background-color 0.3s ease;
  align-self: flex-end;
}

.search-button:disabled {
  background-color: #ccc;
  cursor: not-allowed;
}

.search-button:hover {
  background-color: rgb(220, 100, 0);
}

.error-message {
  color: red;
  font-size: 0.875rem;
  margin-top: 0.5rem;
}

@media (max-width: 768px) {
  .search-bar {
    flex-direction: column;
  }

  .search-button {
    width: 100%;
  }
}
</style>
