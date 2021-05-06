<template>
    <vue-dropzone ref="myVueDropzone" id="dropzone" :options="dropzoneOptions"></vue-dropzone>
</template>

<script>
import vue2Dropzone from 'vue2-dropzone'
import 'vue2-dropzone/dist/vue2Dropzone.min.css'
export default {
  name: 'app',
  components: {
    vueDropzone: vue2Dropzone
  },
  data: function () {
    return {
      dropzoneOptions: {
          url: 'https://httpbin.org/post',
          thumbnailWidth: 180,
          addRemoveLinks: true,
          maxFilesize: 1.0,
          headers: { "My-Awesome-Header": "header value" },
          dictDefaultMessage: "<i class='fa fa-cloud-upload'></i> FILES UPLOAD"
      }
    }
  }
}
</script>