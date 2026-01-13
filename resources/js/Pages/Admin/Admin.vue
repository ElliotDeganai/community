<template>
    <div class="px-32">
        <div class="py-32">
            <div class="text-xl font-bold w-full">
                <div class="text-center w-full uppercase">Dashboard</div>
            </div>
        </div>
        <div>
            <div>This is your admin page, from here your can manage all the resources on your website !</div>
            <div class="py-8">
                <div v-if="$page.props.auth.isDev || $page.props.auth.isAdmin" class="py-8" id="categories">
                    <div class="header-config">
                        Last templates
                    </div>
                    <div v-if="categories.length > 0" class="flex flex-wrap">
                        <div class="w-1/3 p-8" :key="category.id" v-for="category in categories">
                            <div class=" bg-stone-100 shadow-md h-full rounded-md p-2">
                                <div class="text-xl font-bold">
                                    <Link :href="route('categories.show', category.id)" class="">
                                        {{category.name}}
                                    </Link>
                                </div>
                                <div>{{category.description}}</div>
                                <div>Last update the {{formatDate(category.updated_at)}}</div>
                                <div class="text-gray-500" v-if="category.category">Is child of {{category.category.name}}</div>
                            </div>
                        </div>
                    </div>
                    <div v-else class="p-8 w-1/5">
                        <Link class="btn-submit-fields" :href="route('categories.create')">Create Templates</Link>
                    </div>
                    <div v-if="categories.length > 0" class="px-8 w-1/5">
                        <Link class="btn-submit-fields" :href="route('categories.index')">See all templates</Link>
                    </div>
                </div>
                <div v-if="categories.length > 0" class="py-8" id="posts">
                    <div class="header-config">
                        Last resources
                    </div>
                    <div v-if="posts.length > 0" class="flex flex-wrap">
                        <div class="w-1/3 p-8" :key="post.id" v-for="post in posts">
                            <div class="bg-stone-100 shadow-md h-full rounded-md p-2">
                                <div class="text-xl font-bold">
                                    <Link :href="route('posts.show', post.id)" class="">
                                        {{post.name}}
                                    </Link>
                                </div>
                                <div>{{post.body}}</div>
                                <div>{{post.category.name}}</div>
                                <div>Last update the {{formatDate(post.created_at)}}</div>
                            </div>
                        </div>
                    </div>
                    <div v-else class="p-8 w-1/5">
                        <Link class="btn-submit-fields" :href="route('posts.create')">Create resources</Link>
                    </div>
                    <div v-if="posts.length > 0" class="px-8 w-1/5">
                        <Link class="btn-submit-fields" :href="route('posts.index')">See all resources</Link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Layout from '../../Layouts/Authenticated.vue';
//import { Link } from '@inertiajs/inertia-vue3';
import { Link } from '@inertiajs/vue3'
import moment from 'moment';
import RichText from '../Help/RichText.vue';
import { mapActions } from 'vuex'
export default {
    layout: Layout,
    components: {Link, RichText},
    props: ['getposts', 'getcategories', 'getsettings'],
    data() {
        return {
            posts: this.getposts.data,
            categories: this.getcategories.data,


        }
    },
    methods: {
        formatDate(date){
            return moment(date).format('YYYY-MM-DD HH:mm:ss');
        },
        ...mapActions([
            'SET_DELETE_MODAL'
        ]),
    },
    watch: {
        content: function() {
            console.log(this.content);
        }
    },
    mounted() {
        //this.$store.commit('SET_DELETE_MODAL');
    },
}
</script>
