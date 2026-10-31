<script setup>
import { Headphones, Laptop, Smartphone, Watch } from 'lucide-vue-next';
defineEmits(['filter']);
</script>

<template>
    <section class="space-y-4">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-slate-900 tracking-tight">Categories</h2>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            <div @click="$emit('filter', 'Laptop')"
                class="bg-white p-5 rounded-2xl border border-slate-200/80 hover:border-blue-500 hover:shadow-md transition-all cursor-pointer flex flex-col items-center text-center group">
                <div
                    class="w-14 h-14 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 mb-3 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                    <Laptop class="w-6 h-6" />
                </div>
                <span class="font-semibold text-sm text-slate-800">Laptops</span>
            </div>
            <div @click="$emit('filter', 'Smartphone')"
                class="bg-white p-5 rounded-2xl border border-slate-200/80 hover:border-blue-500 hover:shadow-md transition-all cursor-pointer flex flex-col items-center text-center group">
                <div
                    class="w-14 h-14 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 mb-3 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                    <Smartphone class="w-6 h-6" />
                </div>
                <span class="font-semibold text-sm text-slate-800">Smartphones</span>
            </div>
            <div @click="$emit('filter', 'Headphones')"
                class="bg-white p-5 rounded-2xl border border-slate-200/80 hover:border-blue-500 hover:shadow-md transition-all cursor-pointer flex flex-col items-center text-center group">
                <div
                    class="w-14 h-14 rounded-full bg-amber-50 flex items-center justify-center text-amber-600 mb-3 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                    <Headphones class="w-6 h-6" />
                </div>
                <span class="font-semibold text-sm text-slate-800">Headphones</span>
            </div>
            <div @click="$emit('filter', 'Smart Watch')"
                class="bg-white p-5 rounded-2xl border border-slate-200/80 hover:border-blue-500 hover:shadow-md transition-all cursor-pointer flex flex-col items-center text-center group">
                <div
                    class="w-14 h-14 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-600 mb-3 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                    <Watch class="w-6 h-6" />
                </div>
                <span class="font-semibold text-sm text-slate-800">Smart Watches</span>
            </div>
        </div>
    </section>
</template>