<template>
  <div>

    <!-- Edit project modal -->
    <div class="modal fade" id="editProjectModal" tabindex="-1" role="dialog" ref="editProjectModal">
      <div class="modal-dialog" role="document">
        <form @submit.prevent="updateProject()">
          <div class="modal-content">
            <modal-loader :show="loading"></modal-loader>

            <div class="modal-header shadow-sm">
              <h5 class="modal-title"><span class="ti-write"></span> Edit Project</h5>
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
              <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" v-model="form.description"></textarea>
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary shadow-sm"><span class="ti-save"></span> Update</button>
            </div>
          </div>
        </form>
      </div>
    </div>
    <!--/ Edit project modal -->

  </div>

</template>

<script>
export default {
  data () {
    return {
      loading: false,
      project: null,
      form: new Form({
        name: null,
        description: null
      })
    }
  },
  methods: {
    /**
     * Edit project.
     */
    editProject () {
      // Set form data
      this.form.name        = this.project.name;
      this.form.description = this.project.description;
      //--------------

      // Show edit project modal
      $(this.$refs.editProjectModal).modal('show');
      //------------------------
    },

    /**
     * Update project.
     */
    updateProject () {
      // Show loading
      this.loading = true;
      //-------------

      this.form.submit('put', `projects/${this.project.id}`)
        .then((response) => {
          let data = response.data;

          if (data.status == true) {
            // Reset project
            this.project = data.project;
            //--------------

            // Emit project updated event
            this.$eventBus.$emit('projectUpdated', data.project);
            //---------------------------

            // Hide modal
            $(this.$refs.editProjectModal).modal('hide');
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
    // Listen to edit project event
    this.$eventBus.$on('editProject', (project) => {
      // Set project
      this.project = project;
      //------------

      // Call edit project
      this.editProject();
      //------------------ 
    });
    //-----------------------------
  }
}
</script>

<style scoped>
.card .bottom {
  font-size: 14px;
}
</style>
