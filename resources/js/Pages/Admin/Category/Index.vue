<template>
    <div class="px-32">
            <div class="py-32">
                <div class="text-xl font-bold w-full">
                    <div class="text-center w-full uppercase">Categories</div>
                </div>
            </div>
            <div>From here you can see the list of the categories and their associated documentation</div>
            <div>
                <div>
                    <div v-if="$page.props.status.message !== null" class="py-8">
                        <div v-if="$page.props.status.message" class="p-4 rounded-md bg-blue-100 text-blue-700 bold">{{$page.props.status.message}}</div>
                    </div>
                    <div class="py-8">
                        <Link :href="route('categories.create')" class="text-lg font-bold bg-gray-800 px-3 py-2 rounded-md text-white">
                            Add a new Category
                        </Link>
                    </div>
                    <div v-if="categories.length !== 0" class="w-full">
                        <div class="w-full">
                            <div class="w-full font-bold flex flex-wrap py-4 border-b-2 border-gray-800">
                                <div class="w-1/12">
                                </div>
                                <div class="text-left w-1/7">Name</div>
                                <!-- <div class="text-left w-1/7">Description</div> -->
                                <div class="text-left w-1/7">Posts</div>
                                <div class="text-left w-1/7">User</div>
                                <div class="text-left w-1/7">Parent</div>
                                <div class="text-left w-1/7">Updated</div>
                            </div>
                        </div>
                        <div class="w-full">
                            <div class="w-full" :key="category.id" v-for="category in categories">
                                <div class="w-full flex flex-wrap py-4 border-b border-gray-200">
                                    <div class="w-1/12 py-2">
                                        <button @click.prevent="deploy(category)" type="button">
                                            <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="text-left w-1/7 py-2">
                                        <Link :href="route('categories.show', category.id)" class="">
                                            {{category.name}}
                                        </Link>
                                    </div>
                                    <!-- <div class="text-left w-1/7 py-2">{{category.description}}</div> -->
                                    <div class="text-left w-1/7 py-2">{{category.posts_count}}</div>
                                    <div class="text-left w-1/7 py-2">{{category.user.name}}</div>
                                    <div v-if="category.category !== null" class="text-left w-1/7 py-2">
                                        <Link :href="route('categories.show', category.category.id)" class="px-3 py-2 bg-stone-800 rounded-full text-white font-bold">
                                            {{category.category.name}}
                                        </Link>
                                    </div>
                                    <div v-else class="text-left w-1/7 py-2"></div>
                                    <div class="text-left w-1/7 py-2">{{formatDate(category.updated_at)}}</div>
                                    <div class="px-3 py-2">
                                        <Link class="btn-add" :href="route('categories.edit', category.id)">Edit</Link>
                                    </div>
                                    <div class="px-3 ">
                                        <button class="btn-delete" @click="this.$store.dispatch('set_model', {model: category, route: 'template', type: 'template'})">Delete</button>
                                    </div>
                                    <div class="px-3 py-2">
                                        <Link class="btn-add" :href="route('posts.create_type', { type: category.name })"  :data="{ type: category.name }">Add Resource</Link>
                                    </div>
<!--                                     <div class="">
                                        <Link as="button" data-message="Are you sure ?" class="btn-delete" method="delete" :href="route('categories.destroy', category.id)" :preserve-state="false">
                                            Delete
                                        </Link>
                                    </div> -->
                                </div>
                                <div class="w-full" v-if="detail !== null">
                                    <div v-if="detail.id === category.id" class="w-full bg-stone-100">
                                        <div class="uppercase font-bold text-lg py-2 w-full text-white bg-gray-900 text-center">Documentation</div>
                                        <div class="w-full">
                                            <div class="w-full flex flex-wrap py-2 font-bold">
                                                <div class="text-left w-1/12"></div>
                                                <div class="text-left w-1/7">Name</div>
                                                <div class="text-left w-1/7">Type</div>
                                                <div class="text-left w-1/7">Description</div>
                                            </div>
                                        </div>
                                        <div class="w-full">
                                            <div class="w-full flex flex-wrap py-2" :key="documentation.id" v-for="documentation in category.documentations">
                                                <div class="text-left w-1/12 py-1"></div>
                                                <div class="text-left w-1/7 py-1">{{documentation.name}}</div>
                                                <div class="text-left w-1/7 py-1">{{documentation.type}}</div>
                                                <div class="text-left w-1/7 py-1">{{documentation.description}}</div>
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
import { Link } from '@inertiajs/inertia-vue3';
import Pagination from '../../Help/Pagination.vue'
import moment from 'moment';
import store from '../../../Store/index'
import { mapActions } from 'vuex'
export default {
    store: store,
    layout: Layout,
    components: {Link, Pagination},
    props: ['getcategories'],
    data() {
        return {
            categories: this.getcategories.data,
            pagination: this.getcategories,
            detail: null
        }
    },
    methods: {
        formatDate(date){
            return moment(date).format('YYYY-MM-DD HH:mm:ss');
        },
        showDetails(category){
            this.detail = category;
        },
        reduceDetails(){
            this.detail = null;
        },
        deploy(category){
            if (this.detail === null) {
                this.showDetails(category);
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
