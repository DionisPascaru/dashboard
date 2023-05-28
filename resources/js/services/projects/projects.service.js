import httpRequest from "../httpRequest";

const loadProjects = () => {
    return httpRequest.get('/projects');
}

const loadProject = (id) => {
    return httpRequest.get(`/project/${id}`);
}

const createProject = (payload) => {
    return httpRequest.post('/project', payload);
}

const deleteProject = (id) => {
    return httpRequest.delete(`/project/${id}`);
}

export {
    loadProjects,
    loadProject,
    createProject,
    deleteProject,
}
