<template>
  <vue-element-loading :active="show" spinner="ring" background-color="rgba(255, 255, 255, 0.80)" color="gray" text="Loading..." />
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
</style>
