<template>
  <div>
    <base-layout>

      <div class="project">
        <div class="row justify-content-center mb-4">
          <div class="col-md-8">
          <div class="border-bottom pb-3 text-right">
            <a href="#" @click.prevent="$eventBus.$emit('addTaskList', project.id)" class="mr-3"><span class="ti-plus"></span> Add Task List</a>
            <a href="#" @click.prevent="$eventBus.$emit('addTask', project.id)"><span class="ti-plus"></span> Add Task</a>
          </div>
          </div>
        </div>

        <div class="row justify-content-center">
          <div class="col-md-8">
          <loader :show="loading"></loader>
          
          <!-- Project -->
          <div v-if="! $isEmpty(project)">
            <!-- Project detail -->
            <div class="row">
              <div class="col-md-12">
                <div class="card mb-3">
                  <div class="card-body">
                  <h5 class="card-title">
                    <div class="row">
                      <div class="col-md-10">
                        <span class="ti-tag"></span> {{ project.name }}
                      </div>
                      <div class="col-md-2">
                        <!-- Actions -->
                        <div class="actions">
                          <a href="#" class="text-primary" @click.prevent="$eventBus.$emit('editProject', project)"><span class="ti-write"></span></a>
                          <a href="#" class="text-danger" v-if="$isEmpty(project.task_lists)" @click.prevent="deleteProject(project.id)"><span class="ti-trash"></span></a>
                        </div>
                        <!--/ Actions -->
                      </div>
                    </div>
                  </h5>
                  <p class="card-text ml-1" v-if="project.description">{{ project.description }}</p>
                  </div>
                </div>
              </div>
            </div>
            <!--/ Project detail -->

            <!-- Task List -->
            <div class="row">
              <div class="col-md-12">
                <task-list :task-lists="project.task_lists"></task-list>
              </div>
            </div>
            <!--/ Task List -->

          </div>
          <div v-else>
            <div class="text-center">
              <span class="ti-cloud"></span> Project not found.
              <div class="back-link"><span class="ti-back-left"></span> Click <router-link to="/projects">here</router-link> to go to projects.</div>
            </div>
          </div>
          <!--/ Project -->

          </div>
        </div>
    </div>        

    </base-layout>

    <!-- Edit project modal -->
    <edit-project-modal></edit-project-modal>
    <!--/ Edit project modal -->

    <!-- Add task list modal -->
    <add-task-list-modal></add-task-list-modal>
    <!--/ Add task list modal -->

    <!-- Edit task list modal -->
    <edit-task-list-modal></edit-task-list-modal>
    <!--/ Edit task list modal -->
  </div>

</template>

<script>
export default {
  components: {
    BaseLayout: require('./BaseLayout.vue').default,
    TaskList: require('../components/TaskList.vue').default,
    EditProjectModal: require('../components/EditProjectModal.vue').default,
    AddTaskListModal: require('../components/AddTaskListModal.vue').default,
    EditTaskListModal: require('../components/EditTaskListModal.vue').default
  },
  data () {
    return {
      loading: false,
      project: null
    }
  },
  methods: {
    /**
     * Get project.
     */
    getProject () {
      // Show loading
      this.loading = true;
      //-------------

      axios.get(`projects/${ this.$route.params.id }`)
      .then((response) => {
        let data = response.data;

        // Set project
        if (data.status == true) {
          this.project = data.project;
        }
        //-------------

        // Hide loading
        this.loading = false;
        //-------------
      })
      .catch((error) => {
        // Hide loading
        this.loading = false;
        //-------------
      });
    },

    /**
     * Update project.
     * 
     * @param {object}  project
     */
    updateProject (project) {
      // Get project task lists
      let taskLists = this.project.task_lists;
      //-----------------------

      // Update project
      this.project = project;
      //---------------

      // Reset task lists
      this.project.task_lists = taskLists;
      //-----------------
    },

    /**
     * Delete project.
     * 
     * @param {integer}  projectId
     */
    deleteProject (projectId) {
      // Show loading
      this.loading = true;
      //-------------

      axios.delete(`projects/${projectId}`)
        .then((response) => {
          let data = response.data;

          if (data.status == true) {
            // Go to project
            this.$router.push('/projects');
            //--------------

            // Show message
            this.$showToast('success', 'Project deleted, Redirected you to projects page.');
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
    },

    /**
     * Update task list.
     * 
     * @param {object}  taskList
     */
    updateTaskList (taskList) {
      // Find task list in task lists
      this.project.task_lists.find((_taskList, key) => {
        if (_taskList.id == taskList.id) {
          // Update task lists
          Vue.set(this.project.task_lists, key, taskList);
          //------------------

          return true;
        }
      });
      //-----------------------------
    }
  },
  created () {
    // Listen to project updated event
    this.$eventBus.$on('projectUpdated', (project) => this.updateProject(project));
    //--------------------------------

    // Listen to task list updated event
    this.$eventBus.$on('taskListUpdated', (taskList) => this.updateTaskList(taskList));
    //----------------------------------
  },
  mounted () {
    // Get project
    this.getProject();
    //-------------
  }
}
</script>

<style scoped>
.project .action-links.dropdown-toggle::after {
  display: none;
}

.project .action-links.dropdown-toggle:hover {
  text-decoration: none;
}

.project .project-link, .project .project-link:hover {
  color: inherit;
  text-decoration: none;
}

.project .project-link .card {
  box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
}

.project .project-link:hover .card {
  transition: all 0.7s;
  box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}

.project .actions {
  text-align: right; 
}

.project .actions a {
  font-size: 14px;
  margin-right: 5px;
}

.project .actions a:hover, .project .actions a:focus, .project .actions a:active {
  text-decoration: none;
} 
</style>
