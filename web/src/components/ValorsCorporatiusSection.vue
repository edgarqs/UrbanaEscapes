<style scoped>
h2 {
  text-align: center;
  margin: 20px 0;
  font-size: 2rem;
  font-weight: 700;
  line-height: 1.5;
  color: #333;
  margin-bottom: 1rem;
}

.content {
  margin: 4rem 0;

  h2 {
    margin-bottom: 2rem;
  }
}

.card-list {
  width: 80%;
  /* Aumentar el ancho del contenedor */
  margin: 0 auto;
  /* Centrar horizontalmente */
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  /* Aumentar el ancho mínimo de las tarjetas */
  grid-gap: 4em;
  /* Espaciado entre las tarjetas */
  justify-content: center;
  /* Centrar las tarjetas en el contenedor */
}

.card,
.card-body {
  display: flex;
  flex-direction: column;
  align-items: center;
}

.card {
  border-radius: 18px;
  background: #fff;
  box-shadow: 1px 1px 15px rgba(0, 0, 0, 0.4);
  overflow: hidden;
  transition: transform 0.4s;
}

/*.card:hover {
    transform: scale(1.05);
    box-shadow: 4px 4px 25px rgba(0, 0, 0, 0.2);
}
*/

.card-image {
  display: block;
  width: 100%;
  /* Asegura que el div ocupe todo el ancho de la tarjeta */
  height: 200px;
  /* Ajusta según la altura deseada */
  overflow: hidden;
  /* Oculta las partes que excedan del contenedor */
  position: relative;
  /* Necesario para que las imágenes queden en su lugar */
}

.card-image img {
  width: 100%;
  /* La imagen ocupa el ancho del div */
  height: 100%;
  /* La imagen ocupa la altura del div */
  object-fit: cover;
  /* La imagen se recorta para llenar el contenedor proporcionalmente */
  object-position: center;
  /* Centra el recorte de la imagen */
}

.card-body {
  padding: 20px 28px;
}

.card-body h2 {
  font-size: 1.8em;
  margin: 2px auto 12px;
}

.card-body p {
  color: gray;
  font-size: 1.1em;
  line-height: 22px;
  text-align: center;
}
</style>

<template>
  <div class="content">
    <h2 class="center">{{ $t('valors-titol')}}</h2>

    <div class="card-list">
      <div class="card">
        <div class="card-image">
          <img src="./img/reunio.jpeg" alt="London trip" />
        </div>
        <div class="card-body">
          <h2>{{ $t('valors-historia-titol') }}</h2>
          <p>
            {{ $t('valors-historia-descripcio') }}
          </p>
        </div>
      </div>

      <div class="card">
        <div class="card-image">
          <img src="./img/placas.jpg" alt="New York trip" />
        </div>
        <div class="card-body">
          <h2>{{ $t('valors-valors-titol') }}</h2>
          <p>
            {{ $t('valors-sostenibilitat') }}
          </p>
          <p>
            {{ $t('valors-atencio-client') }}
          </p>
          <p>
            {{ $t('valors-compromis-comunitat') }}
          </p>
        </div>
      </div>

      <div class="card">
        <div class="card-image">
          <img src="./img/hotel.jpg" alt="Marrakech trip" />
        </div>
        <div class="card-body">
          <h2>{{ $t('valors-filosofia-titol')}}</h2>
          <p>
            {{ $t('valors-filosofia-descripcio') }}
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup></script>
