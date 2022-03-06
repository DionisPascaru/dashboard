<template>
    <el-container>
        <el-aside>
            <sidebar></sidebar>
        </el-aside>
        <el-container>
            <div class="view-content">
                <router-view />
            </div>
        </el-container>
    </el-container>
</template>

<script>
import Sidebar from './Sidebar.vue';

export default {
  components: { Sidebar },
    name: 'Dashboard',
    component: {
        Sidebar
    }
}
</script>

<style lang="scss" scoped>
.view-content {
    width: calc(100% - 40px);
    padding: 20px;
}
</style>
