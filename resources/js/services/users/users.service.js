import httpRequest from "../httpRequest";

const loadUsers = () => {
    return httpRequest.get('/users');
}

const loadUser = (id) => {
    return httpRequest.get(`/user/${id}`);
}

const deleteUser = (id) => {
    return httpRequest.delete(`/user/${id}`);
}

export {
    loadUsers,
    loadUser,
    deleteUser
}
