<template>
    <el-container>
        <el-aside>
            <sidebar></sidebar>
        </el-aside>
        <el-container>
            <router-view />
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
