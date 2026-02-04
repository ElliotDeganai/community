<template>
    <div class="container-px-lg post-text-normal">
            <div class="container-py-login">
                <div class="page-subtitle font-bold w-full flex flex-wrap justify-center">
                    <Link :href="route('categories.edit', category.id)" class="text-center w-full uppercase">Template {{category.name}}</Link>
                </div>
            </div>
            <div>From here you can see your template details and all its associated elements.</div>
            <div class="container-py-inside-md">
                <div class="header-config">
                    Details
                </div>
                <div class="container-py-field">
                    <div class="label-fields">Description:</div>
                    <div class="px-3">
                        <div>{{category.description}}</div>
                    </div>
                    <div class="py-2 px-3">Updated the {{formatDate(category.updated_at)}}</div>
                </div>
                <div class="py-2">
                    <div class="header-config">
                        Documentations
                    </div>
                    <div class="flex flex-wrap container-py-field">
                        <div class="px-3" :key="doc.id" v-for="doc in category.documentations">
                            <div class="flex flex-wrap py-2">
                                <div class="px-3 py-2 rounded-full bg-stone-800 text-white font-bold flex flex-wrap">
                                    <div>{{doc.name}}</div>
                                    <div class="px-2"> | </div>
                                    <div>{{doc.type}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-py-inside-md">
                    <div class="header-config">
                        Parent template
                    </div>
                    <div class="flex flex-wrap container-py-field px-3">
                        <Link v-if="category.category" :href="route('categories.show', category.category.id)" class="px-3 py-2 rounded-full bg-stone-800 text-white font-bold">{{category.category.name}}</Link>
                    </div>
                </div>
                <div class="container-py-inside-md">
                    <div class="header-config">
                        Child templates
                    </div>
                    <div class="flex flex-wrap container-py-field">
                        <div class="flex flex-wrap px-3" :key="childCat.id" v-for="childCat in category.categories">
                            <div class="py-2">
                                <Link v-if="childCat" :href="route('categories.show', childCat.id)" class="px-3 py-2 rounded-full bg-stone-800 text-white font-bold">{{childCat.name}}</Link>
                            </div>
                        </div>
                        <div class="py-2">
                            <Link class="px-3 py-2 rounded-full bg-sky-800 text-white font-bold" :href="route('categories.create_type', { type: category.name ? category.name : 'custom' })"  :data="{ type: category.name ? category.name : 'custom' }">+ Add Child Template</Link>
                        </div>
                    </div>
                </div>
                <div class="container-py-inside-md">
                    <div class="header-config">
                        Resources
                    </div>
                    <div class="flex flex-wrap container-py-field">
                        <div class="flex flex-wrap px-3" :key="childPost.id" v-for="childPost in category.posts">
                            <div class="py-2">
                                <Link :href="route('posts.show', childPost.id)" class="px-3 py-2 rounded-full bg-stone-800 text-white font-bold">{{childPost.name}}</Link>
                            </div>
                        </div>
                        <div class="py-2">
                            <Link class="px-3 py-2 rounded-full bg-sky-800 text-white font-bold" :href="route('posts.create_type', { type: category.name ? category.name : 'custom' })"  :data="{ type: category.name ? category.name : 'custom' }">+ Add Resource</Link>
                        </div>
                    </div>
                </div>
                <div class="container-py-inside-md">
                    <button class="btn-delete post-title" @click="this.$store.dispatch('set_model', {model: category, route: 'template', type: 'template'})">Delete</button>
                </div>
            </div>
        </div>
</template>
<script>
import Layout from '../../../Layouts/Authenticated.vue';
//import { Link } from '@inertiajs/inertia-vue3';
import { Link } from '@inertiajs/vue3'
import Pagination from '../../Help/Pagination.vue'
//import { Inertia } from '@inertiajs/inertia'
import { router } from '@inertiajs/vue3'
import moment from 'moment';
import store from '../../../Store/index'
import { mapActions } from 'vuex'
export default {
    store: store,
    layout: Layout,
    components: {Link, Pagination},
    props: ['getcategory'],
    data() {
        return {
            category: this.getcategory,
            detail: null
        }
    },
    methods: {
        formatDate(date){
            return moment(date).format('YYYY-MM-DD HH:mm:ss');
        },
        submit_delete(category) {
            router.delete(route("categories.delete", category.id));
        },
        ...mapActions([
            'set_model'
        ]),
    },
    computed: {
    }
}
</script>
