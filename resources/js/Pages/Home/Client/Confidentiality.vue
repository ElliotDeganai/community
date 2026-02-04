<template>
    <div class="bg-gradient-to-r from-sky-100 via-white to-sky-100">
        <div class="container-px relative">
            <!-- <div :style="'background-image: url(/storage/home/carousel/carousel.png)'" class="bg-repeat bg-center w-full h-full absolute top-0 left-0 opacity-40"></div> -->
            <div class="container-py-login w-full h-full">
                <div class="w-full container-py z-10">
                    <div class="uppercase section-title w-full text-center z-20">{{page.title}}</div>
                </div>
                <div class="w-full" :key="field.id" v-for="(field) in section_legal.page_fields">
                    <div class="container-py-inside" v-if="$helpers.getFieldDocValueObject(field, legal) !== ''">
                        <div class="w-full">
                            <div class="container-py-inside" v-if="$helpers.getFieldDocValueObject(field, legal) !== ''">
                                <div class="w-full flex">
                                    <div class="container-px-inside border-t border-b w-full flex" v-if="field.name == 'Last update'">
                                        <div class="pr-4">Dernière mise à jour : </div>
                                        <div class="post-content font-bold">{{formatDateFr(getValueByFieldName('Last update', legal, section_legal))}}</div>
                                    </div>
                                    <div class="post-content" v-if="field.name == 'Content'">
                                        <div v-html="getValueByFieldName('Content', legal, section_legal)" class="post-content"></div>
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
import moment from 'moment';
export default {
    components:  {BreezeGuestLayout, DocValue},
    layout: BreezeGuestLayout,
    props: {
        getsection: Object,
    },
    data() {
        return{
            page: this.$page.props.pages.filter(page => page.title == 'Politique de confidentialité')[0],
            section_legal: this.$page.props.pages.filter(page => page.title == 'Politique de confidentialité')[0].page_sections[0],
            legal: this.$page.props.pages.filter(page => page.title == 'Politique de confidentialité')[0].page_sections[0].category.posts.filter(p => p.name == 'Politique de Confidentialité')[0]
        }
    },
    methods: {
        formatDateFr(date){
            return moment(date).format('DD-MM-YYYY');
        },
        getValueByFieldName(field_name, post, section) {
            return this.$helpers.getFieldDocValueObject(this.$helpers.getSectionField(section, field_name) , post).docValue;
        },
    },
    computed: {
    },
    created() {
    },
}
</script>
<style>

</style>
