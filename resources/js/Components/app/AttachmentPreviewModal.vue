<script setup>
    import { computed } from 'vue'
    import { TransitionRoot, TransitionChild, Dialog, DialogPanel } from '@headlessui/vue'
    import { XMarkIcon, ChevronLeftIcon, ChevronRightIcon } from '@heroicons/vue/24/solid';
    import { isImage } from '@/helpers';
    import { isVideo } from '@/helpers';

    const emit = defineEmits(['update:modelValue', 'update:index', 'hide']);

    const props = defineProps({
        attachments: {
            type: Array,
            requered: true,
        },
        index: Number,
        modelValue: Boolean,
    });

    const show = computed({
        get: () => props.modelValue,
        set: (value) => emit('update:modelValue', value)
    });

    const currentIndex = computed({
        get: () => props.index,
        set: (value) => emit('update:index', value)
    });

    const attachment = computed(() => {
        return props.attachments[currentIndex.value]
    });

    function closeModal() {
        show.value = false;
        emit('hide');
    }

    function prev() {
        if (currentIndex.value === 0) return;
        currentIndex.value--;
    }

    function next() {
        if (currentIndex.value === props.attachments.length - 1) return;
        currentIndex.value++;
    }

</script>
<template>
    <teleport to="body">
        <TransitionRoot appear :show="show" as="template">
            <Dialog as="div" @close="closeModal" class="relative z-30">
                <TransitionChild as="template" enter="duration-300 ease-out" enter-from="opacity-0"
                    enter-to="opacity-100" leave="duration-200 ease-in" leave-from="opacity-100" leave-to="opacity-0">
                    <div class="fixed inset-0 bg-black/25" />
                </TransitionChild>

                <div class="fixed inset-0 overflow-y-auto">
                    <div class="flex h-full w-full items-center justify-center p-4 text-center">
                        <TransitionChild as="template" enter="duration-300 ease-out" enter-from="opacity-0 scale-95"
                            enter-to="opacity-100 scale-100" leave="duration-200 ease-in"
                            leave-from="opacity-100 scale-100" leave-to="opacity-0 scale-95">
                            <DialogPanel
                                class="flex flex-col w-full transform overflow-hidden mt-10 text-left align-middle shadow-xl transition-all">
                                <button @click="closeModal"
                                    class="absolute right-3 top-3 w-10 h-10 rounded-full hover:bg-purple-900/60 transition flex items-center justify-center text-black hover:text-purple-50 z-40">
                                    <XMarkIcon class="w-6 h-6 " />
                                </button>
                                <div class="relative group max-h-max bg-slate-700 ">
                                    <div @click="prev"
                                        class="absolute left-0 z-20 h-full flex items-center opacity-60 hover:opacity-70 justify-between hover:bg-black/10">
                                        <ChevronLeftIcon class="text-purple-400 shadow-lg w-12" />
                                    </div>
                                    <div @click="next"
                                        class="absolute right-0  z-20 h-full flex items-center opacity-60 hover:opacity-70 justify-between hover:bg-black/10">
                                        <ChevronRightIcon class="text-purple-400 shadow-lg w-12" />
                                    </div>
                                    <div class="flex items-center justify-center ">
                                        <img v-if="isImage(attachment)" :src="attachment.url" width="480"
                                            height="auto" />
                                        <video v-else-if="isVideo(attachment)" :src="attachment.url" width="320"
                                            height="240" controls="controls" />
                                    </div>
                                </div>
                            </DialogPanel>
                        </TransitionChild>
                    </div>
                </div>
            </Dialog>
        </TransitionRoot>
    </teleport>
</template>