<template>
    <div v-if="object.audio">
        <div v-if="object.medias">
            <div v-if="object.medias.length > 0">
                <div class="w-full font-bold">Current audio file:</div>
                <div class="flex flex-wrap py-8">
                    <div class="w-1/4 h-56 p-4 border border-gray-200 relative" :key="media.id" v-for="media in this.object.medias">
                        <div class="w-full relative h-full">
                            <div href="#" class="w-1/4 hover:text-purple-400 flex flex-wrap justify-center">
                                <Music getColor="" getSize="24"/>
                                <div>{{ media.name }}</div>
                            </div>
                            <Link as="button" data-message="Are you sure ?" class="btn-delete z-10 cursor-pointer absolute top-0 left-0" method="delete" :href="route('medias.destroy', media.id)" :preserve-state="false">
                                Delete
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="object.audio.length > 0" class="flex flex-wrap py-8">
            <div class="w-full font-bold">Selected audio:</div>
            <div class="w-1/4 h-56 p-4 relative" :key="index" v-for="(file, index) in this.object.audio">
                <div @mouseleave="resetHover()" @mouseover="setHover(file.previewBase64)" class="w-full relative h-full">
                    <div href="#" class="w-1/4 hover:text-purple-400 flex flex-wrap justify-center">
                        <Music getColor="" getSize="24"/>
                        <div>{{ file.name }}</div>
                    </div>
                    <div @click.prevent="removeFile(file)" v-if="hover === file.previewBase64" class="flex flex-wrap">
                        <button class="btn-delete z-10 absolute top-0 left-0">
                            <span class="">Remove</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <Audio @files-updated="captureFile($event)" :getType="type"></Audio>
    </div>
</template>
<script>
import Audio from "./Audio.vue"
import { Link } from '@inertiajs/inertia-vue3';
import Music from '../../Icon/Music.vue'
export default {
    props: ["getFiles", "geterror", "getType", "getObject"],
  components: { Audio, Link, Music },
  data() {
    return {
      hover: null,
      files: this.getObject.audio,
      type: this.getType,
      object: this.getObject
    }
  },
  methods: {
    captureFile($event) {
        this.object.audio = [];
      this.object.audio.push($event);
        if (this.object.audio.length > 0) {
            this.object.value_audio = 1;
        }
    },
    setHover(key) {
      this.hover = key;
    },
    resetHover() {
      this.hover = null;
    },
    removeFile(file) {
        this.object.audio = this.object.audio.filter(item => item.previewBase64 !== file.previewBase64);
        this.hover = null;
        if (this.object.audio.length <= 0) {
            this.object.value_audio = 0;
        }
    }
  },
  mounted() {
  },
}
</script>
