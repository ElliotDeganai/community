<template>
    <div class="h-full">
        <div v-if="wavesurfer" class="flex flex-wrap justify-center w-full">
            <button class="py-2 px-4" @click="wavesurfer.playPause()">
                    <span class="flex" id="play" v-show="!wavesurfer.isPlaying()">
                        <div class="px-2 boun"><Play :getSize="16" :getColor="'text-amber-900'" /></div>
                    </span>

                    <span class="flex" id="pause" v-show="wavesurfer.isPlaying()">
                        <div class="px-2 boun"><Pause :getSize="16" :getColor="'text-amber-900'" /></div>
                    </span>
            </button>
        </div>
        <div :id="getdoc" class="h-full"></div>
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
    if (!this.wavesurfer) this.createWaveSurfer();
  },
  methods: {
    createWaveSurfer() {
        console.log('test')
        let self = this;
      this.wavesurfer = WaveSurfer.create({
        container: '#'+self.getdoc,
                progressColor: 'orange',
                waveColor: '#78350F',
                mediaControls: true,
                //height: 100,
                interact: true,
                barHeight: 5,
                cursorColor: '#ddd5e9',
                cursorWidth: 2,
                fillParent: true
      });
      this.wavesurfer.load(
        self.audio
      );
    }
  }
}
</script>
<style scoped>


.boun {
  animation: boun 2s linear infinite;
}

@keyframes boun {
  0% { transform: scale(1); }
  50% { transform: scale(2); }
  100% { transform: translateY(1); }
}

     .playFade-enter-active{
        animation: playFadeInVisibility .4s linear;
    }

       .playFade-leave-active, .playFade-leave-to, .playFade-leave{
        animation: playFadeOutVisibility .4s linear;
    }

     @keyframes playFadeIn{
        from{ transform: translateY(-100%); }
        to{ transform: translateY(0); }
    }
    @keyframes playFadeInVisibility{
        from{ opacity: 0; }
        to{ opacity: 1; }
    }

    @keyframes playFadeOut{
        from{ transform: translateY(0); }
        to{ transform: translateY(100%); }

    }

    @keyframes playFadeOutVisibility{
        from{ opacity: 1; }
        to{ opacity: 0; }
    }
</style>
