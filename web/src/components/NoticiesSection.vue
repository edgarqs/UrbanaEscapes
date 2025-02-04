<style scoped>
h1 {
  text-align: center;
  margin: 20px 0;
  font-size: 2rem;
  font-weight: 700;
  line-height: 1.5;
  color: #333;
  margin-bottom: 1rem;
}

h2 {
  font-size: 20px;
  margin: 0;
}

p {
  font-size: 14px;
  margin: 0.5rem 0;
}

section {
  width: 100%;
  max-width: 800px;
  padding: 4rem 1rem;
  margin: 0 auto;
}

section img {
  width: 100%;
  max-width: 520px;
  height: 100%;
  max-height: 200px;
  object-fit: cover;
  margin: 1rem 0;
  display: block;
  border-radius: 8px;
  transform-origin: center;
}

.card-container {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 16px;

  @media screen and (max-width: 580px) {
    grid-template-columns: 1fr;
  }
}

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
</style>

<template>
  <section>
    <h1>{{ $t('noticies-titol')}}</h1>
    <div class="card-container">
      <div class="card">
        <h2>{{ $t('noticia-1-titol')}}</h2>
        <img
          src="https://images.unsplash.com/photo-1506748686214-e9df14d4d9d0?q=80&w=3072&auto=format&fit=crop&ixlib=rb-4.0.3"
          alt="Resort en Bali"
        />
        <p>
          {{ $t('noticia-1-descripcio')}}
        </p>
      </div>
      <div class="card">
        <h2>{{ $t('noticia-2-titol') }} </h2>
        <img
          src="https://images.unsplash.com/photo-1528909514045-2fa4ac7a08ba?q=80&w=3474&auto=format&fit=crop&ixlib=rb-4.0.3"
          alt="Promoción romántica"
        />
        <p>
          {{ $t('noticia-2-descripcio')}}
        </p>
      </div>
      <div class="card">
        <h2>{{ $t('noticia-3-titol')}}</h2>
        <img
          src="https://media.discordapp.net/attachments/974294400475738132/1333860959877595156/StayIn_Landing.jpg?ex=679a6e52&is=67991cd2&hm=f5bea5675c04e5cd2fce7dc157805a95a752f0d9ebe2502d9bc5dd5e5619d205&=&format=webp&width=885&height=498"
          alt="Renovación hotelera"
        />
        <p>
         {{ $t('noticia-3-descripcio')}}
        </p>
      </div>
      <div class="card">
        <h2>{{ $t('noticia-4-titol')}}</h2>
        <img
          src="https://skipper.org/cdn/shop/articles/eco_friendly_120cd6de-0473-47d2-bbf4-45f526c82391.png?v=1659684410&width=1920"
          alt="Sostenibilidad"
        />
        <p>
          {{ $t('noticia-4-descripcio')}}
        </p>
      </div>
    </div>
  </section>
</template>

<script setup></script>
