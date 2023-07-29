<template>
    <div class="px-32">
            <div class="py-32">
                <div class="text-xl font-bold w-full flex flex-wrap justify-center">
                    <Link :href="route('posts.edit', post.id)" class="text-center w-full uppercase">Resource {{post.name}}</Link>
                </div>
            </div>
            <div>From here you can see your resources details and all its associated elements.</div>
            <div class="py-8">
                <div class="header-config">
                    Details
                </div>
                <div>
                    <div class="label-fields">Description:</div>
                    <div class="px-3">
                        <div>{{post.description}}</div>
                    </div>
                    <div class="py-2 px-3">Updated the {{formatDate(post.updated_at)}}</div>
                </div>
                <div class="py-8">
                    <div class="header-config">
                        Documentations
                    </div>
                    <div class="py-4">
                        <div :key="doc.id" v-for="doc in post.doc_values">
                            <div class="flex flex-wrap py-2 px-3">
                                <div class="">
                                    <div class="label-fields">Documentation: {{ doc.documentation.name }}</div>
                                    <Doc class="w-full" :getobject="doc" :getdoc="getValue(doc)" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="py-8">
                    <div class="header-config">
                        Template
                    </div>
                    <div class="flex flex-wrap py-4 px-3">
                        <Link :href="route('categories.show', post.category.id)" class="px-3 py-2 rounded-full bg-stone-800 text-white font-bold">{{post.category.name}}</Link>
                    </div>
                </div>
                <div class="py-8">
                    <div class="header-config">
                        Parent resource
                    </div>
                    <div class="flex flex-wrap py-4 px-3">
                        <Link v-if="post.post" :href="route('posts.show', post.post.id)" class="px-3 py-2 rounded-full bg-stone-800 text-white font-bold">{{post.post.name}}</Link>
                    </div>
                </div>
                <div class="py-8">
                    <div class="header-config">
                        Child resources
                    </div>
                    <div class="flex flex-wrap py-4">
                        <div class="flex flex-wrap px-3" :key="childPost.id" v-for="childPost in post.posts">
                            <div class="py-2">
                                <Link v-if="childPost" :href="route('posts.show', childPost.id)" class="px-3 py-2 rounded-full bg-stone-800 text-white font-bold">{{childPost.name}}</Link>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="py-8">
                    <button class="btn-delete text-2xl" @click="this.$store.dispatch('set_model', {model: post, route: 'resource', type: 'resource'})">Delete</button>
                </div>
            </div>
        </div>
</template>
<script>
import helpers from '../../../helpers'
import Layout from '../../../Layouts/Authenticated.vue';
import { Link } from '@inertiajs/inertia-vue3';
import Pagination from '../../Help/Pagination.vue'
import moment from 'moment';
import store from '../../../Store/index'
import { mapActions } from 'vuex'
import Doc from '../../Home/Help/DocumentationValue.vue'
export default {
    store: store,
    layout: Layout,
    components: {Link, Pagination, Doc},
    props: ['getpost'],
    data() {
        return {
            post: this.getpost,
            detail: null
        }
    },
    methods: {
        formatDate(date){
            return moment(date).format('YYYY-MM-DD HH:mm:ss');
        },
        getValue(docValue){
            return helpers.getValue(docValue);
        },
        submit_delete(category) {
            Inertia.delete(route("categories.delete", category.id));
        },
        ...mapActions([
            'set_model'
        ]),
    },
    computed: {
    }
}
</script>
