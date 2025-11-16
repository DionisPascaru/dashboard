import httpRequest from "../httpRequest";

const searchOrganizations = (payload) => {
    return httpRequest.post('/organizations/search', payload);
}

const readOrganization = (id) => {
    return httpRequest.get(`/organizations/${id}`);
}

const createOrganization = (organization) => {
    return httpRequest.post('/organizations', organization);
}

const updateOrganization = (id, organization) => {
    return httpRequest.put(`/organizations/${id}`, organization);
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
