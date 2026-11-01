<script setup>
import { ChevronLeft, ChevronRight } from 'lucide-vue-next';
import { computed } from 'vue';

const props = defineProps({
    currentPage: {
        type: Number,
        required: true,
    },
    totalPages: {
        type: Number,
        required: true,
    },
});

const emit = defineEmits(['page-change']);

const pages = computed(() => {
    const total = props.totalPages;
    const current = props.currentPage;

    let start = Math.max(1, current - 2);
    let end = Math.min(total, current + 2);

    if (end - start < 4) {
        if (start === 1) {
            end = Math.min(total, start + 4);
        } else if (end === total) {
            start = Math.max(1, end - 4);
        }
    }

    return Array.from(
        { length: end - start + 1 },
        (_, index) => start + index
    );
});

const goToPage = (page) => {
    if (page >= 1 && page <= props.totalPages && page !== props.currentPage) {
        emit('page-change', page);
    }
};
</script>

<template>
    <div class="flex items-center justify-center gap-2 mt-8">
        <!-- Previous -->
        <button @click="goToPage(currentPage - 1)" :disabled="currentPage === 1"
            class="flex h-10 w-10 items-center justify-center rounded-lg border border-slate-200 transition hover:bg-slate-100 disabled:cursor-not-allowed disabled:opacity-40">
            <ChevronLeft class="h-5 w-5" />
        </button>

        <!-- Page Numbers -->
        <button v-for="page in pages" :key="page" @click="goToPage(page)" :class="[
            'h-10 min-w-10 rounded-lg px-3 text-sm font-semibold transition',
            currentPage === page
                ? 'bg-blue-600 text-white'
                : 'border border-slate-200 text-slate-700 hover:bg-slate-100'
        ]">
            {{ page }}
        </button>

        <!-- Next -->
        <button @click="goToPage(currentPage + 1)" :disabled="currentPage === totalPages"
            class="flex h-10 w-10 items-center justify-center rounded-lg border border-slate-200 transition hover:bg-slate-100 disabled:cursor-not-allowed disabled:opacity-40">
            <ChevronRight class="h-5 w-5" />
        </button>
    </div>
</template>
