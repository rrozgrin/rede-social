<script setup>
    import PostItem from './PostItem.vue';
    const post1 = {
        user: {
            id: 1,
            avatar: 'https://randomuser.me/api/portraits/women/13.jpg',
            name: 'Amanda Fagundes',
        },
        group: null,
        attachments: [
            {
                id: 1,
                url: 'https://picsum.photos/1000',
                mime: 'image/jpg'
            },
            {
                id: 2,
                url: 'https://picsum.photos/1000',
                mime: 'image/jpg'
            }
        ],
        body: `<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam accumsan sem et pharetra imperdiet. Integer auctor libero vel accumsan egestas. Fusce consequat ultrices quam, sit amet pellentesque metus dignissim placerat. Etiam aliquam eget massa nec ultricies. Nunc justo metus, mollis rhoncus metus ac, placerat maximus ligula. 
        </p>`,
        created_at: '2024-04-02 15:22',
    }
    const post2 = {
        user: {
            id: 1,
            avatar: 'https://randomuser.me/api/portraits/men/13.jpg',
            name: 'Thiago de Assis',
        },
        group: {
            id: 1,
            name: 'Grupo 1',
        },
        body: `<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam accumsan sem et pharetra imperdiet. Integer auctor libero vel accumsan egestas. Fusce consequat ultrices quam, sit amet pellentesque metus dignissim placerat. Etiam aliquam eget massa nec ultricies. Nunc justo metus, mollis rhoncus metus ac, placerat maximus ligula. 
        </p>`,
        created_at: '2024-04-10 22:22',
    }
</script>

<template>
    <div  class="container mx-auto shadow-none">
        <div>
            <PostItem :post="post1" />
            <PostItem :post="post2" />
        </div>
    </div>
</template>

<style scoped></style>