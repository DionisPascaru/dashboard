import {
    searchProjects,
    loadProject,
    createProject,
    updateProject,
    deleteProject,
    fileUpload,
    imageUpload,
    imageRemove,
} from "../services/projects/projects.service";

const state = () => ({
    projects: [],
    project: {}
})

const getters = {
    getProjects(state) {
        return state.projects
    },
    getProject(state) {
        return state.project
    }
}

const actions = {
    async searchProjects({commit}, payload) {
        try {
            const response = await searchProjects(payload);
            commit('SEARCH_PROJECTS', response);
        } catch (e) {
            throw e;
        }
    },
    async loadProject({commit}, projectId) {
        try {
            const response = await loadProject(projectId);
            commit('LOAD_PROJECT', response);
        } catch (e) {
            throw e;
        }
    },
    async createProject({commit}, payload) {
        try {
            await createProject(payload);
        } catch (e) {
            throw e;
        }
    },
    async updateProject({commit}, {id, project}) {
        try {
            await updateProject(id, project);
        } catch (e) {
            throw e;
        }
    },
    async deleteProject({commit}, projectId) {
        try {
            await deleteProject(projectId);
            commit('DELETE_PROJECT', projectId);
        }catch (e) {
            throw e;
        }
    },
    async fileUpload({commit}, {id, payload}) {
        try {
            await fileUpload(id, payload);
        } catch (e) {
            throw e;
        }
    },
    async imageUpload({commit}, {id, payload}) {
        try {
            await imageUpload(id, payload);
        } catch (e) {
            throw e;
        }
    },
    async imageRemove({commit}, imageId) {
        try {
            await imageRemove(imageId);
        } catch (e) {
            throw e;
        }
    }
};

const mutations = {
    SEARCH_PROJECTS(state, projects) {
        state.projects = projects;
    },
    LOAD_PROJECT(state, project) {
        state.project = project;
    },
    DELETE_PROJECT(state, projectId) {
        const index = state.projects.items.findIndex((project) => project.id === projectId);

        if (index !== -1) {
            state.projects.items.slice(index, 1);
        }
    }
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations,
}
