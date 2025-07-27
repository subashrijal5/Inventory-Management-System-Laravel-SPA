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
import {showToast} from "@/Utils/Helper.js";
import {useI18n} from 'vue-i18n';

const {t} = useI18n();

defineProps({
    filters: {
        type: Object
    },
    employees: {
        type: Object
    },
});

const selectedEmployee = ref(null);
const showCreateModal = ref(false);
const showEditModal = ref(false);
const showDeleteModal = ref(false);
const nameInput = ref(null);
const tableHeads = ref(['#', t('fields.name'), t('employee.designation'), t('fields.email'), t('fields.phone'), t('employee.salary'), t('employee.joining_date'), t('fields.action')]);

const form = useForm({
    name: null,
    email: null,
    phone: null,
    designation: null,
    address: null,
    salary: null,
    nid: null,
    joining_date: null,
    photo: null,
});

const createEmployeeModal = () => {
    showCreateModal.value = true;

    nextTick(() => nameInput.value.focus());
};

const editEmployeeModal = (employee) => {
    selectedEmployee.value = employee;

    form.name = employee.name;
    form.email = employee.email;
    form.phone = employee.phone;
    form.designation = employee.designation;
    form.address = employee.address;
    form.salary = employee.salary;
    form.nid = employee.nid;
    form.joining_date = employee.joining_date;
    form.photo = null;

    showEditModal.value = true;

    nextTick(() => nameInput.value.focus());
};

const deleteEmployeeModal = (employee) => {
    selectedEmployee.value = employee;
    showDeleteModal.value = true;
};

const createEmployee = () => {
    form.post(route('employees.store'), {
        preserveScroll: true,
        onSuccess: () => {
            closeModal();
            showToast();
        },
        onError: () => nameInput.value.focus(),
    });
};

const updateEmployee = () => {
    form.transform((data) => ({
        ...data,
        _method: "put"
    }))
        .post(route('employees.update', selectedEmployee.value.id), {
            preserveScroll: true,
            onSuccess: () => {
                closeModal();
                showToast();
            },
            onError: () => nameInput.value.focus(),
        });
};

const deleteEmployee = () => {
    form.delete(route('employees.destroy', selectedEmployee.value.id), {
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
    <Head :title="$t('navigation.employees')"/>

    <AuthenticatedLayout>
        <template #breadcrumb>
            {{ $t('navigation.employees') }}
        </template>

        <div class="flex flex-wrap">
            <div class="w-full px-4">
                <CardTable
                    indexRoute="employees.index"
                    :paginatedData="employees"
                    :filters="filters"
                    :tableHeads="tableHeads"
                >
                    <template #cardHeader>
                        <div class="flex justify-between items-center">
                            <h4 class="text-2xl">{{ $t('common.apply_filters') }}({{employees.total}})</h4>
                            <Button @click="createEmployeeModal">{{ $t('employee.create_employee') }}</Button>
                        </div>
                    </template>

                    <tr v-for="(employee, index) in employees.data" :key="employee.id">
                        <TableData>
                            {{ (employees.current_page * employees.per_page) - (employees.per_page - (index + 1)) }}
                        </TableData>
                        <TableData class="text-left flex items-center">
                            <img
                                :src="employee.photo"
                                class="h-12 w-12 bg-white rounded-full border"
                                alt="Inventory management system"
                            />
                            <span class="ml-3 font-bold text-blueGray-600">{{ employee.name }}</span>
                        </TableData>
                        <TableData>{{ employee.designation }}</TableData>
                        <TableData>{{ employee.email }}</TableData>
                        <TableData>{{ employee.phone }}</TableData>
                        <TableData>{{ employee.salary }}</TableData>
                        <TableData>{{ employee.joining_date }}</TableData>
                        <TableData>
                            <Button @click="editEmployeeModal(employee)">
                                <i class="fa fa-edit"></i>
                            </Button>
                            <Button
                                @click="deleteEmployeeModal(employee)"
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
            :title="$t('actions.create')"
            :show="showCreateModal"
            :formProcessing="form.processing"
            @close="closeModal"
            @submitAction="createEmployee"
        >
            <div class="grid gap-4 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3">
                <div class="flex flex-col">
                    <DashboardInputGroup
                        :label="$t('fields.name')"
                        name="name"
                        v-model="form.name"
                        :placeholder="$t('employee.enter_name')"
                        :errorMessage="form.errors.name"
                        @keyupEnter="createEmployee"
                    />
                </div>
                <div class="flex flex-col">
                    <DashboardInputGroup
                        :label="$t('fields.email')"
                        name="email"
                        v-model="form.email"
                        :placeholder="$t('employee.enter_email')"
                        :errorMessage="form.errors.email"
                        @keyupEnter="createEmployee"
                        type="email"
                    />
                </div>
                <div class="flex flex-col">
                    <DashboardInputGroup
                        :label="$t('fields.phone')"
                        name="phone"
                        v-model="form.phone"
                        :placeholder="$t('employee.enter_phone')"
                        :errorMessage="form.errors.phone"
                        @keyupEnter="createEmployee"
                    />
                </div>
                <div class="flex flex-col">
                    <DashboardInputGroup
                        :label="$t('employee.nid')"
                        name="nid"
                        v-model="form.nid"
                        :placeholder="$t('employee.enter_nid')"
                        :errorMessage="form.errors.nid"
                        @keyupEnter="createEmployee"
                    />
                </div>
            </div>
            <div class="my-3 grid gap-4 sm:grid-cols-1 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-3">
                <div class="flex flex-col">
                    <DashboardInputGroup
                        :label="$t('employee.designation')"
                        name="designation"
                        v-model="form.designation"
                        :placeholder="$t('employee.enter_designation')"
                        :errorMessage="form.errors.designation"
                        @keyupEnter="createEmployee"
                    />
                </div>
                <div class="flex flex-col">
                    <DashboardInputGroup
                        :label="$t('employee.salary')"
                        name="salary"
                        v-model="form.salary"
                        :placeholder="$t('employee.enter_salary')"
                        :errorMessage="form.errors.salary"
                        @keyupEnter="createEmployee"
                        type="number"
                    />
                </div>
                <div class="flex flex-col">
                    <DashboardInputGroup
                        :label="$t('employee.joining_date')"
                        name="joining_date"
                        v-model="form.joining_date"
                        :placeholder="$t('employee.enter_joining_date')"
                        :errorMessage="form.errors.joining_date"
                        @keyupEnter="createEmployee"
                        type="date"
                    />
                </div>
            </div>
            <div class="grid gap-4 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3">
                <div class="flex flex-col">
                    <label
                        class="w-64 flex flex-col items-center px-4 py-6 bg-white text-blue rounded-lg shadow-lg tracking-wide uppercase border border-blue cursor-pointer hover:bg-blue hover:text-emerald-600">
                        <svg class="w-8 h-8" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path
                                d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z"/>
                        </svg>
                        <span v-if="form.photo" class="mt-2 text-base leading-normal">{{
                                form.photo.name.replace(/(^.{17}).*(\..+$)/, "$1...$2")
                            }}</span>
                        <span v-else class="mt-2 text-base leading-normal">{{ $t('employee.select_photo') }}</span>
                        <input
                            @input="form.photo = $event.target.files[0]"
                            type='file'
                            class="hidden"
                            accept="image/png, image/jpeg, image/jpg, image/gif, image/svg"
                        />
                    </label>
                    <InputError :message="form.errors.photo"/>
                </div>
                <div class="flex flex-col">
                    <label for="address" class="text-stone-600 text-sm font-medium">{{ $t('fields.address') }}</label>
                    <textarea
                        id="address"
                        v-model="form.address"
                        type="text"
                        rows="3"
                        :placeholder="$t('employee.enter_address')"
                        class="mt-2 block w-full rounded-md border border-gray-200 px-2 py-2 shadow-sm outline-none focus:outline-none focus:shadow-outline"
                    ></textarea>
                    <InputError :message="form.errors.address"/>
                </div>
            </div>
        </Modal>

        <!--Edit data-->
        <Modal
            :title="$t('actions.edit')"
            :show="showEditModal"
            :formProcessing="form.processing"
            @close="closeModal"
            @submitAction="updateEmployee"
        >
            <div class="grid gap-4 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3">
                <div class="flex flex-col">
                    <DashboardInputGroup
                        :label="$t('fields.name')"
                        name="name"
                        v-model="form.name"
                        :placeholder="$t('employee.enter_name')"
                        :errorMessage="form.errors.name"
                        @keyupEnter="createEmployee"
                    />
                </div>
                <div class="flex flex-col">
                    <DashboardInputGroup
                        :label="$t('fields.email')"
                        name="email"
                        v-model="form.email"
                        :placeholder="$t('employee.enter_email')"
                        :errorMessage="form.errors.email"
                        @keyupEnter="createEmployee"
                        type="email"
                    />
                </div>
                <div class="flex flex-col">
                    <DashboardInputGroup
                        :label="$t('fields.phone')"
                        name="phone"
                        v-model="form.phone"
                        :placeholder="$t('employee.enter_phone')"
                        :errorMessage="form.errors.phone"
                        @keyupEnter="createEmployee"
                    />
                </div>
                <div class="flex flex-col">
                    <DashboardInputGroup
                        :label="$t('employee.nid')"
                        name="nid"
                        v-model="form.nid"
                        :placeholder="$t('employee.enter_nid')"
                        :errorMessage="form.errors.nid"
                        @keyupEnter="createEmployee"
                    />
                </div>
            </div>
            <div class="my-3 grid gap-4 sm:grid-cols-1 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-3">
                <div class="flex flex-col">
                    <DashboardInputGroup
                        :label="$t('employee.designation')"
                        name="designation"
                        v-model="form.designation"
                        :placeholder="$t('employee.enter_designation')"
                        :errorMessage="form.errors.designation"
                        @keyupEnter="createEmployee"
                    />
                </div>
                <div class="flex flex-col">
                    <DashboardInputGroup
                        :label="$t('employee.salary')"
                        name="salary"
                        v-model="form.salary"
                        :placeholder="$t('employee.enter_salary')"
                        :errorMessage="form.errors.salary"
                        @keyupEnter="createEmployee"
                        type="number"
                    />
                </div>
                <div class="flex flex-col">
                    <DashboardInputGroup
                        :label="$t('employee.joining_date')"
                        name="joining_date"
                        v-model="form.joining_date"
                        :placeholder="$t('employee.enter_joining_date')"
                        :errorMessage="form.errors.joining_date"
                        @keyupEnter="createEmployee"
                        type="date"
                    />
                </div>
            </div>
            <div class="grid gap-4 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3">
                <div class="flex flex-col">
                    <label
                        class="w-64 flex flex-col items-center px-4 py-6 bg-white text-blue rounded-lg shadow-lg tracking-wide uppercase border border-blue cursor-pointer hover:bg-blue hover:text-emerald-600">
                        <svg class="w-8 h-8" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path
                                d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z"/>
                        </svg>
                        <span v-if="form.photo" class="mt-2 text-base leading-normal">{{
                                form.photo.name.replace(/(^.{17}).*(\..+$)/, "$1...$2")
                            }}</span>
                        <span v-else class="mt-2 text-base leading-normal">{{ $t('employee.select_photo') }}</span>
                        <input
                            @input="form.photo = $event.target.files[0]"
                            type='file'
                            class="hidden"
                            accept="image/png, image/jpeg, image/jpg, image/gif, image/svg"
                        />
                    </label>
                    <InputError :message="form.errors.photo"/>
                </div>
                <div class="flex flex-col">
                    <label for="address" class="text-stone-600 text-sm font-medium">{{ $t('fields.address') }}</label>
                    <textarea
                        id="address"
                        v-model="form.address"
                        type="text"
                        rows="3"
                        :placeholder="$t('employee.enter_address')"
                        class="mt-2 block w-full rounded-md border border-gray-200 px-2 py-2 shadow-sm outline-none focus:outline-none focus:shadow-outline"
                    ></textarea>
                    <InputError :message="form.errors.address"/>
                </div>
            </div>
        </Modal>

        <!--Delete data-->
        <Modal
            :title="$t('actions.delete')"
            :show="showDeleteModal"
            :formProcessing="form.processing"
            @close="closeModal"
            @submitAction="deleteEmployee"
            maxWidth="sm"
            :submitButtonText="$t('employee.confirm_delete_button')"
        >
            {{ $t('employee.confirm_delete_employee') }}
        </Modal>
    </AuthenticatedLayout>
</template>
