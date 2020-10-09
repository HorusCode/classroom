require('./bootstrap');


import Vuelidate from "vuelidate";
import locale from 'element-ui/lib/locale'
import langRu from 'element-ui/lib/locale/lang/ru-RU'
locale.use(langRu)



window.Vue = require('vue');


Vue.use(Vuelidate);
Vue.config.debug = true;
Vue.config.devtools = true;

// vue-tippy
Vue.use(require('vue-tippy'), {
    popperOptions: {
        modifiers: {
            hide: {enabled: false}
        }
    }
});



const files = require.context('./', true, /\.vue$/i)
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
Vue.component('Filemanager', require('./components/Includes/Filemanager.vue').default)

//Add mediamanager
/*require('../assets/vendor/MediaManager/js/manager');*/





// axios
axios.defaults.headers.common = {
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    'X-Requested-With': 'XMLHttpRequest'
}
axios.interceptors.response.use(
    (response) => response,
    (error) => Promise.reject(error.response)
)

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

new Vue({
    el: '#app',
});
