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
   * @param {string}      type
   * @param {string}      message
   * @param {*|object}    argOptions
   * @param {null|mixed}  callback
   */
  Vue.prototype.$showToast = function (type, message, argOptions = {}, callback = null) {
    let icon            = null;
    let options         = {};
    let defaultOptions  = {};
    let questionOptions = {};
    let progressOptions = {};
    let questionStatus  = undefined;

    // Set icon
    if (type == 'success') {
      icon = 'ti-check';
    } else if (type == 'warning') {
      icon = 'ti-info-alt';
    } else if (type == 'error') {
      icon = 'ti-close';
    } else if (type == 'question') {
      icon = 'ti-alert';
    }
    //---------

    // Set default options
    defaultOptions = {
      position: 'bottomCenter',
      icon: icon,
      drag: false,
      progressBar: false
    };
    //--------------------

    // Set options if type is question
    if (type == 'question') {
      questionOptions = {
        timeout: false,
        close: false,
        overlay: true,
        overlayColor: 'rgba(249, 249, 249, 0.80)',
        toastOnce: true,
        id: 'question',
        zindex: 999,
        buttons: [
          ['<button><b>Yup!</b></button>', function (instance, toast) {
            instance.hide({transitionOut: 'fadeOut'}, toast, 'button');

            questionStatus = true;
          }, true],
          ['<button>Nah</button>', function (instance, toast) {
            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

            questionStatus = false;
          }]
        ],
        onClosed: function () {
          callback(questionStatus);
        }
      };
    }
    //--------------------------------

    // Set options
    Object.assign(options, defaultOptions);
    Object.assign(options, argOptions);
    Object.assign(options, questionOptions);
    Object.assign(options, progressOptions);
    //------------

    // Show toast
    this.$toast[type](message, '', options);
    //-----------
  } 
}

export default Helpers;
