<template>
    <div class="view-content">
        <div class="ds-block bg-light view-title">
            <h1>Update user</h1>
        </div>

        <div class="ds-block bg-light">
            <el-form :model="user">
                <el-form-item label="Name">
                    <el-input v-model="user.name"></el-input>
                </el-form-item>
                <el-form-item label="Email">
                    <el-input v-model="user.email"></el-input>
                </el-form-item>
                <el-form-item label="Role">
                    <el-select v-model="user.role_id" placeholder="Select">
                        <el-option
                            v-for="item in this.roles"
                            :key="item.id"
                            :label="item.name"
                            :value="item.id">
                        </el-option>
                    </el-select>
                </el-form-item>
            </el-form>

            <el-button class="btn btn-primary" type="primary" @click="update()">Update</el-button>
        </div>
    </div>
</template>

<script>
export default {
    name: 'UserUpdateView',
    data() {
        return {
            dialogFormVisible: false,
        }
    },
    computed: {
        user() {
            return this.$store.getters['user/getUser'];
        },
        roles() {
            return this.$store.getters['user/getRoles'];
        }
    },
    mounted() {
        this.$store.dispatch('user/loadUser', this.$route.params.id);
        this.$store.dispatch('user/getRoles');
    },
    methods: {
        update(id, user) {
            this.$store.dispatch('user/updateUser', {id: this.user.id, user: this.user})
                .then(() => {
                    this.$notify({
                        title: 'Success',
                        type: 'success',
                        message: `The ${this.user.name} successfully updated!`
                    });

                    this.dialogFormVisible = false;
                }).catch((e) => {
                this.$notify.error({
                    title: 'Error',
                    message: e
                });
            });
        }
    }
}
</script>
