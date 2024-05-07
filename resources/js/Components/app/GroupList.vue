<script setup>
    import { ref } from "vue";
    import GroupItem from './GroupItem.vue';
    import { Disclosure, DisclosureButton, DisclosurePanel } from '@headlessui/vue';
    import { ChevronRightIcon } from "@heroicons/vue/24/solid";
    const searchKeyword = ref("");
</script>

<template>
    <div class="px-3 pb-3 mb-2 bg-white w-full rounded-xl overflow-hidden flex flex-col">
        <div class="flex-1 block lg:hidden">
            <Disclosure v-slot="{ open }">
                <DisclosureButton class="w-full">
                    <div class=" pt-3 flex justify-between items-center">
                        <h2 class="text-xl font-semibold text-center">Meus Grupos</h2>
                        <ChevronRightIcon class="h-5 w-5 transition-all" :class="open ? 'rotate-90' : 'transform'" />
                    </div>
                </DisclosureButton>
                <DisclosurePanel>
                    <div class="mx-3 flex justify-center mb-5">
                        <input type="text" :v-model="searchKeyword" placeholder="Digite para procurar"
                            class="border-purple-200  text-center ml-2 px-3 mt-3 border-1 border-b-2  rounded-md shadow-sm focus:outline-none focus:border-purple-300" />
                    </div>
                    <div class="py-3 flex-1 overflow-auto">
                        <div v-if="false" class="text-gray-400 flex text-center px-6">
                            Você ainda não possui nenhum grupo
                        </div>
                        <div v-else class="h-[150px]">
                            <GroupItem image="https://picsum.photos/100" title="Nome do grupo"
                                description="dLorem Ipsum is simply dummy text of the printing and typesetting industry." />
                            <GroupItem image="https://picsum.photos/200" title="Nome do grupo"
                                description="dLorem Ipsum is simply dummy text of the printing and typesetting industry." />
                            <GroupItem image="https://picsum.photos/300" title="Nome do grupo"
                                description="dLorem Ipsum is simply dummy text of the printing and typesetting industry." />
                            <GroupItem image="https://picsum.photos/200" title="Nome do grupo"
                                description="dLorem Ipsum is simply dummy text of the printing and typesetting industry." />
                            <GroupItem image="https://picsum.photos/100" title="Nome do grupo"
                                description="dLorem Ipsum is simply dummy text of the printing and typesetting industry." />
                        </div>
                    </div>
                </DisclosurePanel>
            </Disclosure>
        </div>
        <div class="hidden lg:block">
            <h2 class="text-xl font-semibold text-center pt-3 font-semibold text-center">Meus Grupos</h2>
            <div class="mx-3 flex justify-center mb-5">
                <input type="text" :v-model="searchKeyword" placeholder="Digite para procurar"
                    class="border-purple-200  text-center ml-2 px-3 mt-3 border-1 border-b-2  rounded-md shadow-sm focus:outline-none focus:border-purple-300" />
            </div>
            <div class="py-3 flex-1 overflow-auto">
                <div v-if="false" class="text-gray-400 flex text-center px-6">
                    Você ainda não possui nenhum grupo
                </div>
                <div v-else class="h-[450px]">
                    <GroupItem image="https://picsum.photos/100" title="Nome do grupo"
                        description="dLorem Ipsum is simply dummy text of the printing and typesetting industry." />
                    <GroupItem image="https://picsum.photos/200" title="Nome do grupo"
                        description="dLorem Ipsum is simply dummy text of the printing and typesetting industry." />
                    <GroupItem image="https://picsum.photos/300" title="Nome do grupo"
                        description="dLorem Ipsum is simply dummy text of the printing and typesetting industry." />
                    <GroupItem image="https://picsum.photos/400" title="Nome do grupo"
                        description="dLorem Ipsum is simply dummy text of the printing and typesetting industry." />

                </div>
            </div>
        </div>
    </div>
</template>

<style></style>