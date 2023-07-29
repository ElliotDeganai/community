<template>
    <div class="px-32">
        <div class="py-32">
            <div v-if="category" class="text-xl font-bold w-full">
                <div class="text-center w-full uppercase">List of {{category.name}} type resources</div>
            </div>
            <div v-else class="text-xl font-bold w-full">
                <div class="text-center w-full uppercase">Resources</div>
            </div>
        </div>
        <div>This is the resource admin page. From here, you can see the list of all your resources and their associated documentation values</div>
        <div>
            <div>
                <div v-if="$page.props.status.message" class="p-4 rounded-md bg-blue-100 text-blue-700 bold">{{$page.props.status.message}}</div>

                <div v-if="category" class="py-8">
                    <Link :href="route('posts.create_type', type)" class="text-lg font-bold bg-gray-800 px-3 py-2 rounded-md text-white">
                        Add a new {{category.name}} type resource
                    </Link>
                </div>
                <div v-else class="py-8">
                    <Link :href="route('posts.create')" class="text-lg font-bold bg-gray-800 px-3 py-2 rounded-md text-white">
                        Add a new resource
                    </Link>
                </div>
                <div v-if="posts.length !== 0" class="w-full">
                    <div class="w-full">
                        <div class="w-full font-bold flex flex-wrap py-4 border-b-2 border-gray-800">
                            <div class="w-1/12">
                            </div>
                            <div class="text-left w-1/8">Name</div>
                            <div class="text-left w-1/8">Author</div>
                            <div class="text-left w-1/8">Template</div>
                            <div class="text-left w-1/8">Published</div>
                            <div class="text-left w-1/8">Published at</div>
                            <div class="text-left w-1/8">Body</div>
                            <div class="text-left w-1/8">Slug</div>
                        </div>
                    </div>
                    <div class="w-full">
                        <div :key="post.id" v-for="post in posts" class="w-full">
                            <div class="w-full flex flex-wrap py-4 border-b border-gray-200">
                                <div class="w-1/12 py-2">
                                    <button @click.prevent="deploy(post)" type="button">
                                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                                <div class="text-left w-1/8 py-2">
                                    <Link :href="route('posts.show', post.id)" class="">
                                        {{post.name}}
                                    </Link>
                                </div>
                                <div class="text-left w-1/8 py-2">{{post.user.name}}</div>
                                <div class="text-left w-1/8 py-2">
                                    <Link :href="route('categories.show', post.category.id)" class="px-3 py-2 bg-stone-800 rounded-full text-white font-bold">
                                        {{post.category.name}}
                                    </Link>
                                </div>
                                <div class="text-left w-1/8 py-2" v-if="post.published !== 0">true</div>
                                <div class="text-left w-1/8 py-2" v-else>false</div>
                                <div class="text-left w-1/8 py-2">{{post.published_at}}</div>
                                <div class="text-left w-1/8 py-2">{{post.body}}</div>
                                <div class="text-left w-1/8 py-2">{{post.slug}}</div>
                                <button class="btn-delete" @click="this.$store.dispatch('set_model', {model: post, route: 'resource', type: 'resource'})">Delete</button>
<!--                                 <div>
                                    <Link as="button" data-message="Are you sure ?" class="btn-delete" method="delete" :href="route('posts.destroy', post.id)" :preserve-state="false">
                                        Delete
                                    </Link>
                                </div> -->
                            </div>
                            <div class="w-full" v-if="detail !== null">
                                <div v-if="detail.id === post.id" class="w-full bg-stone-100">
                                    <div class="uppercase font-bold text-lg py-2 w-full text-white bg-gray-900 text-center">Documentation</div>
                                    <div class="w-full">
                                        <div class="w-full flex flex-wrap py-2 font-bold">
                                            <div class="text-left w-1/12"></div>
                                            <div class="text-left w-1/8">Documentation</div>
                                            <div class="text-left w-1/4">Value</div>
                                        </div>
                                    </div>
                                    <div class="w-full">
                                        <div class="w-full flex flex-wrap py-2" :key="value.id" v-for="value in post.doc_values">
                                            <div class="text-left w-1/12 py-1"></div>
                                            <div class="text-left w-1/8 py-1">{{value.documentation.name}}</div>
                                            <div v-if="value.documentation.type === 'text'" class="text-left w-1/4 py-1">{{value.value_text}}</div>
                                            <div v-if="value.documentation.type === 'html'" class="text-left w-1/4 py-1" v-html="value.value_html"></div>
                                            <div v-if="value.documentation.type === 'date'" class="text-left w-1/4 py-1">{{value.value_date}}</div>
                                            <div v-if="value.documentation.type === 'date_time'" class="text-left w-1/4 py-1">{{value.value_date_time}}</div>
                                            <div v-if="value.documentation.type === 'numeric'" class="text-left w-1/4 py-1">{{value.value_number}}</div>
                                            <div v-if="value.documentation.type === 'price'" class="text-left w-1/4 py-1">{{value.value_price}}</div>
                                            <div v-if="value.documentation.type === 'image'" class="text-left w-1/4 py-1">{{value.medias.length}} images</div>
                                            <div v-if="value.documentation.type === 'gallery'" class="text-left w-1/4 py-1">{{value.medias.length}} images</div>
                                            <div v-if="value.documentation.type === 'carousel'" class="text-left w-1/4 py-1">{{value.medias.length}} images</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex py-8 flex-wrap justify-center w-full">
                    <pagination :getpagination="getposts" />
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Layout from '../../../Layouts/Authenticated.vue';
import { Link } from '@inertiajs/inertia-vue3';
import Pagination from '../../Help/Pagination.vue'
import { Inertia } from '@inertiajs/inertia'
import store from '../../../Store/index'
import { mapActions } from 'vuex'
export default {
    layout: Layout,
    components: {Link, Pagination},
    props: ['getposts', 'gettype', 'getcategory'],
    data() {
        return {
            posts: this.getposts.data,
            category: this.getcategory,
            type: this.gettype,
            pagination: this.getposts,
            detail: null
        }
    },
    methods: {
        submit_delete(post) {
            Inertia.delete(route("posts.delete", post.id));
        },
        ...mapActions([
            'set_model'
        ]),
        formatDate(date){
            return moment(date).format('YYYY-MM-DD HH:mm:ss');
        },
        showDetails(post){
            this.detail = post;
        },
        reduceDetails(){
            this.detail = null;
        },
        deploy(post){
            if (this.detail === null) {
                this.showDetails(post);
            }else{
                this.reduceDetails();
            }
        },
    },
}
</script>
