import { ref, watch } from 'vue'

const isCollapsed = ref(false)

// Initialize from localStorage
if (typeof window !== 'undefined') {
    const stored = localStorage.getItem('sidebar-collapsed')
    if (stored !== null) {
        isCollapsed.value = JSON.parse(stored)
    }
}

// Watch for changes and persist to localStorage
watch(isCollapsed, (newValue) => {
    if (typeof window !== 'undefined') {
        localStorage.setItem('sidebar-collapsed', JSON.stringify(newValue))
    }
}, { immediate: false })

export function useSidebar() {
    const toggleSidebar = () => {
        isCollapsed.value = !isCollapsed.value
    }

    const collapseSidebar = () => {
        isCollapsed.value = true
    }

    const expandSidebar = () => {
        isCollapsed.value = false
    }

    return {
        isCollapsed,
        toggleSidebar,
        collapseSidebar,
        expandSidebar
    }
}