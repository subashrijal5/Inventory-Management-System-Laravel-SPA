<script setup>
import InputError from '@/Components/InputError.vue';
import {Link, useForm, usePage} from '@inertiajs/vue3';
import SubmitButton from "@/Components/SubmitButton.vue";
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const user = usePage().props.auth.user;

const form = useForm({
    name: user.name,
    email: user.email,
});
</script>

<template>
    <h6 class="text-blueGray-400 text-sm mt-3 mb-6 font-bold uppercase">
        {{ $t('profile.user_information') }}
    </h6>
    <form @submit.prevent="form.patch(route('profile.update'), {preserveScroll: true})">
        <div class="flex flex-wrap">
            <div class="w-full lg:w-6/12 px-4">
                <div class="relative w-full mb-3">
                    <label
                        class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                        for="name"
                    >
                        {{ $t('fields.name') }}
                    </label>
                    <input
                        id="name"
                        type="text"
                        class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                        v-model="form.name"
                        required
                        autofocus
                        autocomplete="name"
                    />
                    <InputError :message="form.errors.name"/>
                </div>
            </div>
            <div class="w-full lg:w-6/12 px-4">
                <div class="relative w-full mb-3">
                    <label
                        class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                        for="email"
                    >
                        {{ $t('fields.email') }}
                    </label>
                    <input
                        id="email"
                        type="email"
                        class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                        v-model="form.email"
                        required
                        autocomplete="username"
                    />
                    <InputError :message="form.errors.email"/>
                </div>
            </div>

            <div v-if="mustVerifyEmail && user.email_verified_at === null">
                <p class="text-sm px-4 text-gray-800">
                    {{ $t('profile.email_unverified') }}
                    <Link
                        :href="route('verification.send')"
                        method="post"
                        as="button"
                        class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        {{ $t('profile.resend_verification') }}
                    </Link>
                </p>

                <div
                    v-show="status === 'verification-link-sent'"
                    class="px-4 font-medium text-sm text-emerald-500"
                >
                    {{ $t('profile.verification_link_sent') }}
                </div>
            </div>

            <div class="w-full px-4 flex justify-end">
                <SubmitButton
                    :processing="form.processing"
                    class="bg-emerald-500 text-white active:bg-emerald-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 ease-linear transition-all duration-150"
                >
                    {{ $t('actions.save') }}
                    <Transition
                        enter-active-class="transition ease-in-out"
                        enter-from-class="opacity-0"
                        leave-active-class="transition ease-in-out"
                        leave-to-class="opacity-0"
                    >
                        <i v-if="form.recentlySuccessful" class="fas fa-check-circle"></i>
                    </Transition>
                </SubmitButton>
            </div>
        </div>
    </form>
</template>
