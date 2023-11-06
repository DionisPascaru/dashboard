import httpRequest from "../httpRequest";

const searchProjects = (payload) => {
    return httpRequest.post('/projects/search', payload);
}

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

const fileUpload = (id, payload) => {
    return httpRequest.post(`/project/${id}/file-upload`, payload);
}

const imageUpload = (id, payload) => {
    return httpRequest.post(`/project/${id}/image-upload`, payload)
}

const imageRemove = (id) => {
    return httpRequest.delete(`/project/${id}/image-remove`);
}

export {
    searchProjects,
    loadProjects,
    loadProject,
    createProject,
    updateProject,
    deleteProject,
    fileUpload,
    imageUpload,
    imageRemove,
}
