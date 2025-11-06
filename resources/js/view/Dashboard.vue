<template>
    <el-container>
        <el-aside>
            <sidebar></sidebar>
        </el-aside>
        <div class="view-container">
            <div class="ds-block bg-light view-heading">
                <div class="view-title">
                    <h1>{{ viewTitle }}</h1>
                </div>
                <div class="ds-page-options">
                    <div class="ds-page-option" v-for="option in pageOptions">
                        <component :is="option"></component>
                    </div>
                </div>
            </div>
            <breadcrumb-component></breadcrumb-component>
            <router-view />
        </div>
    </el-container>
</template>

<script>
import Sidebar from './Sidebar.vue';
import ClientCreateModalComponent from "../components/clients/ClientCreateModalComponent.vue";
import BreadcrumbComponent from "../components/core/BreadcrumbComponent.vue";

export default {
  components: {BreadcrumbComponent, ClientCreateModalComponent, Sidebar },
    name: 'Dashboard',
    component: {
        Sidebar
    },
    computed: {
        viewTitle() {
            return this.$route.meta.viewTitle || 'Untitled';
        },
        pageOptions() {
            return this.$route.meta.pageOptions;
        }
    },
}
</script>

<style lang="scss" scoped>

</style>
