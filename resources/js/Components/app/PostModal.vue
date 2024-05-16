<script setup>
    import { computed, watch } from 'vue'
    import { TransitionRoot, TransitionChild, Dialog, DialogPanel, DialogTitle } from '@headlessui/vue'
    import { useForm } from '@inertiajs/vue3';
    import { PaperClipIcon, XMarkIcon } from '@heroicons/vue/24/solid';
    import { ref } from 'vue';
    import { isImageOrVideo } from '@/helpers';

    import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

    //CKEditor 
    const editor = ClassicEditor;

    const editorConfig = {
        toolbar: ['bold', 'italic', '|', 'bulletedList', 'numberedList', '|', 'outdent', 'indent', 'blockQuote', '|', 'link', 'heading']
    }

    //posts
    const emit = defineEmits(['update:modelValue'])

    const props = defineProps({
        post: {
            type: Object,
            requered: true,
        },
        modelValue: Boolean,
    })

    const form = useForm({
        id: null,
        body: '',
    })

    const show = computed({
        get: () => props.modelValue,
        set: (value) => emit('update:modelValue', value),
    })

    watch(() => props.post, () => {
        form.id = props.post.id
        form.body = props.post.body
    })

    //Arquivos

    /**{
     *      file: File,
     *      url:  '',
     * }
     */
    const attachmentFiles = ref([])
    const errorMessage = ref('');

    //Incluir-Atualizar post
    function submit() {
        if (form.id) {
            form.put(route('post.update', props.post.id), {
                preserveScroll: true,
                onSuccess: () => {
                    show.value = false
                    form.reset()
                }
            })
        } else {
            form.post(route('post.create'), {
                preserveScroll: true,
                onSuccess: () => {
                    show.value = false
                    form.reset()
                }
            });
        }
    }

    //Cancelar post
    function closeModal() {
        show.value = false
        form.reset()
        attachmentFiles.value = []
    }

    //Incluir arquivos
    async function onAttachmentChoose(event) {
        errorMessage.value = '';
        for (const file of event.target.files) {
            const upFile = {
                file,
                url: await readFile(file)
            }

            if (isImageOrVideo({ mime: file.type })) {
                attachmentFiles.value.push(upFile);
            } else {
                errorMessage.value = 'O tipo de arquivo selecionado não é suportado. Apenas imagens e vídeos são permitidos.';
                setTimeout(() => {
                    errorMessage.value = '';
                }, 3000);
            }
        }
        event.target.value = null;
    }

    async function readFile(file) {
        return new Promise((res, rej) => {
            if (isImageOrVideo({ mime: file.type })) {
                const reader = new FileReader();
                reader.onload = () => {
                    res(reader.result)
                }
                reader.onerror = rej
                reader.readAsDataURL(file);
            } else {
                res(null)
            }
        })
    }

    function removeFile(upFile) {
        attachmentFiles.value = attachmentFiles.value.filter(f => f !== upFile)
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
                    <div class="flex min-h-full items-center justify-center p-4 text-center">
                        <TransitionChild as="template" enter="duration-300 ease-out" enter-from="opacity-0 scale-95"
                            enter-to="opacity-100 scale-100" leave="duration-200 ease-in"
                            leave-from="opacity-100 scale-100" leave-to="opacity-0 scale-95">
                            <DialogPanel
                                class="lg:w-[600px] bg-purple-50 sm:w-full transform overflow-hidden rounded-2xl p-6 text-left align-middle shadow-xl transition-all">
                                <DialogTitle as="h3" class="text-lg font-medium leading-6 text-purple-900">
                                    {{ form.id ? 'Editar post' : 'Novo post' }}
                                </DialogTitle>
                                <div class="mt-2">
                                    <ckeditor :editor="editor" v-model="form.body" :config="editorConfig">
                                    </ckeditor>
                                    <div class="grid grid-cols-3 gap-1 mb-3">
                                        <template v-for="upFile of attachmentFiles" :key="upFile.file.name">
                                            <div class="flex relative  items-center justify-center">
                                                <button @click="removeFile(upFile)"
                                                    class="absolute mt-2 right-1 top-1 inline-flex mr-1 opacity-60 bg-purple-50 hover:opacity-100 rounded-full hover:bg-purple-800  mb-2 text-purple-900 hover:text-purple-50 py-1 px-1 text-xs items-center">
                                                    <XMarkIcon class="h-5 w-5" />
                                                </button>
                                                <img v-if="isImageOrVideo({ mime: upFile.file.type })" :src="upFile.url"
                                                    class="shadow-lg rounded-lg my-2 mx-2 object-cover aspect-square" />
                                            </div>
                                        </template>
                                    </div>
                                </div>
                                <div v-if="errorMessage" class="text-red-500">{{ errorMessage }}</div>
                                <div class="w-full px-2 py-1 flex justify-end items-center">
                                    <button @click="submit" type="button"
                                        class="flex items-center relative text-purple-600">
                                        <PaperClipIcon class="h-5 w-5 mr-1" /> Adicionar fotos
                                        <input @click.stop @change="onAttachmentChoose" type="file" multiple
                                            class="absolute left-0 top-0 right-0 bottom-0 opacity-0" />
                                    </button>
                                </div>
                                <div class="mt-1 flex gap-1 w-full">
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