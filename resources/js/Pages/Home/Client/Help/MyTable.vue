<template>
    <div class="">
        <div class="w-full">
            <div>{{title}} :</div>
            <div class="flex flex-wrap py-2">
                <div :class="['w-'+colLength]" :key="index" v-for="(headerItem, index) in header" class="font-bold">{{headerItem}}</div>
            </div>
            <div :key="index" v-for="(valRow, index) in tableValues" class="flex flex-wrap content-center border-t py-2">
                <div :class="['w-'+colLength]" :key="index" v-for="(val, index) in valRow" class="">{{val}}</div>
                <button v-if="$page.props.auth.isDev || $page.props.auth.isAdmin" class="btn-delete" @click="this.$store.dispatch('set_model', {model: val  , route: 'resource', type: 'resource'})">Delete</button>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        gettitle: String,
        getheader: Array,
        getvalues: Array,
        getColLength: String
    },
    data() {
        return {
            title: this.gettitle,
            header: this.getheader,
            tableValues: this.getvalues,
            colLength: this.getColLength
        }
    },
    computed: {
        getColLength() {
            return this.tableValues[0]
        }
    },
}
</script>
<style>
</style>
