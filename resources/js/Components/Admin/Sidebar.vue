<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import {
    Bot,
    ChevronLeft,
    LayoutDashboard,
    Package
} from 'lucide-vue-next';
import { computed } from 'vue';
import { route } from 'ziggy-js';

defineProps({
    open: {
        type: Boolean,
        default: true,
    },
});

const emit = defineEmits(['close']);

const page = usePage();

const navigation = [
    {
        label: 'Dashboard',
        route: 'admin.dashboard',
        icon: LayoutDashboard,
    },
    {
        label: 'Products',
        route: 'admin.products.index',
        icon: Package,
    },
];

const currentUrl = computed(() => page.url);

const isActive = (routeName) => {
    const url = route(routeName);
    return currentUrl.value === url || currentUrl.value.startsWith(`${url}/`);
};
</script>

<template>
    <aside
        class="fixed inset-y-0 left-0 z-50 flex w-64 flex-col border-r border-gray-200 bg-white transition-transform duration-300 lg:static lg:translate-x-0"
        :class="open ? 'translate-x-0' : '-translate-x-full'">
        <div class="flex h-20 items-center justify-between border-b border-gray-100 px-6">
            <Link :href="route('admin.dashboard')" class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-600 text-white">
                    <Bot :size="23" />
                </div>

                <div>
                    <h1 class="text-lg font-bold text-gray-900">Learn AI</h1>
                    <p class="text-xs text-gray-500">Admin Panel</p>
                </div>
            </Link>

            <button type="button" class="rounded-lg p-2 text-gray-500 hover:bg-gray-100 lg:hidden"
                @click="emit('close')">
                <ChevronLeft :size="20" />
            </button>
        </div>

        <div class="flex-1 overflow-y-auto px-4 py-6">
            <p class="mb-4 px-3 text-xs font-semibold uppercase tracking-wider text-gray-400">
                Main Menu
            </p>

            <nav class="space-y-1">
                <Link v-for="item in navigation" :key="item.route" :href="route(item.route)"
                    class="flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium transition" :class="isActive(item.route)
                            ? 'bg-indigo-50 text-indigo-700'
                            : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'
                        " @click="emit('close')">
                    <component :is="item.icon" :size="19" />
                    {{ item.label }}
                </Link>
            </nav>

            <div class="mt-10 rounded-2xl bg-gradient-to-br from-indigo-600 to-violet-600 p-4 text-white">
                <Bot :size="25" class="mb-3" />

                <h3 class="font-semibold">AI Assistant</h3>

                <p class="mt-1 text-xs leading-5 text-indigo-100">
                    Manage your products and power your AI shopping assistant.
                </p>
            </div>
        </div>

        <div class="border-t border-gray-100 p-4">
            <p class="text-center text-xs text-gray-400">
                © {{ new Date().getFullYear() }} Learn AI
            </p>
        </div>
    </aside>
</template>