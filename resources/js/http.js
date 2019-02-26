import store from './store';

const axios = require('axios');

// Set axios default headers
let token = document.head.querySelector('meta[name="csrf-token"]');
//--------------------------

// Create an instance
const instance = axios.create({
  baseURL: 'http://timesheet.local/api/',
  headers: {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': token ? token.content : null
  }
});
//-------------------

// Request interceptors.
instance.interceptors.request.use(function (config) {
  // Set authorization token
  let token = store.state.auth.token;

  if (token) {
    config.headers.Authorization = `Bearer ${token}`;
  }
  //------------------------

  return config;
}, function (error) {
  return Promise.reject(error);
});

// Response interceptors
instance.interceptors.response.use(function (response) {
  return response;
}, function (error) {
  return Promise.reject(error);
});
//----------------------

export default instance;
