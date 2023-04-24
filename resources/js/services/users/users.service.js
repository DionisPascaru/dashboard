import httpRequest from "../httpRequest";

const loadUsers = () => {
    return httpRequest.get('/users');
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

export {
    loadUsers,
    loadUser,
    createUser,
    updateUser,
    deleteUser
}
