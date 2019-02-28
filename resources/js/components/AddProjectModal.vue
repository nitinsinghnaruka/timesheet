<template>
  <div>

    <!-- Add project modal -->
    <div class="modal fade" id="addProjectModal" tabindex="-1" role="dialog" ref="addProjectModal">
      <div class="modal-dialog" role="document">
        <form @submit.prevent="storeProject()">
          <div class="modal-content">
            <modal-loader :show="loading"></modal-loader>

            <div class="modal-header shadow-sm">
              <h5 class="modal-title"><span class="ti-plus"></span> Add Project</h5>
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
              <button type="submit" class="btn btn-primary shadow-sm"><span class="ti-save"></span> Save</button>
            </div>
          </div>
        </form>
      </div>
    </div>
    <!--/ Add project modal -->

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
     * Add project.
     */
    addProject () {
      // Show add project modal
      $(this.$refs.addProjectModal).modal('show');
      //-----------------------
    },

    /**
     * Store project.
     */
    storeProject () {
      // Show loading
      this.loading = true;
      //-------------

      this.form.submit('post', 'projects')
        .then((response) => {
          let data = response.data;

          if (data.status == true) {
            // Emit project stored event
            this.$eventBus.$emit('projectStored', data.project);
            //--------------------------

            // Hide modal
            $(this.$refs.addProjectModal).modal('hide');
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
    // Listen to add project event
    this.$eventBus.$on('addProject', () => this.addProject());
    //----------------------------
  }
}
</script>

<style scoped>
.card .bottom {
  font-size: 14px;
}
</style>
