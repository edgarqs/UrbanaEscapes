<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Anton&display=swap');

.oferta-container {
  position: relative;
  background-image: url('img/ofertas_fondo3.webp');
  background-size: cover;
  background-position: center;
  width: 100%;
  height: 400px;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  text-align: center;
  overflow: hidden;
  padding: 20px;
}

.oferta-container::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.226);
  z-index: 0;
}

h2,
h3,
button {
  position: relative;
  z-index: 1;
}

h2 {
  font-family: 'Anton', sans-serif;
  color: rgb(255, 136, 0);
  font-size: 50px;
  background-color: white;
  padding: 5px 15px;
  border-radius: 20px;
  transform: rotate(-5deg);
  display: inline-block;
  font-weight: bold;
  letter-spacing: 2px;
  margin-bottom: 50px;
}

h3 {
  color: white;
  font-size: 24px;
  margin-top: 10px;
}

button {
  margin-top: 15px;
  padding: 10px 20px;
  font-size: 18px;
  background-color: rgb(255, 136, 0);
  color: white;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  transition: 0.3s;
  font-weight: bold;

  &:hover {
    background-color: rgb(220, 100, 0);
  }
}

@media (max-width: 768px) {
  .background-image {
    height: 300px;
    padding: 10px;
  }

  h2 {
    font-size: 36px;
    padding: 5px 15px;
    border-radius: 5px;
    transform: rotate(-3deg);
  }

  h3 {
    font-size: 20px;
  }

  button {
    font-size: 16px;
    padding: 8px 16px;
  }
}

@media (max-width: 480px) {
  .background-image {
    height: 250px;
  }

  h2 {
    font-size: 28px;
    padding: 4px 10px;
    border-radius: 4px;
  }

  h3 {
    font-size: 18px;
  }

  button {
    font-size: 14px;
    padding: 6px 12px;
  }
}
</style>

<template>
  <div class="oferta-container">
    <h2>¡OFERTAS EXCLUSIVAS!</h2>
    <h3>Reserva ahora y ahorra hasta un 30%</h3>
    <button>VER OFERTAS</button>
  </div>
</template>
