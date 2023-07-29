<template>

<svg :class="classText" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
    <path d="M5 4h3v12H5V4zm7 0h3v12h-3V4z"/>
</svg>

</template>
<script>
export default {
    props: ["getSize", "getColor"],
    data(){
        return{
            classText: 'w-'+this.getSize+' h-full'+ ' '+this.getColor+' focus:outline-none'
        }
    }
}
</script>
