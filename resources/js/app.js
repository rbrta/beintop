

require('./bootstrap');
window.Vue = require('vue');

import VModal from './modules/vue-modal'
import Element from 'element-ui'
import locale from 'element-ui/lib/locale/lang/ru-RU'
import 'element-ui/lib/theme-chalk/index.css'

Vue.use(VModal, { dynamic: true, injectModalsContainer: true });
Vue.use(Element, { locale });

const app = new Vue({
    el: '#app',
    methods: {
      
    }
});
