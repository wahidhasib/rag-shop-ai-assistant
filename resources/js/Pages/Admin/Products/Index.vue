<script setup>
import { Link, router } from '@inertiajs/vue3';
import {
    Package,
    Pencil,
    Plus,
    Trash2
} from 'lucide-vue-next';
import { ref, watch } from 'vue';
import { route } from 'ziggy-js';

import Pagination from '@/Components/Admin/Pagination.vue';
import SearchInput from '@/Components/Admin/SearchInput.vue';
import StatusBadge from '@/Components/Admin/StatusBadge.vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';

defineOptions({
    layout: AdminLayout,
});

const props = defineProps({
    products: {
        type: Object,
        required: true,
    },

    filters: {
        type: Object,
        default: () => ({
            search: '',
        }),
    },
});

const search = ref(props.filters.search || '');

let searchTimeout = null;

watch(search, (value) => {
    clearTimeout(searchTimeout);

    searchTimeout = setTimeout(() => {
        router.get(
            route('admin.products.index'),
            { search: value || undefined },
            {
                preserveState: true,
                preserveScroll: true,
                replace: true,
            }
        );
    }, 400);
});

const deleteProduct = (product) => {
    if (!window.confirm(`Are you sure you want to delete "${product.name}"?`)) {
        return;
    }

    router.delete(route('admin.products.destroy', product.id), {
        preserveScroll: true,
    });
};

const imageUrl = (image) => {
    if (!image) return null;

    return image.startsWith('http') ? image : `/storage/${image}`;
};
</script>

<template>
    <div class="space-y-6">
        <!-- Page heading -->
        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">
                    Products
                </h1>

                <p class="mt-1 text-sm text-gray-500">
                    Manage your store products.
                </p>
            </div>

            <Link :href="route('admin.products.create')"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-indigo-700">
                <Plus :size="18" />
                Add Product
            </Link>
        </div>

        <!-- Product table -->
        <section class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
            <div class="flex flex-col justify-between gap-4 border-b border-gray-100 p-5 sm:flex-row sm:items-center">
                <div>
                    <h2 class="font-bold text-gray-900">
                        All Products
                    </h2>

                    <p class="mt-1 text-xs text-gray-500">
                        {{ products.total }} products found
                    </p>
                </div>

                <SearchInput v-model="search" placeholder="Search products..." />
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-50 text-xs uppercase text-gray-500">
                        <tr>
                            <th class="px-6 py-4 font-semibold">Product</th>
                            <th class="px-6 py-4 font-semibold">Category</th>
                            <th class="px-6 py-4 font-semibold">Price</th>
                            <th class="px-6 py-4 font-semibold">Stock</th>
                            <th class="px-6 py-4 font-semibold">Status</th>
                            <th class="px-6 py-4 text-right font-semibold">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        <tr v-for="product in products.data" :key="product.id" class="transition hover:bg-gray-50">
                            <!-- Product -->
                            <td class="whitespace-nowrap px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <img v-if="imageUrl(product.image)" :src="imageUrl(product.image)"
                                        :alt="product.name"
                                        class="h-12 w-12 rounded-lg border border-gray-100 object-cover" />

                                    <div v-else
                                        class="flex h-12 w-12 items-center justify-center rounded-lg bg-gray-100 text-gray-400">
                                        <Package :size="21" />
                                    </div>

                                    <div>
                                        <p class="font-semibold text-gray-800">
                                            {{ product.name }}
                                        </p>

                                        <p class="text-xs text-gray-400">
                                            {{ product.brand || 'No brand' }}
                                        </p>
                                    </div>
                                </div>
                            </td>

                            <!-- Category -->
                            <td class="whitespace-nowrap px-6 py-4 text-gray-600">
                                {{ product.category || '—' }}
                            </td>

                            <!-- Price -->
                            <td class="whitespace-nowrap px-6 py-4">
                                <div class="font-semibold text-gray-800">
                                    ${{ Number(product.discount_price || product.price || 0).toFixed(2) }}
                                </div>

                                <span
                                    v-if="product.discount_price && Number(product.discount_price) < Number(product.price)"
                                    class="text-xs text-gray-400 line-through">
                                    ${{ Number(product.price).toFixed(2) }}
                                </span>
                            </td>

                            <!-- Stock -->
                            <td class="whitespace-nowrap px-6 py-4">
                                <span :class="product.stock > 0 ? 'text-gray-700' : 'font-semibold text-red-600'">
                                    {{ product.stock }}
                                </span>
                            </td>

                            <!-- Status -->
                            <td class="whitespace-nowrap px-6 py-4">
                                <StatusBadge :active="Boolean(product.is_active)" />
                            </td>

                            <!-- Actions -->
                            <td class="whitespace-nowrap px-6 py-4">
                                <div class="flex items-center justify-end gap-2">
                                    <Link :href="route('admin.products.edit', product.id)"
                                        class="rounded-lg p-2 text-indigo-600 transition hover:bg-indigo-50"
                                        title="Edit product">
                                        <Pencil :size="17" />
                                    </Link>

                                    <button type="button" @click="deleteProduct(product)"
                                        class="rounded-lg p-2 text-red-500 transition hover:bg-red-50"
                                        title="Delete product">
                                        <Trash2 :size="17" />
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr v-if="!products.data.length">
                            <td colspan="6" class="px-6 py-16 text-center">
                                <Package class="mx-auto text-gray-300" :size="40" />

                                <h3 class="mt-3 font-semibold text-gray-800">
                                    No products found
                                </h3>

                                <p class="mt-1 text-sm text-gray-500">
                                    Try a different search or add a new product.
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div
                class="flex flex-col items-center justify-between gap-4 border-t border-gray-100 px-5 py-4 sm:flex-row">
                <p class="text-xs text-gray-500">
                    Showing {{ products.from || 0 }} to {{ products.to || 0 }}
                    of {{ products.total }} products
                </p>

                <Pagination :links="products.links" />
            </div>
        </section>
    </div>
</template>