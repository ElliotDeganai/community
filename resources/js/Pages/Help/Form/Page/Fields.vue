<template>
    <div class="">
        <div>
            <div class="py-16">
                <div class="header-config">
                    Page header
                </div>
                <div class="header-config">
                    Page Footer
                </div>
                <div class="header-config">
                    Page details
                </div>
                <div class="py-4">
                    <label class="label-fields" for="title">Title</label>
                    <div class="py-2 w-full">
                        <input type="text" class="form-fields" id="title" name="title" v-model="model.title" />
                        <div class="w-full error-msg" v-if="errors.title">{{ errors.title }}</div>
                    </div>
                </div>
                <div class="py-4">
                    <label class="label-fields" for="url">URL</label>
                    <div class="py-2 w-full">
                        <input type="text" class="form-fields" id="url" name="url" v-model="model.url" />
                        <div class="w-full error-msg" v-if="errors.url">{{ errors.url }}</div>
                    </div>
                </div>
                <div class="py-4">
                    <label class="label-fields" for="content">Description</label>
                    <div class="py-2">
                        <textarea class="w-1/2 form-fields" id="description" name="description" v-model="model.description">
                        </textarea>
                        <div class="w-full error-msg" v-if="errors.description">{{ errors.description }}</div>
                    </div>
                </div>
                <div class="">
                    <custom-file
                        :getFiles="getmodel.medias"
                        :getId="'page_image'"
                        :getType="'image'"
                        :getObject="getmodel"
                    />
                </div>
            </div>
            <div class=" text-sm py-8">
                <div>
                    <div class="header-config">
                        Category to use on the page
                    </div>
                    <div>
                        <div :key="index" v-for="(category, index) in this.model.categories" class="py-4 border-b border-gray-300">
                            <div>
                                <div>
                                    <div class="py-4">
                                        <label class="label-fields">Category</label>
                                        <div class="py-2">
                                            <select @change="selectCategoryToAdd($event.target.value)" class="w-1/5 form-fields">
                                                <option></option>
                                                <option :key="cat.id" v-for="cat in categories" :value="cat.id">{{cat.name}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div v-if="category.category.id > 0">
                                        <div>
                                            <div>
                                                <div class="label-fields py-4">Which category attributes do you want to display on the page ?</div>
                                            </div>
                                            <div class="checkbox py-4" :key="doc.id" v-for="doc in getCategoryById(category.category.id).documentations">
                                                <label class="label-fields">
                                                    <input type="checkbox" :name="'roles'+doc.id" :value="doc"
                                                    @change="CheckDocumentation(doc, index)" :checked="isChecked(doc, index)"/>
                                                    {{doc.name}}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div v-if="category.id === iteration" class="flex flex-wrap">
                                    <button @click.prevent="onButtonRemoveItem(category.category.id)" class="btn-delete">
                                        <span class="">Delete category</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div></div>
                        </div>
                        <!-- <remove-item getText="Supprimer l'activité" @itemToRemove.prevent="onButtonRemoveItem(activity.index)" /> -->
                        <div class="flex flex-wrap py-8">
                            <div>
                        <!-- <remove-item getText="Supprimer l'activité" @itemToRemove.prevent="onButtonRemoveItem(activity.index)" /> -->
                            </div>

                        </div>
                        <div class="flex flex-wrap py-8">
                            <button @click.prevent="onButtonAddItem()" class="rounded-md flex flex-wrap justify-center px-3 py-2 text-white bg-blue-600 hover:bg-blue-400 hover:text-white hover:font-bold">
                                <span class="">Add Category</span>
                            </button>
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
//import { Link } from '@inertiajs/inertia-vue3';
import { Link } from '@inertiajs/vue3'
import FileInput from '../../File/FileInput.vue'
import FilesInput from '../../File/FilesInput.vue'
import CustomFile from '../../File/Custom/Parent.vue'
import CustomFiles from '../../File/Custom/Parents.vue'
export default {
    props: {
        getcategories: Array,
        getiteration: Number,
        getmodel: Object,
        errors: Object,
    },
    components: {Link, CustomFile},
    data() {
        return {
            model: this.getmodel,
            iteration: this.getiteration,
            iteration_start: this.getiteration,
            docTypes: ['text', 'html', 'numeric', 'date', 'date_time', 'gallery','image','carousel', 'price'],
            categories: this.getcategories,
            category_list: [],
            selectedCategories: []
        }
    },
    methods: {
        submitModel(){
            this.$emit('modelSubmited', this.model);
        },
        selectCategoryToAdd(catId){
            let category = this.getCategoryById(Number(catId));
            let documentations = [];
            for (let index = 0; index < category.documentations.length; index++) {
                const element = category.documentations[index];
                documentations.push(element);
            }
            //console.log(Number(catId), this.isCategorySelected(Number(catId)))
            if (!this.isCategorySelected(Number(catId))) {
                this.model.categories[this.model.categories.length-1] = {
                    id : this.iteration,
                    category: category,
                    documentations: documentations
                };
                this.selectedCategories = this.selectedCategories.filter(category => category.id !== Number(catId));
            }
        },
        getCategoryById(id) {
            return this.categories.filter(cat => cat.id === id)[0];
        },
        addCategoryToPage() {
            this.model.categories.push({
                id : this.iteration+1,
                category: {id: 0},
                documentations: null
            });
            this.iteration++;
        },
        addDocumentationProduct() {
            let documentation = {
                id: this.iteration+1,
                name: '',
                type: 'price',
                prefix: null,
                suffix: null,
                currency: null,
                description: '',
            };
            this.model.documentations.push(documentation);
            this.iteration++;
        },
        removeCategory(id) {
            let category = this.getCategoryById(Number(id));
            let newList = this.model.categories.filter(category => category.id != id);
            let newSelectCategories = this.selectCategories.filter(category => category.id != id);
            this.model.categories = newList;
            this.selectCategories = newSelectCategories;
            this.iteration--;
            console.log(category)
            this.selectedCategories.push(category);
        },
        removeDocumentationProduct() {
            let newList = this.model.documentations.filter(documentation => documentation.type !== 'price');
            this.model.documentations = newList;
            this.iteration--;
        },
        getMaxId() {
            let max = 0;
            this.getmodel.documentations.forEach(documentation => {
                if (documentation.id > max) {
                    max = documentation.id;
                }
            });
            return max;
        },
        isChecked(documentation, index) {
            return this.model.categories[index].documentations.find(doc => doc.id === documentation.id) !== undefined;
        },
        CheckDocumentation(documentation, index) {
            this.model.categories[index].documentations.find(doc => doc.id === documentation.id) === undefined ?
            this.model.categories[index].documentations.push(documentation) : this.model.categories[index].documentations.splice(this.model.categories[index].documentations.indexOf(documentation), 1);
        },
        onButtonAddItem() {
            this.addCategoryToPage();
        },
        onButtonRemoveItem(index) {
            this.removeCategory(index);
        },
        toggleProduct() {
            this.model.is_product = !this.model.is_product;
            if (this.model.is_product) {
                this.addDocumentationProduct();
            }else{
                this.removeDocumentationProduct();
            }
        },
        isCategorySelected(id){
            return this.model.categories.filter(category => category.category.id === id).length > 0;
        }
    },
    computed: {
    },
    mounted() {
        this.addCategoryToPage();
        let temp = this.categories;
        this.selectedCategories = temp;
    },
}
</script>
