<template>
    <div :class="[setheight === false || setheight === undefined || setheight === null ? 'h-full' : '']" class="block py-2 md:py-4 lg:py-8">
        <div v-if="type == 'text'">
            {{ docValue }}
        </div>
        <div v-if="type == 'price'">
            {{ docValue }} €
        </div>
        <div v-if="type == 'link'">
            <a class="font-bold underline" :href="docValue">{{ docValue }}</a>
        </div>
        <div v-if="type == 'date'">
            {{ docValue }}
        </div>
        <div v-if="type == 'number'">
            {{ docValue }}
        </div>
        <div v-if="type == 'date_time'">
            {{ docValue }}
        </div>
        <div v-html="docValue" v-if="type == 'html'">
        </div>
        <div v-if="type == 'image' && medias[0]" class="inline-block" :class="[imgSize ? 'h-'+(imgHeight-20)+' '+'md:h-'+imgHeight+' '+'w-'+imgWidth : '']">
            <img class="w-full h-full object-cover" v-if="type == 'image'" :src="medias[0].original_url" />
        </div>
        <Audio v-if="type == 'audio'" :getdoc="'wavesurfer_'+getobject.id" :getaudio="medias[0].original_url"></Audio>
        <Gallery v-if="type == 'gallery'" :getphotos="medias" />
        <Gallery v-if="type == 'carousel'" :getphotos="medias" />
    </div>
</template>
<script>
import Audio from '../../Help/Audio.vue'
import Gallery from '../../Help/Gallery/Gallery.vue'
export default {
    props: ['getdoc', 'getobject', 'imgSize', 'setheight'],
    components: {Audio, Gallery},
    data() {
        return {
/*             docValue: this.getdoc ? this.getdoc.docValue : '',
            type: this.getdoc ? this.getdoc.type : '',
            medias: this.getdoc ? this.getdoc.medias : '',
            object: this.getdoc ? this.getobject : '',
            imgHeight: this.imgSize ? this.imgSize.height : '',
            imgWidth: this.imgSize ? this.imgSize.width : '' */
        }
    },
    computed: {
        docValue(){
            return this.getdoc ? this.getdoc.docValue : '';
        },
        type(){
            return this.getdoc ? this.getdoc.type : '';
        },
        medias(){
            return this.getdoc ? this.getdoc.medias : '';
        },
        object(){
            return this.getdoc ? this.getobject : '';
        },
        imgHeight(){
            return this.imgSize ? this.imgSize.height : '';
        },
        imgWidth(){
            return this.imgSize ? this.imgSize.width : '';
        },
    },
}
</script>
