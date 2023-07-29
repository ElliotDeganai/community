<template>
    <div class="h-full">
        <div :id="getdoc" class=""></div>
        <div v-if="wavesurfer" class="flex flex-wrap justify-center w-full">
            <button class="py-2 px-4" @click="wavesurfer.playPause()">
                <span class="flex" id="play" v-show="!wavesurfer.isPlaying()">
                    <div class="px-2"><Play :getSize="4" :getColor="''" /></div>
                    Play
                </span>

                <span class="flex" id="pause" v-show="wavesurfer.isPlaying()">
                    <div class="px-2"><Pause :getSize="4" :getColor="''" /></div>
                    Pause
                </span>
            </button>
        </div>
    </div>
</template>

<script>
import Play from '../Help/Icon/Play.vue'
import Pause from '../Help/Icon/Pause.vue'
import WaveSurfer from "wavesurfer.js";

export default {
  name: 'Audios',
  components: {Play, Pause},
  props: {
    getaudio: String,
    getdoc: Object,
  },
  data(){
        return{
            wavesurfer: null,
            audio: this.getaudio,
            doc: this.getdoc,
            id: this.getdoc
        }
  },
  async mounted() {
    console.log('test1');
    if (!this.wavesurfer) this.createWaveSurfer();
  },
  methods: {
    createWaveSurfer() {
        console.log('test')
        let self = this;
      this.wavesurfer = WaveSurfer.create({
        container: '#'+self.getdoc,
                progressColor: 'orange',
                waveColor: '#7c3aed',
                mediaControls: true
      });
      this.wavesurfer.load(
        self.audio
      );
    }
  }
}
</script>
<style scoped>

</style>
