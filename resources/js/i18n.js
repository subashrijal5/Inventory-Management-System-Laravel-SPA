import { createI18n } from 'vue-i18n'
import en from './locales/en.js'
import ne from './locales/ne.js'

const messages = {
    en,
    ne
}

// Get locale from Laravel (passed via Inertia) or fallback to localStorage or 'en'
const getInitialLocale = () => {
    // Check if we have access to Inertia page props
    if (typeof window !== 'undefined' && window.Laravel && window.Laravel.locale) {
        return window.Laravel.locale
    }
    
    // Fallback to localStorage or default
    return localStorage.getItem('locale') || 'en'
}

const i18n = createI18n({
    legacy: false, // Use Composition API mode
    locale: getInitialLocale(),
    fallbackLocale: 'en',
    messages
})

export default i18n