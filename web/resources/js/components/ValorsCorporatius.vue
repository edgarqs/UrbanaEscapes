<style scoped>


.card-list {
    width: 80%; /* Aumentar el ancho del contenedor */
    margin: 0 auto; /* Centrar horizontalmente */
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); /* Aumentar el ancho mínimo de las tarjetas */
    grid-gap: 4em; /* Espaciado entre las tarjetas */
    justify-content: center; /* Centrar las tarjetas en el contenedor */
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
    box-shadow: 4px 4px 25px rgba(0, 0, 0, 0.4);
    overflow: hidden;
    cursor: pointer;
    transition: transform 0.4s;
}

/*.card:hover {
    transform: scale(1.05);
    box-shadow: 4px 4px 25px rgba(0, 0, 0, 0.2);
}
*/

.card-image {
    display: block;
    width: 100%; /* Asegura que el div ocupe todo el ancho de la tarjeta */
    height: 200px; /* Ajusta según la altura deseada */
    overflow: hidden; /* Oculta las partes que excedan del contenedor */
    position: relative; /* Necesario para que las imágenes queden en su lugar */
}

.card-image img {
    width: 100%; /* La imagen ocupa el ancho del div */
    height: 100%; /* La imagen ocupa la altura del div */
    object-fit: cover; /* La imagen se recorta para llenar el contenedor proporcionalmente */
    object-position: center; /* Centra el recorte de la imagen */
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
    <h1>Valors Corporatius</h1>
    
    <div class="card-list">

        <div class="card">
            <div class="card-image">
                <img src="./img/reunio.jpeg" alt="London trip">
            </div>
            <div class="card-body">
                <h2>La Nostra Història</h2>
                <p>Des dels inicis, vam néixer amb la missió de redefinir l’hospitalitat, combinant elegància, confort i atenció al detall. Amb presència en diverses destinacions, seguim creant experiències inoblidables que són refugi per als viatgers d’avui.</p>
            </div>
        </div>

        <div class="card">
            <div class="card-image">
                <img src="./img/placas.jpg" alt="New York trip">
            </div>
            <div class="card-body">
                <h2>Els Nostres Valors</h2>
                <p><b>Sostenibilitat:</b> Reduïm residus, fomentem l’eficiència energètica i col·laborem amb iniciatives locals.</p>
                <p><b>Atenció al Client:</b> Servei personalitzat i atent, amb cura pels detalls que marquen la diferència.</p>
                <p><b>Compromís amb la Comunitat:</b> Integram la cultura local i donem suport al desenvolupament d’empreses i comunitats locals.</p>
            </div>
        </div>

        <div class="card">
            <div class="card-image">
                <img src="./img/hotel.jpg" alt="Marrakech trip">
            </div>
            <div class="card-body">
                <h2>La Nostra Filosofia</h2>
                <p>Cadena d’hotels amb l’objectiu de redefinir l’hospitalitat, combinant elegància, calidesa i atenció impecable per oferir experiències úniques en diverses destinacions.</p>
            </div>
        </div>
    </div>

</template>

<script setup></script>