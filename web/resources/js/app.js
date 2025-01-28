import './bootstrap';
import { createApp } from 'vue';
import App from './components/Hero.vue';
import Header from './components/Header.vue';
import Vcorpo from './components/ValorsCorporatius.vue';
import hotels from './components/Hotels.vue';
import footer from './components/Footer.vue';
import ofertas from './components/Ofertas.vue';

createApp(Header).mount('#header');
createApp(App).mount('#hero');
createApp(Vcorpo).mount('#valorscorporatius');
createApp(hotels).mount('#hotels');
createApp(ofertas).mount('#ofertas');
createApp(footer).mount('#footer');

