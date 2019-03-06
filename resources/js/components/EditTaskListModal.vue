<template>
  <div>

    <!-- Edit task list modal -->
    <div class="modal fade" id="editTaskListModal" tabindex="-1" role="dialog" ref="editTaskListModal">
      <div class="modal-dialog" role="document">
        <form @submit.prevent="updateTaskList()">
          <div class="modal-content">
            <modal-loader :show="loading"></modal-loader>

            <div class="modal-header shadow-sm">
              <h5 class="modal-title"><span class="ti-write"></span> Task List</h5>
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
    <!--/ Edit task list modal -->

  </div>

</template>

<script>
export default {
  data () {
    return {
      loading: false,
      taskList: null,
      form: new Form({
        name: null
      })
    }
  },
  methods: {
    /**
     * Edit task list.
     */
    editTaskList () {
      // Set form data
      this.form.name = this.taskList.name;
      //-------------- 

      // Show edit task list modal
      $(this.$refs.editTaskListModal).modal('show');
      //--------------------------
    },

    /**
     * Update task list.
     */
    updateTaskList () {
      // Show loading
      this.loading = true;
      //-------------

      this.form.submit('put', `task-lists/${this.taskList.id}`)
        .then((response) => {
          let data = response.data;

          if (data.status == true) {
            // Emit task list updated event
            this.$eventBus.$emit('taskListUpdated', data.task_list);
            //-----------------------------

            // Hide modal
            $(this.$refs.editTaskListModal).modal('hide');
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
    // Listen to edit task list event
    this.$eventBus.$on('editTaskList', (taskList) => {
        // Set task list
        this.taskList = taskList;
        //--------------

        // Call edit task list
        this.editTaskList();
        //--------------------
    });
    //-------------------------------
  }
}
</script>

<style scoped>
.card .bottom {
  font-size: 14px;
}
</style>
