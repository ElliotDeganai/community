<template>
    <div class="relative">
        <div v-if="$page.props.auth.isDev || $page.props.auth.isAdmin || $page.props.auth.isEditor" class="pt-32 w-full h-full">
            <div class="w-full py-8 lg:py-24 z-10">
                <div class="title-home">Résumé</div>
            </div>
            <div>
                <div class="flex flex-wrap px-2 lg:px-32">
                    <div class="w-1/3 relative">
                        <div class="font-bold py-2 px-1 text-white bg-green-700 text-base lg:text-xl w-full text-center truncate">Viendront</div>
                        <div class="px-2 lg:px-8 absolute top-0 right-0 py-2">
                            <Couple class="text-white" :getSize="4" />
                        </div>
                    </div>
                    <div class="w-1/3">
                        <div class="font-bold py-2 px-1 text-white bg-gray-900 text-base lg:text-xl w-full text-center truncate">N'ont pas répondu</div>
                        <div>
                        </div>
                    </div>
                    <div class="w-1/3">
                        <div class="font-bold py-2 px-1 text-white bg-red-700 text-base lg:text-xl w-full text-center truncate">Ne Viendront Pas</div>
                        <div>
                        </div>
                    </div>
                </div>
                <div class="flex flex-wrap px-2 lg:px-32">
                    <div class="w-1/3 px-2">
                        <div class="relative">
                            <div class="text-sm lg:text-base relative w-full text-center py-2" :key="user.id" v-for="user in coming">
                                {{user.name}}
                                <div class="px-1 lg:px-8 absolute top-0 right-0 py-2">
                                    <span v-if="user.has_company && user.is_accompanied" class="text-green-700 font-bold" >
                                        <Couple class="" :getSize="4" />
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="w-1/3 px-2">
                        <div>
                            <div class="text-sm lg:text-base w-full text-center py-2" :key="user.id" v-for="user in noAnswers">
                                {{user.name}}
                            </div>
                        </div>
                    </div>
                    <div class="w-1/3 px-2">
                        <div>
                            <div class="text-sm lg:text-base w-full text-center py-2" :key="user.id" v-for="user in notComing">
                                {{user.name}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="py-4 lg:py-8">
                    <div class="w-full py-8 lg:py-24 z-10">
                        <div class="title-home">Teams</div>
                    </div>
                    <div class="flex flex-wrap px-2 lg:px-32">
                        <div class="w-1/3 relative">
                            <div class="font-bold py-2 px-1 text-white bg-green-700 text-base lg:text-xl w-full text-center truncate">Team Paris</div>
                        </div>
                        <div class="w-1/3">
                            <div class="font-bold py-2 px-1 text-white bg-gray-900 text-base lg:text-xl w-full text-center truncate">Team Lux</div>
                            <div>
                            </div>
                        </div>
                        <div class="w-1/3">
                            <div class="font-bold py-2 px-1 text-white bg-red-700 text-base lg:text-xl w-full text-center truncate">Team Suisse</div>
                            <div>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-wrap px-2 lg:px-32">
                        <div class="w-1/3 px-2">
                            <div class="relative">
                                <div class="text-sm lg:text-base relative w-full text-center py-2" :key="user.id" v-for="user in team_paris">
                                    {{user.name}}
                                    <div class="px-1 lg:px-8 absolute top-0 right-0 py-2">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="w-1/3 px-2">
                            <div>
                                <div class="text-sm lg:text-base w-full text-center py-2" :key="user.id" v-for="user in team_lux">
                                    {{user.name}}
                                </div>
                            </div>
                        </div>
                        <div class="w-1/3 px-2">
                            <div>
                                <div class="text-sm lg:text-base w-full text-center py-2" :key="user.id" v-for="user in team_swiss">
                                    {{user.name}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="py-8 px-2 lg:px-32">
                    <div>
                        <div class="title-home">Récapitulatif</div>
                        <div class="py-8">
                            <div class="flex border">
                                <div class="bg-sky-200 px-3 py-2 lg:w-1/5 truncate">Nombre d'invités présents</div>
                                <div class="px-3 py-2">{{coming.length}}</div>
                            </div>
                            <div class="flex border">
                                <div class="bg-sky-200 px-3 py-2 lg:w-1/5 truncate">Nombre de moitié présentes</div>
                                <div class="px-3 py-2">{{coming.filter(u => u.is_accompanied).length}}</div>
                            </div>
                            <div class="flex border">
                                <div class="bg-sky-900 text-white px-3 py-2 lg:w-1/5 truncate">Nombre total de personnes présentes</div>
                                <div class="px-3 py-2">{{coming.length + coming.filter(u => u.is_accompanied).length}}</div>
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
import Couple from '../Help/Icon/Couple.vue'
export default {
    components:  {BreezeGuestLayout, DocValue, Couple},
    layout: BreezeGuestLayout,
    props: {
        getusers: Array,
        getsection: Object,
    },
    data() {
        return{
            //page: this.$page.props.pages.filter(page => page.title == 'Faq')[0],
            //  sections: this.$page.props.pages.filter(page => page.title == 'Faq')[0].page_sections
            allUsers: this.getusers.filter(u => u.roles[0].name === 'client')
        }
    },
    methods: {
    },
    computed: {
        coming() { return this.allUsers.filter(u => u.is_partying && u.has_answered)},
        notComing() { return this.allUsers.filter(u => !u.is_partying && u.has_answered)},
        noAnswers() { return this.allUsers.filter(u => !u.has_answered)},
        team_lux() { return this.allUsers.filter(u => u.team == 'lux')},
        team_paris() { return this.allUsers.filter(u => u.team == 'paris')},
        team_swiss() { return this.allUsers.filter(u => u.team == 'swiss')},
    },
    created() {
    },
}
</script>
<style>

</style>
