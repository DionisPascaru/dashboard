<template>
    <div>
        <el-button type="primary" @click="dialogFormVisible = true">Add Project</el-button>

        <el-dialog title="Add user" :visible.sync="dialogFormVisible" width="450px">
            <el-form :model="project">
                <el-form-item label="Title">
                    <el-input v-model="project.title"></el-input>
                </el-form-item>
                <el-form-item label="Cover">
                    <el-upload
                        action="#"
                        :auto-upload="false"
                        list-type="picture-card"
                        :on-change="handleUpload">
                        <i class="el-icon-plus"></i>
                    </el-upload>
                    <el-dialog :visible.sync="dialogVisible">
                        <img width="100%" :src="dialogImageUrl" alt="">
                    </el-dialog>
                </el-form-item>
                <el-form-item label="Video">
                    <el-input v-model="project.video"></el-input>
                </el-form-item>
                <el-form-item label="Category">
                    <el-input v-model="project.category_id"></el-input>
                </el-form-item>
            </el-form>
            <span slot="footer" class="dialog-footer">
                <el-button @click="dialogFormVisible = false">Cancel</el-button>
                <el-button type="primary" @click="create">Create</el-button>
              </span>
        </el-dialog>
    </div>
</template>

<script>
export default {
    name: 'ProjectCreateComponent',
    data() {
        return {
            dialogFormVisible: false,
            project: {
                title: '',
                video: '',
                category_id: ''
            },
            dialogImageUrl: '',
            dialogVisible: false
        }
    },
    methods: {
        handleUpload(file) {
            this.project.cover = file;
        },
        create() {
            const formData = new FormData();
            formData.append('title', this.project.title);
            formData.append('cover', this.project.cover.raw, this.project.cover.name);
            formData.append('video', this.project.video);
            formData.append('category_id', this.project.category_id);

            this.$store.dispatch('project/createProject', formData)
                .then(() => {
                    this.$notify({
                        title: 'Success',
                        type: 'success',
                        message: `The ${this.project.title} successfully created!`
                    });

                    this.dialogFormVisible = false;
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
            this.project.video = '';
            this.project.category_id = '';
        },
    }
}
</script>
