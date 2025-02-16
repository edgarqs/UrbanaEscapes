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
  margin: 0 auto;
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  grid-gap: 4em;
  justify-content: center;
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
  text-decoration: none;
  color: inherit;
}

.card:hover {
  transform: scale(1.05);
  box-shadow: 4px 4px 25px rgba(0, 0, 0, 0.2);
}

.card-image {
  display: block;
  width: 100%;
  height: 400px;
  overflow: hidden;
  position: relative;
}

.card-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  object-position: center;
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
    <h2 class="center">Nuestro Equipo</h2>

    <div class="card-list">
      <a href="https://pgonzalez.info" class="card" target="_blank">
        <div class="card-image">
          <img src="./img/Pol.png" alt="Foto del Pol González" />
        </div>
        <div class="card-body">
          <h2>Pol González</h2>
          <p>Descripció del Pol González</p>
        </div>
      </a>

      <a href="https://portfolio.edgarqs.dev/" class="card" target="_blank">
        <div class="card-image">
          <img src="./img/Edgar.png" alt="Foto del Edgar Quirante" />
        </div>
        <div class="card-body">
          <h2>Edgar Quirante</h2>
          <p>Descripción del Edgar Quirante.</p>
        </div>
      </a>

      <a href="https://jonjoestarr.github.io/CurriculumVitae/" class="card" target="_blank">
        <div class="card-image">
          <img src="./img/Jon.png" alt="Foto del Jon Perea" />
        </div>
        <div class="card-body">
          <h2>Jon Perea</h2>
          <p>Descripción del Jon Perea.</p>
        </div>
      </a>
    </div>
  </div>
</template>

<script setup></script>
