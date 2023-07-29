<template>
    <div class="block h-full py-8">
        <div v-if="type == 'text'">
            {{ docValue }}
        </div>
        <div v-if="type == 'price'">
            {{ docValue }} €
        </div>
        <div class="h-full" v-if="type == 'link'">
            <iframe
                :title="docValue" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen
                class="w-full h-full object-cover" :src="docValue">
            </iframe>
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
        <div v-if="type == 'image'" class="inline-block" :class="[imgSize ? 'h-'+imgHeight+' '+'w-'+imgWidth : '']">
            <img class="w-full h-full object-contain" v-if="type == 'image'" :src="medias[0].original_url" />
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
    props: ['getdoc', 'getobject', 'imgSize'],
    components: {Audio, Gallery},
    data() {
        return {
            docValue: this.getdoc ? this.getdoc.docValue : '',
            type: this.getdoc ? this.getdoc.type : '',
            medias: this.getdoc ? this.getdoc.medias : '',
            object: this.getdoc ? this.getobject : '',
            imgHeight: this.imgSize ? this.imgSize.height : '',
            imgWidth: this.imgSize ? this.imgSize.width : ''
        }
    },
}
</script>
