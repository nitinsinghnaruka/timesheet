<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-5">

        <!-- Register -->
        <div class="register">
          <div class="card shadow-sm">
            <div class="card-header text-center">
              <span class="ti-user user-icon"></span>
            </div>
            <div class="card-body">

              <!-- Form -->
              <form method="POST" class="form" @keypress="form.errors.clear(); errorMessage = null;" @submit.prevent="register()">

                <div class="form-text text-danger mb-2 text-center" v-if="errorMessage">{{ errorMessage }}</div>

                <div class="form-group">
                  <input type="text" class="form-control" id="name" placeholder="Name" v-model="form.name">
                  <small id="nameHelp" class="form-text text-danger" v-if="form.errors.has('name')">{{ form.errors.get('name') }}</small>
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" id="email" placeholder="Email" v-model="form.email">
                  <small id="emailHelp" class="form-text text-danger" v-if="form.errors.has('email')">{{ form.errors.get('email') }}</small>
                </div>
                <div class="form-group">
                  <input type="password" class="form-control" id="password" placeholder="Password" v-model="form.password">
                  <small id="passwordHelp" class="form-text text-danger" v-if="form.errors.has('password')">{{ form.errors.get('password') }}</small>
                </div>
                <div class="form-group">
                  <input type="password" class="form-control" id="password_confirmation" placeholder="Confirm Password" v-model="form.password_confirmation">
                  <small id="passwordConfirmationHelp" class="form-text text-danger" v-if="form.errors.has('password_confirmation')">{{ form.errors.get('password_confirmation') }}</small>
                </div>
                <div class="text-right">
                  <button type="submit" class="btn btn-warning shadow-sm" :disabled="loading" v-text="loading ? 'Registering...' : 'Register'"></button>
                </div>
                <div class="text-center mt-3">
                  <div class="text-muted">or</div>
                  <router-link to="login" class="login-link">Already have an account?</router-link>
                </div>

              </form>
              <!--/ Form -->

            </div>
          </div>
        </div>
        <!--/ Register -->

      </div>
    </div>
  </div>    
</template>

<script>
export default {
  data () {
    return {
      loading: false,
      errorMessage: null,
      form: new Form({
        name: null,
        email: null,
        password: null,
        password_confirmation: null,
      })
    } 
  },
  methods: {
    /**
     * Register
     */
    register () {
      this.loading = true;

      this.form.submit('post', 'register')
        .then((response) => {
          let data = response.data;

          if (data.status == true) {
            // Store auth data
            Auth.store(data.token, data.user);
            //----------------

            // Store login user state
            store.commit('loginUser');
            //-----------------------

            // Redirect to home
            this.$router.push('/');
            //-----------------

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
  }  
}
</script>

<style scoped>
.register {   
  margin: 40% auto;
}

.register .card {
  border: none;
}

.register .card .card-header {
  background-color: #ffffff;
  border: none;
  padding-top: 25px; 
}

.register .card .card-header .user-icon {
  font-size: 32px;
  color: #888;
}

.register .card .card-body {
  padding: 0 40px 40px 40px;
}

.register .form .form-control {
  border: none;
  color: #333333;
  outline: none;
  height: 40px;
  box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
}

.register .form .form-control:focus {
  outline: none;
  box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
}

.register .login-link {
  color: dimgrey;
}
</style>
