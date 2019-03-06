require('./bootstrap');

import router from './routes';
import { VTooltip } from 'v-tooltip';

Vue.directive('tooltip', VTooltip);
Vue.component('Loader', require('./components/Loader.vue').default);
Vue.component('ModalLoader', require('./components/ModalLoader.vue').default);

new Vue({
  el: '#app',
  components: {
    App: require('./views/App').default
  },
  data () {
    return {
      showLoader: false
    }
  },
  router,
  store,
  methods: {
    /**
     * Logout.
     */
    logout () {
      axios.post('/logout')
        .then((response) => {
          let data = response.data;
          
          if (data.status == true) {
            // Clear Auth
            Auth.clear();
            //-----------
                  
            // Commit user logout mutation
            store.commit('logoutUser');
            //----------------------------
            
            // Redirect user to login
            this.$router.push('/login');
            //-----------------------

            // Show message
            this.$showToast('success', data.message);
            //-------------
          } else {
            // Show message
            this.$showToast('error', data.message);
            //-------------
          }
        })
        .catch((error) => {
          //
        });
    },

    /**
     * Unauthorized.
     */
    unauthorized () {
      // Clear Auth
      Auth.clear();
      //-----------
            
      // Commit user logout mutation
      store.commit('logoutUser');
      //----------------------------
      
      // Redirect user to login
      this.$router.push('/login');
      //-----------------------
    }
  },
  created () {
    let _this = this;

    // Response interceptors
    axios.interceptors.response.use(function (response) {
      return response;
    }, function (error) {
      if (error.response.status !== 422) {
        // Listen to response error event
        _this.$showToast('error', error.response.statusText);
        //-------------------------------
      }

      // Call unauthorized
      if (error.response.status == 401) {
        _this.unauthorized();
      }
      //------------------ 

      return Promise.reject(error);
    });
    //----------------------

    // Listen to logout event
    this.$eventBus.$on('logout', () => this.logout());
    //-----------------------
  }
});
