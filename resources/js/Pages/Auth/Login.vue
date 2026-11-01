<script setup>
import AuthButton from '@/Components/Auth/AuthButton.vue';
import AuthCheckbox from '@/Components/Auth/AuthCheckbox.vue';
import AuthInput from '@/Components/Auth/AuthInput.vue';
import AuthLayout from '@/Layouts/AuthLayout.vue';
import { Link, useForm } from '@inertiajs/vue3';

defineOptions({
    layout: AuthLayout,
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <div>
        <div class="mb-8">
            <h2 class="text-3xl font-bold tracking-tight text-gray-900">
                Welcome back!
            </h2>

            <p class="mt-2 text-sm text-gray-500">
                Sign in to continue your shopping experience.
            </p>
        </div>

        <div v-if="$page.props.flash?.status" class="mb-5 rounded-xl bg-green-50 p-3 text-sm text-green-700">
            {{ $page.props.flash.status }}
        </div>

        <form @submit.prevent="submit" class="space-y-5">
            <AuthInput v-model="form.email" label="Email address" type="email" placeholder="you@example.com"
                autocomplete="username" :error="form.errors.email" />

            <div>
                <AuthInput v-model="form.password" label="Password" type="password" placeholder="Enter your password"
                    autocomplete="current-password" :error="form.errors.password" />

                <div class="mt-3 flex justify-between">
                    <AuthCheckbox v-model="form.remember" label="Remember me" />

                    <Link :href="route('password.request')"
                        class="text-sm font-medium text-indigo-600 hover:text-indigo-700">
                        Forgot password?
                    </Link>
                </div>
            </div>

            <AuthButton :loading="form.processing">
                Sign in
            </AuthButton>
        </form>

        <div class="mt-8 text-center">
            <p class="text-sm text-gray-500">
                Don't have an account?

                <Link :href="route('register')" class="font-semibold text-indigo-600 hover:text-indigo-700">
                    Create account
                </Link>
            </p>
        </div>
    </div>
</template>