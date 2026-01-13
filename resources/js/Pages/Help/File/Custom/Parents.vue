<template>
    <div>
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
        <div v-if="object[type].length > 0">
            <div class="w-full font-bold">Selected images:</div>
            <div class="flex flex-wrap py-8">
                <div class="w-1/4 h-56 p-4 relative" :key="index" v-for="(file, index) in this.object[type]">
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
        </div>
        <Files @files-updated="captureFile($event)" :getType="type" :getId="id"></Files>
    </div>
</template>
<script>
import Files from "./Files.vue"
//import { Link } from '@inertiajs/inertia-vue3';
import { Link } from '@inertiajs/vue3'
export default {
    props: ["getFiles", "geterror", "getType", "getId",  "getObject"],
  components: { Files, Link },
  data() {
    return {
      hover: null,
      files: this.getFiles,
      type: this.getType,
      id: this.getId,
      object: this.getObject
    }
  },
  methods: {
    captureFile($event) {
        switch (this.type) {
            case 'gallery':
                this.object.gallery.push($event);
                    if (this.object.gallery.length > 0) {
                        this.object.value_gallery = 1;
                    }
                break;
            case 'carousel':
                this.object.carousel.push($event);
                    if (this.object.carousel.length > 0) {
                        this.object.value_carousel = 1;
                    }
                break;

            default:
                break;
        }
    },
    setHover(key) {
      this.hover = key;
    },
    resetHover() {
      this.hover = null;
    },
    removeFile(file) {
        switch (this.type) {
            case 'gallery':
                this.object.gallery = this.object.gallery.filter(item => item.previewBase64 !== file.previewBase64);
                this.hover = null;
                if (this.object.gallery.length <= 0) {
                    this.object.value_gallery = 0;
                }
                break;
            case 'carousel':
                this.object.carousel = this.object.carousel.filter(item => item.previewBase64 !== file.previewBase64);
                this.hover = null;
                if (this.object.carousel.length <= 0) {
                    this.object.value_carousel = 0;
                }
                break;
            default:
                break;
        }
    }
  },
  mounted() {
  },
}
</script>
