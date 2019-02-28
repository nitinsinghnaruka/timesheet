<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-5">

        <!-- Login -->
        <div class="login">
          <div class="card shadow-sm">
            <div class="card-header text-center">
              <span class="ti-user user-icon"></span>
            </div>
            <div class="card-body">

              <!-- Form -->
              <form method="POST" class="form" @keypress="form.errors.clear(); errorMessage = null;" @submit.prevent="login()">

                <div class="form-text text-danger mb-2 text-center" v-if="errorMessage">{{ errorMessage }}</div>

                <div class="form-group">
                  <input type="text" class="form-control" id="email" placeholder="Enter email" v-model="form.email">
                  <small id="emailHelp" class="form-text text-danger" v-if="form.errors.has('email')">{{ form.errors.get('email') }}</small>
                </div>
                <div class="form-group">
                  <input type="password" class="form-control" id="password" placeholder="Password" v-model="form.password">
                  <small id="passwordHelp" class="form-text text-danger" v-if="form.errors.has('password')">{{ form.errors.get('password') }}</small>
                </div>
                <div class="text-right">
                  <button type="submit" class="btn btn-success shadow-sm" :disabled="loading" v-text="loading ? 'Logging in...' : 'Login'"></button>
                </div>
                <div class="text-center mt-3">
                  <div class="text-muted">or</div>
                  <router-link to="register" class="create-account-link">Create an account</router-link>
                </div>

              </form>
              <!--/ Form -->

            </div>
          </div>
        </div>
        <!--/ Login -->

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
        email: null,
        password: null
      })
    } 
  },
  methods: {
    /**
     * Login
     */
    login () {
      this.loading = true;

      this.form.submit('post', 'login')
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
.login {   
  margin: 40% auto;
}

.login .card {
  border: none;
}

.login .card .card-header {
  background-color: #ffffff;
  border: none;
  padding-top: 25px; 
}

.login .card .card-header .user-icon {
  font-size: 32px;
  color: #888;
}

.login .card .card-body {
  padding: 0 40px 40px 40px;
}

.login .form .form-control {
  border: none;
  color: #333333;
  outline: none;
  height: 40px;
  box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
}

.login .form .form-control:focus {
  outline: none;
  box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
}

.login .create-account-link {
  color: dimgrey;
}
</style>
