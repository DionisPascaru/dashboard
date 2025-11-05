import {
    searchClients,
    readClient,
    createClient,
    updateClient,
    deleteClient
} from "../../services/clients/client.service";

const state = () => ({
    clients: [],
    client: {},
})

const getters = {
    getClients(state) {
        return state.clients;
    },
    getClient(state) {
        return state.client;
    },
}

const actions = {
    async searchClients({commit}, payload) {
        try {
            const response = await searchClients(payload);
            commit('SEARCH_CLIENTS', response);
        } catch (e) {
            throw e;
        }
    },
    async readClient({commit}, clientId) {
        try {
            const response = await readClient(clientId);
            commit('READ_CLIENT', response);
        } catch (e) {
            throw e;
        }
    },
    async createClient({commit}, client) {
        try {
            const response = await createClient(client);
            commit('CREATE_CLIENT', response);
        } catch (e) {
            throw e;
        }
    },
    async updateClient({commit}, {client}) {
        try {
            console.log(client);
            await updateClient(client.id, client);
        } catch (e) {
            throw e;
        }
    },
    async deleteClient({commit}, clientId) {
        try {
            await deleteClient(clientId);
            commit('REMOVE_CLIENT', clientId);
        } catch (e) {
            throw e;
        }
    },
}

const mutations = {
    SEARCH_CLIENTS(state, clients) {
        state.clients = clients;
    },
    READ_CLIENT(state, client) {
        state.client = client;
    },
    CREATE_CLIENT(state, client) {
        state.clients.items.push(client);
    },
    REMOVE_CLIENT(state, clientId) {
        const index = state.clients.items.findIndex(client => client.id === clientId);

        if (index !== -1) {
            state.clients.items.slice(index, 1);
        }
    },
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
