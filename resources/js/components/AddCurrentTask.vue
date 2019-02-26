<template>
  <div>
    <div class="card rounded shadow-sm mt-2">
      <div class="card-body">
        <h5 class="card-title">Current Task</h5>
        <div class="mb-3">
          <div v-if="task">
            <div>{{ task }}</div>
            <span></span>
          </div>
          <div v-else>No task to show.</div>
        </div>
        <span class="bottom">
          <a href="#" data-toggle="modal" data-target="#addCurrentTaskModal1"><span class="ti-plus"></span> Add current task</a>
        </span>
      </div>
    </div>

    <!-- Add task modal -->
    <div class="modal fade" id="addCurrentTaskModal" tabindex="-1" role="dialog" ref="addCurrentTaskModal">
      <div class="modal-dialog" role="document">
        <form @submit.prevent="storeTask()">
          <div class="modal-content">
            <div class="modal-header shadow-sm">
              <h5 class="modal-title">Current Task</h5>
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
     * Store task.
     */
    storeTask () {
      this.form.submit('post', 'tasks')
        .then((response) => {
          if (response.data.status == true) {
            let data = response.data;
            let task = data.task;

            // Emit event
            Event.$emit('currentTaskAdded', task);
            //-----------

            // Hide modal
            $(this.$refs.addCurrentTaskModal).modal('hide');
            //-----------
          }
        })
        .catch((error) => {
          //
        });
    }
  }
}
</script>

<style scoped>
.card .bottom {
  font-size: 14px;
}
</style>
