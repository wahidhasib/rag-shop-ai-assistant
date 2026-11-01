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
    token: String,
    email: String,
});

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('password.store'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <div>
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-900">
                Reset your password
            </h2>

            <p class="mt-2 text-sm text-gray-500">
                Create a new password for your LearnAI account.
            </p>
        </div>

        <form @submit.prevent="submit" class="space-y-5">
            <AuthInput v-model="form.email" label="Email address" type="email" autocomplete="username"
                :error="form.errors.email" />

            <AuthInput v-model="form.password" label="New password" type="password" placeholder="Enter new password"
                autocomplete="new-password" :error="form.errors.password" />

            <AuthInput v-model="form.password_confirmation" label="Confirm new password" type="password"
                placeholder="Confirm new password" autocomplete="new-password" />

            <AuthButton :loading="form.processing">
                Reset password
            </AuthButton>
        </form>

        <div class="mt-8 text-center">
            <Link :href="route('login')" class="text-sm font-semibold text-indigo-600 hover:text-indigo-700">
                Back to sign in
            </Link>
        </div>
    </div>
</template>