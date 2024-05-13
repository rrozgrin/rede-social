<script setup>
import { ref } from 'vue';
import TextareaInput from '@/Components/TextareaInput.vue';
import { useForm } from '@inertiajs/vue3';


const newPostForm = useForm({
    body: '',
})

function submit(){
    newPostForm.post(route('post.create'), {
        onSuccess: () => {
            newPostForm.reset();
        }
    });
}

</script>

<template>
    <div class="py-6 bg-white rounded-lg p-3 mb-5">
        <TextareaInput @click="postCreating = true" class="w-full mb-3"  rows="1" v-model="newPostForm.body">  
        </TextareaInput>
        <div class="flex justify-end">
            <button type="button"
                class="mx-1 rounded-md bg-violet-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-violet-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-violet-600 relative">Incluir
                imagem
                <input type="file" class="absolute left-0 top-0 right-0 bottom-0 opacity-0" name="" id="">
            </button>
            <button @click="submit" type="submit"
                class="mx-1 rounded-md bg-purple-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-purple-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-purple-600">Postar</button>
        </div>
    </div>
</template>

<style scoped>
    /* */
</style>