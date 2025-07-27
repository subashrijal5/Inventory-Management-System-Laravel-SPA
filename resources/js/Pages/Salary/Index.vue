<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3';
import CardTable from "@/Components/Cards/CardTable.vue";
import TableData from "@/Components/TableData.vue";
import Button from "@/Components/Button.vue";
import InputError from "@/Components/InputError.vue";
import Modal from "@/Components/Modal.vue";
import {useForm} from '@inertiajs/vue3';
import {nextTick, ref} from 'vue';
import DashboardInputGroup from "@/Components/DashboardInputGroup.vue";
import AsyncVueSelect from "@/Components/AsyncVueSelect.vue";
import {showToast} from "@/Utils/Helper.js";
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

defineProps({
    filters: {
        type: Object
    },
    salaries: {
        type: Object
    },
});

const selectedSalary = ref(null);
const showCreateModal = ref(false);
const showEditModal = ref(false);
const showDeleteModal = ref(false);
const nameInput = ref(null);
const tableHeads = ref(['#', t('fields.employee'), t('salary.amount'), t('salary.salary_date'), t('fields.action')]);

const form = useForm({
    employee_id: "",
    amount: "",
    salary_date: "",
});

const editSalaryModal = (salary) => {
    selectedSalary.value = salary;

    form.employee_id = salary.employee_id;
    form.amount = salary.amount;
    form.salary_date = salary.salary_date;

    showEditModal.value = true;
    nextTick(() => nameInput.value.focus());
};

const deleteSalaryModal = (salary) => {
    selectedSalary.value = salary;
    showDeleteModal.value = true;
};

const createSalary = () => {
    form.post(route('salaries.store'), {
        preserveScroll: true,
        onSuccess: (e) => {
            closeModal();
            showToast();
        },
        onError: () => nameInput.value.focus(),
    });
};

const updateSalary = () => {
    form.put(route('salaries.update', selectedSalary.value.id), {
        preserveScroll: true,
        onSuccess: () => {
            closeModal();
            showToast();
        },
        onError: () => nameInput.value.focus(),
    });
};

const deleteSalary = () => {
    form.delete(route('salaries.destroy', selectedSalary.value.id), {
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
    <Head :title="$t('navigation.salary')"/>

    <AuthenticatedLayout>
        <template #breadcrumb>
            {{ $t('navigation.salary') }}
        </template>

        <div class="flex flex-wrap">
            <div class="w-full px-4">
                <CardTable
                    indexRoute="salaries.index"
                    :paginatedData="salaries"
                    :filters="filters"
                    :tableHeads="tableHeads"
                >
                    <template #cardHeader>
                        <div class="flex justify-between items-center">
                            <h4 class="text-2xl">{{ $t('common.apply_filters') }}({{salaries.total}})</h4>
                            <Button @click=" showCreateModal = true">{{ $t('salary.pay_salary') }}</Button>
                        </div>
                    </template>

                    <tr v-for="(salary, index) in salaries.data" :key="salary.id">
                        <TableData>
                            {{ (salaries.current_page * salaries.per_page) - (salaries.per_page - (index + 1)) }}
                        </TableData>
                        <TableData>{{ salary.employee.name }} ({{ salary.employee.designation }})</TableData>
                        <TableData>{{ salary.amount }}</TableData>
                        <TableData>{{ salary.salary_date }}</TableData>
                        <TableData>
                            <Button @click="editSalaryModal(salary)">
                                <i class="fa fa-edit"></i>
                            </Button>
                            <Button
                                @click="deleteSalaryModal(salary)"
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
            :title="$t('salary.pay_salary')"
            :show="showCreateModal"
            :formProcessing="form.processing"
            @close="closeModal"
            @submitAction="createSalary"
        >
            <div class="mt-2 grid gap-4 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 min-h-32">
                <div class="flex flex-col">
                    <label for="employee" class="text-stone-600 text-sm font-medium">{{ $t('salary.select_employee') }}</label>
                    <AsyncVueSelect
                        v-model="form.employee_id"
                        resource="employees.index"
                        :placeholder="$t('salary.select_employee')"
                        class="mt-2"
                    />
                    <InputError :message="form.errors.employee_id"/>
                </div>
                <div class="flex flex-col overflow-auto">
                    <DashboardInputGroup
                        :label="$t('salary.salary_date')"
                        name="salary_date"
                        v-model="form.salary_date"
                        :placeholder="$t('salary.enter_salary_date')"
                        :errorMessage="form.errors.salary_date"
                        @keyupEnter="createSalary"
                        type="date"
                    />
                </div>
            </div>
        </Modal>

        <!--Edit data-->
        <Modal
            :title="$t('actions.edit')"
            :show="showEditModal"
            :formProcessing="form.processing"
            @close="closeModal"
            @submitAction="updateSalary"
        >
            <div>
                <DashboardInputGroup
                    :label="$t('fields.employee')"
                    name="employee_id"
                    v-model="form.employee_id"
                    :placeholder="$t('salary.select_employee')"
                    :errorMessage="form.errors.employee_id"
                    @keyupEnter="createSalary"
                />
            </div>
            <div class="mt-2 grid gap-4 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3">
                <div class="flex flex-col overflow-auto">
                    <DashboardInputGroup
                        :label="$t('salary.amount')"
                        name="amount"
                        v-model="form.amount"
                        :placeholder="$t('salary.enter_amount')"
                        :errorMessage="form.errors.amount"
                        @keyupEnter="createSalary"
                        type="number"
                    />
                </div>
                <div class="flex flex-col overflow-auto">
                    <DashboardInputGroup
                        :label="$t('salary.salary_date')"
                        name="salary_date"
                        v-model="form.salary_date"
                        :placeholder="$t('salary.enter_salary_date')"
                        :errorMessage="form.errors.salary_date"
                        @keyupEnter="createSalary"
                        type="date"
                    />
                </div>
            </div>
        </Modal>

        <!--Delete data-->
        <Modal
            :title="$t('actions.delete')"
            :show="showDeleteModal"
            :formProcessing="form.processing"
            @close="closeModal"
            @submitAction="deleteSalary"
            maxWidth="sm"
            :submitButtonText="$t('salary.confirm_delete_button')"
        >
            {{ $t('salary.confirm_delete_salary') }}
        </Modal>
    </AuthenticatedLayout>
</template>
