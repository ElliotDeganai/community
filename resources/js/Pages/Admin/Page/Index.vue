<template>
    <div class="px-32">
        <div class="py-32">
            <div class="text-xl font-bold w-full">
                <div class="text-center w-full uppercase">Pages</div>
            </div>
        </div>
        <div>From here you can see the list of the pages and their associated categories</div>
        <div>
            <div>
                <div v-if="$page.props.status.message !== null" class="py-8">
                    <div v-if="$page.props.status.message" class="p-4 rounded-md bg-blue-100 text-blue-700 bold">{{$page.props.status.message}}</div>
                </div>
                <div class="py-8">
                    <Link :href="route('pages.create')"  class="text-lg font-bold bg-gray-800 px-3 py-2 rounded-md text-white">
                        Add a new page
                    </Link>
                </div>
                <div v-if="pages.length !== 0" class="w-full">
                    <div class="w-full">
                        <div class="w-full font-bold flex flex-wrap py-4 border-b-2 border-gray-800">
                            <div class="w-1/12">
                            </div>
                            <div class="text-left w-1/7">Title</div>
                            <div class="text-left w-1/7">URL</div>
                            <div class="text-left w-1/7">Categories count</div>
                            <div class="text-left w-1/7">Published</div>
                            <div class="text-left w-1/7">Published at</div>
                        </div>
                    </div>
                    <div class="w-full">
                        <div class="w-full" :key="page.id" v-for="page in pages">
                            <div class="w-full flex flex-wrap py-4 border-b border-gray-200">
                                <div class="w-1/12 py-2">
                                    <button @click.prevent="deploy(page)" type="button">
                                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                                <div class="text-left w-1/7 py-2">
                                    <Link :href="route('pages.edit', page.id)" class="">
                                        {{page.title}}
                                    </Link>
                                </div>
                                <div class="text-left w-1/7 py-2">{{page.url}}</div>
                                <div class="text-left w-1/7 py-2">{{page.categories_count}}</div>
                                <div class="text-left w-1/7 py-2">{{page.published}}</div>
                                <div class="text-left w-1/7 py-2">{{formatDate(page.published_at)}}</div>
                                <button v-if="$page.props.auth.isDev" class="btn-delete" @click="this.$store.dispatch('set_model', {model: page, route: 'page', type: 'page'})">Delete</button>
                            </div>
                            <div class="w-full" v-if="detail !== null">
                                <div v-if="detail.id === page.id" class="w-full bg-stone-100">
                                    <div class="uppercase font-bold text-lg py-2 w-full text-white bg-gray-900 text-center">Categories</div>
                                    <div class="w-full">
                                        <div class="w-full flex flex-wrap py-2 font-bold">
                                            <div class="text-left w-1/12"></div>
                                            <div class="text-left w-1/7">Name</div>
                                            <div class="text-left w-1/7">Description</div>
                                        </div>
                                    </div>
                                    <div class="w-full">
                                        <div class="w-full flex flex-wrap py-2" :key="category.id" v-for="category in page.categories">
                                            <div class="text-left w-1/12 py-1"></div>
                                            <div class="text-left w-1/7 py-1">{{category.name}}</div>
                                            <div class="text-left w-1/7 py-1">{{category.description}}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex flex-wrap py-8 justify-center w-full">
                    <pagination :getpagination="pagination" />
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Layout from '../../../Layouts/Authenticated.vue';
//import { Link } from '@inertiajs/inertia-vue3';
import { Link } from '@inertiajs/vue3'
import Pagination from '../../Help/Pagination.vue'
import moment from 'moment';
import store from '../../../Store/index'
import { mapActions } from 'vuex'
export default {
    store: store,
    layout: Layout,
    components: {Link, Pagination},
    props: ['getpages'],
    data() {
        return {
            pages: this.getpages.data,
            pagination: this.getpages,
            detail: null
        }
    },
    methods: {
        formatDate(date){
            return moment(date).format('YYYY-MM-DD HH:mm:ss');
        },
        showDetails(page){
            this.detail = page;
        },
        reduceDetails(){
            this.detail = null;
        },
        deploy(page){
            if (this.detail === null) {
                this.showDetails(page);
            }else{
                this.reduceDetails();
            }
        },
        ...mapActions([
            'set_model'
        ]),
    },
    computed: {
        delete_model () {
            return this.$store.state.model;
        }
    }
}
</script>
