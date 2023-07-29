<template>
    <div class="">
        <div>
            <div class="py-16">
                <div class="header-config">
                    Category details
                </div>
                <div class="py-4">
                    <label class="label-fields" for="title">Name</label>
                    <div class="py-2 w-full">
                        <input type="text" class="form-fields" id="name" name="name" v-model="model.name" />
                        <div class="w-full error-msg" v-if="errors.name">{{ errors.name }}</div>
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
                <div v-if="$page.props.is_ecommerce == 1" class="checkbox py-4">
                    <label class="label-fields">
                        Is Product ?
                    </label>
                    <div v-if="model.id" class="py-2">
                        <div :class="[model.is_product ? ' bg-green-300' : ' bg-stone-300']" class="w-16 h-6 rounded-full relative shadow-lg">
                            <span :class="[model.is_product ? 'right-0 bg-green-800' : 'left-0 bg-stone-700']" class="absolute -top-1  w-8 h-8 rounded-full shadow-lg"></span>
                        </div>
                    </div>
                    <div v-else class="py-2">
                        <div @click.prevent="toggleProduct()" :class="[model.is_product ? ' bg-green-300' : ' bg-stone-300']" class="cursor-pointer w-16 h-6 rounded-full relative shadow-lg">
                            <span :class="[model.is_product ? 'right-0 bg-green-800' : 'left-0 bg-stone-700']" class="absolute -top-1  w-8 h-8 rounded-full shadow-lg"></span>
                        </div>
                    </div>
                </div>
                <div class="header-config">
                    Related
                </div>
                <div class="py-4">
                    <label class="label-fields">Parent template</label>
                    <div class="py-2">
                        <select v-model="model.category_id" class="w-1/5 form-fields">
                            <option :key="category.id" v-for="category in categories" :value="category">{{category.name}}</option>
                        </select>
                    </div>
                </div>
<!--                 <div class="py-4">
                    <label class="label-fields">Child templates</label>
                    <div class="py-2">
                        <div class="flex flex-wrap">
                            <div class="px-3" :key="childCategory.id" v-for="childCategory in childCategories">
                                <div class="px-3 py-2 rounded-full bg-stone-800 text-white font-bold">{{childCategory.name}}</div>
                            </div>
                            <Link v-if="model.id" class="px-3 py-2 rounded-full bg-sky-800 text-white font-bold" :href="route('categories.create_type', { type: model.name ? model.name : 'custom' })"  :data="{ type: model.name ? model.name : 'custom' }">+ Add Child Template</Link>
                        </div>
                    </div>
                </div> -->
            </div>
            <div class=" text-sm py-8">
                <div>
                    <div class="header-config">
                        Documentation
                    </div>
                    <div>
                        <div :key="documentation.id" v-for="(documentation, index) in this.model.documentations" class="py-4 border-b border-gray-300">
                            <div class="py-2">
                                <label class="label-fields" :for="'doc'+index">
                                    Name
                                </label>
                                <div class="py-2 w-full">
                                    <input v-model="documentation.name" class="form-fields" type="text" :id="'name'+index">
                                    <div class="error-msg w-full" v-if="errors['documentations.'+index+'.name'] !== undefined && errors['documentations.'+index+'.name'] !== null">
                                        <p>{{errors['documentations.'+index+'.name']}}</p>
                                    </div>
                                </div>
                            </div>
                            <div v-if="documentation.id >= iteration_start" class="py-2">
                                <label class="label-fields">Type</label>
                                <div v-if="documentation.type !== 'price'" class="py-2 w-full">
                                    <select v-model="documentation.type" class="w-1/5 form-fields">
                                        <option :key="type.index" v-for="type in docTypes" :value="type">{{type}}</option>
                                    </select>
                                    <div class="error-msg w-full" v-if="errors['documentations.'+index+'.type'] !== undefined && errors['documentations.'+index+'.type'] !== null">
                                        <p>{{errors['documentations.'+index+'.type']}}</p>
                                    </div>
                                </div>
                                <div v-else class="w-full py-2">
                                    <div class="px-3 py-2 inline-block rounded-full bg-stone-800 text-white font-bold">{{documentation.type}}</div>
                                </div>
                                <div class="error-msg w-full" v-if="errors['documentations.'+index+'.type'] !== undefined && errors['documentations.'+index+'.type'] !== null">
                                    <p>{{errors['documentations.'+index+'.type']}}</p>
                                </div>
                            </div>
                            <div v-else class="py-2">
                                <label class="label-fields">Type</label>
                                <div class="py-2 w-full">
                                    <div class="w-1/5 rounded-md px-3 py-2 bg-stone-800 text-white uppercase">{{documentation.type}}</div>
                                </div>
                            </div>
                            <div v-if="documentation.type === 'list'" class="py-2">
                                <label class="label-fields">List Option</label>
                                <div class="py-2">
                                    <div class="flex flex-wrap">
                                        <div class="w-full flex flex-wrap" :key="option.id" v-for="(option, index) in documentation.doc_options">
                                            <div class="w-full flex flex-wrap py-2">
                                                <label class="w-1/8 py-4">Option {{index}}:</label>
                                                <input v-model="option.option" class="px-4 w-2/3" type="text" :id="'name'+index">
                                                <div v-if="option.id >= iteration_start_option" class="flex flex-wrap px-4 py-4">
                                                    <button @click.prevent="onButtonRemoveOption(option.id, documentation)" class="btn-delete">
                                                        <span class="">X</span>
                                                    </button>
                                                </div>
                                                <div v-else class="flex flex-wrap px-4 py-4 w-1/6">
                                                    <Link as="button" data-message="Are you sure ?" class="btn-delete" method="delete" :href="route('options.destroy', option.id)" :preserve-state="false">
                                                        Remove
                                                    </Link>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex flex-wrap py-8">
                                        <button @click.prevent="onButtonAddOption(documentation)" class="rounded-md flex flex-wrap justify-center px-3 py-2 text-white bg-blue-600 hover:bg-blue-400 hover:text-white hover:font-bold">
                                            <span class="">Add option</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="py-2">
                                <label class="label-fields" :for="'description'+index">
                                    description
                                </label>
                                <div class="py-2">
                                    <textarea v-model="documentation.description" class="w-1/2 form-fields" :id="'description'+index" />
                                    <div class="error-msg w-full" v-if="errors['documentations.'+index+'.description'] !== undefined && errors['documentations.'+index+'.description'] !== null">
                                        <p >{{errors['documentations.'+index+'.description']}}</p>
                                    </div>
                                </div>
                            </div>
                            <div v-if="documentation.type in ['numeric', 'date', 'date_time']" class="">
                                <div class="py-2">
                                    <label class="label-fields" :for="'prefix'+index">
                                        Prefix
                                    </label>
                                    <div class="py-2 w-full">
                                        <input v-model="documentation.prefix" class="form-fields" type="text" :id="'prefix'+index">
                                        <div class="error-msg w-full" v-if="errors['documentations.'+index+'.prefix'] !== undefined && errors['documentations.'+index+'.prefix'] !== null">
                                            <p>{{errors['documentations.'+index+'.prefix']}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="py-2">
                                    <label class="label-fields" :for="'suffix'+index">
                                        Suffix
                                    </label>
                                    <div class="py-2 w-full">
                                        <input v-model="documentation.prefix" class="form-fields" type="text" :id="'suffix'+index">
                                        <div class="error-msg w-full" v-if="errors['documentations.'+index+'.suffix'] !== undefined && errors['documentations.'+index+'.suffix'] !== null">
                                            <p>{{errors['documentations.'+index+'.suffix']}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div v-if="true==false" class="py-2">
                                <label class="label-fields" :for="'currency'+index">
                                    Currency
                                </label>
                                <div class="py-2 w-full">
                                    <input v-model="documentation.currency" class="form-fields" type="text" :id="'currency'+index">
                                    <div class="error-msg w-full" v-if="errors['documentations.'+index+'.currency'] !== undefined && errors['documentations.'+index+'.currency'] !== null">
                                        <p>{{errors['documentations.'+index+'.currency']}}</p>
                                    </div>
                                </div>
                            </div>
                            <div v-if="documentation.type !== 'price' && $page.props.is_ecommerce == 1">
                    <!-- <remove-item getText="Supprimer l'activité" @itemToRemove.prevent="onButtonRemoveItem(activity.index)" /> -->
                                <div v-if="documentation.id >= iteration_start" class="flex flex-wrap">
                                    <button @click.prevent="onButtonRemoveItem(documentation.id)" class="btn-delete">
                                        <span class="">Delete documentation</span>
                                    </button>
                                </div>
                                <div v-else class="flex flex-wrap">
                                    <Link v-if="documentation.type === 'price'" as="button" data-message="Are you sure ?" class="btn-delete" method="delete" :href="route('documentations.destroy', documentation.id)" :preserve-state="false">
                                        Delete
                                    </Link>
                                </div>
                            </div>
                        </div>
                    <!-- <remove-item getText="Supprimer l'activité" @itemToRemove.prevent="onButtonRemoveItem(activity.index)" /> -->
                        <div class="flex flex-wrap py-8">
                            <button @click.prevent="onButtonAddItem()" class="rounded-md flex flex-wrap justify-center px-3 py-2 text-white bg-blue-600 hover:bg-blue-400 hover:text-white hover:font-bold">
                                <span class="">Add documentation</span>
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
import { Link } from '@inertiajs/inertia-vue3';
export default {
    props: {
        getcategories: Array,
        getiteration: Number,
        getiterationoption: Number,
        getmodel: Object,
        errors: Object,
        getchildcategories: Array
    },
    components: {Link},
    data() {
        return {
            model: this.getmodel,
            iteration: this.getiteration,
            iteration_start: this.getiteration,
            iteration_option: this.getiterationoption,
            iteration_start_option: this.getiterationoption,
            docTypes: ['text', 'html', 'numeric', 'date', 'date_time', 'gallery','image','carousel', 'audio', 'link'],
            categories: this.getcategories,
            childCategories: this.getchildcategories
        }
    },
    methods: {
        submitModel(){
            this.$emit('modelSubmited', this.model);
        },
        addDocumentation() {
            let documentation = {
                id: this.iteration+1,
                name: '',
                type: '',
                prefix: null,
                suffix: null,
                currency: null,
                description: '',
                doc_options: []
            };
            this.model.documentations.push(documentation);
            this.iteration++;
        },
        addOption(documentation) {
            let option = {
                id: this.iteration_option+1,
                option: '',
            };
            documentation.doc_options.push(option);
            this.iteration_option++;
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
        removeDocumentation(id) {
            let newList = this.model.documentations.filter(documentation => documentation.id != id);
            //console.log(newList);
            this.model.documentations = newList;
            this.iteration--;
        },
        removeOption(id, documentation) {
            let newList = documentation.doc_options.filter(option => option.id != id);
            documentation.doc_options = newList;
            this.iteration_option--;
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
        onButtonAddItem() {
            this.addDocumentation();
        },
        onButtonRemoveItem(index) {
            this.removeDocumentation(index);
        },
        onButtonAddOption(documentation) {
            this.addOption(documentation);
        },
        onButtonRemoveOption(index, documentation) {
            this.removeOption(index, documentation);
        },
        toggleProduct() {
            this.model.is_product = !this.model.is_product;
            if (this.model.is_product) {
                this.addDocumentationProduct();
            }else{
                this.removeDocumentationProduct();
            }
        },
    },
}
</script>
