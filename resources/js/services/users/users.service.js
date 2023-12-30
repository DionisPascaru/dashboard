import httpRequest from "../httpRequest";

const searchUsers = (payload) => {
    return httpRequest.post('/users/search', payload);
}

const loadUser = (id) => {
    return httpRequest.get(`/user/${id}`);
}

const createUser = (user) => {
    return httpRequest.post('/user', user);
}

const updateUser = (id, user) => {
    return httpRequest.put(`/user/${id}`, user);
}

const deleteUser = (id) => {
    return httpRequest.delete(`/user/${id}`);
}

const userRoles = () => {
    return httpRequest.get('/roles');
}

export {
    searchUsers,
    loadUser,
    createUser,
    updateUser,
    deleteUser,
    userRoles,
}
