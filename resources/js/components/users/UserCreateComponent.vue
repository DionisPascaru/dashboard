<template>
    <div>
        <el-button type="primary" @click="dialogFormVisible = true">Add User</el-button>

        <el-dialog title="Add user" :visible.sync="dialogFormVisible" width="450px">
            <el-form :model="user">
                <el-form-item label="Name">
                    <el-input v-model="user.name"></el-input>
                </el-form-item>
                <el-form-item label="Email">
                    <el-input v-model="user.email"></el-input>
                </el-form-item>
                <el-form-item label="Password">
                    <el-input v-model="user.password"></el-input>
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
    name: 'UserCreateComponent',
    data() {
        return {
            dialogFormVisible: false,
            user: {
                name: '',
                email: '',
                password: ''
            }
        }
    },
    methods: {
        create() {
            this.$store.dispatch('user/createUser', this.user)
                .then(() => {
                    this.$notify({
                        title: 'Success',
                        type: 'success',
                        message: `The ${this.user.name} successfully created!`
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
        resetForm(){
            this.user.name = '';
            this.user.email = '';
            this.user.password = '';
        }
    }
}
</script>
