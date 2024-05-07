
<script setup>
import { onMounted, ref } from 'vue';

const model = defineModel({
    type: String,
    required: true,
});

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <input
        class="border-purple-300 bg-purple-200  focus:border-purple-500  focus:ring-purple-500  rounded-md shadow-sm"
        v-model="model"
        ref="input"
    />
</template>
