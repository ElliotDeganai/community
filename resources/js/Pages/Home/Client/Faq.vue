<template>
    <div class="text-white px-24 relative">
        <div :style="'background-image: url(/storage/home/carousel/carousel.png)'" class="bg-repeat bg-center w-full h-full absolute top-0 left-0 opacity-40"></div>
        <div class="pt-32 w-full h-full">
            <div class="w-full py-24 z-10">
                <div class="uppercase text-4xl text-white w-full text-center z-20">Faq</div>
            </div>
            <div class="py-8 w-full" :key="section.id" v-for="section in sections">
                <div class="py-4 flex flex-wrap w-full">
                    <div class="p-8 w-1/3 flex flex-wrap" :key="post.id" v-for="post in section.category.posts">
                        <div class="p-8 border border-white rounded-lg">
                            <div class="w-full" :key="field.id" v-for="(field, index) in section.page_fields">
                                <div class=" py-8" v-if="$helpers.getFieldDocValueObject(field, post) !== ''">
                                    <div class="w-full">
                                        <DocValue :class="[index == 0 ? 'font-bold text-xl' : '']" :getdoc="$helpers.getFieldDocValueObject(field, post)" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import BreezeGuestLayout from '@/Layouts/Guest.vue';
import helpers from '../../../helpers'
import DocValue from './../Help/DocumentationValue.vue'
export default {
    components:  {BreezeGuestLayout, DocValue},
    layout: BreezeGuestLayout,
    props: {
        getfaqs: Array,
        getsection: Object,
    },
    data() {
        return{
            page: this.$page.props.pages.filter(page => page.title == 'Faq')[0],
            sections: this.$page.props.pages.filter(page => page.title == 'Faq')[0].page_sections

        }
    },
    methods: {
    },
    computed: {
    },
    created() {
    },
}
</script>
<style>

</style>
