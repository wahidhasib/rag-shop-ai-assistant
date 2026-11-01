<script setup>
import AuthButton from '@/Components/Auth/AuthButton.vue';
import AuthInput from '@/Components/Auth/AuthInput.vue';
import AuthLayout from '@/Layouts/AuthLayout.vue';
import { Link, useForm } from '@inertiajs/vue3';
import { route } from 'ziggy-js';

defineOptions({
    layout: AuthLayout,
});

const props = defineProps({
    status: String,
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>
    <div>
        <div class="mb-8">
            <div class="mb-5 flex h-14 w-14 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-600">
                <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7"
                        d="M12 15v2m-6 4h12a2 2 0 002-2v-7a2 2 0 00-2-2H6a2 2 0 00-2 2v7a2 2 0 002 2zm12-9V7a6 6 0 00-12 0v3" />
                </svg>
            </div>

            <h2 class="text-3xl font-bold text-gray-900">
                Forgot password?
            </h2>

            <p class="mt-2 text-sm leading-6 text-gray-500">
                No worries! Enter your email address and we'll send you
                instructions to reset your password.
            </p>
        </div>

        <div v-if="status" class="mb-5 rounded-xl bg-green-50 p-3 text-sm text-green-700">
            {{ status }}
        </div>

        <form @submit.prevent="submit" class="space-y-5">
            <AuthInput v-model="form.email" label="Email address" type="email" placeholder="you@example.com"
                autocomplete="username" :error="form.errors.email" />

            <AuthButton :loading="form.processing">
                Send reset link
            </AuthButton>
        </form>

        <div class="mt-8 text-center">
            <Link :href="route('login')" class="text-sm font-semibold text-indigo-600 hover:text-indigo-700">
                ← Back to sign in
            </Link>
        </div>
    </div>
</template>