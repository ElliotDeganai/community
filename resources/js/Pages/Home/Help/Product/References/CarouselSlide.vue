<template>
<transition :name="transition">
  <div v-show="visible" class="w-full h-full flex flex-wrap">
        <div class="w-full h-full flex flex-wrap content-center">
            <a class="w-full h-full" :href="reference.link">
                <div class="w-full h-full flex flex-wrap justify-center relative overflow-hidden">
                    <div class="w-full h-full absolute top-0 left-0">
                        <div class="relative w-full h-full flex flex-wrap justify-center content-center"><Youtube getColor="text-white" getSize="6"/></div>
                    </div>
                    <img class="w-1/2 h-full navbar object-cover border border-gray-200" :src="reference.url" />
                </div>
            </a>
        </div>
  </div>
</transition>
</template>

<script>
import Youtube from '../../Icon/Youtube.vue'
export default {
    props: ['getUrlPhoto', 'getreference'],
    components: {Youtube},
    data(){
        return{
            index: 0,
            urlPhoto: this.getUrlPhoto,
            reference: this.getreference
        }
    },
    computed: {
        visible(){
            return this.index === this.$parent.index;
        },
        transition(){
            return 'slide-'+this.$parent.slideDirection;
        }
    }
};
</script>
<style>
    .zooming{
        animation: zooming 20s linear;
    }
    .slide-right-enter-active{
        animation: slideRightIn 2s ease-in;
    }

    .slide-right-leave-active{
        animation: slideRightOut 2s ease-in;
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        padding: 2rem/* 32px */;
        width: 100%;
    }

     @keyframes slideRightIn{
        from{ opacity: 0; }
        to{ opacity: 1; }
    }

    @keyframes zooming{
        from {
            transform: scale(1);
        }
        to {
            transform: scale(2);
        }
    }

    @keyframes slideRightOut{
        from{ opacity: 1; }
        to{ opacity: 0; }
    } 

    .slide-left-enter-active{
        animation: slideLeftIn 2s ease-in;
    }
    .center-div{
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
    }

    .slide-left-leave-active{
        animation: slideLeftOut 2s ease-in;
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        padding: 2rem/* 32px */;
        width: 100%;
    }

     @keyframes slideLeftIn{
        from{ opacity: 0; }
        to{ opacity: 1; }
    }

    @keyframes slideLeftOut{
        from{ opacity: 1; }
        to{ opacity: 0; }
    } 
</style>
