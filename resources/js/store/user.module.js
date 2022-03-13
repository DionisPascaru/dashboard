import {loadUsers, loadUser, deleteUser} from "../services/users/users.service";

const state = () => ({
    users: [],
    user: {}
})

const getters = {
    getUsers(state){
        return state.users;
    },
    getUser(state){
        return state.user;
    }
}

const actions = {
    async loadUsers({commit}){
        try {
            const response = await loadUsers();
            commit('LOAD_USERS', response.data);
        } catch (e) {
            throw e;
        }
    },
    async loadUser({commit}, userId){
        try {
            const response = await loadUser(userId);
            commit('LOAD_USER', response.data);
        } catch (e) {
            throw e;
        }
    },
    async deleteUser({commit}, userId){
        try {
            await deleteUser(userId);
            commit('REMOVE_USER', userId);
        } catch (e) {
            throw e;
        }
    }
}

const mutations = {
    LOAD_USERS(state, users){
        state.users = users;
    },
    LOAD_USER(state, user){
        state.user = user;
    },
    REMOVE_USER(state, userId){
        const index = state.users.findIndex(user => user.id === userId);

        if (index !== -1) {
            state.users.slice(index, 1);
        }
    }
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
