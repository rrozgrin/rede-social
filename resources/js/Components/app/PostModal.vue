<script setup>
    import { computed, watch } from 'vue'
    import { TransitionRoot, TransitionChild, Dialog, DialogPanel, DialogTitle } from '@headlessui/vue'
    import { useForm } from '@inertiajs/vue3';
    import { PaperClipIcon, XMarkIcon, ArrowUturnLeftIcon, VideoCameraIcon } from '@heroicons/vue/24/solid';
    import { ref } from 'vue';
    import { isImage } from '@/helpers';
    import { isVideo } from '@/helpers';

    import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

    //CKEditor 
    const editor = ClassicEditor;

    const editorConfig = {
        toolbar: ['bold', 'italic', '|', 'bulletedList', 'numberedList', '|', 'outdent', 'indent', 'blockQuote', '|', 'link', 'heading']
    }

    //posts
    const emit = defineEmits(['update:modelValue', 'hide']);

    const props = defineProps({
        post: {
            type: Object,
            requered: true,
        },
        modelValue: Boolean,
    });

    const form = useForm({
        body: '',
        attachments: [],
        deleted_file_ids: [],
        _method: 'POST',
    });

    const show = computed({
        get: () => props.modelValue,
        set: (value) => emit('update:modelValue', value),
    });

    const computedAttachments = computed(() => {
        return [...attachmentFiles.value, ...(props.post.attachments || [])];
    });

    watch(() => props.post, () => {
        form.body = props.post.body || ''
    });

    //Arquivos

    /**{
     *      file: File,
     *      url:  '',
     * }
     */
    const attachmentFiles = ref([]);
    const errorMessage = ref('');
    const formErrors = ref({});

    //Incluir-Atualizar post
    function submit() {
        form.attachments = attachmentFiles.value.map(upFile => upFile.file);
        if (props.post.id) {
            form._method = 'PUT';
            form.post(route('post.update', props.post.id), {
                preserveScroll: true,
                onSuccess: () => {
                    show.value = false;
                    closeModal();
                },
                onError: (errors) => {
                    processErrors(errors)
                }
            })
        } else {
            form.post(route('post.create'), {
                preserveScroll: true,
                onSuccess: () => {
                    show.value = false;
                    closeModal();
                },
                onError: (errors) => {
                    processErrors(errors)
                }
            });
        }
    }

    //erros
    function processErrors(errors) {
        formErrors.value = errors
        for (const key in errors) {
            if (key.includes('.')) {
                const [, index] = key.split('.')
                attachmentErrors.value[index] = errors[key]
            }
        }
    }

    //Cancelar post
    function closeModal() {
        show.value = false;
        emit('hide');
        resetModal();
    }

    function resetModal() {
        form.reset();
        attachmentFiles.value = [];
        if (props.post && props.post.attachments) {
            props.post.attachments.forEach(f => f.deleted = false);
        }
    }

    //Incluir arquivos
    async function onAttachmentChoose(event) {
        errorMessage.value = '';
        for (const file of event.target.files) {
            const upFile = {
                file,
                url: await readFile(file)
            }

            if (isImage({ mime: file.type, size: file.size }) || isVideo({ mime: file.type, size: file.size })) {
                attachmentFiles.value.push(upFile);

            } else {
                errorMessage.value = isVideo.error || isImage.error;
                setTimeout(() => {
                    errorMessage.value = '';
                }, 3000);
            }
        }
        event.target.value = null;
    }

    async function readFile(file) {
        return new Promise((res, rej) => {
            if (isImage({ mime: file.type }) || isVideo({ mime: file.type })) {
                const reader = new FileReader();
                reader.onload = () => {
                    res(reader.result);
                }
                reader.onerror = rej
                reader.readAsDataURL(file);
            } else {
                res(null);
            }
        })
    }

    function removeFile(upFile) {
        if (upFile.file) {
            attachmentFiles.value = attachmentFiles.value.filter(f => f !== upFile);
        } else {
            form.deleted_file_ids.push(upFile.id);
            upFile.deleted = true;
        }

    }

    function undoDelete(upFile) {
        upFile.deleted = false;
        form.deleted_file_ids = form.deleted_file_ids.filter(id => upFile.id !== id);
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
                                    {{ post ? 'Editar post' : 'Novo post' }}
                                </DialogTitle>
                                <div class="mt-2">
                                    <ckeditor :editor="editor" v-model="form.body" :config="editorConfig">
                                    </ckeditor>
                                    <div class="grid gap-1 mb-3" :class="[
                                        computedAttachments.length === 1 ? 'grid-cols-1' : 'grid-cols-2'
                                    ]">
                                        <template v-for="upFile of computedAttachments" :key="upFile.file">
                                            <div class="flex relative  items-center justify-center">
                                                <div v-if="upFile.deleted" @click="undoDelete(upFile)"
                                                    class="absolute left-0  right-0 py-1 cursor-pointer z-10 opacity-50 aspect-square px-2 text-xs text-center flex justify-center items-center  bg-black text-white">
                                                    <ArrowUturnLeftIcon class="h-5 w-5 mr-1" />
                                                    <p class="text-xs">clique para manter</p>
                                                </div>
                                                <button @click="removeFile(upFile)"
                                                    class="absolute mt-2 right-1 top-1 inline-flex mr-1 opacity-60 bg-purple-50 hover:opacity-100 rounded-full hover:bg-purple-800  mb-2 text-purple-900 hover:text-purple-50 py-1 px-1 text-xs items-center">
                                                    <XMarkIcon class="h-5 w-5" />
                                                </button>
                                                <img v-if="isImage(upFile.file || upFile)" :src="upFile.url"
                                                    class="shadow-lg rounded-lg my-2 mx-2 aspect-square object-contain"
                                                    :class="upFile.deleted ? 'opacity-50' : ''" />
                                                <div v-if="isVideo(upFile.file || upFile)"
                                                    class="flex flex-col justify-center aspect-square items-center px-3"
                                                    :class="upFile.deleted ? 'opacity-50' : ''">
                                                    <VideoCameraIcon class="w-10 h-10 mb-3" />

                                                    <small class="text-center">
                                                        {{ (upFile.file || upFile).name }}
                                                    </small>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                                <div v-if="errorMessage" class="text-red-500">{{ errorMessage }}</div>
                                <div v-if="formErrors.attachments" class="text-red-500">{{ formErrors.attachments }}
                                </div>
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