<script setup>
    import { Disclosure, DisclosureButton, DisclosurePanel } from '@headlessui/vue'
    import { HandThumbUpIcon } from '@heroicons/vue/24/solid'
    import { ChatBubbleLeftRightIcon } from '@heroicons/vue/24/solid'
    defineProps({
        post: Object
    })
    function isImage(attachment) {
        const mime = attachment.mime.split('/')
        return mime[0].toLowerCase() === 'image'
    }
</script>

<template>
    <div class="bg-white  rounded-l-3xl rounded-r-xl mb-3 p-5 ">
        <div class="flex items-center gap-3 ">
            <img :src="'storage/' + post.user.avatar_url"
                class="w-[48px] rounded-full hover:ring-purple-600 hover:ring-2 transition-all" />
            <div>
                <h4 class="font-bold text-purple-950 m-0">
                    <a href="#" class="hover:underline"> {{ post.user.name }}</a>
                    <template v-if="post.group">
                        |
                        <a href="#" class="hover:underline">{{ post.group.name }}</a>
                    </template>
                </h4>
                <small class="text-purple-600">{{ post.created_at }}</small>
            </div>
        </div>
        <div class="mb-3"  v-if="post && post.body">
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