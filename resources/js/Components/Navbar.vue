<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { Bot, LogOut, Search, ShoppingBag, ShoppingCart, User } from 'lucide-vue-next';
import { computed, ref } from 'vue';

const props = defineProps({
    cartCount: Number
});

const emit = defineEmits(['search', 'toggle-chat', 'increment-cart']);

// Access Inertia page props safely
const page = usePage();
const user = computed(() => page.props.auth?.user);

const navSearchQuery = ref('');
const mobileSearchQuery = ref('');

const handleSearch = (query) => {
    if (query.trim()) {
        emit('search', query.trim());
    }
};
</script>

<template>
    <header class="sticky top-0 z-50 bg-white/95 backdrop-blur-md border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between gap-4">

            <!-- Left: Logo -->
            <div class="flex items-center gap-3 shrink-0">
                <Link :href="route('home')" class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-600 flex items-center justify-center text-white shadow-md shadow-blue-600/20">
                        <ShoppingBag class="w-5 h-5" />
                    </div>
                    <span class="text-2xl font-bold tracking-tight text-slate-900">Electro<span class="text-blue-600">Hub</span></span>
                </Link>
            </div>

            <!-- Center: Search Input (Desktop) -->
            <div class="flex-1 max-w-2xl hidden md:flex items-center">
                <div class="relative w-full">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-slate-400">
                        <Search class="w-5 h-5" />
                    </span>
                    <input type="text" v-model="navSearchQuery" @keyup.enter="handleSearch(navSearchQuery)"
                        placeholder="Search electronics, gadgets..."
                        class="w-full pl-11 pr-28 py-3 bg-slate-50 border border-slate-200 rounded-full text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:bg-white transition-all">
                    <button @click="handleSearch(navSearchQuery)"
                        class="absolute inset-y-1.5 right-1.5 px-5 bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm rounded-full transition-colors flex items-center justify-center shadow-sm">
                        Search
                    </button>
                </div>
            </div>

            <!-- Right: Account & Cart -->
            <div class="flex items-center gap-3 shrink-0">
                <button @click="$emit('toggle-chat')"
                    class="lg:hidden p-2.5 text-slate-700 hover:text-blue-600 bg-slate-100 rounded-full relative transition-colors"
                    title="Toggle AI Assistant">
                    <Bot class="w-5 h-5 text-blue-600" />
                </button>

                <!-- Conditional Authentication Section -->
                <template v-if="user">
                    <!-- Authenticated State: User Profile & Logout -->
                    <div class="hidden sm:flex items-center gap-2">
                        <Link class="flex items-center gap-2 py-2 px-3 rounded-full bg-slate-50 border border-slate-200 text-slate-700 font-medium text-sm">
                            <User class="w-4 h-4 text-slate-500" />
                            <span class="max-w-[100px] truncate">{{ user.name }}</span>
                        </Link>
                        <Link :href="route('logout')" method="post" as="button"
                            class="flex items-center gap-1.5 py-2 px-3.5 rounded-full hover:bg-red-50 text-red-600 hover:text-red-700 transition-colors font-medium text-sm"
                            title="Log out">
                            <LogOut class="w-4 h-4" />
                            <span class="hidden md:inline">Logout</span>
                        </Link>
                    </div>
                </template>
                <template v-else>
                    <!-- Guest State: Login & Register Links -->
                    <div class="hidden sm:flex items-center gap-2">
                        <Link :href="route('login')"
                            class="py-2 px-4 rounded-full hover:bg-slate-100 text-slate-700 font-medium text-sm transition-colors">
                            Sign in
                        </Link>
                        <Link :href="route('register')"
                            class="py-2 px-4 rounded-full bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm transition-colors shadow-sm">
                            Register
                        </Link>
                    </div>
                </template>

                <!-- Cart Button -->
                <button @click="$emit('increment-cart')"
                    class="flex items-center gap-2 py-2 px-3.5 bg-slate-100 hover:bg-slate-200 text-slate-800 rounded-full transition-colors font-medium text-sm relative">
                    <ShoppingCart class="w-5 h-5 text-slate-700" />
                    <span class="hidden sm:inline">Cart</span>
                    <span
                        class="absolute -top-1.5 -right-1.5 bg-red-500 text-white text-xs font-bold w-5 h-5 rounded-full flex items-center justify-center shadow-sm">
                        {{ cartCount }}
                    </span>
                </button>
            </div>
        </div>

        <!-- Mobile Search Bar -->
        <div class="px-4 pb-3 md:hidden">
            <div class="relative w-full">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                    <Search class="w-4 h-4" />
                </span>
                <input type="text" v-model="mobileSearchQuery" @keyup.enter="handleSearch(mobileSearchQuery)"
                    placeholder="Search electronics, gadgets..."
                    class="w-full pl-10 pr-24 py-2.5 bg-slate-50 border border-slate-200 rounded-full text-xs text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:bg-white">
                <button @click="handleSearch(mobileSearchQuery)"
                    class="absolute inset-y-1 right-1 px-4 bg-blue-600 text-white font-medium text-xs rounded-full">
                    Search
                </button>
            </div>
        </div>
    </header>
</template>