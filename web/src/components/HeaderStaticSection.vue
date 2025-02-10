<template>
  <div>
    <!-- Header fijo -->
    <header class="bg-white shadow-md fixed top-0 left-0 w-full z-10 h-16"> <!-- Altura fija de 64px (h-16 en Tailwind) -->
      <nav class="max-w-7xl mx-auto flex items-center justify-between p-4 h-full">
        <!-- Logo -->
        <div class="flex items-center">
          <a href="#" class="text-xl font-bold text-gray-800">
            <img src="./img/urbana_logo-sinFondo.avif" alt="logo urbana escapes" class="logo" />
          </a>
        </div>

        <!-- Hamburger Menu Button -->
        <button @click="toggleMenu" class="lg:hidden text-gray-800 focus:outline-none">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
          </svg>
        </button>

        <!-- Navigation -->
        <div :class="{'block': menuOpen, 'hidden': !menuOpen}" class="lg:flex lg:items-center lg:justify-center lg:space-x-6 lg:static lg:bg-transparent lg:shadow-none lg:p-0 absolute top-16 left-0 w-full bg-white shadow-lg p-4 text-center">
          <RouterLink to="/" class="block lg:inline-block text-gray-600 hover:text-gray-800 px-3 py-1 rounded-full hover:bg-gray-100 transition duration-300">{{ $t('inici') }}</RouterLink>
          <RouterLink to="/about" class="block lg:inline-block text-gray-600 hover:text-gray-800 px-3 py-1 rounded-full hover:bg-gray-100 transition duration-300">{{ $t('sobre-nosaltres') }}</RouterLink>
          <RouterLink to="/login" class="block lg:inline-block text-gray-600 hover:text-gray-800 px-3 py-1 rounded-full hover:bg-gray-100 transition duration-300">Login</RouterLink>
        </div>

        <!-- Language selector -->
        <div class="relative hidden lg:block">
          <button @click="toggleLanguageDropdown" class="flex items-center space-x-2 px-3 py-1 bg-gray-100 text-gray-800 rounded-full hover:bg-gray-200 transition duration-300 focus:outline-none" aria-label="Select Language">
            <img :src="currentLanguage.flag" alt="Language Flag" class="h-5 w-5 rounded-full" />
            <span class="hidden lg:block">{{ currentLanguage.label }}</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
          </button>
          <div v-if="languageDropdownOpen" class="absolute right-0 mt-2 bg-white shadow-lg rounded-lg py-2 z-10 w-40">
            <button v-for="lang in languages" :key="lang.code" @click="changeLanguage(lang)" class="flex items-center w-full space-x-2 px-4 py-2 hover:bg-gray-100 text-gray-700 focus:outline-none transition duration-300">
              <img :src="lang.flag" alt="Language Flag" class="h-5 w-5 rounded-full" />
              <span>{{ lang.label }}</span>
            </button>
          </div>
        </div>
      </nav>
    </header>

    <!-- Espacio reservado para el contenido -->
    <div class="pt-16"> <!-- Padding-top igual a la altura del header -->
      <slot></slot> <!-- Aquí irá el contenido que pases al componente -->
    </div>
  </div>
</template>

<script>
import i18n from '../../plugins/i18n'

export default {
  name: 'HeaderStatic',
  data() {
    return {
      menuOpen: false,
      languageDropdownOpen: false,
      currentLanguage: {
        code: 'es',
        label: 'Español',
        flag: 'https://flagcdn.com/w320/es.png',
      },
      languages: [
        { code: 'es', label: 'Español', flag: 'https://flagcdn.com/w320/es.png' },
        { code: 'en', label: 'English', flag: 'https://flagcdn.com/w320/us.png' },
        { code: 'ca', label: 'Visca Catalunya', flag: 'https://upload.wikimedia.org/wikipedia/commons/thumb/c/ce/Flag_of_Catalonia.svg/320px-Flag_of_Catalonia.svg.png' },
      ],
    }
  },
  methods: {
    toggleMenu() {
      this.menuOpen = !this.menuOpen;
    },
    toggleLanguageDropdown() {
      this.languageDropdownOpen = !this.languageDropdownOpen;
    },
    changeLanguage(lang) {
      this.currentLanguage = lang;
      i18n.global.locale.value = lang.code;
      this.languageDropdownOpen = false;
    }
  }
}
</script>

<style scoped>
.logo {
  width: auto;
  height: 50px;
}
</style>