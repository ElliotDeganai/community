<template>
<ul v-if="pagination.total > pagination.per_page" class="flex border border-blue-900 rounded">

    <li class="text-xs md:text-sm border-r border-blue-900 last:border-r-0" :class="[ link.active === true ? 'font-bold bg-blue-800 text-white': '']"  :key="index" v-for="(link, index) in this.linksLimited">
        <Link v-if="link.url !== null" class="py-1 md:py-2 px-2 md:px-4" :href="link.url">
            {{ link.label }}
        </Link>
    </li>


</ul>
</template>
<script>
import { Link } from '@inertiajs/inertia-vue3';
export default {
    props: ["getpagination"],
    components: {Link},
    data(){
        return{
            pagination: this.getpagination,
            links: this.getpagination.links,
            linksLimited: []

        }
    },
    methods: {
        getMiddleLink(label){
            return this.links.filter(link => link.label === label)[0];
        },
        getLastLabel(){
            return this.links[this.links.length-2].label;
        }
    },
    mounted(){
        let refActive = this.links.filter(link => link.active === true)[0];
         if(this.links.length > 6){
             if(refActive.label === 1){
                this.linksLimited.push(refActive);
                this.linksLimited.push(this.getMiddleLink(refActive.label+1));
                this.linksLimited.push(this.getMiddleLink(refActive.label+2));
                this.linksLimited.push(this.getMiddleLink(refActive.label+3));
                this.linksLimited.push(this.links[this.links.length-1]);
             }else if(refActive.label === 2){
                this.linksLimited.push(this.links[0]);
                this.linksLimited.push(this.getMiddleLink(refActive.label-1));
                this.linksLimited.push(refActive);
                this.linksLimited.push(this.getMiddleLink(refActive.label+1));
                this.linksLimited.push(this.getMiddleLink(refActive.label+2));
                this.linksLimited.push(this.getMiddleLink(refActive.label+3));
                this.linksLimited.push(this.links[this.links.length-1]);
             }else if(refActive.label === 3){
                this.linksLimited.push(this.links[0]);
                this.linksLimited.push(this.getMiddleLink(refActive.label-1));
                this.linksLimited.push(this.getMiddleLink(refActive.label-2));
                this.linksLimited.push(refActive);
                this.linksLimited.push(this.getMiddleLink(refActive.label+1));
                this.linksLimited.push(this.getMiddleLink(refActive.label+2));
                this.linksLimited.push(this.getMiddleLink(refActive.label+3));
                this.linksLimited.push(this.links[this.links.length-1]);
             }else if(refActive.label === this.getLastLabel()-2){
                this.linksLimited.push(this.links[0]);
                this.linksLimited.push(this.getMiddleLink(refActive.label-3));
                this.linksLimited.push(this.getMiddleLink(refActive.label-2));
                this.linksLimited.push(this.getMiddleLink(refActive.label-1));
                this.linksLimited.push(refActive);
                this.linksLimited.push(this.getMiddleLink(refActive.label+1));
                this.linksLimited.push(this.getMiddleLink(refActive.label+2));
                this.linksLimited.push(this.links[this.links.length-1]);
             }else if(refActive.label === this.getLastLabel()-1){
                this.linksLimited.push(this.links[0]);
                this.linksLimited.push(this.getMiddleLink(refActive.label-3));
                this.linksLimited.push(this.getMiddleLink(refActive.label-2));
                this.linksLimited.push(this.getMiddleLink(refActive.label-1));
                this.linksLimited.push(refActive);
                this.linksLimited.push(this.getMiddleLink(refActive.label+1));
                this.linksLimited.push(this.links[this.links.length-1]);
             }else if(refActive.label === this.getLastLabel()){
                this.linksLimited.push(this.links[0]);
                this.linksLimited.push(this.getMiddleLink(this.getLastLabel()-3));
                this.linksLimited.push(this.getMiddleLink(this.getLastLabel()-2));
                this.linksLimited.push(this.getMiddleLink(this.getLastLabel()-1));
                this.linksLimited.push(refActive);
             }else{
                this.linksLimited.push(this.links[0]);
                this.linksLimited.push(this.getMiddleLink(refActive.label-3));
                this.linksLimited.push(this.getMiddleLink(refActive.label-2));
                this.linksLimited.push(this.getMiddleLink(refActive.label-1));
                this.linksLimited.push(refActive);
                this.linksLimited.push(this.getMiddleLink(refActive.label+1));
                this.linksLimited.push(this.getMiddleLink(refActive.label+2));
                this.linksLimited.push(this.getMiddleLink(refActive.label+3));
                this.linksLimited.push(this.links[this.links.length-1]);
             }

        }else{
            this.linksLimited = this.links;
        }
    }

}
</script>
