import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import LoginView from '@/views/LoginView.vue'
import AboutView from '@/views/AboutView.vue'
import HabitacionsView from '@/views/HabitacionsView.vue'
import PoliticaView from '../views/PoliticaView.vue'
import CondicionsView from '../views/CondicionsView.vue'


const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView,
    },
    {
      path: '/about',
      name: 'about',
      component: AboutView,
    },
    {
      path: '/login',
      name: 'login',
      component: LoginView,
    },
    {
      path: '/habitacions',
      name: 'habitacions',
      component: HabitacionsView,

    },
    {
      path: '/politica',
      name: 'politica',
      component: PoliticaView,

    },
    {
      path: '/condicions',
      name: 'condicions',
      component: CondicionsView,
    },
  ],
})

export default router
