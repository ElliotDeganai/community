<template>
    <div class="relative w-full">
        <div class="flex flex-wrap justify-center w-full relative overflow-hidden h-full">
            <iframe :style="'left:'+index*item_length+'%'" :class="'w-1/'+shown_items" :key="index" v-for="(video, index) in this.videos" class="h-full px-4 absolute object-cover"
                :src="$helpers.getDocValue(section, video, 'Video URL')"
                title="Youtube Video" frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen>
            </iframe>
        </div>
        <button class="carousel-next group" @click.prevent="next()">
            <svg class="text-white top-0 absolute right-arrow -right-12 w-8 h-8 md:w-12 md:h-12 lg:w-12 lg:h-12 xl:w-12 xl:h-12 bottom-0 my-auto group-hover:text-gray-400" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M12.95 10.707l.707-.707L8 4.343 6.586 5.757 10.828 10l-4.242 4.243L8 15.657l4.95-4.95z"/></svg>
        </button>
        <button class="carousel-prev group" @click.prevent="prev()">
            <svg class="text-white top-0 absolute z-10 left-arrow -left-12 w-8 h-8 md:w-12 md:h-12 lg:w-12 lg:h-12 xl:w-12 xl:h-12 bottom-0 my-auto group-hover:text-gray-400" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M7.05 9.293L6.343 10 12 15.657l1.414-1.414L9.172 10l4.242-4.243L12 4.343z"/></svg>
        </button>
    </div>
</template>

<script>

export default {
  name: "App",
  components: {
  },
  props: {
    getshownitems: Number,
    getvideos: Array,
    getsection: Object
  },
  data() {
    return {
    current: 0,
    shown_items: this.getshownitems,
    item_length: 100/this.getshownitems,
    videos: this.getvideos,
    section: this.getsection
    };
  },
  methods: {
        next(){
            let video1 = this.videos[this.videos.length-1];
            this.videos.unshift(video1);
            this.videos.pop();
        },
        prev(){
            let video1 = this.videos[0];
            this.videos.push(video1);
            this.videos.shift();
        },
  }
};
</script>

<style>
</style>
