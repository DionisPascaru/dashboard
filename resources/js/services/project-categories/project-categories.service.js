import httpRequest from "../httpRequest";

const loadProjectCategories = () => {
    return httpRequest.get('/project-categories');
}

const createProjectCategory = (category) => {
    return httpRequest.post('/project-category', category)
}

export {
    loadProjectCategories,
    createProjectCategory
}
