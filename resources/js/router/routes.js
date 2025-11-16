import Login from '../view/auth/Login';
import Register from '../view/auth/Register.vue';
import Dashboard from '../view/Dashboard';
import Error from '../view/Error';
import clientRoutes from "./clients/client.routes";
import userRoutes from "./users/user.routes";
import projectRoutes from "./projects/project.routes";
import profileRoutes from "./profile/profile.routes";
import organizationRoutes from "./organizations/organization.routes";

export default [
    {
        path: '/login',
        component: Login,
        name: 'Login',
        meta: {
            guard: 'guest'
        }
    },
    {
        path: '/register',
        component: Register,
        name: 'Register',
        meta: {
            guard: 'guest'
        }
    },
    {
        path: '/',
        component: Dashboard,
        name: 'Dashboard',
        redirect: { name: 'Users' },
        meta: {
            guard: 'auth'
        },
        children: [
            ...userRoutes,
            ...projectRoutes,
            ...clientRoutes,
            ...profileRoutes,
            ...organizationRoutes,

        ]
    },
    {
        path: "/forbidden",
        name: "PageForbidden",
        component: Error,
        props: { code: 403 },
    },
    {
        path: "*",
        name: "PageNotFound",
        component: Error,
    },
    {
        path: "/internal-error",
        component: Error,
        props: { code: 500 },
    }
]
