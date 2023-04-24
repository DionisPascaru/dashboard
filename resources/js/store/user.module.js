import {loadUsers, loadUser, createUser, updateUser, deleteUser} from "../services/users/users.service";

const state = () => ({
    users: [],
    user: {}
})

const getters = {
    getUsers(state) {
        return state.users;
    },
    getUser(state) {
        return state.user;
    }
}

const actions = {
    async loadUsers({commit}) {
        try {
            const response = await loadUsers();
            commit('LOAD_USERS', response);
        } catch (e) {
            throw e;
        }
    },
    async loadUser({commit}, userId) {
        try {
            const response = await loadUser(userId);
            commit('LOAD_USER', response);
        } catch (e) {
            throw e;
        }
    },
    async createUser({commit}, user) {
        try {
            const response = await createUser(user);
            commit('CREATE_USER', response);
        } catch (e) {
            throw e;
        }
    },
    async updateUser({commit}, {id, user}) {
        try {
            const response = await updateUser(id, user)
            commit('UPDATE_USER', response);
        } catch (e) {
            throw e;
        }
    },
    async deleteUser({commit}, userId) {
        try {
            await deleteUser(userId);
            commit('REMOVE_USER', userId);
        } catch (e) {
            throw e;
        }
    }
}

const mutations = {
    LOAD_USERS(state, users) {
        state.users = users;
    },
    LOAD_USER(state, user) {
        state.user = user;
    },
    CREATE_USER(state, user) {
        state.users.push(user);
    },
    UPDATE_USER(state, user) {
        const index = state.users.findIndex(item => item.id === user.id);
        if (index !== -1) {
            state.users.splice(index, 1, user);
        }
    },
    REMOVE_USER(state, userId) {
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
