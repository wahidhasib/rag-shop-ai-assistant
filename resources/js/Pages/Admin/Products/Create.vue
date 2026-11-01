<script setup>
import { Link, useForm } from '@inertiajs/vue3';
import { ArrowLeft } from 'lucide-vue-next';
import { route } from 'ziggy-js';

import ProductForm from '@/Components/Admin/ProductForm.vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';

defineOptions({
    layout: AdminLayout,
});

const form = useForm({
    name: '',
    slug: '',
    description: '',
    price: '',
    discount_price: '',
    category: '',
    brand: '',
    stock: 0,
    is_active: true,
    specifications: '{}',
    image: null,
});

const submit = (specifications) => {
    form
        .transform((data) => ({
            ...data,
            specifications,
        }))
        .post(route('admin.products.store'), {
            forceFormData: true,
            preserveScroll: true,
        });
};
</script>

<template>
    <div class="space-y-6">
        <div class="flex items-center gap-3">
            <Link :href="route('admin.products.index')"
                class="rounded-lg border border-gray-200 bg-white p-2 text-gray-600 transition hover:bg-gray-50">
                <ArrowLeft :size="19" />
            </Link>

            <div>
                <h1 class="text-2xl font-bold text-gray-900">
                    Create Product
                </h1>

                <p class="mt-1 text-sm text-gray-500">
                    Add a new product to your store.
                </p>
            </div>
        </div>

        <ProductForm :form="form" @submit="submit">
            <template #cancel>
                <Link :href="route('admin.products.index')"
                    class="inline-flex items-center justify-center rounded-xl border border-gray-200 bg-white px-6 py-3 text-sm font-semibold text-gray-700 transition hover:bg-gray-50">
                    Cancel
                </Link>
            </template>
        </ProductForm>
    </div>
</template>