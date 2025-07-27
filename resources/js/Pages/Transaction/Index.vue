<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3';
import CardTable from "@/Components/Cards/CardTable.vue";
import TableData from "@/Components/TableData.vue";
import {ref} from 'vue';
import {formatDatetime, getCurrency} from "@/Utils/Helper.js";
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

defineProps({
    filters: {
        type: Object
    },
    transactions: {
        type: Object
    },
});

const tableHeads = ref(['#', t('transaction.transaction_number'), t('transaction.order_number'), t('transaction.amount'), t('transaction.paid_through'), t('fields.created_at')]);
</script>

<template>
    <Head :title="$t('navigation.transactions')"/>

    <AuthenticatedLayout>
        <template #breadcrumb>
            {{ $t('navigation.transactions') }}
        </template>

        <div class="flex flex-wrap">
            <div class="w-full px-4">
                <CardTable
                    indexRoute="transactions.index"
                    :paginatedData="transactions"
                    :filters="filters"
                    :tableHeads="tableHeads"
                >
                    <template #cardHeader>
                        <div class="flex justify-between items-center">
                            <h4 class="text-2xl">{{ $t('common.apply_filters') }}({{transactions.total}})</h4>
                        </div>
                    </template>

                    <tr v-for="(transaction, index) in transactions.data" :key="transaction.id">
                        <TableData>
                            {{ (transactions.current_page * transactions.per_page) - (transactions.per_page - (index + 1)) }}
                        </TableData>
                        <TableData>{{ transaction.transaction_number }}</TableData>
                        <TableData>{{ transaction.order.order_number }}</TableData>
                        <TableData>{{ getCurrency() }}{{ transaction.amount }}</TableData>
                        <TableData>{{ transaction.paid_through }}</TableData>
                        <TableData>{{ formatDatetime(transaction.created_at) }}</TableData>
                    </tr>
                </CardTable>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
