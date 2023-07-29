<template>
    <div>
        <div>
            <div class="py-8">
                <div class="text-2xl font-bold">Attributes:</div>
                <div v-if="model.category_id !== null">
                    <div class="w-full" :key="documentation.id" v-for="documentation in this.documentations">
                        <label :for="'doc_'+documentation.id">{{ documentation.name }}</label>
                        <textarea class="" id="excerpt" name="excerpt" v-model="model.excerpt">
                        </textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import moment from 'moment'
export default {
    props: {
        getdocumentations: Array,
        getdocValues: Array,
        getmodel: Object
    },
    data() {
        return {
            documentations: this.getdocumentations,
            docValues: this.getdocValues
        }
    },
    methods: {
        submitModel(){
            if (this.published !== this.model.published) {
               this.published === 0 ? this.model.published_at = moment().format('YYYY-MM-DD HH:mm:ss') : this.model.published_at = null;
            }
            this.$emit('modelSubmited', this.model);
        },
    }
}
</script>
