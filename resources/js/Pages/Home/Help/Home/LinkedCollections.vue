<template>
    <div class="w-full text-blue-900">
        <div class="w-full py-4 md:py-8 relative">
            <div v-if="propCollections.length > 4">
                <div class="relative overflow-hidden w-full h-64 lg:h-70 hidden md:block ">
                    <inertia-link :href="'/season/'+collection.article.id" :style="'left: '+collection.position+'%;'" class="w-1/3 md:w-1/4 collection lg:w-1/4 p-2 md:p-4 absolute top-0" :key="collection.index" v-for="collection in this.getlist">
                        <div class="p-2">
                            <div class="w-full relative overflow-hidden group navbar">
                                <img v-if="collection.article.media_id !== undefined && collection.article.media_id !== null" :src="collection.article.media_id.main_url" class="object-cover w-full  h-32 md:h-48 lg:56 transition duration-500 ease-in-out transform group-hover:scale-125" />
                                <img v-else :src="'/storage/default/collection.jpg'" class="object-cover w-full  h-32 md:h-48 lg:56 transition duration-500 ease-in-out transform group-hover:scale-125"/>
                            <!-- <img v-if="" class="w-full h-56 object-cover navbar" src="https://picsum.photos/200" /> -->
                                <div class="absolute group-hover:block hidden bg-blue-900 top-0 left-0 w-full  h-32 md:h-48 lg:56 opacity-50" />
                                <div class="absolute group-hover:flex hidden w-full h-full top-0 left-0 flex-wrap justify-center content-center">
                                    <div class="text-white font-bold">Voir le détail</div>
                                </div>
                            </div>
                        </div>
                        <div class="w-full text-center">{{collection.article.title}}</div>
                    </inertia-link>
                </div>
                <div class="relative overflow-hidden w-full h-56 block md:hidden ">
                    <inertia-link :href="'/season/'+collection.article.id" :style="'left: '+collection.positionM+'%;'" class="w-1/2 md:w-1/3 collection lg:w-1/4 p-2 md:p-4 absolute top-0" :key="collection.index" v-for="collection in this.getlist">
                        <div class="p-2">
                            <div class="w-full relative overflow-hidden group navbar">
                                <img v-if="collection.article.media_id !== undefined && collection.article.media_id !== null" :src="collection.article.media_id.main_url" class="object-cover w-full h-40 md:h-56 transition duration-500 ease-in-out transform group-hover:scale-125" />
                                <img v-else :src="'/storage/default/collection.jpg'" class="object-cover w-full h-40 md:h-56 transition duration-500 ease-in-out transform group-hover:scale-125"/>
                            <!-- <img v-if="" class="w-full h-56 object-cover navbar" src="https://picsum.photos/200" /> -->
                                <div class="absolute group-hover:block hidden bg-blue-900 top-0 left-0 w-full h-40 md:h-56 opacity-50" />
                                <div class="absolute group-hover:flex hidden w-full h-full top-0 left-0 flex-wrap justify-center content-center">
                                    <div class="text-white font-bold">Voir le détail</div>
                                </div>
                            </div>
                        </div>
                        <div class="w-full text-center">{{collection.article.title}}</div>
                    </inertia-link>
                </div>
            </div>
            <div v-else>
                <div class="relative overflow-hidden w-full h-64 lg:h-70 hidden md:flex flex-wrap justify-center">
                    <inertia-link :href="'/season/'+collection.id" class="w-1/3 md:w-1/4 lg:w-1/4 p-2 md:p-4" :key="collection.index" v-for="collection in this.propCollections">
                        <div class="p-2">
                            <div class="w-full relative overflow-hidden group navbar">
                                <img v-if="collection.media_id !== undefined && collection.media_id !== null" :src="collection.media_id.main_url" class="object-cover w-full  h-32 md:h-48 lg:56 transition duration-500 ease-in-out transform group-hover:scale-125" />
                                <img v-else :src="'/storage/default/collection.jpg'" class="object-cover w-full  h-32 md:h-48 lg:56 transition duration-500 ease-in-out transform group-hover:scale-125"/>
                            <!-- <img v-if="" class="w-full h-56 object-cover navbar" src="https://picsum.photos/200" /> -->
                                <div class="absolute group-hover:block hidden bg-blue-900 top-0 left-0 w-full  h-32 md:h-48 lg:56 opacity-50" />
                                <div class="absolute group-hover:flex hidden w-full h-full top-0 left-0 flex-wrap justify-center content-center">
                                    <div class="text-white font-bold">Voir le détail</div>
                                </div>
                            </div>
                        </div>
                        <div class="w-full text-center">{{collection.title}}</div>
                    </inertia-link>
                </div>
                <div class="relative overflow-hidden w-full h-56 flex flex-wrap justify-center md:hidden ">
                    <inertia-link :href="'/season/'+collection.id" class="w-1/2 md:w-1/3 lg:w-1/4 p-2 md:p-4" :key="collection.index" v-for="collection in this.propCollections">
                        <div class="p-2">
                            <div class="w-full relative overflow-hidden group navbar">
                                <img v-if="collection.media_id !== undefined && collection.media_id !== null" :src="collection.media_id.main_url" class="object-cover w-full h-40 md:h-56 transition duration-500 ease-in-out transform group-hover:scale-125" />
                                <img v-else :src="'/storage/default/collection.jpg'" class="object-cover w-full h-40 md:h-56 transition duration-500 ease-in-out transform group-hover:scale-125"/>
                            <!-- <img v-if="" class="w-full h-56 object-cover navbar" src="https://picsum.photos/200" /> -->
                                <div class="absolute group-hover:block hidden bg-blue-900 top-0 left-0 w-full h-40 md:h-56 opacity-50" />
                                <div class="absolute group-hover:flex hidden w-full h-full top-0 left-0 flex-wrap justify-center content-center">
                                    <div class="text-white font-bold">Voir le détail</div>
                                </div>
                            </div>
                        </div>
                        <div class="w-full text-center">{{collection.title}}</div>
                    </inertia-link>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ["getcollections"],
    data(){
        return{
            imgPath: "/storage/home/",
            propCollections: this.$inertia.page.props.favoriteSeasons,
            collections: [
            ],
            index: 0
        }
    },
    methods: {
        next(){
            if(this.index === 8){
                this.index = 0;
            }else{
                this.index++;
            }
        },
        prev(){
            if(this.index === 0){
                this.index = 8;
            }else{
                this.index--;
            }
        },
        isImgShown(index){
           return index-this.index < 4 && index-this.index >= 0;
        },
        startTimer() {
            let timer = setInterval(() => this.frame(timer), 4000);
        },
        frame(timer){
            //this.next();
            for(let i=0; i<this.collections.length; i++){
                if(this.collections[i].position < -25){
                    this.collections[i].position = 125;
                }else{
                    this.collections[i].position = this.collections[i].position - 25;
                }
                if(this.collections[i].positionM < -50){
                    this.collections[i].positionM = 300;
                }else{
                    this.collections[i].positionM = this.collections[i].positionM - 50;
                }
            }
        },
        updatePositionXL(){

        }
    },
    created(){
        //console.log(this.$inertia.page.props.favoriteSeasons);
    },
    mounted(){
        for(let i=0; i<this.propCollections.length; i++){
            let collection = 
                {
                    //url: this.propCollections[i].media_id.main_url,
                    index: i,
                    //title: this.propCollections[i].title,
                    article: this.propCollections[i],
                    position: i*25,
                    positionM: i*50
                }
            this.collections.push(collection);
        }
        this.startTimer();
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
                tempList[i].position = i*25;
            }
            return tempList;
        },
        getlist(){
            return this.collections.filter(collection => collection.position >= -25);
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
