<template>

    <svg :class="classText" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
        <path d="M0 11l2-2 5 5L18 3l2 2L7 18z"/>
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
