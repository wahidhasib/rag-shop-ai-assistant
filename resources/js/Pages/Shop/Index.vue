<script setup>
import ChatAssistant from '@/Components/ChatAssistant.vue';
import HeroBanner from '@/Components/HeroBanner.vue';
import Navbar from '@/Components/Navbar.vue';
import Pagination from '@/Components/Pagination.vue';
import ProductCard from '@/Components/ProductCard.vue';
import { router } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const props = defineProps({
    products: {
        type: Object,
        required: true,
    },
    categories: {
        type: Array,
        required: true,
    },
});

const cartCount = ref(0);
const isMobileChatOpen = ref(false);
const selectedCategoryFilter = ref(null);
const chatAssistantRef = ref(null);

// Get current pagination information from Laravel
const currentPage = computed(() => props.products.current_page);
const totalPages = computed(() => props.products.last_page);

// Products returned by the current Laravel pagination page
const displayedProducts = computed(() => props.products.data);

const incrementCart = () => {
    cartCount.value++;
};

const toggleMobileChat = () => {
    isMobileChatOpen.value = !isMobileChatOpen.value;
};

const scrollToProducts = () => {
    document.getElementById('productsSection')?.scrollIntoView({
        behavior: 'smooth',
    });
};

// Request another page from Laravel
const changePage = (page) => {
    if (page < 1 || page > totalPages.value) {
        return;
    }

    router.get(
        window.location.pathname,
        { page },
        {
            preserveState: true,
            preserveScroll: true,
            replace: true,
            only: ['products'],
        }
    );

    scrollToProducts();
};

const handleCategoryFilter = (category) => {
    selectedCategoryFilter.value = category;
    scrollToProducts();
};

const resetFilter = () => {
    selectedCategoryFilter.value = null;
};

const handleSearch = (query) => {
    triggerAiPrompt(`Can you search for products matching "${query}"?`);
};

const handleAskAi = (productName) => {
    triggerAiPrompt(`Tell me more about ${productName}.`);
};

const triggerAiPrompt = (promptText) => {
    if (window.innerWidth < 1024) {
        isMobileChatOpen.value = true;
    }

    chatAssistantRef.value?.sendMessage(promptText);
};
</script>

<template>
    <div
        class="bg-slate-50 text-[#111827] antialiased min-h-screen flex flex-col justify-between selection:bg-blue-600 selection:text-white">

        <!-- Navigation Bar -->
        <Navbar :cartCount="cartCount" @search="handleSearch" @toggle-chat="toggleMobileChat"
            @increment-cart="incrementCart" />

        <!-- Main Content Layout -->
        <main
            class="flex-1 max-w-8xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-6 grid grid-cols-1 lg:grid-cols-10 gap-8 items-start">

            <!-- Storefront Left Column (70%) -->
            <div class="lg:col-span-8 space-y-10">
                <HeroBanner @shop-now="scrollToProducts" />

                <!-- <CategoryGrid :categories="props.categories" @filter="handleCategoryFilter" /> -->

                <!-- Products Section -->
                <section id="productsSection" class="space-y-6">
                    <div class="flex items-center justify-between">
                        <h2 class="text-xl font-bold text-slate-900 tracking-tight">
                            {{ selectedCategoryFilter ? `${selectedCategoryFilter} Products` : 'Popular Products' }}
                        </h2>
                        <button v-if="selectedCategoryFilter" @click="resetFilter"
                            class="text-sm font-semibold text-blue-600 hover:text-blue-700 flex items-center gap-1 transition-colors">
                            <span>Show All</span>
                        </button>
                    </div>

                    <!-- Products Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 xl:grid-cols-4 gap-6">
                        <ProductCard v-for="product in displayedProducts" :key="product.id" :product="product"
                            @ask-ai="handleAskAi" />
                    </div>

                    <!-- Pagination Component (Only shown when not filtering by category) -->
                    <Pagination v-if="totalPages > 1 && !selectedCategoryFilter" :currentPage="currentPage"
                        :totalPages="totalPages" @page-change="changePage" />
                </section>
            </div>

            <!-- AI Chat Assistant Right Column (30%) -->
            <ChatAssistant ref="chatAssistantRef" :isOpen="isMobileChatOpen" @toggle-chat="toggleMobileChat" />

        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-slate-200 py-6 mt-12 text-center text-xs text-slate-500">
            <div
                class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p>&copy; 2026 ElectroHub. Built with Laravel 13, Vue 3, Inertia.js & Tailwind CSS 4.</p>
                <div class="flex items-center gap-4">
                    <a href="#" class="hover:text-blue-600 transition-colors">Privacy Policy</a>
                    <a href="#" class="hover:text-blue-600 transition-colors">Terms of Service</a>
                    <a href="#" class="hover:text-blue-600 transition-colors">Support</a>
                </div>
            </div>
        </footer>

    </div>
</template>