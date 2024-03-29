import {loadProjectCategories} from "../services/project-categories/project-categories.service";

const state = () => ({
    projectCategories: []
})

const getters = {
    getProjectCategories(state) {
        return state.projectCategories
    }
}

const actions = {
    async loadProjectCategories({commit}){
        try {
            const response = await loadProjectCategories();
            commit('LOAD_PROJECT_CATEGORIES', response);
        } catch (e) {
            throw e;
        }
    }
}

const mutations = {
    LOAD_PROJECT_CATEGORIES(state, projectCategories) {
        state.projectCategories = projectCategories;
    }
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
