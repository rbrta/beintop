require('./bootstrap');
window.Vue = require('vue');

import VModal from './modules/vue-modal'
import Element from 'element-ui'
import locale from 'element-ui/lib/locale/lang/ru-RU'
import 'element-ui/lib/theme-chalk/index.css'

Vue.use(VModal, { dynamic: true, injectModalsContainer: true });
Vue.use(Element, { locale });

Vue.component('modal-skeleton', require('./components/common/ModalSkeleton.vue').default);
Vue.component('service-table', require('./components/admin/ServiceTable.vue').default);


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
