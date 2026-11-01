<script setup>
defineProps({
    modelValue: Boolean,
    label: String,
});

defineEmits(['update:modelValue']);
</script>

<template>
    <label class="flex cursor-pointer items-center gap-2">
        <input type="checkbox" :checked="modelValue" @change="$emit('update:modelValue', $event.target.checked)"
            class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" />

        <span class="text-sm text-gray-600">
            {{ label }}
        </span>
    </label>
</template>