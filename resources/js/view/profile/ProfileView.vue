<template>
    <div>
        <div class="view-title">
            <h1>Profile info</h1>
        </div>

        <div class="ds-block bg-light">
            <el-row>
                <el-col :md="12">
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
                </el-col>
            </el-row>
        </div>
    </div>
</template>

<script>
export default {
    name: "ProfileView",
    computed: {
        user() {
            return this.$store.getters['auth/loadUser'];
        },
        roles() {
            return this.$store.getters['user/getRoles'];
        }
    },
    mounted() {
        this.$store.dispatch('auth/authUser');
        this.$store.dispatch('user/getRoles');
    },
}
</script>
