
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import moment from 'moment';

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('app', require('./views/App.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
  el: '#app',
  data: {
    counterRunning: false,
    totalSeconds: 0,
    logHours: '00:00:00',
    currentTime: moment().format('h:mm:ss A'),
    calculatedHours: '00:00',
    time: null,
    times: [],
    timeError: null
  },
  methods: {
    /**
     * Update time.
     */
    updateTime: function () {
      setTimeout(function () {
        // Update time
        this.currentTime = moment().format('h:mm:ss A');
        //------------

        // Recall it self
        this.updateTime();
        //---------------
      }.bind(this), 1000);
    },

    /**
     * Start log time.
     */
    startLogTime: function () {
      this.counterRunning = true;

      // Calling counter up
      this.counterUp();
      //-------------------
    },

    /**
     * Stop log time.
     */
    stopLogTime: function () {
      // Store counter
      this.counterRunning = false;
      //--------------
    },

    /**
     * Add time.
     */
    addTime: function () {
      let regex = /^([0-9]{2})\:([0-9]{2})$/;

      if (regex.test(this.time)) {
        // Add time.
        this.times.push(this.time);

        // Calculate hours.
        if (this.calculatedHours != '00:00') {
          let time    = moment(this.calculatedHours, 'HH:mm');
          let hours   = this.time.split(':')[0];
          let minutes = this.time.split(':')[1];

          time.add(hours, 'h'); 
          time.add(minutes, 'm');

          this.calculatedHours = time.format('HH:mm');
        }
        else {
          this.calculatedHours = this.time;
        }

        // Clear input.
        this.time = null;
      } else {
        this.timeError = 'Please enter a valid time format.';
      }
    },

    /**
     * Clear calculated hours.
     */
    clearCalculatedHours: function () {
      this.calculatedHours = '00:00';
      this.times           = [];
    },

    /**
     * Counter up.
     */
    counterUp: function () {
      setTimeout(function () {
          this.totalSeconds += 1;
  
          let seconds = this.pad(this.totalSeconds % 60);
          let minutes = this.pad(parseInt(this.totalSeconds / 60));
          let hours   = this.pad(parseInt(minutes / 60));
  
          this.logHours = hours + ':' + minutes + ':' + seconds;

        // Recall it self
        if (this.counterRunning) {
          this.counterUp();
        }
        //---------------
      }.bind(this), 1000);
    },

    /**
     * Pad.
     * 
     * Pad the given value.
     * @param {*} value 
     */
    pad: function (value) {
      let string = value + '';

      if (string.length < 2) {
        return '0' + string;
      } else {
        return string;
      }
    }
  },
  mounted () {
    // Call update time
    this.updateTime();
    //-----------------
  }
});
