<template>
    <teleport to="body">
        <TransitionRoot appear :show="show" as="template">
            <Dialog as="div" @close="closeModal" class="relative z-10">
                <TransitionChild as="template" enter="duration-300 ease-out" enter-from="opacity-0"
                    enter-to="opacity-100" leave="duration-200 ease-in" leave-from="opacity-100" leave-to="opacity-0">
                    <div class="fixed inset-0 bg-black/25" />
                </TransitionChild>

                <div class="fixed inset-0 overflow-y-auto">
                    <div class="flex min-h-full items-center justify-center p-4 text-center">
                        <TransitionChild as="template" enter="duration-300 ease-out" enter-from="opacity-0 scale-95"
                            enter-to="opacity-100 scale-100" leave="duration-200 ease-in"
                            leave-from="opacity-100 scale-100" leave-to="opacity-0 scale-95">
                            <DialogPanel
                                class="w-full max-w-md transform overflow-hidden rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all">
                                <DialogTitle as="h3" class="text-lg font-medium leading-6 text-gray-900">
                                    Editar post
                                </DialogTitle>
                                <div class="mt-2">
                                    <TextareaInput v-model="post.body" class=" w-full"></TextareaInput>
                                </div>

                                <div class="mt-1 flex gap-1 justify-end">
                                    <button type="button"
                                        class="inline-flex justify-center rounded-md border border-transparent bg-purple-100 px-4 py-1 text-sm font-medium text-purple-900 hover:text-purple-100 shadow-sm hover:bg-purple-900 focus:outline-none focus-visible:ring-2 focus-visible:ring-purple-500 focus-visible:ring-offset-2"
                                        @click="closeModal">
                                        Cancelar
                                    </button>
                                    <button type="button"
                                        class="inline-flex justify-center rounded-md border border-transparent bg-purple-100 px-4 py-1 text-sm font-medium text-purple-900 hover:text-purple-100 shadow-sm hover:bg-purple-900 focus:outline-none focus-visible:ring-2 focus-visible:ring-purple-500 focus-visible:ring-offset-2"
                                        @click="submit">
                                        Salvar
                                    </button>
                                </div>
                            </DialogPanel>
                        </TransitionChild>
                    </div>
                </div>
            </Dialog>
        </TransitionRoot>
    </teleport>
</template>

<script setup>
    import { computed, reactive, watch } from 'vue'
    import {
        TransitionRoot,
        TransitionChild,
        Dialog,
        DialogPanel,
        DialogTitle,
    } from '@headlessui/vue'
    import TextareaInput from '../TextareaInput.vue';
    import { useForm } from '@inertiajs/vue3';

    const emit = defineEmits(['update:modelValue'])

    const props = defineProps({
        post: {
            type: Object,
            requered: true,
        },
        modelValue: Boolean,
    })

    const reactivePost = reactive(props.post);

    const form = useForm({
        id: null,
        body: '',
    })

    const show = computed({
        get: () => props.modelValue,
        set: (value) => emit('update:modelValue', value),
    })

    function submit() {
        const form = useForm({
            id: props.post.post_id,
            body: props.post.body,
        })

        form.put(route('post.update', props.post))
        show.value = false
    }

    function closeModal() {
        show.value = false
    }

    watch(reactivePost, () => {
        console.log('mudou')
    }, { immediate: true, deep: true })

</script>