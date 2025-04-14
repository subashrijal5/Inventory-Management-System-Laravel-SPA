<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import { showToast } from "@/Utils/Helper.js";
import BarcodeScanner from "@/Components/BarcodeScanner.vue";
import Button from "@/Components/Button.vue";
import InputError from "@/Components/InputError.vue";
import ProductForm from "@/Components/Forms/ProductForm.vue";
import axios from "axios";

const props = defineProps({
    product: {
        type: Object,
        default: null,
    },
    barcode: {
        type: String,
        default: null,
    },
    error: {
        type: String,
        default: null,
    },
});

const showCreateForm = ref(false);
const showUpdateForm = ref(false);

const searchForm = useForm({
    barcode: props.barcode || null,
});

const updateForm = useForm({
    quantity: null,
});

const createFormInitialData = {
    barcode: props.barcode || null,
    status: "active",
};

const handleBarcodeDetected = (barcode) => {
    searchForm.barcode = barcode;
    axios
        .get(route("products.search-by-barcode", barcode))
        .then((data) => {
            console.log(
                "🚀 ~ file: BarcodeScanner.vue:52 ~ data.data:",
                data.data.product
            );
            showUpdateForm.value = true;
            showCreateForm.value = false;
            if(data.data?.product){
                product.value = data.data.product;
            }
        })
        .catch(() => {
            showCreateForm.value = true;
            showUpdateForm.value = false;
        });
};

const handleUpdateStock = () => {
    updateForm.post(
        route("products.update-stock-by-barcode", {
            barcode: searchForm.barcode,
            quantity: updateForm.quantity,
        }),
        {
            preserveScroll: true,
            onSuccess: () => {
                showToast("Stock updated successfully!");
                updateForm.reset();
                showUpdateForm.value = false;
            },
        }
    );
};

const handleCreateSuccess = () => {
    showCreateForm.value = false;
};
</script>

<template>
    <Head title="Barcode Scanner" />

    <AuthenticatedLayout>
        <template #breadcrumb> Barcode Scanner </template>

        <div class="flex flex-wrap">
            <div class="w-full px-4">
                <div
                    class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded-lg bg-white border-0"
                >
                    <div class="rounded-t bg-white mb-0 px-6 py-6">
                        <div class="text-center flex justify-between">
                            <h6 class="text-blueGray-700 text-xl font-bold">
                                Scan Product Barcode
                            </h6>
                            <Button
                                :href="route('products.index')"
                                buttonType="link"
                            >
                                Back to Products
                            </Button>
                        </div>
                    </div>
                    <div class="flex-auto px-4 lg:px-10 py-10 pt-0">
                        <div class="flex flex-wrap">
                            <div class="w-full lg:w-8/12 px-4">
                                <BarcodeScanner
                                    :onDetected="handleBarcodeDetected"
                                />
                            </div>
                            <div class="w-full lg:w-4/12 px-4">
                                <div class="relative w-full mb-3">
                                    <h6
                                        class="text-blueGray-400 text-sm mt-3 mb-6 font-bold uppercase"
                                    >
                                        Scanned Product Information
                                    </h6>
                                    <div
                                        v-if="searchForm.barcode"
                                        class="text-sm"
                                    >
                                        <p class="mb-2">
                                            Barcode: {{ searchForm.barcode }}
                                        </p>

                                        <!-- Product Information -->
                                        <div v-if="product" class="mt-4">
                                            <h6
                                                class="text-blueGray-400 text-sm mb-2 font-bold uppercase"
                                            >
                                                Product Details
                                            </h6>
                                            <p class="mb-1">
                                                Name: {{ product.name }}
                                            </p>
                                            <p class="mb-1">
                                                Code: {{ product.product_code }}
                                            </p>
                                            <p class="mb-1">
                                                Current Stock:
                                                {{ product.quantity }}
                                            </p>
                                            <p class="mb-1">
                                                Price: ${{
                                                    product.selling_price
                                                }}
                                            </p>

                                            <!-- Stock Update Form -->
                                            <div
                                                v-if="showUpdateForm"
                                                class="mt-4"
                                            >
                                                <h6
                                                    class="text-blueGray-400 text-sm mb-2 font-bold uppercase"
                                                >
                                                    Update Stock
                                                </h6>
                                                <form
                                                    @submit.prevent="
                                                        handleUpdateStock
                                                    "
                                                    class="space-y-4"
                                                >
                                                    <div>
                                                        <label
                                                            class="block text-sm font-medium text-gray-700"
                                                            >Quantity to
                                                            Add</label
                                                        >
                                                        <input
                                                            type="number"
                                                            v-model="
                                                                updateForm.quantity
                                                            "
                                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                                            required
                                                        />
                                                        <InputError
                                                            :message="
                                                                updateForm
                                                                    .errors
                                                                    .quantity
                                                            "
                                                            class="mt-2"
                                                        />
                                                    </div>
                                                    <Button
                                                        type="submit"
                                                        :loading="
                                                            updateForm.processing
                                                        "
                                                        >Update Stock</Button
                                                    >
                                                </form>
                                            </div>
                                        </div>

                                        <!-- Create Product Form -->
                                        <div
                                            v-if="showCreateForm && !product"
                                            class="mt-4"
                                        >
                                            <h6
                                                class="text-blueGray-400 text-sm mb-2 font-bold uppercase"
                                            >
                                                Create New Product
                                            </h6>
                                            <ProductForm
                                                :barcode="searchForm.barcode"
                                                :initial-data="
                                                    createFormInitialData
                                                "
                                                :submit-url="
                                                    route(
                                                        'products.create-with-barcode'
                                                    )
                                                "
                                                :on-success="
                                                    handleCreateSuccess
                                                "
                                            />
                                        </div>
                                    </div>
                                    <div
                                        v-else
                                        class="text-sm text-blueGray-400"
                                    >
                                        No product scanned yet
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
