<style scoped>
.logo {
  width: 50%;
  height: auto;
  aspect-ratio: 2/1;
}
</style>

<template>
  <header class="bg-gray-50 shadow-md">
    <nav class="max-w-7xl mx-auto flex items-center justify-between p-4">
      <!-- Logo -->
      <div class="flex items-center">
        <a href="#" class="text-xl font-bold text-gray-800">
          <img src="./img/urbana_logo-sinFondo.avif" alt="logo urbana escapes" class="logo">
        </a>
      </div>

      <!-- Search bar for desktop -->
      <div class="hidden lg:flex w-full max-w-md items-center mx-6">
        <input type="text" placeholder="{{ __('search') }}"
          class="w-full px-4 py-2 border border-gray-300 rounded-full focus:ring-2 focus:ring-blue-500 focus:outline-none transition duration-300" />
      </div>

      <!-- Navigation and icons -->
      <div class="flex items-center space-x-6">
        <!-- Hamburger menu button -->
        <button @click="toggleMenu" class="block lg:hidden focus:outline-none text-gray-800" aria-label="Toggle Menu">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
          </svg>
        </button>

        <!-- Desktop nav links -->
        <div class="hidden lg:flex space-x-4">
          <a href="#"
            class="text-gray-600 hover:text-gray-800 px-3 py-1 rounded-full hover:bg-gray-100 transition duration-300">
            {{ __('home') }}
          </a>
          <a href="#"
            class="text-gray-600 hover:text-gray-800 px-3 py-1 rounded-full hover:bg-gray-100 transition duration-300">
            {{ __('about') }}
          </a>
          <a href="#"
            class="text-gray-600 hover:text-gray-800 px-3 py-1 rounded-full hover:bg-gray-100 transition duration-300">
            {{ __('services') }}
          </a>
          <a href="#"
            class="text-gray-600 hover:text-gray-800 px-3 py-1 rounded-full hover:bg-gray-100 transition duration-300">
            {{ __('contact') }}
          </a>
        </div>

        <!-- Language selector -->
        <div class="relative">
          <button @click="toggleLanguageDropdown"
            class="flex items-center space-x-2 px-3 py-1 bg-gray-100 text-gray-800 rounded-full hover:bg-gray-200 transition duration-300 focus:outline-none"
            aria-label="Select Language">
            <img :src="currentLanguage.flag" alt="Language Flag" class="h-5 w-5 rounded-full" />
            <!-- Hide language label in mobile -->
            <span class="hidden lg:block">{{ currentLanguage.label }}</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
          </button>
          <div v-if="languageDropdownOpen" class="absolute right-0 mt-2 bg-white shadow-lg rounded-lg py-2 z-10 w-40">
            <button v-for="lang in languages" :key="lang.code" @click="changeLanguage(lang)"
              class="flex items-center w-full space-x-2 px-4 py-2 hover:bg-gray-100 text-gray-700 focus:outline-none transition duration-300">
              <img :src="lang.flag" alt="Language Flag" class="h-5 w-5 rounded-full" />
              <span>{{ lang.label }}</span>
            </button>
          </div>
        </div>
      </div>
    </nav>

    <!-- Mobile menu -->
    <div v-if="menuOpen" class="flex flex-col items-start bg-white shadow-md lg:hidden p-4 space-y-3">
      <a href="#"
        class="text-gray-600 hover:text-gray-800 px-3 py-1 rounded-full hover:bg-gray-100 transition duration-300">Home</a>
      <a href="#"
        class="text-gray-600 hover:text-gray-800 px-3 py-1 rounded-full hover:bg-gray-100 transition duration-300">About</a>
      <a href="#"
        class="text-gray-600 hover:text-gray-800 px-3 py-1 rounded-full hover:bg-gray-100 transition duration-300">Services</a>
      <a href="#"
        class="text-gray-600 hover:text-gray-800 px-3 py-1 rounded-full hover:bg-gray-100 transition duration-300">Contact</a>
    </div>
  </header>
</template>

<script>
export default {
  name: "Navbar",
  data() {
    return {
      menuOpen: false,
      mobileSearchOpen: false,
      languageDropdownOpen: false,
      currentLanguage: {
        code: "es",
        label: "Español",
        flag: "https://flagcdn.com/w320/es.png",
      },
      languages: [
        { code: "es", label: "Español", flag: "https://flagcdn.com/w320/es.png" },
        { code: "en", label: "English", flag: "https://flagcdn.com/w320/us.png" },
        {
          code: "ca",
          label: "Visca Catalunya",
          flag: "https://upload.wikimedia.org/wikipedia/commons/thumb/c/ce/Flag_of_Catalonia.svg/320px-Flag_of_Catalonia.svg.png"
        },
      ],
    };
  },
  methods: {
    toggleMenu() {
      this.menuOpen = !this.menuOpen;
      this.mobileSearchOpen = false;
    },
    toggleMobileSearch() {
      this.mobileSearchOpen = !this.mobileSearchOpen;
      this.menuOpen = false;
    },
    toggleLanguageDropdown() {
      this.languageDropdownOpen = !this.languageDropdownOpen;
    },
    changeLanguage(lang) {
      this.currentLanguage = lang;
      this.languageDropdownOpen = false;
    },
  },
};
</script>
