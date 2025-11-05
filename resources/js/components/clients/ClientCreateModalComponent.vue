<template>
    <div>
        <el-button class="btn btn-primary" type="primary" @click="dialogFormVisible = true">Add Client</el-button>

        <el-dialog title="Add client" :visible.sync="dialogFormVisible" width="450px">
            <el-form :model="client">
                <el-form-item label="Name">
                    <el-input v-model="client.name"></el-input>
                </el-form-item>
                <el-form-item label="Email">
                    <el-input v-model="client.email"></el-input>
                </el-form-item>
                <el-form-item label="Password">
                    <el-input v-model="client.password"></el-input>
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
    name: 'ClientCreateModalComponent',
    data() {
        return {
            dialogFormVisible: false,
            client: {
                name: '',
                email: '',
                password: ''
            }
        }
    },
    methods: {
        create() {
            this.$store.dispatch('client/createClient', this.client)
                .then(() => {
                    this.$notify({
                        title: 'Success',
                        type: 'success',
                        message: `The ${this.client.name} successfully created!`
                    });

                    this.$store.dispatch('client/searchClients');
                    this.dialogFormVisible = false;
                    this.resetForm();
                })
                .catch(() => {});
        },
        resetForm(){
            this.client.name = '';
            this.client.email = '';
            this.client.password = '';
        }
    }
}
</script>

<style scoped lang="scss">

</style>
