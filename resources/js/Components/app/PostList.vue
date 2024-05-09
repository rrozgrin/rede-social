<script setup>
    import PostItem from './PostItem.vue';

    defineProps({
        posts: Array
    })

</script>

<template>
    <div  class="container mx-auto shadow-none">
        <div>
            <PostItem v-for="post of posts" :key="post.id" :post="post" />
        </div>
    </div>
</template>

<style scoped></style>