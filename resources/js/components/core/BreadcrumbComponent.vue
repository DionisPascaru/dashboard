<template>
    <el-breadcrumb separator="/" style="margin: 20px auto">
        <el-breadcrumb-item>
            <router-link :to="{name: 'Dashboard'}">
                 Dashboard
            </router-link>
        </el-breadcrumb-item>
        <el-breadcrumb-item
            v-for="(breadcrumb, index) in breadcrumbs"
            :key="index">
            <router-link v-if="breadcrumb.name" :to="{name: breadcrumb.name}">
                {{ breadcrumb.text }}
            </router-link>
            <span v-if="!breadcrumb.name">{{ breadcrumb.text }}</span>
        </el-breadcrumb-item>
    </el-breadcrumb>
</template>

<script>
export default {
    name: 'BreadcrumbComponent',
    computed: {
        breadcrumbs() {
            return this.$route.meta.breadcrumbs;
        }
    }
}
</script>
