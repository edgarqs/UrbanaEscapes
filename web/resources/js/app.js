import './bootstrap';
import { createApp } from 'vue';
import App from './components/Hero.vue';
import Header from './components/Header.vue';
import Vcorpo from './components/ValorsCorporatius.vue';
import footer from './components/Footer.vue';
import ofertas from './components/Ofertas.vue';
import noticies from './components/Noticies.vue';
import habitacionsdisponibles from './components/HabitacionsDispo.vue';
import SearchBar from './components/SearchBar.vue';


createApp(Header).mount('#header');
createApp(App).mount('#hero');
createApp(Vcorpo).mount('#valorscorporatius');
createApp(ofertas).mount('#ofertas');
createApp(footer).mount('#footer');
createApp(noticies).mount('#noticies');
createApp(habitacionsdisponibles).mount('#habitacionsdisponibles');
createApp(SearchBar).mount('#searchbar');
