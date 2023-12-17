<template>
    <div class="relative text-white">
        <div v-if="$page.props.auth.isDev || $page.props.auth.isAdmin" class="pt-16 px-4 md:pt-16 md:px-16 lg:pt-32 lg:px-32 w-full h-full">
            <div class="w-full py-8 lg:py-24 z-10">
                <div class="title-home">Résumé</div>
            </div>
            <div>
                <div>
                    <div>
                        <div>
                            <div class="title-home">{{campaign.name}}</div>
                        </div>
                        <div class="py-4 lg:py-8">
                            <div class="py-4 font-bold text-xl">Budget : {{getValueByFieldName("Budget")}} €</div>
                            <div class="py-4">Description : {{campaign.body}}</div>
                            <div>
                                <Link :href="route('test.email')" class="shrink-0 flex items-center bg-white text-red-900 px-3 py-2">
                                    Test email
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-if="launched" class="py-4 lg:py-8">
                    <div class="header-config-client">Voici le nouveau tirage au sort</div>
                    <div class="py-2 lg:py-4">
                        <div class="py-2" :key="user.id" v-for="user in getEditors">
                            {{user.name}}  offre un cadeau à <span v-if="user.new_user">{{getUser(user.new_user).name}}</span>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="header-config-client">Voici le tirage au sort actuel</div>
                    <div class="py-4">
                        <div class="py-2" :key="user.id" v-for="user in getEditors">
                            <span class="font-bold">{{user.name}}</span> offre un cadeau à <span class="font-bold" v-if="user.user_id">{{getUser(user.user_id).name}}</span>
                        </div>
                    </div>

                </div>
                <div class="py-4 lg:py-8">
                    <div>
                        <button @click.prevent="startCampaign()" class="px-3 py-2 bg-white text-red-900 font-bold">Commencer la campagne</button>
                    </div>
                </div>
                <div>
                    <div>
                        <button @click.prevent="submit()" class="px-3 py-2 bg-white text-red-900 font-bold">Valider</button>
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
import { useForm } from "@inertiajs/inertia-vue3";

import { Link } from '@inertiajs/inertia-vue3';
export default {
    components:  {BreezeGuestLayout, DocValue, Couple, Link},
    layout: BreezeGuestLayout,
    props: {
        getcampaigns: Array,
        getsection: Object,
        getusers: Array
    },
    data() {
        return{
            campaign: this.getCampaignSection().category.posts[0],
            users: this.getusers,
            editors: this.getusers.filter(u => u.roles),
            page: this.$page.props.pages.filter(page => page.title == 'Resume')[0],
            sections: this.$page.props.pages.filter(page => page.title == 'Resume')[0].page_sections,
            updateMode: false,
            launched: false,
            form : useForm({
                users: this.getusers
            }),
        }
    },
    methods: {
        getCampaignSection(){
            return this.$helpers.getSection(this.$page.props.pages.filter(page => page.title == 'Resume')[0], 'Campagne');
        },
        getValueByFieldName(field_name) {
            return this.$helpers.getFieldDocValueObject(this.$helpers.getSectionField(this.getCampaignSection(), field_name) , this.campaign).docValue;
        },
        startCampaign() {
            let user_count = this.getEditors.length-1;
            let pioche = [];
            let final = [];
            let self = this;
            this.getEditors.forEach(user => {
                pioche.push(user);
            });
            pioche = this.shuffleBis(pioche);
            //console.log(pioche)
            while (this.compareArray(pioche, this.getEditors)) {
                pioche = this.shuffleBis(pioche);
            }

            for (let index = 0; index < this.getEditors.length; index++) {
                const element = this.users.filter(u => u.id === this.getEditors[index].id)[0];
                element.new_user = pioche[index].id;
            }

            //console.log(this.isCampaignLogic(this.getEditors))
            if (this.isCampaignLogic(this.getEditors)) {
                this.launched = true;
            } else {
                self.startCampaign();
            }


        },
        shuffle (array)  {
            let start_array = array;
            let temp = array.sort(() => Math.random() - 0.5);
            let self = this;
            while (this.compareArray(temp, start_array)) {
                let temp = array.sort(() => Math.random() - 0.5);
            }
            return temp;

        },
        isCampaignLogic(array) {
            let isLogic = true;

            for (let index = 0; index < array.length; index++) {
                const giver = array[index];
                const receiver = array.filter(u => u.id === giver.new_user)[0];
                //console.log(giver, 'giver');
                //console.log(receiver, 'receiver');
                if (giver.new_user === giver.id) {
                    isLogic = false;
                    return isLogic;
                }
                if (giver.new_user === receiver.id && receiver.new_user === giver.id) {
                    isLogic = false;
                    return isLogic;
                }
                return isLogic;
            }
        },
        compareArray(a1, a2){
            for (let index = 0; index < a1.length; index++) {
                if (a1[index].id === a2[index].id) {
                    return true;
                }
            }
            return false;
        },
        shuffleBis(array){
          for (let i = array.length - 1; i > 0; i--) {
                let j = Math.floor(Math.random() * (i + 1));
                [array[i], array[j]] = [array[j], array[i]];
            }
            return array;
        },
        submit() {
            let self = this;
            this.form.put(route("users.campaign", this.form),  {
                onSuccess: (form) => {
                    self.updateMode = false;
                },
                preserveScroll: true
            });
        },
        cancel() {
            this.updateMode = false;
        },
        changeAnswers() {
            this.updateMode = !this.updateMode;
        },
        setUpdateMode() {
            this.updateMode = !this.updateMode;
        },
        getUser(id) {
            return this.users.filter(u => u.id === id)[0];
        }
    },
    computed: {
        gameStarted() {
            let started = false;
            this.users.forEach(u => {
                if (u.user_id !== null) {
                    started = true;
                }
            });
            return started;
        },
        getEditors() {
            let editors = [];
            this.getusers.forEach(user => {
                if (user.roles.filter(r => r.name === 'editor').length !== 0) {
                    editors.push(user)
                }
            });
            return editors;
        },
        isEditor() {
            if (this.$page.props.auth.user.roles.filter(r => r.name === 'editor').length > 0) {
                return true;
            }
            return false;
        },
    },
    created() {
    },
}
</script>
<style>

</style>
