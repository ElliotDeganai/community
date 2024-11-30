<template>
  <div class="pt-32 w-full h-full min-h-screen  px-24 relative">
    <div class="w-full h-full absolute top-0 left-0">
        <div class="w-full h-full flex flex-wrap">
            <div class="w-1/4" :key="i" v-for="i in 24">
                <div class="w-full py-8 flex flex-wrap justify-center content-center items-stretch text-xs md:text-sm ">
                    <a class="self-center px-2" href="https://www.elliot-deganai.com/">
                        <img :src="'/storage/base/ED_2_Noir_Sans_fond_no_space.png'" class="object-contain h-6 md:h-16 " alt="" />
                    </a>
                </div>
            </div>
        </div>
        <div class="w-full h-full opacity-95 absolute top-0 left-0 bg-white"></div>
    </div>
    <H1 class="px-6 py-4 w-full font-bold text-5xl uppercase text-center relative">
        {{ title }}
    </H1>
    <div class="px-8 py-16 relative">{{ description }}</div>
  </div>
</template>

<script>
import Layout from '../Layouts/Default.vue';
export default {
  layout: Layout,
  props: {
    status: Number,
  },
  computed: {
    title() {
      return {
        503: '503: Service Unavailable',
        500: '500: Server Error',
        404: '404: Page Not Found',
        403: '403: Forbidden',
      }[this.status]
    },
    description() {
      return {
        503: 'Sorry, we are doing some maintenance. Please check back soon.',
        500: 'Whoops, something went wrong on our servers.',
        404: 'Sorry, the page you are looking for could not be found.',
        403: 'Sorry, you are forbidden from accessing this page.',
      }[this.status]
    },
  },
}
</script>
