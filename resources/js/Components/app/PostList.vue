<script setup>
    import { ref } from 'vue';
    import PostItem from '@/Components/app/PostItem.vue';
    import PostModal from './PostModal.vue';
    import AttachmentPreviewModal from '@/Components/app/AttachmentPreviewModal.vue';

    defineProps({
        posts: Array,
    });
    
    const showEditModal = ref(false);
    const showAttachmentsModal = ref(false);
    const editPost = ref({});
    const previewAttachmentPost = ref({});

    function openEditModal(post) {
        editPost.value = post;
        showEditModal.value = true;
    }

    function onModalHide(){
        editPost.value = {};
    }

    function openAttachmentModal(post, index){
        previewAttachmentPost.value = {
            post,
            index
        };
        showAttachmentsModal.value = true;
    }

</script>

<template>
    <div class="my-1 mx-1  container shadow-none">
        <div>
            <PostItem v-for="post of posts" :key="post.id" :post="post" 
            @editClick="openEditModal"
            @attachmentClick="openAttachmentModal"/>
            <PostModal :post="editPost" v-model="showEditModal" @hide="onModalHide" />
            <AttachmentPreviewModal :attachments="previewAttachmentPost.post?.attachments || []"
                                    v-model:index="previewAttachmentPost.index"
                                    v-model="showAttachmentsModal" />
        </div>
    </div>

</template>

<style scoped></style>