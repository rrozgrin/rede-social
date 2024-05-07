<script setup>
defineProps({
    image: String,
    title: String,
    description: String,
});
</script>

<template>
    <div
        class="cursor-pointer hover:bg-violet-100 hover:bg-opacity-50">
        <div class="flex items-start gap-3 py-2 px-2">
            <img :src="image" class="w-[48px] rounded-full" />
            <div>
                <h3 class="font-bold text-lg">{{ title }}</h3>
                <div class="text-xs text-gray-500">
                    {{ description }}
                </div>
            </div>
        </div>
    </div>
</template>



<style>
</style>