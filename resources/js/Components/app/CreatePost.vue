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
        <div @click="showCreatePostModal" class="py-2 flex justify-center items-center shadow-lg  text-purple-200  bg-gradient-to-t from-purple-600 to-purple-700 hover:bg-gradient-to-t hover:from-purple-700 hover:to-purple-600  rounded-xl w-full">
        Clique aqui para criar um novo post
        </div>
        <PostModal :post="newPost" v-model="showModal" />
    </div>
</template>

<style scoped>
    /* */
</style>