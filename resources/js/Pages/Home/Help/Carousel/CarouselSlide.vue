<template>
<transition :name="transition">
  <div v-show="visible" class="bg-gray-900 w-full h-full">
        <div class="w-1/2 flex flex-wrap justify-center content-center">
            <img class="h-76 object-cover floating" :src="product.images[0].src" />
        </div>
        <div class="w-1/2 h-1/2 px-2 flex flex-wrap content-center">
            <div class="w-full text-5xl text-white">{{product.name}}</div>
            <div v-html="product.description" class="w-full text-lg h-full truncate text-white py-8"></div>
            <div class="w-full flex flex-wrap">
                <div class="bg-green-400 text-white cursor-pointer font-bold px-6 py-2 text-lg rounded-full">Get it free</div>
            </div>
        </div>
  </div>
</transition>
</template>

<script>
export default {
    props: ['getproduct'],
    data(){
        return{
            index: 0,
            product: this.getproduct
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
        /* width: 100%; */
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

    .slide-left-leave-active{
        animation: slideLeftOut 2s ease-in;
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
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
