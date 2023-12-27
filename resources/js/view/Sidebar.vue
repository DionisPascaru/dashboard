<template>
    <div class="sidebar">
        <el-menu
            :default-active="activeIndex"
            class="el-menu-vertical-demo"
            background-color="transparent"
            text-color="#fff"
            active-text-color="#ffd04b"
            :router="true">
            <el-menu-item index="ExampleComponent" :route="{ name: 'ExampleComponent' }">
                <span>Example</span>
            </el-menu-item>
            <el-menu-item index="Users" :route="{ name: 'Users' }">
                <span>Users</span>
            </el-menu-item>
            <el-menu-item index="Projects" :route="{ name: 'Projects' }">
                <span>Projects</span>
            </el-menu-item>
        </el-menu>
        <div>
            <el-button @click="logout">
                Logout
            </el-button>
        </div>
    </div>
</template>
<script>
export default {
    name: "Sidebar",
    computed: {
        activeIndex() {
            return this.$route.name;
        },
        authUser() {
            return this.$store.getters['auth/loadUser'];
        }
    },
    mounted() {
        this.$store.dispatch('auth/authUser');
    },
    methods: {
        logout() {
            this.$store.dispatch('auth/logout').then(() => {
                this.$router.push({name: 'Home'});
            })
        },
    }
};
</script>

<style lang="scss" scoped>
.sidebar {
    background-color: #545c64;
    height: calc(100vh - 40px);
    min-height: 500px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: 20px;

    .el-menu-vertical-demo {
        border-right: 0;
    }
}
</style>
