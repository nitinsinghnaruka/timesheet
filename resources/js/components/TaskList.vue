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
            <button class="btn btn-link font-weight-bold text-success btn-toggle-task-list" type="button" data-toggle="collapse" :data-target="'#collapse' + index" @click="toggleTasksVisibility(taskList.id)">
              <span :class="tasksIsActive(taskList.id) ? 'ti-arrow-down' : 'ti-arrow-right'"></span> {{ taskList.name }}
            </button>
          </h5>
        </div>

        <div :id="'collapse' + index" class="collapse show" v-if="tasksIsActive(taskList.id)">
          <div class="card-body mt-1 p-5">
            <loader :show="loading"></loader>
            
            <!-- Tasks -->
            <tasks :tasks="taskList.tasks"></tasks>
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
import Tasks from './Tasks.vue';

export default {
  props: {
    taskLists: {
      type: Array,
      required: true
    }
  },
  data () {
    return {
      loading: false,
      activeTasks: []
    }
  },
  components: {
    Tasks
  },
  methods: {
    /**
     * Toggle tasks visiblity.
     * 
     * @param {integer}  taskListID
     */
    toggleTasksVisibility (taskListID) {
      // Check task list's task is visible or not
      let isTasksVisible = this.activeTasks.filter((value) => {
        return value === taskListID;
      });
      //-----------------------------------------
          
      if (isTasksVisible.length == 0) {
        // Add to active tasks
        this.activeTasks.push(taskListID);
        //--------------------
      } else {
        // Delete from active tasks
        Vue.delete(this.activeTasks, this.activeTasks.indexOf(taskListID));
        //-------------------------
      }
    },

    /**
     * Tasks is active.
     * 
     * @param {integer}  taskListID
     */
    tasksIsActive (taskListID) {
      let visible = false;

      // Check task list's task is visible or not
      let isTasksVisible = this.activeTasks.filter((value) => {
        return value === taskListID;
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
     * Get tasks.
     * 
     * @param {integer}  taskListID
     */
    getTasks (taskListID) {
      // Show loading
      this.loading = true;
      //-------------

      axios.get(`tasks/${taskListID}`)
        .then((response) => {

        })
        .catch((error) => {

        });
    }
  }
}
</script>

<style scoped>
.task-lists .btn-toggle-task-list:hover, .task-lists .btn-toggle-task-list:focus .task-lists .btn-toggle-task-list:active {
  text-decoration: unset;
}
</style>
