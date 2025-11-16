import httpRequest from "../httpRequest";

const searchClients = (payload) => {
    return httpRequest.post('/clients/search', payload);
}

const readClient = (id) => {
    return httpRequest.get(`/clients/${id}`);
}

const createClient = (client) => {
    return httpRequest.post('/clients', client);
}

const updateClient = (id, client) => {
    return httpRequest.put(`/clients/${id}`, client);
}

const deleteClient = (id) => {
    return httpRequest.delete(`/clients/${id}`);
}

const readOwnedOrganizations = (id) => {
    return httpRequest.get(`/clients/${id}/organizations`);
}

export {
    searchClients,
    readClient,
    createClient,
    updateClient,
    deleteClient,
    readOwnedOrganizations,
}
