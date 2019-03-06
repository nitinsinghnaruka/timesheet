<template>
  <div class="task-lists">

    <!-- Heading -->
    <div class="row mt-2 mb-4">
      <div class="col-md-12">
        <h5 class="text-center"><span class="ti-align-center"></span> Task List</h5>
      </div>
    </div>
    <!--/ Heading -->

    <!-- Task list -->
    <div class="accordion" v-if="! $isEmpty(taskLists)">

      <div class="card border-0 shadow-sm mb-4" v-for="(taskList, index) in taskLists" :key="taskList.id">
        <div class="card-header bg-white shadow-sm">
          <h5 class="mb-0">
            <div class="row">
              <div class="col-md-10">
                <button class="btn btn-link font-weight-bold text-success btn-toggle-task-list" type="button" data-toggle="collapse" :data-target="'#collapse' + index" @click="toggleTasksVisibility(taskList.id)">
                  <span :class="tasksIsActive(taskList.id) ? 'ti-arrow-down' : 'ti-arrow-right'"></span> {{ taskList.name }}
                </button>
              </div>
              <div class="col-md-2">
                <!-- Actions -->
                <div class="actions">
                  <a href="" @click.prevent="$eventBus.$emit('editTaskList', taskList)" v-tooltip="'Edit Task List'"><span class="ti-write"></span></a>
                  <a href="" @click.prevent="deleteTaskList(taskList.id)" v-tooltip="'Delete Task List'"><span class="ti-trash text-danger"></span></a>
                </div>
                <!--/ Actions -->
              </div>
            </div>
          </h5>
        </div>

        <div :id="'collapse' + index" class="collapse show" v-if="tasksIsActive(taskList.id)">
          <div class="card-body mt-1 p-5">
            <loader :show="loading"></loader>
            
            <!-- Tasks -->
            <tasks :tasks="! $isEmpty(taskList.tasks) ? taskList.tasks : []"></tasks>
            <!--/ Tasks -->

          </div>
        </div>

      </div>

    </div>
    <div v-else>
      <div class="text-center mt-5">
        <span class="ti-cloud"></span> No task list.
      </div>
    </div>
    <!--/ Task list -->

  </div>  
</template>

<script>
export default {
  props: {
    taskLists: {
      type: Array,
      required: true
    }
  },
  components: {
    Tasks: require('./Tasks.vue').default
  },
  data () {
    return {
      loading: false,
      activeTasks: []
    }
  },
  methods: {
    /**
     * Toggle tasks visiblity.
     * 
     * @param {integer}  taskListId
     */
    toggleTasksVisibility (taskListId) {
      // Check task list's task is visible or not
      let isTasksVisible = this.activeTasks.filter((value) => {
        return value === taskListId;
      });
      //-----------------------------------------
          
      if (isTasksVisible.length == 0) {
        // Add to active tasks
        this.activeTasks.push(taskListId);
        //--------------------

        // Show task list's tasks
        this.showTasks(taskListId);
        //----------------------- 
      } else {
        // Delete from active tasks
        Vue.delete(this.activeTasks, this.activeTasks.indexOf(taskListId));
        //-------------------------
      }
    },

    /**
     * Tasks is active.
     * 
     * @param {integer}  taskListId
     */
    tasksIsActive (taskListId) {
      let visible = false;

      // Check task list's task is visible or not
      let isTasksVisible = this.activeTasks.filter((value) => {
        return value === taskListId;
      });
      //-----------------------------------------

      // Update visibility
      if (isTasksVisible.length > 0) {
        visible = true;
      }
      //------------------

      return visible;
    },

    /**
     * Set task list.
     * 
     * @param {object}  taskList
     */
    setTaskList (taskList) {
      this.taskLists.unshift(taskList);
    },

    /**
     * Delete task list.
     * 
     * @param {integer}  taskListId
     */
    deleteTaskList (taskListId) {      
      this.$showToast('question', 'Are you sure to delete?', {}, (status) => {
        if (status == true) {
          // Show loader
          this.$root.showLoader = true;
          //------------

          axios.delete(`task-lists/${taskListId}`)
            .then((response) => {
              let data = response.data;

              // Hide loader
              this.$root.showLoader = false;
              //------------

              if (data.status == true) {
                // Find task list in task lists
                this.taskLists.find((_taskList, key) => {
                  if (_taskList.id == taskListId) {
                    // Update task lists
                    Vue.delete(this.taskLists, key);
                    //------------------

                    return true;
                  }
                });
                //-----------------------------

                // Show message
                this.$showToast('success', data.message);
                //-------------
              } else {
                // Show message
                this.$showToast('error', data.message);
                //-------------
              }
            })
            .catch((error) => {
              // Hide loader
              this.$root.showLoader = false;
              //------------
            });
        }
      });
    },

    /**
     * Show tasks.
     * 
     * @param {integer}  taskListId
     */
    showTasks (taskListId) {
      // Get task list of given id
      let taskList = this.taskLists.find((_taskList) => _taskList.id === taskListId);
      //--------------------------

      // Get tasks
      if (this.$isEmpty(taskList.tasks)) {
        // Show loading
        this.loading = true;
        //-------------

        axios.get(`tasks/${taskListId}`)
          .then((response) => {
            let data = response.data;

            // Set tasks to task list
            taskList.tasks = data.tasks;
            //-----------------------

            // Emit task list updated event
            this.$eventBus.$emit('taskListUpdated', taskList);
            //-----------------------------

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
      //----------
    }
  },
  created () {
    // Listen to task list stored event
    this.$eventBus.$on('taskListStored', (taskList) => this.setTaskList(taskList));
    //---------------------------------
  }
}
</script>

<style scoped>
.task-lists .btn-toggle-task-list:hover, .task-lists .btn-toggle-task-list:focus, .task-lists .btn-toggle-task-list:active {
  text-decoration: none;
}

.task-lists .actions {
  margin-top: 8px;
  text-align: right;
}

.task-lists .actions a {
  font-size: 14px;
}

.task-lists .actions a:hover, .task-lists .actions a:focus, .task-lists .actions a:active {
  text-decoration: none;
}
</style>
