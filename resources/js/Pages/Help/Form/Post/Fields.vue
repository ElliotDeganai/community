<template>
    <div class="">
        <div>
            <div class="py-16">
                <div class="header-config">
                    Post details
                </div>
                <div class="py-4">
                    <label class="label-fields" for="title">Name</label>
                    <div class="py-2">
                        <input @blur.prevent="setSlug()" type="text" class="form-fields" id="name" name="name" v-model="model.name" />
                        <div class="error-msg" v-if="errors.name">{{ errors.name }}</div>
                    </div>
                </div>
                <div class="py-4">
                    <label class="label-fields" for="slug">Slug</label>
                    <div class="py-2">
                        <input type="text" class="form-fields" id="slug" name="slug" v-model="model.slug" />
                        <div class="error-msg" v-if="errors.slug">{{ errors.slug }}</div>
                    </div>
                </div>
                <div class="py-4">
                    <label class="label-fields" for="body">Body</label>
                    <div class="py-2">
                        <textarea class="w-1/2 form-fields" id="body" name="body" v-model="model.body">
                        </textarea>
                        <div class="error-msg" v-if="errors.body">{{ errors.body }}</div>
                    </div>
                </div>
                <div v-if="startCategory === null" class="py-4">
                    <label class="label-fields"  for="category">Template</label>
                    <select @change.prevent="resetDoc()" v-model="model.category_id" id="category" name="category" class="w-1/5 form-fields">
                        <option :key="category.id" v-for="category in categories" :value="category">{{category.name}}</option>
                    </select>
                </div>
                <div v-else class="py-4">
                        <div class="bg-stone-700 w-1/5 text-white font-bold uppercase px-3 py-2 rounded-md">Template: {{model.category_id.name}}</div>
                </div>
                <div class="py-4">
                    <label class="label-fields"  for="published">Published</label>
                    <div class="py-2">
                        <input type="radio" class=" form-fields" id="published" name="published" v-model="model.published" value="0" /> False
                        <input type="radio" class=" form-fields" id="published" name="published" v-model="model.published" value="1" /> True
                        <div class="error-msg" v-if="errors.published">{{ errors.published }}</div>
                    </div>
                </div>
                <div class="py-4">
                    <label class="label-fields" for="excerpt">Excerpt</label>
                    <div class="py-2">
                        <textarea class="w-1/2 form-fields" id="excerpt" name="excerpt" v-model="model.excerpt">
                        </textarea>
                        <div class="error-msg" v-if="errors.excerpt">{{ errors.excerpt }}</div>
                    </div>
                </div>
            </div>
            <div>
                <div  class="header-config">
                    Related
                </div>
                <div v-if="parentCategory">
                    <label class="label-fields">Parent post</label>
                    <div class="py-2">
                        <select v-model="model.post_id" class="w-1/5 form-fields">
                            <option :key="post.id" v-for="post in parentCategory.posts" :value="post">{{post.name}}</option>
                        </select>
                    </div>
                </div>
<!--                 <div class="py-4">
                    <label class="label-fields">Child posts</label>
                    <div class="py-2">
                        <div class="flex flex-wrap">
                            <select v-model="model.post_id" class="w-1/5 form-fields">
                                <option :key="post.id" v-for="post in parentCategory.posts" :value="post">{{post.name}}</option>
                            </select>
                            <div class="px-3" :key="childPost.id" v-for="childPost in childPosts">
                                <div class="px-3 py-2 rounded-full bg-stone-800 text-white font-bold">{{childPost.name}}</div>
                            </div>
                            <Link  v-if="model.id" class="px-3 py-2 rounded-full bg-sky-800 text-white font-bold" :href="route('categories.create_type', { type: model.name ? model.name : 'custom' })"  :data="{ type: model.name ? model.name : 'custom' }">+ Add Child Post</Link>
                        </div>
                    </div>
                </div> -->

            </div>
            <div class="py-8">
                <div class="header-config">
                    Documentation
                </div>
                <div class="py-8" v-if="model.category_id !== null">
                    <div class="error-msg" v-if="errors.doc_values">
                        <div :key="index" v-for="(error, index) in errors.doc_values">Your form has some issues</div>
                    </div>
                    <div class="w-full" :key="attribute.id" v-for="(attribute, index) in model.category_id.documentations">
                        <label class="label-fields" :for="'doc_'+attribute.id">{{ attribute.name }}</label>
                        <div v-if="model.doc_values.filter(doc => doc.documentation_id === attribute.id )[0]" class="py-4">
                            <input type="text"
                                v-if="attribute.type === 'text'"
                                class="w-2/3 form-fields"
                                :id="'doc_'+attribute.id"
                                :name="'doc_'+attribute.id"
                                v-model="model.doc_values.filter(doc => doc.documentation_id === attribute.id )[0].value_text"
                            />
                            <input type="text"
                                v-if="attribute.type === 'link'"
                                class="w-2/3 form-fields"
                                :id="'doc_'+attribute.id"
                                :name="'doc_'+attribute.id"
                                v-model="model.doc_values.filter(doc => doc.documentation_id === attribute.id )[0].value_link"
                            />
<!--                             <div v-if="attribute.type === 'list'">
                                <div>
                                    <div :key="option.id" v-for="option in attribute.doc_options">
                                        <label class="label-fields" :for="'doc_'+option.id">{{ option.option }}</label>
                                        <input type="text"
                                            class="w-2/3 form-fields"
                                            :id="'doc_'+attribute.id+'_'+option.id"
                                            :name="'doc_'+attribute.id+'_'+option.id"
                                            v-model="model.doc_values.filter(doc => doc.option_id === option.id )[0].value_list"
                                        />
                                    </div>
                                </div>
                            </div> -->
                            <rich-text v-if="attribute.type === 'html'"
                                class="w-full h-64"
                                :id="'doc_'+attribute.id"
                                :name="'doc_'+attribute.id"
                                v-model="model.doc_values.filter(doc => doc.documentation_id === attribute.id )[0].value_html">
                            </rich-text>
                            <input type="number"
                                v-if="attribute.type === 'numeric'"
                                class="w-1/5 form-fields"
                                :id="'doc_'+attribute.id"
                                :name="'doc_'+attribute.id"
                                v-model="model.doc_values.filter(doc => doc.documentation_id === attribute.id )[0].value_number"
                            />
                            <input type="number"
                                v-if="attribute.type === 'price'"
                                class="w-1/5 form-fields"
                                :id="'doc_'+attribute.id"
                                :name="'doc_'+attribute.id"
                                v-model="model.doc_values.filter(doc => doc.documentation_id === attribute.id )[0].value_price"
                            />
                            <input type="date"
                                v-if="attribute.type === 'date'"
                                class="w-1/5 form-fields"
                                :id="'doc_'+attribute.id"
                                :name="'doc_'+attribute.id"
                                v-model="model.doc_values.filter(doc => doc.documentation_id === attribute.id )[0].value_date"
                            />
                            <input type="datetime-local"
                                v-if="attribute.type === 'date_time'"
                                class="w-1/5 form-fields"
                                :id="'doc_'+attribute.id"
                                :name="'doc_'+attribute.id"
                                v-model="model.doc_values.filter(doc => doc.documentation_id === attribute.id )[0].value_date_time"
                            />
                            <div v-if="attribute.type === 'image'" class="">
                                <div class="">
                                    <custom-file
                                        :getFiles="model.doc_values.filter(doc => doc.documentation_id === attribute.id )[0].images"
                                        :getId="index"
                                        :getType="'image'"
                                        :getObject="model.doc_values.filter(doc => doc.documentation_id === attribute.id )[0]"
                                    />
                                </div>
                            </div>
                            <div v-if="attribute.type === 'gallery'" class="">
                                <div class="">
                                    <custom-files
                                        :getFiles="model.doc_values[index].gallery"
                                        :getId="index"
                                        :getType="'gallery'"
                                        :getObject="model.doc_values.filter(doc => doc.documentation_id === attribute.id )[0]"
                                    />
                                </div>
                            </div>
                            <div v-if="attribute.type === 'carousel'" class="">
                                <div class="">
                                    <custom-files
                                        :getFiles="model.doc_values[index].carousel"
                                        :getId="index"
                                        :getType="'carousel'"
                                        :getObject="model.doc_values.filter(doc => doc.documentation_id === attribute.id )[0]"
                                    />
                                </div>
                            </div>
                            <div v-if="attribute.type === 'audio'" class="">
                                <div class="">
                                    <input-audio
                                        :getFiles="model.doc_values[index].audio"
                                        :getId="index"
                                        :getType="'audio'"
                                        :getObject="model.doc_values.filter(doc => doc.documentation_id === attribute.id )[0]"
                                    />
                                </div>
                            </div>
                            <div class="py-4">
                                <div class="error-msg w-full" v-if="errors['doc_values.'+index+'.value_text'] !== undefined && errors['doc_values.'+index+'.value_text'] !== null">
                                    <p>{{errors['doc_values.'+index+'.value_text']}}</p>
                                </div>
                                <div class="error-msg w-full" v-if="errors['doc_values.'+index+'.value_html'] !== undefined && errors['doc_values.'+index+'.value_html'] !== null">
                                    <p>{{errors['doc_values.'+index+'.value_html']}}</p>
                                </div>
                                <div class="error-msg w-full" v-if="errors['doc_values.'+index+'.value_number'] !== undefined && errors['doc_values.'+index+'.value_number'] !== null">
                                    <p>{{errors['doc_values.'+index+'.value_number']}}</p>
                                </div>
                                <div class="error-msg w-full" v-if="errors['doc_values.'+index+'.value_price'] !== undefined && errors['doc_values.'+index+'.value_price'] !== null">
                                    <p>{{errors['doc_values.'+index+'.value_price']}}</p>
                                </div>
                                <div class="error-msg w-full" v-if="errors['doc_values.'+index+'.value_date'] !== undefined && errors['doc_values.'+index+'.value_date'] !== null">
                                    <p>{{errors['doc_values.'+index+'.value_date']}}</p>
                                </div>
                                <div class="error-msg w-full" v-if="errors['doc_values.'+index+'.value_date_time'] !== undefined && errors['doc_values.'+index+'.value_date_time'] !== null">
                                    <p>{{errors['doc_values.'+index+'.value_date_time']}}</p>
                                </div>
                                <div class="error-msg w-full" v-if="errors['doc_values.'+index+'.images.0'] !== undefined && errors['doc_values.'+index+'.images.0'] !== null">
                                    <p>There is some issues with the image</p>
                                </div>
                                <div class="error-msg w-full" v-if="errors['doc_values.'+index+'.gallery.0'] !== undefined && errors['doc_values.'+index+'.gallery.0'] !== null">
                                    <p>There is some issues with your gallery images</p>
                                </div>
                                <div class="error-msg w-full" v-if="errors['doc_values.'+index+'.carousel.0'] !== undefined && errors['doc_values.'+index+'.carousel.0'] !== null">
                                    <p>There is some issues with your carousel images</p>
                                </div>
                                <div class="error-msg w-full" v-if="errors['doc_values.'+index+'.audio.0'] !== undefined && errors['doc_values.'+index+'.audio.0'] !== null">
                                    <p>There is some issues with your audio file</p>
                                </div>
                            </div>
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
import FileInput from '../../File/FileInput.vue'
import FilesInput from '../../File/FilesInput.vue'
import CustomFile from '../../File/Custom/Parent.vue'
import CustomFiles from '../../File/Custom/Parents.vue'
import InputAudio from '../../File/Custom/ParentAudio.vue'
import { Link } from '@inertiajs/inertia-vue3';
export default {
    props: {
        getmodel: Object,
        getparent: Object,
        categories: Array,
        errors: Object,
        getparentcategory: Object,
        getparentpost: Object
    },
    components: {RichText, FileInput, FilesInput, CustomFile, CustomFiles, InputAudio, Link},
    data() {
        return {
            startCategory: this.getmodel.category_id,
            model: this.getmodel,
            published: this.getmodel.published,
            iteration: this.getMaxId(),
            parentCategory: this.getparentcategory,
            parentPost: this.getparentpost,
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
    },
    created() {
        if (this.getmodel.doc_values.length === 0 && this.getmodel.category_id !== null) {
            this.resetDoc();
        }
        if (this.getmodel.category_id && this.getparentcategory == null) {
            if (this.getmodel.category_id.category) {
                this.parentCategory = this.getmodel.category_id.category;
            }
        }
        if (this.getparentpost) {

        }
    },
    mounted() {
    },
}
</script>
