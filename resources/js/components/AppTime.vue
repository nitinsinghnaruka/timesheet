<template>
  <div class="card rounded shadow-sm text-center">
    <div class="card-body">
      <h4 class="card-title"><span class="ti-timer"></span> Time</h4>
      <h5 class="card-subtitle text-success font-weight-bold mb-2">{{ currentTime }}</h5>
    </div>
  </div>  
</template>

<script>
export default {  
  data () {
    return {
      currentTime: this.$moment().format('hh:mm:ss A'),
      logHours: '00:00:00',
      counterRunning: false    
    }
  },
  methods: {
    /**
     * Update time.
     */
    updateTime () {
      setTimeout(function () {
        // Update time
        this.currentTime = this.$moment().format('hh:mm:ss A');
        //------------

        // Recall it self
        this.updateTime();
        //---------------
      }.bind(this), 1000);
    },
  },
  mounted () {
    // Call update time
    this.updateTime();
    //-----------------
  }
}
</script>
