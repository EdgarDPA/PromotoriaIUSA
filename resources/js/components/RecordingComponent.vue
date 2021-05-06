<template>
    <VueRecordAudio @result="onResult"/>
</template>

<script>
    import Vue from 'vue'
    import VueRecord from '@codekraft-studio/vue-record'
    Vue.use(VueRecord)
    
    export default {
        mounted() {
        },
        methods: {
            onResult (data) {
                alert('Grabación exitosa!');
                console.log('The blob data:', data);
                console.log('Downloadable audio', window.URL.createObjectURL(data));
            }
        }
    }
</script>