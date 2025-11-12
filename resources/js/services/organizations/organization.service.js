import httpRequest from "../httpRequest";

const searchOrganizations = (payload) => {
    return httpRequest.post('/organizations/search', payload);
}

const readOrganization = (id) => {
    return httpRequest.get(`/organizations/${id}`);
}

const createOrganization = (user) => {
    return httpRequest.post('/organizations', user);
}

const updateOrganization = (id, user) => {
    return httpRequest.put(`/organizations/${id}`, user);
}

const deleteOrganization = (id) => {
    return httpRequest.delete(`/organizations/${id}`);
}

export {
    searchOrganizations,
    readOrganization,
    createOrganization,
    updateOrganization,
    deleteOrganization,
}
