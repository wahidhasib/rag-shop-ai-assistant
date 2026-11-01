<script setup>
import { Laptop } from 'lucide-vue-next';
import { onMounted } from 'vue';
defineEmits(['filter']);

const props = defineProps({
    categories: {
        type: Array,
        default: []
    }
})

onMounted(() => {
    console.log(props.categories)
})
</script>

<template>
    <section class="space-y-4">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-slate-900 tracking-tight">Categories</h2>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            <div v-for="category in categories" :key="category" @click="$emit('filter', category.category)"
                class="bg-white p-5 rounded-2xl border border-slate-200/80 hover:border-blue-500 hover:shadow-md transition-all cursor-pointer flex flex-col items-center text-center group">
                <div
                    class="w-14 h-14 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 mb-3 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                    <Laptop class="w-6 h-6" />
                </div>
                <span class="font-semibold text-sm text-slate-800">{{ category.category }}</span>
            </div>
        </div>
    </section>
</template>