import { createI18n } from 'vue-i18n'
import en from '../lang/en.json'
import es from '../lang/es.json'
import ca from '../lang/ca.json'

const messages = {
  en,
  es,
  ca,
}

const i18n = createI18n({
  legacy: false,
  locale: 'es', // Idioma por defecto
  fallbackLocale: 'es', // Idioma de respaldo
  messages, // Traducciones
})

export default i18n
