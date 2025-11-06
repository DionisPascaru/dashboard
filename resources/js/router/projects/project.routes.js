import Projects from "../../view/projects/Projects.vue";
import ProjectCreateView from "../../view/projects/ProjectCreateView.vue";
import ProjectUpdateView from "../../view/projects/ProjectUpdateView.vue";
import ProjectCreateButtonComponent from "../../components/projects/ProjectCreateButtonComponent.vue";

export default [
    {
        path: 'projects',
        component: Projects,
        name: 'Projects',
        meta: {
            guard: 'auth',
            viewTitle: 'Projects',
            pageOptions: [
                ProjectCreateButtonComponent,
            ],
            breadcrumbs: [
                {
                    text: 'Projects',
                    name: 'Projects',
                },
            ]
        }
    },
    {
        path: 'projects/create',
        component: ProjectCreateView,
        name: 'ProjectCreateView',
        meta: {
            guard: 'auth',
            viewTitle: 'Create project',
            breadcrumbs: [
                {
                    text: 'Projects',
                    name: 'Projects',
                },
                {
                    text: 'Create project',
                    name: null,
                },
            ]
        }
    },
    {
        path: 'projects/:id/update',
        component: ProjectUpdateView,
        name: 'ProjectUpdateView',
        meta: {
            guard: 'auth',
            viewTitle: 'Edit projects',
            breadcrumbs: [
                {
                    text: 'Projects',
                    name: 'Projects',
                },
                {
                    text: 'Edit project',
                    name: null,
                },
            ]
        }
    },
]
