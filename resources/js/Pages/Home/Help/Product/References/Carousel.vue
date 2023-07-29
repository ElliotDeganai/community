<template>
  <div class="relative overflow-hidden w-full">

  <slot/>

  <div class="text-white desc-top w-full h-full text-2xl md:text-2xl lg:text-2xl xl:text-4xl absolute font-bold text-center flex items-stretch">
  </div>
  <button class="carousel-next group" @click.prevent="next">
    <!-- <div class="bg-black opacity-50 w-8 h-8 md:w-12 md:h-12 lg:w-12 lg:h-12 xl:w-12 xl:h-12 absolute my-auto right-0 top-0 bottom-0 group-hover:bg-white"></div> -->
    <svg class="text-white top-0 absolute right-arrow right-0 w-8 h-8 md:w-12 md:h-12 lg:w-12 lg:h-12 xl:w-12 xl:h-12 bottom-0 my-auto group-hover:text-gray-700" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M12.95 10.707l.707-.707L8 4.343 6.586 5.757 10.828 10l-4.242 4.243L8 15.657l4.95-4.95z"/></svg>
  </button>
  <button class="carousel-prev group" @click.prevent="prev">
    <!-- <div class="bg-black opacity-50 w-8 h-8 md:w-12 md:h-12 lg:w-12 lg:h-12 xl:w-12 xl:h-12 absolute my-auto left-0 top-0 bottom-0 group-hover:bg-white"></div> -->
    <svg class="text-white top-0 absolute z-10 left-arrow left-0 w-8 h-8 md:w-12 md:h-12 lg:w-12 lg:h-12 xl:w-12 xl:h-12 bottom-0 my-auto group-hover:text-gray-700" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M7.05 9.293L6.343 10 12 15.657l1.414-1.414L9.172 10l4.242-4.243L12 4.343z"/></svg>
  </button>

  <div class="w-full flex flex-wrap justify-center absolute bottom-0 left-0">
    <div class="flex w-full flex flex-wrap justify-center  pt-4 relative overflow-hidden">
        <div @click.prevent="changeIndex(i-1)" :class="[i === index+1 ? 'bg-white' : '']" class="relative w-3 h-3 mx-2 cursor-pointer rounded-full border border-blue-100 navbar" :key="i" v-for="i in slides.length"></div>
    </div>
  </div>

  </div>
</template>

<script>
//import Down from '../Icon/DownDirection';
export default {
  components: {
  },
  props: [
    "getphotos",
  ],
  data() {
    return {
      photos: [
        {
          url: 'pic1.jpg'
        },
        {
          url: 'pic2.jpg'
        },
        {
          url: 'pic3.jpg'
        },
        {
          url: 'pic4.jpg'
        },
      ],
      index: 0,
      slides: [],
      slidesBands: [],
      slideDirection: null,
      count: 0,
      timeRangeSlider: 10,
      descriptionCarousel: { item: 'Marché du futur, des experts qui vous accompagnent dans votre conquête des marchés publics', index: 0},
      descriptionList: [
        { item: 'Marché du futur, des experts qui vous accompagnent dans votre conquête des marchés publics', index: 0},
        {item: 'Marché du futur, des experts qui vous accompagnent dans votre conquête des marchés publics', index: 1},
        {item: 'Marché du futur, des experts qui vous accompagnent dans votre conquête des marchés publics', index: 2}
      ],

      typingBar: {
        item: '|',
        visibility: true
      }
    };
  },
  methods: {
    changeIndex(i){
      if(i > this.index){
        this.slideDirection = 'right';
      }else{
        this.slideDirection = 'left';
      }
      this.index = i;
      this.count = 0;
    },
    next(){
      this.slideDirection = 'right';
      if(this.index >= this.slidesCount-1){
        this.index = 0;
        //this.descriptionCarousel = 0;
      }else{
        this.index++;
        //this.descriptionCarousel++;
      }
      this.count = 0;
      this.descriptionCarousel = this.descriptionList[this.index];
    },
    prev(){
      this.slideDirection = 'left';
      if(this.index <= 0){
        this.index = this.slidesCount-1;
        //this.descriptionCarousel = this.slidesCount-1;
      }else{
        this.index--;
        //this.descriptionCarousel--;

      }
      this.count = 0;
      this.descriptionCarousel = this.descriptionList[this.index];
    },
    startTimer() {
      let timer = setInterval(() => this.frame(timer), 1000);
    },
      frame(timer){
         if (this.count >= this.timeRangeSlider) {
          clearInterval(timer);
          this.next();
          this.startTimer();
        } else {
          this.count = this.count + 1;
        }
      },
    startTimerText() {
      let timer = setInterval(() => this.changeDescription(timer), 50);
    },
changeDescription(timer){
  let currentLenght = this.descriptionCarousel.item.length;
  if(currentLenght < this.descriptionList[this.index].item.length && this.descriptionCarousel.index === this.index){

    this.descriptionCarousel.item = this.descriptionCarousel.item + this.descriptionList[this.index].item[currentLenght];
  }else if (currentLenght >= this.descriptionList[this.index].item.length && this.descriptionCarousel.index === this.index){
    clearInterval(timer);
    this.startTimerText();
  }else if (this.descriptionCarousel.index !== this.index){
          clearInterval(timer);
          this.descriptionCarousel.index = this.index;
          this.descriptionCarousel.item = '';
          this.startTimerText();

  }
},
typingBarLight(){
  setInterval(() => this.typingBar.visibility = !this.typingBar.visibility, 500);
},
  },
  computed: {
    slidesCount(){
      return this.slides.length;
    }
  },
  mounted() {
    this.slides = this.$children;
    this.slides.forEach((slide, i) => {
      slide.index = i;
    });
     //this.startTimer();
/*    this.startTimerText();
    this.typingBarLight() */
  }
};
</script>
<style>
     .down-float{
        animation: downIn .5s ease-in-out alternate infinite;
    }

@keyframes downIn {
    from{ transform: translateY(-50%); }
    to{ transform: translateY(0); }
}

.desc-top{
  top: 0;
  bottom: 0;


}
</style>
