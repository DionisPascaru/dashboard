<template>
    <div>
        <div class="view-title">
            <h1>Create project page</h1>
        </div>

        <el-form :model="project">
            <el-row :gutter="20">
                <el-col :span="12">
                    <el-form-item label="Title">
                        <el-input v-model="project.title"></el-input>
                    </el-form-item>
                    <el-form-item label="Category">
                        <el-input v-model="project.category_id"></el-input>
                    </el-form-item>
                    <el-form-item label="Cover">
                        <el-upload
                            action="#"
                            list-type="picture-card"
                            :limit="1"
                            :auto-upload="false"
                            :on-change="handleUpload">
                            <i class="el-icon-plus"></i>
                        </el-upload>
                    </el-form-item>
                    <el-form-item label="Images">
                        <el-upload
                            action="#"
                            list-type="picture-card"
                            :multiple="true"
                            :auto-upload="false"
                            :on-change="handleImagesUpload">
                            <i class="el-icon-plus"></i>
                        </el-upload>
                    </el-form-item>
                </el-col>
            </el-row>
        </el-form>
        <span slot="footer" class="dialog-footer">
            <el-button @click="resetForm">Reset</el-button>
            <el-button type="primary" @click="create">Create</el-button>
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
        }
    },
    methods: {
        handleUpload(file) {
            this.project.cover = file;
        },
        handleImagesUpload(file) {
            this.project.images.push(file);
        },
        create() {
            const formData = new FormData();
            formData.append('title', this.project.title);
            formData.append('cover', this.project.cover.raw, this.project.cover.name);
            formData.append('category_id', this.project.category_id);

            this.project.images.forEach(image => {
               formData.append('images[]', image.raw, image.name);
            });

            this.$store.dispatch('project/createProject', formData)
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
        },
        resetForm() {
            this.project.title = '';
            this.project.cover = '';
            this.project.category_id = '';
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
