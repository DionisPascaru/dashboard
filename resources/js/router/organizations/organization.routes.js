import Organizations from "../../view/organizations/Organizations.vue";

export default [
    {
        path: 'organizations',
        component: Organizations,
        name: 'Organizations',
        meta: {
            guard: 'auth',
            viewTitle: 'Organizations',
            breadcrumbs: [
                {
                    text: 'Organizations',
                    name: 'Organizations',
                },
            ]
        },
    },
]
