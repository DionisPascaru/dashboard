import Login from '../view/auth/Login';
import ExampleComponent from "../components/ExampleComponent";
import Dashboard from "../view/Dashboard";
import Home from "../view/Home";
import Error from "../view/Error";

export default [
    {
        path: '/',
        name: 'Home',
        redirect: {name: 'Login'},
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
        ]
    },
    {
        path: '/dashboard',
        component: Dashboard,
        name: 'Dashboard',
        redirect: { name: 'ExampleComponent' },
        meta: {
            guard: 'auth'
        },
        children: [
            {
                path: '/example',
                component: ExampleComponent,
                name: 'ExampleComponent',
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
