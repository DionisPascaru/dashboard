import Vuex from 'vuex'
import auth from './auth.module'
import user from './user.module'
import Vue from "vue";
Vue.use(Vuex);
export default new Vuex.Store({
    modules: {
        auth,
        user
    }
})
