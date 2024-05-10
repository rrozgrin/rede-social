<script setup>
    import { Disclosure, DisclosureButton, DisclosurePanel } from '@headlessui/vue'
    import { HandThumbUpIcon, ChatBubbleLeftRightIcon, ChevronDownIcon, TrashIcon, EllipsisVerticalIcon, PencilIcon } from '@heroicons/vue/24/solid'
    import { Menu, MenuButton, MenuItems, MenuItem } from '@headlessui/vue'
    import { ref } from "vue";

    // import ArchiveIcon from './archive-icon.vue'
    // import DuplicateIcon from './duplicate-icon.vue'
    // import MoveIcon from './move-icon.vue'


    const emit = defineEmits(['editClick'])
    const props = defineProps({
        post: Object
    })
    
    function isImage(attachment) {
        const mime = attachment.mime.split('/')
        return mime[0].toLowerCase() === 'image'
    }

    function openEditModal(){
        emit('editClick', props.post)
    }
</script>

<template>
    <div class="bg-white  rounded-l-3xl rounded-r-xl mb-3 p-5 ">
        <div class="flex items-center gap-3 ">
            <div class="flex items-center w-full">
                <a href="#">
                    <img :src="'storage/' + post.user.avatar_url"
                        class="w-[80px] rounded-full hover:ring-purple-600 hover:ring-2 transition-all" />
                </a>
                <div class="w-full">
                    <h4 class="font-bold pl-3 text-purple-950 m-0">
                        <a href="#" class="hover:underline"> {{ post.user.name }}</a>
                        <template v-if="post.group">
                            |
                            <a href="#" class="hover:underline">{{ post.group.name }}</a>
                        </template>
                    </h4>
                    <small class="text-purple-600 pl-3 -pt-">{{ post.created_at }}</small>
                </div>
                <div class="w-9 ">
                    <Menu as="div" class="relative inline-block text-left">
                        <div>
                            <MenuButton
                                class="w-8 h-8 rounded-full hover:bg-purple-900 hover:text-purple-100 text-purple-900  transition flex items-center justify-center">

                                <EllipsisVerticalIcon class=" h-6 w-6  " aria-hidden="true" />
                            </MenuButton>
                        </div>

                        <transition enter-active-class="transition duration-100 ease-out"
                            enter-from-class="transform scale-95 opacity-0"
                            enter-to-class="transform scale-100 opacity-100"
                            leave-active-class="transition duration-75 ease-in"
                            leave-from-class="transform scale-100 opacity-100"
                            leave-to-class="transform scale-95 opacity-0">
                            <MenuItems
                                class="absolute right-0 mt-1 w-32 origin-top-right divide-y divide-gray-100 rounded-md bg-white shadow-lg ring-1 ring-black/5 focus:outline-none">
                                <div class="px-1 py-1">
                                    <MenuItem v-slot="{ active }">
                                    <button @click="openEditModal" :class="[
                                        active ? 'bg-purple-900 text-white' : 'text-purple-900',
                                        'group flex w-full items-center rounded-md px-2 py-2 text-sm',
                                    ]">
                                        <PencilIcon :active="active" :class="[
                                            'mr-2 h-5 w-5 text-purple-900',
                                            active ? 'bg-purple-900 text-white' : 'text-purple-900',
                                        ]" aria-hidden="true" />
                                        Editar
                                    </button>
                                    </MenuItem>
                                </div>

                                <div class="px-1 py-1">
                                    <MenuItem v-slot="{ active }">
                                    <button :class="[
                                        active ? 'bg-purple-900 text-white' : 'text-purple-900',
                                        'group flex w-full items-center rounded-md px-2 py-2 text-sm',
                                    ]">
                                        <TrashIcon :active="active" :class="[
                                            'mr-2 h-5 w-5 text-purple-900',
                                            active ? 'bg-purple-900 text-white' : 'text-purple-900',
                                        ]" aria-hidden="true" />
                                        Excluir
                                    </button>
                                    </MenuItem>
                                </div>
                            </MenuItems>
                        </transition>
                    </Menu>
                </div>
            </div>
        </div>
        <div class="mb-3" v-if="post && post.body">
            <Disclosure v-slot="{ open }">
                <div v-if="!open && post.body" v-html="post.body.substring(0, 200)" class="ml-14 p-1" />
                <template v-if="post.body.length >= 200">
                    <DisclosurePanel>
                        <div v-html="post.body" class="ml-14 mr-8 px-1" />
                    </DisclosurePanel>
                    <div class="flex justify-end">
                        <DisclosureButton class="text-purple-400 text-sm">
                            <span>{{ open ? '...leia menos' : 'leia mais...' }}</span>
                        </DisclosureButton>
                    </div>
                </template>
            </Disclosure>
        </div>
        <div class="flex justify-end">
            <button class="flex mx-2 rounded-md gap-1 bg-violet-100 hover:bg-purple-200 justify-center py-1 px-2">
                <HandThumbUpIcon class="w-5 h-5" />
                Curtir
            </button>
            <button class="flex mx-2 rounded-md gap-1 bg-violet-100 hover:bg-purple-200 justify-center py-1 px-2">
                <ChatBubbleLeftRightIcon class="w-5 h-5" />
                Comentar
            </button>
        </div>
    </div>
    
</template>

<style scoped></style>