<script setup>
defineProps({
    label: String,
    type: {
        type: String,
        default: 'text',
    },
    placeholder: String,
    modelValue: String,
    error: String,
    autocomplete: String,
});

defineEmits(['update:modelValue']);
</script>

<template>
    <div class="space-y-2">
        <label class="block text-sm font-medium text-gray-700">
            {{ label }}
        </label>

        <input :type="type" :placeholder="placeholder" :value="modelValue" :autocomplete="autocomplete"
            @input="$emit('update:modelValue', $event.target.value)"
            class="w-full rounded-xl border border-gray-200 bg-white px-4 py-3 text-sm outline-none transition placeholder:text-gray-400 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10"
            :class="{ 'border-red-500 focus:border-red-500 focus:ring-red-500/10': error }" />

        <p v-if="error" class="text-xs text-red-500">
            {{ error }}
        </p>
    </div>
</template>