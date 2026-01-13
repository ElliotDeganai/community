<template>
    <div class="relative">
        <div class="w-full h-full">
            <div class="">
                <div>
                    <div>
                        <div class="relative h-screen flex flex-wrap justify-center content-center">
                            <img v-if="$helpers.getObjectImage(page)" class="w-full h-full object-cover" :src="$helpers.getObjectImage(page)" />
                            <div v-if="$helpers.getObjectImage(page)" class="w-full h-full absolute top-0 left-0 bg-black opacity-50"></div>
                            <div v-if="page.header_title || page.header_subtitle" class="w-full h-full absolute top-0 left-0 flex flex-wrap justify-center content-center">
                                <div v-if="page.header_title" class="text-white font-bold text-6xl w-full text-center">{{page.header_title}}</div>
                                <div v-if="page.header_subtitle" class="text-white font-bold text-xl">{{page.header_subtitle}}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="py-8 px-24 w-full">
                <div class="py-4 flex flex-wrap justify-center w-full">
                    <div class="p-8 w-1/3 flex flex-wrap justify-center cursor-pointer" @click.prevent="selectMaintenance(maintenance)" :key="maintenance.id" v-for="maintenance in maintenances">
                        <div class="px-8 py-4 text-green-700 font-bold text-2xl" :class="[selected_maintenance.id == maintenance.id ? 'rounded-md bg-green-700 text-white shadow-lg' : '']">{{ maintenance.name }}
<!--                             <div class="w-full" :key="field.id" v-for="(field, index) in section.page_fields">
                                <div class=" py-8" v-if="$helpers.getFieldDocValueObject(field, post) !== ''">
                                    <div class="w-full">
                                        <DocValue :class="[index == 0 ? 'font-bold text-xl' : '']" :getdoc="$helpers.getFieldDocValueObject(field, post)" />
                                    </div>
                                </div>
                            </div> -->
                        </div>
                    </div>
                    <div>
                        <div>
                            <div class="w-full" :key="field.id" v-for="(field, index) in section_maintenance.page_fields">
                                <div class=" py-8" v-if="$helpers.getFieldDocValueObject(field, selected_maintenance_display) !== ''">
                                    <div class="w-full">
                                        <DocValue :imgSize="{height: 64, width: 'full'}" :class="[index == 0 ? '' : '']" :getdoc="$helpers.getFieldDocValueObject(field, selected_maintenance_display)" />
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
import DocValue from '../Help/DocumentationValue.vue'
export default {
    components:  {BreezeGuestLayout, DocValue},
    layout: BreezeGuestLayout,
    props: {
        //getfaqs: Array,
        //getsection: Object,
    },
    data() {
        return{
            page: this.$page.props.pages.filter(page => page.title == 'Maintenance')[0],
            sections: this.$page.props.pages.filter(page => page.title == 'Maintenance')[0].page_sections,
            section_maintenance: this.$page.props.pages.filter(page => page.title == 'Maintenance')[0].page_sections.filter(section => section.name == 'Maintenance')[0],
            maintenances: this.$page.props.pages.filter(page => page.title == 'Maintenance')[0].page_sections[0].category.posts,
            selected_maintenance: this.$page.props.pages.filter(page => page.title == 'Maintenance')[0].page_sections[0].category.posts[0]
        }
    },
    methods: {
        selectMaintenance(maintenance) {
            this.selected_maintenance = maintenance;
        }
    },
    computed: {
        selected_maintenance_display(){
            return this.selected_maintenance;
        }
    },
    created() {
    },
}
</script>
<style>

</style>
