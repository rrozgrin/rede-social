<template>
    <AuthenticatedLayout>
        <div class="container mx-auto pt-[75px] overflow-auto ">
            <div class="relative">
                <img class="mx-auto h-[200px] w-full object-cover"
                    src="/img/default_cover.jpg">
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
                        <TabPanel v-if="isMyProfile" key="posts" class="rounded-xl bg-purple-100 p-3 shadow-inner shadow-purple-900">
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
    import { PencilIcon } from '@heroicons/vue/24/solid';
    import { computed } from 'vue';

    const authUser = usePage().props.auth.user;
    const isMyProfile = computed(()=>authUser && authUser.id === props.user.id) ;

    const props = defineProps({
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

    

</script>

<style>
</style>