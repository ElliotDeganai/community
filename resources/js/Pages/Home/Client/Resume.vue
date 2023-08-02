<template>
    <div class="relative">
        <div v-if="$page.props.auth.isDev || $page.props.auth.isAdmin || $page.props.auth.isEditor" class="pt-32 w-full h-full">
            <div class="w-full py-8 lg:py-24 z-10">
                <div class="title-home">Résumé</div>
            </div>
            <div>
                <div class="flex flex-wrap px-2 lg:px-32">
                    <div class="w-1/3">
                        <div class="font-bold text-green-700 text-base lg:text-xl">Viendront</div>
                        <div>
                            <div class="text-sm lg:text-base" :key="user.id" v-for="user in coming">
                                {{user.name}}
                            </div>
                        </div>
                    </div>
                    <div class="w-1/3">
                        <div class="font-bold text-gray-900 text-base lg:text-xl">N'ont pas répondu</div>
                        <div>
                            <div class="text-sm lg:text-base" :key="user.id" v-for="user in noAnswers">
                                {{user.name}}
                            </div>
                        </div>
                    </div>
                    <div class="w-1/3">
                        <div class="font-bold text-red-700 text-base lg:text-xl">Ne Viendront Pas</div>
                        <div>
                            <div class="text-sm lg:text-base" :key="user.id" v-for="user in notComing">
                                {{user.name}}
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
        getusers: Array,
        getsection: Object,
    },
    data() {
        return{
            //page: this.$page.props.pages.filter(page => page.title == 'Faq')[0],
            //  sections: this.$page.props.pages.filter(page => page.title == 'Faq')[0].page_sections
            allUsers: this.getusers
        }
    },
    methods: {
    },
    computed: {
        coming() { return this.allUsers.filter(u => u.is_partying && u.has_answered)},
        notComing() { return this.allUsers.filter(u => !u.is_partying && u.has_answered)},
        noAnswers() { return this.allUsers.filter(u => !u.has_answered)},
    },
    created() {
    },
}
</script>
<style>

</style>
