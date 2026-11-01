<script setup>
import AuthBrand from '@/Components/Auth/AuthBrand.vue';
</script>

<template>
    <div class="min-h-screen bg-gray-50 lg:grid lg:grid-cols-2">

        <!-- Left side: Branding -->
        <div class="relative hidden overflow-hidden bg-indigo-700 p-12 lg:flex lg:flex-col lg:justify-between">
            <div class="absolute -right-32 -top-32 h-96 w-96 rounded-full bg-indigo-500/30 blur-3xl"></div>
            <div class="absolute -bottom-32 -left-32 h-96 w-96 rounded-full bg-purple-500/30 blur-3xl"></div>

            <div class="relative z-10">
                <div class="inline-flex rounded-xl bg-white p-3">
                    <AuthBrand />
                </div>
            </div>

            <div class="relative z-10 max-w-lg text-white">
                <span class="rounded-full bg-white/10 px-4 py-2 text-xs font-medium tracking-wide">
                    AI-POWERED SHOPPING
                </span>

                <h2 class="mt-8 text-5xl font-bold leading-tight">
                    Find the right product with intelligent AI.
                </h2>

                <p class="mt-6 text-lg leading-8 text-indigo-100">
                    Explore products, compare specifications, and discover
                    smarter shopping recommendations with LearnAI.
                </p>

                <div class="mt-10 flex items-center gap-3">
                    <div class="flex -space-x-3">
                        <div
                            class="flex h-10 w-10 items-center justify-center rounded-full border-2 border-indigo-700 bg-amber-300 text-sm font-bold text-gray-900">
                            A</div>
                        <div
                            class="flex h-10 w-10 items-center justify-center rounded-full border-2 border-indigo-700 bg-emerald-300 text-sm font-bold text-gray-900">
                            B</div>
                        <div
                            class="flex h-10 w-10 items-center justify-center rounded-full border-2 border-indigo-700 bg-pink-300 text-sm font-bold text-gray-900">
                            C</div>
                    </div>

                    <p class="text-sm text-indigo-100">
                        Your smarter shopping experience starts here.
                    </p>
                </div>
            </div>

            <p class="relative z-10 text-xs text-indigo-200">
                © {{ new Date().getFullYear() }} LearnAI. All rights reserved.
            </p>
        </div>

        <!-- Right side: Auth form -->
        <div class="flex min-h-screen items-center justify-center px-5 py-12 sm:px-10">
            <div class="w-full max-w-md">

                <div class="mb-10 lg:hidden">
                    <AuthBrand />
                </div>

                <slot />

                <p class="mt-10 text-center text-xs text-gray-400">
                    © {{ new Date().getFullYear() }} LearnAI. All rights reserved.
                </p>
            </div>
        </div>
    </div>
</template>