<script setup>
defineProps({
    active: {
        type: Boolean,
        default: false,
    },
});
</script>

<template>
    <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-semibold" :class="active
            ? 'bg-green-50 text-green-700'
            : 'bg-gray-100 text-gray-600'
        ">
        <span class="h-1.5 w-1.5 rounded-full" :class="active ? 'bg-green-500' : 'bg-gray-400'"></span>

        {{ active ? 'Active' : 'Inactive' }}
    </span>
</template>