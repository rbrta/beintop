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

Vue.use(VModal, { dynamic: true, injectModalsContainer: true });
Vue.use(Element, { locale });

import VueCountdown from '@chenfengyuan/vue-countdown';

Vue.component(VueCountdown.name, VueCountdown);
Vue.component('modal-skeleton', require('./components/common/ModalSkeleton.vue').default);
Vue.component('service-table', require('./components/admin/ServiceTable.vue').default);
Vue.component('button-activation', require('./components/common/ButtonActivation').default);
Vue.component('button-details', require('./components/common/ButtonDetails').default);

/**
 * Client components
 */
Vue.component('client-orders', require('./components/client/Orders').default);

Vue.prototype.$showModal = function(component, props, width = 680, events) {
    this.$modal.show(component, props, {
        width: width,
        height: 'auto',
        scrollable: true,
        adaptive: true,
        clickToClose: true,
        transition: 'nice-modal-fade'
    }, events);
};



const app = new Vue({
    el: '#app'
});
