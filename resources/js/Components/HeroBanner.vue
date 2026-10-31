<script setup>
import { ArrowRight } from 'lucide-vue-next';
defineEmits(['shop-now']);
</script>

<template>
    <section
        class="bg-gradient-to-r from-blue-50 via-blue-100/60 to-blue-50 rounded-3xl p-6 sm:p-10 border border-blue-100 relative overflow-hidden flex flex-col md:flex-row items-center justify-between gap-8 shadow-sm">
        <div class="max-w-lg z-10 space-y-4 text-left">
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-slate-900 tracking-tight leading-tight">
                Find Your Perfect Gadget
            </h1>
            <p class="text-slate-600 text-sm sm:text-base leading-relaxed">
                Explore the latest electronics and get instant help from our AI shopping assistant.
            </p>
            <div>
                <button @click="$emit('shop-now')"
                    class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-xl shadow-lg shadow-blue-600/25 transition-all transform hover:-translate-y-0.5 text-sm">
                    <span>Shop Now</span>
                    <ArrowRight class="w-4 h-4" />
                </button>
            </div>
        </div>

        <!-- Hero Images Showcase -->
        <div class="relative w-full md:w-auto flex justify-center z-10">
            <div class="relative w-72 sm:w-80 h-52 sm:h-60 flex items-center justify-center">
                <img src="https://images.unsplash.com/photo-1517336714731-489689fd1ca8?auto=format&fit=crop&w=600&q=80"
                    alt="Laptop"
                    class="absolute -left-6 top-4 w-44 sm:w-52 rounded-xl shadow-xl border border-white object-cover transform -rotate-3 hover:rotate-0 transition-transform duration-300">
                <img src="https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?auto=format&fit=crop&w=400&q=80"
                    alt="Smartphone"
                    class="absolute right-0 -top-2 w-28 sm:w-32 rounded-xl shadow-2xl border-2 border-white object-cover transform rotate-6 hover:rotate-0 transition-transform duration-300">
                <img src="https://images.unsplash.com/photo-1572569511254-d8f925fe2cbb?auto=format&fit=crop&w=300&q=80"
                    alt="Earbuds"
                    class="absolute right-12 bottom-0 w-20 sm:w-24 rounded-lg shadow-lg border-2 border-white object-cover">
                <img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=300&q=80"
                    alt="Smartwatch"
                    class="absolute -left-2 bottom-2 w-20 sm:w-24 rounded-lg shadow-lg border-2 border-white object-cover">
            </div>
        </div>
    </section>
</template>