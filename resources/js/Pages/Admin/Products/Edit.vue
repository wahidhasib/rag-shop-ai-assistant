<script setup>
import { Link, useForm } from '@inertiajs/vue3';
import { ArrowLeft } from 'lucide-vue-next';
import { route } from 'ziggy-js';

import ProductForm from '@/Components/Admin/ProductForm.vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';

defineOptions({
    layout: AdminLayout,
});

const props = defineProps({
    product: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    name: props.product.name ?? '',
    slug: props.product.slug ?? '',
    description: props.product.description ?? '',
    price: props.product.price ?? '',
    discount_price: props.product.discount_price ?? '',
    category: props.product.category ?? '',
    brand: props.product.brand ?? '',
    stock: props.product.stock ?? 0,
    is_active: Boolean(props.product.is_active),
    specifications: JSON.stringify(
        props.product.specifications ?? {},
        null,
        2
    ),
    image: null,
});

const existingImage = props.product.image
    ? props.product.image.startsWith('http')
        ? props.product.image
        : `/storage/${props.product.image}`
    : null;

const submit = (specifications) => {
    form
        .transform((data) => ({
            ...data,
            specifications,
            _method: 'put',
        }))
        .post(route('admin.products.update', props.product.id), {
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
                    Edit Product
                </h1>

                <p class="mt-1 text-sm text-gray-500">
                    Update {{ product.name }} information.
                </p>
            </div>
        </div>

        <ProductForm :form="form" :is-edit="true" :existing-image="existingImage" @submit="submit">
            <template #cancel>
                <Link :href="route('admin.products.index')"
                    class="inline-flex items-center justify-center rounded-xl border border-gray-200 bg-white px-6 py-3 text-sm font-semibold text-gray-700 transition hover:bg-gray-50">
                    Cancel
                </Link>
            </template>
        </ProductForm>
    </div>
</template>