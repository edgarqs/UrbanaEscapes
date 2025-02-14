<template>
  <div>
    <!-- Header fijo -->
    <header class="bg-white shadow-md fixed top-0 left-0 w-full z-10 h-16">
      <!-- Altura fija de 64px (h-16 en Tailwind) -->
      <nav class="max-w-7xl mx-auto flex items-center justify-between p-4 h-full">
        <!-- Logo -->
        <div class="flex items-center">
          <a href="/" class="text-xl font-bold text-gray-800">
            <img src="./img/urbana_logo-sinFondo.avif" alt="logo urbana escapes" class="logo" />
          </a>
        </div>

        <!-- Desktop Navigation -->
        <div class="hidden lg:flex items-center justify-center flex-grow space-x-6">
          <a href="/" class="text-gray-800 hover:text-gray-600">{{ $t('inici') }}</a>
          <span class="text-orange-500">|</span>
          <a href="/about" class="text-gray-800 hover:text-gray-600">{{ $t('sobre-nosaltres') }}</a>
        </div>

        <div class="flex items-center space-x-4">
          <!-- Hamburger Menu Button -->
          <button @click="toggleMenu" class="lg:hidden text-gray-800 focus:outline-none">
            <svg
              class="w-6 h-6"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M4 6h16M4 12h16m-7 6h7"
              ></path>
            </svg>
          </button>

          <!-- Language selector -->
          <div class="relative">
            <button
              @click="toggleLanguageDropdown"
              class="flex items-center space-x-2 px-3 py-1 rounded-full hover:bg-gray-200 transition duration-300 focus:outline-none"
              :class="{
                'bg-gray-100 text-gray-800': scrolled,
                'bg-transparent text-black': !scrolled,
              }"
              aria-label="Select Language"
            >
              <img :src="currentLanguage.flag" alt="Language Flag" class="h-5 w-5 rounded-full" />
              <span class="hidden lg:block">{{ currentLanguage.label }}</span>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-4 w-4"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M19 9l-7 7-7-7"
                />
              </svg>
            </button>
            <div
              v-if="languageDropdownOpen"
              class="absolute right-0 mt-2 bg-white shadow-lg rounded-lg py-2 z-10 w-40"
            >
              <button
                v-for="lang in languages"
                :key="lang.code"
                @click="changeLanguage(lang)"
                class="flex items-center w-full space-x-2 px-4 py-2 hover:bg-gray-100 text-gray-700 focus:outline-none transition duration-300"
              >
                <img :src="lang.flag" alt="Language Flag" class="h-5 w-5 rounded-full" />
                <span>{{ lang.label }}</span>
              </button>
            </div>
          </div>
        </div>
      </nav>

      <!-- Mobile Menu -->
      <div v-if="menuOpen" class="lg:hidden absolute top-16 left-0 w-full bg-white shadow-lg z-10">
        <nav class="flex flex-col items-center space-y-4 p-4">
          <a href="/" class="text-gray-800 hover:text-gray-600">{{ $t('inici') }}</a>
          <a href="/about" class="text-gray-800 hover:text-gray-600">{{ $t('sobre-nosaltres') }}</a>
          <a href="/contact" class="text-gray-800 hover:text-gray-600">{{ $t('contacte') }}</a>
        </nav>
      </div>
    </header>

    <!-- Espacio reservado para el contenido -->
    <div class="pt-16"></div>
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
        {
          code: 'ca',
          label: 'Visca Catalunya',
          flag: 'https://upload.wikimedia.org/wikipedia/commons/thumb/c/ce/Flag_of_Catalonia.svg/320px-Flag_of_Catalonia.svg.png',
        },
      ],
    }
  },
  methods: {
    toggleMenu() {
      this.menuOpen = !this.menuOpen
    },
    toggleLanguageDropdown() {
      this.languageDropdownOpen = !this.languageDropdownOpen
    },
    changeLanguage(lang) {
      this.currentLanguage = lang
      i18n.global.locale.value = lang.code
      this.languageDropdownOpen = false
    },
  },
}
</script>

<style scoped>
.logo {
  width: auto;
  height: 50px;
}
.text-orange-500 {
  color: #ffa500; /* Ajusta este color según el color naranja principal de tu web */
}
</style>
