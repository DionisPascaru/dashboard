import httpRequest from "../httpRequest";

const loadProjectCategories = () => {
    return httpRequest.get('/project-categories');
}

export {
    loadProjectCategories
}
