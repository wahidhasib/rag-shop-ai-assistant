<script setup>
defineProps({
    currentPage: Number,
    totalPages: Number
});

defineEmits(['page-change']);
</script>

<template>
    <div class="flex items-center justify-between pt-6 border-t border-slate-200">
        <span class="text-xs text-slate-500">Showing page {{ currentPage }} of {{ totalPages }}</span>
        <div class="flex items-center gap-1.5">
            <button @click="$emit('page-change', currentPage - 1)" :disabled="currentPage === 1"
                :class="['px-3.5 py-2 rounded-xl text-xs font-semibold border border-slate-200 transition-all', currentPage === 1 ? 'bg-white text-slate-400 cursor-not-allowed' : 'bg-white text-slate-700 hover:bg-slate-100']">
                Previous
            </button>

            <button v-for="page in totalPages" :key="page" @click="$emit('page-change', page)"
                :class="['w-9 h-9 rounded-xl text-xs font-semibold transition-all', currentPage === page ? 'bg-blue-600 text-white shadow-sm' : 'bg-white border border-slate-200 text-slate-700 hover:bg-slate-100']">
                {{ page }}
            </button>

            <button @click="$emit('page-change', currentPage + 1)" :disabled="currentPage === totalPages"
                :class="['px-3.5 py-2 rounded-xl text-xs font-semibold border border-slate-200 transition-all', currentPage === totalPages ? 'bg-white text-slate-400 cursor-not-allowed' : 'bg-white text-slate-700 hover:bg-slate-100']">
                Next
            </button>
        </div>
    </div>
</template>