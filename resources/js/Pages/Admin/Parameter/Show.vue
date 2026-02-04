<template>
    <div class="container-px-lg">
            <div class="container-py-login">
                <div class="page-subtitle font-bold w-full flex flex-wrap justify-center">
                    <Link :href="route('parameters.edit', post.id)" class="text-center w-full uppercase">Paramètre du site</Link>
                </div>
            </div>
            <div>From here you can see your sites details.</div>
            <div v-if="$page.props.status.message" class="container-p rounded-md bg-blue-100 text-blue-700 bold">{{$page.props.status.message}}</div>
            <div class="container-py-inside-md">
                <div class="header-config">
                    Details
                </div>
                <div>
                    <div class="container-py-field">
                        <label class="label-fields" for="site_name">Name</label>
                        <div class="px-3">
                            <div id="site_name">{{post.site_name}}</div>
                        </div>
                    </div>
                    <div class="container-py-field">
                        <label class="label-fields" for="email">Email</label>
                        <div class="px-3">
                            <div id="email">{{post.email}}</div>
                        </div>
                    </div>
                    <div class="container-py-field">
                        <label class="label-fields" for="phone">Phone</label>
                        <div class="px-3">
                            <div id="phone">{{post.phone}}</div>
                        </div>
                    </div>
                    <div class="container-py-field">
                        <label class="label-fields" for="mobile">Mobile</label>
                        <div class="px-3">
                            <div id="mobile">{{post.mobile}}</div>
                        </div>
                    </div>
                    <div class="container-py-field">
                        <label class="label-fields">Address</label>
                        <div class="px-3">
                            <div>{{post.address}}</div>
                        </div>
                    </div>
                    <div class="container-py-field">
                        <label class="label-fields">City</label>
                        <div class="px-3">
                            <div>{{post.city}}</div>
                        </div>
                    </div>
                    <div class="container-py-field">
                        <label class="label-fields">Postal code</label>
                        <div class="px-3">
                            <div>{{post.postal_code}}</div>
                        </div>
                    </div>
                    <div class="container-py-field">
                        <label class="label-fields">Country</label>
                        <div class="px-3">
                            <div>{{post.country}}</div>
                        </div>
                    </div>
                    <div class="container-py-field">
                        <label class="label-fields">Logo Light</label>
                        <div class="px-3">
                            <div v-if="post.medias.filter(m => m.collection_name == 'logo_light').length > 0" class="inline-block h-64">
                                <img class="w-full h-full object-cover" :src="post.medias.filter(m => m.collection_name == 'logo_light')[0].original_url" />
                            </div>
                        </div>
                    </div>
                    <div class="py-4">
                        <label class="label-fields">Logo Dark</label>
                        <div class="px-3">
                            <div v-if="post.medias.filter(m => m.collection_name == 'logo_dark').length > 0" class="inline-block h-64">
                                <img class="w-full h-full object-cover" :src="post.medias.filter(m => m.collection_name == 'logo_dark')[0].original_url" />
                            </div>
                        </div>
                    </div>
                    <div class="py-4">
                        <label class="label-fields">Logo Footer</label>
                        <div class="px-3">
                            <div v-if="post.medias.filter(m => m.collection_name == 'logo_footer').length > 0" class="inline-block h-64">
                                <img class="w-full h-full object-cover" :src="post.medias.filter(m => m.collection_name == 'logo_footer')[0].original_url" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</template>
<script>
import helpers from '../../../helpers'
import Layout from '../../../Layouts/Authenticated.vue';
//import { Link } from '@inertiajs/inertia-vue3';
import { Link } from '@inertiajs/vue3'
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
            post: this.getpost
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
