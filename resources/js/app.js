

require('./bootstrap');
window.Vue = require('vue');

import Element from 'element-ui'
import locale from 'element-ui/lib/locale/lang/ru-RU'
import 'element-ui/lib/theme-chalk/index.css'
Vue.use(Element, { locale });

const app = new Vue({
    el: '#app',
    methods: {
        addService() {
            alert("addService");
        }
    }
});
