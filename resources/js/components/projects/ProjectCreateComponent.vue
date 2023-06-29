<template>
    <div>
        <div class="view-title">
            <h1>Create project page</h1>
        </div>

        <el-form :model="project" :rules="rules" ref="createProjectForm">
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
                        <el-upload
                            action="#"
                            ref="uploadCover"
                            list-type="picture-card"
                            :limit="1"
                            :auto-upload="false"
                            :on-change="handleCoverUpload"
                            :on-remove="onCoverRemoved">
                            <i class="el-icon-plus"></i>
                        </el-upload>
                    </el-form-item>
                    <el-form-item label="Images">
                        <el-upload
                            action="#"
                            ref="uploadImages"
                            list-type="picture-card"
                            :multiple="true"
                            :auto-upload="false"
                            :on-change="handleImagesUpload"
                            :on-remove="onImagesRemoved">
                            <i class="el-icon-plus"></i>
                        </el-upload>
                    </el-form-item>
                </el-col>
            </el-row>
        </el-form>
        <span slot="footer" class="dialog-footer">
            <el-button @click="resetForm">Reset</el-button>
            <el-button type="primary" @click="create('createProjectForm')">Create</el-button>
        </span>
    </div>
</template>

<script>
export default {
    name: 'ProjectCreateComponent',
    data() {
        return {
            project: {
                title: '',
                cover: '',
                images: [],
                category_id: ''
            },
            rules: {
                title: [
                    {
                        required: true,
                        message: "Title is required",
                        trigger: ["blur", "change"],
                    },
                ],
                cover: [
                    {
                        required: true,
                        message: "Cover is required",
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
      projectCategories() {
          return this.$store.getters['projectCategories/getProjectCategories'];
      }
    },
    mounted() {
        this.$store.dispatch('projectCategories/loadProjectCategories');
    },
    methods: {
        handleCoverUpload(file) {
            this.project.cover = file;
        },
        handleImagesUpload(file) {
            this.project.images.push(file);
        },
        onCoverRemoved(){
            this.project.cover = '';
        },
        onImagesRemoved(file) {
            const index = this.project.images.findIndex(item => item.uid === file.uid);

            if (index !== -1) {
                this.project.images.splice(index, 1);
            }
        },
        create(formName) {
            this.$refs[formName].validate((valid) => {
                if (valid) {
                    const input = this.processProject();

                    this.$store.dispatch('project/createProject', input)
                        .then(() => {
                            this.$notify({
                                title: 'Success',
                                type: 'success',
                                message: `The ${this.project.title} successfully created!`
                            });

                            this.resetForm();
                        })
                        .catch((e) => {
                            this.$notify.error({
                                title: 'Error',
                                message: e
                            });
                        });
                }
            })
        },
        processProject() {
            const formData = new FormData();
            formData.append('title', this.project.title);
            formData.append('category_id', this.project.category_id);

            if (this.project.cover) {
                formData.append('cover', this.project.cover.raw, this.project.cover.name);
            }

            if (this.project.images) {
                this.project.images.forEach(image => {
                    formData.append('images[]', image.raw, image.name);
                });
            }

            return formData;
        },
        resetForm() {
            this.project.title = '';
            this.project.cover = '';
            this.project.category_id = '';
            this.project.images = [];

            this.$refs.uploadCover.clearFiles();
            this.$refs.uploadImages.clearFiles();
        },
    }
}
</script>

<style>
.el-form-item {
    display: flex;
    flex-direction: column;
    width: 100%;
}

.el-form-item__label {
    text-align: left;
}
</style>
