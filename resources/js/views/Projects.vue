<template>
  <div>
    <base-layout>

      <div class="projects">
        <div class="row justify-content-center mb-4">
          <div class="col-md-8">
            <div class="border-bottom pb-3 text-right">
              <a href="#" @click.prevent="$eventBus.$emit('addProject')"><span class="ti-plus"></span> Add Project</a>
            </div>
          </div>
        </div>

        <div class="row justify-content-center">
          <div class="col-md-8">
            <loader :show="loading"></loader>

            <!-- Projects list -->
            <div v-if="! $isEmpty(projects)">
              <div class="row">
                <div class="col-md-4" v-for="project in projects" :key="project.id">
                  <router-link :to="'/projects/' + project.slug" class="project-link">
                    <div class="card text-center mb-3">
                      <div class="card-body">
                        <h5 class="card-title">{{ project.name }}</h5>
                        <p class="card-text" v-if="project.description">{{ project.description }}</p>
                        <!-- 
                        <div class="mt-3 actions">
                        </div>
                        -->
                      </div>
                    </div>
                  </router-link>
                </div>
              </div>
            </div>
            <div v-else>
              <div class="text-center">
                <span class="ti-cloud"></span> No projects.
              </div>
            </div>
            <!--/ Projects list -->

          </div>
        </div>
      </div>

    </base-layout>

    <!-- Add project modal -->
    <add-project-modal></add-project-modal>
    <!--/ Add project modal -->

  </div>

</template>

<script>
import BaseLayout from './BaseLayout.vue';
import AddProjectModal from '../components/AddProjectModal.vue';

export default {
  components: {
    BaseLayout,
    AddProjectModal
  },
  data () {
    return {
      loading: false,
      projects: []
    }
  },
  methods: {
    /**
     * Get projects.
     */
    getProjects () {
      // Show loading
      this.loading = true;
      //-------------

      axios.get('projects')
       .then((response) => {
         let data = response.data;

         // Set projects
         if (data.status == true) {
           this.projects = data.projects;
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
    // Get projects
    this.getProjects();
    //-------------
  }
}
</script>

<style scoped>
.projects .action-links.dropdown-toggle::after {
  display: none;
}

.projects .action-links.dropdown-toggle:hover {
  text-decoration: none;
}

.projects .project-link, .projects .project-link:hover {
  color: inherit;
  text-decoration: none;
}

.projects .project-link .card {
  box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
}

.projects .project-link:hover .card {
  transition: all 0.7s;
  box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}

.projects .actions a {
  font-size: 12px;
}
</style>
