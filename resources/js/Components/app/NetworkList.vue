<script setup>
    import { ref } from "vue";
    import NetworkItem from './NetworkItem.vue';
    import { Disclosure, DisclosureButton, DisclosurePanel } from '@headlessui/vue';
    import { ChevronRightIcon } from "@heroicons/vue/24/solid";
    const searchKeyword = ref("");
</script>

<template>
    <div class="px-3 pb-3 mb-2 bg-white w-full rounded-xl overflow-hidden flex flex-col">
        <div class="flex-1 block lg:hidden">
            <Disclosure v-slot="{ open }">
                <DisclosureButton class="w-full">
                    <div class="flex pt-3 justify-between items-center">
                        <h2 class="text-xl font-semibold text-center">Minhas Conexões</h2>
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
                            Você ainda não possui nenhum amigo
                        </div>
                        <div v-else>
                            <NetworkItem image="https://picsum.photos/500" name="Carlos da Silva" />
                            <NetworkItem image="https://picsum.photos/600" name="Katia" />
                            <NetworkItem image="https://picsum.photos/700" name="Felipe" />
                            <NetworkItem image="https://picsum.photos/800" name="Crystal" />
                            <NetworkItem image="https://picsum.photos/900" name="Fabia" />

                        </div>
                    </div>
                </DisclosurePanel>
            </Disclosure>
        </div>
        <div class="hidden lg:block">
            <h2 class="text-xl pt-3 font-semibold text-center">Minhas Conexões</h2>
            <div class="mx-3 flex justify-center mb-5">
                <input type="text" :v-model="searchKeyword" placeholder="Digite para procurar"
                    class="border-purple-200 text-center ml-2 px-3 mt-3 border-1 border-b-2  rounded-md shadow-sm focus:outline-none focus:border-purple-300" />
            </div>

            <div class="py-3 flex-1 overflow-auto">
                <div v-if="false" class="text-gray-400 flex text-center px-6">
                    Você ainda não possui nenhum amigo
                </div>
                <div v-else class="h-[450px]">
                    <NetworkItem image="https://picsum.photos/500" name="Carlos da Silva" />
                    <NetworkItem image="https://picsum.photos/600" name="Katia" />
                    <NetworkItem image="https://picsum.photos/700" name="Felipe" />
                    <NetworkItem image="https://picsum.photos/800" name="Crystal" />
                    <NetworkItem image="https://picsum.photos/900" name="Fabia" />

                </div>
            </div>
        </div>
    </div>
</template>

<style></style>