<template>
    <div class="bg-amber-50  h-screen">
        <div class="flex items-stretch h-full w-full relative">

            <div class="w-full h-full flex flex-wrap absolute top-0 left-0 overflow-hidden">
                <div class="w-1/4 hidden lg:inline" :key="i" v-for="i in 24">
                    <div class="w-full py-4 flex flex-wrap justify-center content-center items-stretch text-xs md:text-sm ">
                        <Palm :getSize="10" />
                    </div>
                </div>
                <div :class="[]" class="w-1/4 inline lg:hidden" :key="i" v-for="i in 48">
                    <div class="w-full py-1 lg:py-4 flex flex-wrap justify-center content-center items-stretch text-xs md:text-sm ">
                        <Palm :getSize="10" />
                    </div>
                </div>
            </div>
            <div class="flex items-stretch w-full h-full bg-amber-50 self-center">
                <div class="flex flex-wrap justify-center w-full h-full items-stretch">
                    <div class="h-70 w-70 bg-amber-50 loadering self-center">
                    </div>
                </div>
            </div>
            <div class="flex flex-wrap justify-center w-full h-full absolute my-auto">
                <div class="flex flex-wrap content-center items-stretch h-full">
                    <img alt="Logo chargement" class="object-contain w-24 self-center" :src="'/storage/home/ED_amber.png'" />
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Palm from '../../../Help/Icon/Palm.vue'
export default {
    components:{Palm}

}
</script>
<style>
.loadering {
  border: 16px solid #FEF3C7;
  border-radius: 50%;
  border-top: 16px solid #451A03;
  width: 240px;
  height: 240px;
  animation: loading 2s linear infinite;
}

@keyframes loading {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }

}

.circle-loading{
    top: 30%;
}


</style>
