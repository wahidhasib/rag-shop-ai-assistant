<script setup>
import AuthButton from '@/Components/Auth/AuthButton.vue';
import AuthInput from '@/Components/Auth/AuthInput.vue';
import AuthLayout from '@/Layouts/AuthLayout.vue';
import { Link, useForm } from '@inertiajs/vue3';
import { route } from 'ziggy-js';

defineOptions({
    layout: AuthLayout,
});

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <div>
        <div class="mb-8">
            <h2 class="text-3xl font-bold tracking-tight text-gray-900">
                Create your account
            </h2>

            <p class="mt-2 text-sm text-gray-500">
                Join LearnAI and experience smarter shopping.
            </p>
        </div>

        <form @submit.prevent="submit" class="space-y-5">
            <AuthInput v-model="form.name" label="Full name" placeholder="Enter your full name" autocomplete="name"
                :error="form.errors.name" />

            <AuthInput v-model="form.email" label="Email address" type="email" placeholder="you@example.com"
                autocomplete="username" :error="form.errors.email" />

            <AuthInput v-model="form.password" label="Password" type="password" placeholder="Create a password"
                autocomplete="new-password" :error="form.errors.password" />

            <AuthInput v-model="form.password_confirmation" label="Confirm password" type="password"
                placeholder="Confirm your password" autocomplete="new-password" />

            <AuthButton :loading="form.processing">
                Create account
            </AuthButton>
        </form>

        <div class="mt-8 text-center">
            <p class="text-sm text-gray-500">
                Already have an account?

                <Link :href="route('login')" class="font-semibold text-indigo-600 hover:text-indigo-700">
                    Sign in
                </Link>
            </p>
        </div>
    </div>
</template>