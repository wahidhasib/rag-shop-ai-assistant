<script setup>
import { Link } from '@inertiajs/vue3';
import {
    AlertTriangle,
    ArrowRight,
    CheckCircle,
    Package,
    Plus,
    Users,
} from 'lucide-vue-next';
import { route } from 'ziggy-js';

import StatCard from '@/Components/Admin/StatCard.vue';
import StatusBadge from '@/Components/Admin/StatusBadge.vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';

defineOptions({
    layout: AdminLayout,
});

defineProps({
    stats: {
        type: Object,
        default: () => ({
            totalProducts: 0,
            activeProducts: 0,
            outOfStock: 0,
            totalCustomers: 0,
        }),
    },

    recentProducts: {
        type: Array,
        default: () => [],
    },
});
</script>

<template>
    <div class="space-y-8">
        <!-- Welcome section -->
        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">
                    Welcome to Admin Panel
                </h1>

                <p class="mt-1 text-sm text-gray-500">
                    Here's what's happening with your store today.
                </p>
            </div>

            <Link :href="route('admin.products.create')"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700">
                <Plus :size="18" />
                Add New Product
            </Link>
        </div>

        <!-- Statistics -->
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-4">
            <StatCard title="Total Products" :value="stats.totalProducts" description="Products in your store"
                :icon="Package" color="indigo" />

            <StatCard title="Active Products" :value="stats.activeProducts" description="Currently available products"
                :icon="CheckCircle" color="green" />

            <StatCard title="Out of Stock" :value="stats.outOfStock" description="Products requiring restock"
                :icon="AlertTriangle" color="orange" />

            <StatCard title="Total Customers" :value="stats.totalCustomers" description="Registered customers"
                :icon="Users" color="red" />
        </div>

        <!-- Recent Products -->
        <section class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
            <div class="flex items-center justify-between border-b border-gray-100 px-5 py-5 sm:px-6">
                <div>
                    <h2 class="font-bold text-gray-900">Recent Products</h2>
                    <p class="mt-1 text-xs text-gray-500">
                        Recently added products
                    </p>
                </div>

                <Link :href="route('admin.products.index')"
                    class="inline-flex items-center gap-2 text-sm font-semibold text-indigo-600 hover:text-indigo-700">
                    View All
                    <ArrowRight :size="16" />
                </Link>
            </div>

            <div v-if="recentProducts.length" class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-50 text-xs uppercase text-gray-500">
                        <tr>
                            <th class="px-6 py-4 font-semibold">Product</th>
                            <th class="px-6 py-4 font-semibold">Category</th>
                            <th class="px-6 py-4 font-semibold">Price</th>
                            <th class="px-6 py-4 font-semibold">Stock</th>
                            <th class="px-6 py-4 font-semibold">Status</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        <tr v-for="product in recentProducts" :key="product.id" class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <img v-if="product.image"
                                        :src="product.image.startsWith('http') ? product.image : `/storage/${product.image}`"
                                        :alt="product.name"
                                        class="h-11 w-11 rounded-lg border border-gray-100 object-cover" />

                                    <div v-else
                                        class="flex h-11 w-11 items-center justify-center rounded-lg bg-gray-100 text-gray-400">
                                        <Package :size="20" />
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

                            <td class="px-6 py-4 text-gray-600">
                                {{ product.category || '—' }}
                            </td>

                            <td class="px-6 py-4 font-medium text-gray-800">
                                ${{ Number(product.discount_price || product.price || 0).toFixed(2) }}
                            </td>

                            <td class="px-6 py-4 text-gray-600">
                                {{ product.stock }}
                            </td>

                            <td class="px-6 py-4">
                                <StatusBadge :active="Boolean(product.is_active)" />
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div v-else class="px-6 py-16 text-center">
                <Package class="mx-auto text-gray-300" :size="40" />

                <h3 class="mt-3 font-semibold text-gray-800">
                    No products found
                </h3>

                <p class="mt-1 text-sm text-gray-500">
                    Start by adding your first product.
                </p>

                <Link :href="route('admin.products.create')"
                    class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-indigo-600 hover:text-indigo-700">
                    <Plus :size="16" />
                    Add Product
                </Link>
            </div>
        </section>
    </div>
</template>