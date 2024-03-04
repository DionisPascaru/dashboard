<template>
    <div>
        <div class="view-title">
            <h1>Projects</h1>
            <router-link :to="{ name: 'ProjectCreateView'}">
                <el-button class="btn btn-primary" type="primary">Add project</el-button>
            </router-link>
            <project-category-create-component></project-category-create-component>
        </div>

        <div class="ds-block bg-light">
            <projects-search-component @search-filters="handleSearch" :options="options"></projects-search-component>
        </div>

        <div class="ds-block bg-light">
            <div class="ds-pagination">
                <el-pagination
                    class="ds-pagination-buttons"
                    layout="prev, pager, next"
                    @current-change="handlePagination"
                    :total="projects.total"
                    :current-page="options.pageNum">
                </el-pagination>
                <div>
                    <h4>Totals: {{ projects.total }}</h4>
                </div>
            </div>
            <div class="view-content">
                <el-table
                    class="table"
                    :data="projects.items"
                    v-loading="loading"
                    style="width: 100%">
                    <el-table-column
                        prop="cover"
                        label="Cover"
                        width="180">
                        <template slot-scope="scope">
                            <el-image
                                style="width: 100px; height: 100px"
                                :src="scope.row.cover.url"
                                fit="fit">
                            </el-image>
                        </template>
                    </el-table-column>
                    <el-table-column
                        prop="title"
                        label="Title">
                    </el-table-column>
                    <el-table-column
                        prop="category"
                        label="Category">
                    </el-table-column>
                    <el-table-column
                        prop="created"
                        label="Created">
                    </el-table-column>
                    <el-table-column
                        prop="updated"
                        label="Updated">
                    </el-table-column>
                    <el-table-column label="Actions">
                        <template slot-scope="scope">
                            <router-link :to="{ name: 'ProjectUpdateView', params: { id: scope.row.id } }">
                                <el-button class="btn btn-default">Update project</el-button>
                            </router-link>
                            <el-button class="btn btn-danger" type="danger" @click="deleteProject(scope.row)">
                                Delete
                            </el-button>
                        </template>
                    </el-table-column>
                </el-table>
            </div>
            <div class="ds-pagination">
                <el-pagination
                    class="ds-pagination-buttons"
                    layout="prev, pager, next"
                    @current-change="handlePagination"
                    :total="projects.total"
                    :current-page="options.pageNum">
                </el-pagination>
                <div>
                    <h4>Totals: {{ projects.total }}</h4>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import config from "../../config";
import ProjectsSearchComponent from "../../components/projects/ProjectsSearchComponent.vue";
import ProjectCategoryCreateComponent from "../../components/projects/ProjectCategoryCreateComponent.vue";

export default {
    name: 'Projects',
    components: {
        ProjectCategoryCreateComponent,
      ProjectsSearchComponent
    },
    data() {
        return {
            loading: true,
            path: config.path,
            options: {
                filters: {
                    title: '',
                    category_id: null,
                    date_from: null,
                    date_till: null,
                },
                pageSize: 10,
                pageNum: 1
            }
        }
    },
    computed: {
        projects() {
            return this.$store.getters['project/getProjects'];
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

            this.$store.dispatch('project/searchProjects', this.options)
                .then(() => {
                })
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
        deleteProject(project) {
            this.$confirm(
                `Are you sure you want to delete project ${project.title}?`,
                {
                    title: 'Delete project',
                    confirmButtonText: "OK",
                    cancelButtonText: "Cancel",
                    type: "warning"
                }
            ).then(() => {
                this.$store.dispatch('project/deleteProject', project.id)
                    .then(() => {
                        this.$notify({
                            title: 'Success',
                            type: 'success',
                            message: `The ${project.title} successfully deleted!`
                        });
                        this.search();
                    })
                    .catch(e => {
                        this.$notify.error({
                            title: 'Error',
                            message: e
                        });
                    });
            }).catch(() => {});
        }
    }
}
</script>
