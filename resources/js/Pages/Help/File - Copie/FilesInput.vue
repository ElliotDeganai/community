<template>
    <div class="py-4">
<!--         <div v-if="object.images.length > 0" class="py-2 md:py-4">
            <div class="">
                <img :src="object.images[0].original_url" class="object-contain h-40 md:h-56" alt="photo de présentation"/>
            </div>
        </div> -->
        <div class="flex flex-wrap">
            <label class="bg-stone-800 text-white py-2 px-2 md:py-2 md:px-4 cursor-pointer text-xs md:text-sm lg:text-base xl:text-base" :for="name">{{selectText}}</label>
            <div class="border-2 border-stone-500 py-2 px-2 md:py-2 md:px-4 text-xs md:text-sm lg:text-base xl:text-base" v-if="objectForm !== null && objectForm !== undefined">{{objectForm.name}}</div>
        </div>
        <input :id="name" type="file" :name="name" class="form-control" v-on:change.prevent="onFileChange" multiple>
        <div class="text-red-700 py-2 w-full" v-if="fileErrors !== undefined && fileErrors !== null">
            <p :key="error.index" v-for="error in fileErrors">{{error}}</p>
        </div>
    </div>
</template>
<script>
export default {
    props: ["getObject", "getType", "getObjectForm", "getSelectText", "getName", "getIsUpdate", "geterror"],
    data(){
        return{
            name: this.getName,
            originalUrl: null,
            objectForm: this.getObjectForm,
            selectText: this.getSelectText,
            isUpdate: this.getObject,
            object: this.getObject,
            type: this.getType,
            fileErrors: this.geterror
        }
    },
    methods: {
        onFileChange(e) {
            e.target.files.forEach(element => {
                this.object.images.push(element);
                switch (this.type) {
                    case 'image':
                        this.object.value_image = 1;
                        break;
                    case 'gallery':
                        this.object.value_gallery = 1;
                        break;
                    case 'carousel':
                        this.object.value_carousel = 1;
                        break;

                    default:
                        break;
                }
            });
            //this.objectForm = e.target.files[0];
            this.$emit('fileAdded', this.objectForm);
        },
    },
    watch: {
        getObjectForm(){
            this.objectForm = this.getObjectForm;
        },
        geterror(){
            this.fileErrors = this.geterror;
        },
        getName(){
            this.name = this.getName;
        }
    }

}
</script>
<style>
input[type="file"] {
    display: none;
}
</style>
