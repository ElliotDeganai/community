<template>
    <div class="">
        <div>
            <div class="py-16">
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
                    <label class="label-fields" for="content">Description</label>
                    <div class="py-2">
                        <textarea class="w-1/2 form-fields" id="description" name="description" v-model="model.description">
                        </textarea>
                        <div class="w-full error-msg" v-if="errors.description">{{ errors.description }}</div>
                    </div>
                </div>
<!--                 <div class="">
                    <label for="url">URL</label>
                    <input type="text" class="" id="url" name="url" v-model="model.url" />
                    <div v-if="errors.url">{{ errors.url }}</div>
                </div> -->
                <div class="py-4">
                    <label class="label-fields" for="title">URL</label>
                    <div class="py-2 w-full">
                        <input type="text" class="form-fields" id="url" name="url" v-model="model.url" />
                        <div class="w-full error-msg" v-if="errors.url">{{ errors.url }}</div>
                    </div>
                </div>
                <div class="py-4">
                    <label class="label-fields" for="url_name">URL Name</label>
                    <div class="py-2 w-full">
                        <input type="text" class="form-fields" id="url_name" name="url_name" v-model="model.url_name" />
                        <div class="w-full error-msg" v-if="errors.url_name">{{ errors.url_name }}</div>
                    </div>
                </div>
                <div class="py-4">
                    <label class="label-fields" for="template">Template name</label>
                    <div class="py-2 w-full">
                        <input type="text" class="form-fields" id="template" name="template" v-model="model.template" />
                        <div class="w-full error-msg" v-if="errors.template">{{ errors.template }}</div>
                    </div>
                </div>
                <div class="py-4">
                    <label class="label-fields"  for="published">Published</label>
                    <div class="py-2">
                        <input type="radio" class=" form-fields" id="published" name="published" v-model="model.published" value="0" /> False
                        <input type="radio" class=" form-fields" id="published" name="published" v-model="model.published" value="1" /> True
                        <div class="error-msg" v-if="errors.published">{{ errors.published }}</div>
                    </div>
                </div>
            </div>
            <div class=" text-sm py-8">
                <div>
                    <div class="header-config">
                        Section definition
                    </div>
                    <div>
                        <div :key="index" v-for="(section, index) in this.model.page_sections" class="py-4 border-b border-gray-300">
                            <div>
                                <div class="py-4">
                                    <label class="label-fields" for="title">Title</label>
                                    <div class="py-2 w-full">
                                        <input type="text" class="form-fields" :id="'section_title_'+index" :name="'section_name_'+index" v-model="section.name" />
                                        <div class="w-full error-msg" v-if="errors.name">{{ errors.section.name }}</div>
                                    </div>
                                </div>
                                <div class="py-4">
                                    <label class="label-fields" for="content">Description</label>
                                    <div class="py-2">
                                        <textarea class="w-1/2 form-fields" :id="'section_description_'+index" :name="'section_description_'+index" v-model="section.description">
                                        </textarea>
                                        <div class="w-full error-msg" v-if="errors.description">{{ errors.section.description }}</div>
                                    </div>
                                </div>
                                <div>
                                    <label>Category to use in the section:</label>
                                    <select v-model="section.new_category" class="w-1/5 form-fields">
                                        <option :key="index_cat" v-for="(cat, index_cat) in categories" :value="cat">{{cat.name}}</option>
                                    </select>
                                </div>
                                <div v-if="section.new_category">
                                    <div class="py-8 font-bold">From here you can map the page section fields to your template attributes</div>
                                    <div :key="index" v-for="(field, index) in section.page_fields">
                                        <div class="flex flex-wrap w-1/2">
                                            <!-- <div class="w-1/3">{{ field.name }}</div> -->
                                            <div class="py-4 w-1/2">
                                                <label class="label-fields" for="title">Field name</label>
                                                <div class="py-2 w-full">
                                                    <input type="text" class="form-fields" :id="'field_name_'+index" :name="'field_name_'+index" v-model="field.name" />
                                                    <div class="w-full error-msg" v-if="errors.field">{{ errors.field.name }}</div>
                                                </div>
                                            </div>
                                            <div class="py-4 w-1/2">
                                                <label class="label-fields" for="title">Documentation</label>
                                                <div class="w-full py-2">
                                                    <select v-model="field.new_documentation" class="form-fields w-full">
                                                        <option :key="index" v-for="(doc, index) in section.new_category.documentations" :value="doc">{{doc.name}}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="py-4">
                                        <div @click="addField(section)" class="rounded-md flex flex-wrap justify-center px-3 py-2 text-white bg-blue-600 hover:bg-blue-400 hover:text-white hover:font-bold">Add a field</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="py-4">
                            <div @click="addSection()" class="rounded-md flex flex-wrap justify-center px-3 py-2 text-white bg-blue-600 hover:bg-blue-400 hover:text-white hover:font-bold">Add a section</div>
                        </div>
                        <!-- <remove-item getText="Supprimer l'activité" @itemToRemove.prevent="onButtonRemoveItem(activity.index)" /> -->
                        <div class="flex flex-wrap py-8">
                            <div>
                        <!-- <remove-item getText="Supprimer l'activité" @itemToRemove.prevent="onButtonRemoveItem(activity.index)" /> -->
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
<script defer>
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
            model: this.getmodel,
            iteration: this.getiteration,
            iteration_start: this.getiteration,
            categories: this.getcategories,
            category_list: [],
            selectCategories: []
        }
    },
    methods: {
        submitModel(){
            this.$emit('modelSubmited', this.model);
        },
        addSection(){
            let section = {
                id: this.iteration,
                name: null,
                description: null,
                page_fields: [],
                new_category: null
            };
            this.model.page_sections.push(section);
            this.iteration++;
        },
        addField(section){
            let field = {
                id: this.iteration,
                name: null,
                new_documentation: null
            };
            section.page_fields.push(field);
            this.iteration++;
        },
    },
    computed: {
    },
    created() {
        if (this.model.page_sections) {
            this.model.page_sections.forEach(section => {
                if (section.category === null) {
                    section.new_category = null;
                } else {
                    section.new_category = section.category;
                }
            });
        }
        if (this.model.page_sections) {
            this.model.page_sections.forEach(section => {
                section.page_fields.forEach(field => {
                    if (field.new_documentation === null) {
                        field.new_documentation = null;
                    } else {
                        field.new_documentation = field.documentation;
                    }
                })
            });
        }
    },
    mounted() {
    },
}
</script>
