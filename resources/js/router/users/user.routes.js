import Users from "../../view/users/Users.vue";
import UserUpdateView from "../../view/users/UserUpdateView.vue";
import UserCreateComponent from "../../components/users/UserCreateComponent.vue";

export default [
    {
        path: 'users',
        component: Users,
        name: 'Users',
        meta: {
            guard: 'auth',
            viewTitle: 'Users',
            pageOptions: [
                UserCreateComponent,
            ],
            breadcrumbs: [
                {
                    text: 'Users',
                    name: 'Users',
                },
            ]
        }
    },
    {
        path: 'user/:id/update',
        component: UserUpdateView,
        name: 'UserUpdateView',
        meta: {
            guard: 'auth',
            viewTitle: 'Edit users',
            breadcrumbs: [
                {
                    text: 'Users',
                    name: 'Users',
                },
                {
                    text: 'Edit user',
                    name: null,
                },
            ]
        }
    },
]
