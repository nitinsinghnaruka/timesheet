<template>
  <div class="card rounded shadow-sm">
    <div class="card-body">
      <h4 class="card-title text-center"><span class="ti-time"></span> Calculate Time</h4>
      <div class="row mt-4">
        <div class="col-md-6">
          <h3 class="text-center">{{ calculatedHours }}</h3>

          <form type="POST" class="mt-3 text-center" @keypress="timeError = null;" @submit.prevent="addTime()">
            <div class="form-group">
              <input type="text" class="form-control" placeholder="Enter time" name="time" v-model="time" />
              <small id="timeHelp" class="form-text text-muted text-left">Time must be in 00:00 format.</small>
              <small id="timeHelp" class="form-text text-danger text-left" v-if="timeError">{{ timeError }}</small>
            </div>
            <button type="submit" class="btn btn-primary"><span class="ti-plus"></span> Add</button>
          </form>
        </div>
        <div class="col-md-6">
          <div v-if="times.length">
            <ul class="list-group" style="overflow-x: auto; max-height: 200px;">
              <li class="list-group-item text-center p-2" v-for="(time, index) in times" :key="index">{{ time }}</li>
            </ul>
            <div class="mt-2 text-center pl-2">
              <a href="#" class="card-link text-danger" @click.prevent="clearCalculatedHours()">Clear</a>
            </div>
          </div>
          <div v-else>
            <div class="text-center mt-5">No times.</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  components: {
    AppTime: require('../components/AppTime')
  },
  data () {
    return {
      calculatedHours: '00:00:00',
      time: null,
      timeError: null,
      times: []  
    }
  }   
}
</script>
