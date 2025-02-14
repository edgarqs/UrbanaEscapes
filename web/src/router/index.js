'use strict'
import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import AboutView from '@/views/AboutView.vue'
import HabitacionsView from '@/views/HabitacionsView.vue'
import PoliticaView from '../views/PoliticaView.vue'
import CompraView from '../views/CompraView.vue'
import CondicionsView from '../views/CondicionsView.vue'
import ReservaView from '../views/ReservaView.vue'
import ReviewCompraView from '@/views/ReviewCompraView.vue'

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
    {
      path: '/reserva/:id',
      name: 'reserva',
      component: ReservaView,
    },
    {
      path: '/compra/:id',
      name: 'compra',
      component: CompraView,
    },
    {
      path: '/review-compra/:id',
      name: 'review-compra',
      component: ReviewCompraView,
    },
  ],
})

export default router
