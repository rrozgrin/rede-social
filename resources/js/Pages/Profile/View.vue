<template>
    <AuthenticatedLayout>
        <div class="container mx-auto pt-[75px] overflow-auto ">
            <div v-show="showNotification && success"
                class="px-2  mb-1 py-2 font-medium h-full text-sm bg-emerald-500 text-white">
                {{ success }}
            </div>
            <div v-show="errors.cover" class="px-2 mb-1 py-2 font-medium h-full text-sm bg-red-500 text-white">
                O arquivo precisa ser do tipo imagem
            </div>
            <div class="relative">
                <img class="mx-auto h-[200px] w-full object-cover"
                    :src="coverImageSrc || (user.cover_url ? '/storage/' + user.cover_url : '/img/default_cover.jpg')">
                <div class="absolute  top-2 right-2">
                    <button v-if="!coverImageSrc"
                        class="opacity-60 hover:opacity-100 bg-purple-50 hover:bg-purple-600 text-purple-600 hover:text-purple-50 py-1 px-2 text-xs flex items-center">
                        <CameraIcon class="h-5 w-5 mr-1" />
                        Atualizar imagem de capa

                        <input type="file" class="absolute left-0 top-0 bottom-0 right-0 opacity-0 cursor-pointer"
                            @change="onCoverChange" />
                    </button>
                    <div v-else>
                        <button @click="cancelCoverImage"
                            class="inline-flex mr-1 opacity-60 hover:opacity-100 bg-purple-50 hover:bg-purple-600 text-purple-600 hover:text-purple-50 py-1 px-2 text-xs items-center">
                            <XMarkIcon class="h-5 w-5 mr-1" />
                            Cancelar
                        </button>
                        <button @click="submitCoverFile"
                            class="inline-flex mr-1 opacity-60 hover:opacity-100 bg-purple-50 hover:bg-purple-600 text-purple-600 hover:text-purple-50 py-1 px-2 text-xs items-center">
                            <ArrowUpTrayIcon class="h-5 w-5 mr-1" />
                            Enviar
                        </button>
                    </div>
                </div>
                <div class="flex">
                    <div class="relative flex justify-center items-end ml-5 h-5 -bottom-[20px]">
                        <img class=" w-[150px] h-[150px] rounded-full"
                            :src="avatarImageSrc || (user.avatar_url ? '/storage/' + user.avatar_url : '/img/default_avatar.png')">
                        <div class="absolute">
                            <button v-if="!avatarImageSrc"
                                class="opacity-10 hover:opacity-50 w-[150px] h-[75px]  justify-center rounded-br-full rounded-bl-full bg-white  hover:bg-purple-300 text-purple-900 hover:text-purple-900 py-1 px-2 text-xs flex items-center">
                                <CameraIcon class="h-5 w-5 mr-1" />
                                <input type="file"
                                    class="absolute left-0 top-0 bottom-0 right-0 opacity-0 cursor-pointer"
                                    @change="onAvatarChange" />
                            </button>
                            <div v-else>
                                <button @click="cancelAvatarImage"
                                    class="inline-flex mr-1 opacity-60 bg-purple-50 hover:opacity-100 rounded-full hover:bg-purple-800  mb-2 text-purple-900 hover:text-purple-50 py-1 px-2 text-xs items-center">
                                    <XMarkIcon class="h-5 w-5" />
                                </button>
                                <button @click="submitAvatarFile"
                                    class="inline-flex mr-1 opacity-60 bg-purple-50 hover:opacity-100 rounded-full hover:bg-purple-800 mb-2 text-purple-900 hover:text-purple-50 py-1 px-2 text-xs items-center">
                                    <ArrowUpTrayIcon class="h-5 w-5" />
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-between items-start flex-1 Secondary ml-5 text-purple-100 mt-2 pb-3">
                        <h2 class="font-semibold text-lg">{{ user.name }}</h2>
                        <SecondaryButton v-if="isMyProfile">
                            <PencilIcon class="h-3 w-3 mr-1" />
                            Editar Perfil
                        </SecondaryButton>
                    </div>
                </div>
            </div>
            <div>
                <TabGroup>
                    <TabList class="sm:px-6 lg:px-16  bg-purple-100 flex space-x-1 rounded-lg pt-1">
                        <Tab v-slot="{ selected }" as="template">
                            <TabItem text="Posts" :selected="selected" />
                        </Tab>
                        <Tab v-slot="{ selected }" as="template">
                            <TabItem text="Conexões" :selected="selected" />
                        </Tab>
                        <Tab v-slot="{ selected }" as="template">
                            <TabItem text="Fotos" :selected="selected" />
                        </Tab>
                        <Tab v-if="isMyProfile" v-slot="{ selected }" as="template">
                            <TabItem text="Meu perfil" :selected="selected" />
                        </Tab>
                    </TabList>

                    <TabPanels class="mt-2">
                        <TabPanel key="posts" class="rounded-xl bg-purple-100 p-3 shadow-inner shadow-purple-900">
                            Posts
                        </TabPanel>
                        <TabPanel key="posts" class="rounded-xl bg-purple-100 p-3 shadow-inner shadow-purple-900">
                            Conexões
                        </TabPanel>
                        <TabPanel key="posts" class="rounded-xl bg-purple-100 p-3 shadow-inner shadow-purple-900">
                            Fotos
                        </TabPanel>
                        <TabPanel v-if="isMyProfile" key="posts"
                            class="rounded-xl bg-purple-100 p-3 shadow-inner shadow-purple-900">
                            <Edit :must-verify-email="mustVerifyEmail" :status="status" />
                        </TabPanel>
                    </TabPanels>
                </TabGroup>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
    import { TabGroup, TabList, Tab, TabPanel, TabPanels } from '@headlessui/vue';
    import { usePage } from '@inertiajs/vue3';
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import TabItem from '@/Pages/Profile/Partials/TabItem.vue'
    import Edit from '@/Pages/Profile/Edit.vue';
    import SecondaryButton from '@/Components/SecondaryButton.vue';
    import { ArrowUpIcon, ArrowUpTrayIcon, ArrowUturnUpIcon, CameraIcon, PencilIcon, XMarkIcon } from '@heroicons/vue/24/solid';
    import { computed, ref } from 'vue';
    import { useForm } from '@inertiajs/vue3';

    const imagesForm = useForm({
        cover: null,
        avatar: null,
    })

    const coverImageSrc = ref('');
    const avatarImageSrc = ref('');
    const authUser = usePage().props.auth.user;
    const isMyProfile = computed(() => authUser && authUser.id === props.user.id);
    const showNotification = ref(true);

    const props = defineProps({
        errors: Object,
        mustVerifyEmail: {
            type: Boolean,
        },
        status: {
            type: String,
        },
        success: {
            type: String,
        },
        user: {
            type: Object,
        },
    });

    function onCoverChange(event) {
        imagesForm.cover = event.target.files[0]
        if (imagesForm.cover) {
            const reader = new FileReader()
            reader.onload = () => {
                coverImageSrc.value = reader.result;
            }
            reader.readAsDataURL(imagesForm.cover)
        }
    }

    function cancelCoverImage() {
        imagesForm.cover = null;
        coverImageSrc.value = null;
    }

    function submitCoverFile() {
        console.log(imagesForm.cover)
        imagesForm.post(route('profile.updateImage'), {
            onSuccess: () => {
                cancelCoverImage()
                setTimeout(() => {
                    showNotification.value = false
                }, 3000)
            }
        })
    }

    function onAvatarChange(event) {
        imagesForm.avatar = event.target.files[0]
        if (imagesForm.avatar) {
            const reader = new FileReader()
            reader.onload = () => {
                avatarImageSrc.value = reader.result;
            }
            reader.readAsDataURL(imagesForm.avatar)
        }
    }

    function cancelAvatarImage() {
        imagesForm.avatar = null;
        avatarImageSrc.value = null;
    }

    function submitAvatarFile() {
        console.log(imagesForm.Avatar)
        imagesForm.post(route('profile.updateImage'), {
            onSuccess: () => {
                cancelAvatarImage()
                setTimeout(() => {
                    showNotification.value = false
                }, 3000)
            }
        })
    }


</script>

<style></style>