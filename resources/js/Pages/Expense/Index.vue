<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3';
import CardTable from "@/Components/Cards/CardTable.vue";
import TableData from "@/Components/TableData.vue";
import Button from "@/Components/Button.vue";
import InputError from "@/Components/InputError.vue";
import Modal from "@/Components/Modal.vue";
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

defineProps({
    filters: {
        type: Object
    },
    expenses: {
        type: Object
    },
});

import {useForm} from '@inertiajs/vue3';
import {nextTick, ref} from 'vue';
import DashboardInputGroup from "@/Components/DashboardInputGroup.vue";
import {showToast} from "@/Utils/Helper.js";

const selectedExpense = ref(null);
const showCreateModal = ref(false);
const showEditModal = ref(false);
const showDeleteModal = ref(false);
const nameInput = ref(null);
const tableHeads = ref(['#', t('fields.name'), t('expense.amount'), t('expense.expense_date'), t('common.action')]);

const form = useForm({
    name: "",
    description: "",
    amount: "",
    expense_date: "",
});

const editExpenseModal = (expense) => {
    selectedExpense.value = expense;

    form.name = expense.name;
    form.description = expense.description;
    form.amount = expense.amount;
    form.expense_date = expense.expense_date;

    showEditModal.value = true;
    nextTick(() => nameInput.value.focus());
};

const deleteExpenseModal = (expense) => {
    selectedExpense.value = expense;
    showDeleteModal.value = true;
};

const createExpense = () => {
    form.post(route('expenses.store'), {
        preserveScroll: true,
        onSuccess: (e) => {
            closeModal();
            showToast();
        },
        onError: () => nameInput.value.focus(),
    });
};

const updateExpense = () => {
    form.put(route('expenses.update', selectedExpense.value.id), {
        preserveScroll: true,
        onSuccess: () => {
            closeModal();
            showToast();
        },
        onError: () => nameInput.value.focus(),
    });
};

const deleteExpense = () => {
    form.delete(route('expenses.destroy', selectedExpense.value.id), {
        preserveScroll: true,
        onSuccess: () => {
            closeModal();
            showToast();
        },
    });
};

const closeModal = () => {
    showCreateModal.value = false;
    showEditModal.value = false;
    showDeleteModal.value = false;
    form.reset();
};
</script>

<template>
    <Head :title="$t('navigation.expenses')"/>

    <AuthenticatedLayout>
        <template #breadcrumb>
            {{ $t('navigation.expenses') }}
        </template>

        <div class="flex flex-wrap">
            <div class="w-full px-4">
                <CardTable
                    indexRoute="expenses.index"
                    :paginatedData="expenses"
                    :filters="filters"
                    :tableHeads="tableHeads"
                >
                    <template #cardHeader>
                        <div class="flex justify-between items-center">
                            <h4 class="text-2xl">{{ $t('common.apply_filters') }}({{expenses.total}})</h4>
                            <Button @click=" showCreateModal = true">{{ $t('expense.create_expense') }}</Button>
                        </div>
                    </template>

                    <tr v-for="(expense, index) in expenses.data" :key="expense.id">
                        <TableData>
                            {{ (expenses.current_page * expenses.per_page) - (expenses.per_page - (index + 1)) }}
                        </TableData>
                        <TableData>{{ expense.name }}</TableData>
                        <TableData>{{ expense.amount }}</TableData>
                        <TableData>{{ expense.expense_date }}</TableData>
                        <TableData>
                            <Button @click="editExpenseModal(expense)">
                                <i class="fa fa-edit"></i>
                            </Button>
                            <Button
                                @click="deleteExpenseModal(expense)"
                                type="red"
                            >
                                <i class="fa fa-trash-alt"></i>
                            </Button>
                        </TableData>
                    </tr>
                </CardTable>
            </div>
        </div>

        <!--Create data-->
        <Modal
            :title="$t('common.create')"
            :show="showCreateModal"
            :formProcessing="form.processing"
            @close="closeModal"
            @submitAction="createExpense"
        >
            <div>
                <DashboardInputGroup
                    :label="$t('fields.name')"
                    name="name"
                    v-model="form.name"
                    :placeholder="$t('placeholders.enter_name')"
                    :errorMessage="form.errors.name"
                    @keyupEnter="createExpense"
                />
            </div>
            <div class="mt-2 grid gap-4 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3">
                <div class="flex flex-col overflow-auto">
                    <DashboardInputGroup
                        :label="$t('expense.amount')"
                        name="amount"
                        v-model="form.amount"
                        :placeholder="$t('expense.enter_amount')"
                        :errorMessage="form.errors.amount"
                        @keyupEnter="createExpense"
                        type="number"
                    />
                </div>
                <div class="flex flex-col overflow-auto">
                    <DashboardInputGroup
                        :label="$t('expense.expense_date')"
                        name="expense_date"
                        v-model="form.expense_date"
                        :placeholder="$t('expense.enter_expense_date')"
                        :errorMessage="form.errors.expense_date"
                        @keyupEnter="createExpense"
                        type="date"
                    />
                </div>
            </div>
            <div class="mt-2">
                <label for="description" class="text-stone-600 text-sm font-medium">{{ $t('fields.description') }}</label>
                <textarea
                    id="description"
                    v-model="form.description"
                    type="text"
                    rows="3"
                    :placeholder="$t('placeholders.enter_description')"
                    class="mt-2 block w-full rounded-md border border-gray-200 px-2 py-2 shadow-sm outline-none focus:outline-none focus:shadow-outline"
                ></textarea>
                <InputError :message="form.errors.description"/>
            </div>
        </Modal>

        <!--Edit data-->
        <Modal
            :title="$t('common.edit')"
            :show="showEditModal"
            :formProcessing="form.processing"
            @close="closeModal"
            @submitAction="updateExpense"
        >
            <div>
                <DashboardInputGroup
                    :label="$t('fields.name')"
                    name="name"
                    v-model="form.name"
                    :placeholder="$t('placeholders.enter_name')"
                    :errorMessage="form.errors.name"
                    @keyupEnter="updateExpense"
                />
            </div>
            <div class="mt-2 grid gap-4 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3">
                <div class="flex flex-col overflow-auto">
                    <DashboardInputGroup
                        :label="$t('expense.amount')"
                        name="amount"
                        v-model="form.amount"
                        :placeholder="$t('expense.enter_amount')"
                        :errorMessage="form.errors.amount"
                        @keyupEnter="updateExpense"
                        type="number"
                    />
                </div>
                <div class="flex flex-col overflow-auto">
                    <DashboardInputGroup
                        :label="$t('expense.expense_date')"
                        name="expense_date"
                        v-model="form.expense_date"
                        :placeholder="$t('expense.enter_expense_date')"
                        :errorMessage="form.errors.expense_date"
                        @keyupEnter="updateExpense"
                        type="date"
                    />
                </div>
            </div>
            <div class="mt-2">
                <label for="description" class="text-stone-600 text-sm font-medium">{{ $t('fields.description') }}</label>
                <textarea
                    id="description"
                    v-model="form.description"
                    type="text"
                    rows="3"
                    :placeholder="$t('placeholders.enter_description')"
                    class="mt-2 block w-full rounded-md border border-gray-200 px-2 py-2 shadow-sm outline-none focus:outline-none focus:shadow-outline"
                ></textarea>
                <InputError :message="form.errors.description"/>
            </div>
        </Modal>

        <!--Delete data-->
        <Modal
            :title="$t('common.delete')"
            :show="showDeleteModal"
            :formProcessing="form.processing"
            @close="closeModal"
            @submitAction="deleteExpense"
            maxWidth="sm"
            :submitButtonText="$t('common.yes_delete_it')"
        >
            {{ $t('expense.delete_confirmation') }}
        </Modal>
    </AuthenticatedLayout>
</template>
