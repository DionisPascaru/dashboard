<template>
    <el-container>
        <el-aside>
            <sidebar></sidebar>
        </el-aside>
        <el-container class="view-container">
            <router-view />
        </el-container>
    </el-container>
</template>

<script>
import Sidebar from './Sidebar.vue';3

export default {
  components: { Sidebar },
    name: 'Dashboard',
    component: {
        Sidebar
    }
}
</script>

<style lang="scss" scoped>
.view-container {
    margin-left: 300px;
}
</style>
