<template>
    <div class="border-t border-gray-200">

    </div>
</template>
<script>
import moment from 'moment'
import { Link } from '@inertiajs/inertia-vue3';
export default {
    props: {
        getcategories: Array,
        getiteration: Number,
        getmodel: Object,
        errors: Object,
    },
    components: {Link},
    data() {
        return {
        }
    },
    methods: {
    }
}
</script>
