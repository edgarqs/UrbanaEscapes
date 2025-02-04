<template>
  <div class="search-bar">
    <!-- Camp de destinació -->
    <div class="search-field">
      <label for="destination">{{ $t('cerca-destinacio')}}</label>
      <input
        type="text"
        id="destination"
        v-model="destination"
        placeholder="Ciutat, zona o hotel"
      />
    </div>

    <!-- Data d'inici -->
    <div class="search-field">
      <label for="start-date">{{ $t('cerca-inici')}}</label>
      <input type="date" id="start-date" v-model="startDate" :min="today" />
    </div>

    <!-- Data final -->
    <div class="search-field">
      <label for="end-date">{{ $t('cerca-final')}}</label>
      <input type="date" id="end-date" v-model="endDate" :min="startDate || today" />
    </div>

    <!-- Quantitat de persones -->
    <div class="search-field">
      <label for="people">{{ $t('cerca-persones')}}</label>
      <input type="number" id="people" v-model="people" min="1" placeholder="Nombre de persones" />
    </div>

    <!-- Botó de cerca -->
    <button class="search-button" @click="handleSearch">{{ $t('cerca-boto')}}</button>
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
    }
  },
  methods: {
    handleSearch() {
      // Validar que tots els camps estiguin omplerts
      if (!this.destination || !this.startDate || !this.endDate || !this.people) {
        alert('Si us plau, omple tots els camps.')
        return
      }

      // Redirigir a la pàgina d'habitacions disponibles (RW03)
      this.$emit('search', {
        destination: this.destination,
        startDate: this.startDate,
        endDate: this.endDate,
        people: this.people,
      })
    },
  },
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
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  max-width: 1000px;
  margin: 0 auto;
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

  &:hover {
    background-color: rgb(220, 100, 0);
  }
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
