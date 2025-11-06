import Clients from "../../view/clients/Clients.vue";
import ClientUpdateView from "../../view/clients/ClientUpdateView.vue";
import ClientCreateModalComponent from "../../components/clients/ClientCreateModalComponent.vue";

export default [
    {
        path: 'clients',
        component: Clients,
        name: 'Clients',
        meta: {
            guard: 'auth',
            viewTitle: 'Clients',
            pageOptions: [
                ClientCreateModalComponent,
            ],
            breadcrumbs: [
                {
                    text: 'Clients',
                    name: 'Clients',
                },
            ]
        },
    },
    {
        path: 'clients/:id/edit',
        component: ClientUpdateView,
        name: 'ClientUpdateView',
        meta: {
            viewTitle: 'Edit client',
            breadcrumbs: [
                {
                    text: 'Clients',
                    name: 'Clients'
                },
                {
                    text: 'Edit client',
                    name: null,
                }
            ]
        }
    }
]
