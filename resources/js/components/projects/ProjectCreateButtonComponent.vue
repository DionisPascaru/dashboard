<template>
    <router-link :to="{ name: 'ProjectCreateView'}">
        <el-button class="btn btn-primary" type="primary">Add project</el-button>
    </router-link>
</template>

<script>
export default {
    name: 'ProjectCreateButtonComponent'
}
</script>
