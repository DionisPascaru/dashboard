<template>
    <div>
        <el-button class="btn btn-primary" type="primary" @click="dialogFormVisible = true">Add Category</el-button>
        <el-dialog title="Add category" :visible.sync="dialogFormVisible" width="450px">
            <el-form :model="category">
                <el-form-item label="Name">
                    <el-input v-model="category.name"></el-input>
                </el-form-item>
            </el-form>
            <span slot="footer" class="dialog-footer">
                <el-button @click="dialogFormVisible = false">Cancel</el-button>
                <el-button class="btn btn-primary" type="primary" @click="create">Create</el-button>
            </span>
        </el-dialog>
    </div>
</template>

<script>

export default {
    name: 'ProjectCategoryCreateComponent',
    data() {
        return {
            dialogFormVisible: false,
            category: {
                name: ''
            }
        }
    },
    methods: {
        create() {
            this.$store.dispatch('projectCategories/createProjectCategory', this.category)
                .then(() => {
                    this.$notify({
                        title: 'Success',
                        type: 'success',
                        message: `The ${this.category.name} successfully created!`
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
            this.category.name = '';
        }
    }
}

</script>

<style scoped lang="scss">

</style>
