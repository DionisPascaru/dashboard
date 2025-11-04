import Vuex from 'vuex'
import auth from './auth.module'
import user from './user.module'
import project from './project.module'
import projectCategories from "./project-categories.module";
import client from './clients/client.module';
import Vue from "vue";

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        auth,
        user,
        project,
        projectCategories,
        client,
    }
})
