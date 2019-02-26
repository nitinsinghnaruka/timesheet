require('./bootstrap');

import router from './routes';

Vue.component('Loader', require('./components/Loader.vue').default);
Vue.component('ModalLoader', require('./components/ModalLoader.vue').default);

new Vue({
  el: '#app',
  components: {
    App: require('./views/App').default
  },
  router,
  store,
  methods: {
    //
  },
  created () {
    let _this = this;

    // Response interceptors
    axios.interceptors.response.use(function (response) {
      return response;
    }, function (error) {
      // Listen to response error event
      _this.$showToast('error', error.response.statusText);
      //-------------------------------

      return Promise.reject(error);
    });
    //----------------------
  }
});
