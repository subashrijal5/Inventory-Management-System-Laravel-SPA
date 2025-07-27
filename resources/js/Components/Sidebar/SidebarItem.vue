<template>
    <li class="items-center">
        <Link
            :href="route(routeName)"
            class="text-xs uppercase py-3 font-bold block transition-all duration-300 relative group"
            :class="[
                route().current(routeName)
                    ? 'text-emerald-500 hover:text-emerald-600'
                    : 'text-blueGray-700 hover:text-blueGray-500',
                collapsed ? 'text-center px-2' : 'pl-12 pr-6'
            ]"
            :title="collapsed ? name : ''"
        >
            <i
                :class="[
                    icon,
                    'mr-2 text-sm transition-all duration-300',
                    route().current(routeName) ? 'opacity-75' : 'text-blueGray-300',
                    collapsed ? 'mr-0 text-base' : 'mr-2 text-sm'
                ]"
            ></i>
            <span 
                v-if="!collapsed" 
                class="transition-all duration-300"
            >
                {{ name }}
            </span>
            
            <!-- Tooltip for collapsed state -->
            <div 
                v-if="collapsed"
                class="absolute left-full ml-2 px-2 py-1 bg-gray-800 text-white text-xs rounded opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 whitespace-nowrap z-50"
            >
                {{ name }}
            </div>
        </Link>
    </li>
</template>

<script setup>
import {Link} from "@inertiajs/vue3";

const props = defineProps({
    name: {
        type: String,
        required: true,
    },
    routeName: {
        type: String,
        required: true,
    },
    icon: {
        type: String,
    },
    collapsed: {
        type: Boolean,
        default: false,
    },
});
</script>
