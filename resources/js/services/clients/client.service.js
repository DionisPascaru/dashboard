import httpRequest from "../httpRequest";

const searchClients = (payload) => {
    return httpRequest.post('/clients/search', payload);
}

const readClient = (id) => {
    return httpRequest.get(`/clients/${id}`);
}

const createClient = (user) => {
    return httpRequest.post('/clients', user);
}

const updateClient = (id, user) => {
    return httpRequest.put(`/clients/${id}`, user);
}

const deleteClient = (id) => {
    return httpRequest.delete(`/clients/${id}`);
}

export {
    searchClients,
    readClient,
    createClient,
    updateClient,
    deleteClient,
}
