<template>
    <div class="bg-white h-screen">
        <div class="flex items-stretch h-full w-full relative">
            <div class="flex items-stretch w-full h-full bg-white self-center">
                <div class="flex flex-wrap justify-center w-full h-full items-stretch">
                    <div class="h-70 w-70 bg-white loader self-center">
                    </div>
                </div>
            </div>
            <div class="flex flex-wrap justify-center w-full h-full absolute my-auto">
                <div class="flex flex-wrap content-center items-stretch h-full">
                    <img alt="Logo chargement" class="object-contain w-24 self-center" :src="'/storage/base/ED_2_Noir_Sans_fond_no_space.png'" />
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {

}
</script>
<style>
.loader {
  border: 16px solid #a0aec0;
  border-radius: 50%;
  border-top: 16px solid black;
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
