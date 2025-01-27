<style scoped>
/* Add your styles here */
h1 {
    text-align: center;
    margin: 20px 0;
}

.cards {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-around;
    margin: 10px auto;
    padding: 30px;


}

.card {
    background-color: rgb(219, 213, 213);
}
h1{
    font-size: 2rem;
    font-weight: 700;
    line-height: 1.5;
    color: #333;
    margin-bottom: 1rem;
}
</style>

<template>
    <h1>Valors Corporatius</h1>
    <div class="cards">
        <div class="card max-w-sm rounded overflow-hidden shadow-lg">
            <div class="px-6 py-4">
                <img class="w-full h-full" src="./img/reunio.jpeg" alt="Reunio">
                <div class="font-bold text-xl mb-2 pt-4">La Nostra Història</div>
                <p class=" text-base">
                    La nostra cadena d’hotels va néixer amb l’objectiu de redefinir l’hospitalitat, oferint espais on
                    cada detall està pensat per garantir el màxim confort i benestar. Des dels inicis hem crescut amb
                    una filosofia clara: combinar elegància, calidesa i una atenció impecable per crear experiències
                    inoblidables. Amb presència en diverses destinacions, seguim fidels als nostres valors fundacionals,
                    esdevenint el refugi perfecte per als viatgers d’avui.
                </p>
            </div>
            <div class="px-6 pt-4 pb-2">
                <span
                    class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">#tradiciohotelera</span>
                <span
                    class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">#lanostrahistoria</span>
                <span
                    class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">#arrelsdhospitalitat</span>
            </div>
        </div>
        <div class=" card max-w-sm rounded overflow-hidden shadow-lg">
            <div class="px-6 py-4">
                <img class="w-full h-full" src="./img/placas.jpg" alt="Plaques solars">
                <div class="font-bold text-xl mb-2 pt-4">Els Nostres Valors</div>
                <p class="text-base">
                    <li>Sostenibilitat
                        <ul>Ens comprometem amb el planeta mitjançant pràctiques responsables, com la reducció de
                            residus, l’eficiència energètica i el suport a iniciatives locals de conservació.</ul>
                    </li>
                    <li>Atenció al Client
                        <ul>La satisfacció dels nostres hostes és la nostra prioritat. Oferim un servei personalitzat,
                            atent i proper, posant èmfasi en els petits detalls que marquen la diferència.</ul>
                    </li>
                    <li>Compromís amb les Comunitats
                        <ul>Cada hotel integra i reflecteix la cultura local, donant suport a empreses locals i
                            fomentant el desenvolupament de les comunitats on operem.</ul>
                    </li>
                </p>
            </div>
            <div class="px-6 pt-4 pb-2">
                <span
                    class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">#viatjarsostenible</span>
                <span
                    class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">#experiencialocal</span>
                <span
                    class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">#excel·lènciaenelservei</span>
            </div>
        </div>
        <div class="card max-w-sm rounded overflow-hidden shadow-lg">
            <div class="px-6 py-4 p">
                <img class="w-full" src="./img/hotel.jpg" alt="Habitacio de l'hotel">
                <div class="font-bold text-xl mb-2 pt-4">La Nostra Filosofia</div>
                <p class="text-base">
                <li>
                    Apostem per incorporar la tecnologia més avançada al servei de l’hospitalitat, sense perdre el
                    tracte humà.
                </li>
                <li>
                    Ens inspirem en la cultura, la gastronomia i l’essència de cada destinació per oferir experiències
                    autèntiques.
                </li>
                <li>
                    Ens esforcem per crear espais on cada hoste se senti com a casa, connectant amb les seves
                    necessitats i expectatives.
                </li>
                </p>
            </div>
            <div class="px-6 pt-4 pb-2">
                <span
                    class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">#viatjaambpropòsit</span>
                <span
                    class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">#innovacióhotelera</span>
                <span
                    class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">#sentircomacasa</span>
            </div>
        </div>
    </div>

</template>

<script setup></script>