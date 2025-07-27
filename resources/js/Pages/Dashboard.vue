<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, useForm} from '@inertiajs/vue3';
import CardLineChart from "@/Components/Cards/CardLineChart.vue";
import CardBarChart from "@/Components/Cards/CardBarChart.vue";
import HeaderStats from "@/Components/Headers/HeaderStats.vue";
// import Datepicker from "@vuepic/vue-datepicker";
// import '@vuepic/vue-datepicker/dist/main.css';
import {watch} from "vue";

const props = defineProps({
    date: String,
    total_orders: Object,
    total_profit: Object,
    total_loss: Object,
    total_expense: Object,
    profit_line_chart: Object,
    orders_bar_chart: Object,
});

const form = useForm({
    date: props.date,
});

watch(() => form.date, async (newDateRange, oldDateRange) => {
    form.get(route('dashboard'), {
        preserveScroll: true,
    });
})
</script>

<template>
    <Head :title="$t('navigation.dashboard')" />

    <AuthenticatedLayout>
        <template #breadcrumb>
            <div class="flex items-center space-x-4">
                <span class="text-white text-sm">{{ $t('common.select_month') }}:</span>
                <input
                    type="month"
                    :placeholder="$t('common.select_month')"
                    v-model="form.date"
                    class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 relative bg-white rounded text-sm shadow outline-none focus:outline-none focus:ring w-full pl-10"
                />
            </div>
        </template>

        <template #headerState>
            <HeaderStats
                :total_orders="total_orders"
                :total_profit="total_profit"
                :total_loss="total_loss"
                :total_expense="total_expense"
            />
        </template>

        <div>
            <div class="flex flex-wrap">
                <div class="w-full xl:w-8/12 mb-12 xl:mb-0 px-4">
                    <CardLineChart
                        :profit_line_chart="profit_line_chart"
                    />
                </div>
                <div class="w-full xl:w-4/12 px-4">
                    <CardBarChart
                        :orders_bar_chart="orders_bar_chart"
                    />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
