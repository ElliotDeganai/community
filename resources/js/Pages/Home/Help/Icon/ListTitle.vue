<template>

<svg :class="classText" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
    <path d="M0 0l20 10L0 20V0zm0 8v4l10-2L0 8z"/>
</svg>

</template>
<script>
export default {
    props: ["getSize", "getColor"],
    data(){
        return{
            classText: 'w-'+this.getSize+' h-'+this.getSize+' '+this.getColor+' focus:outline-none'
        }
    }
}
</script>
