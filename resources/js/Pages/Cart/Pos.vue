<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, router} from '@inertiajs/vue3';
import {useForm} from '@inertiajs/vue3';
import {watch, ref, computed} from 'vue';
import AsyncVueSelect from "@/Components/AsyncVueSelect.vue";
import {getCurrency, numberFormat, showToast, truncateString} from "@/Utils/Helper.js";
import InputError from "@/Components/InputError.vue";
import SubmitButton from "@/Components/SubmitButton.vue";

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

const searchQuery = ref('');
const searchType = ref('code'); // name, code, category
const barcodeInput = ref(null);

// Handle barcode scanner input
const handleBarcodeInput = (event) => {
    if (event.key === 'Enter') {
        const product = props.products.data.find(p => p.product_code === searchQuery.value);
        if (product) {
            addToCart(product);
            searchQuery.value = '';
        }
    }
};

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
        form.total = numberFormat(newProps.total - (newProps.cartSubtotal * (form.custom_discount.discount / 100)).toFixed(2));
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
    <Head title="Product"/>
    <AuthenticatedLayout>
        <template #breadcrumb>
            POS
        </template>
        <div class="flex flex-wrap">
            <div class="w-full px-4">
                <div class="relative -mt-16 flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded bg-white">
                    <div class="flex lg:flex-row flex-col-reverse shadow-lg">
                        <!-- left section -->
                        <div class="lg:w-4/5 min-h-screen shadow-lg overflow-auto max-h-screen">
                            <!-- header -->
                            <div class="flex flex-row justify-between items-center px-5 mt-5">
                                <div class="text-gray-800">
                                    <div class="font-bold text-xl">Products</div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <input
                                        ref="barcodeInput"
                                        v-model="searchQuery"
                                        type="text"
                                        placeholder="Scan barcode or enter product code..."
                                        class="px-3 py-1 rounded-md border border-gray-200 text-sm focus:outline-none focus:border-gray-400 w-full"
                                        @keyup="handleBarcodeInput"
                                        autofocus
                                    />
                                </div>
                            </div>
                            <!-- end header -->

                            <!-- products -->
                            <div class="grid grid-cols-3 gap-6 px-5 mt-5 overflow-y-auto">
                                <div
                                    v-for="(product, index) in filteredProducts" :key="product.id"
                                    role="button"
                                    class="select-none cursor-pointer transition-shadow rounded-lg bg-white shadow-md hover:shadow-xl border border-gray-200 flex flex-col justify-between min-h-[120px] p-4"
                                    :title="product.name"
                                    @click="addToCart(product)"
                                >
                                    <div class="flex flex-col gap-2">
                                        <div class="flex justify-between items-start">
                                            <span v-if="product.quantity > 0" class="text-xs font-medium px-2 py-1 rounded bg-emerald-100 text-emerald-700">{{ product.quantity }}{{ product.unit_type?.symbol }}</span>
                                            <span v-if="product.quantity < 1" class="text-xs font-medium px-2 py-1 rounded bg-red-100 text-red-700">Out of Stock</span>
                                            <p class="text-xs text-gray-500">Code: {{ product.product_code }}</p>
                                        </div>
                                        <h3 class="text-base font-medium text-gray-800">{{ product.name }}</h3>
                                        <p class="text-xl font-bold text-emerald-600">{{ getCurrency() }}{{ numberFormat(product.selling_price) }}</p>
                                    </div>
                                </div>
                            </div>
                            <!-- end products -->
                        </div>
                        <!-- end left section -->

                        <!-- right section -->
                        <div class="lg:w-2/5">
                            <!-- header -->
                            <div class="flex flex-row items-center justify-between px-5 mt-5">
                                <div class="font-bold text-xl">Cart</div>
                                <div class="font-semibold">
                                    <span
                                        @click="carts.total > 0 ? deleteCartAllItems() : null"
                                        :role="carts.total > 0 ? 'button' : null"
                                        class="px-4 py-2 rounded-md bg-red-100 text-red-500"
                                    >Clear({{ carts.total }})</span>
                                </div>
                            </div>
                            <!-- end header -->
                            <!-- order list -->
                            <div class="px-3 py-2 overflow-y-auto h-64">

                                <div
                                    v-for="cart in carts.data"
                                    :key="cart.id"
                                    class="flex flex-row justify-between items-center mb-3" :class="cart.quantity > cart.product.quantity ? 'bg-red-200' : ''">
                                    <div class="flex flex-row items-center w-2/5" :title="cart.product.name">
                                        <span class="text-sm font-medium" :title="cart.product.name">
                                            {{ truncateString(cart.product.name, 20) }}
                                            <br>
                                            <span class="text-xs text-gray-600">Q: {{ numberFormat(cart.product.quantity) }} {{ cart.product.unit_type?.symbol }}</span>
                                        </span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span role="button" @click="decrementCartQuantity(cart)" class="px-2 py-0.5 rounded-l-md bg-gray-300 text-sm">-</span>
                                        <input @keyup.enter="insertCartQuantity(cart, $event.target.value)" type="text" style="padding: 0;" class="font-medium border-gray-300 p-0 w-6 text-center text-sm" :value="cart.quantity">
                                        <span @click="incrementCartQuantity(cart)" role="button" class="px-2 py-0.5 rounded-r-md bg-gray-300 text-sm">+</span>
                                    </div>
                                    <div class="font-medium text-base w-16 text-center">
                                        {{ getCurrency() }}{{ numberFormat(cart.quantity * cart.product.selling_price) }}
                                    </div>
                                    <i @click="deleteCart(cart)" role="button" class="fa fa-trash-alt text-red-500 text-sm"></i>
                                </div>

                            </div>
                            <!-- end order list -->
                            <!-- totalItems -->
                            <div class="px-5 mt-1">
                                <div class="pt-2 rounded-md shadow-lg">
                                    <div class=" px-4 flex justify-between ">
                                        <span class="font-semibold text-sm">Subtotal</span>
                                        <span class="font-bold">{{ getCurrency() }}{{ cartSubtotal.toFixed(2) }}</span>
                                    </div>
                                    <div class=" px-4 flex justify-between ">
                                        <span class="font-semibold text-sm">Sales Tax({{ tax }}%)</span>
                                        <span class="font-bold">{{ getCurrency() }}{{ totalTax }}</span>
                                    </div>
                                    <div class=" px-4 flex justify-between ">
                                        <span v-if="discountType === 'fixed'" class="font-semibold text-sm">Discount({{ getCurrency()}}{{ discount }})</span>
                                        <span v-else class="font-semibold text-sm">Discount({{ discount }}%)</span>
                                        <span class="font-bold">- {{ getCurrency() }}{{ totalDiscount }}</span>
                                    </div>
                                    <div class=" px-4 flex justify-between items-center">
                                        <div class="text-sm flex items-center flex-wrap">
                                            <span class="font-semibold text-sm mr-1">Custom Discount - </span>
                                            <div class="flex">
                                                <select
                                                    v-model="form.custom_discount.discount_type"
                                                    class="px-3 py-0 w-14 rounded-l-md bg-gray-300 border-none"
                                                >
                                                    <option value="fixed">=</option>
                                                    <option value="percentage">%</option>
                                                </select>
                                                <input
                                                    v-model="form.custom_discount.discount"
                                                    type="text"
                                                    class="font-semibold border-gray-300 px-0.5 py-1 w-10 text-center"
                                                >
                                            </div>
                                        </div>
                                        <span v-if="form.custom_discount.discount_type === 'fixed'" class="font-bold">- {{ getCurrency() }}{{ form.custom_discount.discount }}</span>
                                        <span v-else class="font-bold">- {{ getCurrency() }}{{ numberFormat(cartSubtotal * (form.custom_discount.discount / 100)) }}</span>
                                    </div>
                                    <div class="border-t-2 mt-3 py-2 px-4 flex items-center justify-between">
                                        <span class="font-semibold text-2xl">Total</span>
                                        <span class="font-bold text-2xl">{{ getCurrency() }}{{ form.total }}</span>
                                    </div>
                                </div>
                            </div>
                            <!-- end total -->
                            <!-- cash -->
                            <div class="px-5 mt-1">
                                <div class="rounded-md shadow-lg px-4 py-4">
                                    <div>
                                        <label for="customer" class="text-stone-600 text-sm font-medium">Customer</label>
                                        <AsyncVueSelect
                                            v-model="form.customer_id"
                                            class="my-1"
                                            resource="customers.index"
                                            placeholder="Select Customer"
                                        />
                                        <InputError :message="form.errors.customer_id"/>
                                    </div>

                                    <div>
                                        <label for="paid" class="text-stone-600 text-sm font-medium">Pay</label>
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
                                                placeholder="Enter paid amount"
                                                v-model="form.paid"
                                                type="text"
                                                class="w-full rounded-r-md border border-gray-200 px-2 py-2 shadow-sm outline-none focus:outline-none focus:shadow-outline"
                                            />
                                        </div>
                                        <InputError :message="form.errors.paid"/>
                                    </div>
                                </div>
                            </div>
                            <!-- end cash -->
                            <!-- button pay-->
                            <div class="px-5 mt-3 mb-4">
                                <SubmitButton
                                    @click="createOrder"
                                    :processing="form.processing"
                                    class="w-full px-4 py-4 rounded-md shadow-lg text-center bg-emerald-500 text-white font-semibold focus:outline-none"
                                    :class="!carts.total ? 'cursor-not-allowed' : ''"
                                >Pay & Print</SubmitButton>
                            </div>
                            <!-- end button pay -->
                        </div>
                        <!-- end right section -->
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>


