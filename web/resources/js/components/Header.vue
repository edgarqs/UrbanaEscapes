<template>
    <header class="bg-white shadow-md" id="toggle-element">
        <nav class="max-w-7xl mx-auto flex items-center justify-between p-4">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="#" class="text-xl font-bold text-gray-800"><img src="../public/urbana_logo.svg"
                        alt="logo urbana escapes"></a>
            </div>

            <!-- Search bar for desktop -->
            <div class="hidden lg:flex w-full max-w-md items-center mx-6">
                <input type="text" placeholder="Search..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none" />
            </div>

            <!-- Navigation and icons -->
            <div class="flex items-center space-x-6">
                <!-- Hamburger menu button -->
                <button @click="toggleMenu" class="block lg:hidden focus:outline-none text-gray-800"
                    aria-label="Toggle Menu">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <!-- Desktop nav links -->
                <div class="hidden lg:flex space-x-4">
                    <a href="#" class="text-gray-600 hover:text-gray-800">Home</a>
                    <a href="#" class="text-gray-600 hover:text-gray-800">About</a>
                    <a href="#" class="text-gray-600 hover:text-gray-800">Services</a>
                    <a href="#" class="text-gray-600 hover:text-gray-800">Contact</a>
                </div>

                <!-- Language selector -->
                <div class="relative">
                    <button @click="toggleLanguageDropdown"
                        class="flex items-center space-x-2 focus:outline-none text-gray-800"
                        aria-label="Select Language">
                        <img :src="currentLanguage.flag" alt="Language Flag" class="h-5 w-5 rounded-full" />
                        <span>{{ currentLanguage.label }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div v-if="languageDropdownOpen"
                        class="absolute right-0 mt-2 bg-white shadow-lg rounded-md p-2 z-10">
                        <button v-for="lang in languages" :key="lang.code" @click="changeLanguage(lang)"
                            class="flex items-center w-full space-x-2 px-4 py-2 hover:bg-gray-100 focus:outline-none">
                            <img :src="lang.flag" alt="Language Flag" class="h-5 w-5 rounded-full" />
                            <span>{{ lang.label }}</span>
                        </button>
                    </div>
                </div>

                <!-- Search Icon for mobile -->
                <button @click="toggleMobileSearch" class="block lg:hidden focus:outline-none text-gray-800"
                    aria-label="Search">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 1 1-14 0 7 7 0 0 1 14 0z" />
                    </svg>
                </button>
            </div>
        </nav>

        <!-- Mobile search bar -->
        <div v-if="mobileSearchOpen" class="p-4 bg-gray-100">
            <input type="text" placeholder="Search..."
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none" />
        </div>

        <!-- Mobile menu -->
        <div v-if="menuOpen" class="flex flex-col items-start space-y-2 bg-white shadow-md lg:hidden p-4">
            <a href="#" class="text-gray-600 hover:text-gray-800">Home</a>
            <a href="#" class="text-gray-600 hover:text-gray-800">About</a>
            <a href="#" class="text-gray-600 hover:text-gray-800">Services</a>
            <a href="#" class="text-gray-600 hover:text-gray-800">Contact</a>
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
            ],
        };
    },
    methods: {
        toggleMenu() {
            this.menuOpen = !this.menuOpen;
            this.mobileSearchOpen = false; // Close search bar if menu is opened
        },
        toggleMobileSearch() {
            this.mobileSearchOpen = !this.mobileSearchOpen;
            this.menuOpen = false; // Close menu if search bar is opened
        },
        toggleLanguageDropdown() {
            this.languageDropdownOpen = !this.languageDropdownOpen;
        },
        changeLanguage(lang) {
            this.currentLanguage = lang;
            this.languageDropdownOpen = false; // Close dropdown after selection
        },
    },
};

document.addEventListener("scroll", function () {
  const toggleElement = document.querySelector("#toggle-element");
  if (window.scrollY > 100) {
    // Mostrar cuando el scroll supera 100px
    toggleElement.style.display = "block";
  } else {
    // Ocultar cuando el scroll vuelve a menos de 100px
    toggleElement.style.display = "none";
  }
});
</script>

<style>
/* Add custom styles if needed */
header {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 1000;
    display: none;
}
</style>