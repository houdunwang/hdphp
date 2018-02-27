import Vue from 'vue'
import hello from './components/hello.vue';
import ucenter from './components/ucenter/ucenter.vue'
require('./bootstrap');
require('./less/hello.less');
import store from './store/index'
const app = new Vue({
    el: '#app',
    store,
    components: {
        hello, ucenter
    }
});