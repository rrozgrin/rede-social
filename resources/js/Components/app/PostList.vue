<script setup>
    import { ref } from 'vue';
    import PostItem from '@/Components/app/PostItem.vue';
    import PostModal from './PostModal.vue';

    defineProps({
        posts: Array
    })
    const showEditModal = ref(false)
    const editPost = ref({})

    function openEditModal(post) {
        editPost.value = post;
        showEditModal.value = true;
    }

</script>

<template>
    <div class="my-1 mx-1  container shadow-none">
        <div>
            <PostItem v-for="post of posts" :key="post.id" :post="post" @editClick="openEditModal"/>
            <PostModal :post="editPost" v-model="showEditModal" />
        </div>
    </div>

</template>

<style scoped></style>