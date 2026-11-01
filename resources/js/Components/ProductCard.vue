<script setup>
import { ArrowRight } from 'lucide-vue-next';

const props = defineProps({
    product: Object
});

defineEmits(['ask-ai']);

const badgeColor = (category) => {
    switch (category) {
        case 'Laptop': return 'bg-blue-600';
        case 'Smartphone': return 'bg-purple-600';
        case 'Headphones': return 'bg-amber-600';
        default: return 'bg-emerald-600';
    }
};
</script>

<template>
    <div
        class="product-card bg-white rounded-2xl border border-slate-200/80 p-5 flex flex-col justify-between hover:shadow-lg transition-all">
        <div>
            <div class="relative bg-slate-100 rounded-xl overflow-hidden mb-4 h-48 flex items-center justify-center">
                <img :src="product.image_url" :alt="product.name"
                    class="object-cover h-full w-full hover:scale-105 transition-transform duration-300">
                <span
                    :class="['absolute top-3 left-3 text-white text-[10px] font-bold px-2.5 py-1 rounded-md uppercase tracking-wider', badgeColor(product.category)]">
                    {{ product.category }}
                </span>
            </div>
            <h3 class="font-bold text-slate-900 text-base mb-1">{{ product.name }}</h3>
            <p class="text-xs text-slate-500 mb-3 leading-relaxed">{{ product.specs }}</p>
        </div>
        <div class="flex items-center justify-between pt-3 border-t border-slate-100 mt-2">
            <span class="text-lg font-bold text-slate-900">${{ product.price }}</span>
            <button @click="$emit('ask-ai', product.name)"
                class="inline-flex items-center gap-1 text-xs font-semibold text-blue-600 hover:bg-blue-50 px-3 py-2 rounded-lg transition-colors">
                <span>Ask AI</span>
                <ArrowRight class="w-3.5 h-3.5" />
            </button>
        </div>
    </div>
</template>