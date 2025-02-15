<style scoped>
/* Estilos generales */
h1 {
  text-align: center;
  margin: 20px 0;
  font-size: 2.5rem;
  font-weight: 700;
  line-height: 1.5;
  color: #333;
  margin-bottom: 1.5rem;
}

h2 {
  font-size: 1.5rem;
  margin: 0.5rem 0;
  color: #555;
}

p {
  font-size: 1rem;
  margin: 0.5rem 0;
  color: #666;
}

/* Contenedor de las tarjetas */
.card-container {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 16px;

  @media screen and (max-width: 768px) {
    grid-template-columns: 1fr 1fr;
  }

  @media screen and (max-width: 580px) {
    grid-template-columns: 1fr;
  }
}

/* Estilo de las tarjetas */
.card {
  width: 100%;
  max-width: 520px;
  padding: 16px;
  background-color: #fff;
  border-radius: 8px;
  box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
  animation: fade-in linear both;
  /* view function */
  animation-timeline: view();
  animation-range: entry 10% entry 80%;
}

.card img {
  width: 100%;
  height: 200px;
  object-fit: cover;
  display: block;
}

/* Animaciones */
@keyframes scaleProgress {
  from {
    transform: scalex(0);
  }

  to {
    transform: scalex(100%);
  }
}

@keyframes fade-in {
  from {
    opacity: 0.3;
    transform: scale(0.9);
  }

  to {
    opacity: 1;
    transform: scale(1);
  }
}

/* Agregar padding al contenedor principal */
.section-container {
  padding: 20px 100px; /* Aumentar el padding en los lados */
}
</style>

<template>
  <section class="section-container">
    <h1>{{ $t('noticies-titol') }}</h1>
    <div class="card-container">
      <div class="card">
        <h2>{{ $t('noticia-1-titol') }}</h2>
        <img src="./img/noticia1.avif" alt="Resort en Bali" loading="lazy" />
        <p>
          {{ $t('noticia-1-descripcio') }}
        </p>
      </div>
      <div class="card">
        <h2>{{ $t('noticia-2-titol') }}</h2>
        <img src="./img/noticia2.avif" alt="Promoción romántica" loading="lazy" />
        <p>
          {{ $t('noticia-2-descripcio') }}
        </p>
      </div>
      <div class="card">
        <h2>{{ $t('noticia-3-titol') }}</h2>
        <img src="./img/noticia3.avif" alt="Renovación hotelera" loading="lazy" />
        <p>
          {{ $t('noticia-3-descripcio') }}
        </p>
      </div>
      <div class="card">
        <h2>{{ $t('noticia-4-titol') }}</h2>
        <img src="./img/noticia4.avif" alt="Sostenibilidad" loading="lazy" />
        <p>
          {{ $t('noticia-4-descripcio') }}
        </p>
      </div>
      <div class="card">
        <h2>{{ $t('noticia-5-titol') }}</h2>
        <img src="./img/noticia5.avif" alt="Foto hotel París" loading="lazy" />
        <p>
          {{ $t('noticia-5-descripcio') }}
        </p>
      </div>
      <div class="card">
        <h2>{{ $t('noticia-6-titol') }}</h2>
        <img src="./img/noticia6.avif" alt="Foto de platos de comida" loading="lazy" />
        <p>
          {{ $t('noticia-6-descripcio') }}
        </p>
      </div>
    </div>
  </section>
</template>

<script setup></script>
