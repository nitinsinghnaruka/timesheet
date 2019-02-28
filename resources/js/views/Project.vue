<template>
  <div>
    <base-layout>

      <div class="project">
        <div class="row justify-content-center mb-4">
          <div class="col-md-8">
          <div class="border-bottom pb-3 text-right">
            <a href="#" @click.prevent="$eventBus.$emit('addTaskList')" class="mr-3"><span class="ti-plus"></span> Add Task List</a>
            <a href="#" @click.prevent="$eventBus.$emit('addTask')"><span class="ti-plus"></span> Add Task</a>
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
                  <h5 class="card-title"><span class="ti-tag"></span> {{ project.name }}</h5>
                  <p class="card-text ml-1" v-if="project.description">{{ project.description }}</p>
                  <div class="mt-3 actions">
                    <a href="#" class="text-primary" @click.prevent="$eventBus.$emit('editProject', project)"><span class="ti-write"></span> Edit</a>
                    <a href="#" class="text-danger" v-if="$isEmpty(project.task_lists)" @click.prevent="deleteProject(project.id)"><span class="ti-trash"></span> Delete</a>
                  </div>
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

  </div>

</template>

<script>
import BaseLayout from './BaseLayout.vue';
import TaskList from '../components/TaskList.vue';
import EditProjectModal from '../components/EditProjectModal.vue';

export default {
  components: {
    BaseLayout,
    TaskList,
    EditProjectModal
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
    }
  },
  created () {
    // Listen to project updated event
    this.$eventBus.$on('projectUpdated', (project) => this.updateProject(project));
    //--------------------------------
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

.project .actions a {
  font-size: 14px;
  margin-right: 5px;
}
</style>
