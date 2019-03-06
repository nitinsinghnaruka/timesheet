<template>
  <div>

    <!-- Add task list modal -->
    <div class="modal fade" id="addTaskListModal" tabindex="-1" role="dialog" ref="addTaskListModal">
      <div class="modal-dialog" role="document">
        <form @submit.prevent="storeTaskList()">
          <div class="modal-content">
            <modal-loader :show="loading"></modal-loader>

            <div class="modal-header shadow-sm">
              <h5 class="modal-title"><span class="ti-plus"></span> Task List</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"><span class="ti-close"></span></span>
              </button>
            </div>
            <div class="modal-body">              
              <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" v-model="form.name">
                <small id="nameHelp" class="form-text text-danger" v-if="form.errors.has('name')">{{ form.errors.get('name') }}</small>
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary shadow-sm"><span class="ti-save"></span> Save</button>
            </div>
            
          </div>
        </form>
      </div>
    </div>
    <!--/ Add task list modal -->

  </div>

</template>

<script>
export default {
  data () {
    return {
      loading: false,
      projectId: null,
      form: new Form({
        name: null
      })
    }
  },
  methods: {
    /**
     * Add task list.
     */
    addTaskList () {
      // Show add task list modal
      $(this.$refs.addTaskListModal).modal('show');
      //-------------------------
    },

    /**
     * Store task list.
     */
    storeTaskList () {
      // Show loading
      this.loading = true;
      //-------------

      this.form.submit('post', `task-lists/${this.projectId}`)
        .then((response) => {
          let data = response.data;

          if (data.status == true) {
            // Emit task list stored event
            this.$eventBus.$emit('taskListStored', data.task_list);
            //----------------------------

            // Hide modal
            $(this.$refs.addTaskListModal).modal('hide');
            //-----------

            // Show message
            this.$showToast('success', data.message);
            //-------------
          } else {
            // Show message
            this.$showToast('error', data.message);
            //-------------
          }

          // Hide loading
          this.loading = false;
          //-------------
        })
        .catch((error) => {
          // Hide loading
          this.loading = false;
          //-------------
        });
    }
  },
  created () {
    // Listen to add task list event
    this.$eventBus.$on('addTaskList', (projectId) => {
        // Set project id
        this.projectId = projectId;
        //---------------

        // Call add task list
        this.addTaskList();
        //-------------------
    });
    //------------------------------
  }
}
</script>

<style scoped>
.card .bottom {
  font-size: 14px;
}
</style>
