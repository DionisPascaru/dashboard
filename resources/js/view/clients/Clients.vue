<template>
    <div class="view-content">
        <div class="ds-block bg-light">
            <client-search-filter-component
                @search-filters="handleSearch"
                :options="options">
            </client-search-filter-component>
        </div>

        <div class="ds-block bg-light">
            <div class="ds-pagination">
                <el-pagination
                    class="ds-pagination-buttons"
                    layout="prev, pager, next"
                    @current-change="handlePagination"
                    :total="clients.total"
                    :current-page="options.pageNum">
                </el-pagination>
                <div>
                    <h4>Totals: {{ clients.total }}</h4>
                </div>
            </div>
            <div class="view-content">
                <el-table
                    class="table"
                    :data="clients.items"
                    v-loading="loading"
                    style="width: 100%">
                    <el-table-column
                        prop="name"
                        label="Name"
                        width="180">
                    </el-table-column>
                    <el-table-column
                        prop="email"
                        label="Email">
                    </el-table-column>
                    <el-table-column
                        prop="created_at"
                        label="Created">
                    </el-table-column>
                    <el-table-column
                        prop="updated_at"
                        label="Updated">
                    </el-table-column>
                    <el-table-column
                        label="Status">
                        <template slot-scope="scope">
                            <div class="ds-status" :class="`ds-status-${scope.row.status.value}`">
                                {{ scope.row.status.name }}
                            </div>
                        </template>
                    </el-table-column>
                    <el-table-column
                        label="Actions"
                        width="280">
                        <template slot-scope="scope">
                            <div class="d-flex flex-gap">
                                <router-link :to="{ name: 'ClientUpdateView', params: { id: scope.row.id }}">
                                    <el-button class="btn btn-info" type="info" icon="el-icon-edit"></el-button>
                                </router-link>
                                <el-button class="btn btn-danger" type="danger" @click="deleteClient(scope.row)">
                                    Delete
                                </el-button>
                            </div>
                        </template>
                    </el-table-column>
                </el-table>
            </div>
            <div class="ds-pagination">
                <el-pagination
                    class="ds-pagination-buttons"
                    layout="prev, pager, next"
                    @current-change="handlePagination"
                    :total="clients.total"
                    :current-page="options.pageNum">
                </el-pagination>
                <div>
                    <h4>Totals: {{ clients.total }}</h4>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import ClientSearchFilterComponent from "../../components/clients/ClientSearchFilterComponent.vue";
import ClientCreateModalComponent from "../../components/clients/ClientCreateModalComponent.vue";

export default {
    name: 'Clients',
    components: {
        ClientCreateModalComponent,
        ClientSearchFilterComponent
    },
    data() {
        return {
            loading: true,
            options: {
                filters: {
                    name: '',
                    email: '',
                    role_id: null,
                    date_from: null,
                    date_till: null,
                },
                pageSize: 10,
                pageNum: 1
            }
        }
    },
    computed: {
        clients() {
            return this.$store.getters['client/getClients'];
        }
    },
    mounted() {
        this.search(this.options);
    },
    methods: {
        handlePagination(val) {
            this.options.pageNum = val;
            this.search();
        },
        handleSearch(options) {
            this.options = options;
            this.options.pageSize = 10;
            this.options.pageNum = 1;
            this.search();
        },
        search() {
            this.loading = true;

            this.$store.dispatch('client/searchClients', this.options)
                .then(() => {})
                .catch((e) => {
                    this.$notify.error({
                        title: 'Error',
                        message: e
                    });
                })
                .finally(() => {
                    this.loading = false;
                })
        },
        deleteClient(client) {
            this.$confirm(
                `Are you sure you want to delete client ${client.name}?`,
                {
                    title: 'Delete client',
                    confirmButtonText: "OK",
                    cancelButtonText: "Cancel",
                    type: "warning"
                }
            ).then(() => {
                this.$store.dispatch('client/deleteClient', client.id)
                    .then(() => {
                        this.$notify({
                            title: 'Success',
                            type: 'success',
                            message: `The ${client.name} successfully deleted!`
                        });
                        this.search();
                    })
                    .catch(e => {
                        this.$notify.error({
                            title: 'Error',
                            message: e
                        });
                    });
            })
        }
    }
}
</script>

<style scoped lang="scss">

</style>
