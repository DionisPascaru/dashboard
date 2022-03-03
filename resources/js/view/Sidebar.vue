<template>
    <div>
        <el-menu
            default-active="2"
            class="el-menu-vertical-demo"
            background-color="#545c64"
            text-color="#fff"
            active-text-color="#ffd04b"
            :router="true"
        >
            <el-menu-item index="1" :route="{ name: 'ExampleComponent' }">
                <span>Example</span>
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
    methods: {
        logout() {
            this.$store.dispatch('auth/logout').then(() => {
                this.$router.push({name: 'Home'});
            })
        }
    }
};
</script>
