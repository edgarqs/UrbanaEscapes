<template>
  <div class="policy-section">
    <h1>{{ $t('privacitat') }}</h1>

    <h2>{{ $t('politica-introduccio') }}</h2>
    <p>{{ $t('politica-introduccio-descripcio') }}</p>

    <h2>{{ $t('politica-informacio') }}</h2>
    <p>{{ $t('politica-informacio-descripcio') }}</p>
    <ul>
      <li>{{ $t('politica-informacio-contacte') }}</li>
      <li>{{ $t('politica-informacio-demografica') }}</li>
      <li>{{ $t('politica-informacio-altres') }}</li>
    </ul>

    <h2>{{ $t('politica-us') }}</h2>
    <p>{{ $t('politica-us-descripcio') }}</p>
    <ul>
      <li>{{ $t('politica-us-serveis') }}</li>
      <li>{{ $t('politica-us-millorar') }}</li>
      <li>{{ $t('politica-us-promocions') }}</li>
      <li>{{ $t('politica-us-contacte') }}</li>
    </ul>

    <h2>{{ $t('politica-seguretat') }}</h2>
    <p>{{ $t('politica-seguretat-descripcio') }}</p>

    <h2>{{ $t('politica-cookies') }}</h2>
    <p>{{ $t('politica-cookies-descripcio') }}</p>

    <h2>{{ $t('politica-enllacos') }}</h2>
    <p>{{ $t('politica-enllacos-descripcio') }}</p>

    <h2>{{ $t('politica-control') }}</h2>
    <p>{{ $t('politica-control-descripcio') }}</p>
    <ul>
      <li>{{ $t('politica-control-formulari') }}</li>
      <li>{{ $t('politica-control-canvi') }}</li>
    </ul>

    <h2>{{ $t('politica-contacte') }}</h2>
    <p>{{ $t('politica-contacte-descripcio') }}</p>
  </div>
</template>

<style scoped>
.policy-section {
  font-family: Arial, sans-serif;
  margin: 20px;
  line-height: 1.6;
  color: #333;
}

.policy-section h1 {
  font-size: 2.5em;
  margin-bottom: 20px;
  color: #0056b3;
}

.policy-section h2 {
  font-size: 1.8em;
  margin-top: 20px;
  margin-bottom: 10px;
  color: #007bff;
}

.policy-section p {
  margin-bottom: 15px;
  font-size: 1.1em;
}

.policy-section ul {
  margin-left: 20px;
  list-style-type: disc;
}

.policy-section ul li {
  margin-bottom: 10px;
  font-size: 1.1em;
}
</style>