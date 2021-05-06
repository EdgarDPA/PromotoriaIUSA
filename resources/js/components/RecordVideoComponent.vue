<template>
    <VueRecordVideo @result="onResultVideo"/>
</template>

<style>
    .vue-video-recorder .recorder-icon {
        background-color: #17a2b8;
    }
</style>

<script>
    import Vue from 'vue'
    import VueRecord from '@codekraft-studio/vue-record'
    Vue.use(VueRecord)
    
    export default {
        mounted() {
        },
        methods: {
            onResultVideo (data) {
                alert('Grabación exitosa!');
                console.log('The blob data:', data);
                console.log('Downloadable video', window.URL.createObjectURL(data));
            }
        }
    }
</script>