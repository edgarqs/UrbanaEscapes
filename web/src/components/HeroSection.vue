<script>
'use strict'
export default {
  name: 'HeroSection',
}
</script>
<template>
  <video loop muted autoplay playsinline poster="" class="background-video">
    <source src="./../video/videohotel.mp4" type="video/mp4" />
  </video>
</template>

<style scoped>
.background-video {
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
}

.page-hero {
  position: relative;
  overflow: hidden;
}

video[poster] {
  object-fit: cover;
  width: 100%;
  height: 100%;
}
</style>
