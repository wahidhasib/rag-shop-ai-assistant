<script setup>
defineProps({
    title: String,
    value: {
        type: [String, Number],
        default: 0,
    },
    description: String,
    icon: {
        type: [Object, Function],
        required: true,
    },
    color: {
        type: String,
        default: 'indigo',
    },
});
</script>

<template>
    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">{{ title }}</p>

                <h3 class="mt-2 text-3xl font-bold tracking-tight text-gray-900">
                    {{ Number(value).toLocaleString() }}
                </h3>
            </div>

            <div class="flex h-12 w-12 items-center justify-center rounded-xl" :class="{
                'bg-indigo-50 text-indigo-600': color === 'indigo',
                'bg-green-50 text-green-600': color === 'green',
                'bg-orange-50 text-orange-600': color === 'orange',
                'bg-red-50 text-red-600': color === 'red',
            }">
                <component :is="icon" :size="23" />
            </div>
        </div>

        <p v-if="description" class="mt-4 text-xs text-gray-500">
            {{ description }}
        </p>
    </div>
</template>