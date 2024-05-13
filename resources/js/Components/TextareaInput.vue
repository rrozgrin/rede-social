<script setup>
    import { onMounted, ref } from 'vue';


    const props = defineProps({
        modelValue: {
            type: String,
            required: true,
        },
        placeholder: String,
        autoResize: {
            type: Boolean,
            default: true,
        }
    })

    const emit = defineEmits(['update:modelValue']);

    const input = ref(null);

    onMounted(() => {
        adjustHeight();
    });

    defineExpose({ focus: () => input.value.focus() });

    function onInputChange($event) {
        emit('update:modelValue', $event.target.value);
        adjustHeight();
    }

    function adjustHeight(){       
        if (props.autoResize) {
            input.value.style.height = 'auto';
            input.value.style.height = input.value.scrollHeight + 'px';
        }
    }


</script>

<template>
    <textarea
        class="border-purple-300 bg-purple-100  focus:border-purple-500 placeholder-purple-300  focus:ring-purple-500  rounded-md shadow-sm"
        ref="input" @input="onInputChange" placeholder="Escrava um novo post" :value="modelValue"></textarea>
</template>
