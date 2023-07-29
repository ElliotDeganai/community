<template>
    <div class="px-32">
        <div class="py-32">
            <div class="text-xl font-bold w-full">
                <div class="text-center w-full uppercase">Users</div>
            </div>
        </div>
        <div>From here you can manage the users who can access your application</div>
        <div>
            <div>
                <div v-if="$page.props.status.message" class="p-4 rounded-md bg-blue-100 text-blue-700 bold">{{$page.props.status.message}}</div>
                 <div class="py-8">
                    <Link :href="route('register')"  class="text-lg font-bold bg-gray-800 px-3 py-2 rounded-md text-white">
                        Add a new user
                    </Link>
                </div>
                <div class="w-full">
                    <div class="w-full">
                        <div class="w-full font-bold flex flex-wrap py-4 border-b-2 border-gray-800">
                            <div class="text-left w-1/6">Name</div>
                            <div class="text-left w-1/6">Email</div>
                            <div class="text-left w-1/6">Role</div>
                            <div class="text-left w-1/6">Posts</div>
                            <div class="text-left w-1/6">Categories</div>
                        </div>
                    </div>
                    <div class="w-full">
                        <div class="w-full flex flex-wrap py-4 border-b border-gray-200" :key="user.id" v-for="user in users">
                            <div class="text-left w-1/6 py-2">
                                <Link :href="route('users.edit', user.id)" class="">
                                    {{user.name}}
                                </Link>
                            </div>
                            <div class="text-left w-1/6 py-2">{{user.email}}</div>
                            <div class="text-left w-1/6 py-2">
                                <span :key="role.id" v-for="role in user.roles">{{role.name}}, </span>
                            </div>
                            <div class="text-left w-1/6 py-2">{{user.posts_count}}</div>
                            <div class="text-left w-1/6 py-2">{{user.categories_count}}</div>
                            <button class="btn-delete" @click="this.$store.dispatch('set_model', {model: user, route: 'user', type: 'user'})">Delete</button>
<!--                             <div>
                                <Link as="button" data-message="Are you sure ?" class="btn-delete" method="delete" :href="route('users.destroy', user.id)" :preserve-state="false">
                                    Delete
                                </Link>
                            </div> -->
                        </div>
                    </div>
                </div>
                <div class="flex flex-wrap justify-center w-full">
                    <pagination :getpagination="getusers" />
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Layout from '../../../Layouts/Authenticated.vue';
import { Link } from '@inertiajs/inertia-vue3';
import Pagination from '../../Help/Pagination.vue'
import store from '../../../Store/index'
import { mapActions } from 'vuex'
export default {
    layout: Layout,
    components: {Link, Pagination},
    props: ['getusers'],
    data() {
        return {
            users: this.getusers.data
        }
    },
    methods: {
        ...mapActions([
            'set_model'
        ]),
    },
}
</script>
