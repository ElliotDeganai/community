<template>
    <div class="text-white px-32 relative">
        <div :style="'background-image: url(/storage/home/carousel/carousel.png)'" class="bg-repeat w-full h-full absolute top-0 left-0 opacity-40"></div>
        <div class="pt-32 w-full h-full min-h-screen z-20">
            <div class="w-full py-24 z-20">
                <div class="uppercase text-4xl text-white w-full text-center z-20">News</div>
            </div>
            <div class="py-16 w-full z-20">
                <div class="py-8 w-full z-20" :key="section.id" v-for="section in sections">
                    <div class="py-4 flex flex-wrap w-full z-20">
                        <div class="py-8 px-32 w-full z-20" :key="post.id" v-for="post in section.category.posts">
                            <div class="py-4 w-full z-20">{{ post.name }}</div>
                            <div class="w-full z-20" :key="field.id" v-for="field in section.page_fields">
                                <div class=" py-8 z-20" v-if="$helpers.getFieldDocValueObject(field, post) !== ''">
                                    <div v-if="$helpers.getFieldDocValueObject(field, post).type == 'link'" class="w-full flex flex-wrap justify-center">
                                        <div class="h-72 w-full">
                                            <DocValue :getdoc="$helpers.getFieldDocValueObject(field, post)" />
                                        </div>
                                    </div>
                                    <div v-else class="w-full">
                                        <DocValue :getdoc="$helpers.getFieldDocValueObject(field, post)" />
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
        getnews: Array,
        getsection: Object,
    },
    data() {
        return{
            page: this.$page.props.pages.filter(page => page.title == 'News')[0],
            sections: this.$page.props.pages.filter(page => page.title == 'News')[0].page_sections

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
