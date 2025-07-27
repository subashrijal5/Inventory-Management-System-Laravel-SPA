<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, router} from '@inertiajs/vue3';
import {useForm} from '@inertiajs/vue3';
import {watch, ref, computed} from 'vue';
import AsyncVueSelect from "@/Components/AsyncVueSelect.vue";
import {getCurrency, numberFormat, showToast, truncateString} from "@/Utils/Helper.js";
import InputError from "@/Components/InputError.vue";
import SubmitButton from "@/Components/SubmitButton.vue";
import { useI18n } from 'vue-i18n';

// Placeholder image for products without images
const placeholderImage = 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAwIiBoZWlnaHQ9IjIwMCIgdmlld0JveD0iMCAwIDIwMCAyMDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSIyMDAiIGhlaWdodD0iMjAwIiBmaWxsPSIjRjNGNEY2Ii8+CjxwYXRoIGQ9Ik02MCA2MEgxNDBWMTQwSDYwVjYwWiIgZmlsbD0iI0Q1RDlERCIvPgo8cGF0aCBkPSJNODAgODBIMTIwVjEyMEg4MFY4MFoiIGZpbGw9IiNBN0I2QzIiLz4KPGNpcmNsZSBjeD0iOTAiIGN5PSI5MCIgcj0iNSIgZmlsbD0iIzY4NzI4MCIvPgo8cGF0aCBkPSJNODUgMTA1TDk1IDk1TDExNSAxMTVIODVWMTA1WiIgZmlsbD0iIzY4NzI4MCIvPgo8L3N2Zz4K';

const getProductImage = (product) => {
    return product.photo && product.photo.trim() !== '' ? product.photo : placeholderImage;
};

const props = defineProps({
    products: Object,
    carts: Object,
    cartSubtotal: Number,
    discountType: String,
    discount: Number,
    totalDiscount: Number,
    tax: Number,
    totalTax: Number,
    total: Number,
    orderPaidByTypes: Object,
});

const { t } = useI18n();

const searchQuery = ref('');
const searchType = ref('name'); // name, code, category

const filteredProducts = computed(() => {
    if (!searchQuery.value) return props.products.data;
    
    return props.products.data.filter(product => {
        const query = searchQuery.value.toLowerCase();
        switch(searchType.value) {
            case 'name':
                return product.name.toLowerCase().includes(query);
            case 'code':
                return product.product_code.toLowerCase().includes(query);
            case 'category':
                return product.category?.name.toLowerCase().includes(query);
            default:
                return true;
        }
    });
});

const form = useForm({
    customer_id: null,
    total: null,
    paid: null,
    paid_through: "cash",
    custom_discount: {
        discount: 0,
        discount_type: "fixed"
    },
});

// Watch props and update the form fields reactively
watch(props, (newProps) => {
    if (form.custom_discount.discount_type === "fixed") {
        form.total = newProps.total - form.custom_discount.discount;
        form.paid = newProps.total - form.custom_discount.discount;
    } else {
        form.total = numberFormat(newProps.total - (newProps.cartSubtotal * (form.custom_discount.discount / 100)));
        form.paid = numberFormat(newProps.total - (newProps.cartSubtotal * (form.custom_discount.discount / 100)));
    }
}, { immediate: true });

// watch form
watch(() => form.custom_discount, async (newForm, oldForm) => {
    if (form.custom_discount.discount_type === "fixed") {
        form.total = props.total - form.custom_discount.discount;
        form.paid = props.total - form.custom_discount.discount;
    } else {
        form.total = numberFormat(props.total - (props.cartSubtotal * (form.custom_discount.discount / 100)));
        form.paid = numberFormat(props.total - (props.cartSubtotal * (form.custom_discount.discount / 100)));
    }
}, {
    immediate: true,
    deep: true
})

const addToCart = (product) => {
    router.post(route('carts.store', product.id), {}, {
        preserveScroll: true,
        onSuccess: () => {
            // showToast();
        }
    });
};

const incrementCartQuantity = (cart) => {
    router.put(route('carts.increment', cart.id), {}, {
        preserveScroll: true,
        onSuccess: () => {
            // showToast();
        }
    });
};

const decrementCartQuantity = (cart) => {
    router.put(route('carts.decrement', cart.id), {}, {
        preserveScroll: true,
        onSuccess: () => {
            // showToast();
        }
    });
};

const insertCartQuantity = (cart, quantity) => {
    if (cart.quantity == quantity) {
        return;
    }
    router.put(route('carts.update', cart.id), {
        quantity: quantity,
    }, {
        preserveScroll: true,
        onSuccess: () => {
            // showToast();
        }
    });
};

const deleteCart = (cart) => {
    router.delete(route('carts.delete', cart.id), {
        preserveScroll: true,
        onSuccess: () => {
            // showToast();
        }
    });
};

const deleteCartAllItems = () => {
    router.delete(route('carts.delete.all'), {
        onSuccess: () => {
            showToast();
        }
    });
};

const createOrder = () => {
    if (!props.carts.total) {
        return;
    }
    form.post(route('orders.store'), {
        preserveScroll: true,
        onSuccess: () => {
            showToast();
            form.reset()
        },
    });
};
</script>
<template>
    <Head :title="$t('navigation.products')"/>
    <AuthenticatedLayout>
        <template #breadcrumb>
            {{ $t('navigation.pos') }}
        </template>
        <div class="flex flex-wrap">
            <div class="w-full px-2 sm:px-4">
                <div class="relative -mt-16 flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded bg-white">
                    <div class="flex flex-col lg:flex-row shadow-lg min-h-screen">
                        <!-- Products Section -->
                        <div class="w-full lg:w-3/5 xl:w-2/3 shadow-lg overflow-hidden">
                            <!-- Header -->
                            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center px-3 sm:px-5 mt-5 gap-3">
                                <div class="text-gray-800">
                                    <div class="font-bold text-lg sm:text-xl">{{ $t('navigation.products') }}</div>
                                </div>
                                <div class="flex items-center gap-2 w-full sm:w-auto">
                                    <select
                                        v-model="searchType"
                                        class="px-2 sm:px-3 py-1 rounded-md bg-gray-200 border-none text-sm flex-shrink-0"
                                    >
                                        <option value="name">{{ $t('fields.name') }}</option>
                                        <option value="code">{{ $t('fields.code') }}</option>
                                        <option value="category">{{ $t('fields.category') }}</option>
                                    </select>
                                    <input
                                        v-model="searchQuery"
                                        type="text"
                                        :placeholder="$t('pos.search_products')"
                                        class="px-2 sm:px-3 py-1 rounded-md border border-gray-200 text-sm focus:outline-none focus:border-gray-400 flex-grow sm:flex-grow-0 sm:w-48"
                                    />
                                </div>
                            </div>
                            <!-- End Header -->

                            <!-- Products Grid -->
                            <div class="px-3 sm:px-5 mt-5 overflow-y-auto" style="height: calc(100vh - 200px);">
                                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-3 sm:gap-4 pb-4">
                                    <div
                                        v-for="(product, index) in filteredProducts" 
                                        :key="product.id"
                                        role="button"
                                        class="select-none cursor-pointer transition-all duration-200 rounded-lg bg-white shadow-md hover:shadow-lg border border-gray-200 flex flex-col justify-between overflow-hidden group"
                                        :title="product.name"
                                        @click="addToCart(product)"
                                    >
                                        <!-- Product Image -->
                                        <div class="relative overflow-hidden bg-gray-50">
                                            <img 
                                                :src="getProductImage(product)" 
                                                class="w-full h-32 sm:h-40 object-cover group-hover:scale-105 transition-transform duration-200" 
                                                :alt="product.name"
                                                loading="lazy"
                                            >
                                            <!-- Stock Badge -->
                                            <div class="absolute top-2 left-2">
                                                <span 
                                                    v-if="product.quantity > 0" 
                                                    class="text-xs font-semibold inline-block py-1 px-2 rounded-full text-emerald-700 bg-emerald-100 border border-emerald-200"
                                                >
                                                    {{ product.quantity }}{{ product.unit_type?.symbol }}
                                                </span>
                                                <span 
                                                    v-else 
                                                    class="text-xs font-semibold inline-block py-1 px-2 rounded-full text-red-700 bg-red-100 border border-red-200"
                                                >
                                                    {{ $t('pos.out_of_stock') }}
                                                </span>
                                            </div>
                                        </div>
                                        
                                        <!-- Product Info -->
                                        <div class="p-3 flex-grow flex flex-col justify-between">
                                            <div>
                                                <h3 class="font-medium text-sm text-gray-800 line-clamp-2 mb-1" :title="product.name">
                                                    {{ product.name }}
                                                </h3>
                                                <p class="text-xs text-gray-500 mb-2">{{ product.product_code }}</p>
                                            </div>
                                            <div class="flex justify-between items-center">
                                                <span class="font-bold text-sm text-gray-900">
                                                    {{ getCurrency() }}{{ numberFormat(product.selling_price) }}
                                                </span>
                                                <button 
                                                    class="bg-blue-500 hover:bg-blue-600 text-white text-xs px-2 py-1 rounded transition-colors duration-200"
                                                    :disabled="product.quantity < 1"
                                                    :class="product.quantity < 1 ? 'opacity-50 cursor-not-allowed' : ''"
                                                >
                                                    {{ $t('pos.add_to_cart') }}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Products Grid -->
                        </div>
                        <!-- End Products Section -->

                        <!-- Cart Sidebar -->
                        <div class="w-full lg:w-2/5 xl:w-1/3 bg-gray-50 border-l border-gray-200">
                            <!-- Cart Header -->
                            <div class="flex flex-row items-center justify-between px-4 sm:px-5 py-4 bg-white border-b border-gray-200 sticky top-0 z-10">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-shopping-cart text-blue-500"></i>
                                    <span class="font-bold text-lg sm:text-xl text-gray-800">{{ $t('pos.cart') }}</span>
                                    <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2 py-1 rounded-full">
                                        {{ carts.total }}
                                    </span>
                                </div>
                                <button
                                    @click="carts.total > 0 ? deleteCartAllItems() : null"
                                    :disabled="carts.total === 0"
                                    class="px-3 py-1.5 rounded-md text-sm font-medium transition-colors duration-200"
                                    :class="carts.total > 0 ? 'bg-red-100 text-red-600 hover:bg-red-200' : 'bg-gray-100 text-gray-400 cursor-not-allowed'"
                                >
                                    <i class="fas fa-trash-alt mr-1"></i>
                                    {{ $t('pos.clear') }}
                                </button>
                            </div>
                            <!-- End Cart Header -->

                            <!-- Cart Items -->
                            <div class="overflow-y-auto" style="height: calc(100vh - 500px); min-height: 200px;">
                                <div v-if="carts.data.length === 0" class="flex flex-col items-center justify-center h-full text-gray-500 p-8">
                                    <i class="fas fa-shopping-cart text-4xl mb-4 opacity-50"></i>
                                    <p class="text-center">{{ $t('pos.empty_cart') }}</p>
                                </div>
                                
                                <div v-else class="p-3 space-y-2">
                                    <div
                                        v-for="cart in carts.data"
                                        :key="cart.id"
                                        class="bg-white rounded-md border border-gray-200 p-3 transition-all duration-200"
                                        :class="cart.quantity > cart.product.quantity ? 'border-red-300 bg-red-50' : 'hover:shadow-sm'"
                                    >
                                        <!-- Product Header with Quantity Controls -->
                                        <div class="flex items-center justify-between">
                                            <div class="flex-grow min-w-0 mr-3">
                                                <h4 class="font-medium text-sm text-gray-800 truncate" :title="cart.product.name">
                                                    {{ cart.product.name }}
                                                </h4>
                                                <div class="flex items-center justify-between mt-1">
                                                    <span class="text-xs text-gray-500">
                                                        {{ $t('pos.available') }}: {{ numberFormat(cart.product.quantity) }} {{ cart.product.unit_type?.symbol }}
                                                    </span>
                                                    <span class="text-xs text-gray-600">
                                                        {{ getCurrency() }}{{ numberFormat(cart.product.selling_price) }}
                                                    </span>
                                                </div>
                                            </div>
                                            
                                            <!-- Quantity Controls -->
                                            <div class="flex items-center gap-2">
                                                <div class="flex items-center gap-1">
                                                    <button
                                                        @click="decrementCartQuantity(cart)"
                                                        class="w-8 h-8 rounded bg-gray-200 hover:bg-gray-300 flex items-center justify-center text-gray-600 transition-colors duration-200"
                                                        :disabled="cart.quantity <= 1"
                                                    >
                                                        <i class="fas fa-minus text-xs"></i>
                                                    </button>
                                                    <input
                                                        @keyup.enter="insertCartQuantity(cart, $event.target.value)"
                                                        type="number"
                                                        class="w-14 h-8 text-center border border-gray-300 rounded text-sm font-medium focus:outline-none focus:border-blue-500"
                                                        :value="cart.quantity"
                                                        min="1"
                                                    >
                                                    <button
                                                        @click="incrementCartQuantity(cart)"
                                                        class="w-8 h-8 rounded bg-gray-200 hover:bg-gray-300 flex items-center justify-center text-gray-600 transition-colors duration-200"
                                                        :disabled="cart.quantity >= cart.product.quantity"
                                                    >
                                                        <i class="fas fa-plus text-xs"></i>
                                                    </button>
                                                </div>
                                                
                                                <!-- Remove Button -->
                                                <button
                                                    @click="deleteCart(cart)"
                                                    class="text-red-500 hover:text-red-700 p-1 rounded transition-colors duration-200"
                                                    :title="$t('pos.remove_item')"
                                                >
                                                    <i class="fas fa-trash-alt text-xs"></i>
                                                </button>
                                            </div>
                                        </div>
                                        
                                        <!-- Stock Warning -->
                                        <div v-if="cart.quantity > cart.product.quantity" class="mt-2 p-2 bg-red-100 border border-red-200 rounded">
                                            <p class="text-xs text-red-700">
                                                <i class="fas fa-exclamation-triangle mr-1"></i>
                                                {{ $t('pos.insufficient_stock') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Cart Items -->
                            <!-- Cart Summary -->
                            <div class="bg-white border-t border-gray-200 p-4 sm:p-5 space-y-4">
                                <!-- Totals -->
                                <div class="bg-gray-50 rounded-lg p-4 space-y-4">
                                    <div class="flex justify-between items-center text-sm">
                                        <span class="text-gray-600">{{ $t('pos.subtotal') }}</span>
                                        <span class="font-semibold">{{ getCurrency() }}{{ numberFormat(cartSubtotal) }}</span>
                                    </div>
                                    <div class="flex justify-between items-center text-sm">
                                        <span class="text-gray-600">{{ $t('pos.sales_tax') }} ({{ tax }}%)</span>
                                        <span class="font-semibold">{{ getCurrency() }}{{ numberFormat(totalTax) }}</span>
                                    </div>
                                    <!-- <div class="flex justify-between items-center text-sm">
                                        <span class="text-gray-600">
                                            {{ $t('pos.discount') }}
                                            <span v-if="discountType === 'fixed'">({{ getCurrency() }}{{ discount }})</span>
                                            <span v-else>({{ discount }}%)</span>
                                        </span>
                                        <span class="font-semibold text-red-600">-{{ getCurrency() }}{{ numberFormat(totalDiscount) }}</span>
                                    </div> -->
                                    
                                    <!-- Custom Discount Section -->
                                    <div class="bg-white rounded-lg border border-gray-200 p-3 space-y-3">
                                        <div class="flex items-center justify-between">
                                            <label class="text-sm font-medium text-gray-700">{{ $t('pos.custom_discount') }}</label>
                                            <div class="flex items-center gap-2">
                                                <button
                                                    @click="form.custom_discount.discount_type = 'fixed'"
                                                    class="px-3 py-1 text-xs font-medium rounded-md transition-colors duration-200"
                                                    :class="form.custom_discount.discount_type === 'fixed' 
                                                        ? 'bg-blue-100 text-blue-700 border border-blue-300' 
                                                        : 'bg-gray-100 text-gray-600 border border-gray-300 hover:bg-gray-200'"
                                                >
                                                    {{ getCurrency() }}
                                                </button>
                                                <button
                                                    @click="form.custom_discount.discount_type = 'percentage'"
                                                    class="px-3 py-1 text-xs font-medium rounded-md transition-colors duration-200"
                                                    :class="form.custom_discount.discount_type === 'percentage' 
                                                        ? 'bg-blue-100 text-blue-700 border border-blue-300' 
                                                        : 'bg-gray-100 text-gray-600 border border-gray-300 hover:bg-gray-200'"
                                                >
                                                    %
                                                </button>
                                            </div>
                                        </div>
                                        
                                        <div class="flex items-center gap-2">
                                            <input
                                                v-model="form.custom_discount.discount"
                                                type="number"
                                                step="0.01"
                                                min="0"
                                                class="flex-1 px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                :placeholder="form.custom_discount.discount_type === 'fixed' ? '0.00' : '0'"
                                                :max="form.custom_discount.discount_type === 'percentage' ? 100 : cartSubtotal"
                                            >
                                            <span class="text-sm text-gray-500 min-w-0">
                                                {{ form.custom_discount.discount_type === 'fixed' ? getCurrency() : '%' }}
                                            </span>
                                        </div>
                                        
                                        <div class="flex justify-between items-center text-sm">
                                            <span class="text-gray-600">{{ $t('pos.discount_amount') }}</span>
                                            <span class="font-semibold text-green-600">
                                                <span v-if="form.custom_discount.discount_type === 'fixed'">
                                                    -{{ getCurrency() }}{{ numberFormat(form.custom_discount.discount) }}
                                                </span>
                                                <span v-else>
                                                    -{{ getCurrency() }}{{ numberFormat(cartSubtotal * (form.custom_discount.discount / 100)) }}
                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <!-- Total -->
                                    <div class="flex justify-between items-center pt-3 border-t-2 border-gray-300">
                                        <span class="text-lg font-bold text-gray-800">{{ $t('pos.total') }}</span>
                                        <span class="text-xl font-bold text-blue-600">{{ getCurrency() }}{{ numberFormat(form.total) }}</span>
                                    </div>
                                </div>

                                <!-- Customer & Payment Section -->
                                <div class="space-y-4">
                                    <!-- Customer Selection -->
                                    <div class="bg-white rounded-lg border border-gray-200 p-4">
                                        <label for="customer" class="block text-sm font-medium text-gray-700 mb-2">
                                            {{ $t('fields.customer') }}
                                        </label>
                                        <AsyncVueSelect
                                            v-model="form.customer_id"
                                            resource="customers.index"
                                            :placeholder="$t('pos.select_customer')"
                                            class="w-full"
                                        />
                                        <InputError :message="form.errors.customer_id" class="mt-1"/>
                                    </div>

                                    <!-- Payment Method & Amount -->
                                    <div class="bg-white rounded-lg border border-gray-200 p-4 space-y-4">
                                        <h3 class="text-sm font-medium text-gray-700">{{ $t('pos.payment_method_and_amount') }}</h3>
                                        
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                            <!-- Payment Method -->
                                            <div>
                                                <label class="block text-xs font-medium text-gray-600 mb-1">{{ $t('pos.payment_method') }}</label>
                                                <select
                                                    id="paid_through"
                                                    v-model="form.paid_through"
                                                    class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                >
                                                    <option
                                                        v-for="(orderPaidByType, index) in orderPaidByTypes"
                                                        :key="index"
                                                        :value="orderPaidByType.value"
                                                    >
                                                        {{ orderPaidByType.label }}
                                                    </option>
                                                </select>
                                            </div>
                                            
                                            <!-- Paid Amount -->
                                            <div>
                                                <label class="block text-xs font-medium text-gray-600 mb-1">{{ $t('pos.paid_amount') }}</label>
                                                <input
                                                    id="paid"
                                                    :placeholder="$t('pos.enter_paid_amount')"
                                                    v-model="form.paid"
                                                    type="number"
                                                    class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                    min="0"
                                                    step="0.01"
                                                />
                                            </div>
                                        </div>
                                        
                                        <!-- Change Amount -->
                                        <div v-if="form.paid && form.paid >= form.total" class="bg-green-50 border border-green-200 rounded-md p-3">
                                            <div class="flex justify-between items-center">
                                                <span class="text-sm font-medium text-green-700">{{ $t('pos.change') }}</span>
                                                <span class="text-sm font-bold text-green-800">
                                                    {{ getCurrency() }}{{ numberFormat(form.paid - form.total) }}
                                                </span>
                                            </div>
                                        </div>
                                        
                                        <InputError :message="form.errors.paid" class="mt-1"/>
                                    </div>
                                </div>

                                <!-- Pay Button -->
                                <SubmitButton
                                    @click="createOrder"
                                    :processing="form.processing"
                                    :disabled="!carts.total || form.processing"
                                    class="w-full py-3 px-4 bg-blue-600 hover:bg-blue-700 disabled:bg-gray-400 disabled:cursor-not-allowed text-white font-semibold rounded-lg transition-colors duration-200 flex items-center justify-center gap-2"
                                >
                                    <i class="fas fa-credit-card"></i>
                                    {{ $t('pos.pay_and_print') }}
                                </SubmitButton>
                            </div>
                            <!-- End Cart Summary -->
                        </div>
                        <!-- End Cart Sidebar -->
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
/* Custom CSS to hide the spinner */
input[type="number"]::-webkit-outer-spin-button,
input[type="number"]::-webkit-inner-spin-button {
    -webkit-appearance: none;
}

input[type="number"] {
    -moz-appearance: textfield;
}

/* Line clamp utility for product names */
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Smooth transitions */
.transition-all {
    transition-property: all;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
}

/* Custom scrollbar for webkit browsers */
.overflow-y-auto::-webkit-scrollbar {
    width: 6px;
}

.overflow-y-auto::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 3px;
}

.overflow-y-auto::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 3px;
}

.overflow-y-auto::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}

/* Mobile-specific adjustments */
@media (max-width: 640px) {
    .grid-cols-2 {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}

/* Tablet-specific adjustments */
@media (min-width: 641px) and (max-width: 1024px) {
    .sm\:grid-cols-3 {
        grid-template-columns: repeat(3, minmax(0, 1fr));
    }
}
</style>
