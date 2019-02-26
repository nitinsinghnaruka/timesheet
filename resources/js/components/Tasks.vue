<template>
  <div>

    <div v-if="! $isEmpty(tasks)">
      hellow
    </div>
    <div else>
      <div class="text-center">
      <span class="ti-cloud"></span> No tasks.
    </div>
   </div>

  </div>
</template>

<script>
export default {
  props: {
    tasks: {
      type: Array,
      required: true
    }  
  }  
}
</script>
