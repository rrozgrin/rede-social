<script setup>
defineProps({
    type: {
        type: String,
        default: 'button',
    },
});
</script>

<template>
    <button
        :type="type"
        class="inline-flex items-center px-4 py-2 bg-purple-600   rounded-md font-semibold text-xs text-purple-100 uppercase tracking-widest shadow-sm hover:bg-purple-400  focus:outline-none  disabled:opacity-25 transition ease-in-out duration-150"
    >
        <slot />
    </button>
</template>