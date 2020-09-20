require('./bootstrap');


import Vuelidate from "vuelidate";
window.Vue = require('vue')
Vue.use(Vuelidate);

Vue.config.debug = true;
Vue.config.devtools = true;


const files = require.context('./', true, /\.vue$/i)
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))


//Add mediamanager
/*require('../assets/vendor/MediaManager/js/manager');*/


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

new Vue({
    el: '#app',
});
