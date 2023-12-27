import httpRequest from "../httpRequest";

const login = (email, password) => {
    return httpRequest.post('/login', { email, password });
}

const authUser = () => {
    return httpRequest.get('/auth-user');
}

export {
    login,
    authUser
}
