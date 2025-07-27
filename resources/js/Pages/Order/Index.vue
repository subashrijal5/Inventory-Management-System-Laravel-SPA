<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3';
import CardTable from "@/Components/Cards/CardTable.vue";
import TableData from "@/Components/TableData.vue";
import Button from "@/Components/Button.vue";
import InputError from "@/Components/InputError.vue";
import Modal from "@/Components/Modal.vue";
import {useForm} from '@inertiajs/vue3';
import {ref, computed} from 'vue';
import {formatDatetime, getCurrency, numberFormat, showToast, truncateString} from "@/Utils/Helper.js";
import TableHead from "@/Components/TableHead.vue";
import { useI18n } from 'vue-i18n';

defineProps({
    filters: {
        type: Object
    },
    orders: {
        type: Object
    },
    orderPaidByTypes: {
        type: Object
    },
});

const { t } = useI18n();

const selectedOrder = ref(null);
const showOrderItemsModal = ref(false);
const showPaymentModal = ref(false);
const showSettleModal = ref(false);
const tableHeads = computed(() => [
    t('fields.order_number'), 
    t('fields.customer'), 
    t('order.summary', { currency: getCurrency() }), 
    t('fields.paid'), 
    t('fields.due'), 
    t('fields.profit'), 
    t('fields.loss'), 
    t('fields.status'), 
    t('fields.date'), 
    t('fields.action')
]);

const form = useForm({
    amount: null,
    paid_through: 'cash',
});

const viewOrderItemsModal = (order) => {
    selectedOrder.value = order;
    showOrderItemsModal.value = true;
};

const payDueOrderModal = (order) => {
    selectedOrder.value = order;
    form.amount = order.due;
    showPaymentModal.value = true;
};
const payOrderDue = () => {
    form.put(route('orders.pay', selectedOrder.value.id), {
        preserveScroll: true,
        onSuccess: () => {
            closeModal();
            showToast();
        },
    });
};

const settleOrderModal = (order) => {
    selectedOrder.value = order;
    showSettleModal.value = true;
};
const settleDuePayment = () => {
    form.put(route('orders.settle', selectedOrder.value.id), {
        preserveScroll: true,
        onSuccess: () => {
            closeModal();
            showToast();
        },
    });
};

const closeModal = () => {
    showOrderItemsModal.value = false;
    showPaymentModal.value = false;
    showSettleModal.value = false;
};
</script>

<template>
    <Head :title="$t('navigation.orders')"/>

    <AuthenticatedLayout>
        <template #breadcrumb>
            {{ $t('navigation.orders') }}
        </template>

        <div class="flex flex-wrap">
            <div class="w-full px-4">
                <CardTable
                    indexRoute="orders.index"
                    :paginatedData="orders"
                    :filters="filters"
                    :tableHeads="tableHeads"
                >
                    <template #cardHeader>
                        <div class="flex justify-between items-center">
                            <h4 class="text-2xl">{{ $t('common.apply_filters') }}({{orders.total}})</h4>
                            <Button
                                :href="route('carts.index')"
                                buttonType="link"
                            >{{ $t('order.create_order') }}</Button>
                        </div>
                    </template>

                    <tr v-for="(order, index) in orders.data" :key="order.id">
                        <TableData>
                            <strong>#{{ order.order_number }}</strong>
                        </TableData>
                        <TableData>{{ order.customer ? order.customer.name : $t('common.unknown') }}</TableData>
                        <TableData class="text-start">
                            <span>{{ $t('order.sub_total') }}: {{ order.sub_total }}</span><br>
                            <span>{{ $t('order.tax') }}: {{ order.tax_total }}</span><br>
                            <span>{{ $t('order.discount') }}: {{ order.discount_total }}</span><br>
                            <span>{{ $t('order.total') }}: {{ order.total }}</span><br>
                        </TableData>
                        <TableData>{{ getCurrency() }}{{ order.paid }}</TableData>
                        <TableData>
                            <span :class="order.due > 0 ? 'text-red-500 text-xl font-bold' : ''">{{ getCurrency() }}{{ order.due }}</span>
                            <br>
                            <div class="flex" v-if="order.due > 0">
                                <Button
                                    @click="payDueOrderModal(order)"
                                    :title="$t('order.pay_due')"
                                    class="px-2"
                                >
                                    <i class="fa fa-money-bill-wave"></i>
                                </Button>
                                <Button
                                    @click="settleOrderModal(order)"
                                    type="red"
                                    class="px-2"
                                    :title="$t('order.settle')"
                                >
                                    <i class="fa fa-handshake"></i>
                                </Button>
                            </div>
                        </TableData>
                        <TableData :class="order.profit > 0 ? 'text-emerald-500 font-bold' : ''">{{ getCurrency() }}{{ order.profit }}</TableData>
                        <TableData :class="order.loss > 0 ? 'text-red-500 font-bold' : ''">{{ getCurrency() }}{{ order.loss }}</TableData>
                        <TableData>
                            <span v-if="order.status === 'paid'" class="text-xs font-semibold inline-block py-1 px-2 rounded text-emerald-600 bg-emerald-200">{{ $t('status.paid') }}</span>
                            <span v-else-if="order.status === 'partial_paid'" class="text-xs font-semibold inline-block py-1 px-2 rounded text-amber-600 bg-amber-200">{{ $t('status.partial_paid') }}</span>
                            <span v-else-if="order.status === 'over_paid'" class="text-xs font-semibold inline-block py-1 px-2 rounded text-purple-600 bg-purple-200">{{ $t('status.over_paid') }}</span>
                            <span v-else-if="order.status === 'unpaid'" class="text-xs font-semibold inline-block py-1 px-2 rounded text-red-600 bg-red-200">{{ $t('status.unpaid') }}</span>
                            <span v-else class="text-xs font-semibold inline-block py-1 px-2 rounded text-blue-600 bg-blue-200">{{ $t('status.settled') }}</span>
                        </TableData>
                        <TableData>{{ formatDatetime(order.created_at) }}</TableData>
                        <TableData>
                            <Button @click="viewOrderItemsModal(order)" :title="$t('order.order_items')">
                                <i class="fa fa-list"></i>
                            </Button>
<!--                            <Button-->
<!--                                :href="route('orders.show', order.id)"-->
<!--                                buttonType="link"-->
<!--                                preserveScroll-->
<!--                            >-->
<!--                                <i class="fa fa-eye"></i>-->
<!--                            </Button>-->
                        </TableData>
                    </tr>
                </CardTable>
            </div>
        </div>

        <!--Show order items data-->
        <Modal
            :title="$t('order.order_items_count', { count: selectedOrder?.order_items.length })"
            :show="showOrderItemsModal"
            @close="closeModal"
            maxWidth="4xl"
            :showSubmitButton="false"
        >
            <div class="relative flex flex-col min-w-0 break-words w-full mb-6 rounded bg-white">
                <div class="block w-full overflow-x-auto">
                    <!-- Projects table -->
                    <table class="items-center w-full bg-transparent border-collapse">
                        <thead>
                        <tr>
                            <TableHead>{{ $t('fields.product_name') }}</TableHead>
                            <TableHead>{{ $t('fields.product_number') }}</TableHead>
                            <TableHead>{{ $t('fields.product_code') }}</TableHead>
                            <TableHead>{{ $t('fields.price') }}</TableHead>
                            <TableHead>{{ $t('fields.quantity') }}</TableHead>
                            <TableHead>{{ $t('fields.action') }}</TableHead>
                        </tr>
                        </thead>
                        <tbody>

                        <tr v-for="(orderItem, index) in selectedOrder.order_items" :key="orderItem.id">
                            <TableData class="text-left flex items-center" :title="orderItem.product_json.name">
                                <img
                                    :src="orderItem.product_json.photo"
                                    class="h-12 w-12 bg-white rounded-full border"
                                    :alt="$t('common.inventory_management_system')"
                                />
                                <span class="ml-3 font-bold text-blueGray-600">{{ truncateString(orderItem.product_json.name, 15) }}</span>
                            </TableData>
                            <TableData>{{ orderItem.product_json.product_number }}</TableData>
                            <TableData>{{ orderItem.product_json.product_code }}</TableData>
                            <TableData>
                                {{ $t('order.buying') }}: <strong>{{ getCurrency() }}{{ orderItem.product_json.buying_price }}</strong>
                                <br>
                                {{ $t('order.selling') }}: <strong>{{getCurrency() }}{{ orderItem.product_json.selling_price }}</strong>
                            </TableData>
                            <TableData>
                                <strong>{{ numberFormat(orderItem.quantity) }}{{ orderItem.product?.unit_type?.symbol }}</strong>
                            </TableData>
                            <TableData>
                                <Button
                                    v-if="orderItem.product_id"
                                    :href="route('products.edit', orderItem.product_id)"
                                    buttonType="link"
                                    preserveScroll
                                >
                                    <i class="fa fa-eye"></i>
                                </Button>
                            </TableData>
                        </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </Modal>

        <!--Pay due-->
        <Modal
            :title="$t('order.pay_due')"
            :show="showPaymentModal"
            :formProcessing="form.processing"
            @close="closeModal"
            @submitAction="payOrderDue"
            maxWidth="sm"
        >
            <div>
                <div class="flex mt-1">
                    <select
                        id="paid_through"
                        v-model="form.paid_through"
                        class="w-1/2 rounded-l-md bg-gray-300 border-none px-2 py-2 outline-none focus:outline-none"
                    >
                        <option
                            v-for="(orderPaidByType, index) in orderPaidByTypes"
                            :key="index"
                            :value="orderPaidByType.value"
                        >
                            {{ orderPaidByType.label }}
                        </option>
                    </select>
                    <input
                        id="paid"
                        :placeholder="$t('order.enter_paid_amount')"
                        v-model="form.amount"
                        @keyup.enter="payOrderDue"
                        type="text"
                        class="w-full rounded-r-md border border-gray-200 px-2 py-2 shadow-sm outline-none focus:outline-none focus:shadow-outline"
                    />
                </div>
                <InputError :message="form.errors.amount"/>
            </div>
        </Modal>

        <!--Settle Order-->
        <Modal
            :title="$t('order.due_settlement')"
            :show="showSettleModal"
            :formProcessing="form.processing"
            @close="closeModal"
            @submitAction="settleDuePayment"
            maxWidth="md"
            :submitButtonText="$t('order.yes_settle_it')"
        >
            {{ $t('order.confirm_settle_due') }}
            <br>
            <br>
            <strong>{{ $t('common.note') }}: </strong>{{ $t('order.due_discount_note') }}
        </Modal>
    </AuthenticatedLayout>
</template>
