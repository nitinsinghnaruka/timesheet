<template>
  <div>

    <!-- Add task modal -->
    <div class="modal fade" id="addTaskModal" tabindex="-1" role="dialog" ref="addTaskModal">
      <div class="modal-dialog" role="document">
        <form @submit.prevent="storeTask()">
          <div class="modal-content">
            <div class="modal-header shadow-sm">
              <h5 class="modal-title">Task</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"><span class="ti-close"></span></span>
              </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                  <label for="task">Task</label>
                  <select class="form-control" id="task" v-model="form.task">
                    <option value="" selected>Root</option>
                  </select>
                  <small id="taskHelp" class="form-text text-danger" v-if="form.errors.has('task')">{{ form.errors.get('task') }}</small>
                </div>
                <div class="form-group">
                  <label for="name">Name</label>
                  <input type="text" class="form-control" id="name" v-model="form.name">
                  <small id="nameHelp" class="form-text text-danger" v-if="form.errors.has('name')">{{ form.errors.get('name') }}</small>
                </div>
                <div class="form-group">
                  <label for="description">Description</label>
                  <textarea class="form-control" id="description" v-model="form.description"></textarea>
                </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary shadow-sm"><span class="ti-save"></span> Save</button>
            </div>
          </div>
        </form>
      </div>
    </div>
    <!--/ Add task modal -->

  </div>

</template>

<script>
export default {
  data () {
    return {
      task: null,
      form: new Form({
        task: null,
        name: null,
        description: null
      })
    }
  },
  methods: {
    /**
     * Add task.
     */
    addTask () {
      // Show add task modal
      $(this.$refs.addTaskModal).modal('show');
      //--------------------
    },

    /**
     * Store task.
     */
    storeTask () {
      this.form.submit('post', 'tasks')
        .then((response) => {
          if (response.data.status == true) {
            let data = response.data;
            let task = data.task;

            // Emit task added event
            this.$eventBus.$emit('taskAdded', task);
            //----------------------

            // Hide modal
            $(this.$refs.addTaskModal).modal('hide');
            //-----------
          }
        })
        .catch((error) => {
          //
        });
    }
  },
  created () {
    // Listen to add task event
    this.$eventBus.$on('addTask', () => this.addTask());
    //-------------------------
  }
}
</script>

<style scoped>
.card .bottom {
  font-size: 14px;
}
</style>
