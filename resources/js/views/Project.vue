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
                    <a href="#" class="text-primary"><span class="ti-write"></span> Edit</a>
                    <a href="#" class="text-danger" v-if="$isEmpty(project.task_lists)"><span class="ti-trash"></span> Delete</a>
                  </div>
                  </div>
                </div>
              </div>
            </div>
            <!--/ Project detail -->

            <!-- Task List -->
            <div class="row">
              <div class="col-md-12">
                <task-list :task-lists="taskLists"></task-list>
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

    <!-- Add project -->
    <!-- <add-project></add-project> -->
    <!--/ Add project -->

  </div>

</template>

<script>
import BaseLayout from './BaseLayout.vue';
import TaskList from '../components/TaskList.vue';

export default {
  components: {
    BaseLayout,
    TaskList
  },
  data () {
    return {
      loading: false,
      project: null,
      taskLists: []
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
          this.project   = data.project;
          this.taskLists = data.project.task_lists;
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
     * Set project.
     * 
     * @param {object}  project
     */
    setProject (project) {
      this.projects.unshift(project);
    }
  },
  created () {
    // Listen to project stored event
    this.$eventBus.$on('projectStored', (project) => this.setProject(project));
    //-------------------------------
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
