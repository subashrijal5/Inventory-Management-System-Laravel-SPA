import { ref, watch } from 'vue'
import { useI18n } from 'vue-i18n'
import { usePage, router } from '@inertiajs/vue3'

export function useLocale() {
    const { locale } = useI18n()
    const page = usePage()
    
    // Sync Vue i18n locale with Laravel locale from Inertia props
    const syncLocale = () => {
        if (page.props.locale && page.props.locale !== locale.value) {
            locale.value = page.props.locale
            localStorage.setItem('locale', page.props.locale)
        }
    }
    
    // Change language function
    const changeLanguage = async (newLocale) => {
        try {
            // Update Vue i18n locale immediately for better UX
            locale.value = newLocale
            localStorage.setItem('locale', newLocale)
            
            // Send request to Laravel backend
            await router.post(route('language.change'), {
                locale: newLocale
            }, {
                preserveState: true,
                preserveScroll: true,
                only: ['locale'] // Only reload locale prop
            })
        } catch (error) {
            console.error('Failed to change language:', error)
            // Revert on error
            const previousLocale = page.props.locale || 'en'
            locale.value = previousLocale
            localStorage.setItem('locale', previousLocale)
        }
    }
    
    // Available languages
    const availableLocales = [
        { code: 'en', name: 'English', nativeName: 'English' },
        { code: 'ne', name: 'Nepali', nativeName: 'नेपाली' }
    ]
    
    // Get current locale info
    const currentLocaleInfo = () => {
        return availableLocales.find(l => l.code === locale.value) || availableLocales[0]
    }
    
    // Initialize sync on mount
    syncLocale()
    
    // Watch for changes in Inertia props
    watch(() => page.props.locale, syncLocale)
    
    return {
        locale,
        changeLanguage,
        availableLocales,
        currentLocaleInfo,
        syncLocale
    }
}