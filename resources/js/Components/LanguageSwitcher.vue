<template>
    <div class="relative inline-block text-left">
        <button
            @click="isOpen = !isOpen"
            class="inline-flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
        >
            <span class="mr-2">{{ currentLocaleInfo().nativeName }}</span>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </button>

        <div
            v-show="isOpen"
            @click.away="isOpen = false"
            class="absolute right-0 z-10 mt-2 w-48 origin-top-right bg-white border border-gray-200 rounded-md shadow-lg ring-1 ring-black ring-opacity-5"
        >
            <div class="py-1">
                <button
                    v-for="localeOption in availableLocales"
                    :key="localeOption.code"
                    @click="handleLanguageChange(localeOption.code)"
                    :class="[
                        'block w-full px-4 py-2 text-sm text-left hover:bg-gray-100',
                        locale === localeOption.code ? 'bg-gray-100 text-gray-900' : 'text-gray-700'
                    ]"
                >
                    <span class="font-medium">{{ localeOption.nativeName }}</span>
                    <span class="text-gray-500 ml-2">({{ localeOption.name }})</span>
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import { useLocale } from '@/composables/useLocale'

const isOpen = ref(false)
const { locale, changeLanguage, availableLocales, currentLocaleInfo } = useLocale()

const handleLanguageChange = async (newLocale) => {
    if (newLocale !== locale.value) {
        await changeLanguage(newLocale)
    }
    isOpen.value = false
}
</script>