<script setup>
    import { Head, Link } from '@inertiajs/vue3';
    import GroupList from '@/Components/app/GroupList.vue';
    import NetworkList from '@/Components/app/NetworkList.vue';
    import CreatePost from '@/Components/app/CreatePost.vue';
    import PostList from '@/Components/app/PostList.vue';
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    defineProps({
    });
</script>

<template>

    <Head title="Rede Social" />
    <AuthenticatedLayout>
        <div class="grid lg:grid-cols-12 mx-4 gap-3 max-sm:gap-0 h-full">
            <div class="lg:col-span-3 lg:order-1 h-full">
                <GroupList />
            </div>
            <div class="lg:col-span-3 lg:order-3 h-full">
                <NetworkList />
            </div>
            <div class="lg:col-span-6 lg:order-2 h-full">
                <CreatePost />
                <PostList />
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style></style>