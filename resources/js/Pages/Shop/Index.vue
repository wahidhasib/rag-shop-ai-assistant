<script setup>
import CategoryGrid from '@/Components/CategoryGrid.vue';
import ChatAssistant from '@/Components/ChatAssistant.vue';
import HeroBanner from '@/Components/HeroBanner.vue';
import Navbar from '@/Components/Navbar.vue';
import Pagination from '@/Components/Pagination.vue';
import ProductCard from '@/Components/ProductCard.vue';
import { computed, ref } from 'vue';

// Initial products prop passed from Laravel controller
const props = defineProps({
    products: {
        type: Array,
        default: () => [
            { id: 1, name: 'HP Pavilion 15', category: 'Laptop', price: 650, specs: 'Intel Core i5, 16GB RAM, 512GB SSD.', image: 'https://images.unsplash.com/photo-1588872657578-7efd1f1555ed?auto=format&fit=crop&w=600&q=80', page: 1 },
            { id: 2, name: 'Samsung Galaxy S24', category: 'Smartphone', price: 799, specs: '8GB RAM, 256GB Storage, AMOLED Display.', image: 'https://images.unsplash.com/photo-1610945265064-0e34e5519bbf?auto=format&fit=crop&w=600&q=80', page: 1 },
            { id: 3, name: 'Sony Wireless Headphones', category: 'Headphones', price: 120, specs: 'Noise Cancellation, Bluetooth 5.0.', image: 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=600&q=80', page: 1 },
            { id: 4, name: 'Apple Watch Series', category: 'Smart Watch', price: 299, specs: 'Fitness Tracking, Heart Rate, GPS.', image: 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=600&q=80', page: 1 },
            { id: 5, name: 'MacBook Air M2', category: 'Laptop', price: 1099, specs: 'Apple M2 Chip, 8GB RAM, 256GB SSD.', image: 'https://images.unsplash.com/photo-1611186871348-b1ce696e52c9?auto=format&fit=crop&w=600&q=80', page: 2 },
            { id: 6, name: 'Google Pixel 8 Pro', category: 'Smartphone', price: 749, specs: 'Tensor G3, 12GB RAM, 128GB Storage.', image: 'https://images.unsplash.com/photo-1598327105666-5b89351aff97?auto=format&fit=crop&w=600&q=80', page: 2 },
            { id: 7, name: 'Bose QuietComfort 45', category: 'Headphones', price: 279, specs: 'Acoustic Noise Cancelling, 24h Battery.', image: 'https://images.unsplash.com/photo-1546435770-a3e426bf472b?auto=format&fit=crop&w=600&q=80', page: 2 },
            { id: 8, name: 'Garmin Venu 3', category: 'Smart Watch', price: 449, specs: 'AMOLED Display, Advanced Health Metrics.', image: 'https://images.unsplash.com/photo-1508685096489-7aacd43bd3b1?auto=format&fit=crop&w=600&q=80', page: 2 }
        ]
    }
});

const cartCount = ref(0);
const isMobileChatOpen = ref(false);
const currentPage = ref(1);
const selectedCategoryFilter = ref(null);
const chatAssistantRef = ref(null);

const incrementCart = () => {
    cartCount.value++;
};

const toggleMobileChat = () => {
    isMobileChatOpen.value = !isMobileChatOpen.value;
};

const scrollToProducts = () => {
    document.getElementById('productsSection')?.scrollIntoView({ behavior: 'smooth' });
};

const handleCategoryFilter = (category) => {
    selectedCategoryFilter.value = category;
    scrollToProducts();
};

const resetFilter = () => {
    selectedCategoryFilter.value = null;
    currentPage.value = 1;
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

// Filtered products list based on pagination or category selection
const displayedProducts = computed(() => {
    if (selectedCategoryFilter.value) {
        return props.products.filter(p => p.category === selectedCategoryFilter.value);
    }
    return props.products.filter(p => p.page === currentPage.value);
});
</script>

<template>
    <div
        class="bg-slate-50 text-[#111827] antialiased min-h-screen flex flex-col justify-between selection:bg-blue-600 selection:text-white">

        <!-- Navigation Bar -->
        <Navbar :cartCount="cartCount" @search="handleSearch" @toggle-chat="toggleMobileChat"
            @increment-cart="incrementCart" />

        <!-- Main Content Layout -->
        <main
            class="flex-1 max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-6 grid grid-cols-1 lg:grid-cols-10 gap-8 items-start">

            <!-- Storefront Left Column (70%) -->
            <div class="lg:col-span-7 space-y-10">
                <HeroBanner @shop-now="scrollToProducts" />

                <CategoryGrid @filter="handleCategoryFilter" />

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
                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
                        <ProductCard v-for="product in displayedProducts" :key="product.id" :product="product"
                            @ask-ai="handleAskAi" />
                    </div>

                    <!-- Pagination Component (Only shown when not filtering by category) -->
                    <Pagination v-if="!selectedCategoryFilter" :currentPage="currentPage" :totalPages="2"
                        @page-change="(page) => { currentPage = page; scrollToProducts(); }" />
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