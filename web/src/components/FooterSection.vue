<style scoped>
/* Estilos base para el layout */
body,
html {
  height: 100%; /* Ocupa el 100% de la ventana */
  margin: 0;
}

#app {
  display: flex;
  flex-direction: column;
  min-height: 100%; /* Asegura que el contenedor principal llene el espacio */
}

/* Footer */
footer {
  background: #ffffff; /* Fondo blanco */
  color: #333333; /* Texto gris oscuro */
  flex-shrink: 0; /* Evita que el footer se comprima */
  border-top: 1px solid #e5e5e5; /* Línea sutil para separar */
}

a {
  transition: color 0.3s ease;
  color: #333333;
}
a:hover {
  color: #007bff; /* Efecto hover en azul */
}
</style>

<template>
  <div id="app">
    <!-- Contenido principal -->
    <main class="flex-grow">
      <!-- Aquí puedes colocar el contenido de la página -->
    </main>

    <!-- Footer -->
    <footer class="py-10">
      <div class="max-w-screen-xl mx-auto px-6">
        <div class="grid lg:grid-cols-3 sm:grid-cols-1 gap-8">
          <!-- Información de contacto -->
          <div>
            <h3 class="text-lg font-semibold mb-4">UrbanaEscapes</h3>
            <p class="text-sm">Carrer de les Closes, 120</p>
            <p class="text-sm">Terrassa, 08221</p>
            <p class="text-sm">contactans@urbanaescapes.com</p>
            <p class="text-sm">+34 640 99 81 89</p>
          </div>

          <!-- Políticas -->
          <div>
            <h3 class="text-lg font-semibold mb-4">{{ $t('politiques') }}</h3>
            <ul class="space-y-2">
              <li><a href="condicions" class="text-sm">{{ $t('condicions-us') }}</a></li>
              <li><a href="politica" class="text-sm">{{ $t('privacitat') }}</a></li>
            </ul>
          </div>

          <!-- Redes sociales -->
          <div>
            <h3 class="text-lg font-semibold mb-4">{{ $t('xarxes') }}</h3>
            <ul class="flex space-x-4">
              <li>
                <a href="https://www.youtube.com/@airbnb" class="text-sm">
                  <img
                    src="https://cdn-icons-png.flaticon.com/512/174/174883.png"
                    alt="YouTube"
                    class="w-5 h-5 inline-block mr-2"
                  />
                  YouTube
                </a>
              </li>
              <li>
                <a href="https://www.tiktok.com/@airbnb?lang=es" class="text-sm">
                  <img
                    src="https://cdn-icons-png.flaticon.com/512/3116/3116491.png"
                    alt="TikTok"
                    class="w-5 h-5 inline-block mr-2"
                  />
                  TikTok
                </a>
              </li>
              <li>
                <a href="https://www.facebook.com/AirbnbEspana/?locale=es_ES" class="text-sm">
                  <img
                    src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/b8/2021_Facebook_icon.svg/1200px-2021_Facebook_icon.svg.png"
                    alt="Facebook"
                    class="w-5 h-5 inline-block mr-2"
                  />
                  Facebook
                </a>
              </li>
            </ul>
          </div>
        </div>

        <!-- Separador -->
        <hr class="my-8 border-orange-300" />

        <!-- Créditos -->
        <div class="text-center text-sm text-gray-500">
          Copyright © 2024 UrbanaEscapes - Pol González - Edgar Quirante - Jon Perea
        </div>
      </div>
    </footer>
  </div>
</template>

<script setup></script>
