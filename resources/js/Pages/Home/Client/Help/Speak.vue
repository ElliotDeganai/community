<template>
    <div class="relative w-full">
        <div class="w-full py-24 z-10">
            <div class="uppercase text-4xl text-white w-full text-center z-20">They speak about us</div>
        </div>
        <div class="w-full overflow-hidden relative">
            <div :style="transformStyle" :class="['inner-move-next']" ref="inner" class="whitespace-nowrap">
                <div :style="'width:'+step+' px'" :class="[index === card+1 ? '' : '' ]" class="mr-10 relative h-48 inline-flex" v-for="(video, index) in videos" :key="video.id">
                    <div class="absolute top-0 left-0 p-8">
                        <div class="w-full h-full bg-black z-10"></div>
                        <div class="w-full text-center text-white font-bold z-20">{{video.name}}</div>
                    </div>
                    <iframe
                     :title="video.name" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen
                      class="w-full h-full object-cover" :src="$helpers.getDocValue(section, video, 'Link').docValue"></iframe>
                </div>
            </div>
        </div>
<!--         <button class="carousel-next group" @click.prevent="next()">
            <svg class="text-white top-0 absolute right-arrow right-0 w-8 h-8 md:w-12 md:h-12 lg:w-12 lg:h-12 xl:w-12 xl:h-12 bottom-0 my-auto group-hover:text-gray-400" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M12.95 10.707l.707-.707L8 4.343 6.586 5.757 10.828 10l-4.242 4.243L8 15.657l4.95-4.95z"/></svg>
        </button>
        <button class="carousel-prev group" @click.prevent="prev()">
            <svg class="text-white top-0 absolute z-10 left-arrow left-0 w-8 h-8 md:w-12 md:h-12 lg:w-12 lg:h-12 xl:w-12 xl:h-12 bottom-0 my-auto group-hover:text-gray-400" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M7.05 9.293L6.343 10 12 15.657l1.414-1.414L9.172 10l4.242-4.243L12 4.343z"/></svg>
        </button> -->
    </div>
</template>

<script>
export default {
    components: {},
    props: {
        getvideos: Array,
        //getcategories: Array,
        getsection: Object,
    },
  data () {
    return {
      cards: [],
      card: 0,
      step: null,
      movestep: null,
      innerWidth: null,
        videos: this.getsection.category.posts,
        section: this.getsection,
    }
  },
  methods:{
    getValue(docValue){
        return helpers.getValue(docValue);
    },
    next(){
        if (this.card === this.cards.length){
            this.card = 0;
        }else{
            this.card = this.card + 1;
        }
    },
    prev(){
        if (this.card === 0){
            this.card = this.cards.length;
        }else{
            this.card = this.card - 1;
        }
    },
    setStep () {
      const innerWidth = this.$refs.inner.scrollWidth // ❶
      const totalCards = this.cards.length
      this.step = innerWidth / totalCards // ❷
      this.movestep = this.step/2
      console.log(innerWidth)
    },
    setCard(){
/*         this.videos.forEach(v => {
            this.cards.push(v.id);
        }); */
        for (let index = 0; index < this.videos.length; index++) {
            const element = this.videos[index];
            this.cards.push(index);
        }
    }
  },
  computed:{
      transformStyle () {
          let self = this;
        let transform = '';
          switch (self.card) {
              case 1:
                  transform = 'transform: translateX(-'+self.step/2+'px)';
                  return transform;
                  //break;
              case 2:
                  transform = 'transform: translateX(-'+2*self.step/2+'px)';
                  return transform;
                  //break;
              case 3:
                  transform = 'transform: translateX(-'+3*self.step+'px)';
                  return transform;
                  //break;
              case 4:
                  transform = 'transform: translateX(-'+4*self.step+'px)';
                  return transform;
                  //break;
              case 5:
                  transform = 'transform: translateX(-'+5*self.step+'px)';
                  return transform;
                  //break;
              case 6:
                  transform = 'transform: translateX(-'+6*self.step+'px)';
                  return transform;
                  //break;
              case 7:
                  transform = 'transform: translateX(-'+7*self.step+'px)';
                  return transform;
                  //break;
              case 8:
                  transform = 'transform: translateX(-'+8*self.step+'px)';
                  return transform;
                  //break;

              default:
                  break;
          }
          return transform;
      },
       testvideos(){
        let videos = [];
        for (let index = 0; index < this.getsection.category.posts.length; index++) {
            const element = this.getsection.category.posts[index];
            videos.push(element);
        }
        for (let index = 0; index < this.getsection.category.posts.length; index++) {
            const element = this.getsection.category.posts[index];
            videos.push(element);
        }
        return videos;
      }
  },

  mounted () {
    this.setCard();
    this.setStep();
  },
}
</script>

<style>

.inner-move-next {
    /*transform: translateX(-50px);*/
    transition: transform 0.2s; /* ❹ */
}

/* optional */
button {
  margin-right: 5px;
  margin-top: 10px;
}


.change-height{
    transition: height .5s;
}
</style>
