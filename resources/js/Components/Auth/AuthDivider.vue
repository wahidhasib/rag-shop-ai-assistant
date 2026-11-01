<template>
    <div class="relative py-2">
        <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t border-gray-200"></div>
        </div>

        <div class="relative flex justify-center">
            <span class="bg-white px-4 text-xs text-gray-400">
                <slot>OR</slot>
            </span>
        </div>
    </div>
</template>