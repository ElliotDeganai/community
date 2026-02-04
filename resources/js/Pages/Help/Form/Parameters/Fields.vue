<template>
    <div class="">
        <div>
            <div class="py-16">
                <div class="header-config">
                    Site infos
                </div>
                <div class="py-4">
                    <label class="label-fields" for="title">Site Name</label>
                    <div class="py-2">
                        <input type="text" class="form-fields" id="site_name" name="site_name" v-model="model.site_name" />
                        <div class="error-msg" v-if="errors.name">{{ errors.site_name }}</div>
                    </div>
                </div>
                <div class="py-4">
                    <label class="label-fields" for="email">email</label>
                    <div class="py-2">
                        <input type="text" class="form-fields" id="email" name="email" v-model="model.email" />
                        <div class="error-msg" v-if="errors.email">{{ errors.email }}</div>
                    </div>
                </div>
                <div class="py-4">
                    <label class="label-fields" for="phone">phone</label>
                    <div class="py-2">
                        <input type="text" class="form-fields" id="phone" name="phone" v-model="model.phone" />
                        <div class="error-msg" v-if="errors.phone">{{ errors.phone }}</div>
                    </div>
                </div>
                <div class="py-4">
                    <label class="label-fields" for="mobile">mobile</label>
                    <div class="py-2">
                        <input type="text" class="form-fields" id="mobile" name="mobile" v-model="model.mobile" />
                        <div class="error-msg" v-if="errors.mobile">{{ errors.mobile }}</div>
                    </div>
                </div>
                <div class="py-4">
                    <label class="label-fields" for="address">address</label>
                    <div class="py-2">
                        <input type="text" class="form-fields" id="address" name="address" v-model="model.address" />
                        <div class="error-msg" v-if="errors.address">{{ errors.address }}</div>
                    </div>
                </div>
                <div class="py-4">
                    <label class="label-fields" for="city">city</label>
                    <div class="py-2">
                        <input type="text" class="form-fields" id="city" name="city" v-model="model.city" />
                        <div class="error-msg" v-if="errors.city">{{ errors.city }}</div>
                    </div>
                </div>
                <div class="py-4">
                    <label class="label-fields" for="postal_code">postal_code</label>
                    <div class="py-2">
                        <input type="text" class="form-fields" id="postal_code" name="postal_code" v-model="model.postal_code" />
                        <div class="error-msg" v-if="errors.postal_code">{{ errors.postal_code }}</div>
                    </div>
                </div>
                <div class="py-4">
                    <label class="label-fields" for="country">country</label>
                    <div class="py-2">
                        <input type="text" class="form-fields" id="country" name="country" v-model="model.country" />
                        <div class="error-msg" v-if="errors.country">{{ errors.country }}</div>
                    </div>
                </div>
                <div>
                    <div  class="py-8">
                        <div class="">
                            <custom-file
                                :getFiles="model.medias_logo_light"
                                :getId="'logo_light'"
                                :getType="'logo_light'"
                                :getObject="model"
                                :getcollection="'logo_light'"
                            />
                        </div>
                    </div>
                    <div class="py-8">
                        <div class="">
                            <custom-file
                                :getFiles="model.medias_logo_dark"
                                :getId="'logo_dark'"
                                :getType="'logo_dark'"
                                :getObject="model"
                                :getcollection="'logo_dark'"
                            />
                        </div>
                    </div>
                    <div class="py-8">
                        <div class="">
                            <custom-file
                                :getFiles="model.medias_logo_footer"
                                :getId="'logo_footer'"
                                :getType="'logo_footer'"
                                :getObject="model"
                                :getcollection="'logo_footer'"
                            />
                        </div>
                    </div>
                </div>
            </div>
            <div class="">
                <button  @click.prevent="submitModel()" class="btn-submit-fields" value="Submit">
                    Submit
                </button>
            </div>
        </div>
    </div>
</template>
<script>
import moment from 'moment'
import '../../RichText.vue'
import RichText from '../../RichText.vue'
import RichText2 from '../../RichText2.vue'
import FileInput from '../../File - Copie/FileInput.vue'
import FilesInput from '../../File - Copie/FilesInput.vue'
import CustomFile from '../../File - Copie/Custom/Parent.vue'
import CustomFiles from '../../File - Copie/Custom/Parents.vue'
import InputAudio from '../../File - Copie/Custom/ParentAudio.vue'
//import { Link } from '@inertiajs/inertia-vue3';
import { Link } from '@inertiajs/vue3'
export default {
    props: {
        getmodel: Object,
        getparent: Object,
        categories: Array,
        errors: Object,
        getparentcategory: Object,
        getparentpost: Object
    },
    components: {RichText, RichText2, FileInput, FilesInput, CustomFile, CustomFiles, InputAudio, Link},
    data() {
        return {
            model: this.getmodel,
        }
    },
    methods: {
        submitModel(){
            if (this.published !== this.model.published) {
               this.published === 0 ? this.model.published_at = moment().format('YYYY-MM-DD HH:mm:ss') : this.model.published_at = null;
            }
            this.$emit('modelSubmited', this.model);
        },
        setSlug() {
            if (this.model.slug === null || this.model.slug === '') {
                this.model.slug = this.model.name.replaceAll(' ', '-').toLowerCase(); // $& means the whole matched string
            }
        },
        getMaxId() {
            let max = 0;
            this.getmodel.doc_values.forEach(documentation => {
                if (documentation.id > max) {
                    max = documentation.id;
                }
            });
            return max;
        },
        resetDoc(){
            this.getmodel.category_id.documentations.forEach(documentation => {
                let doc = {
                    documentation_id: documentation.id,
                    value_text: null,
                    value_number: null,
                    value_html: null,
                    value_date:null,
                    value_date_time:null,
                    value_number:null,
                    value_price:null,
                    value_list: null,
                    value_link: null,
                    value_boolean: null,
                    value_gallery:null,
                    value_image:null,
                    value_carousel:null,
                    images: [],
                    gallery: [],
                    carousel: [],
                    audio: [],
                };
                this.model.doc_values.push(doc);
            });
            this.setParentCatgory()
        },
        addDocValue(val){
            this.model.doc_values.push({

            });
        },
        setParentCatgory(){
            this.parentCategory = this.model.category_id.category;
        },
/*         setChildCatgory(){
            this.childCategories = [];
            this.categories.forEach(element => {

            });
        }, */
        onFileAddedImage(objectForm){
                console.log(objectForm)
                //this.model.value_image = objectForm;
        },
        setImages(){
                if (!this.getmodel.images) {
                    doc_value.images = [];
                };
                if (!doc_value.gallery) {
                    doc_value.gallery = [];
                };
                if (!doc_value.carousel) {
                    doc_value.carousel = [];
                };
        },
    },
    created() {
        //this.setImages();
    },
    mounted() {
    },
}
</script>
