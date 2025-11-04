import Login from '../view/auth/Login';
import Register from '../view/auth/Register.vue';
import Dashboard from '../view/Dashboard';
import Home from '../view/Home';
import Users from '../view/users/Users';
import UserUpdateView from '../view/users/UserUpdateView.vue';
import Projects from '../view/projects/Projects';
import ProjectCreateView from '../view/projects/ProjectCreateView.vue';
import ProjectUpdateView from "../view/projects/ProjectUpdateView.vue";
import ProfileView from "../view/profile/ProfileView.vue";
import Error from '../view/Error';
import Clients from "../view/clients/Clients.vue";

export default [
    {
        path: '/',
        name: 'Home',
        redirect: { name: 'Login' },
        component: Home,
        meta: {
            guard: "guest"
        },
        children: [
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
        ]
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
            {
                path: '/users',
                component: Users,
                name: 'Users',
                meta: {
                    guard: 'auth'
                }
            },
            {
                path: '/user/:id/update',
                component: UserUpdateView,
                name: 'UserUpdateView',
                meta: {
                    guard: 'auth'
                }
            },
            {
                path: '/projects',
                component: Projects,
                name: 'Projects',
                meta: {
                    guard: 'auth'
                }
            },
            {
                path: '/projects/create',
                component: ProjectCreateView,
                name: 'ProjectCreateView',
                meta: {
                    guard: 'auth'
                }
            },
            {
                path: '/projects/:id/update',
                component: ProjectUpdateView,
                name: 'ProjectUpdateView',
                meta: {
                    guard: 'auth'
                }
            },
            {
                path: '/profile',
                component: ProfileView,
                name: 'ProfileView',
                meta: {
                    guard: 'auth'
                }
            },
            {
                path: '/clients',
                component: Clients,
                name: 'Clients',
                meta: {
                    guard: 'auth'
                }
            },
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
