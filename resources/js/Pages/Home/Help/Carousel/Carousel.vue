<template>
  <div class="relative overflow-hidden w-full flex flex-wrap">
    <div :style="'background-image: url(/storage/home/carousel/carousel.png)'" class="bg-repeat bg-center w-full h-full absolute top-0 left-0 opacity-40"></div>
    <div class="w-1/3 z-10 relative h-full group">
        <div class="w-full h-full absolute top-0 left-0  flex flex-wrap justify-center content-center ">
            <div class="h-68 group-hover:h-70 group-hover:w-70 cursor-pointer opacity-10 transition duration-500 ease-in-out transform group-hover:scale-125 w-68 rounded-full bg-white">
            </div>
        </div>
        <div class="w-full h-full absolute top-0 left-0  flex flex-wrap justify-center content-center ">
            <div class="h-66 cursor-pointer opacity-25 transition duration-500 ease-in-out transform group-hover:scale-125 w-66 rounded-full bg-white">
            </div>
        </div>
        <div class="w-full h-full absolute top-0 left-0  flex flex-wrap justify-center content-center ">
            <div class="h-64 cursor-pointer  transition duration-500 ease-in-out  w-64 rounded-full bg-white  flex flex-wrap justify-center content-center ">
                <div class="text-purple-600 w-full uppercase text-center font-bold text-4xl">Watch the trailer</div>
            </div>
        </div>
    </div>
    <!-- <slot class="w-2/3 h-full"/> -->
    <div v-if="product != null" class="w-2/3 z-10 h-full flex flex-wrap relative">
      <transition-group :name="transition" class="w-full h-full flex flex-wrap">
        <div v-show="productId === product.id" :key="product.id" v-for="product in this.products" class="w-full h-full flex flex-wrap">
          <div class="w-1/2 flex flex-wrap justify-center content-center">
              <img class="h-76 object-cover floating" :src="$helpers.getImageUrl(product)" />
          </div>
          <div class="w-1/2 pr-8 flex flex-wrap content-center">
              <div class="w-full text-5xl font-bold text-white">{{product.name}}</div>
              <div class="w-full text-base text-white py-8 pr-8">{{product.body}}</div>
              <div class="w-full flex flex-wrap">
                  <div class="bg-green-400 text-white cursor-pointer font-bold px-6 py-2 text-base rounded-full">Buy it !</div>
              </div>
          </div>
        </div>
      </transition-group>
    </div>

    <button class="carousel-next group z-20" @click.prevent="next">
      <svg class="text-white top-0 absolute right-arrow right-0 w-8 h-8 md:w-12 md:h-12 lg:w-12 lg:h-12 xl:w-12 xl:h-12 bottom-0 my-auto group-hover:text-gray-700" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M12.95 10.707l.707-.707L8 4.343 6.586 5.757 10.828 10l-4.242 4.243L8 15.657l4.95-4.95z"/></svg>
    </button>

    <button class="carousel-prev group z-20" @click.prevent="prev">
      <svg class="text-white top-0 absolute z-10 left-arrow left-0 w-8 h-8 md:w-12 md:h-12 lg:w-12 lg:h-12 xl:w-12 xl:h-12 bottom-0 my-auto group-hover:text-gray-700" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M7.05 9.293L6.343 10 12 15.657l1.414-1.414L9.172 10l4.242-4.243L12 4.343z"/></svg>
    </button>

    <div class="w-full flex flex-wrap justify-center absolute bottom-0 left-0 z-20">
      <div class="flex w-full flex-wrap justify-center  pb-12 relative overflow-hidden">
          <div @click.prevent="changeIndex(i-1)" :class="[i === index+1 ? 'bg-white' : '']" class="relative w-4 h-4 mx-4 cursor-pointer rounded-full border border-blue-100 navbar" :key="i" v-for="i in products.length"></div>
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
    "getcountry",
    "getphotos",
    "getproducts",
    "getsection",
  ],
  data() {
    return {
      products: this.getsection.category.posts,
      section: this.getsection,
      countries: this.getcountries,
      country: this.getcountry,
      photos: this.getphotos,
      index: 0,
      slides: [],
      slidesBands: [],
      slideDirection: null,
      count: 0,
      timeRangeSlider: 10,
      descriptionCarousel: { item: '', index: 0},
/*       descriptionList: [
        { item: 'Elliot Deganai', index: 0},
        {item: 'Développeur informatique indépendant', index: 1},
        {item: 'Création de sites et applications web', index: 2},
        {item: 'Des services sur mesures et 100% personnalisés', index: 3}
      ], */
      typingBar: {
        item: '|',
        visibility: true
      }
    };
  },
  methods: {
/*     setProducts() {
        return this.$woocommerce_api.getAsync("products?per_page=6").then(result => {
            //console.log("product", JSON.parse(result.toJSON().body));
            this.products = JSON.parse(result.toJSON().body);
            return JSON.parse(result.toJSON().body);
        });
    }, */
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
      if(this.index >= this.products.length-1){
        this.index = 0;
        //this.descriptionCarousel = 0;
      }else{
        this.index++;
        //this.descriptionCarousel++;
      }
      this.count = 0;
    },
    prev(){
      this.slideDirection = 'left';
      if(this.index <= 0){
        this.index = this.products.length-1;
        //this.descriptionCarousel = this.slidesCount-1;
      }else{
        this.index--;
        //this.descriptionCarousel--;

      }
      this.count = 0;
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
    },
    descriptionList: function() {
      return [
        {item: 'ML Fiduciaire Sàrl', index: 0},
        {item: 'Efficacité et compétitivité', index: 1},
        {item: 'Comptabilité, fiscalité et ressources humaines', index: 2},
        //{item: this.$t('carousel.slide_3'), index: 3}
      ]
    },
    product(){
      return this.products[this.index];
    },
    productId(){
      return this.products[this.index].id;
    },
    transition(){
        return 'slide-'+this.slideDirection;
    }
  },
  watch: {
  },
/*   mounted() {
    this.slides = this.$children;
    this.slides.forEach((slide, i) => {
      slide.index = i;
    });
  } */

    mounted() {
    },
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

    @keyframes floating{
        from{ transform: scale(90%); }
        to{ transform: scale(115%); }
    }
    @keyframes fading-color{
        from{ opacity: 1; }
        to{ opacity: 0.25; }
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
        width: 100%;
    }


    .disc-center{
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%,-50%);
    transition: 1s ease-in-out;
        /* width: 100%; */
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
