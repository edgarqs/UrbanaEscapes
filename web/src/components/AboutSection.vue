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
  height: 200px;
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
      <a href="https://pgonzalez.info/" class="card" target="_blank">
        <div class="card-image">
          <img
            src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTkGoDqDQkEQHZa5AuEarpjS3kcC9aSbEXJyg&s"
            alt="Foto del Pol González"
          />
        </div>
        <div class="card-body">
          <h2>Pol González</h2>
        </div>
      </a>

      <a href="https://portfolio.edgarqs.dev/" class="card" target="_blank">
        <div class="card-image">
          <img
            src="https://plus.unsplash.com/premium_photo-1689568158814-3b8e9c1a9618?fm=jpg&q=60&w=3000&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MXx8cGVyc29uYXxlbnwwfHwwfHx8MA%3D%3D"
            alt="Foto del Edgar Quirante"
          />
        </div>
        <div class="card-body">
          <h2>Edgar Quirante</h2>
        </div>
      </a>

      <a href="https://portfolio3.com" class="card" target="_blank">
        <div class="card-image">
          <img
            src="https://images.pexels.com/photos/1222271/pexels-photo-1222271.jpeg?cs=srgb&dl=pexels-justin-shaifer-501272-1222271.jpg&fm=jpg"
            alt="Foto del Jon Perea"
          />
        </div>
        <div class="card-body">
          <h2>Jon Perea</h2>
        </div>
      </a>
    </div>
  </div>
</template>

<script setup></script>
