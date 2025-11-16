import Organizations from "../../view/organizations/Organizations.vue";
import OrganizationUpdateView from "../../view/organizations/OrganizationUpdateView.vue";

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
    {
        path: 'organizations/:id/edit',
        component: OrganizationUpdateView,
        name: 'OrganizationUpdateView',
        meta: {
            viewTitle: 'Edit organization',
            breadcrumbs: [
                {
                    text: 'Organizations',
                    name: 'Organizations'
                },
                {
                    text: 'Edit organization',
                    name: null,
                }
            ]
        }
    }
]
