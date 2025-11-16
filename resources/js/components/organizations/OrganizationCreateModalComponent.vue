<template>
    <div>
        <el-button class="btn btn-primary" type="primary" @click="dialogFormVisible = true">Add organization</el-button>

        <el-dialog title="Add organization" :visible.sync="dialogFormVisible" width="450px">
            <el-form :model="organization">
                <el-form-item label="Name">
                    <el-input v-model="organization.name"></el-input>
                </el-form-item>
                <el-form-item label="Email">
                    <el-input v-model="organization.email"></el-input>
                </el-form-item>
                <el-form-item label="Phone">
                    <el-input v-model="organization.phone"></el-input>
                </el-form-item>
                <el-form-item label="Address">
                    <el-input v-model="organization.address"></el-input>
                </el-form-item>
                <el-form-item label="Description">
                    <el-input
                        type="textarea"
                        :rows="2"
                        placeholder="Please input"
                        v-model="organization.description">
                    </el-input>
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
    name: 'OrganizationCreateModalComponent',
    data() {
        return {
            clientId: this.$route.params.id,
            dialogFormVisible: false,
            organization: {
                name: '',
                owner: null,
                email: '',
                phone: '',
                address: '',
                description: '',
                logo: '',
            }
        }
    },
    methods: {
        create() {
            this.organization.owner = parseInt(this.clientId);

            this.$store.dispatch('organization/createOrganization', this.organization)
                .then(() => {
                    this.$notify({
                        title: 'Success',
                        type: 'success',
                        message: `The ${this.organization.name} successfully created!`
                    });

                    this.$store.dispatch('client/readOwnedOrganizations', this.clientId);
                    this.dialogFormVisible = false;
                    this.resetForm();
                })
                .catch(() => {});
        },
        resetForm(){
            this.organization.name = '';
            this.organization.email = '';
            this.organization.phone = '';
            this.organization.address = '';
            this.organization.logo = '';
            this.organization.description = '';
        }
    }
}
</script>
<style scoped lang="scss">

</style>
