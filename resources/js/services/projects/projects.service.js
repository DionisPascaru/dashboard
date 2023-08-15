import httpRequest from "../httpRequest";
import id from "element-ui/src/locale/lang/id";

const loadProjects = () => {
    return httpRequest.get('/projects');
}

const loadProject = (id) => {
    return httpRequest.get(`/project/${id}`);
}

const createProject = (payload) => {
    return httpRequest.post('/project', payload);
}

const updateProject = (id, payload) => {
    return httpRequest.post(`/project/${id}`, payload);
}

const deleteProject = (id) => {
    return httpRequest.delete(`/project/${id}`);
}

export {
    loadProjects,
    loadProject,
    createProject,
    updateProject,
    deleteProject,
}
