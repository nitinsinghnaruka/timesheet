import VueIziToast from 'vue-izitoast';
import 'izitoast/dist/css/iziToast.min.css';

const Helpers = {};

Helpers.install = function (Vue, options) {
  
  Vue.use(VueIziToast);

  /**
   * Check given value is empty or not.
   * 
   * @param   {*|null}  value
   * @returns {boolean}
   */
  Vue.prototype.$isEmpty = function (value = null) {
    if (value) {
      if (typeof value == 'object') {
        return Object.keys(value).length == 0;
      } else if (Array.isArray(value)) {
        return value.length == 0;
      }
    }

    return true;
  }

  /**
   * Toast.
   * 
   * @param {string}    type
   * @param {string}    message
   * @param {*|object}  options
   */
  Vue.prototype.$showToast = function (type, message, options = {}) {
    let icon = null;

    // Set icon
    if (type == 'success') {
      icon = 'ti-check';
    } else if (type == 'warning') {
      icon = 'ti-info-alt';
    } else if (type == 'error') {
      icon = 'ti-close';
    }
    //---------

    // Set default options
    options.position    = 'bottomCenter';
    options.icon        = icon;
    options.drag        = false;
    options.progressBar = false;
    //--------------------

    // Show toast
    this.$toast[type](message, '', options);
    //-----------
  } 
}

export default Helpers;
