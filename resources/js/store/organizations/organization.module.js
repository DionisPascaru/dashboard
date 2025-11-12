import {
    searchOrganizations,
    createOrganization,
    deleteOrganization,
    updateOrganization, readOrganization
} from "../../services/organizations/organization.service";

const state = () => ({
    organizations: [],
    organization: {},
})

const getters = {
    getOrganizations(state) {
        return state.organizations;
    },
    getOrganization(state) {
        return state.organization;
    },
}

const actions = {
    async searchOrganizations({commit}, payload) {
        try {
            const response = await searchOrganizations(payload);
            commit('SEARCH_ORGANIZATIONS', response);
        } catch (e) {
            throw e;
        }
    },
    async readOrganization({commit}, organizationId) {
        try {
            const response = await readOrganization(organizationId);
            commit('READ_ORGANIZATION', response);
        } catch (e) {
            throw e;
        }
    },
    async createOrganization({commit}, organization) {
        try {
            const response = await createOrganization(organization);
            commit('CREATE_ORGANIZATION', response);
        } catch (e) {
            throw e;
        }
    },
    async updateOrganization({commit}, {organization}) {
        try {
            await updateOrganization(organization.id, organization);
        } catch (e) {
            throw e;
        }
    },
    async deleteOrganization({commit}, organizationId) {
        try {
            await deleteOrganization(organizationId);
            commit('REMOVE_ORGANIZATION', organizationId);
        } catch (e) {
            throw e;
        }
    },
}

const mutations = {
    SEARCH_ORGANIZATIONS(state, organizations) {
        state.organizations = organizations;
    },
    READ_ORGANIZATION(state, organization) {
        state.organization = organization;
    },
    CREATE_ORGANIZATION(state, organization) {
        state.organizations.items.push(organization);
    },
    REMOVE_ORGANIZATION(state, organizationId) {
        const index = state.organizations.items.findIndex(organization => organization.id === organizationId);

        if (index !== -1) {
            state.organizations.items.slice(index, 1);
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
