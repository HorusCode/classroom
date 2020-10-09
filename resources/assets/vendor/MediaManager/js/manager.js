/*                Libs                */
import Vue2Filters from 'vue2-filters'
import VueClipboard from 'vue-clipboard2'

Vue.use(Vue2Filters)
Vue.use(VueClipboard)
Vue.use(require('vue-ls'))
window.EventHub = require('vuemit')
window.keycode = require('keycode')
window.Fuse = require('fuse.js')



// v-touch
let VueTouch = require('vue-touch')
VueTouch.registerCustomEvent('dbltap', {type: 'tap', taps: 2})
VueTouch.registerCustomEvent('hold', {type: 'press', time: 500})
Vue.use(VueTouch)





// vue-awesome
require('./modules/icons')
Vue.component('icon', require('vue-awesome/components/Icon').default)
Vue.component('iconTypes', require('./components/utils/icon-types.vue').default)

/*                Components                */
Vue.component('MediaManager', require('./components/manager.vue').default)
Vue.component('MyNotification', require('vue-notif').default)
Vue.component('MyDropdown', require('./components/utils/dropdown.vue').default)

/*                Events                */
if ('connection' in navigator) {
    if (!navigator.connection.saveData) {
        require('./modules/events')
    }
}
