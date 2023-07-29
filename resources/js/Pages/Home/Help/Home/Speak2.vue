<template>
    <div class="w-full text-white relative">
        <div class="w-full h-full bg-white opacity-10 absolute top-0"></div>
        <div class="w-full pt-24">
            <div class="uppercase text-4xl text-white w-full text-center">They speak about us</div>
        </div>
        <div class="w-full py-8 md:py-24 relative  px-32">
            <div>
                <test :getsection="section" :getvideos="videos" :getshownitems="4" class="h-56" />
            </div>
        </div>
    </div>
</template>
<script>
import Youtube from '../Icon/Youtube.vue'
import Test from './Test.vue'
export default {
    components: {
        Youtube, Test
    },
    props: {
        linkList: Array,
        getvideos: Array,
        getsection: Object,
    },
    data() {
        return{
            imgPath: "/storage/home/",
            collections: [
            ],
            index: 0,
            videos: this.getvideos.data,
            section: this.getsection
        }
    },
    methods: {
        test(){
            for(let i=0; i<this.collections.length; i++){
                if(this.collections[i].index >= 5){
                    this.collections[i].index = 1;
                }else if(this.collections[i].index <= 1){
                    this.collections[i].index = this.collections[i].index+1;
                }else{
                    this.collections[i].index = this.collections[i].index+1;
                }
            }
        },
        next(){
            for(let i=0; i<this.collections.length; i++){
                if(this.collections[i].index >= 5){
                    this.collections[i].index = 1;
                }else if(this.collections[i].index <= 1){
                    this.collections[i].index = this.collections[i].index+1;
                }else{
                    this.collections[i].index = this.collections[i].index+1;
                }
            }
        },
        prev(){
            for(let i=0; i<this.collections.length; i++){
                if(this.collections[i].index >= 5){
                    this.collections[i].index = this.collections[i].index-1;
                }else if(this.collections[i].index <= 1){
                    this.collections[i].index = 5;
                }else{
                    this.collections[i].index = this.collections[i].index-1;
                }
            }
        },
        isImgShown(index){
           return index-this.index < 4 && index-this.index >= 0;
        },
        startTimer() {
            //let timer = setInterval(() => this.frame(timer), 4000);
        },
        frame(){
            for(let i=0; i<this.collections.length; i++){
                if(this.collections[i].position < -20){
                    this.collections[i].position = 100;
                }else{
                    this.collections[i].position = this.collections[i].position - 20;
                }
                if(this.collections[i].positionM < -50){
                    this.collections[i].positionM = 300;
                }else{
                    this.collections[i].positionM = this.collections[i].positionM - 50;
                }
            }
        },
        updatePositionXL(){
        },
        getImageScale(id){
            let scale = '';
            switch (id) {
                case 1:
                    scale = 'h-32 w-1/8';
                    break;
                case 2:
                    scale = 'h-48 w-1/5 z-10';
                    break;
                case 3:
                    scale = 'h-64 w-1/4 z-20';
                    break;
                case 4:
                    scale = 'h-48 w-1/5 z-10';
                    break;
                case 5:
                    scale = 'h-32 w-1/8';
                    break;

                default:
                    break;
            }
            return scale;
        },
    },
    created(){
    },
    mounted(){
        for(let i=0; i<this.videos.length; i++){
            let collection =
                {
                    index: i+1,
                    article: this.videos[i],
                }
            this.collections.push(collection);
        }
        //this.startTimer();
    },
    computed: {
        getImages(){
            let self = this;
            let tempList = this.collections.filter(collection => self.isImgShown(collection.index));
            if(tempList.length < 4){
                switch (tempList.length) {
                    case 3:
                        tempList.push(this.collections[0]);
                        break;
                    case 2:
                        tempList.push(this.collections[0]);
                        tempList.push(this.collections[1]);
                        break;
                    case 1:
                        tempList.push(this.collections[0]);
                        tempList.push(this.collections[1]);
                        tempList.push(this.collections[2]);
                        break;

                    default:
                        break;
                }
            }
            for(let i=0; i<tempList.length; i++){
                tempList[i].position = i*20;
            }
            return tempList;
        },
        getlist(){
            return this.collections.filter(collection => collection.position >= -20);
            //return this.collections;
        },
        getVideosStyles(){
            return this.collections.filter(collection => collection.position >= -20);
            //return this.collections;
        }
        }

}
</script>
<style>

    .fade-enter-active{
        animation: fadeIn 4s linear;
    }

    .fade-leave-active{
        animation: fadeOut 4s linear;
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        /* width: 100%; */
    }
    .change-height{
        transition: height 4s;
    }
    .video1{
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-350%,-50%);
    transition: transform 1s ease-in-out;
    }
    .video2{
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-160%,-50%);
    transition: 1s ease-in-out;
    }
    .video3{
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%,-50%);
    transition: 1s ease-in-out;
        /* width: 100%; */
    }
    .video4{
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(60%,-50%);
    }
    .video5{
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(250%,-50%);
    }

     @keyframes fadeIn{
        from{ transform: translateX(100%); }
        to{ transform: translateX(0); }
    }

    @keyframes fadeOut{
        from{ transform: translateX(0); }
        to{ transform: translateX(-100%); }
    }

.collection {
  transition: left 4s;
}
</style>
