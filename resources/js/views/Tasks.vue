<template>
  <div>
    <base-layout>

      <div class="row justify-content-center mb-4">
        <div class="col-md-6">
          <div class="border-bottom pb-3 text-right">
            <a href="#" @click.prevent="$eventBus.$emit('addTask')"><span class="ti-plus"></span> Add task</a>
          </div>
        </div>
      </div>

      <div class="row justify-content-center">
        <div class="col-md-6">
          
          <!-- Tasks list -->
          <div v-if="! $isEmpty(tasks)">
            <div class="row mb-3" v-for="task in tasks" :key="task.id">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-body">
                    <h5 class="card-title">{{ task.name }}</h5>
                    <h6 class="card-subtitle mb-2 text-muted">{{ $moment.utc(task.created_at).fromNow() }}</h6>
                    <p class="card-text" v-if="! $isEmpty(task.description)">{{ task.description }}</p>

                    <div class="row">
                      <div class="col-md-6">
                        <span class="badge badge-pill badge-warning">On Hold</span>
                      </div>
                      <div class="col-md-6">
                        <div class="text-right">

                          <!-- Action links-->
                          <div class="dropdown">
                            <a class="action-links dropdown-toggle" href="#" data-toggle="dropdown">
                              <span class="ti-more"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                              <a class="dropdown-item" href="#">Mark as working</a>
                              <a class="dropdown-item" href="#">Mark as complete</a>
                              <a class="dropdown-item" href="#">Mark as on hold</a>
                            </div>
                          </div>
                          <!--/ Action links-->

                        </div>
                      </div>
                    </div>

                  </div>
                </div>
              </div>
            </div>
          </div>
          <div v-else>
            <div class="text-center">
              <span class="ti-cloud"></span> No tasks.
            </div>
          </div>
          <!--/ Tasks list -->

        </div>
      </div>

    </base-layout>

    <!-- Add task -->
    <add-task></add-task>
    <!--/ Add task -->

  </div>

</template>

<script>
export default {
  components: {
    BaseLayout: require('./BaseLayout.vue').default,
    AddTask: require('../components/AddTask.vue').default
  },
  data () {
    return {
      tasks: []
    }
  },
  methods: {
    /**
     * Get tasks.
     */
    getTasks () {
      axios.get('tasks')
        .then((response) => {
          let data = response.data;

          // Set tasks
          if (data.status == true) {
            this.tasks = data.tasks;
          }
          //----------
        })
        .catch((error) => {
          //
        });
    },

    /**
     * Add task.
     * 
     * @param {object}  task
     */
  },
  created () {
    // Listen to task added event
    this.$eventBus.$on('taskAdded', (task) => this.addTask(task));
    //---------------------------
  },
  mounted () {
    // Get tasks
    this.getTasks();
    //----------
  }
}
</script>

<style scoped>
.action-links.dropdown-toggle::after {
  display: none;
}

.action-links.dropdown-toggle:hover{
  text-decoration: none;
}
</style>
