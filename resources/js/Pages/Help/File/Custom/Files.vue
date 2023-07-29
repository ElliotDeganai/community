<template>
  <div>
    <input
      :id="type+'_'+id"
      class="hide-files-input"
      type="file"
      accept="image/*"
      multiple
      @change="onFileChange($event)"
    />
    <label :id="type+'_'+id" class="files-label" :for="type+'_'+id"> Upload files </label>
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
.hide-files-input {
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
.files-label {
  color: #fff;
  background-color: #3730a3;
  padding: 0.5rem 1rem;
  border-radius: 0.25rem;
  cursor: pointer;
}
input[type='file']:focus + .files-label {
  box-shadow: 0 0 0 4px #bae6fd;
}
</style>
