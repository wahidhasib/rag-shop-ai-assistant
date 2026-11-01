<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { LogOut, Menu, UserCircle } from 'lucide-vue-next';
import { computed } from 'vue';
import { route } from 'ziggy-js';

defineProps({
    title: {
        type: String,
        default: 'Dashboard',
    },
});

defineEmits(['toggle-sidebar']);

const page = usePage();

const user = computed(() => page.props.auth?.user);
</script>

<template>
    <header
        class="sticky top-0 z-30 flex h-20 items-center justify-between border-b border-gray-200 bg-white/95 px-4 backdrop-blur sm:px-6 lg:px-8">
        <div class="flex items-center gap-3">
            <button type="button" class="rounded-lg p-2 text-gray-600 hover:bg-gray-100 lg:hidden"
                @click="$emit('toggle-sidebar')">
                <Menu :size="22" />
            </button>

            <div>
                <h2 class="text-lg font-bold text-gray-900 sm:text-xl">
                    {{ title }}
                </h2>
                <p class="hidden text-xs text-gray-500 sm:block">
                    Manage your application
                </p>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <div class="hidden text-right sm:block">
                <p class="text-sm font-semibold text-gray-800">
                    {{ user?.name ?? 'Administrator' }}
                </p>
                <p class="text-xs text-gray-500">
                    {{ user?.email ?? '' }}
                </p>
            </div>

            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-indigo-50 text-indigo-600">
                <UserCircle :size="23" />
            </div>

            <Link :href="route('logout')" method="post" as="button"
                class="rounded-lg p-2 text-gray-500 transition hover:bg-red-50 hover:text-red-600" title="Logout">
                <LogOut :size="19" />
            </Link>
        </div>
    </header>
</template>