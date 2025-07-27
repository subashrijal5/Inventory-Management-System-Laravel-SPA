<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3';
import DataTable from "@/Components/DataTable.vue";
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

const props = defineProps({
    users: Object,
    filters: Object,
});

const tableHeads = [
    {
        name: t('fields.name'),
        key: 'name',
        sortable: true,
    },
    {
        name: t('fields.email'),
        key: 'email',
        sortable: true,
    },
    {
        name: t('user.email_verified_at'),
        key: 'email_verified_at',
        sortable: true,
    },
];
</script>

<template>
    <Head :title="$t('navigation.users')"/>

    <AuthenticatedLayout>
        <template #breadcrumb>
            {{ $t('navigation.users') }}
        </template>

        <div class="flex flex-wrap">
            <div class="w-full px-4">
                <DataTable
                    indexRoute="users.index"
                    :paginatedData="users"
                    :filters="filters"
                    :tableHeads="tableHeads"
                >
                    <template #cardHeader>
                        <div class="flex justify-between items-center">
                            <h4 class="text-2xl">{{ $t('common.apply_filters') }}({{users.total}})</h4>
                        </div>
                    </template>

                    <template #tableBody>
                        <tr v-for="(user, index) in users.data" :key="user.id">
                            <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left text-blueGray-700">
                                {{ (users.current_page * users.per_page) - (users.per_page - (index + 1)) }}
                            </td>
                            <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                {{ user.name }}
                            </td>
                            <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                {{ user.email }}
                            </td>
                            <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                <span v-if="user.email_verified_at" class="bg-emerald-500 text-white active:bg-emerald-600 text-xs font-bold uppercase px-3 py-1 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150">
                                    {{ $t('user.verified') }}
                                </span>
                                <span v-else class="bg-red-500 text-white active:bg-red-600 text-xs font-bold uppercase px-3 py-1 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150">
                                    {{ $t('user.unverified') }}
                                </span>
                            </td>
                        </tr>
                    </template>
                </DataTable>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
