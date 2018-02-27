import Vue from 'vue'
import Vuex from 'vuex'
import ucenter from './modules/ucenter'

Vue.use(Vuex)
export default new Vuex.Store({
    modules: {ucenter}
})