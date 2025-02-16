<template>
  <div class="terms-section">
    <h1>{{ $t('condicions-us') }}</h1>

    <h2>{{ $t('condicions-acceptacio') }}</h2>
    <p>{{ $t('condicions-acceptacio-descripcio') }}</p>

    <h2>{{ $t('condicions-modificacions') }}</h2>
    <p>{{ $t('condicions-modificacions-descripcio') }}</p>

    <h2>{{ $t('condicions-uso') }}</h2>
    <p>{{ $t('condicions-uso-descripcio') }}</p>

    <h2>{{ $t('condicions-propiedad') }}</h2>
    <p>{{ $t('condicions-propiedad-descripcio') }}</p>

    <h2>{{ $t('condicions-enlaces') }}</h2>
    <p>{{ $t('condicions-enlaces-descripcio') }}</p>

    <h2>{{ $t('condicions-limitacion') }}</h2>
    <p>{{ $t('condicions-limitacion-descripcio') }}</p>

    <h2>{{ $t('condicions-ley') }}</h2>
    <p>{{ $t('condicions-ley-descripcio') }}</p>

    <p>{{ $t('condicions-contacto') }}</p>
  </div>
</template>

<style scoped>
.terms-section {
  font-family: Arial, sans-serif;
  margin: 20px;
  line-height: 1.6;
  color: #333;
}

.terms-section h1 {
  font-size: 2.5em;
  margin-bottom: 20px;
  color: #0056b3;
}

.terms-section h2 {
  font-size: 1.8em;
  margin-top: 20px;
  margin-bottom: 10px;
  color: #007bff;
}

.terms-section p {
  margin-bottom: 15px;
  font-size: 1.1em;
}
</style>
