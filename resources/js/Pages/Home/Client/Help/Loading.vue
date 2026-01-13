<template>
    <div class="h-screen">
        <div class="flex items-stretch h-full w-full relative">

            <div class="w-full h-full flex flex-wrap absolute top-0 left-0 overflow-hidden">
                <div class="w-1/4 hidden lg:inline" :key="i" v-for="i in 24">
                    <div class="w-full p-8 flex flex-wrap justify-center content-center items-stretch text-xs md:text-sm  opacity-10">
                        <img :src="'/storage/base/ED_2_Noir_Sans_fond_no_space.png'" class="object-contain h-full" alt="" />
                    </div>
                </div>
                <div :class="[]" class="w-1/4 inline lg:hidden" :key="i" v-for="i in 48">
                    <div class="w-full py-1 lg:p-8 flex flex-wrap justify-center content-center items-stretch text-xs md:text-sm  opacity-10">
                        <img :src="'/storage/base/ED_2_Noir_Sans_fond_no_space.png'" class="object-contain h-full" alt="" />
                    </div>
                </div>
            </div>
            <div class="flex items-stretch w-full h-full bg-sky-900 self-center">
                <div class="flex flex-wrap justify-center w-full h-full items-stretch">
                    <div class="h-70 w-70 bg-sky-900  loadering self-center">
                    </div>
                </div>
            </div>
            <div class="flex flex-wrap justify-center w-full h-full absolute my-auto">
                <div class="flex flex-wrap content-center items-stretch h-full">
                    <img alt="Logo chargement" class="object-contain w-24 self-center" :src="'/storage/base/ED 2 Blanc Sans fond.png'" />
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Palm from '../../../Help/Icon/Palm.vue'
import Gift from '../../../Help/Icon/Gift.vue'
export default {
    components:{Palm, Gift}

}
</script>
<style>
.loadering {
  border: 16px solid rgb(247, 247, 247);
  border-radius: 50%;
  border-top: 16px solid rgb(62, 101, 124);
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
