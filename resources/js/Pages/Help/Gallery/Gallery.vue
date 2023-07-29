<template>
    <div class="flex flex-wrap">
        <div class="w-1/4" :key="photo.id" v-for="photo in photos">
            <div class="p-4 w-32 h-32">
                <img class="object-contain w-full h-full" :src="photo.original_url" />
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props:  ['getphotos'] ,
    data() {
        return {
            photos: this.getphotos
        }
    },
}
</script>
