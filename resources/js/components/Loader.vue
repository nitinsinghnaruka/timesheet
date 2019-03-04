<template>
  <vue-element-loading :active="show" spinner="ring" background-color="#ffffff" color="gray" text="Loading..." />
</template>

<script>
export default {
  props: {
    show: {
      type: Boolean,
      required: true
    }
  },
  components: {
    VueElementLoading: require('vue-element-loading')
  }
}
</script>

<style scoped>
.velmld-overlay {
  min-height: 80px !important;
}
</style>
