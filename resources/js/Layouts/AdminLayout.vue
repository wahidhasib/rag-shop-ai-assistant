<script setup>
import Header from '@/Components/Admin/Header.vue';
import Sidebar from '@/Components/Admin/Sidebar.vue';
import { ref } from 'vue';

defineProps({
    title: {
        type: String,
        default: 'Admin Dashboard',
    },
});

const sidebarOpen = ref(false);
</script>

<template>
    <div class="min-h-screen bg-gray-50">
        <div class="flex min-h-screen">
            <Sidebar :open="sidebarOpen" @close="sidebarOpen = false" />

            <div v-if="sidebarOpen" class="fixed inset-0 z-40 bg-gray-900/40 lg:hidden" @click="sidebarOpen = false">
            </div>

            <div class="min-w-0 flex-1">
                <Header :title="title" @toggle-sidebar="sidebarOpen = !sidebarOpen" />

                <main class="p-4 sm:p-6 lg:p-8">
                    <slot />
                </main>
            </div>
        </div>
    </div>
</template>