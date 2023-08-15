import {loadProject, loadProjects, createProject, updateProject, deleteProject} from "../services/projects/projects.service";

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
    async loadProjects({commit}) {
        try {
            const response = await loadProjects();
            commit('LOAD_PROJECTS', response);
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
            const response = await createProject(payload);
            commit('CREATE_PROJECT', response);
        } catch (e) {
            throw e;
        }
    },
    async updateProject({commit}, {id, project}) {
        try {
            const response = await updateProject(id, project);
            commit('UPDATE_PROJECT', response);
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
    }
};

const mutations = {
    LOAD_PROJECTS(state, projects) {
        state.projects = projects;
    },
    LOAD_PROJECT(state, project) {
        state.project = project;
    },
    CREATE_PROJECT(state, project) {
        state.projects.push(project);
    },
    UPDATE_PROJECT(state, project) {
      const index = state.projects.findIndex(item => item.id === project.id);

      if (index !== -1) {
          state.projects.splice(index, 1, project);
      }
    },
    DELETE_PROJECT(state, projectId) {
        const index = state.projects.findIndex((project) => project.id === projectId);

        if (index !== -1) {
            state.projects.slice(index, 1);
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
