<template>
    <div class="text-white">
        <div class="relative pt-24">
            <div>
                <div>
                    <div :key="media.id" v-for="media in this.medias" class="p-8 w-full">
                        <div>
                            <div class="text-2xl font-bold w-full text-center py-8">{{media.title.rendered}}</div>
                            <div v-html="media.description.rendered" class="relative w-full flex flex-wrap justify-center py-8"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios'
export default {
    components: {
    },
    props: ['page'],
    data() {
        return{
            medias: [],
            pageTotal: 0,
        }
    },
    computed: {
        queryOptions: function() {        
            return {  
                    per_page: 5, // Only retrieve the 3 most recent blog medias.
                    page: Number(this.page), // Current page of the collection.
                    _embed: true, //Response should include embedded resources.
            }
        }
    },
    methods: {
        // Get Recent Medias From WordPress Site
        getRecentBlogMedias() {
            axios
                .get(this.$wordpress_url+'/wp-json/wp/v2/media', { params: this.queryOptions})
                .then(response => {
                    this.medias= response.data;
                    this.pageTotal = Number(response.headers['x-wp-totalpages']);
                    //console.log(response.headers['x-wp-totalpages'])
                })
                .catch(error => {
                    console.log(error);
                });
        },
        onPageChange(page) {
            this.queryOptions.page = page;
        }
    },
    watch:  {
        queryOptions(){
            this.getRecentBlogMedias();
        },
    },
    mounted() {
        this.getRecentBlogMedias();
    },
}
</script>
<style>

</style>