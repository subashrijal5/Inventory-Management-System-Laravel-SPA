<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3';
import Button from '@/Components/Button.vue';
import ProductForm from '@/Components/Forms/ProductForm.vue';

defineProps({
    filters: {
        type: Object
    },
});
</script>

<template>
    <Head title="Product"/>

    <AuthenticatedLayout>
        <template #breadcrumb>
            Products > Create
        </template>

        <div class="flex flex-wrap">
            <div class="w-full px-4">
                <div class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded bg-white">
                    <div class="rounded-t mb-3 px-4 py-3 border-0">
                        <div class="flex flex-wrap items-center">
                            <div class="relative w-full px-4 max-w-full flex-grow flex-1">
                                <div class="flex justify-between items-center">
                                    <h4 class="text-2xl">Create Product</h4>
                                    <Button
                                        :href="route('products.index')"
                                        buttonType="link"
                                    >
                                        Go Back
                                    </Button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="block w-full overflow-x-auto px-8 py-4">
                        <ProductForm
                            :submit-url="route('products.store')"
                        />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
