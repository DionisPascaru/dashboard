<template>
    <div class="view-content">
        <div class="ds-block bg-light">
            <organization-search-filter-component @search-filters="handleSearch"
                                                  :options="options">
            </organization-search-filter-component>
        </div>

        <div class="ds-block bg-light">
            <div class="ds-pagination">
                <el-pagination
                    class="ds-pagination-buttons"
                    layout="prev, pager, next"
                    @current-change="handlePagination"
                    :total="organizations.total"
                    :current-page="options.pageNum">
                </el-pagination>
                <div>
                    <h4>Totals: {{ organizations.total }}</h4>
                </div>
            </div>
            <div class="view-content">
                <el-table
                    class="table"
                    :data="organizations.items"
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
                        label="Actions"
                        width="280">
                        <template slot-scope="scope">
                            <div class="d-flex flex-gap">
<!--                                <router-link :to="{ name: 'ClientUpdateView', params: { id: scope.row.id }}">-->
<!--                                    <el-button class="btn btn-info" type="info" icon="el-icon-edit"></el-button>-->
<!--                                </router-link>-->
                                <el-button class="btn btn-danger" type="danger" @click="deleteOrganization(scope.row)">
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
                    :total="organizations.total"
                    :current-page="options.pageNum">
                </el-pagination>
                <div>
                    <h4>Totals: {{ organizations.total }}</h4>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import OrganizationSearchFilterComponent from "../../components/organizations/OrganizationSearchFilterComponent.vue";

export default {
    name: 'Organizations',
    components: {OrganizationSearchFilterComponent},
    data() {
        return {
            loading: true,
            options: {
                filters: {
                    name: '',
                    email: '',
                    date_from: null,
                    date_till: null,
                },
                pageSize: 10,
                pageNum: 1
            }
        }
    },
    computed: {
        organizations() {
            return this.$store.getters['organization/getOrganizations'];
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

            this.$store.dispatch('organization/searchOrganizations', this.options)
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
        deleteOrganization(organization) {
            this.$confirm(
                `Are you sure you want to delete organization ${organization.name}?`,
                {
                    title: 'Delete organization',
                    confirmButtonText: "OK",
                    cancelButtonText: "Cancel",
                    type: "warning"
                }
            ).then(() => {
                this.$store.dispatch('organization/deleteOrganization', organization.id)
                    .then(() => {
                        this.$notify({
                            title: 'Success',
                            type: 'success',
                            message: `The ${organization.name} successfully deleted!`
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
