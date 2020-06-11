require('./bootstrap');
window.Vue = require('vue');

import VModal from './modules/vue-modal'
import Element from 'element-ui'
import locale from 'element-ui/lib/locale/lang/ru-RU'
import 'element-ui/lib/theme-chalk/index.css'

import VueI18n from 'vue-i18n'

Vue.use(VueI18n);


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

const defaultImpl = VueI18n.prototype.getChoiceIndex

VueI18n.prototype.getChoiceIndex = function (choice, choicesLength) {
    if (this.locale !== 'ru') {
        return defaultImpl.apply(this, arguments)
    }

    if (choice === 0) {
        return 0;
    }

    const teen = choice > 10 && choice < 20;
    const endsWithOne = choice % 10 === 1;

    if (!teen && endsWithOne) {
        return 1;
    }

    if (!teen && choice % 10 >= 2 && choice % 10 <= 4) {
        return 2;
    }

    return (choicesLength < 4) ? 2 : 3;
}


const messages = {
    ru: {
        days: 'дней | день | дня | дней',
        hours: 'часов | час | часа | часов',
        minutes: 'минут | минута | минуты | минут',
        seconds: 'секунд | секунда | секунды | секунд'
    }
}

const i18n = new VueI18n({
    locale: 'ru',
    messages
});



const app = new Vue({
    el: '#app',
    i18n
});
