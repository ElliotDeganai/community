<template>
    <div>
        <div class="py-4">
            <div :key="index" class="error-msg w-full" v-for="(err, index) in errors">
                <p>We found the following issue: {{err}}</p>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        errors: Object
    },
    data() {
        return {
        }
    },
    methods: {
    },
    mounted() {
    },
}
</script>
