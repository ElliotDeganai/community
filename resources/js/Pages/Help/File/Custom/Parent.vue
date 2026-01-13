<template>
    <div v-if="object.images">
        <div v-if="object.medias">
            <div v-if="object.medias.length > 0">
                <div class="w-full font-bold">Current image:</div>
                <div class="flex flex-wrap py-8">
                    <div class="w-1/4 h-56 p-4 border border-gray-200 relative" :key="media.id" v-for="media in this.object.medias">
                        <div class="w-full relative h-full">
                            <img class="w-full object-contain h-full" :src="media.original_url" :alt="media.name">
                            <Link as="button" data-message="Are you sure ?" class="btn-delete z-10 cursor-pointer absolute top-0 left-0" method="delete" :href="route('medias.destroy', media.id)" :preserve-state="false">
                                Delete
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="object.images.length > 0" class="flex flex-wrap py-4 md:py-8">
            <div class="w-full font-bold">Selected image:</div>
            <div class="w-full md:w-1/3 lg:w-1/4 h-56 p-2 md:p-4 relative" :key="index" v-for="(file, index) in this.object.images">
                <div @mouseleave="resetHover()" @mouseover="setHover(file.previewBase64)" class="w-full relative h-full">
                    <img class="w-full object-contain h-full" :src="file.previewBase64" :alt="file.name">
                    <div @click.prevent="removeFile(file)" v-if="hover === file.previewBase64" class="flex flex-wrap">
                        <button class="btn-delete z-10 absolute top-0 left-0">
                            <span class="">Remove</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <File @files-updated="captureFile($event)" :getType="type" :getId="getId"></File>
    </div>
</template>
<script>
import File from "./File.vue"
//import { Link } from '@inertiajs/inertia-vue3';
import { Link } from '@inertiajs/vue3'
export default {
    props: ["getFiles", "geterror", "getType", "getObject", "getId"],
  components: { File, Link },
  data() {
    return {
      hover: null,
      files: this.getObject.images,
      type: this.getType,
      object: this.getObject
    }
  },
  methods: {
    captureFile($event) {
        this.object.images = [];
      this.object.images.push($event);
        if (this.object.images.length > 0) {
            this.object.value_image = 1;
        }
    },
    setHover(key) {
      this.hover = key;
    },
    resetHover() {
      this.hover = null;
    },
    removeFile(file) {
        this.object.images = this.object.images.filter(item => item.previewBase64 !== file.previewBase64);
        this.hover = null;
        if (this.object.images.length <= 0) {
            this.object.value_image = 0;
        }
    }
  },
  mounted() {
  },
}
</script>
