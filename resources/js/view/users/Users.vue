<template>
    <div>
        <div class="view-title">
            <h1>Users</h1>
        </div>
        <div class="view-content">
            <el-table
                class="table"
                :data="users"
                v-loading="loading"
                style="width: 100%">
                <el-table-column
                    prop="name"
                    label="Name"
                    width="180">
                </el-table-column>
                <el-table-column
                    prop="email"
                    label="Email">
                </el-table-column>
                <el-table-column
                    prop="role"
                    label="Role"
                    width="180">
                </el-table-column>
                <el-table-column
                    label="Actions"
                    width="180">
                    <template slot-scope="scope">
                        <div class="d-flex">
                            <router-link :to="{ name: 'UserDetails', params: { id: scope.row.id }}">
                                <el-button type="primary">
                                    View
                                </el-button>
                            </router-link>
                            <el-button type="danger" @click="deleteUser(scope.row)">
                                Delete
                            </el-button>
                        </div>
                    </template>
                </el-table-column>
            </el-table>
        </div>

    </div>
</template>

<script>
export default {
    name: 'Users',
    data() {
        return {
            loading: true
        }
    },
    computed: {
        users() {
            return this.$store.getters['user/getUsers'];
        }
    },
    mounted() {
        this.search();
    },
    methods: {
        search() {
            this.loading = true;

            this.$store.dispatch('user/loadUsers')
                .then(() => {})
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
        deleteUser(user) {
            this.$confirm(
                `Are you sure you want to delete user ${user.name}?`,
                {
                    title: 'Delete user',
                    confirmButtonText: "OK",
                    cancelButtonText: "Cancel",
                    type: "warning"
                }
            )
                .then(() => {
                    this.$store.dispatch('user/deleteUser', user.id)
                        .then(() => {
                            this.$notify({
                                title: 'Success',
                                type: 'success',
                                message: `The ${user.name} successfully deleted!`
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

<style lang="scss" scoped>
.d-flex {
    display: flex;
}
</style>
