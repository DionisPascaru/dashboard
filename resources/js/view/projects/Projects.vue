<template>
    <div>
        <div class="view-title">
            <h1>Projects</h1>
        </div>
        <project-create-component></project-create-component>
        <div class="view-content">
            <el-table
                class="table"
                :data="projects"
                v-loading="loading"
                style="width: 100%">
                <el-table-column
                    prop="cover"
                    label="Cover"
                    width="180">
                    <template slot-scope="scope">
                        <el-image
                            style="width: 100px; height: 100px"
                            :src="`${path}/${scope.row.cover}`"
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
                <el-table-column label="Actions">
                    <template slot-scope="scope">
                        <el-button type="danger" @click="deleteProject(scope.row)">
                            Delete
                        </el-button>
                    </template>
                </el-table-column>
            </el-table>
        </div>
    </div>
</template>

<script>
import ProjectCreateComponent from "../../components/projects/ProjectCreateComponent";
import config from "../../config";

export default {
    name: 'Projects',
    components: {
      ProjectCreateComponent
    },
    data() {
        return {
            loading: true,
            path: config.path
        }
    },
    computed: {
        projects() {
            return this.$store.getters['project/getProjects'];
        }
    },
    mounted() {
        this.search();
    },
    methods: {
        search() {
            this.loading = true;

            this.$store.dispatch('project/loadProjects')
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
            console.log(project);
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
            })
        }
    }
}
</script>