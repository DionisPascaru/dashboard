<template>
    <div>
        <div class="view-title">
            <h1>Update project</h1>
        </div>

        <div class="ds-block bg-light">
            <el-form :model="project" :rules="rules" ref="updateProjectForm">
                <el-row :gutter="20">
                    <el-col :span="12">
                        <el-form-item label="Title" prop="title">
                            <el-input v-model="project.title"></el-input>
                        </el-form-item>
                        <el-form-item label="Category" prop="category_id">
                            <el-select v-model="project.category_id" placeholder="Select">
                                <el-option
                                    v-for="item in this.projectCategories"
                                    :key="item.id"
                                    :label="item.name"
                                    :value="item.id">
                                </el-option>
                            </el-select>
                        </el-form-item>
                        <el-form-item label="Cover" prop="cover">
                            <file-upload-component :file.sync="this.file"
                                                   @upload-callback="updateFile">
                            </file-upload-component>
                        </el-form-item>
                        <el-form-item label="Images">
                            <multiple-files-upload-component :files.sync="this.files"
                                                             @upload-callback="updateFiles"
                                                             @remove-callback="removeFiles">
                            </multiple-files-upload-component>
                        </el-form-item>
                    </el-col>
                </el-row>
            </el-form>

            <el-button class="btn btn-primary" type="primary" @click="update('updateProjectForm')">Update</el-button>
        </div>
    </div>
</template>

<script>
import FileUploadComponent from "../../components/core/FileUploadComponent.vue";
import MultipleFilesUploadComponent from "../../components/core/MultipleFilesUploadComponent.vue";

export default {
    name: 'ProjectUpdateView',
    components: {
        FileUploadComponent,
        MultipleFilesUploadComponent,
    },
    data() {
        return {
            dialogImageUrl: '',
            dialogVisible: false,
            disabled: false,
            file: {},
            files: [],
            rules: {
                title: [
                    {
                        required: true,
                        message: "Title is required",
                        trigger: ["blur", "change"],
                    },
                ],
                category_id: [
                    {
                        required: true,
                        message: "Category is required",
                        trigger: ["blur", "change"],
                    },
                ]
            },
        }
    },
    computed: {
        project() {
            return this.$store.getters['project/getProject'];
        },
        projectCategories() {
            return this.$store.getters['projectCategories/getProjectCategories'];
        }
    },
    mounted() {
        this.$store.dispatch('project/loadProject', this.$route.params.id).then(() => {
            this.file = this.project.cover;

            this.files = this.project.images;
        });

        this.$store.dispatch('projectCategories/loadProjectCategories');
    },
    methods: {
        update(formName) {
            this.$refs[formName].validate((valid) => {
                if (valid) {
                    this.$store.dispatch('project/updateProject', {id: this.project.id, project: this.project})
                        .then(() => {
                            this.$notify({
                                title: 'Success',
                                type: 'success',
                                message: `The ${this.project.title} successfully updated!`
                            });

                            this.$router.push({name: 'Projects'});
                        })
                        .catch((e) => {
                            this.$notify.error({
                                title: 'Error',
                                message: e
                            });
                        });
                }
            });
        },
        updateFile(file) {
            this.file = file;

            const formData = new FormData();
            formData.append('id', this.project.id);
            formData.append('cover', this.file.raw ?? '');

            this.$store.dispatch('project/fileUpload', {id: this.project.id, payload: formData})
                .then(() => {
                    this.$notify({
                        title: 'Success',
                        type: 'success',
                        message: `The File successfully updated!`
                    });
                })
                .catch((e) => {
                    this.$notify.error({
                        title: 'Error',
                        message: e
                    });
                });
        },
        updateFiles(file) {
            const formData = new FormData();
            formData.append('image', file.raw ?? '');

            this.$store.dispatch('project/imageUpload', {id: this.project.id, payload: formData})
                .then(() => {
                    this.$notify({
                        title: 'Success',
                        type: 'success',
                        message: `The Image successfully updated!`
                    });
                })
                .catch((e) => {
                    this.$notify.error({
                        title: 'Error',
                        message: e
                    });
                });
        },
        removeFiles(file) {
            const imageId = file.id;

            this.$store.dispatch('project/imageRemove', imageId)
                .then(() => {
                    this.$notify({
                        title: 'Success',
                        type: 'success',
                        message: `The Image successfully removed!`
                    });
                })
                .catch((e) => {
                    this.$notify.error({
                        title: 'Error',
                        message: e
                    });
                })
        }
    }
}
</script>
