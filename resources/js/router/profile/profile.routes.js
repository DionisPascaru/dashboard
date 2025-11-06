import ProfileView from "../../view/profile/ProfileView.vue";

export default [
    {
        path: 'profile',
        component: ProfileView,
        name: 'ProfileView',
        meta: {
            guard: 'auth',
            viewTitle: 'Profile',
            breadcrumbs: [
                {
                    text: 'Profile',
                    name: 'ProfileView',
                },
            ]
        }
    },
]
