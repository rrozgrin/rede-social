<template>
    <AuthenticatedLayout>
        <div class="container mx-auto pt-[75px] overflow-auto ">
            <div class="relative">
                <img class="mx-auto h-[200px] w-full object-cover"
                    :src="coverImageSrc || (user.cover_url ? '/storage/' + user.cover_url : '/storage/user-default.jpg') || '/img/default_cover.jpg'">
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
                        <button @click="submitImageFile"
                            class="inline-flex mr-1 opacity-60 hover:opacity-100 bg-purple-50 hover:bg-purple-600 text-purple-600 hover:text-purple-50 py-1 px-2 text-xs items-center">
                            <ArrowUpTrayIcon class="h-5 w-5 mr-1" />
                            Enviar
                        </button>
                    </div>
                </div>
                <div class="flex">
                    <img class="absolute left-[64px] w-[150px] h-[150px] -bottom-[0px] rounded-full"
                        src="https://randomuser.me/api/portraits/men/46.jpg">
                    <div
                        class="flex justify-between items-center flex-1 Secondary ml-[230px] text-purple-100 mt-2 pb-3">
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
                        <Tab v-if="isMyProfile" v-slot="{ selected }" as="template">
                            <TabItem text="Meu perfil" :selected="selected" />
                        </Tab>
                        <Tab v-slot="{ selected }" as="template">
                            <TabItem text="Posts" :selected="selected" />
                        </Tab>
                        <Tab v-slot="{ selected }" as="template">
                            <TabItem text="Conexões" :selected="selected" />
                        </Tab>
                        <Tab v-slot="{ selected }" as="template">
                            <TabItem text="Fotos" :selected="selected" />
                        </Tab>
                    </TabList>

                    <TabPanels class="mt-2">
                        <TabPanel v-if="isMyProfile" key="posts"
                            class="rounded-xl bg-purple-100 p-3 shadow-inner shadow-purple-900">
                            <Edit :must-verify-email="mustVerifyEmail" :status="status" />
                        </TabPanel>
                        <TabPanel key="posts" class="rounded-xl bg-purple-100 p-3 shadow-inner shadow-purple-900">
                            Posts
                        </TabPanel>
                        <TabPanel key="posts" class="rounded-xl bg-purple-100 p-3 shadow-inner shadow-purple-900">
                            Conexões
                        </TabPanel>
                        <TabPanel key="posts" class="rounded-xl bg-purple-100 p-3 shadow-inner shadow-purple-900">
                            Fotos
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
    const authUser = usePage().props.auth.user;
    const isMyProfile = computed(() => authUser && authUser.id === props.user.id);

    const props = defineProps({
        errors: Object,
        mustVerifyEmail: {
            type: Boolean,
        },
        status: {
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

    function submitImageFile() {
        console.log(imagesForm.cover)
        imagesForm.post(route('profile.updateImage'))
    }


</script>

<style></style>