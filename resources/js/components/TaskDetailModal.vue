<template>
  <div>

    <!-- Task detail modal -->
    <div class="modal fade" id="taskDetailModal" tabindex="-1" role="dialog" ref="taskDetailModal">
      <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content" v-if="! $isEmpty(task)">
            <modal-loader :show="loading"></modal-loader>

            <div class="modal-header shadow-sm">
              <h5 class="modal-title"># {{ task.name }}</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"><span class="ti-close"></span></span>
              </button>
            </div>
            <div class="modal-body">              
              <!-- Status -->
              <div class="status-tag"><span class="badge badge-pill badge-info">In Progress</span></div>
              <!--/ Status -->
            </div>
            <!--
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary shadow-sm"><span class="ti-save"></span> Save</button>
            </div> 
            -->
            
          </div>
      </div>
    </div>
    <!--/ Task detail modal -->

  </div>

</template>

<script>
export default {
  data () {
    return {
      loading: false,
      task: null,
      form: new Form({
        name: null
      })
    }
  },
  methods: {
    /**
     * Show task detail.
     */
    showTaskDetail () {
       // Show task detail modal
       $(this.$refs.taskDetailModal).modal('show');
       //-----------------------
    }
  },
  created () {
    // Listen to show task detail event
    this.$eventBus.$on('showTaskDetail', (task) => {
        // Set task
        this.task = task;
        //---------

        // Call show task Detail
        this.showTaskDetail();
        //----------------------
    });
    //---------------------------------
  }
}
</script>

<style scoped>
.card .bottom {
  font-size: 14px;
}

#taskDetailModal .status-tag {
  text-align: center;
}

#taskDetailModal .status-tag .badge {
  font-size: 20px;
  padding: 10px 30px;
}
</style>
