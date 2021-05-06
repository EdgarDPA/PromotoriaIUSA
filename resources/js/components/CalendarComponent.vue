<template>
    <vue-cal style="height: 500px" :disable-views="['years']" locale="es" />
</template>

<script>
import VueCal from 'vue-cal'
import 'vue-cal/dist/vuecal.css'

export default {
  components: { VueCal },
  data: () => ({
  }),
}
</script>