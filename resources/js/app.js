require('./bootstrap');
window.Vue = require('vue');

import VModal from './modules/vue-modal'
import Element from 'element-ui'
import locale from 'element-ui/lib/locale/lang/ru-RU'
import 'element-ui/lib/theme-chalk/index.css'


import Vue from 'vue';
import VueSweetalert2 from 'vue-sweetalert2';

// If you don't need the styles, do not connect
import 'sweetalert2/dist/sweetalert2.min.css';




const options = {
    confirmButtonColor: '#e164be',
    cancelButtonColor: '#FF985E ',
};

Vue.use(VueSweetalert2, options);

import VueClipboard from 'vue-clipboard2'
Vue.use(VueClipboard)

Vue.use(VModal, { dynamic: true, injectModalsContainer: true });
Vue.use(Element, { locale });

import VueCountdown from '@chenfengyuan/vue-countdown';

Vue.component(VueCountdown.name, VueCountdown);
Vue.component('modal-skeleton', require('./components/common/ModalSkeleton.vue').default);
Vue.component('button-activation', require('./components/common/ButtonActivation').default);
Vue.component('button-details', require('./components/common/ButtonDetails').default);
Vue.component('popuploader', require('./components/common/BuyPopupLoader.vue').default);
Vue.component('scrollto', require('./components/common/ScrollToComponent.vue').default);

/**
* Admin components
*/
Vue.component('admin-service-table', require('./components/admin/ServiceTable.vue').default);
Vue.component('admin-managers-table', require('./components/admin/AdminManagersTable.vue').default);

/**
 * Manager components
 */
 Vue.component('manager-service-table', require('./components/manager/ServiceTable.vue').default);
 Vue.component('manager-clients-table', require('./components/manager/ClientsTable.vue').default);

/**
 * Client components
 */
Vue.component('client-area', require('./components/client/ClientArea').default);

Vue.prototype.$showModal = function (component, props, width = 680, events) {
    this.$modal.show(component, props, {
        width: width,
        height: 'auto',
        scrollable: true,
        adaptive: true,
        clickToClose: true,
        transition: 'nice-modal-fade'
    }, events);
};


// pluralization ==========

Vue.prototype.$plur = function (n, titles) {
    return titles[(n % 10 === 1 && n % 100 !== 11) ? 0 : n % 10 >= 2 && n % 10 <= 4 && (n % 100 < 10 || n % 100 >= 20) ? 1 : 2]
};

Vue.prototype.$plurString = {
    days: ['????????', '??????', '????????'],
    hours: ['??????', '????????', '??????????'],
    minutes: ['????????????', '????????????' , '??????????'],
    seconds: ['??????????????', '??????????????', '????????????']
}


const app = new Vue({
    el: '#app',
});
