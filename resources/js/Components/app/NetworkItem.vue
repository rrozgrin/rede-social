<script setup>
defineProps({
    image: String,
    name: String,
});
</script>

<template>
    <div class="cursor-pointer hover:bg-violet-100 hover:bg-opacity-50">
        <div class="flex items-center gap-2 py-2 px-2">
            <img :src="image" class="w-[48px] rounded-full" />
            <div>
                <h3 class="font-black">{{ name }}</h3>
            </div>
        </div>
    </div>
</template>



<style>
</style>