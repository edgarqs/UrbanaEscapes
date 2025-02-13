<script setup>
import Header from '../components/HeaderSection.vue'
import Footer from '../components/FooterSection.vue'
</script>

<template>
  <main>
    <Header />

    <div v-if="isLoading" class="loading-overlay">
      <div class="loading-spinner"></div>
    </div>

    <Footer />
  </main>
</template>

<style scoped>
/* Estils */
</style>
