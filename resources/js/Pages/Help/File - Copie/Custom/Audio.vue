<template>
  <div>
    <input
      :id="type+'_'+id"
      class="hide-file-input"
      type="file"
      accept="audio/*"
      @change="onFileChange($event)"
    />
    <label :id="type+'_'+id"  class="file-label" :for="type+'_'+id"> Audio </label>
  </div>
</template>
<script>
export default {
    props: ["getType", "getId"],
    data() {
        return {
            index: 0,
            type: this.getType,
            id: this.getId
        }
    },
  methods: {
    onFileChange($event) {
        console.log($event);
        let files=[];
        for (let index = 0; index < $event.target.files.length; index++) {
            let file = $event.target.files[index];
            const reader = new FileReader()
            if (file) {
                reader.readAsDataURL(file)
                reader.onload = () => {
                    //file.id = index;
                    file.previewBase64 = reader.result;
                    files.push(file);
                    console.log(file);
                    this.$emit('files-updated', file);
                }
                reader.onerror = (error) => {
                    console.log('Error ', error)
                }
            }
        }
        this.index++;
    },
  },
}
</script>
<style scoped>
.hide-file-input {
  position: absolute;
  width: 1px;
  height: 1px;
  padding: 0;
  margin: -1px;
  overflow: hidden;
  clip: rect(0, 0, 0, 0);
  white-space: nowrap;
  border-width: 0;
}
.file-label {
  color: #fff;
  background-color: #3730a3;
  padding: 0.5rem 1rem;
  border-radius: 0.25rem;
  cursor: pointer;
}
input[type='file']:focus + .file-label {
  box-shadow: 0 0 0 4px #bae6fd;
}
</style>
