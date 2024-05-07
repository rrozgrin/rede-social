<template>
    <button :class="[
        'rounded-sm py-2 mx-3 px-2 text-sm font-medium leading-5',
        'focus:outline-none ',
        selected
            ? 'border-b-2 border-purple-400 focus:outline-none outline-none text-purple-900 '
            : 'text-purple-400 hover:bg-violer-500 hover:text-purple-600',
    ]">
        {{ text }}
    </button>
</template>

<script setup>
    defineProps({
        selected: Boolean,
        text: String,
    })
</script>

<style></style>