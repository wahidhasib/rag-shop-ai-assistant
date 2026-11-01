<script setup>
import { ImagePlus, Package, X } from 'lucide-vue-next';
import { ref, watch } from 'vue';

const props = defineProps({
    form: {
        type: Object,
        required: true,
    },
    isEdit: {
        type: Boolean,
        default: false,
    },
    existingImage: {
        type: String,
        default: null,
    },
});

const emit = defineEmits(['submit']);

const specificationsText = ref(
    typeof props.form.specifications === 'string'
        ? props.form.specifications
        : JSON.stringify(props.form.specifications ?? {}, null, 2)
);

const imagePreview = ref(null);

const currentImage = ref(props.existingImage);

watch(
    () => props.existingImage,
    (value) => {
        currentImage.value = value;
    }
);

const handleImage = (event) => {
    const file = event.target.files?.[0];

    if (!file) return;

    props.form.image = file;

    if (imagePreview.value) {
        URL.revokeObjectURL(imagePreview.value);
    }

    imagePreview.value = URL.createObjectURL(file);
};

const removeNewImage = () => {
    props.form.image = null;

    if (imagePreview.value) {
        URL.revokeObjectURL(imagePreview.value);
        imagePreview.value = null;
    }
};

const submit = () => {
    let specifications;

    try {
        specifications = JSON.parse(specificationsText.value || '{}');

        if (
            specifications === null ||
            typeof specifications !== 'object' ||
            Array.isArray(specifications)
        ) {
            throw new Error('Specifications must be a JSON object.');
        }
    } catch {
        props.form.setError(
            'specifications',
            'Please enter valid JSON object data.'
        );

        return;
    }

    props.form.clearErrors('specifications');

    emit('submit', specifications);
};
</script>

<template>
    <form @submit.prevent="submit" class="space-y-6">
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <!-- Main fields -->
            <div class="space-y-6 lg:col-span-2">
                <section class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm sm:p-6">
                    <h2 class="mb-5 font-bold text-gray-900">
                        Basic Information
                    </h2>

                    <div class="space-y-5">
                        <div>
                            <label class="mb-2 block text-sm font-semibold text-gray-700">
                                Product Name <span class="text-red-500">*</span>
                            </label>

                            <input v-model="form.name" type="text" placeholder="Enter product name" class="w-full rounded-xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-800 outline-none transition placeholder:text-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
                                :class="{ 'border-red-500': form.errors.name }" />

                            <p v-if="form.errors.name" class="mt-1 text-xs text-red-600">
                                {{ form.errors.name }}
                            </p>
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-semibold text-gray-700">
                                Slug
                            </label>

                            <input v-model="form.slug" type="text" placeholder="product-slug" class="w-full rounded-xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-800 outline-none transition placeholder:text-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100" />

                            <p v-if="form.errors.slug" class="mt-1 text-xs text-red-600">
                                {{ form.errors.slug }}
                            </p>
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-semibold text-gray-700">
                                Description
                            </label>

                            <textarea v-model="form.description" rows="5" placeholder="Write product description..."
                                class="w-full resize-y rounded-xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-800 outline-none transition placeholder:text-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"></textarea>

                            <p v-if="form.errors.description" class="mt-1 text-xs text-red-600">
                                {{ form.errors.description }}
                            </p>
                        </div>
                    </div>
                </section>

                <section class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm sm:p-6">
                    <h2 class="mb-5 font-bold text-gray-900">
                        Product Specifications
                    </h2>

                    <p class="mb-3 text-xs text-gray-500">
                        Enter specifications as a JSON object. Example:
                    </p>

                    <pre class="mb-3 overflow-x-auto rounded-lg bg-gray-50 p-3 text-xs text-gray-600">{
  "processor": "Intel Core i7",
  "ram": "16GB",
  "storage": "512GB SSD"
}</pre>

                    <textarea v-model="specificationsText" rows="8" placeholder='{"processor": "Intel Core i7"}'
                        class="w-full resize-y rounded-xl border border-gray-200 bg-white px-4 py-3 font-mono text-sm text-gray-800 outline-none transition placeholder:text-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"></textarea>

                    <p v-if="form.errors.specifications" class="mt-1 text-xs text-red-600">
                        {{ form.errors.specifications }}
                    </p>
                </section>
            </div>

            <!-- Sidebar fields -->
            <div class="space-y-6">
                <section class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                    <h2 class="mb-5 font-bold text-gray-900">
                        Pricing & Inventory
                    </h2>

                    <div class="space-y-4">
                        <div>
                            <label class="mb-2 block text-sm font-semibold text-gray-700">
                                Price <span class="text-red-500">*</span>
                            </label>

                            <input v-model="form.price" type="number" min="0" step="0.01" placeholder="0.00"
                                class="w-full rounded-xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-800 outline-none transition placeholder:text-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100" />

                            <p v-if="form.errors.price" class="mt-1 text-xs text-red-600">
                                {{ form.errors.price }}
                            </p>
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-semibold text-gray-700">
                                Discount Price
                            </label>

                            <input v-model="form.discount_price" type="number" min="0" step="0.01" placeholder="0.00"
                                class="w-full rounded-xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-800 outline-none transition placeholder:text-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100" />

                            <p v-if="form.errors.discount_price" class="mt-1 text-xs text-red-600">
                                {{ form.errors.discount_price }}
                            </p>
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-semibold text-gray-700">
                                Stock <span class="text-red-500">*</span>
                            </label>

                            <input v-model="form.stock" type="number" min="0" placeholder="0" class="w-full rounded-xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-800 outline-none transition placeholder:text-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100" />

                            <p v-if="form.errors.stock" class="mt-1 text-xs text-red-600">
                                {{ form.errors.stock }}
                            </p>
                        </div>
                    </div>
                </section>

                <section class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                    <h2 class="mb-5 font-bold text-gray-900">
                        Product Details
                    </h2>

                    <div class="space-y-4">
                        <div>
                            <label class="mb-2 block text-sm font-semibold text-gray-700">
                                Category
                            </label>

                            <input v-model="form.category" type="text" placeholder="e.g. Laptop" class="w-full rounded-xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-800 outline-none transition placeholder:text-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100" />

                            <p v-if="form.errors.category" class="mt-1 text-xs text-red-600">
                                {{ form.errors.category }}
                            </p>
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-semibold text-gray-700">
                                Brand
                            </label>

                            <input v-model="form.brand" type="text" placeholder="e.g. Apple" class="w-full rounded-xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-800 outline-none transition placeholder:text-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100" />

                            <p v-if="form.errors.brand" class="mt-1 text-xs text-red-600">
                                {{ form.errors.brand }}
                            </p>
                        </div>
                    </div>
                </section>

                <section class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                    <h2 class="mb-4 font-bold text-gray-900">
                        Product Image
                    </h2>

                    <div class="relative">
                        <div v-if="imagePreview || currentImage"
                            class="relative overflow-hidden rounded-xl border border-gray-200">
                            <img :src="imagePreview || currentImage" alt="Product preview"
                                class="h-48 w-full object-cover" />

                            <button v-if="imagePreview" type="button" @click="removeNewImage"
                                class="absolute right-2 top-2 rounded-full bg-white p-2 text-red-600 shadow hover:bg-red-50">
                                <X :size="17" />
                            </button>
                        </div>

                        <label v-else
                            class="flex h-48 cursor-pointer flex-col items-center justify-center rounded-xl border-2 border-dashed border-gray-300 bg-gray-50 transition hover:border-indigo-400 hover:bg-indigo-50/30">
                            <ImagePlus :size="30" class="text-gray-400" />

                            <span class="mt-3 text-sm font-semibold text-gray-700">
                                Upload product image
                            </span>

                            <span class="mt-1 text-xs text-gray-400">
                                PNG, JPG or WEBP
                            </span>

                            <input type="file" accept="image/png,image/jpeg,image/webp" class="hidden"
                                @change="handleImage" />
                        </label>

                        <label v-if="imagePreview || currentImage"
                            class="mt-3 flex cursor-pointer items-center justify-center gap-2 rounded-lg border border-gray-200 px-3 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50">
                            <ImagePlus :size="16" />
                            Change Image

                            <input type="file" accept="image/png,image/jpeg,image/webp" class="hidden"
                                @change="handleImage" />
                        </label>
                    </div>

                    <p v-if="form.errors.image" class="mt-2 text-xs text-red-600">
                        {{ form.errors.image }}
                    </p>
                </section>

                <section class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                    <h2 class="mb-4 font-bold text-gray-900">
                        Visibility
                    </h2>

                    <label class="flex cursor-pointer items-center justify-between gap-3">
                        <div>
                            <p class="text-sm font-semibold text-gray-800">
                                Active Product
                            </p>

                            <p class="text-xs text-gray-500">
                                Show this product in the store
                            </p>
                        </div>

                        <input v-model="form.is_active" type="checkbox"
                            class="h-5 w-5 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" />
                    </label>
                </section>
            </div>
        </div>

        <!-- Form actions -->
        <div class="flex flex-col-reverse justify-end gap-3 sm:flex-row">
            <slot name="cancel"></slot>

            <button type="submit" :disabled="form.processing"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-6 py-3 text-sm font-semibold text-white transition hover:bg-indigo-700 disabled:cursor-not-allowed disabled:opacity-60">
                <Package :size="17" />

                {{ form.processing
                    ? 'Saving...'
                    : isEdit
                        ? 'Update Product'
                        : 'Create Product'
                }}
            </button>
        </div>
    </form>
</template>