<script setup>
    import { ref } from 'vue';
    import TextareaInput from '@/Components/TextareaInput.vue';
    import PostModal from '@/Components/app/PostModal.vue';

    const showModal = ref(false)
    const newPost = ref({})

    function showCreatePostModal() {
        showModal.value = true
    }

</script>

<template>
    <div class="py-2 rounded-lg  mb-2 ">
        <div @click="showCreatePostModal" class="py-2 flex justify-center items-center shadow-lg  text-purple-200  bg-gradient-to-t from-purple-600 to-purple-700  rounded-xl w-full">
        Clique aqui para criar um novo post
        </div>
        <!-- <div class="flex justify-end">
            <button type="button"
                class="mx-1 rounded-md bg-violet-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-violet-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-violet-600 relative">Incluir
                imagem
                <input type="file" class="absolute left-0 top-0 right-0 bottom-0 opacity-0" name="" id="">
            </button>
            <button @click="submit" type="submit"
                class="mx-1 rounded-md bg-purple-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-purple-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-purple-600">Postar</button>
        </div> -->
        <PostModal :post="newPost" v-model="showModal" />
    </div>
</template>

<style scoped>
    /* */
</style>